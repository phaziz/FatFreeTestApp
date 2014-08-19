<?php

    class App
    {
        /*
         * 
         * DISPLAY TEMPLATE FOR MAIN ROUTE ./
         * 
         * */
        function displayWorld($f3app)
        {
            $f3app -> set('content','index_world.html');
            echo View::instance() -> render('layout.html');
        }

        /*
         * 
         * WHEN WE $_GET params DISPLAY THE PARAMS TEMPLATE
         * 
         * */
        function displayName($f3app,$params)
        {
            $f3app -> set('content','index_params.html');
            $f3app -> set('params',$params);

            echo View::instance() -> render('layout.html');
        }

        /*
         * 
         * ROUTING FOR INCLUDED FILE MINIFICATIONS
         * 
         * */
        function minification($f3app, $args)
        {
            $f3app -> set('UI', $f3app -> get('UI').$args['type'].'/'); 
            echo Web::instance() -> minify($_GET['files']);
        }

        /*
         * 
         * SELECTING DATA USING REDBEANPHP
         * 
         * */
        function redbean($f3app)
        {
            $R_DEBUG = $f3app -> get('R_DEBUG');

            if($R_DEBUG == true)
            {
                R::debug(TRUE);
                $logger = new \Log(date('Y-m-d') . '.log');
                $logger -> write('$R_DEBUG: true.');
            }

            // $add_test = R::dispense( 'test' );
            // $add_test -> name = 'AddTest 1';
            // $add_test -> val = 'AddValue 1';
            // $add_test_result = R::store( $add_test);

            //$TESTDATA = R::findAll('test');
            $TESTDATA = R::getAll( 'SELECT * FROM test ORDER BY id ASC;');
            $FIELDS = R::inspect('test');

            $f3app -> set('result',$TESTDATA);
            $f3app -> set('tableresult',$FIELDS);
            
            echo View::instance() -> render('redbean.html');
        }

        /*
         * 
         * SELECTING DATA USING ORM
         * 
         * */
        function orm($f3app)    
        {
            $TESTDATA = ORM::for_table('test')
                      -> find_many();

            $f3app -> set('result',$TESTDATA);
            echo View::instance() -> render('orm.html');
        }

        /*
         * 
         * UPDATING DATA USING ORM
         * 
         * */
        function ormupdate($f3app)
        {
            $UPDATE = ORM::for_table('test')
                    -> find_one(1);
            $UPDATE -> set(
                array
                (
                    'name' => 'Name 1',
                    'val'  => 'Value 1'
                )
            );
            $UPDATE -> save();

            $TESTDATA = ORM::for_table('test')
                      -> find_many();

            $f3app -> set('result',$TESTDATA);
            echo View::instance() -> render('orm.html');
        }

        /*
         * 
         * SIMPLY DISPLAYS PHPINFO() OF SERVER ENVIRONMENT
         * 
         * */
        function info()
        {
            echo phpinfo();
        }

    }