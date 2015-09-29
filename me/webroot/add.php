<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults
include(__DIR__.'/config.php'); 
$content = new CContent($kittx['database']);

$acronym = isset($_SESSION['user']) ? $_SESSION['user']->getAcronym() : null;

$url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
$title  = isset($_POST['title']) ? $_POST['title'] : null;
$slug  = isset($_POST['slug']) ? $_POST['slug'] : null;
$filter  = isset($_POST['filter']) ? $_POST['filter'] : null;
$data   = isset($_POST['data'])  ? $_POST['data'] : array();
$output = null;

// Check that incoming parameters are valid
!empty($acronym) or die('Check: You need to login');

if(isset($_POST['data'])) {
	$url = empty($url) ? null : $url;
    $params = array($title, $slug, $data, $type, $filter);
	if($content->addContent($params)) {
	  $output = 'Informationen sparades.';
	}
	else {
	  $output = 'Informationen sparades EJ.<br><pre>' . print_r($content->getDbError(), 1) . '</pre>';
	}
}

$kittx['title'] = "Lägg till Innehåll";
 
$kittx['main'] = <<<EOD
<h1>{$kittx['title']}</h1>
{$content->getAddForm()}
<p>
<output>{$output}</output>
</p>
EOD;

 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);