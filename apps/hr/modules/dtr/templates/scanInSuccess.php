<?php use_helper('Form', 'Javascript'); ?>
<div class="contentBox">
<!--<h1><?php echo link_to('<i class="icon-arrow-left-3 fg-darker smaller"></i>', 'dtr/scanIn') ?>
	LEAVE <small>Apply</small></h1>

--><div id="scanIn">
<script>
	function timedRefresh(timeoutPeriod) 
	{
		window.location = "<?php echo url_for('dtr/scanIn') ?>"
	}

	function refocus() 
	{
		$(document).ready(function(){
			$("#employee_no").focus();
			$("#employee_no").val('');
		});
	}
	
</script>

<form name="FORMadd" id="IDFORMadd"
	action="<?php echo url_for('dtr/scanIn') ?>"
	method="post">
	<table class="table bordered condensed">
	<tr>
		<td width='15%' rowspan="4" class="alignCenter">
  					<?php include_partial('telltime');?>
  					<div class="times" data-role="times" ></div>
		</td>
	</tr>
	<tr >
		<td class="bg-clearBlue FORMcell-right span6" nowrap>
			<div class="span6 notice marker-on-bottom bg-darkOrange fg-white alignCenter">
				Work Hours Time In <br />
				07:15am to 08:00am = 08:00am <br />
			</div>
		</td>
		<td rowspan="3" >
			<?php //var_dump(HrEmployeePeer::GetPhoto($sf_params->get('employee_no') ) ); exit(); ?>
			<?php
				//$id = HrEmployeePeer::GetIDByEmployeeNo($sf_params->get('employee_no'));
				$myphoto = HrEmployeePeer::GetPhoto($sf_params->get('id')); 
				echo link_to(image_tag('employee/' . $myphoto,'size="150x300"'),'#', 'id="uploadPhoto" ') ; 
			?>
		</td>
	</tr>
	<tr>
		<td class="bg-clearBlue"><label>
		<?php
			$nameString = ''; 
			echo HTMLLib::CreateInputText('employee_no', $sf_params->get('employee_no'), 'span4', '', ' autocomplete="off"');
			echo '&nbsp;&nbsp;&nbsp;';
			echo HTMLLib::CreateSubmitButton('saveScan', 'TimeIn / Out');
		  
		?></label>
		</td>
	</tr>
	<tr >
		<td class="bg-white fg-darkBlue" nowrap>
			<h1><?php echo $sf_params->get('name'); ?></h1>
		</td>
	</tr>	
</table>
</form>

<?php 
    if (isset($pager)):
		$filename = hrPager::scanInPager($pager);
		$cols = array('seq', 'employee_no', 'name', 'time_in','time_out','duration', 'company', 'team', 'employment');
		//echo PagerJson::TableHeaderFooter($cols, $filename, '', sizeof($pager)); //create the table
		echo PagerJson::AkoDataTableForTicking($cols, $filename);
	endif;

 	echo javascript_tag("setTimeout('timedRefresh()', 300000)");  //refresh in every 5 minutes
	echo javascript_tag("setTimeout('refocus()', 1000)");
?>
</div></div>
<script>
	//********** KEYPRESS PREVENTION
    $(document).ready(function(){
        $("#employee_no").keypress(function() {
        	setTimeout('refocus()', 700)
        });
    });

    //********** PASTE PREVENTION
$(document).ready(function(){
    $(document).on("cut copy paste","#employee_no",function(e) {
        e.preventDefault();
    });
 });
</script>

<!--<script language=JavaScript> var message=""; function clickIE4(){ if (event.button==2){  return false; } } function clickNS4(e){ if (document.layers||document.getElementById&&!document.all){ if (e.which==2||e.which==3){  return false; } } } if (document.layers){ document.captureEvents(Event.MOUSEDOWN); document.onmousedown=clickNS4; } else if (document.all&&!document.getElementById){ document.onmousedown=clickIE4; } document.oncontextmenu=new Function("return false") </script>-->

