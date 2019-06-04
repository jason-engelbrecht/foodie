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
                             'Drinks',  'Miscellaneous', 'Vegetarian'));

$f3->set('categoriesDescriptions', array(
    'Breakfast' => 'What nicer thing can you do for somebody than make them breakfast?',
    'Lunch' => 'We must explain the truth: There is no free lunch.',
    'Dinner' => 'My favorite thing is to have a big dinner with friends and talk about life.',
    'Dessert' => 'Everyday can be cheat day if you truly desire it.',
    'Healthy' => 'Make eating healthy taste good while keeping it simple.',
    'Baking' => 'Baking is both an art and a science. But it doesn\'t have to be hard',
    'Drinks' => 'One can drink too much, but one never drinks enough.',
    'Vegetarian' => 'Eating vegetarian doesn\'t mean you have to eat boring, humdrum dishes.',
    'Miscellaneous' => 'When you don\'t know what you want but you is hungry.'
));

$f3->set('pictures', array(
   'Breakfast' => 'images/breakfast.jpg',
   'Lunch' => 'images/lunch.jpg',
   'Dinner' => 'images/dinner.jpg',
   'Dessert' => 'images/dessert.jpg',
   'Healthy' => 'images/healthy.jpg',
    'Baking' => 'images/baking.jpg',
    'Drinks' => 'images/drinks.jpg',
    'Vegetarian' => 'images/vegetarian.jpg',
    'Miscellaneous' => 'images/miscellaneous.jpg'
));

//turn on fat-free error reporting
$f3->set('DEBUG', 3);

//define home/default route
$f3->route('GET /', function($f3) {
    $f3->set('page_title', 'Home');

    //get recipes for featured recipes
    global $db;
    $recipes = $db->getRecipes();

    //set recipes for home
    $f3->set('recipes', $recipes);

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
                    TIME, 'none', CATEGORY);
            }
            else {
                //standard
                $_SESSION['recipe'] = new StandardRecipe(TITLE, DESCRIPTION,
                    TIME, 'none', CATEGORY);
            }
            $f3->reroute('/post'); //next form
        }
    }
    //display a view
    $view = new Template();
    echo $view->render('views/forms/share_recipe1.html');
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
            $recipe->setIngredients(INGREDIENTS);
            $recipe->setInstructions(INSTRUCTIONS);
            $_SESSION['recipe'] = $recipe;

            //get global db object and category's numerical value
            global $db;
            $category_value = array_search($recipe->getCategory(), $f3->get('categories')) + 1;

            //insert recipe into database
            $db->insertRecipe($recipe->getTitle(), $recipe->getDescription(),
                $recipe->getIngredients(), $recipe->getInstructions(), $recipe->getTime(),
                $recipe->getMeasure(), 'none', $category_value);

            $f3->reroute('/recipe'); //view recipe
        }
    }
    //display a view
    $view = new Template();
    echo $view->render('views/forms/share_recipe2.html');
});

// Define a contact us route
$f3->route('GET /contact', function($f3){
    $f3->set('page_title', 'Contact Us');

    // display a view
    $view = new Template();
    echo $view->render('views/forms/contact.html');
});

//TODO define a route for viewing each recipe
//TODO define a discover recipe route
//TODO define select queries for displaying recipes
//TODO one for main cards, side cards, and display pages

//define recipe route
$f3->route('GET /recipe', function($f3) {
    $f3->set('page_title', 'Home');

    //get recipes for featured recipes
    global $db;
    $recipes = $db->getRecipes();

    //set recipes for home
    $f3->set('recipes', $recipes);

    //display a view
    $view = new Template();
    echo $view->render('views/recipe.html');
});

//Define a route that displays student detail
$f3->route('GET /recipe/@id', function($f3, $params){
    $f3->set('page_title', 'Recipe');

    //get recipes for featured recipes
    global $db;
    $recipes = $db->getRecipes();

    //set recipes for home
    $f3->set('recipes', $recipes);

    $id = $params['id']; //must match^
    $recipe = $db->getRecipe($id);

    //separate both by new lines
    $ingredients = preg_split("/\r\n|\n|\r/", $recipe['ingredients']);
    $instructions = preg_split("/\r\n|\n|\r/", $recipe['instructions']);

    $f3->set('recipe', $recipe);
    $f3->set('ingredients', $ingredients);
    $f3->set('instructions', $instructions);

    $template = new Template();
    echo $template->render('views/recipe.html');
});

// Define a test route
$f3->route('GET|POST /discover', function($f3){
    $f3->set('page_title', 'Test');

    // display a view
    $view = new Template();
    echo $view->render('views/search.html');
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