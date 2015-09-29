<?php

$html = file_get_contents('http://imdb.com/title/tt2310332'); //get the html returned from the following url
echo strpos($html, 'titlePageSprite star-box-giga-star');

echo var_dump(substr($html, strpos($html, 'titlePageSprite star-box-giga-star')+37, 3));

?>