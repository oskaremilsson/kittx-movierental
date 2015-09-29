<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults.
include(__DIR__.'/config.php'); 
$content = new CContent($kittx['database']);
$content->grepAllContent();


// Put results into a list
$items = $content->getContentList();

$kittx['title'] = "Innehåll";
$kittx['main'] = <<<EOD
<h1>{$kittx['title']}</h1>

<ul>
{$items}
</ul>

<p><a href='blog.php'>Visa alla bloggposter.</a></p>

EOD;

// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);