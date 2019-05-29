<?php
/**
 * Jason Engelbrecht & Alvin Nava
 * 5.29.2019
 * https://jengelbrecht.greenriverdev.com/it328/foodie
 * Recipe Class
 */

/**
 * Class representing a recipe
 *
 * This class represents a basic recipe(abstract).
 * @author Jason Engelbrecht & Alvin Nava
 * @copyright 2019
 */
class Recipe
{
    private $_title;
    private $_description;
    private $_ingredients;
    private $_instructions;
    private $_time;
    //private $_measure; children
    private $_image;
    private $_dateCreated;
    private $_category;

    /**
     * Recipe constructor.
     * @param $_title
     * @param $_description
     * @param $_time
     * @param $_image
     * @param $_dateCreated
     * @param $_category
     */
    public function __construct($_title, $_description, $_time, $_image, $_dateCreated, $_category)
    {
        $this->_title = $_title;
        $this->_description = $_description;
        $this->_time = $_time;
        $this->_image = $_image;
        $this->_dateCreated = $_dateCreated;
        $this->_category = $_category;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * @param mixed $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->_ingredients = $ingredients;
    }

    /**
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->_instructions;
    }

    /**
     * @param mixed $instructions
     */
    public function setInstructions($instructions)
    {
        $this->_instructions = $instructions;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->_time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->_time = $time;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->_dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->_category = $category;
    }




}