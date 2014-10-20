<?php

class HomeController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function postLangs() {
        User::onlyHas('lang-view');
        
        $jqgrid = new jQgrid('apl_lang');
        echo $jqgrid->populate(function ($start, $limit) {
            return DB::table('apl_lang')->get();
        });
        $this->layout = null;
    }

    public function postEditlang() {
        User::onlyHas('lang-view');
        
        $oper = Input::get('oper');
        $id = Input::get('id');

        $jqgrid = new jQgrid('apl_lang');
        $result = $jqgrid->operation(array(
            'name' => Input::get('name'),
            'ext' => Input::get('ext'),
            'enabled' => Input::get('enabled')
        ));

        $this->layout = null;

        if ($oper == 'add') {
            Event::fire('language_created', $result);
            
            Post::addLang($result);
            VarLangModel::addLang($result);
        }
        if ($oper == 'del') {
            Event::fire('language_deleted', $id);
            
            Post::removeLang($id);
            VarLangModel::removeLang($id);
        }

        Log::info("Lang operation {$oper} #{$id}");
    }

    public function showDashboard() {
//        
//        PostLang::where('title', '<>', '')->update(array(
//            'uri' => ''
//        ));
//        
//        $postlangs = PostLang::all();
//        foreach ($postlangs as $pl) {
//            $pl->uri = PostLang::uniqURI($pl->id, $pl->title);
//            $pl->save();
//        }

        $this->layout->content = View::make('hello');
    }

    public function getLanguages() {
        User::onlyHas('lang-view');
        
        $this->layout->content = View::make('sections.language.list');
    }

    public function showPage() {
        echo 'test backend';
    }
    
    public function getChangelang($ext) {
        Core\APL\Language::setLanguage($ext);

        return Redirect::back();
    }

}
