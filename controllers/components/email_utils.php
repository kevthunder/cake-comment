<?php 
class EmailUtilsComponent extends Object
{
	var $components = array('Email');
	var $controller = null;
	var $templatePlugin = null;
	
	function initialize(&$controller) {
		$this->controller =& $controller;
	}
	function init(&$controller) {
		$this->controller =& $controller;
	}
	
	function setConfig($conf){
		$this->reset( );
		if(!empty($conf['to'])){
			$this->Email->to = $conf['to'];
		}
		if(!empty($conf['subject'])){
			$this->Email->subject = $conf['subject'];
		}
		if(!empty($conf['sender'])){
			$this->Email->from = $conf['sender'];
		}
		if(!empty($conf['replyTo'])){
			$this->Email->replyTo = $conf['replyTo'];
		}else{
			$this->Email->replyTo = $conf['sender'];
		}
		if(!empty($conf['template'])){
			$tmpl = $conf['template'];
			if(strpos($conf['template'],'.') !== false){
				list($this->templatePlugin,$tmpl) = explode('.',$conf['template'],2);
			}
			$this->Email->template = $tmpl;
		}
		if(!empty($conf['layout'])){
			$this->Email->layout = $conf['layout'];
		}
		if(!empty($conf['sendAs'])){
			$this->Email->sendAs = $conf['sendAs'];
		}
		if(!empty($conf['attachments'])){
			$this->Email->attachments = $conf['attachments'];
		}
	}
	function set( $one, $two = NULL ){
		$this->controller->set($one, $two);
	}
	
	function reset(){
		$this->templatePlugin = null;
		$this->Email->reset();
	}
	
	function send($content = null){
		if(!empty($this->templatePlugin)){
			$o_plugin = $this->controller->plugin;
			//debug($this->templatePlugin);
			$this->controller->plugin = $this->templatePlugin;
			$res = $this->Email->send($content);
			$this->controller->plugin = $o_plugin;
		}else{
			$res = $this->Email->send($content);
		}
		return $res;
	}
	
	function defaultEmail($firstPart='info'){
		return $firstPart.'@'.$this->get_base_server_name();
	}
	function get_base_server_name(){
		$server_name = $_SERVER['SERVER_NAME'];
		if(substr_count($server_name,'.')>1){
			$server_name = preg_replace('!^[^.]*\\.!','', $server_name);
		}
		return $server_name;
	}
}
?>