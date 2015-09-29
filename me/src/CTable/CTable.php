<?php
/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CTable {

	/**
	* Members
	*/
		private $hits;
		private $page;
		private $orderby;
		private $order;
		private $rows;
		private $htmlTable;
		private $res;
		private $db;
    /**
    * Constructor
    *
    */
    public function __construct($database_array, $tablename, $orderby='id', $order=null, $hits=null, $page=null, $search=null, $genre=null)
    {
		// Connect to a MySQL database using PHP PDO
    	$this->db = new CDatabase($database_array);

    	// Prepare the query based on incoming arguments
		$sqlOrig  = "SELECT * FROM {$tablename}";
		$where    = null;
		$groupby  = ' GROUP BY id';
		$limit    = null;
		$sort     = " ORDER BY {$orderby} {$order}";
		$params   = array();

		// Select by searchwords
		if($search) {
		  $where .= ' AND director LIKE ? OR title LIKE ?';
		  $params[] = "%".$search."%";
		  $params[] .= "%".$search."%";
		} 

		if($genre) {
			$where .= " AND genre LIKE '%{$genre}%'";
		}

		// Pagination
		if($hits && $page) {
		  $limit = " LIMIT $hits OFFSET " . (($page - 1) * $hits);
		}

		// Complete the sql statement
		$where = $where ? " WHERE 1 {$where}" : null;
		$sql = $sqlOrig . $where . $groupby . $sort . $limit;
		$this->res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);


		self::getMaxRows($sqlOrig, $where, $groupby, $params);
    }

	/**
	* Use the current querystring as base, modify it according to $options and return the modified query string.
	*
	* @param array $options to set/change.
	* @param string $prepend this to the resulting query string
	* @return string with an updated query string.
	*/
	private function getQueryString($options=array(), $prepend='?') {
		// parse query string into array
		$query = array();
		parse_str($_SERVER['QUERY_STRING'], $query);

		// Modify the existing query string with new options
		$query = array_merge($query, $options);

		// Return the modified querystring
		return $prepend . htmlentities(http_build_query($query));
	}

	/**
	* Create links for hits per page.
	*
	* @param array $hits a list of hits-options to display.
	* @param array $current value.
	* @return string as a link to this page.
	*/
	public function getHitsPerPage($hits, $current=null) {
		$nav = "<p class='list-hits-per-page'>Visa ";
		foreach($hits AS $val) {
			if($current == $val) {
				$nav .= "$val ";
			}
			else {
				$nav .= "<a href='" . self::getQueryString(array('hits' => $val, 'page' => 1)) . "'>$val</a> ";
			}
		}
		$nav .= "<a href='" . self::getQueryString(array('hits' => $this->rows, 'page' => 1)) . "'>Alla</a>";
		return $nav;
	}

	/**
	* Create navigation among pages.
	*
	* @param integer $hits per page.
	* @param integer $page current page.
	* @param integer $max number of pages. 
	* @param integer $min is the first page number, usually 0 or 1. 
	* @return string as a link to this page.
	*/
	public function getPageNavigation($hits, $page, $max=1, $min=1) {
		$nav  = ($page != $min) ? "<a href='" . self::getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> " : '&lt;&lt; ';
		$nav .= ($page > $min) ? "<a href='" . self::getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> " : '&lt; ';

		for($i=$min; $i<=$max; $i++) {
			if($page == $i) {
				$nav .= "$i ";
			}
			else {
				$nav .= "<a href='" . self::getQueryString(array('page' => $i)) . "'>$i</a> ";
			}
		}

		$nav .= ($page < $max) ? "<a href='" . self::getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> " : '&gt; ';
		$nav .= ($page != $max) ? "<a href='" . self::getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> " : '&gt;&gt; ';
		return $nav;
	}

	/**
	* Function to create links for sorting
	*
	* @param string $column the name of the database column to sort by
	* @return string with links to order by column.
	*/
	public function orderby($column) {
		$nav  = "<a href='" . self::getQueryString(array('orderby'=>$column, 'order'=>'desc')) . "'>&darr;</a>";
		$nav .= "<a href='" . self::getQueryString(array('orderby'=>$column, 'order'=>'asc')) . "'>&uarr;</a>";
		return "<span class='orderby'>" . $nav . "</span>";
	}

	/**
	* Get max pages for current query, for nav
	*
	* @param string $sqlOrig, the base of SQL-statement
	* @param string $where, wherestatement
	* @param string $groupby, groupbystatement
	* @param array $params, the parameters
	* @return int the num of rows.
	*/
	public function getMaxRows($sqlOrig, $where, $groupby, $params=array())
	{
		$sql = "
		  SELECT
		    COUNT(id) AS rows
		  FROM 
		  (
		    {$sqlOrig} {$where} {$groupby}
		  ) AS Tables
		";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
		$this->rows = $res[0]->rows;
		return $res[0]->rows;
	}

	/**
	* Get rows-count
	*
	* @return int the num of rows.
	*/
	public function getRows()
	{
		return $this->rows;
	}

	/**
	* Get the HTML-code for listview
	*
	* @return the HTML for movie-list.
	*/
	public function translateToHTML()
	{
		$html = "<div id='listview'><p class='list-sort'>Titel " . self::orderby('title') . " | År " . self::orderby('year') . " | Längd " . self::orderby('length') . " | Regissör " . self::orderby('director') . " | Pris " . self::orderby('price');
		foreach($this->res AS $key => $val) {
			$title = substr($val->title, 0, 15);
			$image = $val->image;
			if($image == null) {
				$image = "no-img";
			}
			$html .= "<div class='list-item'>";
			$html .= "<p class='list-title'><a href='" . self::getQueryString(array('id'=> $val->id)) . "'>{$title}</a></p>";
			$html .= "<a href='" . self::getQueryString(array('id'=> $val->id)) . "'><img src='img.php?src=movies/{$image}&amp;width=200&amp;height=325&amp;crop-to-fit' alt='{$image}'/></a>";
			$html .= "<p class='list-info'>{$val->length} min | <span class='red'>{$val->year}</span> | {$val->price}kr";
			$html .= "</div>";
		}
		if($this->res == NULL) {
			$html .= "<p class='list-nomatch'>Du har tydligare en speciell smak för film. Vi kunde inte hitta det du sökte efter.</p><p class='list-nomatch'><a href='".self::getQueryString(array('genre'=> '', 'search'=> ''))."'>Visa alla filmer</a></p>";
		}
		$html .= "</div>";
		return $html;
	}

	/**
	* Get the HTML-code for table
	*
	* @return the genres as html.
	*/
	public function showGenres($start=null)
	{
		$html = "<div id='genre-list'><p><span class='genre-spacer'>|</span> ";
		$sql = "SELECT * FROM Genre";
		$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
		foreach($res AS $key => $val) {
			if($start) {
				$html .= "<a href='movies.php?genre={$val->name}'>" . $val->name . "</a> <span class='genre-spacer'>|</span> ";
			}
			else {
				$html .= "<a href='" . self::getQueryString(array('genre'=>$val->name, 'page'=>1)) . "'>" . $val->name . "</a> <span class='genre-spacer'>|</span> ";
			}
		}
		$html .= "<p></div>";
		return $html;
	}

    /**
    * Grep all the content of table
    *
    */
    public function grepAllContent()
    {
        $sql = '
            SELECT *
            FROM movies;
            ';
        $this->res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
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
            foreach($this->res AS $key => $val) {
                $html .= "<li><a href='movies.php?id={$val->id}'>" . htmlentities($val->title, null, 'UTF-8') . "</a> | ";
                $html .= "<a href='admin.php?movie&amp;editMovie&id={$val->id}'>
                <img src='img/edit.png' alt='edit'/></a> 
                <a href='admin.php?movie&amp;deleteMovie&amp;id={$val->id}'>
                <img src='img/delete.png' alt='delete'/></a>
                <a href='admin.php?movie&amp;updateRating&amp;id={$val->id}'>
                <img src='img/rating.png' alt='rating'/></a>
                </li>\n";
            }
            $html .= "</ul>";
        }
        return $html;
    }

    /**
    * Grep the content of table-item
    *
    * @param string, the ID for the conent to get
    * @return object, the table-item
    */
    public function grepContent($id)
    {
        $sql = 'SELECT * FROM movies WHERE id = ?';
        $this->res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));
        $this->res = $this->res[0];
        return $this->res;
    }

	public function updateMovie($params)
    {
        $sql = '
          UPDATE movies SET
            director   = ?,
            title    = ?,
            plot    = ?,
            image  = ?,
            price = ?,
            length = ?,
            year = ?,
            youtubeID = ?,
            imdbID = ?,
            updated = NOW()
          WHERE 
            id = ?
        ';
        return $this->db->ExecuteQuery($sql, $params);
    }

    public function deleteMovie($id)
    {
        $sql = "
          DELETE FROM Movie2Genre
          WHERE idMovie = ?;
          DELETE FROM movies
          WHERE id = ?
        ";
        return $this->db->ExecuteQuery($sql, array($id, $id));
    }

    /**
    * Add new movie
    *
    * @param array $params, the parameters
    * @return string, the answer of query.
    */
    public function addMovie($params)
    {
        $sql = '
          INSERT INTO movies(director, title, plot, image, price, length, year, youtubeID, imdbID, updated)
          VALUES 
          (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ';
        return $this->db->ExecuteQuery($sql, $params);
    }

   	/**
    * Update the genres
    *
    * @param array $genres, the array of genres
    * @return string, the answer of query.
    */
    public function updateMovieGenre($idMovie, $genres)
    {
    	$sql = "
    		DELETE FROM Movie2Genre
    		WHERE
    		idMovie = {$idMovie}
    	";
    	$this->db->ExecuteQuery($sql);

    	$sql = '
    		INSERT INTO Movie2Genre(idMovie, idGenre)
    		VALUES 
    	';

    	for($i = 0; $i < count($genres); $i++) {
    		$sql .= "({$idMovie}, {$genres[$i]}), ";
    	}
    	$sql = substr($sql, 0, -2);
    	$this->db->ExecuteQuery($sql);
	}

    /**
    * Get the Editform
    *
    * @return string, the HTML for an edit-form
    */
    public function getEditForm($id)
    {
        self::grepContent($id);
 
        $director = htmlentities($this->res->director, null, 'UTF-8');
		$title = htmlentities($this->res->title, null, 'UTF-8');
		$plot = htmlentities($this->res->plot, null, 'UTF-8');
		$image = htmlentities($this->res->image, null, 'UTF-8');
		$price = htmlentities($this->res->price, null, 'UTF-8');
		$length = htmlentities($this->res->length, null, 'UTF-8');
		$year = htmlentities($this->res->year, null, 'UTF-8');
		$youtubeID = htmlentities($this->res->youtubeID, null, 'UTF-8');
		$imdbID = htmlentities($this->res->imdbID, null, 'UTF-8');

		//code to make the checkboxes from the genres
		$sql = "SELECT * FROM Genre";
		$genres = $this->db->ExecuteSelectQueryAndFetchAll($sql);

		//get the movies genres form the view
		$sql = "SELECT genre FROM VMovie WHERE id = {$id}";
		$movieGenres = $this->db->ExecuteSelectQueryAndFetchAll($sql);
		$movieGenres = explode(",", $movieGenres[0]->genre);
		$count = 0;
		$checkbox = "<p>";
		foreach($genres AS $key => $val) {
			if($count == 2)
			{
				$checkbox .= "</p><p>";
				$count = 0;
			}
			if(in_array($val->name, $movieGenres)) {
				$checkbox .= "<input type='checkbox' name='genre[]' value='{$val->id}' checked='checked' /><span style='color:#277413;'>{$val->name}</span>";
			}
			else {
				$checkbox .= "<input type='checkbox' name='genre[]' value='{$val->id}' />{$val->name}";
			}
			$count++;
		}
		$checkbox .= "</p>";

		//code to make the dropdown for images-choser
		$dir = scandir('img/movies');

		$dropdown = "<select name='image'>";
		foreach ($dir as $key => $file) {
			$type = explode('.', $file)[1];
			if($type == 'jpg') {
				if($image == $file) {
					$dropdown .= "<option value='{$file}' selected>{$file}</option>";
				}
				else {
					$dropdown .= "<option value='{$file}'>{$file}</option>";
				}
				
			}
		}
		$dropdown .= "</select>";	

        $form = <<<KITTY
        <form method='post'>
            <input type='hidden' name='id' value='{$id}'/>
            <p><label>Regissör:<br/><input type='text' name='director' value='{$director}'/></label></p>
            <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
            <p><label>År:<br/><input type='text' name='year' value='{$year}'/></label></p>
            <p><label>Beskrivning:<br/><textarea name='plot' rows='5' cols='50'>{$plot}</textarea></label></p>
            <p><label>Bild:<br/>{$dropdown}</label></p>
            <p><label>Pris:<br/><input type='text' name='price' value='{$price}'/></label></p>
            <p><label>Längd:<br/><input type='text' name='length' value='{$length}'/></label></p>
            <p><label>Youtube-ID:<br/><input type='text' name='youtubeID' value='{$youtubeID}'/></label></p>
            <p><label>IMDB-ID:<br/><input type='text' name='imdbID' value='{$imdbID}'/></label></p>
            {$checkbox}
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
        <form method='post' enctype="multipart/form-data">
            <p><label>Regissör:<br/><input type='text' name='director' value=''/></label></p>
            <p><label>Titel:<br/><input type='text' name='title' value=''/></label></p>
            <p><label>År:<br/><input type='text' name='year' value=''/></label></p>
            <p><label>Beskrivning:<br/><textarea name='plot' rows='5' cols='50'></textarea></label></p>
            <p><label>Bild:<br/><input type="file" name="fileToUpload" /></label></p>
            <p><label>Pris:<br/><input type='text' name='price' value=''/></label></p>
            <p><label>Längd:<br/><input type='text' name='length' value=''/></label></p>
            <p><label>Youtube-ID:<br/><input type='text' name='youtubeID' value=''/></label></p>
            <p><label>IMDB-ID:<br/><input type='text' name='imdbID' value=''/></label></p>
            <p><input type='submit' name='save' value='Spara'/></p>
        </form>
KITTY;
        return $form;
    }
    /**
    * Get the AddImageform
    *
    * @return string, the HTML for an addImage-form
    */
    public function getAddImageForm()
    {
        $form = <<<KITTY
        <form method='post' enctype="multipart/form-data">
            <p><label>Bild:<br/><input type="file" name="fileToUpload" /></label></p>
            <p><input type='submit' name='save' value='Spara'/></p>
        </form>
KITTY;
        return $form;
    }

    /**
    * Upload movie-image
    *
    * @return string, the name of the file
    */
    public function uploadFile()
    {
    	$output = null;
    	$target_dir = KITTX_INSTALL_PATH . "/webroot/img/movies/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$ok = 1;
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check == false) {
		        $output = "File is not an image.";
		        $ok = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    $output = "Sorry, file already exists.";
		    $ok = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    $output = "Sorry, your file is too large.";
		    $ok = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg") {
		    $output = "Sorry, only JPG is allowed.";
		    $ok = 0;
		}
		// if everything is ok, try to upload file
		if($ok) {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        $output = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        $output = "Sorry, there was an error uploading your file.";
		    }
		}
		return $output;
    }

    /**
    * Get the lastest movies
    *
    * @return string, HTML to present the movies
    */
    public function getLatestMovies()
    {
    	$sql = 'SELECT * FROM VMovie ORDER BY updated DESC LIMIT 3';
		$this->res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
		$count = 0;
		$html = "<div id='start-latest-list'><h2>Nya filmer</h2>";
		foreach($this->res AS $key => $val) {
			$image = $val->image;
			if($image == null) {
				$image = "no-img";
			}
			if($count == 0) {
				$html .= "<div class='start-latest-top'><a href='movies.php?id={$val->id}'><p>{$val->title}</p></a><a href='movies.php?id={$val->id}'><img src='img.php?src=movies/{$image}&amp;width=950&amp;height=200&amp;crop-to-fit' alt='{$image}' /></a></div>";
				$count++;
			}
			else {
				$html .= "<div class='start-latest-bot'><a href='movies.php?id={$val->id}'><p>{$val->title}</p></a><a href='movies.php?id={$val->id}'><img src='img.php?src=movies/{$image}&amp;width=475&amp;height=200&amp;crop-to-fit' alt='{$image}' /></a></div>";
			}
		}
		$html .= "</div>";
		return $html;
    }

    /**
    * Get rating
    *
    * @param string $imdbID - the id for the imdb-page
    * @return rating from imdb
    */
    public function getRating($imdbID) {
    	//get the html returned from imdb
		$html = file_get_contents('http://imdb.com/title/' . $imdbID); 

		// fint the place in the html for rating and return it
		return substr($html, strpos($html, 'titlePageSprite star-box-giga-star') + 37, 3);
    }

    /**
    * Update rating
    *
    * @param string $id - the id for the movie to update
    * @return answer from db.
    */
    public function updateRating($id) {
    	//get the imdb-id for movie
    	$sql = 'SELECT imdbID from VMovie WHERE id = ?';
    	$res = $this->db->ExecuteSelectQueryAndFetch($sql, array($id));

    	$rating = "?";
    	$rating = self::getRating($res->imdbID);

    	$sql = 'UPDATE movies
    			SET rating = ?
    			WHERE id = ?';
    	return $this->db->ExecuteQuery($sql, array($rating, $id));	
    }

    /**
    * Update All rating
    *
    * @return answer from db.
    */
    public function updateAllRating() {
    	//get the id for all movies
    	$ids = array();
    	$rating = "?";
    	$sql = 'SELECT id, imdbID from VMovie';
    	$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
    	$sql = 'UPDATE movies
    			SET rating = CASE id';
    	foreach($res AS $key => $val) {
    		array_push($ids, $val->id);
    		if($val->imdbID != "" && $val->imdbID != null) {
    			$rating = self::getRating($val->imdbID);
    		}
    		$sql .= " WHEN {$val->id} THEN '{$rating}'
    		";
    	}
    	$sql .= ' END 
    	WHERE id IN(';
    	foreach($ids AS $id) {
    		$sql .= $id . ',';
    	}
    	//delete the last comma
    	$sql = substr($sql, 0, -1);
    	$sql .= ');';
		return $this->db->ExecuteQuery($sql);
    }

}