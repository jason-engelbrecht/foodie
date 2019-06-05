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
$f3->set('categoriesPictures', array(
   'Breakfast' => 'breakfast.jpg',
   'Lunch' => 'lunch.jpg',
   'Dinner' => 'dinner.jpg',
   'Dessert' => 'dessert.jpg',
   'Healthy' => 'healthy.jpg',
    'Baking' => 'baking.jpg',
    'Drinks' => 'drinks.jpg',
    'Vegetarian' => 'vegetarian.jpg',
    'Miscellaneous' => 'miscellaneous.jpg'
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


        //path to upload image
        $target_dir = "images/uploads/";
        //path of the file to be uploaded
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        //for later - making sure upload is ok
        $uploadOk = 1;
        //get image file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        }
        else {
            $f3->set("errors['image']", "File is not an image");
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $f3->set("errors['image']", "File already exists, please select another file");
            $uploadOk = 0;
        }

        // Check file size, < 1mb
        if ($_FILES["image"]["size"] > 1000000) {
            $f3->set("errors['image']", "File size too large, up to 1 mb file size allowed");
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $f3->set("errors['image']", "Only JPG, JPEG, & PNG files are allowed");
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $f3->set("errors['image']", "Your image was not able to be uploaded, please try again");
        }
        // if everything is ok, try to upload file
        else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                //do nothing
            }
            else {
                $f3->set("errors['image']", "Error. Upload failed, please try again");
            }
        }



        //if all required constants are defined
        if (defined('TITLE') && defined('TIME') &&
            defined('CATEGORY') && defined('DESCRIPTION') &&
            defined('MEASURE') && $uploadOk == 1){

            //check what kind of recipe
            if(MEASURE == 'Metric') {
                //metric
                $_SESSION['recipe'] = new MetricRecipe(TITLE, DESCRIPTION,
                    TIME, $target_file, CATEGORY);
            }
            else {
                //standard
                $_SESSION['recipe'] = new StandardRecipe(TITLE, DESCRIPTION,
                    TIME, $target_file, CATEGORY);
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
                $recipe->getMeasure(), $recipe->getImage(), $category_value);

            session_destroy();
            $f3->reroute('/'); //view recipe
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

//Define a route that displays student detail
$f3->route('GET /recipe/@id', function($f3, $params){
    //get recipes for featured recipes
    global $db;

    //get recipe with id
    $id = $params['id']; //must match^
    $recipe = $db->getRecipe($id);

    //get category
    $category = $recipe['category'];
    $category_value = array_search($category, $f3->get('categories')) + 1;

    //get related recipes by category
    $recipes = $db->getRelatedRecipes($category_value, $id);
    $f3->set('recipes', $recipes);

    //set page title to recipe title
    $f3->set('page_title', $recipe['title']);

    //separate both by new lines
    $ingredients = preg_split("/\r\n|\n|\r/", $recipe['ingredients']);
    $instructions = preg_split("/\r\n|\n|\r/", $recipe['instructions']);

    //set for view
    $f3->set('recipe', $recipe);
    $f3->set('ingredients', $ingredients);
    $f3->set('instructions', $instructions);

    $template = new Template();
    echo $template->render('views/recipe.html');
});

// Define a test route
$f3->route('GET|POST /discover', function($f3){
    $f3->set('page_title', 'Discover');

    if(isset($_POST['submit'])) {
        $_SESSION['search'] = $_POST['search'];
        $_SESSION['category'] = $_POST['category'];

        $f3->reroute('/search');
    }

    // display a view
    $view = new Template();
    echo $view->render('views/discover.html');
});

$f3->route('GET|POST /search', function($f3){
    $f3->set('page_title', 'Search');

    global $db;

    //get category
    $category = array_search($_SESSION['category'], $f3->get('categories')) + 1;

    //search
    $recipes = $db->searchRecipes($_SESSION['search'], $category);
    $f3->set('recipes', $recipes);

    // display a view
    $view = new Template();
    echo $view->render('views/search.html');
});

//TODO make search route with variable parameters for category selection on anchor tags

//run fat-free
$f3->run();