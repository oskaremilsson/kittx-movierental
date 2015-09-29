<?php 
/**
 * This is a kittX pagecontroller. For Source
 *
 */
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the kittX container.
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));
$kittx['stylesheet'][] = 'css/source_style.css';
$kittx['title'] = "Såskock";
$kittx['main'] = $source->View();

include(KITTX_THEME_PATH);
?>