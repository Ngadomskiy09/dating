<?php

class Routes
{
    private $_f3;
    private $_dbh;

    function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_dbh = new Database();
    }

    function home()
    {
        $views = new Template();
        echo $views->render("views/home.html");
    }

    function personalInfo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get Data from form
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $premium = $_POST['premium'];

            // Add data to hive
            $this->_f3->set('fname', $fname);
            $this->_f3->set('lname', $lname);
            $this->_f3->set('age', $age);
            $this->_f3->set('gender', $gender);
            $this->_f3->set('phone', $phone);
            $this->_f3->set('premium', $premium);

            if (validPersonal()) {
                // Write data to session
                $_SESSION['fname'] = $fname;
                $_SESSION['lname'] = $lname;
                $_SESSION['age'] = $age;
                $_SESSION['gender'] = $gender;
                $_SESSION['phone'] = $phone;
                $_SESSION['premium'] = $_POST["premium"];
                if ($_POST['premium'] == "premium") {
                    $_SESSION['member'] = new PremiumMember($_POST['fname'], $_POST['lname'], $_POST['age'],
                    $_POST['gender'], $_POST['phone']);
                } else {
                    $_SESSION['member'] = new Member($_POST['fname'], $_POST['lname'], $_POST['age'],
                        $_POST['gender'], $_POST['phone']);
                }

                //Redirect to profile.html
                $this->_f3->reroute('/profile');
            }

        }
        $views = new Template();
        echo $views->render("views/personal_information.html");
    }

    function profile()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $state = $_POST['state'];
            $seeking = $_POST['seeking'];
            $bio = $_POST['bio'];

            $this->_f3->set('email', $email);
            $this->_f3->set('location', $state);
            $this->_f3->set('seeking', $seeking);
            $this->_f3->set('bio', $bio);

            if(validProfile()) {
                $_SESSION['member']->setEmail($email);
                $_SESSION['member']->setState($state);
                $_SESSION['member']->setSeeking($seeking);
                $_SESSION['member']->setBio($bio);


                //Redirect to interests.html if premium user is selected
                if ($_SESSION['premium'] == "premium") {
                    $this->_f3->reroute('/interests');
                } else {
                    $this->_f3->reroute('/summary');
                }
            }
        }
        $views = new Template();
        echo $views->render("views/profile.html");
    }

    function interests()
    {
        $indoorSelected = array();
        $outdoorSelected = array();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (!empty($_POST['indoor']))
                $indoorSelected = $_POST['indoor'];

            if (!empty($_POST['outdoor']))
                $outdoorSelected = $_POST['outdoor'];

            $this->_f3->set('indoorSelected', $indoorSelected);
            $this->_f3->set('outdoorSelected', $outdoorSelected);

            if (validInterests()) {
                $_SESSION['member']->setIndoor($indoorSelected);
                $_SESSION['member']->setOutdoor($outdoorSelected);

                //Redirect to Summary
                $this->_f3->reroute('/summary');
            }
        }

        $views = new Template();
        echo $views->render("views/interests.html");
    }

    function summary()
    {
        $this->_dbh->insertMember();
        $views = new Template();
        echo $views->render("views/summary.html");
    }

    function admin()
    {
        $this->_f3->set('memberInfo', $this->_dbh->getMembers());
        $this->_f3->set('interests', new interest($this->_f3, $this->_dbh));

        $views = new Template();
        echo $views->render("views/admin.html");
    }

}