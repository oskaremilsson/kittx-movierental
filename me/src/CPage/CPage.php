<?php
/**
 * A class to hold a page
 *
 */
 
Class CPage
{
	private $content;
	/**
    * Contructor
    *
    */
    public function __construct($dbArray)
    {
        $this->content = new CContent($dbArray);
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }

    public function grepContent($url)
    {
		$sql = "
			SELECT *
			FROM News
			WHERE
			type = 'page' AND
			url = ? AND
			published <= NOW();
			";
		$this->content->setData($this->content->db->ExecuteSelectQueryAndFetchAll($sql, array($url)));
		return $this->content->getData();
    }
}