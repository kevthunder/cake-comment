<?php
class CommentConfig extends Object {
	/*
		App::import('Lib', 'Comment.CommentConfig');
		CommentConfig::load();
	*/
	
	var $loaded = false;
	var $defaultConfig = array(
		'minChar' => 10,
		'adminValidation' => array(
			'defaultActive' => false,
		),
	);
	var $trueToDefault = array(
		'adminValidation'
	);
	
	//$_this =& CommentConfig::getInstance();
	function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] =& new CommentConfig();
		}
		return $instance[0];
	}
	
	function _parseTrueToDefault($config){
		$_this =& CommentConfig::getInstance();
		$trueToDefault = Set::normalize($_this->trueToDefault);
		foreach($trueToDefault as $path => $options){
			if(Set::extract($path,$config) === true){
				if(empty($options)){
					$options = Set::extract($path,$_this->defaultConfig);
				}
				$config = Set::insert($config,$path,$options);
			}
		}
		return $config;
	}
	
	function load($path = true){
		$_this =& CommentConfig::getInstance();
		if(!$_this->loaded){
			config('plugins/comment');
			$config = Configure::read('Comment');
			$config = Set::merge($_this->defaultConfig,$config);
			$config = $_this->_parseTrueToDefault($config);
			Configure::write('Comment',$config);
			$_this->loaded = true;
		}
		if(!empty($path)){
			return Configure::read('Comment'.($path!==true?'.'.$path:''));
		}
	}
	
}
?>