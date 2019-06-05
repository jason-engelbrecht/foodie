<?php
/*
Jason Engelbrecht & Alvin Nava
5.29.2019
https://jengelbrecht.greenriverdev.com/it328/foodie
Food blog website form validation
*/
/**
 * Created by PhpStorm.
 * User: haro5
 * Date: 5/29/2019
 * Time: 4:00 PM
 */

function validate($input)
{
    return !empty($input);
}

/**
 * Checks if an image is valid for upload
 *
 * @param array $image      File info for profile image
 * @param string $path      the path of the image to be checked
 * @return bool             if the image is valid
 */
function validImage($image, $path)
{
    global $f3;

    $upload = true;
    $type = strtolower(pathinfo($path,PATHINFO_EXTENSION));
    $check = getimagesize($image['tmp_name']);

    if($check !== false) {
        // is an image
        // if filepath already exists
        if(file_exists($path)) {
            $f3->set("errors['image']", "File already exists.");
            $upload = false;
            // if not correct file type
        } elseif (!($type == 'jpg' || $type == 'png' || $type == 'jpeg')) {
            $f3->set("errors['image']", "Please choose a png, jpg, or jpeg.");
            $upload = false;
        }
    } else {
        $f3->set("errors['image']", "That file isn't an image.");
        $upload = false;
    }

    return $upload;
}