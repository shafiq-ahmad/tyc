<?php
defined('_MEXEC') or die ('Restricted Access');


?><div class="com-head">
	<h3>Daily Overview</h3>
</div>
<div class="form"></div>
<div class="table-responsive"><div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="home" />
			<input type="hidden" name="view" value="summery" />
			<div>
			<div class="date-range">
				<input type="date" name="start_date" id="start_date"class="inputbox date-default" value="" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success btn-lg btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
</div>
<div class="grid">
	<div class="row">
		<div class="col-sm-2">Sale Bills</div>
		<div class="col-sm-1 value">Total #: <span class="badge"><?php echo $this->row['SaleBills'];?></span></div>
		<div class="col-sm-1 value">Discount: <span class="badge"><?php echo $this->row['countDiscount'];?></span></div>
		<div class="col-sm-1 value">Credit: <span class="badge"><?php echo $this->row['countCredit'];?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2">Amount</div>
		<div class="col-sm-2 value">Total: <span class="badge"><?php echo $this->row['TotalSum'];?></span></div>
		<div class="col-sm-2 value">Discount: <span class="badge"><?php echo $this->row['DiscountSum'];?></span></div>
		<div class="col-sm-2 value">Cash: <span class="badge"><?php echo $this->row['cashSum'];?></span></div>
		<div class="col-sm-2 value">Credit: <span class="badge"><?php echo $this->row['creditSum'];?></span></div>
	</div><hr/>
	<div class="row">
		<div class="col-sm-2">Purchase Bills</div>
		<div class="col-sm-1 value">Total #: <span class="badge"><?php echo $this->rowPur['Bills'];?></span></div>
		<div class="col-sm-1 value">Entered: <span class="badge"><?php echo $this->rowPur['BillClosed'];?></span></div>
		<div class="col-sm-1 value">Open: <span class="badge"><?php echo $this->rowPur['BillsOpen'];?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2">Amount</div>
		<div class="col-sm-2 value">Total: <span class="badge"><?php echo $this->rowPur['TotalSum'];?></span></div>
		<div class="col-sm-2 value">Cash: <span class="badge"><?php echo $this->rowPur['cashSum'];?></span></div>
		<div class="col-sm-2 value">Credit: <span class="badge"><?php echo $this->rowPur['creditSum'];?></span></div>
	</div><hr/>
	<div class="row">
		<div class="col-sm-2">Expenses</div>
		<div class="col-sm-2 value"></div>
	</div><hr/>
	<div class="row">
		<div class="col-sm-2">Item Received</div>
		<div class="col-sm-2 value">Type: <span class="badge"><?php //echo $this->rowPur['itemCount'];?></span></div>
		<div class="col-sm-2 value">Qty: <span class="badge"><?php //echo $this->rowPur['itemsQty'];?></span></div>
	</div>
</div>