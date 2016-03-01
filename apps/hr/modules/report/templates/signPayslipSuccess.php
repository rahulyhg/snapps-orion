<?php use_helper('Validation', 'Javascript') ?>
<div class="contentBox">
<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('report/signPayslip'). '?id=' . $sf_params->get('id');?>" method="post">
<div><center>

<div class="panel"  data-role="panel">
<div class="panel-header bg-lightBlue fg-white">
PAYSLIP SIGNATURE
</div>
<div class="panel-content">
<table width="100%" class="table bordered " border="0" cellpadding="4" cellspacing="0" >
<tr>
    <td class="FORMcell-left" nowrap><label>Period Code</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    echo HTMLLib::CreateSelect('period_code', $sf_params->get('period_code'), PayEmployeeLedgerArchivePeer::GetPeriodCode(), 'span4');
    ?>
    <span class="negative">*</span>
    </td>
</tr>
<tr>
    <td class="FORMcell-left " nowrap><label>Bank Cash</label></td>
    <td class="FORMcell-right" nowrap>
    <?php
    $bankCash = array('CASH'=>' -CASH-','CASH-CHECK'=>' -CASH-CHECK-',  'CHEQUE'=>' -CHEQUE-');
    echo HTMLLib::CreateSelect('bank_cash', $sf_params->get('bank_cash'), $bankCash, 'span2');
    ?>
    <span class="negative">*</span>
    </td>
</tr>
<tr>
    <td class="FORMcell-left "><label>Company</label></td>
    <td class="FORMcell-right" nowrap>
    <?php    
        echo HTMLLib::CreateSelect('company', $sf_params->get('company'), HrCompanyPeer::OptCompanyNameListWithAll(), 'span2');
    ?>
    <span class="negative">*</span>
    </td>
</tr>
<tr>
    <td class="FORMcell-left " nowrap></td>
    <td class="FORMcell-right" nowrap>
    <input type="submit" name="showList" value=" Show List " class="success">
    </td>
</tr>
</table>
</div>
</div>
<br />
<div class="panel"  data-role="panel">
<div class="panel-header bg-lightBlue fg-white">
EMPLOYEE LIST
</div>
<div class="panel-content">
<?php 
if (true)
{
    $filename = hrPager::SignPayslipPager($pager, $sf_params->get('bank_cash'));
	$cols = array('seq', 'name', 'company', 'period', 'signed');
	echo PagerJson::AkoDataTableForTicking($cols, $filename, '', '', 100); //create the table
}
?>
</div>


</center></div>
<div style="clear:both;"></div>

</form>
</div>