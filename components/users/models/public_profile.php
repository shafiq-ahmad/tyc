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

class ModelPublic_profile extends Model{
	
	public function getUserReviews($id){
		$db = Core::getDBO();
		$sql="SELECT ur.*, u.full_name FROM user_reviews AS ur ";
		$sql.="INNER JOIN users AS u ON (ur.by_user = u.id)";
		$sql.="WHERE user_id={$id}";
		$rows = $db->get_by_sqlRows($sql);
		return $rows;
	}

	public function getUserReviewsGroup($id){
		if(!$id){return false;}
		$db = Core::getDBO();
		$sql="SELECT AVG(rating) AS avg_rating FROM user_reviews AS ur ";
		$sql.="WHERE user_id={$id}";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function getByToReview($for , $to){
		$db = Core::getDBO();
		$sql="SELECT * FROM user_reviews ";
		$sql.="WHERE user_id={$for} AND by_user={$to} LIMIT 1";
		$row = $db->get_by_sqlRow($sql);
		return $row;
	}

	public function add_review(){
		$this->table = 'user_reviews';
		$user = Core::getUser()->getUser();
		$this->data['by_user'] = $user['id'];
		//$this->data['user_id'] = $this->getVar('seller',0,'post');
		
		$this->setRedirect('?com=users&view=public_profile&seller=' . $this->data['user_id']);
		if($this->getByToReview($this->data['user_id'], $user['id'])){
			$this->setMessage(Localize::_('review_exist'),'warning');
			return false;
		}
		return parent::add();
	}

}

