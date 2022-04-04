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
class Public_profileViewUsers extends View{
	public $id=0;
	public function display($tpl = null){
		$model = $this->getModel('profile');
		$m_public = $this->getModel('public_profile');
		$this->app = core::getApplication();
		$this->app->setTitle('User\'s Profile');
		$this->app->setTmpl('full');
		$model = $this->getModel('user');
		$models = $this->getModel('lists.lists');
		$this->id=$this->getVar('seller',null,'get');
		if(!$this->id){
			$this->setMessage('Seller is not Selected.','danger');
			$this->redirect('index.php');
		}
		
		$this->user = $model->getById($this->id);
		$this->avg_rating	= $m_public->getUserReviewsGroup($this->id)['avg_rating'];
		$this->reviews	= $m_public->getUserReviews($this->id);
		$this->countries = $models->getCountries();
		parent::display($tpl);
	}
	
	public function getStars($sel,$count=5){
		$sel_rating=' selected_rating';
		for($a=1; $a<=$count;$a++):
			//echo '<div class="rev';
			echo '<span class="rating';
			if($a<=$sel){
				echo $sel_rating;
			}
			echo '"></span>';
		endfor;
	}
}
