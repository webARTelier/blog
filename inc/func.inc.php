<?php



// new line to <p>
// ---------------
function nl2p($string) {
  $paragraphs = '';

  foreach (explode("\n", $string) as $line) {
    if (trim($line)) {
      $paragraphs .= '<p>'.$line.'</p>';
    }
  }

  return $paragraphs;
}



?>
