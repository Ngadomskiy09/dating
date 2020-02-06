<?php

/*
 * Nick Gadomskiy
 * 1/18/20
 * Dating profile assignment
 */

session_start();

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require('vendor/autoload.php');
require('models/validate.php');

// Create an instance of the Base class
$f3 = Base::instance();

$f3->set('genders', array('Male', 'Female'));

// Define a default route
$f3->route('GET /', function() {
    $views = new Template();
    echo $views->render("views/home.html");
});

// Define a Personal Info route
$f3->route('GET|POST /personal', function($f3) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Get Data from form
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];

        // Add data to hive
        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('age', $age);
        $f3->set('gender', $gender);

        if (validPersonal()) {
            // Write data to session
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;

            //Redirect to profile.html
            $f3->reroute('/profile');
        }

    }

    $views = new Template();
    echo $views->render("views/personal_information.html");
});

// Define a Profile route
$f3->route('GET|POST /profile', function() {
    $_SESSION['form1a'] = $_POST['fname'];
    $_SESSION['form1b'] = $_POST['lname'];
    $_SESSION['form1c'] = $_POST['age'];
    $_SESSION['form1d'] = $_POST['gender'];
    $_SESSION['form1e'] = $_POST['phone'];
    $views = new Template();
    echo $views->render("views/profile.html");
});

// Define a Interests route
$f3->route('POST /interests', function() {
    $_SESSION['form2a'] = $_POST['email'];
    $_SESSION['form2b'] = $_POST['state'];
    $_SESSION['form2c'] = $_POST['seeking'];
    $_SESSION['form2d'] = $_POST['biography'];
    $views = new Template();
    echo $views->render("views/interests.html");
});

// Define a results summary route
$f3->route('POST /summary', function() {
    $hobbies = "";
        if(!empty($_POST['check_list'])){
            foreach($_POST['check_list'] as $selected) {
                $hobbies .= $selected.", ";
            }
        }

    $_SESSION['form3a'] = $hobbies;
    $views = new Template();
    echo $views->render("views/summary.html");
});



// Run fat free
$f3->run();