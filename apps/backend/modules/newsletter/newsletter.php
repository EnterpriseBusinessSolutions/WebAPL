<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Input,
    NewsletterModel,
    jQgrid,
    Mail;

class Newsletter extends \Core\APL\ExtensionController {

    protected $module_name = 'newsletter';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('NewsletterModel'));

        Actions::get('newsletter/settings', array('before' => 'auth', array($this, 'settings')));
        Actions::get('newsletter/list', array('before' => 'auth', array($this, 'email_list')));
        Actions::post('newsletter/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::post('newsletter/edititem', array('before' => 'auth', array($this, 'edititem')));
        Actions::get('newsletter/send', array('before' => 'auth', array($this, 'send_message')));
        Actions::post('newsletter/sendarticle', array('before' => 'auth', array($this, 'sendarticle')));
        Actions::get('newsletter/export', array('before' => 'auth', array($this, 'getExport')));

        Actions::register('construct_left_menu', array($this, 'left_menu_item'));
        Actions::register('feed_post_bottom', array($this, 'sendemails'));

        $this->layout = Template::mainLayout();
    }

    public function settings() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.settings');

        return $this->layout;
    }

    public function left_menu_item() {
        if (\User::has('newsletter-view')) {
            echo Template::moduleView($this->module_name, 'views.newsletter-left-menu');
        }
    }

    public function email_list() {
        \User::onlyHas('newsletter-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function getlist() {
        \User::onlyHas('newsletter-view');

        $jqgrid = new jQgrid('apl_newsletter');
        echo $jqgrid->populate(function ($start, $limit) {
            return NewsletterModel::select('id', 'email', 'subscribe_date', 'enabled')->skip($start)->take($limit)->get();
        });
    }

    public function edititem() {
        \User::onlyHas('newsletter-view');

        $jqgrid = new jQgrid('apl_newsletter');
        $jqgrid->operation(array(
            'email' => Input::get('email'),
            'enabled' => Input::get('enabled')
        ));
    }

    public function send_message() {
        \User::onlyHas('newsletter-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function sendemails($post) {
        $data['post'] = $post;

        return Template::moduleView($this->module_name, 'views.send_email', $data);
    }

    public function sendarticle() {
        $post_id = Input::get('id');

        $post = \PostLang::where('post_id', $post_id)->first();
        if ($post) {

            $data['post'] = $post;
            $data['post_url'] = "http://kopceak1.sga.webhost1.ru/" . \Core\APL\Language::ext() . "/topost/" . $post_id;

            Template::viewModule($this->module_name, function () use ($data, $post) {
                $newsletterUsers = \NewsletterModel::where('enabled', 1)->get();

                foreach ($newsletterUsers as $user) {
                    $data['user'] = $user;
                    $data['unsubscribe_link'] = "http://kopceak1.sga.webhost1.ru/newsletter/unsubscribe/{$user->hash}";
                    Mail::send('views.emails.post', $data, function($message) use ($post, $user) {
                        $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'Newsletter');
                        $message->subject($post->title . " :: NEWSLETTER");
                        $message->to($user->email);
                    });
                }
            });
        }
    }

    public function getExport() {
        \User::onlyHas('newsletter-view');

        $buffer = "";

        $emails = NewsletterModel::all();

        foreach ($emails as $email) {
            $buffer .= "{$email->email}," . ($email->enabled ? 'activ' : 'inactiv') . ",\"{$email->subscribe_date}\"\n";
        }

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=NewsLetterExport.csv');
        echo "\xEF\xBB\xBF". $buffer;
        die;
    }

}
