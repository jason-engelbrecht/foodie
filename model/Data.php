<?php
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
 */

require '../../../config.php';

class Data
{
    private $_db;

    /**
     * Database constructor
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

}