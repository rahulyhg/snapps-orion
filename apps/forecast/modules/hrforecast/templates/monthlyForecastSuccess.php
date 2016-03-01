<?php use_helper('Form', 'Javascript');
?>
<form name="FORMadd" id="IDFORMadd"
	action="<?php echo url_for('hrforecast/monthlyForecast'). '?id=' . $sf_params->get('id');?>"
	method="post">
<div class="contentBox">
<div class="panel">
    <div class="panel-header bg-lightBlue fg-white">
        MONTHLY HR FORECAST COSTING
    </div>
    <div class="panel-content">
        <table class="bordered condensed table">
		<tr>
			<td class="alignRight bg-clearBlue">Month</td>
			<td class="">
				<?php 
					echo HTMLLib::CreateSelect('month_start', $sf_params->get('month_start'), $monthList, 'span2');
					echo HTMLLib::CreateSelect('year_1', $sf_params->get('year_1'), $yearList, 'span1');
					echo ' to ';
					echo HTMLLib::CreateSelect('month_end', $sf_params->get('month_end'), $monthList, 'span2'); 
					echo HTMLLib::CreateSelect('year_2', $sf_params->get('year_2'), $yearList, 'span1');
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
			<td class="alignRight bg-clearBlue">Notes</td>
			<td class="fg-crimson">
				The Data here is based on estimates.  This is best used when calculating a forecast
			</td>
		</tr>
		<tr>
			<td class="alignRight bg-clearBlue"></td>
			<td class="">
				<?php 
					echo HTMLLib::CreateSubmitButton('compute', 'Compute Monthly Cost');
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
//print_r($monthlyData);
//echo '</pre>';
//exit();
if ($benchmark):
?>
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
	<div class="panel ">
    <div class="panel-header bg-lightBlue fg-white">
        EMPLOYEE COMPUTATION
    </div>
    <div class="panel-content" >
		<table class="bordered table condensed hovered">
			<th class="bg-clearBlue"><small>Seq</small></th>
			<th class="bg-clearBlue"><small>Name</small></th>
			<?php foreach($months as $month):?>
				<th class="bg-clearBlue"><small><?php echo DateUtils::DUFormat('M-Y', $month) ?></small></th>
			<?php endforeach; ?>
			<th class="bg-clearBlue">Total</th>
			
			<?php foreach($employeeList as $empno => $name): $cnt++ ?>
			<?php //var_dump ( HrEmployeePeer::IsResigned($empno)? 'bg-crimson' : '' ); var_dump($name); exit();?>
			<tr class="<?php echo HrEmployeePeer::IsResigned($empno)? 'bg-clearRed ' : '' ?>">
				<td><small><?php echo $cnt; ?></small></td>
				<td><small><?php echo substr($name,0, 15); //$empno .' : '. $name ?></small></td>
				<?php foreach($months as $month):?>
					<td class="alignRight">
						<small><a href="#" data-hint="basic pay"><?php echo number_format($monthlyData[$month][$empno],2) ;  ?></a> + <a href="#" data-hint="overtime"><?php echo number_format($monthlyOvertime[$month][$empno],2) ;  ?></a></small>
					</td>
				<?php endforeach; ?>
				<td class="alignRight"><small><?php echo number_format($totalPerEmployee[$empno],2) ?></small></td>
			</tr>
			<?php endforeach;?>
			<tr  class="bg-clearGreen alignRight">
				<td colspan="2">Total</td>
				<?php foreach($months as $month):?>
					<td><small>
					<?php 
						echo number_format($totalPerMonth[$month]['basic'] + $totalPerMonth[$month]['ot'], 2);
						$grandTotal +=  $totalPerMonth[$month]['basic'] + $totalPerMonth[$month]['ot'];
					?></small></td>
				<?php endforeach;?>
				<td ><small><?php echo number_format($grandTotal,2 ); ?></small></td>
			</tr>
		</table>
	</div>
	</div>
</form>
	<br>
<!--	<div class="panel " data-role="panel">-->
<!--	    <div class="panel-header bg-lightBlue fg-white">-->
<!--	        TREND CHART-->
<!--	    </div>-->
<!--	    <div class="panel-content" style="display: none;" >-->

<?php 
//prepare graph data
$perWeekTotalTrend = array();
foreach($months as $month):
	$perWeekTotalTrend[] = array('month' => DateUtils::DUFormat('M-Y', $month), 'salary' => $totalPerMonth[$month]['basic'], 'ot' => $totalPerMonth[$month]['ot']); 
endforeach;
$perWeekTotalTrendJson = json_encode($perWeekTotalTrend);

//$perEmployeePerWeekTotalTrend = array();
//$employee = array();
//foreach($months as $month):
//	foreach($employeeList as $empno => $name):
//		$employee = array('name' => $name, 'salary' => $monthlyData[$month][$empno] ); 
//	endforeach;
//	$perEmployeePerWeekTotalTrend[] = array_merge(array('week'=> $month), $employee);
//endforeach;
//$perEmployeePerWeekTotalTrendJson = json_encode($perEmployeePerWeekTotalTrend);
//echo '<pre>';
//print_r($monthlyData);
//echo '</pre>';
//exit();

