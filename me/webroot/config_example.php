<?php
/**
 * Config-file for kittX. Change settings here to affect installation.
 *
 */

/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly


/**
 * Define Anax paths.
 *
 */
define('KITTX_INSTALL_PATH', __DIR__ . '/..');
define('KITTX_THEME_PATH', KITTX_INSTALL_PATH . '/theme/render.php');


/**
 * Include bootstrapping functions.
 *
 */
include(KITTX_INSTALL_PATH . '/src/bootstrap.php');


/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();


/**
 * Create the kittX variable.
 *
 */
$kittx = array();


/**
 * Site wide settings.
 *
 */
$kittx['lang'] = 'sv';
$kittx['title_append'] = ' | RM Rental Movies';


$kittx['footer'] = <<<EOD
<footer><span class='sitefooter'>© RM Rental Movies |  <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span></footer>
EOD;

/**
 * Theme related settings.
 *
 */
$kittx['stylesheet'] = array();
$kittx['stylesheet'][] = 'css/style.css';
$kittx['favicon']    = 'img/kittx.ico';
$kittx['sitelogo']    = 'img/rm.png';
$kittx['sitetitle']    = 'RM Rental Movies';
$kittx['siteslogan']    = 'Escape the world';

/**
 * Settings for JavaScript.
 *
 */
$kittx['modernizr'] = 'js/modernizr.js';
$kittx['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
$kittx['javascript_include'] = array();
$kittx['javascript_include'][] = "js/info-box.js";

/**
 * The menu
 *
 */
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->getAcronym() : null;
if($acronym) {
	$kittx['menu'] = array(
	  'start'  => array('text'=>'Start',  'url'=>'index.php'),
	  'movies'  => array('text'=>'Filmer',  'url'=>'movies.php'),
	  'news'  => array('text'=>'Nyheter',  'url'=>'news.php'),
	  'about'  => array('text'=>'Om oss',  'url'=>'about.php'),
	  'contest'  => array('text'=>'Tävling',  'url'=>'contest.php'),
	  'admin'  => array('text'=>'Admin',  'url'=>'admin.php'),
	  'logout'  => array('text'=>'Logout',  'url'=>'logout.php'));
}
else {
	$kittx['menu'] = array(
	  'start'  => array('text'=>'Start',  'url'=>'index.php'),
	  'movies'  => array('text'=>'Filmer',  'url'=>'movies.php'),
	  'news'  => array('text'=>'Nyheter',  'url'=>'news.php'),
	  'about'  => array('text'=>'Om oss',  'url'=>'about.php'),
	  'contest'  => array('text'=>'Tävling',  'url'=>'contest.php'),
	  'login'  => array('text'=>'Login',  'url'=>'login.php'));
}

/**
 * Settings for the database.
 *
 */
$kittx['database']['dsn'] = 'domain';
$kittx['database']['username'] = 'usr';
$kittx['database']['password'] = 'password';
//$kittx['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");