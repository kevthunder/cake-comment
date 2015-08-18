<div class="comments index">
	<?php
		echo $this->Form->create('Comment', array('class' => 'search', 'url' => array('action' => 'index')));
		echo $this->Form->input('q', array('class' => 'keyword', 'label' => false, 'after' => $form->submit(__('Search', true), array('div' => false))));
		echo $this->Form->end();
	?>	
	<h2><?php __('Comments');?></h2>
	
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>			
			<th><?php echo $this->Paginator->sort('text');?></th>			
			<th><?php echo $this->Paginator->sort('model');?></th>			
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>			
			<th><?php echo $this->Paginator->sort('name');?></th>			
			<th><?php echo $this->Paginator->sort('email');?></th>			
			<th><?php echo $this->Paginator->sort('user_id');?></th>			
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
						<td class="text"><?php echo $text->truncate($comment['Comment']['text'], 150, array('exact' => false)); ?>&nbsp;</td>
						<td class="model"><?php echo $comment['Comment']['model']; ?>&nbsp;</td>
						<td class="foreign_key"><?php echo $comment['Comment']['foreign_key']; ?>&nbsp;</td>
						<td class="name"><?php echo $comment['Comment']['name']; ?>&nbsp;</td>
						<td class="email"><?php echo $comment['Comment']['email']; ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($comment['User']['id'], array('controller' => 'users', 'action' => 'view', $comment['User']['id'])); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link(__('View', true), array('action' => 'view', $comment['Comment']['id']), array('class' => 'view')); ?>
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
