<?php

require_once("/home2/ngadomsk/config-dating.php");

class Database
{
    //Connection object
    private $_dbh;

    function __construct()
    {
        /*try{
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            echo "Connected";
        }catch (PDOException $e){
            echo $e->getMessage();
        }*/
        $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    }

    function insertMember()
    {
        $memberObj = $_SESSION['member'];

        $sql = "INSERT INTO member VALUES (DEFAULT, :fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium)";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(":fname", $memberObj->getFname());
        $statement->bindParam(":lname", $memberObj->getLname());
        $statement->bindParam(":age", $memberObj->getAge());
        $statement->bindParam(":gender", $memberObj->getGender());
        $statement->bindParam(":phone", $memberObj->getPhone());
        $statement->bindParam(":email", $memberObj->getEmail());
        $statement->bindParam(":state", $memberObj->getState());
        $statement->bindParam(":seeking", $memberObj->getSeeking());
        $statement->bindParam(":bio", $memberObj->getBio());


        if ($_SESSION['premium'] == "premium") {
            $true = 1;
            $false = 0;
            $statement->bindParam(":premium", $true);
        } else {
            $statement->bindParam(":premium", $false);
        }

        $statement->execute();

        if($_SESSION['premium']){
            $inArray = $memberObj->getIndoor();
            $outArray = $memberObj->getOutdoor();
            $id = $this->_dbh->lastInsertId();

            foreach ($inArray as $value) {
                $intId = $this->getInterests($value);
                $this->insertInterest($id, $intId['interest_id']);
            }

            foreach ($outArray as $value) {
                $intId = $this->getInterests($value);
                $this->insertInterest($id, $intId['interest_id']);
            }

        }

    }

    function getMembers()
    {
        $sql = "SELECT * FROM member";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getMember($member_id)
    {
        return $this->_dbh->lastInsertId();
    }

    function getInterests($interest)
    {
        $sql = "SELECT interest_id FROM interests WHERE interest = :activity";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':activity', $interest);

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    function insertInterest($id, $intId)
    {
        $sql = "INSERT INTO member_interest VALUE(:idMember, :idInterest)";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':idInterest', $intId);
        $statement->bindParam(':idMember', $id);

        $statement->execute();
    }
}