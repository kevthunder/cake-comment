
<div class="comments index">
	<?php
		echo $this->Form->create('Comment', array('class' => 'search', 'url' => array('action' => 'index')));
		echo $this->Form->input('q', array('class' => 'keyword', 'label' => false, 'after' => $form->submit(__('Search', true), array('div' => false))));
		echo $this->Form->end();
	?>	
	<?php if(!empty($for)) { ?>
		
	<h2><?php echo sprintf(__('Comments for %s', true), $for['title']); ?></h2>
	<?php }else{ ?>
	<h2><?php __('Comments');?></h2>
	<?php } ?>
	
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>					
			<th><?php echo $this->Paginator->sort('name');?></th>	
			<th><?php echo $this->Paginator->sort('email');?></th>						
			<th><?php echo $this->Paginator->sort(__('Date',true),'created');?></th>		
			<th><?php echo $this->Paginator->sort('text');?></th>			
			<th><?php echo $this->Paginator->sort('active');?></th>				
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
			$i = 0;
			$bool = array(__('No', true), __('Yes', true), null => __('No', true));
			foreach ($comments as $comment) {
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				?>
					<tr<?php echo $class;?>>
						<td class="id"><?php echo $comment['Comment']['id']; ?>&nbsp;</td>
						<td class="name"><?php 
							if(!empty($comment['User']['id'])){
								echo $this->Html->link($comment['User']['first_name'].' '.$comment['User']['last_name'], array('controller' => 'users', 'action' => 'edit', $comment['User']['id']));
							}else{
								echo $comment['Comment']['name']; 
							}
						?>&nbsp;</td>
						<td class="email"><?php 
							if(!empty($comment['User']['id'])){
								echo $comment['User']['email'];
							}else{
								echo $comment['Comment']['email'];
							}
						?>&nbsp;</td>
						<td class="email"><?php echo $comment['Comment']['created']; ?>&nbsp;</td>
						<td class="text"><?php echo $text->truncate($comment['Comment']['text'], 150, array('exact' => false)); ?>&nbsp;</td>
						<td class="model"><?php echo $bool[$comment['Comment']['active']]; ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Edit', true), array_merge($toPass,array('action' => 'edit', $comment['Comment']['id'])), array('class' => 'edit')); ?>
							<?php echo $this->Html->link(__('Delete', true), array_merge($toPass,array('action' => 'delete', $comment['Comment']['id'])), array('class' => 'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $comment['Comment']['id'])); ?>
						</td>
					</tr>
				<?php
			}
		?>
	</table>
	
	<p class="paging">
		<?php
			echo $this->Paginator->counter(array(
				'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
			));
		?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('« '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |
		<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' »', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Comment', true)), array_merge($toPass,array('action' => 'add'))); ?></li>		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>