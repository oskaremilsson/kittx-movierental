<?php 
/**
 * This is a kittX pagecontroller. That handles Dice-game 100!
 *
 */
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the kittX container.
$kittx['title'] = "Dicegame 100";

$game = new CDiceGameLogic();

$kittx['main'] = "<h1>Spela och vinn gratis hyrning!</h1>" . $game->view();

// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);

?>