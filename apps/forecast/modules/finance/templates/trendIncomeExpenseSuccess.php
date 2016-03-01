<?php

use_helper ( 'Form', 'Javascript' );
sfConfig::set ( 'app_page_heading', 'Trend Income and Expense(s) Summary' );
?>
<div class="contentBox">
	<form name="FORMadd" id="IDFORMadd"
		action="<?php echo url_for('finance/trendIncomeExpense'). '?id=' . $sf_params->get('id');?>"
		method="post">
		<div class="panel">
			<div class="panel-header bg-lightBlue">
				<span class="fg-white">SHOW COST VS SALES TREND</span>
			</div>
			<div class="panel-content">
				<table class="table bordered condensed">
					<tr>
						<td class="FORMcell-left FORMlabel bg-clearBlue" nowrap><label>Month
								From</label></td>
						<td class="FORMcell-right span3" nowrap><?php
						$year1 = HrFiscalYearPeer::GetFiscalYearListYK ();
						$year2 = HrFiscalYearPeer::GetFiscalYearListYK ();
						// $year1 = array('2008'=>'2008', '2009'=>'2009', '2010'=>'2010', '2011'=>'2011', '2012'=>'2012');
						// $year2 = array('2008'=>'2008', '2009'=>'2009', '2010'=>'2010', '2011'=>'2011', '2012'=>'2012');
						$months1 = sfconfig::get ( 'monthlyCalendar' );
						echo HTMLLib::CreateSelect ( 'months1', $sf_params->get ( 'months1' ), $months1, 'span2' );
						echo HTMLLib::CreateSelect ( 'year1', $sf_params->get ( 'year1' ), $year1, 'span2' );
						$months2 = sfconfig::get ( 'monthlyCalendar' );
						?></td>
						<td class="span0 bg-clearBlue alignCenter"><label>To</label></td>
						<td>
				<?php echo HTMLLib::CreateSelect('months2', $sf_params->get('months2'), $months2, 'span2'); ?>
				<?php echo HTMLLib::CreateSelect('year2', $sf_params->get('year2'), $year2, 'span2'); ?>
			</td>

					</tr>
					<tr>
						<td class="FORMcell-left FORMlabel bg-clearBlue" nowrap><label>Company</label></td>
						<td class="FORMcell-right" nowrap><?php
						$company = array (
								"1" => "Micronclean",
								"2" => "Acro Solution",
								"5" => "NanoClean",
								"4" => "T.C. Khoo",
								"0" => "- ALL -" 
						);
						echo HTMLLib::CreateSelect ( 'company', $sf_params->get ( 'company' ), $company, 'span2' );
						?></td>
						<td class="span0 bg-clearBlue alignCenter"><label>Freq</label>
						
						<td class="FORMcell-right" nowrap><?php
						$freq = array (
								"monthly" => " - Monthly - " 
						);
						echo HTMLLib::CreateSelect ( 'frequency', $sf_params->get ( 'frequency' ), $freq, 'span2' );
						?></td>
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
						<td class="FORMcell-left FORMlabel bg-clearBlue"></td>
						<td class="FORMcell-right" nowrap>
				<?php echo HTMLLib::CreateSubmitButton('showCostSales', " Show Cost and Sales Monthly Trend ")?>
			</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
