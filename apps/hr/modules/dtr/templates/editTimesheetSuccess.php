<?php use_helper('Javascript'); ?>
	<?php 	
	
		$save 	= link_to('Save', '#', 'id="save_'.$summary['record_id'].'"');
		$cancel = link_to('Cancel', '#', 'id="cancel_'.$summary['record_id'].'"');
		?>
		
<td nowrap><small><?php echo $summary['seq'] ?></small></td>
<td class=""><small>
	<?php 
		echo $save .'|'. $cancel;
	?>
	</small></td>
<td ><small><?php echo $summary['name'] //echo input_tag('name', $sf_params->get('name'), array('class'=>'span2', 'readonly'=>'readonly') ) ?></small></td>
<td ><?php 
		if ($sf_params->get('meal') == 0 ):
			$sf_params->set('meal', '');
		endif;
		if ($sf_params->get('hrs') == 0 ):
			$sf_params->set('hrs', '');
		endif;
		
		$timeInID = 'time_in_'. $summary['record_id'];
		$timeOutID = 'time_out_'. $summary['record_id'];
		$hrsID = 'hrs_'. $summary['record_id'];
		$mealID = 'meal_'. $summary['record_id'];
		
		echo AjaxLib::AjaxScript('cancel_' . $summary['record_id'], 'dtr/updateDtr', '', 'is_cancel=yes&id='.$summary['record_id'].'&divID='.$summary['divID'], 'tr_'. $summary['divID']);
		//echo AjaxLib::AjaxScript('save_' . $summary['record_id'], 'dtr/updateDtr', 'time_in, time_out, hrs, meal', 'is_cancel=no&id='.$summary['record_id'].'&divID='.$summary['divID'], 'tr_'. $summary['divID']);
		echo AjaxLib::AjaxScript('save_' . $summary['record_id'], 'dtr/updateDtr', $timeInID.",". $timeOutID.",". $hrsID.",". $mealID , 'is_cancel=no&id='.$summary['record_id'].'&divID='.$summary['divID'], 'tr_'. $summary['divID']);
		
echo  input_tag($timeInID, $sf_params->get('time_in'), array('size'=>'18')) ?></td>
<td nowrap><small><?php echo $sf_params->get('time_out') //echo  input_tag('time_out', $sf_params->get('time_out'), array('class'=>'span3')) ?></small></td>
<td nowrap><small><?php echo  input_tag($hrsID, $sf_params->get('hrs'), array('size'=>'4', 'onClick'=>'this.select()', 'placeholder'=>'hrs')) ?></td>
<td nowrap><small><?php echo  input_tag($mealID, $sf_params->get('meal'), array('size'=>'4', 'onClick'=>'this.select()', 'placeholder'=>'meal' )) ?></td>
<td nowrap><small><?php echo $summary['ac_dura'] ?></small></td>
<td nowrap><small><?php echo $summary['normal'] ?></small></td>
<td nowrap><small><?php echo $summary['overtime'] ?></small></td>
<td nowrap><small><?php echo $summary['undertime'] ?></small></td>
<td nowrap><small><?php echo $summary['multiplier'] ?></small></td>
<td nowrap><small><?php echo $summary['holiday'] ?></small></td>
<td nowrap><small><?php echo $summary['leave_type'] ?></small></td>
<td nowrap><small><?php echo $summary['attendance'] ?></small></td>
<?php if (HrLib::GetUser() == 'emmanuel'): ?>
<td nowrap><small><?php echo $summary['amount'] ?></small></td>
<td nowrap><small><?php echo $summary['rate_per_hour'] ?></small></td>
<td nowrap><small><?php echo $summary['parttime'] ?></small></td>
<td nowrap><small><?php echo $summary['allowance'] ?></small></td>
<td nowrap><small><?php echo $summary['levy'] ?></small></td>
<td nowrap><small><?php echo $summary['dayoff'] ?></small></td>
<?php endif; ?>
