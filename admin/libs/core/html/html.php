<?php
defined('_MEXEC') or die ('Restricted Access');

//require_once "pagination.php";
//require_once "list.php";
import('core.html.form');
class Html{
	protected $var;
	public $js='';	//js with event_name=val
	
	public function getCheckState($state){
		if($state==1){
			return 'checked="checked"';
		}else{
			return '';
		}
	}
	
	
public function html_modify($html,$serch_str='*',$new_str='',$position=''){//position:'','after','before'
	if(!$html){return false;}
	// remove all image
	foreach($html->find($serch_str) as $e){
		//$ad_code = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Homepage Leaderboard --><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-1234567890123456" data-ad-slot="1234567890"></ins><script> (adsbygoogle = window.adsbygoogle || []).push({});</script>';
		if($position=='after'){
			$e->outertext = $e->outertext . $new_str;
		}elseif($position=='before'){
			$e->outertext = $new_str . $e->outertext;
		}else{
			$e->outertext = $new_str;
		}
	}
	return $html;
}
	
	
}

?>