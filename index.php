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

// Create an instance of the Base class
$f3 = Base::instance();

// Define a default route
$f3->route('GET /', function() {
    $views = new Template();
    echo $views->render("views/home.html");
});

// Define a Personal Info route
$f3->route('GET /personal', function() {
    $views = new Template();
    echo $views->render("views/personal_information.html");
});

// Define a Profile route
$f3->route('POST /profile', function() {
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
    $views = new Template();
    echo $views->render("views/summary.html");
});



// Run fat free
$f3->run();