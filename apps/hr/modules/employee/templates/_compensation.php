<?php use_helper('Validation', 'Javascript') ?>
<?php $users = array('emmanuel', 'terence', 'melvin', 'adeline', 'florence', 'nyoman'); ?>
<?php $access = false; ?>
<?php 
	if (in_array(HrLib::GetUser(), $users) ): 
		$access = true;
	else:
		$hrData = HrEmployeePeer::retrieveByPK($sf_params->get('id'));
		if ($hrData):
			// compensation can still be accessible under 30 days
			$dcreated = $hrData->getDateCreated()? DateUtils::DUFormat('Y-m-d', $hrData->getDateCreated()) : '2008-01-01';
			if (DateUtils::DateDiff('d', $dcreated, Date('Y-m-d') ) <= 30  ):
				$access = true;
			endif;
		endif;
	endif;
?>
<?php if ($access):?>
<div class="grid">
    <div class="row">
        <div class="span6">
        <div id="DIVbasicPay">
		<table class="table bordered condensed">
			<tr>
				<td colspan="2" class="bg-lime alignRight" nowrap><span
						class="fg-white">BASIC PAY</span></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2 " nowrap>Bank
				Acct #</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('acct_no');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Commence Date</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('commence_date');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Effectivity
				Date</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('effectivity_date');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Pay</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('scheduled_amount') .' / '. $sf_params->get('frequency');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Payment Every</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('frequency');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Hourly Rate</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('hourly_rate');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Allowance</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('allowance');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Levy</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('levy');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Paid Type</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('paid_type') ;
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Employment</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('type_of_employment') ;
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Has MC Benefit</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('has_mc_benefit') ;
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap>Remarks</td>
				<td class="alignLeft" nowrap><?php
				echo $sf_params->get('remark');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight " nowrap></td>
				<td class="alignLeft" nowrap><?php
				//echo AjaxLib::AjaxScript('edit_basic', 'employee/editBasic', 'acct_no,commence_date,effectivity_date,scheduled_income,frequency,hourly_rate,allowance,levy,paid_type,type_of_employment,has_mc_benefit,remark','', 'DIVbasicPay');
				echo AjaxLib::AjaxScript('edit_basic', 'employee/editBasicPay', 'id','', 'DIVbasicPay');
				echo HTMLLib::CreateSubmitButton('edit_basic', 'Edit Basic Pay');
				?></td>
			</tr>
		
		</table>
		</div>
        </div>
        
        <!-- CPF ENTRY -->
        <div class="span6">
        <div id="DIVcpfPay">
			<table  class="table bordered condensed">
				<tr>
					<td colspan="2" class="bg-lime alignRight" nowrap><span
						class="fg-white">CPF INFORMATION</span></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight span2" width="50px"
						nowrap>Contribute CPF</td>
					<td class="alignLeft" nowrap><?php
					echo $sf_params->get('cpf') ;
					?></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight " nowrap>CPF Amount</td>
					<td class="alignLeft" nowrap><?php
					echo $sf_params->get('cpf_amount');
					?></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight " nowrap>CPF
					Citizenship</td>
					<td class="alignLeft" nowrap><?php
					echo $sf_params->get('cpf_citizenship') ;
					?></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight " nowrap>Nationality</td>
					<td class="alignLeft" nowrap><?php
					echo $sf_params->get('nationality') ;
					?></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight " nowrap>Race</td>
					<td class="alignLeft" nowrap><?php
					echo $sf_params->get('race') ;
					?></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight " nowrap>Birth Date</td>
					<td class="alignLeft" nowrap><?php
					echo $sf_params->get('date_of_birth') ;
					?></td>
				</tr>
				<tr>
					<td class="bg-clearBlue alignRight " nowrap></td>
					<td class="alignLeft" nowrap><?php
					echo AjaxLib::AjaxScript('edit_cpf', 'employee/editCpfPay', 'id','', 'DIVcpfPay');
					echo HTMLLib::CreateSubmitButton('edit_cpf', 'Edit CPF Pay');
					?></td>
				</tr>
			</table>
			
			
			</div>
        </div>
    </div>
    <div class="row">
        <div class="">
        	<?php 
        		if (isset($bppager)):
        			$filename = hrPager::PayHistory($bppager, $sf_params->get('id'));
					$cols = array('seq', 'action', 'name', 'monthly', 'allowance','rate_hr', 'levy', 'effectivity', 'remark');
					echo PagerJson::AkoDataTableForTicking($cols, $filename); //create the table
	       		endif;
        	?>
        </div>
    </div>
    <div class="row">
    	
				<table class="table bordered condensed">
					<tr>
						<td colspan="2" class="bg-lime alignRight" nowrap><span
							class="fg-white">EXTRA INCOME</span></td>
					</tr>
					<tr>
						<td class="span2 bg-clearBlue alignRight" nowrap>Account</td>
						<td class="alignLeft" nowrap>
						<?php
						echo $sf_params->get('extra_acct_code');
						//$acctCode = PayAccountCodePeer::GetAcctCodeList();
						//echo HTMLLib::CreateSelectSearch('extra_acct_code', $sf_params->get('extra_acct_code'), $acctCode,'span3' );
						?> <span class="negative"></span></td>
					</tr>
					<tr>
						<td class="bg-clearBlue alignRight" nowrap>Scheduled Amount</td>
						<td class="alignLeft" nowrap><?php
						echo $sf_params->get('extra_scheduled_amount');
						?> <small class="text-warning">To be paid Monthly</small>
						&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td class="bg-clearBlue alignRight" nowrap>Effectivity Date</td>
						<td class="alignLeft" nowrap><?php
						echo $sf_params->get('extra_sdate');
						?></td>
					</tr>
					<tr>
						<td class="bg-clearBlue alignRight" nowrap>Frequency</td>
						<td class="alignLeft" nowrap><?php
						echo $sf_params->get('extra_frequency');
						?></td>
					</tr>
					<tr>
						<td class="bg-clearBlue alignRight" nowrap>Status</td>
						<td class="alignLeft" nowrap><?php
						echo $sf_params->get('is_active');
						?> <span class="negative">*</span></td>
					</tr>
					<tr>
						<td class="bg-clearBlue" nowrap></td>
						<td><?php 
						echo AjaxLib::AjaxScript('add_extra_income', 'employee/editExtraIncome', 'id','', 'DIVExtraIncome');
						echo HTMLLib::CreateSubmitButton('add_extra_income', 'Add Extra Income' );
						?></td>
					</tr>
				</table>
        <div class="bg-clearBlue">
        	<?php 
        		if (isset($extrapager)):
        			$filename = hrPager::FixedIncome($extrapager, $sf_params->get('id'));
					$cols = array('seq', 'name', 'description', 'amount','remark', 'effectivity', 'created_by', 'date_created');
					echo PagerJson::AkoDataTableForTicking($cols, $filename); //create the table
	       		endif;
        	?>
        </div>
    </div>
    
