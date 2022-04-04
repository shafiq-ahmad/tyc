<?php
defined('_MEXEC') or die ('Restricted Access');
//echo getNewID();exit;
$id=0;
$filter_text = "";
//print_r($_POST);
//echo "<br/>get<br/>";
//print_r($_GET);	exit;


?>

	<table  class="table table-bordered table-hover table-condenseds">
		<thead>
			<tr>
				<th>Item Code</th><th>Title</th><th>Qty</th><th>Old Cost</th>
				<th>New Cost</th><th>Sale</th><th>Total Cost</th><th>Actions</th>
			</tr>
		</thead>
		<tbody id="pur_articles"><?php
		if($this->pur_arts){
			$x=1;
			$sub_total=0;
			foreach ($this->pur_arts as $pa){
		?><tr <?php if($this->id==$pa['article_code']){echo ' class="active"';} ?>><?php 
			echo '<td tabindex="' . $x . '">' . $pa['article_code'] . '</td>';
			$total = $pa['unit_price']*($pa['qty_scheme']);
			$sub_total=$sub_total+$total;
			echo '<td>' . $pa['art_title'] . '</td>'; 
			echo '<td>' . $pa['qty_scheme'] . '</td>'; 
			echo '<td>' . $pa['cost_price'] . '</td>'; 
			echo '<td>' . $pa['unit_price'] . '</td>'; 
			echo '<td>' . $pa['sale_price'] . '</td>'; 
			echo '<td>' . $total . '</td>'; 
			if(!$this->pur['status']){
				$art_qty = $pa['qty_scheme']+$pa['scheme'];
				$js = "remPurItem({$pa['purchase_id']},'{$pa['article_code']}', {$art_qty});return false;";
				echo '<td>'; 
				echo '<a onclick="' . $js . '" href="#" title="Delete" tabindex="-1">X</a>'; 
				//echo '<a href="' . $delete_link . '" title="Delete">Delete</a>'; 
				echo '</td>';
			}
		?></tr><?php
			$x++;
			}
		}else{
			echo "<tr><td><p>No item(s)</p></td></tr>";
		}
		?></tbody>
		<tfoot>
			<tr>
				<th colspan="6">Total:</th><th><?php if(isset($sub_total)){echo $sub_total;}else{echo '0';} ?></th><th></th>
			</tr>
		</tfoot>
	</table>