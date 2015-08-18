 <?php
 	if(isset($comment['Comment'])){
		$comment = array_merge($comment,$comment['Comment']);
	}
 ?>
 <div class="commentaire clearfix">
	<p class="name"><?php echo isset($comment['User']['first_name'])?$comment['User']['first_name'].' '.$comment['User']['last_name']:$comment['name']; ?></p>
	<p class="date"><?php echo date_("j M Y",strtotime($comment['created'])); ?></p>
	<div class="texte"><?php echo nl2br(h($comment['text'])); ?></div>
</div>