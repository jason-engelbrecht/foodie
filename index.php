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
require_once'model/validation.php';

//start session, open data stream, create recipe object
session_start();
$db = new Data();

//create an instance of the base class
$f3 = Base::instance();

//arrays
$f3->set('categories', array('Breakfast', 'Lunch', 'Dinner',
                             'Dessert', 'Healthy', 'Baking',
                             'Drinks', 'Miscellaneous'));

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

    //form submission
    if(isset($_POST['submit'])) {
        //get post data
        $title = $_POST['title'];
        $time = $_POST['time'];
        $category = $_POST['category'];
        //TODO need to get image
        $description = trim($_POST['description']);
        $measure = $_POST['measure'];

        //set to hive for sticky form
        $f3->set('title', $title);
        $f3->set('time', $time);
        $f3->set('category', $category);
        $f3->set('description', $description);
        $f3->set('measure', $measure);

        //validate
        if (validate(trim($title))) {
            define('TITLE', $title);
        }
        else {
            $f3->set("errors['title']", "Please enter a title");
        }

        if (validate(trim($time))) {
            define('TIME', $time);
        }
        else {
            $f3->set("errors['time']", "Please enter a time");
        }

        if (validate($category) && in_array($category, $f3->get('categories'))) {
            define('CATEGORY', $category);
        }
        else {
            $f3->set("errors['category']", "Please enter a category");
        }

        if (validate($description)) {
            define('DESCRIPTION', $description);
        }
        else {
            $f3->set("errors['description']", "Please enter a description");
        }

        if (validate($measure) && ($measure == 'Standard' || $measure == 'Metric')) {
            define('MEASURE', $measure);
        }
        else {
            $f3->set("errors['measure']", "Please select a measurement");
        }

        //if all required constants are defined
        if (defined('TITLE') && defined('TIME') &&
            defined('CATEGORY') && defined('DESCRIPTION') &&
            defined('MEASURE')) {

            //check what kind of recipe
            if(MEASURE == 'Metric') {
                //metric
                $_SESSION['recipe'] = new MetricRecipe(TITLE, DESCRIPTION,
                    TIME, 'none', time(), CATEGORY);
            }
            else {
                //standard
                $_SESSION['recipe'] = new StandardRecipe(TITLE, DESCRIPTION,
                    TIME, 'none', time(), CATEGORY);
            }
            $f3->reroute('/post'); //next form
        }
    }
    //display a view
    $view = new Template();
    echo $view->render('views/share_recipe/share_recipe1.html');
});

//define share recipe route - post
$f3->route('GET|POST /post', function($f3) {
    $f3->set('page_title', 'Post');

    if(isset($_POST['submit'])) {
        //get post data
        $ingredients = trim($_POST['ingredients']);
        $instructions = trim($_POST['instructions']);

        //set to hive for sticky form
        $f3->set('ingredients', $ingredients);
        $f3->set('instructions', $instructions);

        //validate
        if (validate($ingredients)) {
            define('INGREDIENTS', $ingredients);
        }
        else {
            $f3->set("errors['ingredients']", "Please enter your ingredients");
        }

        //validate
        if (validate($instructions)) {
            define('INSTRUCTIONS', $instructions);
        }
        else {
            $f3->set("errors['instructions']", "Please enter your instructions");
        }

        if (defined('INGREDIENTS') && defined('INSTRUCTIONS')) {

            //get recipe and assign new fields
            $recipe = $_SESSION['recipe'];
            /*$recipe->setIngredients('INGREDIENTS');
            $recipe->setInstructions('INSTRUCTIONS');*/
            $_SESSION['recipe'] = $recipe;

            //TODO enter info into database

            $f3->reroute('/recipe'); //view recipe
        }
    }
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

// Define a contact us route
$f3->route('GET /contact', function($f3){
   $f3->set('page_title', 'Contact Us');

   // display a view
    $view = new Template();
    echo $view->render('views/contact.html');
});

// Define a test route
$f3->route('GET /test', function($f3){
    $f3->set('page_title', 'Test');

    // display a view
    $view = new Template();
    echo $view->render('views/test.html');
});

//run fat-free
$f3->run();