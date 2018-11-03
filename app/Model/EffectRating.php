<?php 
class EffectRating extends AppModel {
	 public $belongsTo = array(
		'Effect' => array(
			'className' => 'Effect',
			'foreignKey' => 'effect_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        );
    public $hasAndBelongsToMany =array(
        'Review' => array(
            'className'=>'Review',
            'foreignKey'=>'review_id',
            'conditions' => '',
			'fields' => '',
			'order' => ''
            )
	);
 
}
?>
