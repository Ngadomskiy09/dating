<?php

/**
 * Create Table member
(
member_id int NOT NULL AUTO_INCREMENT,
member_fname VARCHAR(255) NOT NULL,
member_lname VARCHAR(255) NOT NULL,
member_age int(3) NOT NULL,
member_gender CHAR(1),
member_phone VARCHAR (20) NOT NULL,
member_email VARCHAR(255) NOT NULL,
member_state CHAR(2),
member_seeking CHAR(1),
member_bio VARCHAR(255),
member_premium TINYINT(1) NOT NULL,

PRIMARY KEY (member_id)
)

INSERT INTO member VALUES (DEFAULT, "Nick", "Gadomskiy", "30", "M", "2533943445", "ngadomskiy09@gmail.com", "WA", "F", "Just looking", "1")

Create Table interests
(
interest_id int NOT NULL AUTO_INCREMENT,
interest VARCHAR(255),
interest_type CHAR(7),

PRIMARY KEY (interest_id)
)

CREATE Table member_interest
(
member_id int NOT NULL,
interest_id int NOT NULL,

FOREIGN KEY (member_id) REFERENCES member (member_id), FOREIGN key (interest_id) REFERENCES interests (interest_id)
)
 *
 * INSERT INTO interests VALUES
(DEFAULT,'TV','indoor'),(DEFAULT,'Movies','indoor'),
(DEFAULT,'Board Games','indoor'),(DEFAULT,'Cooking','indoor'),
(DEFAULT,'Puzzles','indoor'),(DEFAULT,'Reading','indoor'),
(DEFAULT,'Playing Cards','indoor'),(DEFAULT,'Video Games','indoor'),
(DEFAULT,'Hiking','outdoor'),(DEFAULT,'Biking','outdoor'),
(DEFAULT,'Swimming','outdoor'),(DEFAULT,'Collecting','outdoor'),
(DEFAULT,'Walking','outdoor'),(DEFAULT,'Climbing','outdoor')
 */

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