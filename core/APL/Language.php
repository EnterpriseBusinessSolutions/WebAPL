<?php

/**
 *
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

use DB,
    Exception,
    Session,
    Input;

class Language {

    protected static $id = 1;
    protected static $list = array();
    protected static $language = null;

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        $list = DB::table('apl_lang')->get();
        foreach ($list as $lang) {
            self::$list[$lang->id] = $lang;
        }

        self::_init_language();
    }

    /**
     * Init current language
     * @throws Exception
     */
    private static function _init_language() {
        $lang = Input::get('lang');

        if (!$lang) {
            $lang = Session::get('lang');
        }

        $language = DB::table('apl_lang')->where('ext', $lang)->first();
        if (!$language) {
            $language = DB::table('apl_lang')->first();
        }

        if ($language) {
            self::$language = $language;
            self::$id = $language->id;
            Session::put('lang', self::ext());
        } else {
            throw new Exception("Available language not found");
        }
    }

    /**
     * Get laguages list
     * @return array
     */
    public static function getList() {
        return self::$list;
    }

    /**
     * Get current language id
     * @return int
     */
    public static function getId() {
        return self::$id;
    }

    /**
     * Get current language record
     * @param int $lang_id
     * @return lang record
     */
    public static function getItem($lang_id = 0) {
        $lang_id = $lang_id ? $lang_id : self::$id;

        if (isset(self::$list[$lang_id])) {
            return self::$list[$lang_id];
        } else {
            return false;
        }
    }

    /**
     * Get current language extension
     * @return string[2]
     */
    public static function ext() {
        if (isset(self::$language->ext)) {
            return self::$language->ext;
        } else {
            self::_init_language();
            return self::ext();
        }
    }

    /**
     * Get url with language extension
     * @param string $path
     * @return string
     */
    public static function url($path = '') {
        return url(self::ext() . '/' . $path);
    }

}