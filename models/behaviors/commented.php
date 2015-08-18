<?php
class CommentedBehavior extends ModelBehavior {

	function setup(&$model, $config = array()) {
		$conditions = array('Comment.model'=>$model->name);
		if(!Configure::read('admin')) {
			$conditions['Comment.active'] = 1;
		}
		$model->bindModel( array('hasMany' => array(
			'Comment' => array(
				'className' => 'Comment.Comment',
				'foreignKey' => 'foreign_key',
				'dependent' => false,
				'conditions' => $conditions,
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
		)),false);
	}
	
	function getCommentJoin(&$model){
		return array(
			'alias' => $model->Comment->alias,
			'table'=> $model->Comment->useTable,
			'type' => 'LEFT',
			'conditions' => array(
				array($model->Comment->alias.'.model'=>$model->name),
				array($model->Comment->alias.'.foreign_key = '.$model->alias.'.'.$model->primaryKey),
			)
		);
	}
}