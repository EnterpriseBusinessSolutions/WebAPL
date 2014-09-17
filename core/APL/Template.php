<?php

/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

use View;

class Template {

    protected static $template = 'Default';
    protected static $module = null;
    protected static $view_mods = array(
        'page' => array(
            'posturi_vacante' => array(
                'name' => 'Lista de posturi vacante',
                'function' => array('PageView', 'posturiVacante')
            ),
            'promisiuni_primar' => array(
                'name' => 'Lista de promisiuni a primarului (feed based)',
                'function' => array('PageView', 'promisesMod')
            ),
            'locations_list' => array(
                'name' => 'Lista cu locatii (cultura)',
                'function' => array('PageView', 'locationsList')
            ),
            'accordion_list' => array(
                'name' => 'Lista acordion (faq)',
                'function' => array('PageView', 'accordionList')
            ),
            'town_list' => array(
                'name' => 'Lista primarii (orase)',
                'function' => array('PageView', 'townList')
            ),
            'tablePosts' => array(
                'name' => 'Posturi ca tabel (autorizatii)',
                'function' => array('PageView', 'tablePosts')
            ),
            'urgentNumbers' => array(
                'name' => 'Numere de urgenta (urgenta)',
                'function' => array('PageView', 'urgentNumbers')
            ),
            'acticles' => array(
                'name' => 'Lista articole',
                'function' => array('PageView', 'articleList')
            ),
            'externLinks' => array(
                'name' => 'Linkuri externe',
                'function' => array('PageView', 'externLinks')
            ),
            'fileFolders' => array(
                'name' => 'Dosare cu fisiere',
                'function' => array('PageView', 'fileFolders')
            ),
            'acquisitionsList' => array(
                'name' => 'Lista de achizitii',
                'function' => array('PageView', 'acquisitionsList')
            ),
            'projectsList' => array(
                'name' => 'Lista de proiecte',
                'function' => array('PageView', 'projectsList')
            ),
            'videoList' => array(
                'name' => 'Lista cu video',
                'function' => array('PageView', 'videoList')
            ),
            'adsList' => array(
                'name' => 'Anunturi',
                'function' => array('PageView', 'adsList')
             ),
            'newsList' => array(
                'name' => 'Stiri',
                'function' => array('PageView', 'newsList')
            ),
            'contactsView' => array(
                'name' => 'Contacte',
                'function' => array('PageView', 'contactsView')
            ),
            'meetingPast' => array(
                'name' => 'Sedinte trecute',
                'function' => array('PageView', 'meetingPast')
            ),
            'meetingFuture' => array(
                'name' => 'Sedinta viitoare',
                'function' => array('PageView', 'meetingFuture')
            ),
            'mapPage' => array(
                'name' => 'Harta',
                'function' => array('PageView', 'mapPage')
            )
        )
    );
    protected static $page_title = '';
    protected static $breadcrumbs = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        
    }

    /**
     * Get current template name
     * @return string
     */
    public static function getCurrent() {
        return self::$template;
    }

    /**
     * 
     * @param array $paths
     * @return string
     */
    public static function preparePaths($paths = array()) {
        $paths = (array) $paths;

        if (isset(self::$module) && self::$module) {
            $paths = array(
                app_path() . '/modules/' . self::$module . '/'
            );
        } else {
            foreach ($paths as &$path) {
                $path = $path . '/' . self::$template . '/';
            }
        }
        return $paths;
    }

    /**
     * Set template
     * @param string $template
     */
    public static function setTemplate($template) {
        self::$template = $template;
    }

    /**
     * 
     * @param string $path
     * @return string
     */
    public static function path($path = '') {
        return "/apps/" . APP_FOLDER . "/views/templates/" . self::$template . "/" . $path;
    }

    /**
     * Load view from module folder
     * @param string $module
     * @param string $view
     * @param mixed $data
     * @return View
     */
    public static function moduleView($module, $view, $data = array()) {
        self::$module = $module;
        $data = View::make($view, $data);
        self::$module = null;
        return $data;
    }

    /**
     * Get main layout
     * @return type
     */
    public static function mainLayout() {
        return View::make('layout.main');
    }

    /**
     * 
     * 
     * 
     *   VIEW METHODS
     *   functions like Actions component
     * 
     * 
     * 
     */

    /**
     * Register new method
     * @param string $section
     * @param string $tag
     * @param string $name
     * @param mixed $function
     * @param boolean $override
     * @throws Exception
     */
    public static function registerViewMethod($section, $tag, $name, $function, $override = false) {
        if (self::checkViewMethod($section, $tag) && !$override) {
            throw new Exception("Override view method '{$tag}' from '{$section}'");
        } else {
            self::$view_mods[$section][$tag] = array(
                'name' => $name,
                'function' => $function
            );
        }
    }

    /**
     * delete view method
     * @param string $fromSection
     * @param string $tag
     */
    public static function dropViewMethod($fromSection, $tag) {
        unset(self::$view_mods[$fromSection][$tag]);
    }

    /**
     * Verify if exist view method
     * @param string $section
     * @param string $tag
     * @return boolean
     */
    public static function checkViewMethod($section, $tag) {
        return isset(self::$view_mods[$section][$tag]) && $tag && $section;
    }

    /**
     * Call view Method
     * @param string $section
     * @param string $tag
     * @param string $parameters
     * @return mixed
     * @throws Exception
     */
    public static function callViewMethod($section, $tag, $parameters = array()) {
        if (self::checkViewMethod($section, $tag)) {
            return call_user_func_array(self::$view_mods[$section][$tag]['function'], $parameters);
        } else {
            throw new Exception("Undefined view method '{$tag}' in '{$section}'");
        }
    }

    /**
     * get list of section methods
     * @param string $section
     * @return array
     */
    public static function getViewMethodList($section) {
        if (isset(self::$view_mods[$section])) {
            return self::$view_mods[$section];
        } else {
            return array();
        }
    }

    /**
     * 
     * 
     *   END VIEW METHODS
     * 
     * 
     */

    /**
     * 
     *   Breadcrumb
     * 
     */
    public static function addBreadCrumb($url, $name) {
        self::$breadcrumbs[] = array(
            'name' => $name,
            'url' => $url
        );
    }

    public static function getBreadCrumbs() {
        return self::$breadcrumbs;
    }

    public static function setPageTitle($title, $override = false) {
        if (static::$page_title) {
            if ($override) {
                static::$page_title = $title;
            }
        } else {
            static::$page_title = $title;
        }
    }
    
    public static function getPageTitle() {
        return static::$page_title;
    }

}
