<?php
defined('_MEXEC') or die ('Restricted Access');

//$cust_title=$this->row['cust_title'];
//$person=$this->row['person'];
//$credit=$this->row['credit'];

//echo json_encode($row);exit;
?><div class="com-head">
	<?php /* ?><h3>Add/Edit Article</h3><?php */ ?>
	<style>
	.form-inline .row {margin-bottom:10px;}
	</style>
</div><div class="form-group">
	<form class="form-inline" method="post" name="frm" action="?com=articles&view=articles&id=<?php echo $this->id;?>">
		<fieldset class="form">
		<div class="form grid">
			<div class="row well-sm">
				<div class="col-sm-2 cell">Bill#: </div><div class="col-sm-2 cell"><?php echo $this->row['id'];?></div>
				<div class="col-sm-1 cell">Date: </div><div class="col-sm-2 cell"><?php echo $this->row['sale_date'];?></div>
				<div class="col-sm-1 cell">User: </div><div class="col-sm-3 cell"><?php //echo $this->row['full_name'];?></div>
			</div>
			</div>
			<div class="row well-sm">
				<div class="col-sm-2 cell">Sub Total: </div><div class="col-sm-2 cell"><?php echo $this->row['sub_total'];?></div>
				<div class="col-sm-1 cell">Discount: </div><div class="col-sm-2 cell"><?php echo $this->row['discount_amount'];?></div>
				<div class="col-sm-1 cell highlight">VAT: </div><div class="col-sm-2 cell highlight"><?php echo $this->row['vat_amount'];?></div>
			</div>
			<div class="row well-sm screen">
				<?php /* ?><div class="col-sm-1"><label class="control-label" for="bank_check">Bank Cheque:</label> </div><div class="col-sm-1"><input name="bank_check" class="inputbox form-control" value="<?php echo $this->row['bank_check'];?>" /></div>
				<div class="col-sm-1"><label class="control-label" for="bank_card">Bank Card:</label> </div><div class="col-sm-1"><input name="bank_card" class="inputbox form-control" value="<?php echo $this->row['bank_card'];?>" /></div>
			<?php */?></div>
		</div>
		</fieldset>
	</form>
</div>
	<table  class="table table-bordered table-hover table-condenseds">
		<thead>
		<tr>
			<th class="screen">Item Code</th><th>Title</th><th>Qty</th><th>Price</th><th>Discount</th><th>TP Price</th><th>VAT</th><th>Total Cost</th>
		</tr>
		</thead>
		<tbody id="pur_articles">		
		<script>
	var json_data = <?php
		echo $this->row['data_articles']; ?>;
	console.log(json_data[0]);
	var subTotal=0;
	$.each(json_data, function(i, v) {
		var vat=0;
		var tp_price=0;
		var discount=0;
		if(v.vat){vat = eval(v.vat);}
		if(v.tp_price){
			tp_price = eval(v.tp_price);
		}
		if(v.discount){discount = eval(v.discount);}
		document.write('<tr>');
		document.write('<td class="article_code">'+v.article_id+'</td>');
		document.write('<td class="title">'+v.title+'</td>');
		document.write('<td class="qty">'+v.qty+'</td>');
		//price_terms
		document.write('<td class="price">'+eval(v.price).toFixed(2)+'</td>');
		document.write('<td class="tp_price">'+tp_price.toFixed(2)+'</td>');
		document.write('<td class="discount">'+discount.toFixed(2)+'</td>');
		document.write('<td class="vat">'+vat.toFixed(2)+'</td>');
		var p;
		if(tp_price){
			p=tp_price;
		}else{
			p=v.price;
		}
		var item_total=eval(v.qty) * (p-discount)-vat;
		subTotal+=item_total;
		document.write('<td class="station_id">'+item_total+'</td>');
		//document.write('<td class="no-print"><a href="?com=sales&view=sale&task=edit&id='+v.id+'" title="Edit">Edit</a></td>');
		document.write('</tr>');
	});
		</script>
		
		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">Total:</th><th><script>document.write(subTotal);</script></th>
			</tr>
		</tfoot>
	</table>