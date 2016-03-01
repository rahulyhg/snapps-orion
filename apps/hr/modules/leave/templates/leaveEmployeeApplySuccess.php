<?php use_helper('Validation', 'Javascript') ?>
<div class="contentBox">
<h1><?php echo link_to('<i class="icon-arrow-left-3 fg-darker smaller"></i>', 'dtr/scanIn') ?>
	GOTO <small>Scan In</small></h1>
<?php 
	//var_dump($sf_params->get('ctab'));
?>
<div class="tab-control" data-role="tab-control">
    <ul class="tabs">
	    <li class="<?php echo ($sf_params->get('ctab') == 2 ? 'active' : '') ; ?>"><a href="#_page_1">Annual Leave</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 6 ? 'active' : '') ?>"><a href="#_page_2">Unpaid Leave</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 1 ? 'active' : '') ?>"><a href="#_page_3">Medical Leave</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 8 ? 'active' : '') ?>"><a href="#_page_4">National Service</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 13 ? 'active' : '') ?>"><a href="#_page_5">Hospitalization</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 12 ? 'active' : '') ?>"><a href="#_page_6">Maternity</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 7 ? 'active' : '') ?>"><a href="#_page_7">Child Care</a></li>
	    <li class="<?php echo ($sf_params->get('ctab') == 11 ? 'active' : '') ?>"><a href="#_page_8">Compassionate</a></li>
    </ul>
     
    <div class="frames">
	    <div class="frame" id="_page_1"><?php include_partial('leave_employee_apply', array('leaveID'=>2,'reason'=>'Holiday', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_2"><?php include_partial('leave_employee_apply', array('leaveID'=>6,'reason'=>'Emergency Leave', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_3"><?php include_partial('leave_employee_apply', array('leaveID'=>1,'reason'=>'Sick', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_4"><?php include_partial('leave_employee_apply', array('leaveID'=>8,'reason'=>'National Service', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_5"><?php include_partial('leave_employee_apply', array('leaveID'=>13,'reason'=>'Hospitalized', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_6"><?php include_partial('leave_employee_apply', array('leaveID'=>12,'reason'=>'Maternity', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_7"><?php include_partial('leave_employee_apply', array('leaveID'=>7,'reason'=>'Child Care', 'cal'=>$cal)) ?></div>
	    <div class="frame" id="_page_8"><?php include_partial('leave_employee_apply', array('leaveID'=>11,'reason'=>'', 'cal'=>$cal)) ?></div>
    </div>
</div>	
</div>

<?php 
function isactive($ctab)
{
	if ($sf_params->get('ctab') == $ctab):
		return 'active';
	else:
		return '';
	endif;
}
?>

