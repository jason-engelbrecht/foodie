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
 * This class represents a basic recipe(abstract)
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
    private $_image;
    private $_dateCreated;
    private $_category;

    /**
     * Recipe constructor
     * @param $_title - title of recipe
     * @param $_description - description of recipe
     * @param $_time - time recipe takes to make
     * @param $_image - image of recipe
     * @param $_dateCreated - date recipe was created
     * @param $_category - category of recipe
     * @return void
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
     * Get recipe title
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Set recipe title
     * @param string - recipe title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * Get recipe description
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Set recipe description
     * @param string - recipe description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * Get recipe ingredients
     * @return array
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * Set recipe ingredients
     * @param array - recipe ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->_ingredients = $ingredients;
    }

    /**
     * Get recipe instructions
     * @return array
     */
    public function getInstructions()
    {
        return $this->_instructions;
    }

    /**
     * Set recipe instructions
     * @param array - recipe instructions
     */
    public function setInstructions($instructions)
    {
        $this->_instructions = $instructions;
    }

    /**
     * Get recipe time to make
     * @return string
     */
    public function getTime()
    {
        return $this->_time;
    }

    /**
     * Set time to make recipe
     * @param string - time to make recipe
     */
    public function setTime($time)
    {
        $this->_time = $time;
    }

    /**
     * Get recipe image
     * @return string
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * Set recipe image
     * @param string - recipe image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * Get recipe creation date
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * Set recipe creation date
     * @param mixed - recipe creation date
     */
    public function setDateCreated($dateCreated)
    {
        $this->_dateCreated = $dateCreated;
    }

    /**
     * Get recipe category
     * @return string
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * Set recipe category
     * @param string - recipe category
     */
    public function setCategory($category)
    {
        $this->_category = $category;
    }
}