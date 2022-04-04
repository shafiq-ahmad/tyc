<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/

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

				<label class="control-label" for="start_date">Start date:</label>
				<input type="date" name="start_date" id="start_date"class="inputbox date-default" value="<?php if(isset($_GET['start_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['start_date']));}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input type="date" name="end_date" id="end_date"class="inputbox date-default" value="<?php if(isset($_GET['end_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['end_date']));}?>" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success screen btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
</div>
<div class="grid grid-bordered">
	<div class="row">
		<div class="col-sm-2"><strong>Headings</strong></div>
		<div class="col-sm-1"><strong>Amouont</strong></div><div class="col-sm-1"><strong>Cash</strong></div><div class="col-sm-1"><strong>Credit</strong></div>
		<div class="col-sm-1"><strong>Discount</strong></div><div class="col-sm-2"><strong>Transcations</strong></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Sales</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->row['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->row['cashSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->row['creditSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->row['DiscountSum'],1);?></span></div>
		<div class="col-sm-2 value"><span class="badge"><?php echo round($this->row['SaleBills'],1);?></span>
		Disc: <span class="badge"><?php echo round($this->row['countDiscount'],1);?></span>
		Credit: <span class="badge"><?php echo round($this->row['countCredit'],1);?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Purchase returns</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowPR['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowPR['cashSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowPR['creditSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
		<div class="col-sm-2 value"><span class="badge"><?php echo round($this->rowPR['Bills'],1);?></span>
		Entered: <span class="badge"><?php echo round($this->rowPR['BillClosed'],1);?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Cash Received</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php //echo round($this->rowPR['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>A/C Receivibles</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php //echo round($this->rowPR['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
		<div class="col-sm-1 value"><span class="badge"></span></div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-sm-2"><strong>Purchase</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowPur['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowPur['cashSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowPur['creditSum'],1);?></span></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php echo round($this->rowPur['Bills'],1);?></span>
		Entered: <span class="badge"><?php echo $this->rowPur['BillClosed'];?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Sales returns</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowSR['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowSR['TotalCash'],1);?></span></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowSR['TotalCredit'],1);?></span></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php echo round($this->rowSR['Bills'],1);?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Expenses</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php echo round($this->rowExp['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php echo round($this->rowExp['Bills'],1);?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>Cash Paid</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php //echo round($this->rowExp['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php //echo round($this->rowExp['Bills'],1);?></span></div>
	</div>
	<div class="row">
		<div class="col-sm-2"><strong>A/C Payables</strong></div>
		<div class="col-sm-1 value"><span class="badge"><?php //echo round($this->rowExp['TotalSum'],1);?></span></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value"></div>
		<div class="col-sm-1 value">&nbsp;</div>
		<div class="col-sm-2 value"><span class="badge"><?php //echo round($this->rowExp['Bills'],1);?></span></div>
	</div>
	<hr/>
</div>