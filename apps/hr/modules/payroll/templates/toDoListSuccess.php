<div class="contentBox">
<table class="table bordered condensed">
	<tr>
		<td colspan="3" class="text-right bg-clearGreen"><h3 class="">PAYROLL TO DO LIST</h3></td>
	</tr>
	<tr>
		<td class="bg-clearBlue span2 text-right"><label>Charlie</label></td>
		<td class="span4 text-center"><label>
		<?php echo link_to('Show Payslip', 'payroll/payslipEntry?id='.  $charlieID, 'class="mylink" target="_blank"' ); ?>
		</label></td>
		<td><label>Charlie will have the maximum Overtime of $100</label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue  text-right"><label>Kenneth</label></td>
		<td class=" text-center"><label>
		<?php echo link_to('Show Payslip', 'payroll/payslipEntry?id='.  $kennethID, 'class="mylink" target="_blank"' ); ?>
		</label></td>
		<td><label>Add $2 for ECF Contribution</label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue  text-right"><label>Cash Check</label></td>
		<td class=" text-center"><label>
		<?php foreach($cashCheckList as $trID => $name): ?>
		<?php echo link_to($name, 'payroll/payslipEntry?id='.  $trID, 'class="mylink" target="_blank"' ); ?><br>
		<?php endforeach; ?>
		</label></td>
		<td><label>Cash Check should be rounded to the nearest $1</label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue  text-right"><label>Check CBS</label></td>
		<td class=" text-center"><label>
		<?php foreach($CBSList as $trID => $name): ?>
		<?php echo link_to($name, 'payroll/payslipEntry?id='.  $trID, 'class="mylink" target="_blank"' ); ?><br>
		<?php endforeach; ?>
		</label></td>
		<td><label>Remove the Bank Subsidy for the Following</label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue  text-right"><label>Seagate Old Worker</label></td>
		<td class=" text-center"><label>
		<?php echo link_to('SYED AHAMED MARICAN', 'payroll/payslipEntry?id='.  $syedID, 'class="mylink" target="_blank"' ); ?><br>
		<?php echo link_to('SUKARNI BINTI SULAIMAN', 'payroll/payslipEntry?id='.  $sukarniID, 'class="mylink" target="_blank"' ); ?><br>
		<?php echo link_to('SULAIMAN BIN IBRAHIM', 'payroll/payslipEntry?id='.  $sulaimanID, 'class="mylink" target="_blank"' ); ?>
		
		</label></td>
		<td><label>Bank Should not exceed $1,000</label></td>
	</tr>
		<tr>
		<td class="bg-clearBlue  text-right"><label>Irregular TimeIn</label></td>
		<td class=" text-center"><label>
		<?php echo link_to('YANG MEIZHEN', 'payroll/payslipEntry?id='.  $meizhenID, 'class="mylink" target="_blank"' ); ?><br>
		<?php echo link_to('RAPHAEL CARLO DE JOYA', 'payroll/payslipEntry?id='.  $cocoID, 'class="mylink" target="_blank"' ); ?><br>
		
		</label></td>
		<td><label>Remove Tardy or Absences</label></td>
	</tr>
	</tr>
		<tr>
		<td class="bg-clearBlue  text-right"><label>MEAL ALLOWANCE</label></td>
		<td class=" text-center"><label>
		<?php echo link_to('CHEN JIE', 'payroll/payslipEntry?id='.  $chenJieID, 'class="mylink" target="_blank"' ); ?><br>
		</label></td>
		<td><label>No of days x 2.5</label></td>
	</tr>
	</tr>
		<tr>
		<td class="bg-clearBlue  text-right"><label>PARI</label></td>
		<td class=" text-center"><label>
		<?php echo link_to('PARI', 'payroll/payslipEntry?id='.  $pariID, 'class="mylink" target="_blank"' ); ?><br>
		</label></td>
		<td><label>Compute Overtime</label></td>
	</tr>
	</tr>
		<tr>
		<td class="bg-clearBlue  text-right"><label>SOWWEN</label></td>
		<td class=" text-center"><label>
		<?php echo link_to('SOWEN', 'payroll/payslipEntry?id='.  $sowwenID, 'class="mylink" target="_blank"' ); ?><br>
		</label></td>
		<td><label>2.4K</label></td>
	</tr>
</table>
</div>