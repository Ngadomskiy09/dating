<?php

class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    function getIndoor()
    {
        return $this->_inDoorInterests;
    }

    function setIndoor($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    function getOutdoor()
    {
        return $this->_outDoorInterests;
    }

    function setOutdoor($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }
}