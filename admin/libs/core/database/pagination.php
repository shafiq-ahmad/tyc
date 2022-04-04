<?php
defined('APP_EXEC') or die('No direct access is allowed.');

if(!class_exists('Database')){
	import('core.database');
}
import('core.html');

class DatabasePagination extends Database{
	public $current_page;
	public $url;
	
  public function __construct($per_page){
  	$this->current_page = (int)Request::getVar("page",1);
    self::$per_page = (int)$per_page;
	
	$pp = Request::getVar('perPage');
	if($pp){self::$per_page = $pp;}
	parent::__construct();
  }

  public function getPage($sql){
	$this->total_count = $this->listCount($this->loadObjectList($sql));
  	$this->current_page = (int)Request::getVar("page",1);
	if (!strrpos($sql, " LIMIT ")){
		if(self::$per_page){
			if(self::$per_page=='*'){self::$per_page=$this->total_count;}
			$sql .= " LIMIT " . self::$per_page . " ";
		}
	}
	if (!strrpos($sql, " OFFSET ")){
		if($this->offset()){
			$sql .= " OFFSET {$this->offset()} ";
		}
	}
	//echo $sql;
	//$db = Core::getDBO();
	$res = $this->loadObjectList($sql);
	Database::$pagination_list = $this->paginationList();
	return $res;
  }

	public function offset() {
		// Assuming 20 items per page: page 1 has an offset of 0    (1-1) * 20, page 2 has an offset of 20, in other words, page 2 starts with item 21
		return ($this->current_page - 1) * self::$per_page;
	}

	public function perPage() {
		if($this->per_page && $this->per_page>0){
			return $this->per_page;
		}
		return false;
	}

	public function total_pages() {
		return ceil($this->total_count/self::$per_page);
	}

	public function previous_page() {
		return $this->current_page - 1;
	}

	public function next_page() {
		return $this->current_page + 1;
	}

	public function has_previous_page() {
		return $this->previous_page() >= 1 ? true : false;
	}

	public function has_next_page() {
		return $this->next_page() <= $this->total_pages() ? true : false;
	}

	public function paginationList(){
		$page_count=0;
		$html='';
		$this->url .= '&perPage=' . self::$per_page;
		if($this->total_pages() > 1) {
			$page_count=$this->total_pages();
		if($this->has_previous_page()) { 
			$html .= "<a href=\"{$this->url}&page=";
			$html .= $this->previous_page();
			$html .= "\">&laquo; Previous</a> "; 
		}

		for($i=1; $i <= $this->total_pages(); $i++) {
			if($i == $this->current_page) {
				$html .= " <span class=\"selected\">{$i}</span> ";
			} else {
				$html .= " <a href=\"{$this->url}&page={$i}\">{$i}</a> "; 
			}
		}

			if($this->has_next_page()) { 
				$html .= " <a href=\"{$this->url}&page=";
				$html .= $this->next_page();
				$html .= "\">Next &raquo;</a> "; 
		}
			
		}elseif($this->total_pages()==1){$page_count=1;}
		$html .= '<br class="clear" />';
		
		
		$html .= '<div class="page_details">';
			$html .= "<span>Total Records: {$this->total_count}, </span><span>";
			//echo "Per Page: {$this->per_page}, ";
			$html .= "Per Page: ";
			$html .= $this->limitList(self::$per_page);
			$html .= "</span><span>Total Pages: {$page_count} ";
		$html .= '</span></div>';
		return $html;
	}

	public function limitList($selected=0){
		$list = array();
		$list[0]->id=1;
		$list[0]->name='1';
		$list[1]->id=2;
		$list[1]->name='2';
		$list[2]->id=3;
		$list[2]->name='3';
		$list[3]->id=4;
		$list[3]->name='4';
		$list[4]->id=5;
		$list[4]->name='5';
		$list[5]->id=10;
		$list[5]->name='10';
		$list[6]->id=20;
		$list[6]->name='20';
		$list[7]->id=30;
		$list[7]->name='30';
		$list[8]->id=40;
		$list[8]->name='40';
		$list[9]->id=50;
		$list[9]->name='50';
		$list[10]->id=100;
		$list[10]->name='100';
		$list[11]->id='*';
		$list[11]->name='All';
		if($selected>100){$selected='*';}
		$result = '<form name="pageLimit" id="pageLimit" style="display:inline;">';
		if (isset($_GET['option']) && $_GET['option'] != ''){
			$result .= '<input type="hidden" name="option" value="' . $_GET['option']  . '" />';
		}
		if(isset($_GET['view'])){
			$result .= '<input type="hidden" name="view" value="' . $_GET['view']  . '" />';
		}
		if(isset($_GET['task'])){
			$result .= '<input type="hidden" name="task" value="' . $_GET['task']  . '" />';
		}
		$result .= HTML::htmlFormList($list, 'perPage', 'list', 'pageLimit', $selected);
		$result .= '</form>';
		return $result;
	}

} // end class DatabasePagination




?>