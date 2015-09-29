<?php
include(__DIR__.'/config.php'); 

// Get parameters 
$id = isset($_GET['id']) ? $_GET['id'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;
$genre = isset($_GET['genre']) ? $_GET['genre'] : null;
/*// Check that incoming parameters are valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');*/

$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$hits = isset($_GET['hits']) ? $_GET['hits'] : 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$table = new CTable($kittx['database'], 'VMovie', $orderby, $order, $hits, $page, $search, $genre);

$max = $hits ? ceil($table->getRows() / $hits) : 1;


// Do it and store it all in variables in the kittx container.
$kittx['title'] = "Våra filmer";

$kittx['main'] = <<<EOD
<div class='dbtable'>
  {$table->showGenres()}
  {$table->translateToHTML()}
  <div class='pages'>{$table->getPageNavigation($hits, $page, $max)}</div>
  <div class='hits-per-page'>{$table->getHitsPerPage(array(2, 4, 8), $hits)}</div>
</div>
EOD;



if($id != null) {
  $movie = new CMovie('VMovie', $id, $kittx['database']);
  if($movie->isValid()) {
    $kittx['main'] .= <<<EOD
    <div id="movie-info-wrapper">
      <div id="movie-info">
        {$movie->getHTML()}
      </div>
    </div>
EOD;
  }
}

// Finally, leave it all to the rendering phase of kittx.
include(KITTX_THEME_PATH);