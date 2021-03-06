<?php use_helper('Validation', 'Javascript') ?>
<div class="contentBox">
<form name="FORMadd" id="IDFORMadd" 
	action="<?php echo url_for('report/employeeDetailReport?id='.$sf_params->get('id') )?>" method="post">
<table class="table bordered">
<tr>
	<td colspan="3" >
		<nav class="breadcrumbs">
			<ul>
			<li><a href="#">Home</a></li>
			<li class=" "><a id="save" href="<?php echo url_for('report/employeeDetailReport') ?>" class="" >Add New Employee</a></li>
			<li><a href="#">&nbsp;</a></li>
			</ul>
		</nav>
	</td>
</tr>
</table>

<div class="panel" data-role="panel">
		    <div class="panel-header bg-blue fg-white">
		    SEARCH FILTER
		    </div>
		    <div class="panel-content bg-clearBlue" style="display: none;">
		<table class="table bordered condensed">
			<tr>
				<td class="bg-clearBlue alignRight span2" >PASS TYPE</td>
				<td colspan="5" class="" >
				<?php 
				$rankType = array(
					''=> ' -SELECT WORK PASS-',
				    'SPR'=> ' -SPR-',
					'FW'=> ' -FOREIGN WORKER-',
					'SPASS'=> ' -SPASS-',
					'EPASS'=> ' -EPASS-',
					'PEPASS'=> ' -PEPASS-',
					'WP'=> ' -WORK PERMIT-',
					'PRC'=> ' -PRC-',
					'DP'=> ' -DEPENDANTS PASS-',
					//'S'=> ' -SINGAPOREAN ONLY-',  //does not work without entry on hr_employee_ic
					'PR'=> ' -PR ONLY-',
				);
				echo HTMLLib::CreateSelect('rank_code', $sf_params->get('rank_code'), $rankType, 'span3');
				?>
				</td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" >COMPANY</td>
				<td class="" colspan="5" ><?php 
				$companyList = HrCompanyPeer::GetCompanyList();
				echo HTMLLib::CreateSelect('company_filter', $sf_params->get('company_filter'), $companyList, 'span3');
				?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="span2" ><?php echo HTMLLib::CreateCheckBox('chk_seq', 'Sequence No', $sf_params->get('chk_seq'))?></td>
				<td class="span2" ><?php echo HTMLLib::CreateCheckBox('chk_employee_no', 'Employee No', $sf_params->get('chk_employee_no'))?></td>
				<td class="span2" ><?php echo HTMLLib::CreateCheckBox('chk_name', 'Name', $sf_params->get('chk_name'))?></td>
				<td class="span2" ><?php echo HTMLLib::CreateCheckBox('chk_company', 'Company', $sf_params->get('chk_company'))?></td>
				<td class="span2" ><?php echo HTMLLib::CreateCheckBox('chk_team', 'Team', $sf_params->get('chk_team'))?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_age', 'Age', $sf_params->get('chk_age'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_joined_date', 'Joined Date', $sf_params->get('chk_joined_date'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_race', 'Race', $sf_params->get('chk_race'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_nationality', 'Nationality', $sf_params->get('chk_nationality'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_cell_no', 'Contact', $sf_params->get('chk_cell_no'))?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_cpf', 'Cpf', $sf_params->get('chk_cpf'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_cpf_year', 'Cpf Year', $sf_params->get('chk_cpf_year'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_paid_type', 'Paid Type', $sf_params->get('chk_paid_type'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_account_no', 'Account No', $sf_params->get('chk_account_no'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_mom_group', 'MOM Group', $sf_params->get('chk_mom_group'))?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_m_allowance', 'Monthly Allowance', $sf_params->get('chk_m_allowance'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_basic_pay', 'Basic Pay', $sf_params->get('chk_basic_pay'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_other_income', 'Other Income', $sf_params->get('chk_other_income'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_pass_type', 'Pass Type', $sf_params->get('chk_pass_type'))?></td>
				<td><?php echo HTMLLib::CreateCheckBox('chk_gender', 'Gender', $sf_params->get('chk_gender'))?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_employer_share', 'Employer Share', $sf_params->get('chk_employer_share'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_levy', 'Levy', $sf_params->get('chk_levy'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_dob', 'Date Of Birth', $sf_params->get('chk_dob'))?></td>
				<td class="" ><?php echo HTMLLib::CreateCheckBox('chk_fin', 'NRIC/FIN', $sf_params->get('chk_fin'))?></td>
				<td class="" ><?php //echo HTMLLib::CreateCheckBox('chk_other_income', 'Other Income', $sf_params->get('chk_other_income'))?></td>
				<td class="" ><?php //echo HTMLLib::CreateCheckBox('chk_pass_type', 'Pass Type', $sf_params->get('chk_pass_type'))?></td>
				<td><?php //echo HTMLLib::CreateCheckBox('chk_gender', 'Gender', $sf_params->get('chk_gender'))?></td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="" ><?php //echo HTMLLib::CreateCheckBox('chk_spr_worker', 'Singaporean/PR Only', $sf_params->get('chk_spr_worker'))?></td>
				<td class="" ><?php //echo HTMLLib::CreateCheckBox('chk_foreign_worker', 'Foreign Worker Only', $sf_params->get('chk_foreign_worker'))?></td>
				<td class="" >&nbsp;</td>
				<td class="" >&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class="bg-clearBlue alignRight span2" ></td>
				<td class="" ><?php echo HTMLLib::CreateSubmitButton('filter_search', 'Filter Search')?></td>
			</tr>
		</table>
	</div>
</div>
<br />
<?php 
if (isset($pager))
{

    $filename = hrPager::SearchEmployeeReport($pager, sfContext::getInstance()->getUser()->getUsername());
	//$cols = array('seq','employee_no', 'name', 'team', 'company', 'joined-date', 'age', 'basic_pay', 'm_allowance', 'other_income');
	//$cols = array('seq','employee_no', 'name', 'company','team');
	//var_dump($cols);
	echo PagerJson::AkoDataTableForTicking($cols, $filename, 'EMPLOYEE MASTERLIST','', sizeof($filename)); //create the table
	//echo PagerJson::ShowInFlatTable($cols, $filename, 'EMPLOYEE MASTERLIST');
	
}
?>
</div>
</form>