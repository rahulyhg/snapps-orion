<script type="text/javascript">
	$(document).ready(function(){
		$('#framework').click(function (){
				window.location.href='welcome/framework';
				//window.location.href='<?php echo sfConfig::get('http_intranet') . 'orion/reject' ?>';
			});

		$('#hr').click(function (){
			window.location.href='<?php echo sfConfig::get('http_intranet') . 'orion/hr' ?>';
		});
		
		$('#reject').click(function (){
			window.location.href='<?php echo sfConfig::get('http_intranet') . 'orion/reject' ?>';
		});
		
		$('#ticket').click(function (){
			window.location.href='<?php echo sfConfig::get('http_intranet') . 'orion/ticket' ?>';
		});

		$('#camera').click(function (){
			window.location.href='<?php echo sfConfig::get('http_intranet') . 'orion/camera' ?>';
		});
		
		$('#survey').click(function (){
			window.location.href='<?php echo sfConfig::get('http_intranet') . 'orion/survey' ?>';
		});
	});
</script>
<table class="" border='0'>
	<tr>
		<td colspan="2" class="alignCenter">
			<h2>DASHBOARD MENU</h2>
		</td>
	</tr>
</table>
<div class="listview">
	<a href="<?php echo sfConfig::get('http_intranet') . 'orion/reject' ?>" class="list" id="reject">
		<div class="list-content">
			<?php echo image_tag('WIN8.png','class="icon"') ?>
			<div class="data">
			<span class="list-title">Goto Reject Photo</span>
			<div class="progress-bar">
				<div class="bar bg-color-green" style="width: 100%"></div>
			</div>
			<span class="list-remark">Take photo / send email</span>
			</div>
		</div>
	</a>
	
	<a href="<?php echo sfConfig::get('http_intranet') . 'orion/survey' ?>" class="list" >
		<div class="list-content">
			<?php echo image_tag('WIN8.png','class="icon"') ?>
			<div class="data">
			<span class="list-title">Goto Reject Survey</span>
			<div class="progress-bar">
				<div class="bar bg-color-green" style="width: 100%"></div>
			</div>
			<span class="list-remark">Employee Satisfaction Index</span>
			</div>
		</div>
	</a>
	
	<a href="<?php echo sfConfig::get('http_intranet') . 'orion/camera' ?>" class="list" >
		<div class="list-content">
			<?php echo image_tag('WIN8.png','class="icon"') ?>
			<div class="data">
			<span class="list-title">Goto Camera Viewer</span>
			<div class="progress-bar">
				<div class="bar bg-color-green" style="width: 100%"></div>
			</div>
			<span class="list-remark">View Camera</span>
			</div>
		</div>
	</a>
	
	<?php if ( $sf_user->getUsername() == 'emmanuel' ): ?>
	<a href="<?php echo sfConfig::get('http_intranet') . 'orion/hr' ?>" class="list" >
		<div class="list-content">
			<?php echo image_tag('WIN8.png','class="icon"') ?>
			<div class="data">
			<span class="list-title">Goto HR</span>
			<div class="progress-bar">
				<div class="bar bg-color-green" style="width: 100%"></div>
			</div>
			<span class="list-remark">Human Resource</span>
			</div>
		</div>
	</a>
	
		<a href="<?php echo sfConfig::get('http_intranet') . 'orion/dashboard' ?>" class="list" >
		<div class="list-content">
			<?php echo image_tag('WIN8.png','class="icon"') ?>
			<div class="data">
			<span class="list-title">Goto Framework</span>
			<div class="progress-bar">
				<div class="bar bg-color-green" style="width: 100%"></div>
			</div>
			<span class="list-remark">Sandbox</span>
			</div>
		</div>
		</a>
	<?php endif; ?>
</div>
<div class="times" data-role="times" ></div>

<?php include_partial('tellTime') ?>

        