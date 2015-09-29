<?php
/**
 * Bootstrapping functions, essential and needed for kittX to work together with some common helpers. 
 *
 */
 
/**
 * Default exception handler.
 *
 */
function myExceptionHandler($exception) {
  echo "kittX: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('myExceptionHandler');

function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}

/**
 * Autoloader for classes.
 *
 */
function myAutoloader($class) {
  $path = KITTX_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    include($path);
  }
  else {
    throw new Exception("Classfile '{$class}' does not exists.");
  }
}
spl_autoload_register('myAutoloader');

/**
 * Create a link to the content, based on its type.
 *
 * @param object $content to link to.
 * @return string with url to display content.
 */
function getUrlToContent($content) {
  switch($content->type) {
    case 'page': return "page.php?url={$content->url}"; break;
    case 'post': return "blog.php?slug={$content->slug}"; break;
    default: return null; break;
  }
}
