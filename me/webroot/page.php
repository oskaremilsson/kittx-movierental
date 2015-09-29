<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults.
include(__DIR__.'/config.php');
$db = new CDatabase($kittx['database']);
$filter = new CTextFilter();
$content = new CPage($kittx['database']);
$url = isset($_GET['url']) ? $_GET['url'] : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->getAcronym() : null;

if(isset($content->grepContent($url)[0])) {
  $c = $content->grepContent($url)[0];
}
else {
  die('Misslyckades: det finns inget innehåll.');
}
$title  = htmlentities($c->title, null, 'UTF-8');
$data   = $filter->doFilter(htmlentities($c->data, null, 'UTF-8'), $c->filter);

// Do it and store it all in variables in the kittX container.
$kittx['title'] = $title;
$editLink = $acronym ? "<a href='edit.php?id={$c->id}'>Uppdatera sidan</a>" : null;
 
$kittx['main'] = <<<EOD
<article>
<header><h1>{$kittx['title']}</h1></header>

{$data}

<footer>
{$editLink}
</footer
EOD;
 

 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);