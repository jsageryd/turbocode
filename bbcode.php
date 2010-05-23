function bbcode($string)
 {
  $string = preg_replace("#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $string);
  $string = preg_replace("#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $string);
  $string = preg_replace("#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $string);
  $string = preg_replace("#\[link\]www\.(.+?)\[/link\]#is", "<a href=\"http://www.\\1\">www.\\1</a>", $string);
  $string = preg_replace("#\[link\](.+?)\[/link\]#is", "<a href=\"\\1\">\\1</a>", $string);
  $string = preg_replace("#\[link=(.+?)\](.+?)\[/link\]#is", "<a href=\"\\1\">\\2</a>", $string);
  $string = preg_replace("#\[url\]www\.(.+?)\[/url\]#is", "<a href=\"http://www.\\1\">www.\\1</a>", $string);
  $string = preg_replace("#\[url\](.+?)\[/url\]#is", "<a href=\"\\1\">\\1</a>", $string);
  $string = preg_replace("#\[url=(.+?)\](.+?)\[/url\]#is", "<a href=\"\\1\">\\2</a>", $string);
  $string = preg_replace("#\[img\](.+?)\[/img\]#is", "<img src=\"\\1\" alt=\"[image]\" style=\"margin: 5px 0px 5px 0px\" />", $string);
  $string = preg_replace("#\[img-l\](.+?)\[/img\]#is", "<img src=\"\\1\" alt=\"[image]\" style=\"border: thin solid #DFE5F2; FLOAT: left; MARGIN-RIGHT: 20px\" />", $string);
  $string = preg_replace("#\[img-r\](.+?)\[/img\]#is", "<img src=\"\\1\" alt=\"[image]\" style=\"border: thin solid #DFE5F2; FLOAT: right; MARGIN-LEFT: 20px;\" />", $string);

# Spans
  $string = preg_replace("#\[s:(.+)\](.+?)\[/s\]#is", "<span class=\"\\1\">\\2</span>", $string);

# Divs
  $string = preg_replace("#\[d:(.+)\](.+?)\[/d\]#is", "<div class=\"\\1\">\\2</div>", $string);

# Paragraphs
  do{
    $laststring = $string;
    $string = preg_replace("#\[paragraph:(.+)?\](.*)?\[(paragraph|section|subsection|subsubsection):(.+)?\]#isU", "<div class=\"paragraph\"><h4>$1</h4>$2</div>[$3:$4]", $string);
  }while($string !== $laststring);
  $string = preg_replace("#\[paragraph:(.+)?\](.*)$#isU", "<div class=\"paragraph\"><h4>$1</h4>$2</div>", $string);

# Subsubsections
  do{
    $laststring = $string;
    $string = preg_replace("#\[subsubsection:(.+)?\](.*)?\[(sub|subsub)?section:(.+)?\]#isU", "<div class=\"subsubsection\"><h3>$1</h3>$2</div>[$3section:$4]", $string);
  }while($string !== $laststring);
  $string = preg_replace("#\[subsubsection:(.+)?\](.*)$#isU", "<div class=\"subsubsection\"><h3>$1</h3>$2</div>", $string);

# Subsections
  do{
    $laststring = $string;
    $string = preg_replace("#\[subsection:(.+)?\](.*)?\[(sub)?section:(.+)?\]#isU", "<div class=\"subsection\"><h2>$1</h2>$2</div>[$3section:$4]", $string);
  }while($string !== $laststring);
  $string = preg_replace("#\[subsection:(.+)?\](.*)$#isU", "<div class=\"subsection\"><h2>$1</h2>$2</div>", $string);

# Sections
  do{
    $laststring = $string;
    $string = preg_replace("#\[section:(.+)?\](.*)?\[section:(.+)?\]#isU", "<div class=\"section\"><h1>$1</h1>$2</div>[section:$3]", $string);
  }while($string !== $laststring);
  $string = preg_replace("#\[section:(.+)?\](.*)$#isU", "<div class=\"section\"><h1>$1</h1>$2</div>", $string);

  return $string;
 }

$e = &$modx->Event;
switch ($e->name) {
case "OnWebPagePrerender":
$o = &$modx->documentOutput; // get a reference of the output
$o = bbcode($o);
 break;
default :
return; // stop here - this is very important.
 break;
}
