function turbocode($string){
#	$string = preg_replace("#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $string);
#	$string = preg_replace("#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $string);
#	$string = preg_replace("#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $string);
#	$string = preg_replace("#\[link\]www\.(.+?)\[/link\]#is", "<a href=\"http://www.\\1\">www.\\1</a>", $string);
#	$string = preg_replace("#\[link\](.+?)\[/link\]#is", "<a href=\"\\1\">\\1</a>", $string);
#	$string = preg_replace("#\[link=(.+?)\](.+?)\[/link\]#is", "<a href=\"\\1\">\\2</a>", $string);
#	$string = preg_replace("#\[url\]www\.(.+?)\[/url\]#is", "<a href=\"http://www.\\1\">www.\\1</a>", $string);
	$string = preg_replace("#\[url\](.+?)\[/url\]#is", "<a href=\"$1\">$1</a>", $string);
	$string = preg_replace("#\[url=(.+?)\](.+?)\[/url\]#is", "<a href=\"$1\">$2</a>", $string);
#	$string = preg_replace("#\[img\](.+?)\[/img\]#is", "<img src=\"\\1\" alt=\"[image]\" style=\"margin: 5px 0px 5px 0px\" />", $string);
#	$string = preg_replace("#\[img-l\](.+?)\[/img\]#is", "<img src=\"\\1\" alt=\"[image]\" style=\"border: thin solid #DFE5F2; FLOAT: left; MARGIN-RIGHT: 20px\" />", $string);
#	$string = preg_replace("#\[img-r\](.+?)\[/img\]#is", "<img src=\"\\1\" alt=\"[image]\" style=\"border: thin solid #DFE5F2; FLOAT: right; MARGIN-LEFT: 20px;\" />", $string);

#	Paragraphs [paragraph:The Paragraph]
	do{
		$laststring = $string;
		$string = preg_replace("#\[paragraph:(.+)\](.*)\[(paragraph|section|subsection|subsubsection):(.+)\]#isU", "<div class=\"tc_paragraph\"><h4>$1</h4>$2</div>\n[$3:$4]", $string, 1);
	}while($string !== $laststring);
	$string = preg_replace("#\[paragraph:(.+)\](.*)$#isU", "<div class=\"tc_paragraph\"><h4>$1</h4>$2</div>", $string);

#	Subsubsections [subsubsection:The Subsubsection]
	do{
		$laststring = $string;
		$string = preg_replace("#\[subsubsection:(.+)\](.*)\[(sub|subsub)?section:(.+)\]#isU", "<div class=\"tc_subsubsection\"><h3>$1</h3>$2</div>\n[$3section:$4]", $string, 1);
	}while($string !== $laststring);
	$string = preg_replace("#\[subsubsection:(.+)\](.*)$#isU", "<div class=\"tc_subsubsection\"><h3>$1</h3>$2</div>", $string);

#	Subsections [subsection:The Subsection]
	do{
		$laststring = $string;
		$string = preg_replace("#\[subsection:(.+)\](.*)\[(sub)?section:(.+)\]#isU", "<div class=\"tc_subsection\"><h2>$1</h2>$2</div>\n[$3section:$4]", $string, 1);
	}while($string !== $laststring);
	$string = preg_replace("#\[subsection:(.+)\](.*)$#isU", "<div class=\"tc_subsection\"><h2>$1</h2>$2</div>", $string);

#	Sections [section: The Section]
	do{
		$laststring = $string;
		$string = preg_replace("#\[section:(.+)\](.*)\[section:(.+)\]#isU", "<div class=\"tc_section\"><h1>$1</h1>$2</div>\n[section:$3]", $string, 1);
	}while($string !== $laststring);
	$string = preg_replace("#\[section:(.+)\](.*)$#isU", "<div class=\"tc_section\"><h1>$1</h1>$2</div>", $string);

	do{
		$laststring = $string;

#		Spans \theclass[Text][Title]
		$string = preg_replace("#\\\\([^\{\[\]\}]+)\[([^\[\]\\\\]+)\]\[(.+)\]#isU", "<span class=\"tc_$1\" title=\"$3\">$2</span>", $string);

#		Spans \theclass[Text]
		$string = preg_replace("#\\\\([^\{]+)\[(.+)\]#isU", "<span class=\"tc_$1\">$2</span>", $string);

#		Divs \theclass{Text}{Title}
		$string = preg_replace("#\\\\([^\{\[\]\}]+)\{([^\{\}\\\\]+)\}\{(.+)\}#isU", "<div class=\"tc_$1\" title=\"$3\">$2</span>", $string);

#		Divs \theclass{Text}
		$string = preg_replace("#\\\\([^\[]+)\{(.+)\}#isU", "<div class=\"tc_$1\">$2</div>", $string);

	}while($string !== $laststring);

	return $string;
}

$e = &$modx->Event;
switch ($e->name) {
	case "OnLoadWebDocument":
		$o = &$modx->documentObject['content']; // get a reference of the output
		$o = turbocode($o);
		break;
	default :
		return; // stop here - this is very important.
		break;
}
