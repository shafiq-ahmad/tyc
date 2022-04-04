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

import('core.application.component.view');
class SubscriptionsViewSubscriptions extends View{
	public $id=0;
	public $rows=null;
	public function display($tpl = null){
		$id=$this->getVar('id',null, 'post');
		$payment_method=$this->getVar('payment_method',null, 'post');
		$this->app = core::getApplication();
		if(Application::$options->task=='json'){
			$this->app->setTmpl('json');
		}else{
			$this->app->setTmpl('page');
		}
		$this->app->setTitle('Subscriptions');
		$m_cart = $this->getModel('cart.cart');
		$this->payment_methods = $m_cart->getPaymentMethods($payment_method);
		$model = $this->getModel('subscriptions');
		$this->rows = $model->getSubscriptions($id);
		$this->vehicle_types = array(1=>'Regular', 2=>'Bike' , 3=>'Big Pickup');
		parent::display($tpl);
	}
}
