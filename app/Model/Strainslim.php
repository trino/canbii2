<?php
class Strainslim extends AppModel
{
    public $alias = "Strain";
    public $useTable = 'strains';
    public $uses = array('Strain');
    public $belongsTo = array(
        'StrainType' => array(
            'className' => 'StrainType',
            'foreignKey' => 'type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public $hasMany=array('Review'=>array('className'=>'Review',
            'foreignKey'=>'strain_id',
            'dependent'=>true,
            'exclusive'=>true
        )
    );
}