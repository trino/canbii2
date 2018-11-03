<?php 
class BuzzType extends AppModel {
	
  public $uses = array('BuzzType','Strain');
	public $hasMany=array('Strain'=>array('className'=>'Strain',
                                 'foreignKey'=>'buzz_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                )
                );
}
?>
