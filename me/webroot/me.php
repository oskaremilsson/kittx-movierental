<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
include(__DIR__.'/config.php'); 
// Do it and store it all in variables in the kittX container.
$kittx['title'] = "Om mig";

$kittx['main'] = <<<EOD
<h1>Om mig</h1>
<p class="text">Jo då var det dags att göra me-sida nummer femtiotre och även här skriva en presentation. De blir förmodligen flummigare och flummigare.
Oskar Emilsson heter jag, 22år från vimmerby. Befann mig på campus i tre år, ett år under spelprog, ett webb och ett som kårordförande. 
Redo att ta nya tag på det här. </p>
<img src="img/kitty.jpg" alt="kitty" class="profil" />
EOD;

$kittx['main'] .= CSpotify::getSpotify();

// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);
?>