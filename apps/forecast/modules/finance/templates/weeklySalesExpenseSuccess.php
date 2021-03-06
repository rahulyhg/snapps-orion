<?php use_helper('Form', 'Javascript');
?>
<form name="FORMadd" id="IDFORMadd"
	action="<?php echo url_for('finance/weeklySalesExpense') ?>"
	method="post">
<div class="contentBox">
<div class="panel">
    <div class="panel-header bg-lightBlue fg-white">
        WEEKLY SALES & EXPENSES
    </div>
    <div class="panel-content">
        <table class="bordered condensed table">
		<tr>
			<td class="alignRight bg-clearBlue span4">Year</td>
			<td class="">
				<?php 
					//echo HTMLLib::CreateSelect('month', $sf_params->get('month'), $monthList, 'span2');
					echo AjaxLib::AjaxScriptOnChange('year', 'hrforecast/weekDescriptionAjax', 'year, week_start, week_end', '', 'monthSpanDescription'); 
					echo HTMLLib::CreateSelect('year', $sf_params->get('year'), $yearList, 'span1');
				?>
				<small>last update: <?php echo HrEmployeeDailyPeer::GetLastUpdate()?></small>
			</td>
		</tr>
		<tr>
			<td class="alignRight bg-clearBlue">Daily</td>
			<td class="">
				<?php 
					echo HTMLLib::CreateDateInput('start_date', $sf_params->get('start_date'), 'span2');
					echo HTMLLib::CreateDateInput('end_date', $sf_params->get('end_date'), 'span2');
				?>
			</td>
		</tr>
		<tr>
			<td class="alignRight bg-clearBlue">Company</td>
			<td class="">
				<?php 
					//echo AjaxLib::AjaxScriptOnChange('company', 'hrforecast/getTeamAjax', 'company', '', 'teamSelect');
					echo HTMLLib::CreateSelect('company', $sf_params->get('company'), $companyList, 'span2');
				?>
			</td>
		</tr>
		<tr>
						<td class="FORMcell-left FORMlabel bg-clearBlue" nowrap><label>Sales
								Source</label></td>
						<td class="FORMcell-right" nowrap><?php
						$sales_source = array (
								'INVOICE' => ' -INVOICE- ',
								'DO' => ' -DELIVERY ORDER-' 
						);
						echo HTMLLib::CreateSelect ( 'sales_source', $sf_params->get ( 'sales_source' ), $sales_source, 'span2' );
						?></td>
						
			</td>
		</tr>
		<tr>
			<td class="alignRight bg-clearBlue"></td>
			<td class="">
				<?php 
					echo HTMLLib::CreateSubmitButton('compute', 'Compute Weekly Cost');
					echo '&nbsp;';
					echo HTMLLib::CreateSubmitButton('filter_name', 'Show the Below Name(s) Only');
					echo '&nbsp;';
					echo HTMLLib::CreateSubmitButton('daily_update', 'Update Data');
				?>
			</td>
		</tr>
	</table>
    </div>
</div>
<br>
<?php 
$cnt = 0;
$total = array();
$grandTotal = 0;

