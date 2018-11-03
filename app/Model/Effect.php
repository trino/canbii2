<?php
class Effect extends AppModel
{
    public $hasMany=array('EffectRating'=>array('className'=>'EffectRating',
                                 'foreignKey'=>'effect_id',
                                 'dependent'=>true,
                                 'exclusive'=>true
                                ),
                    );
}