<?php 
class StrainType extends AppModel {
	
  public $uses = array('StrainType','Strain');
	public $hasMany=array('Strain'=>array('className'=>'Strain',
                                 'foreignKey'=>'type_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                )
                );
}
?>
