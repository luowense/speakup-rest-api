<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup/user', 'App\\Api\\V1\\Controllers\\SignUpController@signUpUser');
        $api->post('signup/psy', 'App\\Api\\V1\\Controllers\\SignUpController@signUpPsy');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');


    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UsersController@me');

        $api->get('users', 'App\\Api\\V1\\Controllers\\UsersController@index');
        $api->get('ticket/{id}/messages/', 'App\\Api\\V1\\Controllers\\MessagesController@index');
        $api->post('ticket/{id}/messages/send', 'App\\Api\\V1\\Controllers\\MessagesController@store');

        $api->get('tickets/{id}/join', 'App\\Api\\V1\\Controllers\\TicketController@join');
        $api->post('tickets/start', 'App\\Api\\V1\\Controllers\\TicketController@start');
        $api->get('tickets/{id}', 'App\\Api\\V1\\Controllers\\TicketController@index');
        $api->get('users/{id}/tickets', 'App\\Api\\V1\\Controllers\\TicketController@checkTicketByPsy');
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.', 201
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!', 201
                ]);
            }
        ]);
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.', 201
        ]);
    });
});
