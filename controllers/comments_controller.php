<?php
class CommentsController extends CommentAppController {

	var $name = 'Comments';

	
	function beforeFilter() {
		parent::beforeFilter();
		$this->toPass = array_intersect_key($this->params['named'],array_flip(array('model','foreign_key')));
		$this->set('toPass',$this->toPass);
	}
	
	/*function index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

	function view($id = null) {
		if(!$id && isset($this->params['named']['id']) && is_numeric($this->params['named']['id'])) {
			$id = $this->params['named']['id'];
		}
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'comment'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}*/

	
	function admin_index() {
		$q = null;
		if(isset($this->params['named']['q']) && strlen(trim($this->params['named']['q'])) > 0) {
			$q = $this->params['named']['q'];
		} elseif(isset($this->data['Comment']['q']) && strlen(trim($this->data['Comment']['q'])) > 0) {
			$q = $this->data['Comment']['q'];
			$this->params['named']['q'] = $q;
		}
		if(!empty($this->params['named']['model'])){
			$this->paginate['conditions']['model'] = $this->params['named']['model'];
			if(!empty($this->params['named']['foreign_key'])){
				$this->paginate['conditions']['foreign_key'] = $this->params['named']['foreign_key'];
				$model = ClassRegistry::init($this->params['named']['model']);
				$forDF = $model->displayField;
				if($forDF == $model->primaryKey){
					if($model->hasField('title')){
						$forDF = 'title';
					}elseif($model->hasField('title_fre')){
						$forDF = 'title_fre';
					}
				}
				$for = $model->find('first',array('fields'=>array($model->primaryKey, $forDF.' as title'),'conditions'=>array($model->primaryKey =>$this->params['named']['foreign_key']),'recursive'=>-1));
				$for = $for[$model->alias];
				if($forDF == $model->primaryKey){
					$for['title'] = $this->params['named']['model'].'  #'.$for['title'];
				}
				$this->set('for', $for);
			}
		}
					
		if($q !== null) {
			$this->paginate['conditions']['OR'] = array('Comment.text LIKE' => '%'.$q.'%',
														'Comment.model LIKE' => '%'.$q.'%',
														'Comment.name LIKE' => '%'.$q.'%',
														'Comment.email LIKE' => '%'.$q.'%');
		}
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Comment->create();
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'comment'));
				$this->redirect(array_merge($this->toPass,array('action' => 'index')));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'comment'));
			}
		}
		$users = $this->Comment->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'comment'));
			$this->redirect(array_merge($this->toPass,array('action' => 'index')));
		}
		if (!empty($this->data)) {
			if ($this->Comment->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'comment'));
				$this->redirect(array_merge($this->toPass,array('action' => 'index')));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'comment'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$this->set(compact('users'));
	}
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'comment'));
			$this->redirect(array_merge($this->toPass,array('action'=>'index')));
		}
		if ($this->Comment->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Comment'));
			$this->redirect(array_merge($this->toPass,array('action'=>'index')));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Comment'));
		$this->redirect(array_merge($this->toPass,array('action' => 'index')));
	}
	
}
?>