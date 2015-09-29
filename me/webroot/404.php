<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$kittx['title'] = "404";
$kittx['header'] = "";
$kittx['main'] = "This is a kittX 404. Cat is not here.";
$kittx['footer'] = "";
 
// Send the 404 header 
header("HTTP/1.0 404 Not Found");
 
 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);