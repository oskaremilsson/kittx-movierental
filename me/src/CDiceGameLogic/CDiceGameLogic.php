<?php
/*
* Module for game logic
*
*/

class CDiceGameLogic
{
    /**
    * Properties
    *
    */
    private $game;
    private $html;
    private $activePlayer;
    
    /**
    * Constructor
    *
    */
    public function __construct()
    {
        $this->html = "";
        $this->activePlayer = 1;
        $this->game = new CDiceGame();
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }
    
    /**
    * Function to handle sessions
    *
    */
    private function handleSession()
    {
        if(isset($_SESSION['dicegame']))
        {
            $this->game = $_SESSION['dicegame'];
            if(isset($_GET['nrOfPlayers']))
            {
                if((int)$_GET['nrOfPlayers'] != $this->game->getNrOfPlayers())
                {
                    $this->game = new CDiceGame((int)$_GET['nrOfPlayers']);
                    $_SESSION['dicegame'] = $this->game;
                }
            }
        }
        else
        {
            if(isset($_GET['nrOfPlayers']))
            {
                $this->game = new CDiceGame((int)$_GET['nrOfPlayers']);
            }
            $_SESSION['dicegame'] = $this->game;
        }
    }

    /**
    * Function to handle the different gamestates available.
    *
    */
    private function handleGameStates()
    {
        if(isset($_GET['player']))
        {
            $this->activePlayer = (int)$_GET['player'];
        }

        if(isset($_GET['roll']))
        {
            if($this->game->roll() == 1)
            {
                $this->game->resetSum();
            }
        }
        else if(isset($_GET['save']))
        {
            if($this->activePlayer > 1)
            {
                $this->game->addTotal($this->activePlayer - 1); //has to be -1 since the player who saved is not the activePlayer when this is called
            }
            else if($this->activePlayer == 1)
            {
                $this->game->addTotal(($this->game->getNrOfPlayers())); //and is its player one, you cant put it as -1, but at the last player
            }
        }
        else if(isset($_GET['reset']))
        {
            $this->game->resetTotalSum();
            $this->game->resetSum();
            session_destroy();
        }
        
    }

    private function checkWinner($maxPoints)
    {
        $winner = -1;
        for($i = 0; $i < $this->game->getNrOfPlayers(); $i++)
        {
            if($this->game->player[$i]->getPoints() >= $maxPoints)
            {
                $winner = $i;
            }
        }
        return $winner;
    }

    public function view()
    {
        session_name('dicegame');

        self::handleSession();
        self::handleGameStates();
        $winner = self::checkWinner(100);

        if($winner != -1)
        {
            $this->html .= "<p class='text'>Grattis! Ange kod: D1C3G4M3 i kassan för att få din fria hyrning (max 99kr)</p>";
            $this->html .= "<p class='text'><a href='?p=dice&amp;reset'>Spela igen?</a></p>";
        }
        
        else
        {
            if($this->game->getNrOfPlayers() < 2)
            {
                $this->html .= "<p class='text'><a href='?p=dice&amp;roll&amp;nrOfPlayers=" . $this->game->getNrOfPlayers() . "'>Kasta tärningen</a> | <a href='?p=dice&amp;save'>Spara summan(" . $this->game->getSum() . ")</a> | ";
            }
            else
            {
                $this->html .= "<p class='text'><a href='?p=dice&amp;roll&amp;nrOfPlayers=" . $this->game->getNrOfPlayers() . "&amp;player=" . $this->activePlayer . "'>Kasta tärningen</a> | <a href='?p=dice&amp;save&amp;nrOfPlayers=" . $this->game->getNrOfPlayers() . "&amp;player=";
                if($this->activePlayer < $this->game->getNrOfPlayers()) //if the current player is not the last player
                {
                    $this->html .= ($this->activePlayer + 1); //link to the next player
                }
                else
                {
                    $this->html .= 1; //link to player one
                }
                $this->html .= "'>Spara summan(" . $this->game->getSum() . ")</a> | ";
            }
            $this->html .= "<a href='?p=dice&amp;reset'>Börja om</a></p>";
            
            $this->html .= "<div class='dice dice-{$this->game->die->getValue()}'></div>";
            //$this->html .= "<p class='text'>Spelare " . $this->activePlayer . "</p>";
            $this->html .= "<p class='text'>Osparade poäng: " . $this->game->getSum() . "</p>";
            $this->html .= "<p class='text'>Poäng: " . $this->game->getTotalSum(1) . "</p>";
            /*
            $this->html .= "<ul>";
            for($i = 0; $i < $this->game->getNrOfPlayers(); $i++)
            {
                $this->html .= "<li>Spelare " . ($i + 1). ": " . $this->game->getTotalSum($i + 1) . "</li>";
            }
            $this->html .= "</ul>";
            
            $this->html .= "<p class='text'><a href='?p=dice&amp;reset'>Spela ensam :(</a> | <a href='?p=dice&amp;reset&amp;nrOfPlayers=2'>Spela 2 personer</a> | <a href='?p=dice&amp;reset&amp;nrOfPlayers=4'>Spela 4 Personer</a></p>";
            */
        }
        return $this->html;
    }
}