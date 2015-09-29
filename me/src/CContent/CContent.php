<?php
/**
 * A class to hold databaseinfo
 *
 */
 
Class CContent
{
    /**
    * Properties
    *
    */
    public $db;
    private $data;
    
    /**
    * Contructor
    *
    */
    public function __construct($dbArray)
    {
        $this->db = new CDatabase($dbArray);
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }
    
    /**
    * Grep all the content of table
    *
    * @return object, the table-object
    */
    public function grepAllContent()
    {
        $sql = '
            SELECT *, (published <= NOW()) AS available
            FROM News
            ORDER BY published DESC;
            ';
        $this->data = $this->db->ExecuteSelectQueryAndFetchAll($sql);
        return $this->data;
    }

    /**
    * Grep the content of table-item
    *
    * @param string, the ID for the conent to get
    * @return object, the table-item
    */
    public function grepContent($id)
    {
        $sql = 'SELECT * FROM News WHERE id = ?';
        $this->data = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));
        $this->data = $this->data[0];
        return $this->data;
    }

    /**
    * Get a list of all the content of table
    *
    * @return string, html of the list
    */
    public function getContentList()
    {
        self::grepAllContent();
        $html = null;
        $acronym = isset($_SESSION['user']) ? $_SESSION['user']->getAcronym() : null;
        if($acronym) {
            $html .= "<ul class='admin-list'>";
            foreach($this->data AS $key => $val) {
                $title = substr($val->title, 0, 30);
                $html .= "<li><a href='" . self::getUrlToContent($val) . "'>" . htmlentities($title, null, 'UTF-8') . "</a> | ";
                $html .= "<a href='admin.php?news&editNews&id={$val->id}'><img src='img/edit.png' alt='edit'/></a> <a href='admin.php?news&deleteNews&id={$val->id}'><img src='img/delete.png' alt='delete'/></a></li>\n";
            }
            $html .= "</ul>";
        }
        return $html;
    }

    public function updateContent($params)
    {
        $sql = '
          UPDATE News SET
            title   = ?,
            slug    = ?,
            data    = ?,
            filter  = ?,
            updated = NOW()
          WHERE 
            id = ?
        ';
        return $this->db->ExecuteQuery($sql, $params);
    }

    public function deleteContent($id)
    {
        $sql = '
          DELETE FROM News
          WHERE id = ?
        ';
        return $this->db->ExecuteQuery($sql, array($id));
    }

    public function getDbDump()
    {
        return $this->db->Dump();
    }

    public function getDbError()
    {
        return $this->db->ErrorInfo();
    }

    /**
    * Get the Editform
    *
    * @return string, the HTML for an edit-form
    */
    public function getEditForm($id)
    {
        self::grepContent($id);
 
        $url    = htmlentities($this->data->url, null, 'UTF-8');
        $type   = htmlentities($this->data->type, null, 'UTF-8');
        $title  = htmlentities($this->data->title, null, 'UTF-8');
        $data   = htmlentities($this->data->data, null, 'UTF-8');
        $slug   = htmlentities($this->data->slug, null, 'UTF-8');
        $filter = htmlentities($this->data->filter, null, 'UTF-8');
        $published = htmlentities($this->data->published, null, 'UTF-8');

        $form = <<<KITTY
        <form method='post'>
            <input type='hidden' name='id' value='{$id}'/>
            <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
            <p><label>Slug:<br/><input type='text' name='slug' value='{$slug}'/></label></p>
            <p><label>Text:<br/><textarea name='data' rows='20' cols='70'>$data</textarea></label></p>
            <p><label>Filter:<br/><input type='text' name='filter' value='{$filter}'/></label></p>
            <p><input type='submit' name='save' value='Spara'/></p>
        </form>
KITTY;
        return $form;
    }

    /**
    * Get the Addform
    *
    * @return string, the HTML for an add-form
    */
    public function getAddForm()
    {
        $form = <<<KITTY
        <form method='post'>
            <p><label>Titel:<br/><input type='text' name='title' value=''/></label></p>
            <p><label>Slug:<br/><input type='text' name='slug' value=''/></label></p>
            <p><label>Text:<br/><textarea name='data' rows='20' cols='70'></textarea></label></p>
            <p><label>Filter:<br/><input type='text' name='filter' value=''/></label></p>
            <p><input type='submit' name='save' value='Skapa nyhet'/></p>
        </form>
KITTY;
        return $form;
    }

    /**
    * Add new content
    *
    * @param array $params, the parameters
    * @return string, the answer os query.
    */
    public function addContent($params)
    {
        $sql = '
          INSERT INTO News (title, slug, data, type, filter, published, created, url)
          VALUES 
          (?, ?, ?, ?, ?, NOW(), NOW(), null)
          
        ';
        return $this->db->ExecuteQuery($sql, $params);
    }

    /**
    * Create a new content-table
    *
    * @param string $name, the name of table
    * @return string, the answer os query.
    */
    public function createTable($name)
    {
        $sql = "CREATE TABLE {$name}
                (
                  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
                  slug CHAR(80) UNIQUE,
                  url CHAR(80) UNIQUE,
                 
                  type CHAR(80),
                  title VARCHAR(80),
                  data TEXT,
                  filter CHAR(80),
                 
                  published DATETIME,
                  created DATETIME,
                  updated DATETIME,
                  deleted DATETIME
                 
                ) ENGINE INNODB CHARACTER SET utf8;";

        return $this->db->ExecuteQuery($sql);
    }

    /**
    * Get the url to content
    *
    * @param object $content to link to.
    * @return string with url to display content.
    */
    private function getUrlToContent($content) {
        switch($content->type) {
            case 'post': return "news.php?slug={$content->slug}"; break;
            default: return null; break;
        }
    }

    /**
    * SET FUNCTIONS
    */
    /**
    * Set data
    *
    * @param string $data the datatext.
    */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
    * GET FUNCTIONS
    */
    /**
    * Get the Data
    *
    * @return string the $data.
    */
    public function getData()
    {
        return $this->data;
    }
}