<?php
/**
 * Jason Engelbrecht & Alvin Nava
 * 5.29.2019
 * https://jengelbrecht.greenriverdev.com/it328/foodie
 * Ajax search
 */

//open data stream
require'Data.php';
$db = new Data();

//categories for reference
$categories = array('Breakfast', 'Lunch', 'Dinner',
    'Dessert', 'Healthy', 'Baking',
    'Drinks',  'Miscellaneous', 'Vegetarian');

//display recipe function
function displayRecipe($title, $description, $time, $date, $category, $image, $id) {
    echo
    '<div class="result">
        <!-- container -->
        <div class="container pt-5">
            
            <!-- recipe jumbotron -->
            <div class="jumbotron text-center hoverable p-4 grey lighten-5">
                <!-- row -->
                <div class="row">
                    <!-- column -->
                    <div class="col-md-4 offset-md-1 mx-3 my-3">
                        <!-- image -->
                        <!--Mask with wave-->
                        <div class="view overlay">
                            <img src="'. $image .'" class="img-fluid" alt="Sample image with waves effect.">
                            <a href="../foodie/recipe/' . $id . '">
                                <div class="mask waves-effect waves-light rgba-white-slight"></div>
                            </a>
                        </div>
                    </div>
                    <!-- column -->
    
                    <!-- column -->
                    <div class="col-md-7 text-md-left ml-3 mt-3">
    
                        <!-- Category -->
                        <a href="../foodie/search/' . $category . '" class="orange-text">
                            <h6 class="h6 pb-1 deep-orange-lighter-hover"><i class="fas fa-utensils"></i> ' . $category . '</h6>
                        </a>
    
                        <!-- Title -->
                        <h4 class="h4 mb-4">' . $title . '</h4>
    
                        <!-- Part of description -->
                        <p class="font-weight-light">' .  substr($description , 0, 261) . '</p>
    
                        <!-- Time -->
                        <h6 class="h6 pb-1"><i class="far fa-clock"></i> ' . $time . '</h6>
                        <!-- Date -->
                        <h6 class="h6 pb-1">Posted on: ' .  date('F j, Y', strtotime($date)) . '</h6>
                        <!-- View recipe -->
                        <a class="ml-0 btn peach-gradient text-white" href="../foodie/recipe/' . $id . '"><i class="fas fa-hamburger mr-1"></i> Full recipe </a>
                    </div>
                    <!-- column -->
                </div>
                <!-- row -->
            </div>
            <!-- recipe jumbotron -->
        </div>
    </div>';
}

//get values
$category = $_POST['category'];
$search = $_POST['search'];

//check category is all or need to retrieve
if($category != 'all') {
    $category = array_search($category, $categories) + 1;
}

//search
$recipes = $db->searchRecipes($search, $category);

//display all recipes
foreach ($recipes as $recipe) {
    $category = $categories[(int)$recipe['category'] - 1];
    displayRecipe($recipe['title'], $recipe['description'], $recipe['time'],
        $recipe['date_created'], $category, $recipe['image'], $recipe['recipe_id']);
}