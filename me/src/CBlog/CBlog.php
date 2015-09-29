<?php
/**
 * A class to hold a blog
 *
 */
 
Class CBlog
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

    public function grepContent($slug)
    {
		$slugSql = $slug ? 'slug = ?' : '1';
        $sql = "
            SELECT *
            FROM News
            WHERE
            type = 'post' AND
            $slugSql AND
            published <= NOW();
            ";
		$this->content->setData($this->content->db->ExecuteSelectQueryAndFetchAll($sql, array($slug)));
		return $this->content->getData();
    }

    public function grepContentList()
    {
        $sql = "
            SELECT *
            FROM News
            WHERE
            type = 'post' AND
            published <= NOW()
            ORDER BY published DESC;
            ";
        $this->content->setData($this->content->db->ExecuteSelectQueryAndFetchAll($sql));
        return $this->content->getData();
    }
    public function grepLatestNews()
    {
        $sql = "
            SELECT *
            FROM News
            WHERE
            type = 'post' AND
            published <= NOW()
            ORDER BY published DESC
            LIMIT 3;
            ";
        $this->content->setData($this->content->db->ExecuteSelectQueryAndFetchAll($sql));
        return $this->content->getData();
    }
}