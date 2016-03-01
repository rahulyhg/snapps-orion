<?php sfConfig::set('app_page_heading', 'Leave Request Form'); ?>
<?php use_helper('Validation', 'Javascript') ?>
<?php 
	echo HrLib::DisableEnterKey('Must select the Dates first or Click the Apply Leave Button') ;
	//var_dump($sf_params->get('cmonth'.$leaveID));
	if (! $sf_params->get('cmonth'.$leaveID)):
		$sf_params->set('cmonth'.$leaveID, date('Y-m-01'));
	endif;
?>



<?php //sfConfig::set('app_page_heading', 'Leave Request Form'); 
	$button = '';
	switch($leaveID):
		case 2:
			$button = submit_tag('Apply Annual Leave', 'class="success"');
			break;
		case 6:
			$button = submit_tag('Apply Unpaid Leave', 'class="success"');
			break;
		case 1:
			$button = submit_tag('Apply Medical Leave', 'class="success"');
			break;
		case 8:
			$button = submit_tag('Apply National Service', 'class="success"');
			break;
		case 13:
			$button = submit_tag('Apply Hospitalization', 'class="success"');
			break;
		case 12:
			$button = submit_tag('Apply Maternity', 'class="success"');
			break;
		case 7:
			$button = submit_tag('Apply Child Care', 'class="success"');
			break;
		case 11:
			$button = submit_tag('Apply Compassionate Leave', 'class="success"');
			break;	
	endswitch;
	//echo $leaveID;
?>
<form name="FORMadd" autocomplete="off" id="IDFORMadd" action="<?php echo url_for('leave/leaveEmployeeApply')?>" method="post">

<table class="table super-condensed bordered" >

<tr>
	<td class="bg-clearBlue alignRight"><small><label>Employee</label></small></td>
	<td class="">
		<?php 
			$name  = 'name_'.$leaveID;
			$empno = 'employee_no_'.$leaveID;
			$cmonth= 'cmonth_'.$leaveID;
			$chkbal= 'BTNbalance_'.$leaveID;
			$leaveCNO = 'leave_'. $leaveID;
			echo AjaxLib::AjaxScript($chkbal, 'leave/ajaxLeaveCreditCount', $name.','.$empno.','.$cmonth.','.$leaveCNO,'',"divCalendarDisplay".$leaveID );
			echo AjaxLib::AjaxScriptOnBlur($name, 'leave/ajaxLeaveCreditCount', $name.','.$empno.','.$cmonth.','.$leaveCNO,'',"divCalendarDisplay".$leaveID );
			echo input_tag($leaveCNO, $leaveID, 'type=hidden');
			if ($sf_user->isAuthenticated()):
				//echo input_tag($empno, $sf_params->get($empno), 'type=hidden');
				echo HTMLLib::CreateSelect($empno, $sf_params->get($empno), HrEmployeePeer::GetEmployeeNameList('', sfContext::getInstance()->getUser()->getUsername()), 'span5' );
			else:
				//echo input_tag($name, $sf_params->get($name), 'type=hidden');
				echo HTMLLib::CreateInputText($empno, $sf_params->get($empno), 'span4' );
				echo ' <small class="fg-red">scan ic here</small>';
			endif;
		?>
	</td>
</tr>
<script>
//	$("#<?php echo $name?>").blur( function(){
//		$("#IDFORMadd").submit();
//	} );
</script>
<tr>
	<td class="bg-clearBlue alignRight"><small><label>Commence Date</label></small></td>
	<td class="">
		<?php echo input_tag('commence_date'.$leaveID, $sf_params->get('commence_date'.$leaveID), 'class="span2" type="hidden"'); ?>
		<div id="DIVCommenceDate<?php echo $leaveID ?>">
			<?php echo $sf_params->get('commence_date'.$leaveID) ?>
		</div>
	</td>
</tr>
<tr>
	<td class="bg-clearBlue alignRight"><small><label>Leave Balance</label></small></td>
	<td class="">
		<h4 class="fg-darkBlue">
			<?php echo input_tag('balance'.$leaveID, $sf_params->get('balance'.$leaveID), 'class="span2"  type="hidden"'); ?>
			<div id="DIVBalance<?php echo $leaveID ?>">
			<?php 
					echo $sf_params->get('balance'.$leaveID);
					echo HTMLLib::CreateSubmitButton($chkbal, 'Check Balance');
			?>
			</div>
		</h4>
	</td>
</tr>
<tr>
	<td class="bg-clearBlue alignRight"><small><label>Change Month</label></small></td>
	<td class=""><?php
	//$months = array_merge(array(''=>'Select Month Here'), sfConfig::get('monthlyCalendar') );
	$months = sfConfig::get('monthlyCalendar');
	echo AjaxLib::AjaxScriptOnChange($cmonth, 'leave/ajaxChangeCalendar', $name.','.$empno.','.$cmonth.','.$leaveCNO,'','divCalendarDisplay'. $leaveID);
	echo HTMLLib::CreateSelect($cmonth, $sf_params->get($cmonth), $months, 'span2'); 
	echo  $button;
	echo '&nbsp;&nbsp;' . submit_tag('Reset', 'class="warning"');
	?></td>
</tr>
<tr>
	<td class="bg-clearBlue alignRight"><small><label>MOM Calculator</label></small></td>
	<td><?php echo link_to('Maternity Leave', 'http://www.mom.gov.sg/employment-practices/leave/maternity-leave/calculate-maternity-leave', 'target=_BLANK') ?></td>
