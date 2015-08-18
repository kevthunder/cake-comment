<?php 
	if(isset($commentsData['postSuccess']) && $commentsData['postSuccess'] === true){ 
		echo $this->element('comment_success',array('plugin'=>'comment','commentsData'=>$commentsData));
	}else{
		$url = Router::parse($this->params['url']['url']);
		$url = array_merge($url,$url['named'],$url['pass']);
		unset($url['named'],$url['pass']);
		$formId = 'CommentAdd'.$commentsData['model'].$commentsData['foreign_key'].'form';
		echo $this->Form->create('Comment',array('id'=>$formId, 'url'=>$url));
			if(isset($commentsData['postSuccess']) && $commentsData['postSuccess'] === false){
				$this->Html->scriptBlock('
					(function( $ ) {
						$(function(){
							window.location.hash = "'.$formId.'";
						})
					})( jQuery );
				',array('inline'=>false));
				echo '<p class="notice error">'.__('Some errors were detected in your form.',true).'</a>)</p>';
			}
			echo $this->Form->input('model',array('value' => $commentsData['model'], 'type'=>'hidden'));
			echo $this->Form->input('foreign_key',array('value' => $commentsData['foreign_key'], 'type'=>'hidden'));
			if(!isset($user)){ 
				echo $this->Form->input('name',array('after'=>'<span class="note required">('.__('Required',true).')</span>'));
				echo $this->Form->input('email',array('after'=>'<span class="note required">('.__('Requis, mais ne sera pas publié',true).')</span>'));
			}else{
				echo '<p class="userInfo">'.sprintf(__('Leave a comment as %s.',true), $user['User']['first_name'].' '.$user['User']['last_name']).' (<a href="'.$this->Html->url(array('plugin'=>'auth','controller'=>'users','action'=>'logout')).'">'.__('Logout',true).'</a>)</p>';
			}
			App::import('Lib', 'Comment.CommentConfig');
			$minChar = CommentConfig::load('minChar');
			$inputOpt = array('label'=>__('Comment',true));
			if($minChar){
				$inputOpt['after'] = '<span class="note minLength">('.sprintf(__('%s characters minimum',true), $minChar).')</span>';
			}
			echo $this->Form->input('text',$inputOpt);
			if(is_object($this->Captcha)){
				echo $this->Captcha->captcha();
			}
		echo $this->Form->end(__('Submit',true));
	} 
 ?>