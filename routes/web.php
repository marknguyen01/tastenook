<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::get('/', 'WelcomeController@welcome')->name('welcome');

// Authentication Routes
Auth::routes();



// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);

    // Leaving Reviews
    Route::prefix('/b/{slug}')->group(function() {
      Route::post('/review/store', ['as' => 'review.store', 'uses' => 'ReviewController@store']);
      Route::get('/review/edit', ['as' => 'review.edit', 'uses' => 'ReviewController@edit']);
      Route::get('/review/delete', ['as' => 'review.delete', 'uses' => 'ReviewController@destroy']);
      Route::post('/review/update', ['as' => 'review.update', 'uses' => 'ReviewController@update']);
    });

    Route::prefix('/review/{id}')->group(function() {
      Route::post('/upvote', ['as' => 'review.upvote', 'uses' => 'ReviewController@upvote']);
      Route::post('/downvote', ['as' => 'review.downvote', 'uses' => 'ReviewController@downvote']);
      Route::post('/comment', ['as' => 'review.comment', 'uses' => 'ReviewController@storeComment']);
    });

    Route::prefix('/post/{id}')->group(function() {
      Route::post('/upvote', ['as' => 'post.upvote', 'uses' => 'PostController@upvote']);
      Route::post('/downvote', ['as' => 'post.downvote', 'uses' => 'PostController@downvote']);
      Route::post('/comment', ['as' => 'post.comment', 'uses' => 'PostController@storeComment']);
    });

    Route::group(['middleware' => ['level:3', 'permission:edit.businesses']], function() {
        Route::get('/b/create', ['as' => 'business.create', 'uses' => 'BusinessController@create']);
        Route::post('/b/create', ['as' => 'business.store', 'uses' => 'BusinessController@store']);
        Route::prefix('/b/{slug}')->group(function() {
          Route::get('/edit', ['as' => 'business.edit', 'uses' => 'BusinessController@edit']);
          Route::post('/update', ['as' => 'business.update', 'uses' => 'BusinessController@update']);
          Route::get('/coupon', ['as' => 'coupon.show', 'uses' => 'BusinessController@showCoupon']);
          Route::get('/coupon/create', ['as' => 'coupon.create', 'uses' => 'BusinessController@createCoupon']);
          Route::post('/coupon/store', ['as' => 'coupon.store', 'uses' => 'BusinessController@storeCoupon']);
          Route::get('/coupon/{coupon_id}/edit', ['as' => 'coupon.edit', 'uses' => 'BusinessController@editCoupon']);
          Route::post('/coupon/{coupon_id}/update', ['as' => 'coupon.update', 'uses' => 'BusinessController@updateCoupon']);
          Route::get('/coupon/{coupon_id}/delete', ['as' => 'coupon.delete', 'uses' => 'BusinessController@deleteCoupon']);
          Route::get('/post', ['as' => 'post.show', 'uses' => 'PostController@show']);
          Route::get('/post/create', ['as' => 'post.create', 'uses' => 'PostController@create']);
          Route::post('/post/store', ['as' => 'post.store', 'uses' => 'PostController@store']);
          Route::get('/post/{post_id}/edit', ['as' => 'post.edit', 'uses' => 'PostController@edit']);
          Route::post('/post/{post_id}/update', ['as' => 'post.update', 'uses' => 'PostController@update']);
          Route::get('/post/{post_id}/destroy', ['as' => 'post.destroy', 'uses' => 'PostController@destroy']);
        });
    });
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');
});

// Public Routes
Route::group(['middleware' => ['web', 'activity']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);

    Route::get('/b/{slug}/', ['as' => 'business.show', 'uses' => 'BusinessController@show']);
    Route::post('/b/search', ['as' => 'business.search', 'uses' => 'BusinessController@search']);

});

Route::redirect('/php', '/phpinfo', 301);
