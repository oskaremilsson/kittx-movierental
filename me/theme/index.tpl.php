<!doctype html>
<html lang='<?=$lang?>' class='no-js'>
<head>
<script src='<?=$modernizr?>'></script>
<meta charset='utf-8'/>
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Fredericka+the+Great' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Orbitron:900' rel='stylesheet' type='text/css'>
<title><?=get_title($title)?></title>
<?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
<?php
foreach ($kittx['stylesheet'] as $style)
{
    echo "<link rel='stylesheet' type='text/css' href='$style'/>";
}
$search = isset($_GET['search']) ? $_GET['search'] : "Sök";
?>
</head>
<body>
<div id='wrapper'>
	<div id='header'><a href='index.php'><img class='sitelogo' src='<?=$kittx['sitelogo']?>' alt='kittX Logo'/></a>
		<p class='sitetitle'><a href='index.php'><?=$kittx['sitetitle']?></a>
		<span class='siteslogan'><?=$kittx['siteslogan']?></span></p>
		<?php echo CNavigation::GenerateMenu($kittx['menu']);?>
		<div id="searchfield">
			<form action="movies.php">
			<?php echo "<label><input type='search' name='search' placeholder='{$search}'/></label>";?>
			</form>
		</div>
	</div>
	<div id='main'><?=$main?></div>
	<div id='footer'><?=$footer?></div>
</div>
  
<?php if(isset($jquery)):?><script src='<?=$jquery?>'></script><?php endif; ?>
<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$val?>'></script>
<?php endforeach; endif; ?>
</body>
</html>