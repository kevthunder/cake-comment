<?php __('Bonjour'); ?>,<br>
<?php 
	echo str_replace(
		array('%site%','%display_val%'),
		array($site,$displayVal),
		__('Un nouveau commentaire a été publié sur %site% à propos de %display_val%',true)
	); 
?><br><br>
<b><?php __('Voici le commentaire'); ?> :</b><br>
<?php echo nl2br(h($comment['Comment']['text'])); ?>
<br><br><br>
<?php 
	$defaultActive = CommentConfig::load('adminValidation.defaultActive');
	echo str_replace(
		array('[a]','[/a]'),
		array('<a href="'.$this->Html->url(array('plugin'=>'comment','controller'=>'comments','action'=>'edit','admin'=>true,$comment['Comment']['id']),true).'">','</a>'),
		__('Pour '.($defaultActive?'désactiver':'activer').' ce commentaire, [a]Cliquez ici[/a].',true)
	);
?>
