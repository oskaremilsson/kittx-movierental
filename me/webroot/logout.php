<?php
include(__DIR__.'/config.php'); 

header("Refresh: 1; url=index.php");

if(isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
}
else {
  $user = null;
}

if($user) {
  $user->logout();
  if(!$user->getStatus()) {
    $kittx['main'] = "<p>Loggar ut...</p>";
    $user = null;
  }
}

$kittx['title'] = "Utloggad";

// Finally, leave it all to the rendering phase of kittx.
include(KITTX_THEME_PATH);