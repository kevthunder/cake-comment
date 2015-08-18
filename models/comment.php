<?php
class Comment extends CommentAppModel {
	var $name = 'Comment';
	var $displayField = 'name';
	var $validate = array(
		'model' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'foreign_key' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	function __construct( $id = false, $table = NULL, $ds = NULL ){
		if(in_array('Captcha',App::objects('plugin'))){
			$this->actsAs[] = 'Captcha.Captcha';
		}
		if(in_array('NoSpam',App::objects('plugin'))){
			$this->actsAs['NoSpam.NoSpam'] = array('fields' => array('name','text','email'));
		}
		parent::__construct( $id, $table, $ds );
	}
	
	function beforeValidate(){
		App::import('Lib', 'Comment.CommentConfig');
		$minChar = CommentConfig::load('minChar');
		if(!empty($minChar)){
			$this->validate['text'] = array(
				'minlength' => array(
					'rule' => array('minlength', $minChar),
					'message' => sprintf(__('Your text must contain at least %s characters',true), $minChar),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			);
		}else{
			unset($this->validate['text']);
		}
		if(empty($this->data[$this->alias]['user_id'])){
			$this->validate['name'] = array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			);
			$this->validate['email'] = array(
				'notempty' => array(
					'rule' => array('notempty'),
					//'message' => 'Your custom message here',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
				'email' => array(
					'rule' => array('email', true),
					//'message' => 'Your custom message here',
				),
			);
		}else{
			unset($this->validate['name']);
			unset($this->validate['email']);
		}
	}
}
?>