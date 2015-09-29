<?php
/**
 * A class for the admin-site
 * >:3
 */
Class CAdmin
{
    /**
    * Properties
    *
    */
        private $id;
        private $database_array;

        private $content;
        private $addNews;
        private $editNews;
        private $deleteNews;
        private $type;
        private $title;
        private $slug;
        private $filter;
        private $published;
        private $data;

        private $movies;
        private $addMovie;
        private $editMovie;
        private $deleteMovie;
        private $addImage;
        private $updateRating;
        private $updateAllRating;

        private $director;
        private $plot;
        private $image;
        private $price;
        private $length;
        private $year;
        private $youtubeID;
        private $imdbID;
        private $genres;
        private $imgFileName;

        private $output;
        private $html;
    
    /**
    * Get the AddImageform
    *
    * @param string $mode, type of admin-page
    */
    public function __construct($database_array, $mode) {
        $this->database_array = $database_array;
        $this->id  = isset($_GET['id']) ? $_GET['id'] : null;
        $this->output = null;

        if($mode == "news") {
            self::newsHandler();
        }
        else if($mode == "movie") {
            self::movieHandler();
        }
    }
    
    /**
    * Deconstructor
    *
    */
    public function __destruct() {
    }

    /**
    * Handle the news-admin
    *
    */
    private function newsHandler() {
        $html = null;
        $this->content = new CContent($this->database_array);

        $this->addNews = isset($_GET['addNews'])  ? true : false;
        $this->editNews = isset($_GET['editNews'])  ? true : false;
        $this->deleteNews = isset($_GET['deleteNews'])  ? true : false;

        $this->type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : 'post';
        $this->title  = isset($_POST['title']) ? $_POST['title'] : null;
        $this->slug  = isset($_POST['slug']) ? $_POST['slug'] : null;
        $this->filter  = isset($_POST['filter']) ? $_POST['filter'] : null;
        $this->published  = isset($_POST['published']) ? $_POST['published'] : null;
        $this->data   = isset($_POST['data'])  ? $_POST['data'] : array();

        if(isset($_POST['data'])) {
            self::changeNews();
        }

        //if editNews and an id is given, give the editform
        if($this->id != null and $this->editNews) {
            if(is_numeric($this->id)) //but only if its a number
            {
                $html = $this->content->getEditForm($this->id);
            }
        }
        //if addNews then show the form for it
        else if($this->addNews) {
            $html = $this->content->getAddForm();
        }
        //if deleteNews then delete it
        else if($this->deleteNews) {
            $this->content->deleteContent($this->id);
            $this->output = "Nyhet kastad i papperskorgen";
            $html = "<p><a href='?news&addNews'><img src='img/add.png' alr='add news'/>Skriv nyhet</a></p>
            <p><img src='img/edit.png' alt='edit'/> = ändra 
            <img src='img/delete.png' alt='delete'/> = tabort";
            $html .= $this->content->getContentList();
        }
        else {
            // Put results into a list
            $html = "<p><a href='?news&addNews'><img src='img/add.png' alr='add news'/>Skriv nyhet</a></p>
            <p><img src='img/edit.png' alt='edit'/> = ändra 
            <img src='img/delete.png' alt='delete'/> = tabort";
            $html .= $this->content->getContentList();
        }

        $this->html = <<<EOD
        <p><a href='?movie'>Filmer</a> | <a href='?news'>Nyheter</a></p>
        <p>
        <output>{$this->output}</output>
        </p>
        {$html}
EOD;
    }

    /**
    * Handle the movie-admin
    *
    */
    private function movieHandler() {
        $html = null;
        $this->movies = new CTable($this->database_array, 'movies');

        $this->addMovie = isset($_GET['addMovie'])  ? true : false;
        $this->editMovie = isset($_GET['editMovie'])  ? true : false;
        $this->deleteMovie = isset($_GET['deleteMovie'])  ? true : false;
        $this->addImage = isset($_GET['addImage'])  ? true : false;
        $this->updateRating = isset($_GET['updateRating'])  ? true : false;
        $this->updateAllRating = isset($_GET['updateAllRating'])  ? true : false;
        
        $this->director   = isset($_POST['director']) ? $_POST['director'] : null;
        $this->title  = isset($_POST['title']) ? $_POST['title'] : null;
        $this->plot  = isset($_POST['plot']) ? $_POST['plot'] : null;
        $this->image  = isset($_POST['image']) ? $_POST['image'] : null;
        $this->price  = isset($_POST['price']) ? $_POST['price'] : null;
        $this->length   = isset($_POST['length']) ? $_POST['length'] : null;
        $this->year   = isset($_POST['year']) ? $_POST['year'] : null;
        $this->youtubeID   = isset($_POST['youtubeID']) ? $_POST['youtubeID'] : null;
        $this->imdbID   = isset($_POST['imdbID']) ? $_POST['imdbID'] : null;

        $this->genres  = isset($_POST['genre']) ? $_POST['genre'] : null;
        $this->imgFileName = isset($_FILES["fileToUpload"]["name"]) ? $_FILES["fileToUpload"]["name"] : null; 

        if(isset($_POST['title'])) {
            self::changeMovie();
        }

        if($this->imgFileName != "") {
            $this->output = $this->movies->uploadFile();
        }

        //if editMovie and an id is given, give the editform
        if($this->id != null and $this->editMovie) {
            if(is_numeric($this->id)) //but only if its a number
            {
                $html = $this->movies->getEditForm($this->id);
            }
        }
        //if updateRating make that happen
        else if($this->updateRating && is_numeric($this->id)) {
            if($this->movies->updateRating($this->id)) {
                $this->output = 'Rating uppdaterades';
            }
        }
        //if updateAllRatings makeit happen
        else if($this->updateAllRating) {
            if($this->movies->updateAllRating()) {
                $this->output = 'Rating uppdaterades';
            }
        }
        //if addMovie then show the form for it
        else if($this->addMovie) {
            $html = $this->movies->getAddForm();
        }
        //if addImage then show the form for it
        else if($this->addImage) {
            $html = $this->movies->getAddImageForm();
        }
        //if deleteMovie then delete it
        else if($this->id != null && $this->deleteMovie) {
            $this->movies->deleteMovie($this->id);
            $this->output = "Filmen är kastad i papperskorgen";
            $html = "<p><a href='?movie&addMovie'><img src='img/add.png' alt='add movie'/>Ny film</a> 
            <a href='?movie&addImage'><img src='img/add.png' alt='add image'/>Ladda upp bild</a>
            <a href='?movie&updateAllRating'><img src='img/rating.png' alt='rating'/>Uppdatera alla ratings</a></p>
            <p><img src='img/edit.png' alt='edit'/> = ändra 
            <img src='img/delete.png' alt='delete'/> = tabort 
            <img src='img/rating.png' alt='rating'/> = uppdatera rating</p>";
            $html .= $this->movies->getContentList();
        }
        else {
            $html = "<p><a href='?movie&addMovie'><img src='img/add.png' alt='add movie'/>Ny film</a> 
            <a href='?movie&addImage'><img src='img/add.png' alt='add image'/>Ladda upp bild</a>
            <a href='?movie&updateAllRating'><img src='img/rating.png' alt='rating'/>Uppdatera alla ratings</a></p>
            <p><img src='img/edit.png' alt='edit'/> = ändra 
            <img src='img/delete.png' alt='delete'/> = tabort 
            <img src='img/rating.png' alt='rating'/> = uppdatera rating</p>";
            
            $html .= $this->movies->getContentList();
        }
        $this->html = <<<EOD
        <p><a href='?movie'>Filmer</a> | <a href='?news'>Nyheter</a></p>
        <p>
        <output>{$this->output}</output>
        </p>
        {$html}
EOD;
    }

    /**
    * Change the news accordingly
    *
    */
    private function changeNews() {
        if($this->editNews && is_numeric($this->id)){
        $params = array($this->title, $this->slug, $this->data, $this->filter, $this->id);
        if($this->content->updateContent($params)) {
            $this->output = 'Informationen sparades.';
        }
        }
        else if($this->addNews){
            if($this->slug == "" || $this->slug == null) {
                $this->slug = substr($this->title, 0, 15);
                $this->slug = str_replace(array('å', 'ä', 'ö', ' '), array('a', 'a', 'o', '_'), $this->slug); 
            }
            $params = array($this->title, $this->slug, $this->data, 'post', $this->filter);
            if($this->content->addContent($params)) {
                $this->output = 'Informationen sparades.';
            }
        }
        else {
            $this->output = 'Informationen sparades EJ.<br>';
        }
    }
    /**
    * Change the movie accordingly
    *
    */
    private function changeMovie() {
        if($this->editMovie && is_numeric($this->id)){
            $params = array($this->director, $this->title, $this->plot, $this->image, $this->price, $this->length, $this->year, $this->youtubeID, $this->imdbID, $this->id);
            if($this->movies->updateMovie($params)) {
                if($this->movies->updateMovieGenre($this->id, $this->genres))
                $this->output = 'Filmen uppdaterades';
            }
        }
        else if($this->addMovie){
            $params = array($this->director, $this->title, $this->plot, $this->imgFileName, $this->price, $this->length, $this->year, $this->youtubeID, $this->imdbID);
            if($this->movies->addMovie($params)) {
                $this->output .= 'Filmen skapades';
            }
        }
        else {
            $this->output = 'Informationen sparades ej.<br>';
        }
    }

    /**
    * Get HTML to show
    *
    * @return string $html, html to show
    */
    public function getHTML(){
        return $this->html;
    }
    

}