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
