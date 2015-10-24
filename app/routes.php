<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
    'as' => 'home',
    'uses' => 'AccountController@getLogin'
));

Route::group(array('before' => 'guest'), function(){

   Route::group(array('before' => 'csrf'), function(){

       Route::post('/account/login', array(
           'as' => 'account-login-post',
           'uses' => 'AccountController@postLogin'
       ));

       Route::post('/account/create', array(
           'as' => 'account-create-post',
           'uses' => 'AccountController@postCreate'
       ));

   });

    Route::get('/account/login', array(
        'as' => 'account-login',
        'uses' => 'AccountController@getLogin'
    ));

    Route::get('/account/create', array(
        'as' => 'account-create',
        'uses' => 'AccountController@getCreate'
    ));

});

Route::post('/readings/reading', array(
    'as' => 'data',
    'uses' => 'ReadingsController@postReading'
));

Route::post('/account/FindPhone', array(
    'as' => 'phone',
    'uses' => 'AccountController@postFindPhone'
));

Route::post('/server', array(
    'as' => 'server',
    'uses' => 'ReadingsController@postServer'
));

Route::post('/com', array(
    'as' => 'com',
    'uses' => 'CommandController@postCom'
));

Route::post('/code', array(
    'as' => 'code',
    'uses' => 'CommandController@postCode'
));

Route::post('/command/data', array(
    'as' => 'command',
    'uses' => 'CommandController@postForm'
));

Route::post('/exhaust/reading', array(
    'as' => 'exdata',
    'uses' => 'ExhaustController@postReading'
));

Route::get('/exhaust/index', array(
    'as' => 'exhaustIndex',
    'uses' => 'ExhaustController@getIndex'
));

Route::get('/exhaust/set_room', array(
    'as' => 'room_form',
    'uses' => 'ExhaustController@getForm'
));

Route::get('/exhaust/graph/{mac}/{time_length}', array(
    'as' => 'exhaustGraph',
    'uses' => 'ExhaustController@getGraph'
));

Route::get('/exhaust/rooms', array(
    'as' => 'exhaustRooms',
    'uses' => 'ExhaustController@getRooms'
));

Route::post('/exhaust/room_name', array(
    'as' => 'room_name',
    'uses' => 'ExhaustController@postRoom'
));

Route::get('/exhaust/delete/{mac}', array(
    'as' => 'exhaustDelete',
    'uses' => 'ExhaustController@getDelete'
));

Route::group(array('before' => 'auth'), function(){

    Route::group(array('before' => 'csrf'), function(){

        Route::post('/readings/data', array(
            'as' => 'variable',
            'uses' => 'ReadingsController@postVariable'
        ));

        Route::post('/account/phonechange', array(
            'as' => 'account-phone-post',
            'uses' => 'AccountController@postPhone'
        ));

        Route::post('/account/password', array(
            'as' => 'account-password-post',
            'uses' => 'AccountController@postChangePassword'
        ));

        Route::post('/editRecords', array(
            'as' => 'editRecords',
            'uses' => 'ReadingsController@postEditRecords'
        ));

    });

    Route::get('/account/logoff', array(
        'as' => 'account-logoff',
        'uses' => 'AccountController@getLogoff'
    ));

    Route::get('/account/pass', array(
        'as' => 'account-password',
        'uses' => 'AccountController@getChangePassword'
    ));

    Route::get('/command', array(
        'as' => 'command-form',
        'uses' => 'CommandController@getCommandForm'
    ));

    Route::get('/account/phone', array(
        'as' => 'account-phone',
        'uses' => 'AccountController@getChangePhone'
    ));

    Route::get('/readings', array(
        'as' => 'readings',
        'uses' => 'ReadingsController@getIndex'
    ));

    Route::get('/set_threshold', array(
        'as' => 'form',
        'uses' => 'ReadingsController@getForm'
    ));

    Route::get('/backup', array(
        'as' => 'records',
        'uses' => 'ReadingsController@getRecords'
    ));

    Route::get('/graph/{mac}/{time_length}', array(
        'as' => 'graph',
        'uses' => 'ReadingsController@getGraph'
    ));

    Route::get('/threshold', array(             // display all entries in the table threshold
        'as' => 'getThreshold',
        'uses' => 'ThresholdController@getThreshold'
    ));

    Route::get('/devices', array(               // display all entries in the table ip2name
        'as' => 'devices',
        'uses' => 'DeviceController@getDevices'
    ));

    Route::get('/rooms', array(
        'as' => 'rooms',
        'uses' => 'ReadingsController@getRooms'
    ));

    Route::get('/edit/{room}', array(
        'as' => 'rooms',
        'uses' => 'ReadingsController@getRecordsData'
    ));

    Route::get('/devices/delete/{mac}', array(               // display all entries in the table ip2name
        'as' => 'delete',
        'uses' => 'DeviceController@getDelete'
    ));
});