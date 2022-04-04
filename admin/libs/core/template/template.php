<?php
defined('_MEXEC') or die ('Restricted Access');

	class Template {
		
		public $filename;
		public $assigned_vars=array();
		
		public function set($key, $value) {
			$this->assigned_vars[$key] = $value;
		}
	  
		public function display() {
			if(file_exists($this->filename)) {
				$output = file_get_contents($this->filename);
				foreach($this->assigned_vars as $key => $value) {
					$output = preg_replace('/{'.$key.'}/', $value, $output);
				}
				echo $output;
			} else {
				echo "*** Missing template error ***";
			}
		}
	}
	

?>


