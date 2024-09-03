<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use League\HTMLToMarkdown\HtmlConverter;

final class Toolbox
{
  /**
   * Clean integer string value (strip all chars not - and spaces )
   *
   * @since versin 0.83.5
   *
   * @param string  $integer  integer string
   *
   * @return string  clean integer
   **/
  public static function cleanInteger($integer)
  {
    return preg_replace("/[^0-9-]/", "", $integer);
  }

  public static function getRootPath(Request $request)
  {
    $routeContext = RouteContext::fromRequest($request);
    return $routeContext->getBasePath();
  }

  /**
   * strtolower function for utf8 string
   *
   * @param string $str
   *
   * @return string  lower case string
  **/
  public static function strtolower($str)
  {
    if (is_null($str))
    {
      return null;
    }
    return mb_strtolower($str, "UTF-8");
  }

  /**
   * Convert HTML text into markdown
   */
  public static function convertHtmlToMarkdown($text)
  {
    $converter = new HtmlConverter();
    $converter->getConfig()->setOption('strip_tags', true);

    return $converter->convert(html_entity_decode($text));
  }
}
