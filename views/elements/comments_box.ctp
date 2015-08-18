<div class="commentsBox">
	<?php
		if(isset($comments)){
			$commentsData['comments'] = $comments;
		}
		if(isset($foreign_model)){
			$commentsData['model'] = $foreign_model;
		}
		if(isset($foreign_key)){
			$commentsData['foreign_key'] = $foreign_key;
		}
		$count = 0;
		if(!empty($commentsData['comments'])){
			$count = sizeof($commentsData['comments']);
		}
	?>
	<h2><?php echo $count ?> <?php if(sizeof($count)>1){ __('commentaires'); }else{ __('commentaire'); }; ?></h2>

	<div class="list">
	<?php 
		if(!empty($commentsData['comments'])){
			foreach($commentsData['comments'] as $comment){
				echo $this->element('comment',array('plugin'=>'comment','comment'=>$comment));
			} 
		}
	?>
	</div>
	<div class="form">
		<h3><?php __('Soumettre un commentaire'); ?></h3>
		<?php
			echo $this->element('comment_form',array('plugin'=>'comment','commentsData'=>$commentsData));
		?>
	</div>
</div>