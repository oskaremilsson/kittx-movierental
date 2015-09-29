<?php
/*
* Class for game-logic for the dice-game 100
*
*/
class CDiceGame
{
    /**
    * Properties
    *
    */
    public $die;
    private $sum;
    public $player;
    private $nrOfPlayers;
    
    /**
    * Constructor
    *
    */
    public function __construct($nrOfPlayers = 1)
    {
        $this->die = new CDie();
        $this->sum = 0;
        $this->nrOfPlayers = $nrOfPlayers;
        $this->player = array();
        for($i = 0; $i < $this->nrOfPlayers; $i++)
        {
            $this->player[$i] = new CDicePlayer();
        }
    }
    
    /**
    * Deconstructor
    *
    */
    public function __desctruct()
    {
    }
    
    /**
    * Roll the die
    *
    */
    public function roll()
    {
         $this->die->roll();
         $this->sum += $this->die->getValue();
         return $this->die->getValue();
    }
    
    /**
    * Save the die-value to the temp-sum (when you want to roll again)
    *
    */
    public function addSum()
    {
        $this->sum += $this->die->getValue();
    }
    
    /**
    * Add to the total (when you want to save the score)
    *
    */
    public function addTotal($i)
    {
        $this->player[(int)$i - 1]->setPoints( $this->player[(int)$i-1]->getPoints() + $this->sum ); // -1 to handle the eg. "player 1" to pos 0
        $this->sum = 0;
    }
    
    /**
    * Reset sum (when you get a 1)
    *
    */
    public function resetSum()
    {
        $this->sum = 0;
    }
    
    /**
    * Reset totalSum
    *
    */
    public function resetTotalSum()
    {
        for($i = 0; $i < $this->nrOfPlayers; $i++)
        {
            $this->player[$i]->setPoints(0);
        }
    }
    
    /**
    * Get functions
    *
    */
    public function getSum()
    {
        return $this->sum;
    }
    
    public function getTotalSum($i)
    {
        return $this->player[(int)$i - 1]->getPoints(); // -1 to handle the eg. "player 1" to pos 0
    }
    
    public function getNrOfPlayers()
    {
        return $this->nrOfPlayers;
    }
    
}