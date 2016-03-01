<?php use_helper('Form', 'Javascript'); ?>
<h1><?php echo link_to('<i class="icon-arrow-left-3 fg-darker smaller"></i>', '') ?>
	INCOME VS SALES <small>Daily</small></h1>

<div class="contentBoxCondensed">
<!-- <div class="contentBox"> -->
<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('finance/dailyIncomeExpense'). '?id=' . $sf_params->get('id');?>" method="post">
<div class="panel" data-role="panel">
<div class="panel-header bg-lightBlue">
<span class="fg-white">DAILY INCOME EXPENSE</span>
</div>
<div class="panel-content">
<table class="table bordered condensed" >
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Daily</label></td>
    <td class="alignLeft" nowrap>
    <?php
    echo HTMLLib::CreateDateInput('sdate', $sf_params->get('sdate'), 'span2');
    ?>
    </td>
    <td class="bg-clearBlue alignRight" nowrap><label>TO</label></td>
    <td><?php echo HTMLLib::CreateDateInput('edate', $sf_params->get('edate'), 'span2'); ?></td>    
</tr>
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Company</td>
    <td class="alignLeft" nowrap>
    <?php
    $company = array ("1"=>"Micronclean", "2"=>"Acro Solution", 
                      "5"=>"NanoClean", "4"=>"T.C. Khoo", "0"=>"- ALL -" );
    echo HTMLLib::CreateSelect('company', $sf_params->get('company'), $company, "span2");
    ?>
    </td>    
    <td class="bg-clearBlue alignRight" nowrap><label>Frequency</label></td>
    <td><?php
    $freq = array ( "daily"=>" - Daily - ");
    echo HTMLLib::CreateSelect('frequency', $sf_params->get('frequency'), $freq, "span2");
    ?></td> 
</tr>
<tr>
    <td class="bg-clearBlue alignRight" nowrap><label>Sales Source</label></td>
    <td class="alignLeft" nowrap>
    <?php
    $sales_source = array('INVOICE'=>' -INVOICE- ', 'DO'=>' -DELIVERY ORDER-');
    echo HTMLLib::CreateSelect('sales_source', $sf_params->get('sales_source'), $sales_source, "span2");
    ?>
    </td>    
    <td class="bg-clearBlue alignRight" nowrap><label></label></td>
    <td><input type="submit" name="benchmark" value=" Show Cost and Sales Daily " class="success"></td>
</tr>
</table>
</div>
</div>
</form>
</div>
</div>
<?php

	if (isset($benchmark)):
// 			HrLib::vardump($dailyExpense);
// 			HrLib::vardump($eData);
			$totalSales = 0;
			$totalExpense = 0;
			$totalPerDay = array();
			$grandTotal = 0;
			$totalSales = 0;
			$totalExpense = 0;
			
