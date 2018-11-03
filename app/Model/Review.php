<?php
class Review extends AppModel
{
     public $uses = array('EffectRating','Strain');
	public $hasMany=array('EffectRating'=>array('className'=>'EffectRating',
                                 'foreignKey'=>'review_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                'SymptomRating'=>array('className'=>'SymptomRating',
                                 'foreignKey'=>'review_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                'FlavorRating'=>array('className'=>'FlavorRating',
                                 'foreignKey'=>'review_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                                
                                
                                      
                );
                
    public $hasOne= array('ReviewColor'=>array('className'=>'ReviewColor',
                                 'foreignKey'=>'review_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                )
                    );
     public $belongsTo = array(
		'Strain' => array(
			'className' => 'Strain',
			'foreignKey' => 'strain_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'fields' => array('username'),
        )
        
	);           
}