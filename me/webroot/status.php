<?php
include(__DIR__.'/config.php'); 

if(isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
}
else {
  $user = null;
}

$kittx['title'] = "Status";

$kittx['main'] = <<<EOD
<a href="login.php">login.php</a> | <a href="logout.php">logout.php</a>
	<h1>{$kittx['title']}</h1>
EOD;

if($user && $user->getStatus()) {
	$kittx['main'] .= <<<EOD
	<p>inloggad som {$user->getName()} ({$user->getAcronym()})
EOD;
}
else {
	$kittx['main'] .= "Du är inte inloggad.";
}

// Finally, leave it all to the rendering phase of kittx.
include(KITTX_THEME_PATH);