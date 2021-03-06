<?php use_helper('Form', 'Javascript'); ?>
<div class="contentBox">
<?php echo HTMLLib::CreateBackBanner('payroll/payslipNano?period_code=' . $record->getPeriodCode(), 'NANO PAYSLIP', 'Manual Entry') ?>
<?php
if (isset($pager)):
    $filename = hrPager::NanoPayslipEdit($pager);
	$cols = array('seq','name', 'action', 'acct_code', 'description', 'income', 'deduction', 'bank_cash');
    echo PagerJson::ShowInFlatTable($cols, $filename, strtoupper(DateUtils::DUFormat('F Y', HrLib::PeriodStartDate($record->getPeriodCode()) )) .' PAYROLL PERIOD', array('income','deduction'));
endif;
?>
</div>
<script>
	$('.td_action').addClass(' alignCenter');
	$('.td_bank_cash').addClass(' alignCenter');
	$('.td_income').addClass(' alignRight');
	$('.td_deduction').addClass(' alignRight');
</script>