<?php if ($benchmark): ?>
<table class="table bordered">
		<tr>
			<td>
		<?php include_partial('trendIncomeExpenseChart', array('chartdata'=> $salesVexpense, 'target' => $target ) )?>
	</td>
		</tr>
	</table>

	<table class="table bordered">
		<tr><td colspan="15" class="bg-clearGreen alignRight">NOTICE</td></tr>
		<?php if ($sf_params->get ( 'company' ) == 2):?>
		<tr>
			<td class="bg-clearRed"><small>
			<pre>
			ACRO SOLUTION SUBCONTRACTORS COMPOSITION:
				TC KHOO Bill Acro (HR Payroll)
			+ 	Nano Bill Acro $2,000.00
			+	Nano Bill Acro $4,000.00 (Patrick)
			+ 	Nano Bill Acro $6,000.00 (Cleaning Part)
			+	Lady Boss Bill Acro $130
			______________________________
			( HR Payroll ) + $12,130.00 / month
			</pre>
			</small></td>
		</tr>
		<?php endif; ?>
	</table>
	<!-- SALES vs EXPENSE  -->
	<table class="table bordered">
		<tr><td colspan="<?php echo sizeof($titles) + 5 ?>" class="bg-clearGreen alignRight">SALES VS EXPENSE</td></tr>
		<td class="bg-clearBlue">&nbsp;</td>
	<?php foreach($titles as $cdate ):?>
	<?php $month = HrLib::CamelCase(strtolower(DateUtils::DUFormat('M-y', $cdate)) ); ?>
		<td class="bg-clearBlue"><small><?php echo $month?></small></td>
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

	<?php 
// 	HTMLLib::vardump($iData);
// 	exit();
	?>
	<!-- 	SHOW ACRO AND NANOCLEAN ONLY  -->
	<?php if ($sf_params->get('company') == 2 || $sf_params->get('company') == 5) : ?>
	<!-- SEAGATE SALES AND OTHER SALES  -->
	<table class="table bordered">
		<tr><td colspan="<?php echo sizeof($titles) + 5 ?>" class="bg-clearGreen alignRight">SEAGATE SALES & OTHER SALES <small>(ACRO & NANOCLEAN ONLY)</small></td></tr>
		<td class="bg-clearBlue">&nbsp;</td>
	<?php foreach($titles as $cdate ):?>
	<?php $month = HrLib::CamelCase(strtolower(DateUtils::DUFormat('M-y', $cdate)) ); ?>
		<td class="bg-clearBlue"><small><?php echo $month?></small></td>
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
	
	<!-- 	HRCOST -->
	<table class="table bordered striped">
	<tr><td colspan="<?php echo sizeof($titles) + 5 ?>" class="bg-clearGreen alignRight">HR COST BREAKDOWN <em><small class="fg-red">(This figure is based on the HR Payroll)</small></em></td></tr>
	<tr><td class="bg-clearBlue">&nbsp;</td>
		<?php foreach($titles as $cdate ):?>
			<?php $month = HrLib::CamelCase(strtolower(DateUtils::DUFormat('M-y', $cdate)) ); ?>
			<td class="bg-clearBlue"><small><?php echo $month?></small></td>
		<?php endforeach;?>
		<td class="bg-clearBlue">Total</td>
	</tr>
	<?php $hrItemCostTotal = array(); ?>
	<?php foreach($hrCost[0] as $item => $whatever ):?>
	<?php 
		$bgitem = $item == 'Total' ? ' fg-white bg-green text-right ' : '  text-right '; 
		$hrItemCostTotal[$item] = 0;
		?>
		<tr>
			<?php if ($item !== 'Total'):?>
				<td class="bg-clearBlue text-right "><small><?php echo $item ?></small></td>
			<?php else: ?>
				<td class="bg-green fg-white text-right"><small><?php echo $item ?></small></td>
			<?php endif; ?>
			
			<?php foreach($hrCost as $cost ):?>
				<?php $hrItemCostTotal[$item] += $cost[$item]; ?>
				<td class="<?php echo $bgitem ?>"><small><?php echo number_format($cost[$item], 2)?></small></td>
			<?php endforeach;?>
			<td class=" <?php echo $bgitem ?>" ><small><?php echo number_format($hrItemCostTotal[$item], 2)?></small></td>
		</tr>
	<?php endforeach;?>
	</table>
	
	

	<table class="table bordered">
		<tr>
			<td>
		<?php include_partial('expenseChart', array('chartdata'=> $pie) )?>
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
	<?php $month = HrLib::CamelCase(strtolower(DateUtils::DUFormat('M', $cdate)) ); ?>
		<th class="bg-clearBlue"><?php echo $month?></th>
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

<?php endif; //if benchmark ?>
</div>

