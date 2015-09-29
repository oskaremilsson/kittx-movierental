<?php
/**
 * A class to show movie-info from a movie
 * >:3
 */
 
Class CMovie
{
    /**
    * Properties
    *
    */
    private $res;
    private $db;
    
    /**
    * construct the module
    *
    * @param array $databse_array, the login-array for databse.
    * @param string $tablename, name for the table to use
    * @param int $id, the id for the movie
    */
    public function __construct($tablename, $id, $database_array)
    {
        // Connect to a MySQL database using PHP PDO
        $this->db = new CDatabase($database_array);
        // Prepare the query based on incoming arguments
        $sqlOrig  = "SELECT * FROM {$tablename}";
        // Complete the sql statement
        $where = " WHERE id = {$id}";
        $sql = $sqlOrig . $where;
        $this->res = $this->db->ExecuteSelectQueryAndFetch($sql);
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct()
    {
    }
    
    /**
    * construct the module
    *
    * @return string, html for the info
    */
    public function getHTML()
    {
        $html = "";
        if($this->res){
            $movie = $this->res; //just to save some chars when typing the html.. :)
            $id_link = self::getQueryString(array('id'=> '')); //länk för stäng-knappen (tar bort id-taggen)
            $dir_link = self::getQueryString(array('search'=> $movie->director, 'id'=> ''));

            $image = $movie->image;
            if($image == null) {
                $image = "no-img";
            }

            $html = <<<EOD
            <div id="info-head">
                <img src="img.php?src=movies/{$image}&amp;width=800&amp;height=200&amp;crop-to-fit" alt='{$image}'/>
                <div id="close-info"><a href="{$id_link}">Stäng</a></div>
                <div id="info-imbd-link"><a href="http://imdb.com/title/{$movie->imdbID}" target="_blank"><img src="img/imdb.png" width="100" height="50" alt="imbd-logo" /></a></div>
            </div>
            <p class="info-title">{$movie->title}</p>
            
            <p class="info-info">{$movie->rating}/10 | {$movie->length} min | <a href="movies.php{$dir_link}">{$movie->director}</a> | Pris: {$movie->price}kr</p>
            <p class="info-genre">{$movie->genre}</p>
            <p class="info-plot">{$movie->plot}</p>
            <iframe style="margin-left: 120px; width: 560px; height: 315px; border: none;" src="//www.youtube.com/embed/{$movie->youtubeID}" allowfullscreen></iframe>

        
EOD;
        }
        return $html;
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
    * Check if movie-info is available
    *
    * @return boolean 
    */
    public function isValid(){
        $bool = false;
        if($this->res) {
            $bool = true;
        }
        return $bool;
    }
}