<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults.
include(__DIR__.'/config.php'); 
$kittx['stylesheet'][] = 'css/gallery.css';
$kittx['stylesheet'][] = 'css/breadcrumb.css';
$kittx['stylesheet'][] = 'css/figure.css';
 
$galleryObj = new CGallery(__DIR__);

// Prepare content and store it all in variables in the Anax container.
$kittx['title'] = "Jag ska måla hela världen";
 
$kittx['main'] = <<<EOD
<h1>{$kittx['title']}</h1>
<p>Övning för bildgalleri.</p>
{$galleryObj->getBreadcrumb()}

{$galleryObj->getGallery()}
EOD;


 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);
