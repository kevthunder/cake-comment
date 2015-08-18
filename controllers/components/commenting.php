<?php
//fix for for php <5.3
if ( false === function_exists('lcfirst') ):
    function lcfirst( $str )
    { return (string)(strtolower(substr($str,0,1)).substr($str,1));}
endif;


class CommentingComponent extends Object {
	
	var $controller = null;
	var $data = array();
	var $components = array('Email','Comment.EmailUtils');

	function initialize(&$controller) {
		$this->controller = $controller;
		if(in_array('Captcha',App::objects('plugin'))){
			$this->controller->helpers[] = "Captcha.Captcha";
		}
	}
	
	function startup(&$controller) {
		$this->data['model'] = $this->controller->modelClass;
		$model = null;
		if(!empty($this->controller->{$this->data['model']})){
			$model = $this->controller->{$this->data['model']};
		}else{
			$model = ClassRegistry::init($this->data['model']);
		}
		if(!empty($this->controller->{$this->data['model']}->Comment)){
			$this->Comment = $this->controller->{$this->data['model']}->Comment;
		}else{
			$this->Comment = ClassRegistry::init('Comment.Comment');
			$this->controller->modelNames[] = 'Comment';
			$this->controller->Comment = $this->Comment;
		}
		if(!empty($this->controller->data['Comment'])){
			$this->Comment->create();
			$cdata = $this->controller->data['Comment'];
			unset($cdata['user_id']);
			if(!empty($this->controller->user['User']['id'])){
				$cdata['user_id'] = $this->controller->user['User']['id'];
			}
			//debug($cdata);
			App::import('Lib', 'Comment.CommentConfig');
			$adminValidation = CommentConfig::load('adminValidation');
			$cdata['active'] = empty($adminValidation) || $adminValidation['defaultActive'];
			$success = $this->Comment->save($cdata);
			$success = !empty($success);
			if($success && $adminValidation){
				$comment = $model->find('first',array('conditions'=>array($model->primaryKey => $cdata['foreign_key']),'recursive'=>-1));
				$comment['Comment'] = $cdata;
				$comment['Comment']['id'] = $this->Comment->id;
				if(!empty($comment[$model->alias][$model->displayField])){
					$displayVal = $comment[$model->alias][$model->displayField];
				}else{
					$displayVal = $model->alias.' id :'.$comment[$model->alias][$model->primaryKey];
				}
				$site = $this->EmailUtils->get_base_server_name();
				
				$defConf = array(
					'subject' => __('%site%  - New comment',true),
					'to' => $this->EmailUtils->defaultEmail(),
					'sender' => $this->EmailUtils->defaultEmail(),
					'replyTo' => null,
					'sendAs' => 'html', //both because we like to send pretty mail
					'template' => 'Comment.admin_validation',
					'layout' => null
				);
				$conf = array_merge($defConf,(array)$adminValidation);
				$conf['subject'] = str_replace('%site%',$site,$conf['subject']);
				
				$this->EmailUtils->setConfig($conf);
				
				$this->EmailUtils->set('comment', $comment);
				$this->EmailUtils->set('site', $site);
				$this->EmailUtils->set('displayVal', $displayVal);
				
				if(!$this->EmailUtils->send()){
					
				}else{
					
				}
			}
			$this->data['postSuccess'] = $success;
		}
		//debug($this->Comment->validationErrors);
	}
	
	function beforeRender(&$controller) {
		$viewVarName = lcfirst($this->data['model']);
		$m = $this->data['model'];
		if(!empty($this->controller->params['id'])){
			$this->data['foreign_key'] = $this->controller->params['id'];
		}elseif(!empty($this->controller->viewVars[$viewVarName][$m]['id'])){
			$this->data['foreign_key'] = $this->controller->viewVars[$viewVarName][$m]['id'];
		}elseif(!empty($this->controller->params['pass'][0]) && is_numeric($this->controller->params['pass'][0])){
			$this->data['foreign_key'] = $this->controller->params['pass'][0];
		}
		if(!empty($this->controller->viewVars[$viewVarName]) && array_key_exists('Comment',$this->controller->viewVars[$viewVarName])){
			$this->data['comments'] = $this->controller->viewVars[$viewVarName]['Comment'];
		}elseif(!empty($this->data['foreign_key'])){
			$this->data['comments'] = $this->Comment->find('all',array('conditions'=>array('model'=>$m,'foreign_key'=>$this->data['foreign_key'])));
		}
		$this->controller->set('commentsData',$this->data);
	}
}