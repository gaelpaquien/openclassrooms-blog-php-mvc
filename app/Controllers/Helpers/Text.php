<?php
namespace App\Controllers\Helpers;

class Text
{

  public static function slugify($text, string $divider = '-')
  {
    // Replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // Transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // Trim
    $text = trim($text, $divider);

    // Remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // Lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    // Return the string in slug
    return $text;
  }

}
