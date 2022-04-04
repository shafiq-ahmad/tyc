<?php
defined('APP_EXEC') or die('No direct access is allowed.');

class Pagination extends Database{
	
  public $current_page;
  public $per_page;
  public $total_count;

  public function __construct($total_count=0){
  }

  public function offset() {
    return ($this->current_page - 1) * $this->per_page;
  }

  public function total_pages() {
    $total = ceil($this->total_count/$this->per_page);
    return $total;
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
}

?>