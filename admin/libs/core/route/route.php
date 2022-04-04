<?php
defined('_MEXEC') or die ('Restricted Access');


class Route{
	protected $var;
	public $js='';	//js with event_name=val

	public static function _($url){
		//indject language and menu_id if not set in source
		return $url;
	}

	
	
	
}


/*
parse_str("name=Peter&age=43",$myArray);
print_r($myArray);
//or

parse_str("name=Peter&age=43");
echo $name."<br>";
echo $age;



$url = 'http://username:password@hostname:9090/path?arg=value#anchor';

var_dump(parse_url($url));
var_dump(parse_url($url, PHP_URL_SCHEME));
var_dump(parse_url($url, PHP_URL_USER));
var_dump(parse_url($url, PHP_URL_PASS));
var_dump(parse_url($url, PHP_URL_HOST));
var_dump(parse_url($url, PHP_URL_PORT));
var_dump(parse_url($url, PHP_URL_PATH));
var_dump(parse_url($url, PHP_URL_QUERY));
var_dump(parse_url($url, PHP_URL_FRAGMENT));



//building query
$data = array(
'foo' => 'bar',
'baz' => 'boom',
'cow' => 'milk',
'php' => 'hypertext processor'
);

echo http_build_query($data) . "\n";
echo http_build_query($data, '', '&amp;');




*/

