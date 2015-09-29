<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults.
include(__DIR__.'/config.php'); 
//$db = new CDatabase($kittx['database']);
$filter = new CTextFilter();
$content = new CBlog($kittx['database']);
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->getAcronym() : null;

if($slug != null){
  $res = $content->grepContent($slug);
}
else {
  $res = $content->grepContentList();
}

if(isset($res[0])) {
  $c = $res[0];
}
else {
  die('Misslyckades: det finns inget innehåll.');
}
$title  = htmlentities($c->title, null, 'UTF-8');
$data   = $filter->doFilter(htmlentities($c->data, null, 'UTF-8'), $c->filter);

// Do it and store it all in variables in the kittX container.
$kittx['title'] = "Nyheter";
$kittx['main'] = "<h1>{$kittx['title']}</h1>";
$kittx['main'] .= "<div id='news-list'>";
if(isset($res[0])) {
  foreach($res as $c) {
    $title  = htmlentities($c->title, null, 'UTF-8');
    $data   = $filter->doFilter(htmlentities($c->data, null, 'UTF-8'), $c->filter);
    $editLink = $acronym ? "<a href='admin.php?news&editNews&id={$c->id}'><img src='img/edit.png' alt='edit'/></a><a href='admin.php?news&deleteNews&id={$c->id}'><img src='img/delete.png' alt='delete' /></a>" : null;
 
    if(!isset($slug))
    {
      $data = substr($data, 0, 80);
      $title = substr($title, 0, 25);

      $kittx['main'] .= <<<EOD
      <section class="news-list-item">
        <article>
        <header>
        <h2><a href='news.php?slug={$c->slug}'>{$title}</a></h2>
        </header>
       <p class='news-publ'>{$c->published}</p>
        <p>{$data}<a href='news.php?slug={$c->slug}'>| Läs mer >></a></p>
        </article>
      </section>
EOD;
    }
    else {
      $kittx['main'] .= <<<EOD
      <section class="news-item-full">
        <article>
        <header>
        <h2>{$title} {$editLink}</h2>
        </header>
        <p class='news-publ'>{$c->published}</p>
        <p class='news-text'>{$data}</p>
        
        <footer>
        <p class="news-back"><a href="?">&lt;&lt; Tillbaka</a></p>
        </footer>
        </article>
      </section>
EOD;
    }
  }
}
else if($slug) {
  $kittx['main'] = "Det fanns inte en sådan bloggpost.";
}
else {
  $kittx['main'] = "Det fanns inga bloggposter.";
}
$kittx['main'] .= "</div>";

 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);