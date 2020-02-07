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
    /*$_SESSION['form1a'] = $_POST['fname'];
    $_SESSION['form1b'] = $_POST['lname'];
    $_SESSION['form1c'] = $_POST['age'];
    $_SESSION['form1d'] = $_POST['gender'];
    $_SESSION['form1e'] = $_POST['phone'];*/

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        //$bio = $_POST['bio'];

        $f3->set('email', $email);
        $f3->set('location', $state);
        $f3->set('seeking', $seeking);
        //$f3->set('bio', $bio);

        if(validProfile()) {
            $_SESSION['email'] = $email;
            $_SESSION['location'] = $state;
            $_SESSION['seeking'] = $seeking;
            //$_SESSION['bio'] = $bio;


            //Redirect to profile.html
            $f3->reroute('/interests');
        }
    }
    $views = new Template();
    echo $views->render("views/profile.html");
});

// Define a Interests route
$f3->route('GET|POST /interests', function() {
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