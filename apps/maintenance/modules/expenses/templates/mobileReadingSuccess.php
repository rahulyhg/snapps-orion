<script type="text/javascript">
       document.body.style.zoom = "240%" ;
</script>
<style type="text/css">
       #mydiv {
    	    position:fixed;
    	    top: 50%;
    	    left: 50%;
    	    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    	    margin-left: -15em; /*set to a negative number 1/2 of your width*/
    	    background-color: #fff;
    	}
</style>
<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('expenses/mobileReading'). '?id=' . $sf_params->get('id');?>" method="post">
<div id="mydiv">
<table class="bordered condensed table span5">
	<tr>
		<td colspan="3" class="bg-clearGreen text-right span2"><label>DAILY UTILITIES READING <small>(Water & Electricity)</small></label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue text-right span2"><label><small>AM ELECTRICITY READING</small></label></td>
		<td class="  "><label>
			<?php 
				if (!$sf_params->get('power_am_reading')):
					echo HTMLLib::CreateInputTextNumberOnly('power_am_reading', $sf_params->get('power_am_reading'), 'span3' );
				else:
					echo $sf_params->get('power_am_reading');
				endif;
			?></label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue text-right span2"><label><small>AM WATER READING</small></label></td>
		<td class="  "><label>
			<?php 
				if (!$sf_params->get('water_am_reading')):
					echo HTMLLib::CreateInputTextNumberOnly('water_am_reading', $sf_params->get('water_am_reading'), 'span3' );
				else:
					echo $sf_params->get('water_am_reading');
				endif;
			?></label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue text-right span2"><label><small>PM ELECTRICITY READING</small></label></td>
		<td class="  "><label>
			<?php 
				if (!$sf_params->get('power_pm_reading')):
					echo HTMLLib::CreateInputTextNumberOnly('power_pm_reading', $sf_params->get('power_pm_reading'), 'span3' );
				else:
					echo $sf_params->get('power_pm_reading');
				endif;
			?></label></td>
	</tr>
	<tr>
		<td class="bg-clearBlue text-right span2"><label><small>PM WATER READING</small></label></td>
		<td class="  "><label>
			<?php 
				if (!$sf_params->get('water_pm_reading')):
					echo HTMLLib::CreateInputTextNumberOnly('water_pm_reading', $sf_params->get('water_pm_reading'), 'span3' );
				else:
					echo $sf_params->get('water_pm_reading');
				endif;
			?></label></td>
	</tr>
	<tr>
		<td colspan="3" class=" text-right span2"><label><?php echo HTMLLib::CreateSubmitButton('save', 'Save Data'); ?></label></td>
	</tr>
</table>
</div>
</form>