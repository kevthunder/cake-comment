<div class="comments form">
	<?php echo $this->Form->create('Comment',array('url'=>$toPass));?>
		<fieldset>
			<legend><?php printf(__('Add %s', true), __('Comment', true)); ?></legend>
			<?php
				echo $this->Form->input('active', array('checked' => 'checked'));
				echo $this->Form->input('text');
				echo $this->Form->input('model');
				echo $this->Form->input('foreign_key');
				echo $this->Form->input('name');
				echo $this->Form->input('email');
				echo $this->Form->input('user_id',array('empty'=>true));
			?>
		</fieldset>
	<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Comments', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>