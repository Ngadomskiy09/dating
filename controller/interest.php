<?php

class Interest
{
    private $_f3;
    private $_db;

    function __construct($f3, $db)
    {
        $this->_f3 = $f3;
        $this->_db = $db;
    }

    function viewAll($id)
    {
        $temp = $this->_db->getMemberInterest($id);
        $arr = array();

        foreach($temp as $person) {
            foreach($person as $item) {
                $arr[] =  $item;
            }
        }
        return implode(", ", $arr);
    }
}