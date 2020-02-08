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
$f3->set('states', array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY'));
$f3->set('seek', array('Male', 'Female'));
$f3->set('indoor', array('tv', 'movies', 'cooking', 'board games', 'puzzles', 'reading', 'playing cards', 'video games'));
$f3->set('outdoor', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));

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
        $phone = $_POST['phone'];

        // Add data to hive
        $f3->set('fname', $fname);
        $f3->set('lname', $lname);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);

        if (validPersonal()) {
            // Write data to session
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['age'] = $age;
            $_SESSION['gender'] = $gender;
            $_SESSION['phone'] = $phone;

            //Redirect to profile.html
            $f3->reroute('/profile');
        }

    }

    $views = new Template();
    echo $views->render("views/personal_information.html");
});

// Define a Profile route
$f3->route('GET|POST /profile', function($f3) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = $_POST['bio'];

        $f3->set('email', $email);
        $f3->set('location', $state);
        $f3->set('seeking', $seeking);
        $f3->set('bio', $bio);

        if(validProfile()) {
            $_SESSION['email'] = $email;
            $_SESSION['location'] = $state;
            $_SESSION['seeking'] = $seeking;
            $_SESSION['bio'] = $bio;


            //Redirect to interests.html
            $f3->reroute('/interests');
        }
    }
    $views = new Template();
    echo $views->render("views/profile.html");
});

// Define a Interests route
$f3->route('GET|POST /interests', function($f3) {

    $indoorSelected = array();
    $outdoorSelected = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!empty($_POST['indoor']))
            $indoorSelected = $_POST['indoor'];

        if (!empty($_POST['outdoor']))
            $outdoorSelected = $_POST['outdoor'];

        $f3->set('indoorSelected', $indoorSelected);
        $f3->set('outdoorSelected', $outdoorSelected);

        if (validInterests()) {
            $_SESSION['indoor'] = $indoorSelected;
            $_SESSION['outdoor'] = $outdoorSelected;

            //Redirect to Summary
            $f3->reroute('/summary');
        }
    }

    $views = new Template();
    echo $views->render("views/interests.html");
});

// Define a results summary route
$f3->route('GET|POST /summary', function() {
    
    $views = new Template();
    echo $views->render("views/summary.html");
});



// Run fat free
$f3->run();