?>
<br>
<div class="panel " data-role="panel">
	    <div class="panel-header bg-lightBlue fg-white">
	        DAILY SALES VS EXPENSES
	    </div>
	    <div class="panel-content"  >
			

	<table class="table bordered condensed">
	<tr>
		<td rowspan="2" class="bg-clearBlue alignCenter"><small>Seq</small></td>
		<td rowspan="2" class="bg-clearBlue alignCenter"><small>Component</small></td>
		<td colspan="<?php echo sizeof($iData) ?>" class="bg-clearBlue alignCenter" ><strong><?php echo DateUtils::DUFormat('F-Y', $sf_params->get('sdate') ) ?></strong></td>
		<td rowspan="2" class="bg-clearBlue alignCenter"><small>Total</small></td>
	</tr>
	<tr>
	<?php foreach($iData as $day => $amount): ?>
		<td  class="bg-clearBlue alignCenter"><small><?php echo intval( DateUtils::DUFormat('d', $day) ) ?></small></td>
	<?php endforeach;?>
	</tr>
	
	<tr>
		<td><small>1</small></td>
		<td><small>Sales</small></td>
		<?php foreach($iData as $day => $amount): ?>
			<td  class=" alignRight"><small><?php echo number_format($iData[$day]['SALES']) ; $totalSales +=  $iData[$day]['SALES']; ?></small></td>
		<?php
			  $totalSales += 	$iData[$day]['SALES'];
			endforeach;?>
		<td  class=" alignRight"><small><?php echo $totalSales?></small></td>
	</tr>
	
	<tr>
		<td><small>2</small></td>
		<td><small>Expenses</small></td>
		<?php foreach($dailyExpense as $day => $amount): ?>
			<td  class=" alignRight"><small><?php echo number_format($dailyExpense[$day]) ; $totalExpense += $dailyExpense[$day]  ?></small></td>
		<?php
			  $totalExpense += 	$dailyExpense[$day];
			endforeach;?>
		<td class=" alignRight"><small><?php echo number_format($totalExpense) ?></small></td>
	</tr>
	<tr>
		<td colspan="2" class="bg-clearRed alignRight"><small>Total</small></td>
		<?php foreach($dailyExpense as $day => $amount): ?>
			<td  class="bg-clearRed alignRight"><small><?php echo number_format($iData[$day]['SALES'] - $dailyExpense[$day]) ; $grandTotal += ($iData[$day]['SALES'] - $dailyExpense[$day])  ?></small></td>
		<?php endforeach;?>
		<td  class="bg-clearRed alignRight"><small><?php echo number_format($totalSales - $totalExpense)?></small></td>
	</tr>
	</table>
    </div>
</div>	


<?php 
	$dailyChartJson = '';
	$dailychart = array();
	foreach($iData as $day => $amount):
		$dailychart[] = array(
			'Sales'   => $iData[$day]['SALES'],
			'Expense' => $dailyExpense[$day],
			'Day'	  => DateUtils::DUFormat('d', $day),
			'electricity' => 0,
			'water'       => 0,
			'manpower'    => 0,
		);
	endforeach;
	$dailyChartJson = json_encode($dailychart);
	//HTMLLib::vardump($dailyChartJson);
	
?>
<script type="text/javascript">
            var chart;
            var chartData = <?php echo $dailyChartJson ?>

            AmCharts.ready(function () {
                // SERIAL CHART  
                chart = new AmCharts.AmSerialChart();
                chart.pathToImages = "../amcharts/images/";
                chart.dataProvider = chartData ;
                chart.categoryField = "Day";
                chart.startDuration = 1;
                chart.addTitle("INCOME VS EXPENSES DAILY", 14);
                
                chart.handDrawn = true;
                chart.handDrawnScatter = 3;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // column graph
                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "Sales";
                graph1.lineColor = "#97BECF";
                graph1.valueField = "Sales";
                graph1.lineAlpha = 1;
                graph1.fillAlphas = 1;
                graph1.dashLengthField = "dashLengthColumn";
                graph1.alphaField = "alpha";
                graph1.balloonText = "<span style='font-size:13px;'>[[title]] in [[category]]: <b>[[value]]</b> [[additional]]</span>";
                chart.addGraph(graph1);

                // line
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "line";
                graph2.title = "Expense";
                graph2.lineColor = "#fcd202";
                graph2.valueField = "Expense";
                graph2.lineThickness = 3;
                graph2.bullet = "round";
                graph2.bulletBorderThickness = 3;
                graph2.bulletBorderColor = "#fcd202";
                graph2.bulletBorderAlpha = 1;
                graph2.bulletColor = "#ffffff";
                graph2.dashLengthField = "dashLengthLine";
                graph2.balloonText = "<span style='font-size:13px;'>[[title]] in [[category]]: <b>[[value]]</b> [[additional]]</span>";
                chart.addGraph(graph2);

                // LEGEND                
                var legend = new AmCharts.AmLegend();
                legend.useGraphSettings = true;
                chart.addLegend(legend);

                // WRITE
                chart.write("dailyChart");
            });
        </script>
        <div id="dailyChart" style=" height:400px;"></div>
<?php endif;  ?>


