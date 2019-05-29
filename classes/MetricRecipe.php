<?php
/**
 * Created by PhpStorm.
 * User: haro5
 * Date: 5/28/2019
 * Time: 10:06 PM
 */

/**
 * Class representing a metric recipe
 *
 * This class represents a recipe measured in metrics
 * @author Jason Engelbrecht & Alvin Nava
 * @copyright 2019
 */
class MetricRecipe extends Recipe
{
    private $_measure;

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
        parent::__construct($_title, $_description, $_time, $_image, $_dateCreated, $_category);
        $this->_measure = 'Metric';
    }

    /**
     * @return string
     */
    public function getMeasure()
    {
        return $this->_measure;
    }

    /**
     * @param string $measure
     */
    public function setMeasure($measure)
    {
        $this->_measure = $measure;
    }
}