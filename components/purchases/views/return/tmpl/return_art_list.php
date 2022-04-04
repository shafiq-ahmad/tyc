<?php
defined('_MEXEC') or die ('Restricted Access');
//echo getNewID();exit;
//echo "<br/>get<br/>";
//print_r($this->ret_arts);	exit;
$ret_arts = $this->ret_arts;


?>

	<table class="table table-bordered table-hover table-condenseds">
		<thead><tr><th>Item Code</th><th>Title</th><th>Qty</th><th>Old Cost</th><th>New Cost</th><th>Sale</th><th>Total Cost</th><th>Actions</th></tr></thead>
		<tbody id="pur_articles"><?php
		if($ret_arts){
			$x=1;
			$sub_total=0;
			foreach ($ret_arts as $ra){
		?><tr><?php 
			echo '<td tabindex="' . $x . '">' . $ra['article_code'] . '</td>';
			$total = $ra['unit_price']*($ra['qty_scheme']);
			$sub_total=$sub_total+$total;
			echo '<td>' . $ra['art_title'] . '</td>'; 
			echo '<td>' . $ra['qty_scheme'] . '</td>'; 
			echo '<td>' . $ra['cost_price'] . '</td>'; 
			echo '<td>' . $ra['unit_price'] . '</td>'; 
			echo '<td>' . $ra['sale_price'] . '</td>'; 
			echo '<td>' . $total . '</td>'; 
			if(!$this->ret['status']){
				$art_qty = $ra['qty_scheme']+$ra['scheme'];
				$js = "remRetItem({$ra['return_id']},'{$ra['article_code']}', {$art_qty});return false;";
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