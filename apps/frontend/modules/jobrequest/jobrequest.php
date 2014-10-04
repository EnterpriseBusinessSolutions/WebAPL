<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Core\APL\Shortcodes,
    Input,
    Validator,
    JobRequestModel;

class Jobrequest extends \Core\APL\ExtensionController {

    protected $module_name = 'jobrequest';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('JobRequestModel'));

        Shortcodes::register('cv_form', array($this, 'cv_form'));
        Actions::register('cv_form', array($this, 'cv_form'));
        Actions::post('job/apply', array($this, 'cv_form_submit'));
    }

    public function cv_form($attr) {
        if (isset($attr['post']) && (strtotime($attr['post']->date_point) == 0 || strtotime($attr['post']->date_point) > time())) {
            return Template::moduleView($this->module_name, 'views.job-form', array('post_id' => $attr['post']['id']));
        }
    }

    public function cv_form_submit() {
        $validator = Validator::make(array(
                    'post_id' => Input::get('post_id'),
                    'name' => Input::get('name'),
                    'upload' => Input::file('upload'),
                        ), array(
                    'post_id' => 'required',
                    'name' => 'required',
                    'upload' => 'required',
        ));
        
        $return = array(
            'message' => '',
            'error' => 0
        );
        
        if ($validator->fails()) {
            $return['message'] = implode('<br>', $validator->messages()->all(':message'));
            $return['error'] = 1;
        } else {
            $post_id = Input::get('post_id');

            $name =  Input::get('name');
            
            $filename = 'cv_' . $post_id . '_' . date("Y-m-d") . '_' . uniqid() . '.pdf';
            $filepath = "/upload/cv/" ;

            $audience = new JobRequestModel;
            $audience->post_id = $post_id;
            $audience->name = $name;
            $audience->save();

            $attachFile = false;
            
            if (Input::file('upload')->isValid()) {
                $audience->cv_path = $filepath . $filename;
                $audience->save();
                $attachFile = $filepath . $filename;
                Input::file('upload')->move($_SERVER['DOCUMENT_ROOT'] . $filepath, $filename);
            } else {
                $return['message'] = 'Invalid file';
                $return['error'] = 1;
            }
            
            Template::viewModule($this->module_name, function () use ($name, $attachFile) {
                $sendToUsers = \User::withRole('user-getemails');
                
                $data['name'] = $name;
                foreach ($sendToUsers as $user) {
                    $data['user'] = $user;
                    \Mail::send('views.email-request', $data, function($message) use ($user, $attachFile) {
                        $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'SendMail');
                        $message->subject("New job reqest");
                        $message->to($user->email);
                        if ($attachFile) {
                            $message->attach($_SERVER['DOCUMENT_ROOT'] . $attachFile);
                        }
                    });
                }
            });
        }

        return $return;
    }

}