</div>
				
<script>
$( document ).ready(function() {
	$( "#scheduled_amount" ).change(function() {
	  alert( "test" );
	});
});
</script>






<!--
	
		<div id="DIVExtraIncome">
		<div id="divBorder">
		<table width="100%" class="FORMtable" border="0" cellpadding="4"
			cellspacing="0">
			<tr>
				<td colspan="2" height="25" width="100" nowrap>
				<div class="tk-style53 alignCenter">
				<h2>EXTRA INCOME (FIXED MONTHLY)</h2>
				</div>
				</td>
			</tr>
			<tr>
				<td><?php
//				$gridVars = array(
//				    'searchTemplate' => '',
//				    'pagerTemplate' => 'extraincome_pager_list',
//				    'baseURL' => $sf_request->getModuleAction(),
//				    'pager' => $eincpager,
//				    'searchContainerID' => XIDX::next(),
//				    'headers' => sfConfig::get('app_eincome_grid_headers')
//				);
//				include_partial('global/datagrid/container', $gridVars);
				?></td>
			</tr>
		</table>
		
		<div id="divBorder">
		<table width="100%" class="FORMtable" border="0" cellpadding="4"
			cellspacing="0">
			<tr>
				<td colspan="2" height="25" width="100" nowrap>
				<div class="tk-style53 alignCenter">
				<h2>PAY HISTORY</h2>
				</div>
				</td>
			</tr>
			<tr>
				<td><?php
//				$gridVars = array(
//				    'searchTemplate' => 'basicpay_list_header_search',
//				    'pagerTemplate' => 'basicpay_pager_list',
//				    'baseURL' => $sf_request->getModuleAction(),
//				    'pager' => $bppager,
//				    'searchContainerID' => XIDX::next(),
//				    'headers' => sfConfig::get('app_basicpay_grid_headers')
//				);
//				include_partial('global/datagrid/container', $gridVars);
				?></td>
			</tr>
		</table>
		</div>
		</td>
	</tr>


</table>

				-->
<?php 
else:
	echo '<h1> YOU ARE NOT ALLOWED TO VIEW THIS PAGE </h1><pre>Contact Eman.</pre>'; 
endif; ?>