</tr>
</table>
	
<div class="panel">
<div class="panel-header bg-lightBlue fg-white">
LEAVE DETAIL
</div>
<div class="panel-content">
<table width="100%" class="FORMtable" border="0" cellpadding="4" cellspacing="0">
<tr>
    <td width="400px" class="FORMcell-right" nowrap>
    <div id="DIVLeaveCalendarFrame" >
		<div id="divCalendarDisplay<?php echo $leaveID ?>" >
	    <?php
	    	//$cal = new TkCalendar(date('Y'), false);
	    	//echo $sf_params->get($cmonth);
	    	echo $cal->LeaveApplyCalendar($sf_params->get($cmonth), $sf_params->get($empno), $leaveID);
	 	?>
	 	</div>

 	</div>
    </td>
    <td class="FORMcell-right" nowrap>
    
	<table class="table condensed bordered">
		<tr>
		    <td class="bg-clearBlue alignRight"><label><small>Date of Request</small></label></td>
		    <td colspan="5" class="FORMcell-right" nowrap>
		    <?php 
		    	echo HTMLLib::CreateDateInput('date_filed'.$leaveID, $sf_params->get('date_filed'.$leaveID, Date('Y-m-d')), 'span2');
		    ?>
		    <span class="negative">*</span>        
		    </td>
		</tr>
		<tr>
		    <td class="bg-clearBlue alignRight"><label><small>Half Day</small></label></td>
		    <td colspan="5" class="FORMcell-right" nowrap>
		    <?php
		    	$hDay = array('none'=>'- None -', 'Am Leave'=>'- Am Leave -', 'Pm Leave'=>'- Pm Leave -');
		    	echo HTMLLib::CreateSelect('half_day'.$leaveID, $sf_params->get('half_day'.$leaveID), $hDay, 'span2');
		    ?>
		    <span class="negative"></span>            
		    </td>
		</tr>
		
		<tr>
		    <td class="bg-clearBlue alignRight"><label><small>Reason</small></label></td>
		    <td colspan="3" class="FORMcell-right" nowrap>
		    <?php
		    	echo HTMLLib::CreateTextArea('reason_leave'.$leaveID, $sf_params->get('reason_leave'.$leaveID)? $sf_params->get('reason_leave'.$leaveID) : $reason, 'span4');
//		        echo textarea_tag('reason_leave'.$leaveID,  $sf_params->get('reason_leave'.$leaveID)? $sf_params->get('reason_leave'.$leaveID) : $reason, 'size=50x5'); 
		    ?>
		    <span class="negative">*</span>    
		    </td>
		</tr>
		<tr>
		<tr>
		    <td class="bg-clearBlue alignRight"><label><small>Dates Applied</small></label></td>
		    <td colspan="5" class="FORMcell-right" nowrap>
		    <div id="DIVDatesApplied">
		        <?php
		        	echo HTMLLib::CreateTextArea('dates'.$leaveID, $sf_params->get('dates'), 'span4','', 'readonly="readonly"');
		        
		    		//echo textarea_tag('dates'.$leaveID,  $sf_params->get('dates'), 'size=50x5 readonly=readonly'); 
		    		echo '<br>';
		    		echo '<br>';
		    		echo $button;
		    	?>
		    </div>
		    </td>
		</tr>
	</table>
    
    </td>
</tr>

</table>

</form>



</td>
<td width="100" class="at">  

</td>
</tr>
</table>
</div>
</div>

	 	<div id="DIVShowLeave<?php echo $leaveID ?>" >
		
		</div>
<?php

	$jsLeave = "'employee_no=' + \$F('employee_no".$leaveID."')    "
					." + '&cmonth=' + \$F('cmonth".$leaveID."') "  
					." + '&leaveID=" . $leaveID ."'" 
	;	
	$ajaxShowLeave = array(
			'url'		=>'leave/ajaxShowAppliedLeave',
			'with'		=> $jsLeave,
            'update' 	=> 'DIVShowLeave'.$leaveID,
            'script'    => true,
            'loading'   => 'stop_remote_pager();',
            'before'   	=> 'showLoader();',
            'complete'  => 'hideLoader();formatFormStyle();',
            'type'      => 'synchronous',			
	); 
	

	
	echo javascript_tag("
		  var currentdate = new Date();
		  var firstPress;
		  var lastPress;
		    		 
		  function DisableKeypress(e) {
		    var cdate = new Date();
		    var code;

		    // If IE
		    if (!e)	{	       
		      var e = window.event;
		    }
		      if(typeof firstPress == 'undefined') {
		          firstPress = cdate.getSeconds();
		          lastPress = firstPress;
		      }else{
		      	  lastPress = cdate.getSeconds();
		      	  if (firstPress != lastPress){
		      	  	alert('You are not allowed to key in');
		      	  	window.location = '".url_for('leave/leaveEmployeeApply')."';
		      	  }
		      }
		    if (e.keyCode) code = e.keyCode;
		    else if (e.which) code = e.which;  
		
		    if (code == 17 || code == 45 ){
		      	  	alert('You are not allowed to key in');
		      	  	window.location = '".url_for('leave/leaveEmployeeApply')."';
			}

		  };
		  
//		function DisableKeypress(e) {
//		    var code;
//		    if (!e) var e = window.event;
//		    if (e.keyCode) code = e.keyCode;
//		    else if (e.which) code = e.which;  
//		
//		    if (code > 0)
//		        return false;
//			}
    ");
?>

