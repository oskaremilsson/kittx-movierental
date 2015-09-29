<?php
/**
* Class for a player to the dice game
*
*/
class CDicePlayer
{
    /**
    * Properties
    *
    */
    private $points;
    
    /**
    * Constructor
    *
    */
    public function __construct()
    {
        $this->points = 0;
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }
    
    /**
    * Get functions
    *
    */
    public function getPoints()
    {
        return $this->points;
    }
    
    /**
    * Set functions
    *
    */
    public function setPoints($points)
    {
        $this->points = $points;
    }
}