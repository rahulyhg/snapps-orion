<?php use_helper('Validation', 'Javascript') ?>
<?php echo HTMLLib::CreateBackBanner('', 'INCOME', 'Add Entry') ?>
<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('payroll/scheduledIncomeAdd'). '?id=' . $sf_params->get('id');?>" method="post">

<table class="table condensed bordered"> 
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Employee No</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    if ($sf_params->get('id')):
    	echo $sf_params->get('name');
    	echo input_tag('name',  $sf_params->get('name'), 'type=hidden');
    	echo input_tag('employee_no',  $sf_params->get('employee_no'), 'type=hidden');
    else:
    	echo HTMLLib::CreateSelect('employee_no', $sf_params->get('employee_no'), HrEmployeePeer::GetActiveEmployeeList(), 'span3');
    endif;
    ?>
    <span class="negative">*</span>
<!--    <input type="submit" name="employee" value=" Retrieve " class="submit-button">    -->
    </td>
</tr>
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Account Code</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    $acctCode = array('HA'=>'HARDSHIP ALLOWANCE');
    $acctCode = array_merge($acctCode, PayAccountCodePeer::GetAcctCodeList());
//    echo HTMLForm::Error('acct_code');
//    //echo input_tag('acct_code',  $sf_params->get('acct_code'), 'size="15"');
//    echo select_tag('acct_code', options_for_select($acctCode, $sf_params->get('acct_code')));
//    echo '&nbsp;';
//    echo input_tag('acctDesc',  $sf_params->get('acctDesc'), 'size="20"');    
    
    echo HTMLLib::CreateSelect('acct_code', $sf_params->get('acct_code'), $acctCode, 'span4');
    
    ?>
    <span class="negative">*</span>
    </td>
</tr>


<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Amount</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLForm::Error('total_amount');
    echo HTMLLib::CreateInputText('total_amount',  $sf_params->get('total_amount'), 'span2');
    ?>
    <span class="negative">* Place 0 amount for periodic income such as Allowances.</span>
    </td>
</tr>

<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Description</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    	echo HTMLLib::CreateInputText('acctDesc',  $sf_params->get('acctDesc'),  'span4'); 
    	echo $sf_params->get('description');
    ?>
    </td>
</tr>
<!--<tr>
    <td class="bg-clearBlue alignRight" nowrap>Scheduled Amount</td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLForm::Error('scheduled_amount');
    echo HTMLLib::CreateInputText('scheduled_amount',  $sf_params->get('scheduled_amount'), 'span2');
    ?>
    <span class="negative">*</span>
    Amount Recieved: &nbsp;&nbsp;
    <?php echo $sf_params->get('tot_amt_received') ?>
    </td>
</tr>
<tr>
    <td class="bg-clearBlue alignRight" nowrap>Taxable Amount</td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLForm::Error('taxable_amount');
   echo HTMLLib::CreateInputText('taxable_amount',  $sf_params->get('taxable_amount'), 'span2');
    ?>
    <span class="negative">*</span>
    </td>
</tr>
--><tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Effectivity Date</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
//    echo HTMLForm::DrawDateInput('sdate', $sf_params->get('sdate'), XIDX::next(), XIDX::next(), 'size="15"');    
//    echo HTMLForm::DrawDateInput('edate', $sf_params->get('edate'), XIDX::next(), XIDX::next(), 'size="15"');   
    echo HTMLLib::CreateDateInput('sdate', $sf_params->get('sdate'), 'span2');
    echo "to";
    echo HTMLLib::CreateDateInput('edate', $sf_params->get('edate'), 'span2');
    ?>
    </td>    
</tr>
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Frequency</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLForm::Error('frequency');
    //echo select_tag('frequency', options_for_select(PayScheduledIncome::GetFrequencyList(), $sf_params->get('frequency')));
    echo HTMLLib::CreateSelect('frequency', $sf_params->get('frequency'), PayScheduledIncome::GetFrequencyList(), 'span3')
    ?>
    <span class="negative">*</span>
    </td>
</tr>
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Status</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLForm::Error('status');
    //echo select_tag('status', options_for_select(array('A'=>'Active', 'I'=>'Inactive'), $sf_params->get('status')));
    echo HTMLLib::CreateSelect('status', $sf_params->get('status'), array('A'=>'Active', 'I'=>'Inactive'), 'span2')
    ?>
    <span class="negative">*</span>
    </td>
</tr>


<tr>
    <td class="bg-clearBlue alignRight" nowrap></td>
    <td class="FORMcell-right" nowrap>
    	<?php if ($sf_params->get('status') == 'A') { ?>
        	<input type="submit" name="save" value=" Save Details " class="success">
        <?php }else {
        	    echo 'This transaction has been posted already.  Cannot Modify';
        	  }
         ?>
    </td>
</tr>
</table>
</form>



