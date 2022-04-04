<?php
defined('_MEXEC') or die ('Restricted Access');


if(!class_exists('Html')){
	import('core.html');
}

class HtmlForm extends Html{
	public $label=array();

	//public static function htmlSelect($tableName, $sel_id=0, $name, $class="comboBox", $first=false,$args=[0=>'id',1=>'title']){
	/*
		$opt = new stdClass(); //sel_id, name, class, first
	
	*/
	private static function getProps($obj, $name){
		if(isset($obj->$name)){
			return $obj->$name;
		}
		return '';
	}
	
	public static function htmlSelect($list, $sel_id=0, $name, $class="form-control", $first=false, $multiple=false, $get_one_sel=false, $attr_names = [0=>'id',1=>'title']){
		$result='';
		if($multiple){
			$multiple="multiple";
		}
		$result = '<select id="' . $name . '" class="' . $class . '" name="' . $name . '" ' . $multiple . ' >';
			if($first){
				$result .= '<option value="0" >Select ... </option>';
			}
		
		foreach ($list as $row):
			$result .= '<option value="' . $row['id'] . '" ' ;
				if($row['id']==$sel_id){
					if($get_one_sel){
						return $row['title'];
					}
					$result .= 'selected="selected"';
				} 
				$result .= '>';
				$result .= $row['title'];
			$result .= '</option>';
		 endforeach; 
		$result .= '</select>';
		
		return $result;
	}

	public static function htmlSelectOptions($list, $sel_id=0, $get_only_selected=false){
		$result='';
		foreach ($list as $row):
			$result .= '<option value="' . $row['id'] . '" ' ;
				if($row['id']==$sel_id){
					if($get_only_selected){
						return '<option value="' . $row['id'] . '" selected="selected">' . $row['title'] . '</selected>';
					}
					$result .= 'selected="selected"';
				} 
				$result .= '>';
				$result .= $row['title'];
			$result .= '</option>';
		 endforeach; 
		
		return $result;
	}
	
	public static function htmlSelect2($list, $name='', $opt, $attr_names = [0=>'id',1=>'title']){
		$result='';
		if(self::getProps($opt,'startTag')){
			$result.=self::getProps($opt,'startTag');
		}
		$select = '<select ';
		if($name){
			$select .= 'id="' . $name . '" name="' . $name . ' ';
		}
		$class=self::getProps($opt,'class');
		if($class){
			$select .= 'class="' . $class . '" ';
		}
		$select .= self::getProps($opt,'js') . ' ' . self::getProps($opt,'required') . ' >';
		if(self::getProps($opt,'first')){
			//$select .= '<option value="0" >Select ' . $name . '</option>';
		}
		//echo $attr_names[1];exit;
		$sel_id = self::getProps($opt,'sel_id');
		foreach ($list as $row):
			//$select .= '<option value="' . $row[$attr_names[0]] . '" ' ;
			$select .= '<option value="' . $row['id'] . '" ' ;
				/*if($row[$attr_names[0]]==$sel_id){
					$select .= 'selected="selected"';
				} */
				$select .= '>';
				//$select .= $row->name;
				$select .= htmlspecialchars($row['title']);
			$select .= '</option>';
		 endforeach;
		$select .= '</select>';
		$result.=$select;
		if(self::getProps($opt,'endTag')){
			$result.=self::getProps($opt,'endTag');
		}
		return $result;
	}

}

	
?>