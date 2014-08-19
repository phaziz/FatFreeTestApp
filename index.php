<?php

    /*
     * 
     * CREATE NEW F3 INSTANCE
     * 
     * */
    $f3app = require 'lib/base.php';

    /*
     * 
     * CONFIGURING THE APP
     * 
     * */
    $f3app -> config('./config/config.ini');
    
    /*
     * 
     * CLASS LOADING
     * 
     * */
    require_once './classes/orm.php';   // IDIORM ORM
    require_once './classes/app.php';   // Application Classes
    require_once './classes/rb.php';    // RedBeanPHP ORM library
    require_once './lib/log.php';    // RedBeanPHP ORM library

    /*
     * 
     * CONFIGURING ORM (IDIORM)
     * 
     * */
    ORM::configure(array('connection_string' => 'mysql:host=localhost;dbname=XXXXX','username' => 'XXXXX','password' => 'XXXXX'));

    // REDBEANPHP
    R::setup('mysql:host=localhost;dbname=XXXXX','XXXXX','XXXXX');

    /*
     * 
     * APPLICATION ROUTES
     * 
     * */
    $f3app -> route('GET /php/info','App->info',10);
    $f3app -> route('GET /redbean','App->redbean');
    $f3app -> route('GET /orm','App->orm');
    $f3app -> route('GET /ormupdate','App->ormupdate');
    $f3app -> route('GET /','App->displayWorld',10);
    $f3app -> route('GET /@name','App->displayName',10);
    $f3app -> route('GET /minify/@type','App->minification',3600*24);

    /*
     * 
     * ERROR HANDLING
     * 
     * */
    $f3app -> set('ONERROR',function($f3app)
        {
            $f3app -> set('content','index_error.html');
            $f3app -> set('code', $f3app -> get('ERROR.code'));
            $f3app -> set('status', $f3app -> get('ERROR.status'));
            $f3app -> set('text', $f3app -> get('ERROR.text'));
            $f3app -> set('trace', $f3app -> get('ERROR.trace'));

            echo View::instance() -> render('layout.html');
        }
    );

    /*
     * 
     * RUNNING THE APP
     * 
     * */
    $f3app -> run();
    
    // CLOSING REDBEAN
    R::close();
    