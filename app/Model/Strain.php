<?php
class Strain extends AppModel {
    public $uses = array('EffectRating','Strain');
	public $hasMany=array(
        'OverallEffectRating'=>array('className'=>'OverallEffectRating',
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

    public function afterFind($results, $primary = false) {
        foreach($results as $KEY => $DATA) {
            if (isset($DATA["Strain"]["name"])) {
                $NAME = trim(str_replace( chr( 194 ) . chr( 160 ), ' ', $DATA["Strain"]["name"]));
                $results[$KEY]['Strain']['name'] = $NAME;
            }
        }
        return $results;
    }

    /*
    public $conditions = array('hasocs' => 1);
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        $queryData['conditions'] = array('hasocs' => 1);
        return $queryData;
    }
    */
}