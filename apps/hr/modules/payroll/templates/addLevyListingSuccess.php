<?php use_helper('Validation', 'Javascript') ?>
<div class="contentBox">
<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('payroll/addLevyListing'). '?id=' . $sf_params->get('id');?>" method="post">

<table class="table bordered condensed" > 
<tr>
    <td class="alignRight bg-clearBlue" nowrap><h2>NAME</h2></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo input_tag('period_code',  $sf_params->get('period_code'), 'size="25" type="hidden"');
    echo input_tag('id',  $sf_params->get('id'), 'size="25" type="hidden"');
    if ($sf_params->get('name')):
    	echo '<h2>'.$sf_params->get('name').'</h2>';
    	echo input_tag('employee_no',  $sf_params->get('employee_no'), 'size="25" type="hidden"');
    	echo input_tag('name',  $sf_params->get('name'), 'size="25" type="hidden"');
    else:
    	echo HTMLLib::CreateSelect('employee_no', $sf_params->get('employee_no'), HrEmployeePeer::GetActiveEmployeeList(), 'span5');    	
    endif;
    ?>
    <span class="negative"></span>
    </td>
</tr>
<tr>
    <td class="alignRight bg-clearBlue" nowrap><label>TEAM</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLLib::CreateSelect('team', $sf_params->get('team'), HrEmployeePeer::GetTeamList(), 'span3');
    
    ?>
    <span class="negative">*</span>
    </td>
</tr>
<tr>
    <td class="alignRight bg-clearBlue" nowrap><label>LEVY RATE</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLLib::CreateInputText('levy_rate', $sf_params->get('levy_rate'), 'span2');
    ?>
    <small class="fg-red">*actual rate</small>
    </td>
</tr>
<tr>
    <td class="alignRight bg-clearBlue" nowrap><label>LEVY DED</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
     echo HTMLLib::CreateInputText('levy_ded', $sf_params->get('levy_ded'), 'span2');
    ?>
    <small class="fg-red">*deduction</small>
    </td>
</tr>
<tr>
    <td class="alignRight bg-clearBlue" nowrap></td>
    <td class="FORMcell-right" nowrap>
        <input type="submit" name="save" value=" Save Details " class="success">
    </td>
</tr>
</table>
</form>
</div>