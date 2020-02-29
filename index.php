<?php

/*
 * Nick Gadomskiy
 * 1/18/20
 * Dating profile assignment
 */

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require('vendor/autoload.php');
require('models/validate.php');

session_start();

// Create an instance of the Base class
$f3 = Base::instance();

$dbh = new Database();

$f3->set('genders', array('Male', 'Female'));
$f3->set('states', array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME', 'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM', 'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY'));
$f3->set('seek', array('Male', 'Female'));
$f3->set('indoor', array('tv', 'movies', 'cooking', 'board games', 'puzzles', 'reading', 'playing cards', 'video games'));
$f3->set('outdoor', array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing'));

$controller = new Routes($f3);
$f3->set('DEBUG', 3);

// Define a default route
$f3->route('GET /', function() {
    $GLOBALS['controller']->home();
});

// Define a Personal Info route
$f3->route('GET|POST /personal', function() {
    $GLOBALS['controller']->personalInfo();
});

// Define a Profile route
$f3->route('GET|POST /profile', function() {
    $GLOBALS['controller']->profile();
});

// Define a Interests route
$f3->route('GET|POST /interests', function() {
    $GLOBALS['controller']->interests();
});

// Define a results summary route
$f3->route('GET|POST /summary', function() {
    $GLOBALS['dbh']->insertMember();
    $GLOBALS['controller']->summary();
});

// Run fat free
$f3->run();