<?php
class Strain extends AppModel
{
     public $uses = array('EffectRating','Strain');
	public $hasMany=array('OverallEffectRating'=>array('className'=>'OverallEffectRating',
                                 'foreignKey'=>'strain_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                'OverallSymptomRating'=>array('className'=>'OverallSymptomRating',
                                 'foreignKey'=>'strain_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                'Flavorstrain'=>array('className'=>'Flavorstrain',
                                 'foreignKey'=>'strain_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                
                                'Review'=>array('className'=>'Review',
                                 'foreignKey'=>'strain_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                'StrainImage'=>array('className'=>'StrainImage',
                                 'foreignKey'=>'strain_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                      
                );
     public $belongsTo = array(
		'StrainType' => array(
			'className' => 'StrainType',
			'foreignKey' => 'type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);           
}