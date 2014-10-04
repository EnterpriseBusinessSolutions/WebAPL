<?php

/*
  |--------------------------------------------------------------------------
  | Register The Laravel Class Loader
  |--------------------------------------------------------------------------
  |
  | In addition to using Composer, you may use the Laravel class loader to
  | load your controllers and models. This is useful for keeping all of
  | your classes in the "global" namespace without Composer updating.
  |
 */

ClassLoader::addDirectories(array(
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
));

/*
  |--------------------------------------------------------------------------
  | Application Error Logger
  |--------------------------------------------------------------------------
  |
  | Here we will configure the error logger setup for the application which
  | is built on top of the wonderful Monolog library. By default we will
  | build a basic log file setup which creates a single file for logs.
  |
 */

Log::useFiles(storage_path() . '/logs/laravel.log');

/*
  |--------------------------------------------------------------------------
  | Application Error Handler
  |--------------------------------------------------------------------------
  |
  | Here you may handle any errors that occur in your application, including
  | logging them or displaying custom views for specific errors. You may
  | even register several error handlers to handle different types of
  | exceptions. If nothing is returned, the default error view is
  | shown, which includes a detailed stack trace during debug.
  |
 */

App::error(function(Exception $exception, $code) {
    Log::error($exception);

    /* $page_property = false;

      if ($code == 404) {
      $page_property = 'error_404';
      } elseif ($code >= 500) {
      //$page_property = 'error_500';
      } else {
      //$page_property = 'error_other';
      }

      if ($page_property) {
      $page = PostProperty::postWithProperty('error_404');
      if ($page) {
      $uri = Post::getFullURI($page->id, false);
      $contents = App::make('PageController')->route($uri);
      return Response::make($contents, $code);
      }
      } */

    //return "Undefined error!";
});


$APLExtensions = array(
    'Modules', 'Actions', 'Shortcodes', 'Template', 'Language', 'ExtensionController'
);

Event::listen('APL.core.load', function() use ($APLExtensions) {
    ClassLoader::addDirectories(base_path() . '/core/APL/');

    foreach ($APLExtensions as $Extension) {
        if (!ClassLoader::load($Extension)) {
            throw new Exception("'{$Extension}' load failed!");
        }
    }
});

Event::listen('APL.core.prepare', function () use ($APLExtensions) {
    foreach ($APLExtensions as $Extension) {
        $full_class = "Core\APL\\" . $Extension;
        $full_class::__init();
        class_alias($full_class, $Extension);
    }
});

Event::listen('APL.modules.load', function() {
    Event::fire('APL.core.load');
    Event::fire('APL.core.prepare');

    Module::where('enabled', '1')->get()->each(function($module) {
        ClassLoader::addDirectories(app_path() . '/modules/' . $module->extension . '/');
        ClassLoader::load($module->extension);
        Modules::addInstance($module->extension);
    });
});

Event::listen('APL.install.check', function () {
    return file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled');
});

Event::listen('APL.install.run', function () {
    Event::fire('APL.core.load');
    
    ClassLoader::addDirectories(base_path() . '/install/');

    View::addNamespace('install', base_path() . '/install/views');

    Route::get('/', 'InstallController@getIndex');
    Route::controller('install', 'InstallController');
});


App::before(function($request) {
    //Config::set('app.locale', Core\APL\Language::ext());
    //App::setLocale(Core\APL\Language::ext());
});

/*
  |--------------------------------------------------------------------------
  | Maintenance Mode Handler
  |--------------------------------------------------------------------------
  |
  | The   "down" Artisan command gives you the ability to put an application
  | into maintenance mode. Here, you will define what is displayed back
  | to the user if maintenance mode is in effect for the application.
  |
 */

App::down(function() {
    return Response::make("Be right back!", 503);
});

/*
  |--------------------------------------------------------------------------
  | Require The Filters File
  |--------------------------------------------------------------------------
  |
  | Next we will load the filters file for the application. This gives us
  | a nice separate location to store our route and application filter
  | definitions instead of putting them all in the main routes file.
  |
 */

require app_path() . '/filters.php';
