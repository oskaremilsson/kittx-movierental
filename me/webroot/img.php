<?php 
/**
 * This is a PHP skript to process images using PHP GD.
 *
 */
include(__DIR__.'/config.php'); 


$imgObj = new CImage(__DIR__, 2000, 2000);
$imgObj->showImage();