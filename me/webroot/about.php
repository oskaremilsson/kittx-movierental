<?php 
/**
 * About-page
 *
 */
// Include the essential config-file which also creates the $kittx variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Do it and store it all in variables in the kittX container.
$kittx['title'] = "Om oss";
 
 
$kittx['main'] = <<<EOD
<h1>{$kittx['title']}</h1>
<p class="news-text">Vilka är då vi? Jo det ska jag berätta för er.</p>
<p class="news-text">Vi är en grupp, handvalda, av självaste Henric Pontén. Vi ska se till att folk börjar hyra film igen. Det här med pirat-kopiering måste få ett slut!</p>
<p class="news-text">Därför har vi nu startat upp RM Rental Movies. Klicka dig in på filmer och bläddra runt bland våra titlar!</p>
EOD;
 

 
// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);