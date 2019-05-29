<?php
/*
Jason Engelbrecht
4.12.2019
https://jengelbrecht.greenriverdev.com/it328/dating
Dog dating site, route to views/home.html.
*/

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload file and validation functions
require_once'vendor/autoload.php';

session_start();

//create an instance of the base class
$f3 = Base::instance();

//turn on fat-free error reporting
$f3->set('DEBUG', 3);

//define home/default route
$f3->route('GET /', function($f3) {
    $f3->set('page_title', 'Home');

    //display a view
    $view = new Template();
    echo $view->render('views/home.html');
});

//define share recipe route
$f3->route('GET|POST /share', function($f3) {
    $f3->set('page_title', 'Share');

    //display a view
    $view = new Template();
    echo $view->render('views/share_recipe/share_recipe1.html');
});

//define share recipe route - post
$f3->route('GET|POST /post', function($f3) {
    $f3->set('page_title', 'Post');

    //display a view
    $view = new Template();
    echo $view->render('views/share_recipe/share_recipe2.html');
});

//define recipe route
////////////temporary////////////////
$f3->route('GET /recipe', function($f3) {
    $f3->set('page_title', 'Home');

    //display a view
    $view = new Template();
    echo $view->render('views/recipe.html');
});

//run fat-free
$f3->run();