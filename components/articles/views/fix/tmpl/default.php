<?php
defined('_MEXEC') or die ('Restricted Access');

$db = core::getDBO();
?>

	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
<div class="com-head">
	<h3>Items</h3>
</div>
<div class="table-responsive">
	<div class="box-body">
	<table id="data-table" class="table display">
		<thead>
		<tr>
			<th>Expiry dates</th><th>TP prices</th>
		</tr>
		</thead>
		<tbody id="tblContentBody"><?php
			foreach ($this->rows as $row){
				$update = false;
		?><tr><?php
			$sql = 'UPDATE branch_articles SET ';
			$sql .= '';
			$json = json_decode($row['stock_expiry_dates']);
			if (isset($json->term)){
				$update=true;
				$json = json_encode($json->term);
				$sql .= "stock_expiry_dates = '" . $json . "' ";
			}
			//echo '<td>' . json_encode($json) . '</td>';
			$json_tp = json_decode($row['sale_price_terms']);
			if (isset($json_tp->term)){
				$update=true;
				$json_tp = json_encode($json_tp->term);
				if($json){$sql .= ',';}
				$sql .= "sale_price_terms = '" . $json_tp . "' ";
			}
			
			//echo '<td>' . json_encode($json_tp) . '</td>';
			$sql .= "WHERE article_code = '" . $row['article_code'] . "'";
			if($update){
				echo $sql;
				$db->update_by_sql($sql);
			}
			
		?></tr><?php
			}
		?></tbody>
	</table>
</div>
</div>
