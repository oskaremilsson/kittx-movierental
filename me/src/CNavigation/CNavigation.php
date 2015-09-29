<?php
class CNavigation {
  public static function GenerateMenu($items) {
    $html = "<nav>\n<span class='nav-spacer'>|</span> ";
    foreach($items as $item) {
      $html .= "<a href='{$item['url']}'>{$item['text']}</a> <span class='nav-spacer'>|</span> ";
    }
    $html .= "</nav>\n";
    return $html;
  }
};