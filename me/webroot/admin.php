<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults.
include(__DIR__.'/config.php'); 
$kittx['title'] = "Admin";
$output = null;
$form = null;

$acronym = isset($_SESSION['user']) ? $_SESSION['user']->getAcronym() : null;
// Check if logged in
!empty($acronym) or die('Check: You need to login');

$news = isset($_GET['news'])  ? true : false;
$movie = isset($_GET['movie'])  ? true : false;

if($news) {
	$newsObj = new CAdmin($kittx['database'], 'news');
	$kittx['main'] = "<h1>{$kittx['title']}</h1>" . $newsObj->getHTML();
}

else if($movie) {
	$movieObj = new CAdmin($kittx['database'], 'movie');
	$kittx['main'] = "<h1>{$kittx['title']}</h1>" . $movieObj->getHTML();
}

else {
$kittx['main'] = <<<EOD
	<h1>{$kittx['title']}</h1>
	<p><a href='?movie'>Filmer</a> | <a href='?news'>Nyheter</a></p>
EOD;
}


 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);