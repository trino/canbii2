<?php 
class ReviewColor extends AppModel {
	 public $belongsTo = array(
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'review_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        );
    
 
}
?>
