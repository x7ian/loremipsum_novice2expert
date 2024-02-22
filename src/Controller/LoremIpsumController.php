<?php

namespace Drupal\loremipsum\Controller;

// Change following https://www.drupal.org/node/2457593
// See https://www.drupal.org/node/2549395 for deprecate methods information
// use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Utility\Html;
// use Html instead SAfeMarkup

/**
 * Controller routines for Lorem ipsum pages.
 */
class LoremIpsumController {

  /**
   * Constructs Lorem ipsum text with arguments.
   * This callback is mapped to the path
   * 'loremipsum/generate/{paragraphs}/{phrases}'.
   * 
   * @param string $paragraphs
   *   The amount of paragraphs that need to be generated.
   * @param string $phrases
   *   The maximum amount of phrases that can be generated inside a paragraph.
   */
  public function generate($paragraphs, $phrases) {
    $page_title = 'Lorem ipsum';
    $source_text = "Lorem ipsum dolor sit amet, consectetur adipisci elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. \nUt enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. \nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. \nExcepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ";
    $repertory = explode(PHP_EOL, $source_text);
    $text = '';
    // Generate X paragraphs with up to Y phrases each.
    for ($i = 1; $i <= $paragraphs; $i++) {
       $this_paragraph = '';
       // When we say "up to Y phrases each", we can't mean "from 1 to Y".
       // So we go from halfway up.
       $random_phrases = mt_rand(1, $phrases);
       // Also don't repeat the last phrase.
       $last_number = 0;
       $next_number = 0;
       for ($j = 1; $j <= $random_phrases; $j++) {
         do {
           $next_number = floor(mt_rand(0, count($repertory) - 1));
         } while ($next_number === $last_number && count($repertory) > 1);
         $this_paragraph .= $repertory[$next_number] . ' ';
         $last_number = $next_number;
       }
       $text .= '<p>' . Html::escape($this_paragraph) . '</p>';
    }
    $element = [
      '#type' => 'markup',
      '#markup' => '<h3>' . Html::escape($page_title) . '</h3>' . $text,
    ];
    return $element;
  }

}