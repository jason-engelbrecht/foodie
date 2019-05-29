<?php
/**
 * Created by PhpStorm.
 * User: haro5
 * Date: 5/28/2019
 * Time: 10:06 PM
 */

class StandardRecipe extends Recipe
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
        $this->_measure = 'Standard';
    }

}