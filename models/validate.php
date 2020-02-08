<?php

/* Validate the form
 * @return boolean
 */
function validPersonal()
{
    global $f3;
    $isValid = true;

    if (!validFname($f3->get('fname'))) {

        $isValid = false;
        $f3->set("errors['fname']", "Please enter a first name");
    }

    if (!validLname($f3->get('lname'))) {

        $isValid = false;
        $f3->set("errors['lname']", "Please enter a last name");
    }

    if (!validAge($f3->get('age')))
    {
        $isValid = false;
        $f3->set("errors['age']", "Please enter your age");
    }

    if (!validGender($f3->get('gender'))) {
        $isValid = false;
        $f3->set("errors['gender']", "Please choose a gender");
    }

    if(!validPhone($f3->get('phone')))
    {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter your phone number");
    }

    return $isValid;
}

function validProfile() {
    global $f3;
    $isValid = true;

    if(!validEmail($f3->get('email')))
    {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid email format");
    }

    if (!validSeeking($f3->get('seeking'))) {
        $isValid = false;
        $f3->set("errors['seeking']", "Please choose what gender you are seeking");
    }

    return $isValid;
}

function validInterests() {
    global $f3;
    $isValid = true;

    if(!validIndoor($f3->get('indoorSelected'))) {
        $isValid = false;
        $f3->set("errors['indoorSelected']", "Please choose at least one indoor activity");
    }

    if(!validOutdoor($f3->get('outdoorSelected'))) {
        $isValid = false;
        $f3->set("errors['outdoorSelected']", "Please choose at least one outdoor activity");
    }

    return $isValid;
}

function validFname($fname)
{
    return !empty($fname) && ctype_alpha($fname);
}

function validLname($lname)
{
    return !empty($lname) && ctype_alpha($lname);
}

function validAge($age)
{
    return !empty($age) && ctype_digit($age) && $age >= 1;
}

function validGender($gender)
{
    global $f3;
    return in_array($gender, $f3->get('genders'));
}

function validPhone($phone)
{
    return !empty($phone) && ctype_digit($phone) && $phone >= 1000000000;
}

function validEmail($email)
{
    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validSeeking($seeking)
{
    global $f3;
    return in_array($seeking, $f3->get('seek'));
}

function validIndoor($indoorSelected)
{
    global $f3;
    return true;
}

function validOutdoor($outdoorSelected)
{
    global $f3;
    return true;
}