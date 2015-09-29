<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
include(__DIR__.'/config.php'); 
// Do it and store it all in variables in the kittX container.
$kittx['title'] = "Välkommen";
$movies = new CTable($kittx['database'], 'VMovie');
$content = new CBlog($kittx['database']);

$latestMovies = $movies->getLatestMovies();
$genreList = $movies->showGenres(true);
$latestNews = "";

$res = $content->grepLatestNews();
if(isset($res[0])) {
	$latestNews = "<div id='news-list'>";
  foreach($res as $c) {
    $title = $c->title;
    $data = $c->data;
    $data = substr($data, 0, 80);
    $title = substr($title, 0, 25);
  	$title  = htmlentities($title, null, 'UTF-8');
    $data   = htmlentities($data, null, 'UTF-8');
    $slug = htmlentities($c->slug, null, 'UTF-8');
      $latestNews .= <<<EOD
      <section class="news-list-item">
        <article>
        <header>
        <h2><a href='news.php?slug={$slug}'>{$title}</a></h2>
        </header>
       <p class='news-publ'>{$c->published}</p>
        <p>{$data}| <a href='news.php?slug={$slug}'>Läs mer >></a></p>
        </article>
      </section>
EOD;
  }
  $latestNews .= "</div>";
}

$kittx['main'] = <<<EOD
{$genreList}
{$latestMovies}
{$latestNews}

<div id="start-hot">
<h2>Hetast just nu / Senast hyrd</h2>
<div class='start-hot-item hottest'><a href='movies.php?id=1'><img src='img/hot.png' alt='hot' /></a></div>
<div class='start-hot-item newly-rented'><a href='movies.php?id=2'><img src='img/latest.png' alt='latest_rented' /></a></div>
</div>
EOD;


// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);
?>