<div class="contentBox">
	<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('maintenance/workTemplateUpdate'). '?id=' . $sf_params->get('id');?>" method="post">

	<div class="negative"><h1>WARNING</h1></div>
	<div class="negative"><p>You are about to update the daily required hours for the year <span class="negative"><?php echo sfConfig::get('fiscal_year') ?></span><br>
	You must do this every after new year since the workschedule is pre-prepaid every one year. <br>
	<br>
	<span class="positive"> Please back up tk_worktemplate_detail before proceeding.</span><br><br>
	click on the button below if you want to proceed...<br><br>
	<input type="submit" name="save" value=" PREPARE WORKSCHEDULE <?php echo sfConfig::get('fiscal_year') ?>" class="success">
	</p></div>
	</form>
</div>
