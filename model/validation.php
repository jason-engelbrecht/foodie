<?php
/**
 * Jason Engelbrecht & Alvin Nava
 * 5.29.2019
 * https://jengelbrecht.greenriverdev.com/it328/foodie
 * Validation functions
 */

/**
 * Validate input
 *
 * @param $input mixed - input to be validated
 * @return bool - if valid or not
 */
function validate($input)
{
    return !empty($input);
}

function validateEmail($email)
{
    $isValid = true;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
    }
    return $isValid;

}

/**
 * Validate image upload
 *
 * @return int - success(1) or failure(0) of image upload validation
 */
function validateImage() {
    global $f3;
    //path to upload image
    $target_dir = "images/uploads/";
    //path of the file to be uploaded
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    //for later - making sure upload is ok
    $uploadOk = 1;
    //get image file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        $f3->set("errors['image']", "Image already exists, please select another image");
        $uploadOk = 0;
    }

    // Check file size, < 1mb
    if ($_FILES["image"]["size"] > 1000000) {
        $f3->set("errors['image']", "Image size too large, up to 1 mb image size allowed");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $f3->set("errors['image']", "Only JPG, JPEG, & PNG files are allowed");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $f3->set("errors['image']", "Please submit a valid image");
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
    return $uploadOk;
}
