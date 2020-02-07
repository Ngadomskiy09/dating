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

    if(!validState($f3->get('state')))
    {
        $isValid = false;
        $f3->set("errors['state']", "Please select a state");
    }

    if (!validSeeking($f3->get('seeking'))) {
        $isValid = false;
        $f3->set("errors['seeking']", "Please choose what gender you are seeking");
    }

    /*if(!validBio($f3->get('bio'))) {
        $isValid = false;
        $f3->set("errors['bio']", "Please fill out the biography");
    }*/

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
    return !empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validState($state)
{
    global $f3;
    return in_array($state, $f3->get('states'));
}

function validSeeking($seeking)
{
    global $f3;
    return in_array($seeking, $f3->get('seek'));
}

/*function validBio($bio)
{
    return !empty($bio) && ctype_alpha($bio);
}*/