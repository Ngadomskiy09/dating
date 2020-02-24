<?php

class Member
{
    private $fname;
    private $lname;
    private $age;
    private $gender;
    private $phone;
    private $email;
    private $state;
    private $seeking;
    private $bio;

    function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    function getFname()
    {
        return $this->_fname;
    }

    function setFname($fname)
    {
        $this->_fname = $fname;
    }

    function getLname()
    {
        return $this->_lname;
    }

    function setLname($lname)
    {
        $this->_lname = $lname;
    }

    function getAge()
    {
        return $this->_age;
    }

    function setAge($age)
    {
        $this->_age =$age;
    }

    function getGender()
    {
        return $this->_gender;
    }

    function setGender($gender)
    {
        $this->_gender = $gender;
    }

    function getPhone()
    {
        return $this->_phone;
    }

    function setPhone($phone)
    {
        $this->_phone = $phone;
    }

}