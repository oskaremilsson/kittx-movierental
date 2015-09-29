<?php
include(__DIR__.'/config.php'); 
$kittx['title'] = "Logga in";
$kittx['main'] = <<<EOD
	<h1>{$kittx['title']}</h1>
  <form name="login" method="post">
  <input type="text" name="acronym" placeholder="Användare" />
  <input type="password" name="password" placeholder="Lösenord" />
  <input type="hidden" name="login" />
  <input type="submit" value="logga in" />
  </form>
EOD;

if(isset($_POST['login'])) {
	$user = new CUser();
	if($user->login($kittx['database'], $_POST['acronym'], $_POST['password'])) {
		$_SESSION['user'] = $user;
		header("Refresh: 1; url=admin.php");
		$kittx['main'] .= "<p>Loggar in...</p>";
		
	}
}

// Finally, leave it all to the rendering phase of kittx.
include(KITTX_THEME_PATH);