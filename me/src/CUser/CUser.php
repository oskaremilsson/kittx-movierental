<?php
/**
 * A class to hold a User
 */
 
Class CUser
{
    /**
    * Properties
    *
    */
    private $acronym;
    private $name;
    private $status;
    
    /**
    * Contructor
    *
    */
    public function __construct()
    {
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }

    public function login($dbArray, $acronym, $password)
    {
        $db = new CDatabase($dbArray);
        $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
        $res = $db->ExecuteSelectQueryAndFetch($sql, array($acronym, $password));
        if(!empty($res)) {
            $this->status = true;
            $this->name = $res->name;
            $this->acronym = $acronym;
        }
        return $this->status;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $this->status = false;
        return $this->status;
    }
    
    /**
    * Get-functions
    *
    */
    
    public function getName()
    {
        return $this->name;
    }
    public function getAcronym()
    {
        return $this->acronym;
    }
    public function getStatus()
    {
        return $this->status;
    }
}