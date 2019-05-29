<?php
/**
 * Jason Engelbrecht & Alvin Nava
 * 5.29.2019
 * https://jengelbrecht.greenriverdev.com/it328/foodie
 * StandardRecipe Class
 */

/**
 * Class representing a standard recipe
 *
 * This class represents a recipe measured in standard
 * @author Jason Engelbrecht & Alvin Nava
 * @copyright 2019
 */
class StandardRecipe extends Recipe
{
    private $_measure;

    /**
     * Recipe constructor.
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
        parent::__construct($_title, $_description, $_time, $_image, $_dateCreated, $_category);
        $this->_measure = 'Standard';
    }

    /**
     * Get recipe measurement
     * @return string
     */
    public function getMeasure()
    {
        return $this->_measure;
    }

    /**
     * Set recipe measurement
     * @param string - recipe measurement
     */
    public function setMeasure($measure)
    {
        $this->_measure = $measure;
    }
}