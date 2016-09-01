<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_leave_types_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_leave_types_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_half_day')); ?>:</b>
	<?php echo CHtml::encode($data->is_half_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason')); ?>:</b>
	<?php echo CHtml::encode($data->reason); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('approved')); ?>:</b>
	<?php echo CHtml::encode($data->approved); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viewed_by_manager')); ?>:</b>
	<?php echo CHtml::encode($data->viewed_by_manager); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manager_remark')); ?>:</b>
	<?php echo CHtml::encode($data->manager_remark); ?>
	<br />

	*/ ?>

</div>