?>
<?php //echo $perWeekTotalTrendJson; ?>
<!--<script type="text/javascript">-->
<!--            var chartData = <?php echo $perWeekTotalTrendJson; ?>;-->
<!--            -->
<!--            var chart = AmCharts.makeChart("chartdiv", {-->
<!--                type: "serial",-->
<!--                pathToImages: "../../js/amcharts/images/",-->
<!--                dataProvider: chartData,-->
<!--                categoryField: "week",-->
<!--                categoryAxis: {-->
<!--                    gridAlpha: 0.15,-->
<!--                    minorGridEnabled: true,-->
<!--                    axisColor: "#DADADA"-->
<!--                },-->
<!--                valueAxes: [{-->
<!--                    axisAlpha: 0.2,-->
<!--                    id: "v1"-->
<!--                }],-->
<!--                graphs: [{-->
<!--                    title: "red line",-->
<!--                    id: "g1",-->
<!--                    valueAxis: "v1",-->
<!--                    valueField: "salary",-->
<!--                    bullet: "round",-->
<!--                    bulletBorderColor: "#FFFFFF",-->
<!--                    bulletBorderAlpha: 1,-->
<!--                    lineThickness: 2,-->
<!--                    lineColor: "#b5030d",-->
<!--                    negativeLineColor: "#0352b5",-->
<!--                    balloonText: "[[category]]<br><b><span style='font-size:14px;'>salary: [[value]]</span></b>"-->
<!--                }],-->
<!--                chartCursor: {-->
<!--                    cursorPosition: "mouse"-->
<!--                },-->
<!--                chartScrollbar: {-->
<!--                    scrollbarHeight: 40,-->
<!--                    color: "#FFFFFF",-->
<!--                    autoGridCount: true,-->
<!--                    graph: "g1"-->
<!--                }-->
<!--            });-->
<!---->
<!--            chart.addListener("dataUpdated", zoomChart);-->
<!---->
<!--            // this method is called when chart is first inited as we listen for "dataUpdated" event-->
<!--            function zoomChart() {-->
<!--                // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues-->
<!--                chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);-->
<!--            }-->
<!---->
<!--            // changes cursor mode from pan to select-->
<!--            function setPanSelect() {-->
<!--                var chartCursor = chart.chartCursor;-->
<!---->
<!--                if (document.getElementById("rb1").checked) {-->
<!--                    chartCursor.pan = false;-->
<!--                    chartCursor.zoomable = true;-->
<!---->
<!--                } else {-->
<!--                    chartCursor.pan = true;-->
<!--                }-->
<!--                chart.validateNow();-->
<!--            }           -->
<!--        </script>-->
<!--        <div id="chartdiv" style="width: 100%; height: 400px;"></div>-->
<!--        -->
<!--        <div style="margin-left:35px;">-->
<!--            <input type="radio" checked="true" name="group" id="rb1" onclick="setPanSelect()">Select-->
<!--            <input type="radio" name="group" id="rb2" onclick="setPanSelect()">Pan-->
<!--		</div> -->
		
		<br>
		
	<div class="panel " >
	    <div class="panel-header bg-lightBlue fg-white">
	        ANALYSIS CHART
	    </div>
	    <div class="panel-content" >		
		<script type="text/javascript">
            var chart;
            
            var chartData = <?php echo $perWeekTotalTrendJson; ?>;

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "month";
                chart.plotAreaBorderAlpha = 0.2;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.stackType = "regular";
                valueAxis.gridAlpha = 0.1;
                valueAxis.axisAlpha = 0;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph    
                var graph = new AmCharts.AmGraph();
                graph.title = "salary";
                graph.labelText = "[[value]]";
                graph.valueField = "salary";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                graph.lineColor = "#C72C95";
                graph.balloonText = "<span style='color:#555555;'>[[category]]</span><br><span style='font-size:14px'>[[title]]:<b>[[value]]</b></span>";
                chart.addGraph(graph);

                // second graph              
                graph = new AmCharts.AmGraph();
                graph.title = "overtime";
                graph.labelText = "[[percents]]%";
                graph.valueField = "ot";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                graph.lineColor = "#D8E0BD";
                graph.balloonText = "<span style='color:#555555;'>[[category]]</span><br><span style='font-size:14px'>[[title]]:<b>[[value]]</b></span>";
                chart.addGraph(graph);                

             	// LEGEND
                var legend = new AmCharts.AmLegend();
                legend.position = "right";
                legend.borderAlpha = 0.3;
                legend.horizontalGap = 10;
                legend.switchType = "v";
                chart.addLegend(legend);

                chart.creditsPosition = "top-right";
                // WRITE
                chart.write("stackedChart");
            });

            // this method sets chart 2D/3D
            function setDepth() {
                if (document.getElementById("rb1").checked) {
                    chart.depth3D = 0;
                    chart.angle = 0;
                } else {
                    chart.depth3D = 25;
                    chart.angle = 30;
                }
                chart.validateNow();
            }
        </script>
        
        <div id="stackedChart" style="height: 400px;"></div>
        <div style="margin-left:30px;">
	        <input type="radio" checked="true" name="group" id="rb1" onclick="setDepth()">2D
	        <input type="radio" name="group" id="rb2" onclick="setDepth()">3D
		</div>
	</div>
	</div>	
<?php 	
endif;
?>		
<!--<script>-->
<!--$("#checkAll").change(function () {-->
<!--    $("input:checkbox").prop("checked", $(this).prop("checked"));-->
<!--    	    -->
<!--});-->
<!--</script>-->
</div>