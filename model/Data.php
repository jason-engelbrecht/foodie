<?php
/**
 * Jason Engelbrecht & Alvin Nava
 * 5.29.2019
 * https://jengelbrecht.greenriverdev.com/it328/foodie
 * Data Class
 */
/*
 CREATE TABLE recipe (
 recipe_id INT AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(30) NOT NULL,
 description TEXT NOT NULL,
 ingredients TEXT NOT NULL,
 instructions TEXT NOT NULL,
 time VARCHAR(30) NOT NULL,
 measure CHAR(10) NOT NULL,
 image VARCHAR(50) NOT NULL,
 date_created DATETIME NOT NULL,
 category INT NOT NULL,
 FOREIGN KEY(category) references category(category_id)
 );

 CREATE TABLE category (
 category_id INT AUTO_INCREMENT PRIMARY KEY,
 category VARCHAR(30)
 );

 INSERT INTO category(category)
 VALUES('Breakfast');
 INSERT INTO category(category)
 VALUES('Lunch');
 INSERT INTO category(category)
 VALUES('Dinner');
 INSERT INTO category(category)
 VALUES('Dessert');
 INSERT INTO category(category)
 VALUES('Healthy');
 INSERT INTO category(category)
 VALUES('Baking');
 INSERT INTO category(category)
 VALUES('Drinks');
 INSERT INTO category(category)
 VALUES('Miscellaneous');
 INSERT INTO category(category)
 VALUES('Vegetarian');
 */
$user = $_SERVER['USER'];
require "/home/$user/config.php";
//require '../../../config.php';

/**
 * Class representing a data stream
 *
 * This class represents a data stream
 * @author Jason Engelbrecht & Alvin Nava
 * @copyright 2019
 */
class Data
{
    private $_db;

    /**
     * Data constructor
     * @return void
     */
    function __construct()
    {
        $this->connect();
    }

    /**
     * Connect to database
     * @return PDO
     */
    function connect()
    {
        try {
            //Instantiate a db object
            $this->_db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            return $this->_db;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Inserts a new recipe into the recipe table
     *
     * @param $title string - Title of recipe
     * @param $description string - Description of recipe
     * @param $ingredients string - Ingredients of recipe
     * @param $instructions string - Instructions of recipe
     * @param $time string - Time to make recipe
     * @param $measure string - Measurements of recipe
     * @param $image string - Image of recipe
     * @param $category string - Category of recipe
     * @return mixed - query success or failure
     */
    function insertRecipe($title, $description, $ingredients, $instructions,
                          $time, $measure, $image, $category)
    {
        //define query
        $query = 'INSERT INTO recipe
                  (title, description, ingredients, instructions, 
                  time, measure, image, date_created, category)
                  VALUES
                  (:title, :description, :ingredients, :instructions, 
                  :time, :measure, :image, NOW(), :category)';

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameters
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
        $statement->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $statement->bindParam(':time', $time, PDO::PARAM_STR);
        $statement->bindParam(':measure', $measure, PDO::PARAM_STR);
        $statement->bindParam(':image', $image, PDO::PARAM_STR);
        $statement->bindParam(':category', $category, PDO::PARAM_STR);

        //execute statement
        $statement->execute();
    }

    /**
     * Gets all recipes limited to 3
     *
     * @return mixed - Query results(recipes)
     */
    function getRecipes()
    {
        //define query
        $query = "SELECT * FROM recipe
                  ORDER BY date_created DESC
                  LIMIT 3";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Gets related recipes to a category, limited to 3
     * for related recipes in recipe/ views
     *
     * @param $category string - Category of recipe
     * @param $id string - ID of recipe to not include
     * @return mixed - Query results(recipes)
     */
    function getRelatedRecipes($category, $id)
    {
        //define query
        $query = "SELECT * FROM recipe
                  WHERE recipe_id <> :id
                  AND category = :category
                  ORDER BY date_created DESC
                  LIMIT 3";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameter
        $statement->bindParam(':category', $category, PDO::PARAM_INT);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /**
     * Searches recipes for a match, checking if search term is like
     * one of several columns. Also checking the category if supplied.
     *
     * @param $search_term string - Term to search for
     * @param $category string - Category to check
     * @return mixed - Query results(recipes)
     */
    function searchRecipes($search_term, $category='all')
    {
        //add wildcards to search
        $search_term = '%' . $search_term . '%';
        //search all categories
        if($category == 'all') {
            //define query
            $query = "SELECT * FROM recipe
                      WHERE (title LIKE :search
                      OR description LIKE :search
                      OR ingredients LIKE :search
                      OR instructions LIKE :search
                      OR time LIKE :search)
                      ORDER BY date_created DESC";

            //prepare statement
            $statement = $this->_db->prepare($query);

            //bind parameter
            $statement->bindParam(':search', $search_term, PDO::PARAM_STR);
        }
        //search category supplied
        else {
            //define query
            $query = "SELECT * FROM recipe
                      WHERE (category = :category)
                      AND (title LIKE :search
                      OR description LIKE :search
                      OR ingredients LIKE :search
                      OR instructions LIKE :search
                      OR time LIKE :search)
                      ORDER BY date_created DESC";

            //prepare statement
            $statement = $this->_db->prepare($query);

            //bind parameters
            $statement->bindParam(':category', $category, PDO::PARAM_STR);
            $statement->bindParam(':search', $search_term, PDO::PARAM_STR);
        }

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Gets a unique recipe with the id
     *
     * @param $id string - id of recipe
     * @return mixed - Query result(recipe)
     */
    function getRecipe($id)
    {
        //define query
        $query = "SELECT * FROM recipe
                  WHERE recipe_id = :id";

        //prepare statement
        $statement = $this->_db->prepare($query);

        //bind parameter
        $statement->bindParam(':id', $id, PDO::PARAM_STR);

        //execute
        $statement->execute();

        //get result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}