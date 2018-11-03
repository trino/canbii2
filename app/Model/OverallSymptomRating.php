<?php
class OverallSymptomRating extends AppModel
{
    public $belongsTo = array(
		'Strain' => array(
			'className' => 'Strain',
			'foreignKey' => 'strain_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}