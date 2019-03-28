## FRAMEWORKS
1. [Laravel PHP Framework](https://laravel.com/docs/5.7)
2. [Bootstrap 4 CSS Framework](https://getbootstrap.com/docs/4.3/getting-started/introduction/)
3. [VueJS](https://vuejs.org/) already integrated in Laravel framework but not used

## TO DO
- [X] Automatically generate username for profile links
- [ ] Be able to assign a business to a user in admin console
- [ ] Implement front end design for business page
- [X] Implement hot & new business near you in landing page
- [ ] User profile
- [ ] HTML template for posting user comments on business profiles
- [ ] HTML template for a dashboard which business owner can use to edit their business profile, add menu, make posts, etc...


## HOW TO INSTALL
1. Clone this Github
2. Install PHP and Composer [(How To)](https://www.jeffgeerling.com/blog/2018/installing-php-7-and-composer-on-windows-10)
3. Install [NodeJS](https://nodejs.org/en/)
4. Download [this environment file](https://drive.google.com/open?id=1yfppt_JXePYrMWGLZAEZGIzbi_8nv_SY) and put it in the folder you just cloned
5. To install the dependencies, run the terminal in folder you just cloned and run this command `composer update` and `npm install`
6. To run the website locally, run this command in terminal `php artisan serve`


## OPTIONAL TOOLS
1. [Atom text editor](https://atom.io/) with [Github integration addon](https://atom.io/packages/github) installed
2. [Datagrip](https://www.jetbrains.com/datagrip/) for database queries

## SIMPLE EXPLANATION OF LARAVEL
- Laravel uses a MVC (Model-View-Controller) architecture. It uses a HTML template system called Blade. To create a page, first you need to set up a [Route](https://laravel.com/docs/5.8/routing). For example, to display a HTML page called homepage.blade.php on /home
1. You must have `homepage.blade.php` inside `resources/views` folder
2. Add the following code in `routes/web.php` file
```
Route::get('/home', function () {
    return view('homepage');
})
```


## USEFUL TIPS
1. Do a `git pull origin master` before you start coding, so your local repository is updated with the remote one on Github
2. Refresh migration and seed (To clean the database records and create fake records): `php artisan migration:refresh --seed`  
3. HTML templates are stored in resources/views
4. Other assets such as SASS and JS are stored in resources/assets, they get compiled automically by running `npm run watch` and to config which files to compile, it is in `webpack.mix.js` file
