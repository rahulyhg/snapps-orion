<form name="FORMadd" id="IDFORMadd" action="<?php echo url_for('dashboard/requestTicket') ?>" method="post">
<div class="contentBox">
<div class="grid">
	<div class="row">
		<div class="span6">
		<?php 
			echo AjaxLib::AjaxScript('DIVresigned', 'dashboard/ajaxResigned', '', '', 'requestDIV');
			echo AjaxLib::AjaxScript('DIVresigned', 'dashboard/ajaxResigned', '', '', 'requestDIV');
		
		?>
			<table class="table bordered condensed ">
			<th class="bg-orange fg-white" colspan="2" height="30px">REQUEST FOR TICKET</th>
			<tr>
				<td class="alignCenter">
						<?php
						echo link_to('
							<i class="icon-user-2 on-left "></i>
		                    <h3>RESIGNED EMPLOYEE</h3>
		                    <small>For employee who left the company</small>', 'dashboard/ticketSearch', 'class="command-button primary span4" id="DIVresigned" ') 
						?>
				</td>
			</tr>
			<tr>
				<td class="alignCenter">
						<?php 
						echo link_to('
							<i class="icon-user-2 on-left"></i>
		                    <h3>NEW EMPLOYEE</h3>
		                    <small>Add New Employee</small>', 'employee/employeeSearch', 'class="command-button primary span4" ' ); 
						?>
				</td>
			</tr>
			</table>
		</div>
		<div class="span7">
			<div id="requestDIV">
				&nbsp;
			</div>
		</div>
	</div> <!-- row -->	
	<div class="row">
		<table class="table bordered condensed ">
			<tr>
				<th class="bg-orange fg-white" colspan="2" height="30px">REQUEST LIST</td>
			</tr>
		</table>
		<?php
		    if (isset($tpager)):
				$filename = hrPager::TicketRequestPager($tpager);
				$cols = array('seq', 'name', 'request_type', 'date_effective', 'remark');
				echo PagerJson::AkoDataTableForTicking($cols, $filename);
			endif;
		?>
	</div>
</div> <!-- grid -->	
</div> <!-- contentBox -->	
</form>