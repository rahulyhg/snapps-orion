<?php use_helper('Form', 'Javascript');
?>
<form name="FORMadd" id="IDFORMadd"
	action="<?php echo url_for('hrforecast/dailyForecast') ?>"
	method="post">
<div class="contentBox">
<div class="panel">
    <div class="panel-header bg-lightBlue fg-white">
        DAILY HR COSTING
    </div>
    <div class="panel-content">
        <table class="bordered condensed table">
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
			<td class="alignRight bg-clearBlue">Update</td>
			<td class="">
				<small class="fg-crimson">last update: <?php echo HrEmployeeDailyPeer::GetLastUpdate()?></small>
			</td>
		</tr>
			<td class="alignRight bg-clearBlue"></td>
			<td class="">
				<?php 
					echo HTMLLib::CreateSubmitButton('compute', 'Compute Daily Cost');
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
//print_r($weeklyData);
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
			<th rowspan="2" class="bg-clearBlue"><small>Seq</small></th>
			<th rowspan="2" class="bg-clearBlue"><small>Name</small></th>
			<?php foreach($days as $day):?>
				<th class="bg-clearBlue"><small><?php echo $day ?></small></th>
			<?php endforeach; ?>
			<th rowspan="2" class="bg-clearBlue">Total</th>
			<tr>
				<?php foreach($days as $day):?>
				<td class="alignCenter bg-clearBlue"><small><?php echo DateUtils::DUFormat('D',  $day ) ; ?></small></td>
				<?php endforeach; ?>
			</tr>
			
			<?php foreach($employeeList as $empno => $name): $cnt++ ?>
			<?php //var_dump ( HrEmployeePeer::IsResigned($empno)? 'bg-crimson' : '' ); var_dump($name); exit();?>
			<tr class="<?php echo HrEmployeePeer::IsResigned($empno)? 'bg-clearRed ' : '' ?>">
				<td><small><?php echo $cnt; ?></small></td>
				<td><small><?php echo substr($name,0, 15); //$empno .' : '. $name ?></small></td>
				<?php foreach($days as $day):?>
					<td class="alignRight">
						<small><a href="#" data-hint="basic pay"><?php echo number_format($dailyData[$day][$empno],2) ;  ?></a> + <a href="#" data-hint="overtime"><?php echo number_format($dailyOvertime[$day][$empno],2) ;  ?></a></small>
					</td>
				<?php endforeach; ?>
				<td class="alignRight"><small><?php echo number_format($totalPerEmployee[$empno],2) ?></small></td>
			</tr>
			<?php endforeach;?>
			<tr  class="bg-clearGreen alignRight">
				<td colspan="2">Total</td>
				<?php foreach($days as $day):?>
					<td><small>
					<?php 
						echo number_format($totalPerDay[$day]['basic'] + $totalPerDay[$day]['ot'], 2);
						$grandTotal +=  $totalPerDay[$day]['basic'] + $totalPerDay[$day]['ot'];
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
$perDayTotalTrend = array();
foreach($days as $day):
	$perDayTotalTrend[] = array('day' => $day, 'salary' => $totalPerDay[$day]['basic'], 'ot' => $totalPerDay[$day]['ot']); 
endforeach;
$perDayTotalTrendJson = json_encode($perDayTotalTrend);

?>
<?php //echo $perWeekTotalTrendJson; ?>
	<div class="panel " >
	    <div class="panel-header bg-lightBlue fg-white">
	        ANALYSIS CHART
	    </div>
	    <div class="panel-content" >		
		<script type="text/javascript">
            var chart;
            
            var chartData = <?php echo $perDayTotalTrendJson; ?>;

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "day";
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
                graph.labelText = "[[percents]]%";
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
                legend.borderAlpha = 0.2;
                legend.horizontalGap = 10;
                chart.addLegend(legend);

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