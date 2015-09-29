<?php
/**
 * A class to hold a Die
 *
 */
 
Class CDie
{
    /**
    * Properties
    *
    */
    private $value;
    private $faces;
    
    /**
    * Contructor
    *
    */
    public function __construct($faces=6)
    {
        $this->value = 0;
        $this->faces = $faces;
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }
    
    /**
    * Roll the die the given times
    *
    */
    public function roll()
    {
        $this->value = rand(1, $this->faces);
        return $this->value;
    }
    
    /**
    * Get-functions
    *
    */
    
    public function getValue()
    {
        return $this->value;
    }
}