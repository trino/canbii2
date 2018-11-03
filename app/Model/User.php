<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property Auth $Auth
 * @property user $user
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
    
        'confirm_password' => array(
            'equaltofield' => array(
            'rule' => array('equaltofield','password'),
            'message' => 'Require the same value to password.',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'username' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
        'rule'    => array('checkEmail'),
        'message' => 'Not a valid email address.' 
        ),
	2);

function equaltofield($check,$otherfield)
    {
        //get name of field
        $fname = '';
        foreach ($check as $key => $value){
            $fname = $key;
            break;
        }
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname];
    } 
    function checkEmail($val)
    {
        $value = $val['email'];
        //var_dump($value);die();
        if(str_replace(' ','',$value)!=$value)
        return false;
        if($value=='')
        return false;
        else
        {
            $arr = explode('@',$value);
            //var_dump($arr);die();
            if(count($arr)>1)
            {
                $domain = $arr[1];
                $arr2 = explode('.',$domain);
                if(count($arr2)>1)
                return true;
                else
                return false;
            }
            else
            return false;
        }
    }

    

}
