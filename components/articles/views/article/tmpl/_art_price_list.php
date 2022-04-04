<?php
defined('_MEXEC') or die ('Restricted Access');
//echo getNewID();exit;

?>
<tbody id="tbl_price_list"><?php
	if($this->art_prices){
		$x=1;
		$sub_total=0;
		foreach ($this->art_prices as $ap){
			?><tr><?php
			echo '<td><input type="hidden" name="unit_id" value="' . $ap['unit_id'] . '" />' . $ap['unit_title'] . '</td>'; 
			echo '<td><input type="text" name="bar_code" value="' . $ap['bar_code'] . '" /></td>'; 
			echo '<td><input type="text" name="sale_price" value="' . $ap['sale_price'] . '" /></td>'; 
			echo '<td><input type="text" name="purchase_price" value="' . $ap['purchase_price'] . '" /></td>';
			$js_rem = "";
			$js_edit = "";
			$js_rem .= "remArticlePrice({$this->article_id},'{$ap['unit_id']}');return false;";
			$js_edit .= "updateArticlePrice({$this->article_id},'{$ap['unit_id']}');return false;";
			echo '<td>'; 
			echo '<a onclick="' . $js_rem . '" href="#" title="Delete" tabindex="-1"><i class="fa fa-trash"></i></a> &nbsp; | &nbsp; '; 
			echo '<a onclick="' . $js_edit . '" href="#" title="Delete" tabindex="-1"><i class="fa fa-edit"></i></a>'; 
			echo '</td>';
			?></tr><?php
			$x++;
		}
	}else{
		echo "<tr><td><p>No item(s)</p></td></tr>";
	}
?></tbody>
		