//echo '<pre>';
//print_r($titles);
//echo '</pre>';
//exit(); 
if ($benchmark):
?>
<table class="table bordered">
		<tr>
			<td>
		<?php include_partial('weeklyIncomeExpenseChart', array('chartdata'=> $salesVexpense, 'target' => $target ) )?>
	</td>
		</tr>
	</table>

	<!-- SALES vs EXPENSE  -->
	<table class="table bordered">
		<tr><td colspan="15" class="bg-clearGreen alignRight">SALES VS EXPENSE</td></tr>
		<td class="bg-clearBlue">&nbsp;</td>
	<?php foreach($titles as $cdate ):?>
	<?php $week = DateUtils::DUFormat('W (M j-', $cdate) . DateUtils::DUFormat('j)', DateUtils::AddDate($cdate, 6 ) ); ?>
		<td class="bg-clearBlue text-center"><small>W<?php echo $week?></small></td>
	<?php endforeach;?>
	<td class="bg-clearBlue">Total</td>
		<tr class="alignRight ">
			<td class="bg-clearBlue alignRight"><small>Sales <small>(without gst)</small></small></td>
	<?php $grandTotal = 0; ?>
	<?php foreach($iData as $salesData ):?>
		<?php $grandTotal += $salesData['SALES']?>
		<td class="alignRight "><small><?php echo number_format($salesData['SALES'],2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight "><small><?php echo number_format($grandTotal, 2); ?></small></td>
		</tr>
		<tr class="alignRight ">
			<td class="bg-clearBlue alignRight"><small>Expenses<small>(with gst)</small></small></td>
	<?php $grandTotal = 0; ?>
	<?php foreach($subtotal as $pos => $subtot ):?>
		<?php $grandTotal += $subtot?>
		<td class="alignRight "><small><?php echo number_format($subtot,2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight "><small><?php echo number_format($grandTotal, 2); ?></small></td>
		</tr>
		<tr class="alignRight bg-green ">
			<td class="fg-white"><small>Margin</small></td>
	<?php $grandTotal = 0; ?>
	<?php foreach($subtotal as $pos => $subtot ):?>
		<?php
		$amt = $iData [$pos] ['SALES'] - $subtot;
		$grandTotal += $amt;
		?>
		<td class="alignRight fg-white"><small><?php echo number_format($amt,2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight fg-white"><small><?php echo number_format($grandTotal, 2); ?></small></td>
		</tr>
	</table>
	
			<!-- 	SHOW ACRO AND NANOCLEAN ONLY  -->
	<?php if ($sf_params->get('company') == 2 || $sf_params->get('company') == 5) : ?>
	<!-- SEAGATE SALES AND OTHER SALES  -->
	<table class="table bordered">
		<tr><td colspan="15" class="bg-clearGreen alignRight">SEAGATE SALES & OTHER SALES <small>(ACRO & NANOCLEAN ONLY)</small></td></tr>
		<td class="bg-clearBlue">&nbsp;</td>
	<?php foreach($titles as $cdate ):?>
	<?php $week = DateUtils::DUFormat('W (M j-', $cdate) . DateUtils::DUFormat('j)', DateUtils::AddDate($cdate, 6 ) ); ?>
		<td class="bg-clearBlue text-center"><small>W<?php echo $week?></small></td>
	<?php endforeach;?>
	<td class="bg-clearBlue">Total</td>
	
<!-- 	<tr class="alignRight "> 
	<td class="bg-clearBlue alignRight"><small>Sales Seagate <small>(without gst)</small></td> 
	<?php $grandTotal = 0; ?>
	<?php foreach($seagateSales as $salesData ):?>
		<?php $grandTotal += $salesData['SALES SEAGATE']?>
		<td class="alignRight "><small><?php echo number_format($salesData['SALES SEAGATE'],2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight "><small><?php echo number_format($grandTotal, 2); ?></small></td>
	</tr>
	
	<tr class="alignRight ">
			<td class="bg-clearBlue alignRight"><small>Sales Non-Seagate <small>(without gst)</small></td>
	<?php $grandTotal = 0; ?>
	<?php foreach($otherSales as $salesData ):?>
		<?php $grandTotal += $salesData['SALES NON-SEAGATE']; ?>
		<td class="alignRight "><small><?php echo number_format($salesData['SALES NON-SEAGATE'],2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight "><small><?php echo number_format($grandTotal, 2); ?></small></td>
	</tr>
	-->
		
	<tr class="alignRight ">
			<td class="bg-clearBlue alignRight"><small>Nano Sales Seagate Cassette<small>(without gst)</small></td>
	<?php $grandTotal = 0; ?>
	<?php //var_dump($seagateCassetteSales); exit(); ?>
	<?php foreach($seagateCassetteSales as $salesData ):?>
		<?php $grandTotal += $salesData['SALES SEAGATE CASSETTE']; //var_dump($salesData); exit(); ?>
		<td class="alignRight "><small><?php echo number_format($salesData['SALES SEAGATE CASSETTE'],2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight "><small><?php echo number_format($grandTotal, 2); ?></small></td>
	</tr>
		
	<tr class="alignRight bg-green ">
			<td class="fg-white"><small>TOTAL SALES</small></td>
			<?php $grandTotal = 0; ?>
			<?php foreach($seagateSales as $pos => $salesData ):?>
				<?php
				$amt = $seagateSales [$pos]['SALES SEAGATE'] + $otherSales[$pos]['SALES NON-SEAGATE'];
				$grandTotal += $amt;
				?>
				<td class="alignRight fg-white"><small><?php echo number_format($amt,2) ?></small></td>
			<?php endforeach;?>
	<td class="alignRight fg-white"><small><?php echo number_format($grandTotal, 2); ?></small></td>
		</tr>
	</table>
	<?php endif;  //SHOW ACRO AND NANOCLEAN ONLY ?>
	
	
	<!-- HR ESTIMATED COST  -->
	<table class="table bordered">
		<tr><td colspan="15" class="bg-clearGreen alignRight">HR ESTIMATED COST<small>(BASED ON DAILY COMPUTATION)</small></td></tr>
		<td class="bg-clearBlue">&nbsp;</td>
	<?php foreach($titles as $cdate ):?>
	<?php $week = DateUtils::DUFormat('W (M j-', $cdate) . DateUtils::DUFormat('j)', DateUtils::AddDate($cdate, 6 ) ); ?>
		<td class="bg-clearBlue text-center"><small>W<?php echo $week?></small></td>
	<?php endforeach;?>
	<td class="bg-clearBlue">Total</td>
	<tr  class="bg-green fg-white alignRight">
				<td colspan="1">Total</td>
				<?php
					$grandTotal = 0; 
					foreach($weeks as $week):?>
					<td><small>
					<?php 
						
						echo number_format($totalPerWeek[$week]['basic'] + $totalPerWeek[$week]['ot'], 2);
						$grandTotal +=  $totalPerWeek[$week]['basic'] + $totalPerWeek[$week]['ot'];
					?></small></td>
				<?php endforeach;?>
				<td ><small><?php echo number_format($grandTotal,2 ); ?></small></td>
			</tr>
	</table>
	
	<div class="panel " data-role="panel">
	    <div class="panel-header bg-lightBlue fg-white">
	        EMPLOYEE LIST <small>(Can Filter More Information Here)</small>
	    </div>
	    <div class="panel-content" style="display: none;" >
	        <!--<table class="bordered table condensed hovered">
	        	<th>Seq</th>
	        	<th><?php echo HTMLLib::CreateCheckBox('checkAll', '', 'checked') ?></th>
	        	<th>Name</th>
	        	<th>Company</th>
	        	<th>Group</th>
	        	<th>Type</th>
	        	<?php foreach($employeeList as $empno => $name): $cnt++ ?>
	        	<?php //$empData = HrEmployeePeer::GetDatabyEmployeeNo($empno); ?>
	        	<tr>
	        		<td><small><?php echo $cnt; ?></small></td>
	        		<td><small><?php echo HTMLLib::CreateCheckBox($empno.'_chk', '') ?></small></td>
	        		<td><small><?php echo $name; ?></small></td>
	        		<td><small><?php //echo $empData? $empData->get ?></small></td>
	        		<td><small><?php //echo $name; ?></small></td>
	        		<td><small><?php //echo $name; ?></small></td>
	        	</tr>
	        	<?php endforeach; ?>
	        	<tr>
	        		<td></td>
	        		<td colspan="4"><?php echo HTMLLib::CreateSubmitButton('update_list', 'Display this List Only'); ?></td>
	        	</tr>
	        </table>
	    -->
			<?php 
			if (isset($pager))
			{
				
			    $filename = forecastPager::SearchEmployee($pager, $employeeList);
				$cols = array('seq', 'action', 'employee_no', 'name', 'company', 'team', 'type', 'work-schedule', 'resigned'); //
				echo PagerJson::AkoDataTableForTicking($cols, $filename,'','',sizeof($filename), 'action'); //create the table
			}
			echo '<br>';
			//echo '<input class="success" type="submit" id="filter_name" name="filter_name" value="Show the Above Name(s) Only" >';
			echo HTMLLib::CreateSubmitButton('filter_name', 'Show the Above Name(s) Only');
			?>
	    	</div>
	</div>
	<br>

	
	<?php $cnt = 0;?>
	<div class="panel " data-role="panel">
    <div class="panel-header bg-lightBlue fg-white">
        EMPLOYEE COMPUTATION
    </div>
    <div class="panel-content" style="display: none;">
		<table class="bordered table condensed hovered">
			<th rowspan="1" class="bg-clearBlue"><small>Seq</small></th>
			<th rowspan="1" class="bg-clearBlue"><small>Name</small></th>
				<?php foreach($titles as $cdate ):?>
				<?php $week = DateUtils::DUFormat('W (M j-', $cdate) . DateUtils::DUFormat('j)', DateUtils::AddDate($cdate, 6 ) ); ?>
					<td class="bg-clearBlue text-center"><small>W<?php echo $week?></small></td>
				<?php endforeach;?>
			<th rowspan="1" class="bg-clearBlue">Total</th>
			
			<?php foreach($employeeList as $empno => $name): $cnt++ ?>
			<?php //var_dump ( HrEmployeePeer::IsResigned($empno)? 'bg-crimson' : '' ); var_dump($name); exit();?>
			<tr class="<?php echo HrEmployeePeer::IsResigned($empno)? 'bg-clearRed ' : '' ?>">
				<td><small><?php echo $cnt; ?></small></td>
				<td><small><?php echo substr($name,0, 15); //$empno .' : '. $name ?></small></td>
				<?php foreach($weeks as $week):?>
					<td class="alignRight">
						<small><a href="#" data-hint="basic pay"><?php echo number_format($weeklyData[$week][$empno],2) ;  ?></a> + <a href="#" data-hint="overtime"><?php echo number_format($weeklyOvertime[$week][$empno],2) ;  ?></a></small>
					</td>
				<?php endforeach; ?>
				<td class="alignRight"><small><?php echo number_format($totalPerEmployee[$empno],2) ?></small></td>
			</tr>
			<?php endforeach;?>
			<tr  class="bg-clearGreen alignRight">
				<td colspan="2">Total</td>
				<?php
					$grandTotal = 0; 
					foreach($weeks as $week):?>
					<td><small>
					<?php 
						
						echo number_format($totalPerWeek[$week]['basic'] + $totalPerWeek[$week]['ot'], 2);
						$grandTotal +=  $totalPerWeek[$week]['basic'] + $totalPerWeek[$week]['ot'];
					?></small></td>
				<?php endforeach;?>
				<td ><small><?php echo number_format($grandTotal,2 ); ?></small></td>
			</tr>
		</table>
	</div>
	</div>



</form>
<br>
	<table class="table bordered">
		<tr>
			<td>
		<?php include_partial('expenseChartWeekly', array('chartdata'=> $pie) )?>
	</td>
		</tr>
	</table>
	<table class="table bordered striped">
		<tr class="bg-white">
			<td colspan="15">Note: Value includes Gst.</td>
		</tr>
		<th class="bg-clearBlue">Seq</th>
		<th class="bg-clearBlue">Particular</th>
	<?php foreach($titles as $cdate ):?>
	<?php $week = DateUtils::DUFormat('W (M j-', $cdate) . DateUtils::DUFormat('j)', DateUtils::AddDate($cdate, 6 ) ); //DateUtils::DUFormat('W (M d, y)', $cdate);?>
	
		<td class="bg-clearBlue text-center"><small>W<?php echo $week?></small></td>
	<?php endforeach;?>
	<th class="bg-clearBlue">Total</th>
	<?php
	$xpos = 1 ;
	$empList = '';
	$desc = '';
	$amt = 0;
	$pos = 0;
	$commentLine = '';
	?>
	<?php foreach($particularTotal as $particular => $partTotal ):?>
	<?php
		$highlight = '';
		$commentLine = $particular;
		if ($particular == 'sub contractor - Nano Direct'):
			$highlight = 'bg-lightGreen';
			$commentLine = $particular. '<br>This value is inside the sub-contractor manpower';		
		endif;
		if ($particular == 'sub contractor - Nano Indirect'):
			$highlight = 'bg-lightGreen';
			$commentLine = $particular. '<br>This value is inside the sub-contractor manpower';
		endif;
		if ($particular == 'sub contractor - manpower'):
			$commentLine = 'sub-contractor manpower';
			$highlight = 'bg-amber';
			$commentLine = $particular. '<br>This value is comming from Internal Billing prepared by Florence';
		endif;
		if ($particular == 'sub-contractors'):
			$commentLine = 'sub-contractor manpower';
			$highlight = 'bg-amber';
			$commentLine = $particular. '<br>This value is comming from Internal Billing prepared by Florence';
		endif;
		if ($particular == 'sub contractors'):
			$commentLine = 'sub-contractor manpower';
			$highlight = 'bg-amber';
			$commentLine = $particular. '<br>This value is comming from Internal Billing prepared by Florence';
		endif;
		if ($particular == 'acro - outsource services'):
			$highlight = 'bg-amber';
		endif;
		if ($particular == 'sub contractor basic - estimate'):
			$highlight = 'bg-clearRed';
			$commentLine = $particular. '<br>This value is inside the sub-contractor manpower.<br>Manpower Cost is shown on the last week fo the month';
		endif;
		if ($particular == 'sub contractor overtime - estimate'):
			$highlight = 'bg-clearRed';
			$commentLine = $particular. '<br>This value is inside the sub-contractor manpower.<br>Manpower Cost is shown on the last week fo the month';
		endif;
		if ($particular == 'sub contractor - manpower overtime'):
			$highlight = 'bg-amber';
			$commentLine = $particular. '<br>This value is inside the sub-contractor manpower and not computed in the Grand Total';
		endif;
//  		var_dump($company);
//  		exit();
		if (trim($particular) == 'delivery & handling charges' and $sf_params->get ( 'company' ) == 5):
			$commentLine = $particular. '<br><em class="fg-blue">Transporter Express +  Lorry from MC Clean $600</em>';
		endif;
		if ($particular == 'purchases - general trading' and $sf_params->get ( 'company' ) == 5):
			$commentLine = $particular. '<br><em class="fg-blue">Wong Steam Laundry & Dry Cleaning</em>';
		endif;
		if ($particular == 'rental & factory' and $sf_params->get ( 'company' ) == 5):
			$commentLine = $particular. '<br><em class="fg-blue">Rental Charge by TC Khoo</em>';
		endif;
		
		?>
	<tr class="<?php echo $highlight ?>">
			<td><small><?php echo $xpos++; ?></small></td>
			<td><small><?php echo $commentLine; ?></small></td>
		<?php foreach ( $titles as $pos => $cdate ) :
			$monthlyTotal = number_format ( $amt, 2 ); ?>
			<?php $amt = (isset($eData[$pos][$particular])? $eData[$pos][$particular] : 0 )?>
			<?php 
			if ($particular == 'sub contractor - manpower' || $particular == 'sub-contractors' || $particular == 'sub contractors'):
				$empList = PayEmployeeLedgerArchivePeer::GetEmployeeCountByDate ( $cdate, $sf_params->get ( 'company' ) );
				//$desc = HtmlLib::GetNameToolTip ( sizeof ( $empList ), implode ( '<br>', $empList ) );
				$eID = "createEmplist_".$pos;
				//echo HTMLLib::CreatePopupWindowList($eID, $empList, 3);
				//CreateEmployeeList($empList, $eID);
				$desc = '<button class="button success" id="'.$eID.'">'. sizeof ( $empList ) .'</button>';
				$monthlyTotal = $monthlyTotal . ' | ' . $desc;
				$listcount = 0;
				$empstring = '';
				foreach($empList as $list):
					$listcount ++;
					$empstring .= $list .', ';
				endforeach;	
			?>
			
				
				<td class="alignRight"><small><?php echo number_format($amt, 2) ?> | <a href="#" data-hint="<small><?php echo $empstring; //echo implode('<br>', $empList)?></small>"><?php echo sizeof($empList); ?></a></small></td>
			<?php
			elseif ($particular == 'sub contractor - Nano Direct'):
				$empList = PayEmployeeLedgerArchivePeer::GetEmployeeCountByDate ( $cdate, $sf_params->get ( 'company' ) );
				foreach($empList as $k=>$list):
					if (strpos($list, 'indirect') > 0 ):
						$empstring .= $list;
						unset($empList[$k]);
					endif;
				endforeach;
// 				var_dump($empstring);
// 				exit();
			?>
				<td class="alignRight"><small><?php echo number_format($amt, 2) ?> | <a href="#" data-hint="<small><?php echo implode('<br>', $empList)?></small>"><?php echo sizeof($empList); ?></a></small></td>
			<?php
			elseif ($particular == 'sub contractor - Nano Indirect'):
				$empList = PayEmployeeLedgerArchivePeer::GetEmployeeCountByDate ( $cdate, $sf_params->get ( 'company' ) );
				foreach($empList as $k=>$list):
					if (strpos($list, 'indirect') > 0 ):
					else:
						$empstring .= $list;
						unset($empList[$k]);
					endif;
				endforeach;
// 				var_dump($empstring);
// 				exit();
			?>
				<td class="alignRight"><small><?php echo number_format($amt, 2) ?> | <a href="#" data-hint="<small><?php echo implode('<br>', $empList)?></small>"><?php echo sizeof($empList); ?></a></small></td>
			<?php else: ?>
				<td class="alignRight"><small><?php echo number_format($amt, 2) ?>
			<?php 
			endif;
						
			//HTMLLib::vardump($eData[$pos][$particular]);
			?>
			
		<?php endforeach; //$titles ?> 
		<td class="alignRight"><small><?php echo number_format($partTotal, 2 ); ?></small></td>
		</tr> 
	<?php endforeach; //eData ?>
	<tr class="alignRight bg-green ">
			<td colspan="2" class="fg-white"><small>Total</small></td>
	<?php $grandTotal = 0; ?>
	<?php foreach($subtotal as $pos => $subtot ):?>
		<?php $grandTotal += $subtot?>
		<td class="alignRight fg-white"><small><?php echo number_format($subtot,2) ?></small></td>
	<?php endforeach;?>
	<td class="alignRight fg-white"><small><?php echo number_format($grandTotal, 2); ?></small></td>
		</tr>
	</table>

<?php 	
endif;
?>		
</div>