<?php
class CSpotify {
  public static function getSpotify() {
  	  $content = file_get_contents("http://ws.audioscrobbler.com/1.0/user/OskarEmilsson/recenttracks.rss");
  	  $x = new SimpleXmlElement($content);
  	  $html = "<p class='text'>Senast spelade låtar:</p><ul>";
		for($i=0;$i<10;$i++)
		{
			$title = $x->channel->item[$i]->title;
			$title = str_replace("'", "", $title);
			$song = explode(" – ", $title);
			$html .= "<li>" . $song[0] . " - " . $song[1] . "</li>";
		}
		$html .= "</ul>";
	return $html;
  }
};