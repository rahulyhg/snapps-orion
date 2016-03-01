<?php
class hrPager
{
	public static function GetStartDate($pcode)
	{
		$dt = substr($pcode, 0, 8);
		return date('Y-m-d', mktime(1, 1, 1, strval(substr($dt, 4, 2)), strval(substr($dt, 6, 2)), strval(substr($dt, 0, 4)) ) );
	}

	public static function GetEndDate($pcode)
	{
		$dt = substr($pcode, 9, 8);
		return date('Y-m-d', mktime(1, 1, 1, strval(substr($dt, 4, 2)), strval(substr($dt, 6, 2)), strval(substr($dt, 0, 4)) ) );
	}
	
	public static function LeaveSearch($pager)
	{
		$editDel = "";
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$editUrl  = link_to('Edit', '?id='. $record->getId());
			$delUrl   = link_to('Delete', '?id='. $record->getId(),
                    	array('confirm' => 'Sure to delete this record?')); 
			$editDel = $editUrl . ' | ' . $delUrl ;
			$data[] = array(
					  'seq'=>'<small>'.$seq.'</small>'
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'leave'=> '<small>'.$record->getLeaveType().'</small>'
					, 'from'=> '<small>'.$record->getInclusiveDateFrom().'</small>'
					, 'to'=> '<small>'. $record->getInclusiveDateTo() .'</small>'
					, 'no_days'=> '<small>'. $record->getNoDays().'</small>'
					, 'is_verified'=> '<small>'. $record->getVerifiedBy().'</small>'
					, 'is_approved'=> '<small>'. $record->getApprovedBy().'</small>'
					, 'record_id'=>$record->getId()
					
			);
		endforeach;
		return $data;
	}
	
	public static function LeaveApproval($pager)
	{
		$editDel = "";
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$screenIcon =  '<div class="alignCenter"><i class="icon-screen on-right on-left bg-green"
							style="color: white;
							padding: 10px;
							border-radius: 50%"></i></div>';
			
			$pencilIcon =  '<div class="alignCenter"><i class="icon-pencil on-right on-left bg-orange"
							style="color: white;
							padding: 10px;
							border-radius: 50%"></i></div>';
			$approval = $approveUrl  = link_to($screenIcon, 'leave/leaveApplyDatePrint?id='. $record->getId());
			$verify = $approveUrl  = link_to($screenIcon, 'leave/leaveApplyDatePrintVerify?id='. $record->getId());
			$chkboxID = 'chkbox_' . $record->getId();
			$chkbox = '';
			if (! HrEmployeeLeaveSignaturePeer::IsApprovalSigned($record->getId())):
				//$chkbox = HTMLLib::CreateCheckBox($chkboxID, '');
				$approval =  link_to($pencilIcon, 'leave/leaveApplyDatePrint?id='. $record->getId());
			endif;
			if (! HrEmployeeLeaveSignaturePeer::IsVerifiedSigned($record->getId())):
				$verify =  link_to($pencilIcon, 'leave/leaveApplyDatePrintVerify?id='. $record->getId());
			endif;
			
			$data[] = array(
					  'seq'=>'<small>'.$seq.'</small>'
					, 'sign'=>'<small>'.$chkbox.'</small>'
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'leave'=> '<small>'.$record->getLeaveType().'</small>'
					, 'from'=> '<small>'.$record->getInclusiveDateFrom().'</small>'
					, 'to'=> '<small>'. $record->getInclusiveDateTo() .'</small>'
					, 'no_days'=> '<small>'. $record->getNoDays().'</small>'
					, 'is_verified'=> '<small>'. $verify.'</small>'
					, 'is_approved'=> '<small>'. $approval.'</small>'
					, 'record_id'=>$record->getId()
					
			);
		endforeach;
		return $data;
	}
	
	public static function LeaveApprovalAllEmployee($pager)
	{
		$editDel = "";
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$screenIcon =  '<div class="alignCenter"><i class="icon-screen on-right on-left bg-green"
							style="color: white;
							padding: 10px;
							border-radius: 50%"></i></div>';
			
			$pencilIcon =  '<div class="alignCenter"><i class="icon-pencil on-right on-left bg-orange"
							style="color: white;
							padding: 10px;
							border-radius: 50%"></i></div>';
			$approval = $approveUrl  = link_to($screenIcon, 'leave/leaveApplyDatePrint?id='. $record->getId());
			$verify = $approveUrl  = link_to($screenIcon, 'leave/leaveApplyDatePrintVerify?id='. $record->getId());
			$chkboxID = 'chkbox_' . $record->getId();
			$chkbox = '';
			if (! HrEmployeeLeaveSignaturePeer::IsApprovalSigned($record->getId())):
				//$chkbox = HTMLLib::CreateCheckBox($chkboxID, '');
				$approval =  link_to($pencilIcon, 'leave/leaveApplyDatePrint?id='. $record->getId());
			endif;
			if (! HrEmployeeLeaveSignaturePeer::IsVerifiedSigned($record->getId())):
				$verify =  link_to($pencilIcon, 'leave/leaveApplyDatePrintVerify?id='. $record->getId());
			endif;
			$SN = $record->getName();
			$desc = $record->getLeaveType() .' on '.  $record->getInclusiveDateFrom() .' to '. $record->getInclusiveDateTo();
			
			if ($record->getApproved() != 'OK') :
				$ajaxApprov = AjaxLib::AjaxScript('approve_' . $record->getId(), 'leave/leaveApprove', 'id=' . $record->getId() . '&cDate=' . $record->getInclusiveDateFrom(), 'DIVApprove'. $record->getId() );
				$approvLink = link_to('Approve', 'leave/leaveApprove?id=' . $record->getId() . '&cDate=' . $record->getInclusiveDateFrom(),
		                    array('confirm' =>  $alertdesc . "\nMark this as APPROVED?", 'class'=>'button success', 'id'=>'approve_' . $record->getId() ));
				
				$denyLink = link_to('deny', 'leave/leaveDeny?id=' . $record->getId(). '&cDate=' . $record->getInclusiveDateFrom(),
		                    array('confirm' => 'Record [ '.$SN.': - '.$desc . ' ]  Sure to mark Deny this record?', 'class'=>'button warning' , 'id'=>'approve_' . $record->getId() ));
			endif;	
			$deleteLink = link_to('Delete', 'leave/leaveApplyDelete?id=' . $record->getId(),
                    array('confirm' => 'Record [ '.$SN.': - '.$desc . ' ]  Sure to delete this record?')); 
			
					
			$data[] = array(
					  'seq'=>'<small>'.$seq.'</small>'
					, 'action'=>'<small>'.$deleteLink.'</small>'
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'leave'=> '<small>'.$record->getLeaveType().'</small>'
					, 'from'=> '<small>'.$record->getInclusiveDateFrom().'</small>'
					, 'to'=> '<small>'. $record->getInclusiveDateTo() .'</small>'
					, 'no_days'=> '<small>'. $record->getNoDays().'</small>'
					, 'deny'=> '<small>'. $denyLink.'</small>'
					, 'approved'=> '<small><div id="DIVApprove"'.$record->getId().'>'. $approvLink.'</div></small>'
					, 'record_id'=>$record->getId()
					
			);
		endforeach;
		return $data;
	}

	public static function SignPayslipPager($pager, $bankCash)
	{
		$editDel = "";
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$screenIcon =  '<div class="alignCenter"><i class="icon-screen on-right on-left bg-green"
							style="color: white;
							padding: 10px;
							border-radius: 50%"></i></div>';
			
			$pencilIcon =  '<div class="alignCenter"><i class="icon-pencil on-right on-left bg-orange"
							style="color: white;
							padding: 10px;
							border-radius: 50%"></i></div>';

						
			$sign = link_to($pencilIcon, 'report/individualPayslip?empno='. $record->getEmployeeNo().'&pcode=' . $record->getPeriodCode().'&bank_cash='. $bankCash, 'target="_BLANK"');
			$signature = HrEmployeePaySignaturePeer::GetDataByEmployeeNoPeriod($record->getEmployeeNo(), $record->getPeriodCode());
			if ($signature):
				if ($signature->getCashSigned()):
					$sign = link_to($screenIcon, 'report/individualPayslip?empno='. $record->getEmployeeNo().'&pcode=' . $record->getPeriodCode().'&bank_cash='. $bankCash, 'target="_BLANK"');
				endif;
			endif;

			$chkboxID = 'chkbox_' . $record->getId();
			$chkbox = '';
/*			if (! HrEmployeeLeaveSignaturePeer::IsApprovalSigned($record->getId())):
				$approval =  link_to($pencilIcon, 'leave/leaveApplyDatePrint?id='. $record->getId());
			endif;
			if (! HrEmployeeLeaveSignaturePeer::IsVerifiedSigned($record->getId())):
				$verify =  link_to($pencilIcon, 'leave/leaveApplyDatePrintVerify?id='. $record->getId());
			endif; */
			$period = $record->getPeriodCode();
			$period = DateUtils::DUFormat('M-Y', self::GetStartDate($period));
			$data[] = array(
					  'seq'=>'<small>'.$seq.'</small>'
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'company'=> '<small>'.$record->getCompany().'</small>'
					, 'period'=> '<small>'.$period.'</small>'
					, 'signed'=> '<small>'. $sign .'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}	
	
	public static function scanInPager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$team = '';
			$company = '';
			$employment = '';
			$seq ++ ;
			$dtrmaster = TkDtrmasterPeer::GetDatabyEmployeeNo($record->getEmployeeNo());
			$employeeMaster = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($record->getEmployeeNo(), array('team', 'company', 'type_of_employment'));
			if ($employeeMaster):
				$team = $employeeMaster->get('TEAM');
				$company = $employeeMaster->get('COMP_NAME');
				$employment = $employeeMaster->get('TYPE_OF_EMPLOYMENT');
			endif;
			$data[] = array(
					 'seq'=>'<span class="alignCenter"><small>'.$seq.'</span>'
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'time_in'=> '<small>'.$record->getTimeIn().'</small>'
					, 'time_out'=> '<small>'.$record->getTimeOut().'</small>'
					, 'duration'=> '<small>'.number_format($record->getDuration() / 3600, 2).'</small>'
					, 'company'=> '<small>'.$company.'</small>'
					, 'department'=> '<small></small>'
					, 'team'=> '<small>'.$team.'</small>'
					, 'employment'=> '<small>'.$employment.'</small>'
					, 'record_id'=>$record->getId()
			);

		endforeach;
		return $data;
	}
	
	public static function SearchEmployee($pager, $user=null)
	{
		$fileID = HrLib::randomID(20).'.json';
		$editDel = "";
		$data = array();
		$seq = 0; 
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
			$seq ++ ;
			$editLink = link_to('Edit', 'employee/generalInformation?id=' . $record->getId());
			$deleteLink = link_to('Delete', 'employee/employeeDelete?id=' . $record->getId(),
	                    array('confirm' => 'Record [ '. $record->getName() . ' ]  Sure to delete this record?'));
	        $actionLink = $editLink ;      
	        if ($user == 'emmanuel') $actionLink = $editLink ; //.' | ' . $deleteLink ;
	        $workid = TkDtrmasterPeer::GetWorkSchedulebyEmployeeNo($record->getEmployeeNo());
			$edit = link_to('show', 'employee/uploadEdit?id='. $record->getId());
			$editDel = $edit;
			$data[] = array(
					  'seq'=>$seq
					, 'action'=> '<small>'.$actionLink.'</small>'
					, 'employee_no'=> '<small>'.$record->getEmployeeNo() . '<small>'
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'company'=> '<small>'.HrCompanyPeer::GetNamebyId($record->getHrCompanyId()).'</small>'
					, 'account_no'=> '<small>'.$record->getAcctNo().'</small>'
					, 'joined-date'=> '<small>'.$record->getCommenceDate().'</small>'
					, 'work-schedule'=> '<small>'.substr(TkWorktemplatePeer::GetDescriptionbyWorktempNo($workid), 0 ,25).'</small>'
					, 'type'=> '<small>'.$record->getTypeOfEmployment().'</small>'
					, 'mom'=> '<small>'.$record->getMomGroup().'</small>'
					, 'race'=> '<small>'.$record->getRace().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function LeaveCreditsPager($pager)
	{
		$data = array();
		$seq = 0;
		//sfLoader::loadHelpers(array('Url', 'Text', 'Tag', 'javascript'));
		foreach ($pager as $record):
			$seq ++ ;
			$lcId = HrIndividualLeavePeer::GetDatabyEmployeeNoLeaveType($record->getEmployeeNo(), $record->getLeaveType());
			$id = $lcId? $lcId->getId() : 0;
			$lc = link_to($record->getCredits(), 'employee/individualLeaveEdit?id=' . $id .'&ltype=' . $record->getLeaveType().'&empno=' . $record->getEmployeeNo() ,
			      array('confirm' => 'Record [ '.$record->getId().': - '.$record->getLeaveType() . ' ]  Sure to Change Leave Allocation?', 'target'=>"_BLANK"), 'id="updateLeaveCredits"');
			$lBalance = $record->getCredits() - $record->getConsumed();
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'leave_type'=>'<small>'.$record->getLeaveType().'</small>'
					, 'allocation'=>'<small>'.$lc.'</small>'
					, 'consumed'=>'<small>'.$record->getConsumed().'</small>'
					, 'balance'=>'<small>'.$lBalance.'</small>'
					, 'fiscal_year'=>'<small>'.$record->getFiscalYear().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function LeaveHistory($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'leave'=>'<small>'.$record->getLeaveType().'</small>'
					, 'from'=>'<small>'.$record->getInclusiveDateFrom().'</small>'
					, 'to'=>'<small>'.$record->getInclusiveDateTo().'</small>'
					, 'no_of_days'=>'<small>'.$record->getNoDays().'</small>'
					, 'half_day'=>'<small>'.$record->getHalfDay().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function ICHistory($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'sector'=>'<small>'.$record->getSector().'</small>'
					, 'occupation'=>'<small>'.$record->getOccupation().'</small>'
					, 'pass_type'=>'<small>'.$record->getPassType().'</small>'
					, 'pass_no'=>'<small>'.$record->getPassNo().'</small>'
					, 'application'=>'<small>'.$record->getDateOfApplication().'</small>'
					, 'issued'=>'<small>'.$record->getDateOfIssue().'</small>'
					, 'expiry'=>'<small>'.$record->getDateOfExpiry().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function DocumentPager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = link_to($record->getFileName(),'employee/getDocument?id='. $record->getId() );
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'file_name'=>'<small>'.$desc.'</small>'
					, 'mime_type'=>'<small>'.$record->getMimeType().'</small>'
					, 'size'=>'<small>'.$record->getSize().'</small>'
					, 'description'=>'<small>'.$record->getDescription().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function SearchEmployeeReport($pager, $user=null)
	{
		$fileID = HrLib::randomID(20).'.json';
		$editDel = "";
		$data = array();
		$seq = 0; 
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
		$seq ++ ;
		$editLink = link_to('Edit', 'employee/generalInformation?id=' . $record->getId());
		$deleteLink = link_to('Delete', 'employee/employeeDelete?id=' . $record->getId(),
                    array('confirm' => 'Record [ '. $record->getName() . ' ]  Sure to delete this record?'));
        $actionLink = $editLink ;      
        //if ($user == 'emmanuel') $actionLink = $editLink .' | ' . $deleteLink ;
        $age = $record->getDateOfBirth() .'[ <span class="text-muted">' . DateUtils::DateDiff('yyyy', $record->getDateOfBirth(), Date('Y-m-d')) .'yrs old </span> ]';
        $workid = TkDtrmasterPeer::GetWorkSchedulebyEmployeeNo($record->getEmployeeNo());
        $payDetail = PayBasicPayPeer::GetDatabyEmployeeNo($record->getEmployeeNo());
        $basic = 0;
        $rate = 0;
        $allowance = 0;
        $paidType = '';
        $isCpf = '';
        $cpfYear = 0;
        $levy = 0;
        
        if ($payDetail):
        	$basic = $payDetail->getBasicAmount();
        	$rate  = $payDetail->getHourlyRate();
        	$allowance = $payDetail->getAllowance();
        	$paidType = $payDetail->getPaidType();
        	$isCpf = $payDetail->getCpf();
        	$cpfYear = $payDetail->getCpfCitizenship();
        	$levy = $payDetail->getLevy();
        endif;
        $erShare = PayEmployeeLedgerArchivePeer::GetLatestEmployerShare($record->getEmployeeNo());
        $fixedIncome = '';
        $fixedIncomeDetail = PayFixedIncomePeer::GetIncomeListByEmployeeNo($record->getEmployeeNo());
        foreach($fixedIncomeDetail as $incomeName => $incomeAmount):
        	$fixedIncome += $incomeAmount;
        endforeach;
        
        $joinedDate = '';
        if ($record->getCommenceDate()):
        	$joinedDate = $record->getCommenceDate() .' [ <span class="text-muted">' . number_format(DateUtils::DateDiff('m', $record->getCommenceDate(), Date('Y-m-d')) / 12, 1) .' yrs</span> ]';
        endif;
        
        $icData = HrEmployeeIcPeer::GetDataByEmployeeNo($record->getEmployeeNo());
        $passType = '';
        if ($icData):
        	$passType = $icData->getPassType();
        endif;
		$edit = link_to('show', 'employee/uploadEdit?id='. $record->getId());
		$editDel = $edit;
		$empNo = '';
		if (strtolower(substr($record->getEmployeeNo(),0,1)) == 's'):
			$empNo = $record->getEmployeeNo();
		else:
			$empNo = (string) ''.$record->getEmployeeNo() ."";
		endif;
		
			$data[] = array(
					  'seq'=>$seq
					, 'action'=> '<small>'.$actionLink.'</small>'
					, 'employee_no'=> '<small>'. $empNo . '</small>'
					, 'team'=> '<small>'.$record->getTeam() . '</small>'
					, 'cpf'=> '<small>'. $isCpf . '</small>'
					, 'cpf_year'=> '<small>'. $cpfYear . '</small>'
					, 'paid_type'=> '<small>'.$paidType . '</small>'
					, 'name'=> '<small>'.substr($record->getName(), 0, 30).'</small>'
					, 'company'=> '<small>'.HrCompanyPeer::GetNamebyId($record->getHrCompanyId()).'</small>'
					, 'account_no'=> '<small>'.$record->getAcctNo().'</small>'
					, 'joined_date'=> '<small>'.$joinedDate.'</small>'
					, 'work_schedule'=> '<small>'.substr(TkWorktemplatePeer::GetDescriptionbyWorktempNo($workid), 0 ,25).'</small>'
					, 'm_allowance'=> '<small>'.$allowance.'</small>'
					, 'basic_pay'=> '<small>'. strval($basic? $basic : $rate) .'</small>'
					, 'other_income'=> '<small>'. strval($fixedIncome) .'</small>'
					, 'race'=> '<small>'. $record->getRace() .'</small>'
					, 'age'=> '<small>'. strval($age) .'</small>'
					, 'nationality'=> '<small>'.$record->getNationality().'</small>'
					, 'cell_no'=> '<small>'.$record->getCellNo().'</small>'
					, 'mom_group'=> '<small>'.$record->getMomGroup().'</small>'
					, 'pass_type'=> '<small>'.$passType.'</small>'
					, 'gender'=> '<small>'.$record->getGender().'</small>'
					, 'dob'=> '<small>'.$record->getSinId() . DateUtils::DUFormat('dmY', $record->getDateOfBirth() )."</small>"
					, 'levy'=> '<small>'.$levy.'</small>'
					, 'employer_share'=> '<small>'.$erShare.'</small>'
					, 'fin'=> '<small>'. $record->getSinId() . '</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function DtrPager($pager)
	{
		$data = array();
		$seq = 0;
		$widt="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		foreach ($pager as $record):
			$seq ++ ;
			//$att = TkAttendancePeer::GetDaily($record->getEmployeeNo(), $record->getTransDate());
			$att = TkAttendancePeer::retrieveByPK($record->getTkAttendanceId() );
			$timeIn  = '<span class="">'.DateUtils::DUFormat('l', $record->getTransDate()) .'</span>';
			$timeOut = '<span class="">'.DateUtils::DUFormat('l', $record->getTransDate()) .'</span>';
			if ($att):
				$timeIn = $att->getTimeIn();
				$timeOut = $att->getTimeOut();
			endif;
//			echo '<pre>';
//			print_r($pager);
//			echo '</pre>';
// 			var_dump($record->getTransDate());
// 			var_dump($att->getId());
// 			exit();
			$duration = number_format($record->getDuration() / 3600, 1);
			$meal = $record->getMeal();
			$acdura = $record->getAcDura();
			$normal = $record->getNormal();
			$overtimes = $record->getOvertimes();
			$undertime = $record->getUndertime();
			$multiplier = $record->getMultiplier();
			$holiday = $record->getHolidayCode();
			$leave = $record->getLeaveType();
			$dayoff = $record->getDayoff();
			$amount = $record->getPostedAmount();
			$rate_hr = $record->getRatePerHour();
			$parttime = $record->getPartTimeIncome();
			$allowance = $record->getAllowance();
			$levy = $record->getLevy();
			$attendance = $record->getAttendance();
			$editRow = 'edit_row_' . $record->getId();
			$editAjax = AjaxLib::AjaxScript($editRow, 'dtr/editTimesheet', '', 'id='.$record->getId().'&divID='.$record->getId(), 'tr_'. $record->getId());
			$edit = '<a href="#" id="'.$editRow.'" >Edit</a>';
			//$edit .= $editAjax;			
			$meal = $record->getMeal();
			$durationLog = HTMLLib::Showlog($duration, $record->getModifiedBy(), $record->getDateModified());
			$mealInfo = TkMealSummaryPeer::GetDatabyEmployeeNo($record->getEmployeeNo(), $record->getTransDate());
			if ($mealInfo):
				$mealLog = HTMLLib::Showlog($meal, $mealInfo->getModifiedBy(), $mealInfo->getDateModified());
			else:
				$mealLog = HTMLLib::Showlog($meal, $record->getModifiedBy(), $record->getDateModified());
			endif;
			/*
			$data[] = array(
					  'seq'=>'<span class="alignCenter">'.DateUtils::DUFormat('d', $record->getTransDate()).'</span>'
					, 'action'=>''.$edit.''
					, 'name'=>''.substr($record->getName(), 0, 15).''
					, 'time_in'=>''.$timeIn.''
					, 'time_out'=>''.$timeOut.''
					, 'hrs'=>''.$duration.''
					, 'meal'=>''.$meal.''
					, 'dura'=>''.$acdura.''
					, 'req'=>'<span class="fg-darkBlue" >'.$normal.'</span>'
					, 'ot'=>''.$overtimes.''
					, 'ut'=>''.$undertime.''
					, 'mult'=>''.$multiplier.''
					, 'holiday'=>'<small class="fg-crimson" >'.$holiday.''
					, 'leave_type'=>'<small class="fg-crimson" >'.$leave.''
					, 'd-off'=>''.$dayoff.''
					, 'amount'=>''.$amount.''
					, 'rate_hr'=>''.$rate_hr.''
					, 'pt_inc'=>''.$parttime.''
					, 'm_all'=>''.$allowance.''
					, 'levy'=>''.$levy.''
					, 'att'=>''.$attendance.''
					, 'record_id'=>$record->getId()
			);
			*/

			$data[] = array(
					  'seq'=>'<span class="alignCenter"><small>'.DateUtils::DUFormat('d', $record->getTransDate()).'</small></span>'
					, 'action'=>'<small>'.$edit.'</small>'
					, 'name'=>'<small>'.$record->getName(). $editAjax .'</small>'
					, 'time_in'=>'<small>'.$timeIn.'</small>'
					, 'time_out'=>'<small>'.$timeOut.'</small>'
					, 'hrs'=>'<small>'.$durationLog.'</small>'
					, 'meal'=>'<small>'.$mealLog.'</small>'
					, 'dura'=>'<small>'.$acdura.'</small>'
					, 'req'=>'<small><span class="fg-darkBlue" >'.$normal.'</span></small>'
					, 'ot'=>'<small>'.$overtimes.'</small>'
					, 'ut'=>'<small>'.$undertime.'</small>'
					, 'mult'=>'<small>'.$multiplier.'</small>'
					, 'holiday'=>'<small class="fg-crimson" >'.$holiday.'</small>'
					, 'leave_type'=>'<small class="fg-crimson" >'.$leave.'</small>'
					, 'd-off'=>'<small>'.$dayoff.'</small>'
					, 'amount'=>'<small>'.$amount.'</small>'
					, 'rate_hr'=>'<small>'.$rate_hr.'</small>'
					, 'pt_inc'=>'<small>'.$parttime.'</small>'
					, 'm_all'=>'<small>'.$allowance.'</small>'
					, 'levy'=>'<small>'.$levy.'</small>'
					, 'att'=>'<small>'.$attendance.'</small>'
					, 'record_id'=>$record->getId()
					
			);
		endforeach;
		return $data;
	}
	
	public static function PayrollCheckListPager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			
			$hasPay = link_to('verify', 'employee/generalInformation?id=' . $record->getId());
			$cpfCheck = link_to('verify', 'employee/generalInformation?id=' . $record->getId());
						
			$empPay = PayBasicPayPeer::GetDatabyEmployeeNo($record->getEmployeeNo());
			if ($empPay) :
				if ( $empPay->getScheduledAmount() || $empPay->getHourlyRate()) :
					$hasPay = "OK";
				endif;
				if ($empPay->getCpf() == "YES"  ):
					if ( $empPay->getCpfCitizenship() && $record->getRace()) :
						$cpfCheck = "OK";
					endif;
				else:
					$cpfCheck = "OK";
				endif;
			endif;
			$workid = TkDtrmasterPeer::GetWorkSchedulebyEmployeeNo($record->getEmployeeNo());
			$momGroup = $record->getMomGroup();
			$companyName = HrCompanyPeer::GetNamebyId($record->getHrCompanyId());
			$workTemp = TkWorktemplatePeer::GetDescriptionbyWorktempNo($workid);
			if (!$workTemp):
				$workTemp = link_to('verify', 'employee/generalInformation?id=' . $record->getId());
			endif;
			
			if (!$companyName):
				$companyName = link_to('verify', 'employee/generalInformation?id=' . $record->getId());
			endif;
			
			if ( !$record->getMomGroup()):
				$momGroup = link_to('verify', 'employee/generalInformation?id=' . $record->getId());
			endif;
			if ( ! $companyName || (! $workTemp) || $hasPay != "OK" || $cpfCheck != "OK" || !  $record->getMomGroup()   ) :
				$seq ++ ;						
				$data[] = array(
						'seq'=>'<span class="alignCenter"><small>'.$seq.'</small></span>'
						, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'
						, 'name'=>'<small>'.$record->getName().'</small>'
						, 'company'=>'<small>'.HrCompanyPeer::GetNamebyId($record->getHrCompanyId()).'</small>'
						, 'birth_date'=>'<small>'.$record->getDateOfBirth().'</small>'
						, 'work_sched'=>'<small>'.$workTemp.'</small>'
						, 'has_pay'=>'<small>'.$hasPay.'</small>'
						, 'cpf_chk'=>'<small>'.$cpfCheck.'</small>'
						, 'mom_group'=>'<small>'.$momGroup.'</small>'
						, 'record_id'=>$record->getId()
					);
			endif;
		endforeach;
		return $data;
	}
	
	public static function ScheduledIncomeSearch($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$company = HrEmployeePeer::GetCompanyByEmployeeNo($record->getEmployeeNo());
			$editLink = link_to('Edit', 'payroll/scheduledIncomeEdit?id=' . $record->getId());
			$deleteLink = link_to('Delete', 'payroll/scheduledIncomeDelete?id=' . $record->getId(),
	                    array('confirm' => 'Record [ '. $record->getName() . ' ]  Sure to delete this record?'));
			
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$editLink .' | '. $deleteLink .'</small>'
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'company'=>'<small>'.$company.'</small>'
					, 'description'=>'<small>'.$record->getDescription().'</small>'
					, 'amount'=>'<small>'.number_format($record->getTotalAmount(), 2).'</small>'
					, 'from'=>'<small>'.$record->getFromDate().'</small>'
					, 'to'=>'<small>'.$record->getToDate().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function smsInbox($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$data[] = array(
					 'seq'=>'<small class="alignCenter"><small>'.$seq.'</small>'
					, 'sender'=>'<small>'.$record->getSender().'</small>'
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'message'=> '<small>'.$record->getMsg().'</small>'
					, 'sent'=> '<small>'.$record->getSenttime().'</small>'
					, 'recieved'=> '<small>'.$record->getReceivedtime().'</small>'
					, 'operator'=> '<small>'.$record->getMsg().'</small>'
					, 'type'=> '<small>'.$record->getMsgtype().'</small>'
					, 'updated'=> '<small>'.$record->getIsUpdated().'</small>'
					, 'remarks'=> '<small>'.$record->getUpdateRemark().'</small>'
					, 'record_id'=>$record->getId()
			);

		endforeach;
		return $data;
	}
	
	public static function smsPayslipSend($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$dt = PayEmployeeLedgerArchivePeer::GetStartDate($record->getPeriodCode());
			
			$paysliplink= link_to(DateUtils::DUFormat('M-Y', $dt), 'reports/payslipView?id=' . $record->getId());                    
			
			$rowID = 'gridRow_dtr_' . $record->getId();
			
			$checkBoxID = 'gridCheckBox_item_' . trim($record->getEmployeeNo());
			
			$empDet = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($record->getEmployeeNo(), array('cell_no')); 
			
			$chkbox = '';
			
			if ($empDet->get('CELL_NO')):
				$chkbox = checkbox_tag($checkBoxID, 1, true);
			endif;
			$smsLog = SmsLogPeer::GetSms($record->getEmployeeNo(), $record->getPeriodCode(), $record->getBankCash());
			if ($smsLog):
				$chkbox = DateUtils::DUFormat('Y-m-d', $smsLog->getDateCreated() );
			endif;
			$data[] = array(
					 'seq'=>'<small class="alignCenter"><small>'.$seq.'</small>'
					, 'date_send'=>'<small>'.$chkbox.'</small>'
					, 'employee_no'=> '<small>'.$record->getEmployeeNo().'</small>'
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'company'=> '<small>'.$record->getCompany().'</small>'
					, 'mobile'=> '<small>'.$empDet->get('CELL_NO').'</small>'
					, 'period'=> '<small>'.$paysliplink.'</small>'
					, 'amount'=> '<small>'.number_format(PayEmployeeLedgerArchivePeer::ComputeAmountbyEmpNoPeriodCode($record->getEmployeeNo(), $record->getPeriodCode(),  $record->getBankCash() ), 2 ).'</small>'
					, 'bank_cash'=> '<small>'.$record->getBankCash().'</small>'
					, 'record_id'=>$record->getId()
			);

		endforeach;
		return $data;
	}
	
	public static function LevyContribution($pager)
	{
		$data = array();
		$seq = 0;
		$dt = new PayComputeExtra();
		foreach ($pager as $record):
			$seq ++ ;
			$addLevy = link_to('Add/Edit Employee Levy ',  'payroll/levyListing?period_code=' . $record->getPeriodCode());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$addLevy.'</small>'  
					, 'month'=>'<small>'. DateUtils::DUFormat('F-Y', $dt->GetStartDate($record->getPeriodCode()) ).'</small>'
					, 'period_code'=>'<small>'.$record->getPeriodCode().'</small>'
					, 'from'=>'<small>'.$dt->GetStartDate($record->getPeriodCode()).'</small>'
					, 'to'=>'<small>'.$dt->GetEndDate($record->getPeriodCode()).'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		unset($dt);
		return $data;
	}
	
	public static function LevyListing($pager)
	{
		$data = array();
		$seq = 0;
		$acr = 0;
		$mcs = 0;
		$nan = 0;
		$tck = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$editLink = link_to('Edit', 'payroll/levyListingEdit?id=' . $record->getId(), ' target=_BLANK ' );
			$deleteLink = link_to('Delete', 'payroll/levyListingDelete?id=' . $record->getId() , 
			array('confirm' => 'Sure to delete this record? ' . $record->getName() ) ); 
			switch($record->getCompany()){
			    case 'Acro Solution':
			        $acr += ($record->getLevyRate() + $record->getLevyDed());
			        break;
			    case 'Micronclean':
			        $mcs += ($record->getLevyRate() + $record->getLevyDed());
			        break;
			    case 'NanoClean':
			        $nan += ($record->getLevyRate() + $record->getLevyDed());
			        break;
			    default:
			        $tck += ($record->getLevyRate() + $record->getLevyDed());
			        break;
			}
			$momGroup = '';
			$pass = '';
			$empData = HrEmployeePeer::GetDatabyEmployeeNo($record->getEmployeeNo() ); 
			if ($empData):
				$momGroup = $empData->getMomGroup();
				$pass = $empData->getRankCode();
			endif;
			$addLevy = link_to('Add/Edit Employee Levy ',  'payroll/levyListing?id=' . $record->getId() );
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$editLink . ' | ' . $deleteLink.'</small>'  
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'  
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'company'=>'<small>'.$record->getCompany().'</small>'
					, 'mom_group'=>'<small>'.$momGroup.'</small>'
					, 'period_code'=>'<small>'.DateUtils::DUFormat('F-Y', HrLib::PeriodStartDate($record->getPeriodCode()) ).'</small>'
					, 'amount'=>'<small>'.($record->getLevyRate() - $record->getLevyDed()).'</small>'
					, 'pass'=>'<small>'.$pass.'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		$data[] = array('seq'=> $seq+1,'action'=>'TOTAL',  'employee_no'=> 'Acro = '. $acr, 'name'=> 'Mcs = '.$mcs, 'company'=> 'Nano = '. $nan, 'mom_group'=>'TCK = '.$tck, 'period_code'=>'', 'amount'=>'', 'pass'=>'', 'record_id'=>'');
		return $data;
	}
	
	
	public static function Payslip($pager)
	{
		$data = array();
		$seq = 0;
		$dt = new PayComputeExtra();
		foreach ($pager as $record):
			$seq ++ ;
			$addLevy = link_to('Add/Edit Employee Pay ',  'payroll/payslipPreview?period_code=' . $record->getPeriodCode());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$addLevy.'</small>'  
					, 'month'=>'<small>'. DateUtils::DUFormat('F-Y', $dt->GetStartDate($record->getPeriodCode()) ).'</small>'
					, 'period_code'=>'<small>'.$record->getPeriodCode().'</small>'
					, 'from'=>'<small>'.$dt->GetStartDate($record->getPeriodCode()).'</small>'
					, 'to'=>'<small>'.$dt->GetEndDate($record->getPeriodCode()).'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		unset($dt);
		return $data;
	}
	
	public static function EmployeePayslip($pager)
	{
		$data = array();
		$seq = 0;
		$acr = 0;
		$mcs = 0;
		$nan = 0;
		$tck = 0;
		$race = '';
		foreach ($pager as $record):
			$seq ++ ;
			$editLink = link_to('Edit', 'payroll/levyListingEdit?id=' . $record->getId() );
			$deleteLink = link_to('Delete', 'payroll/levyListingDelete?id=' . $record->getId(),
			array('confirm' => 'Sure to delete this record? ' . $record->getName() )); 
			$momGroup = '';
			$pass = '';
			$empData = HrEmployeePeer::GetDatabyEmployeeNo($record->getEmployeeNo() ); 
			if ($empData):
				$race = $empData->getRace();
				$momGroup = $empData->getMomGroup();
				$pass = $empData->getRankCode();
			endif;
			$addLevy = link_to(' Add/Edit Employee Payslip ',  'payroll/levyListing?id=' . $record->getId());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$editLink . ' | ' . $deleteLink.'</small>'  
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'  
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'company'=>'<small>'.$record->getCompany().'</small>'
					, 'mom_group'=>'<small>'.$momGroup.'</small>'
					, 'race'=>'<small>'.$race.'</small>'
					, 'period_code'=>'<small>'.DateUtils::DUFormat('F-Y', HrLib::PeriodStartDate($record->getPeriodCode()) ).'</small>'
					, 'amount'=>'<small>'.number_format(PayEmployeeLedgerArchivePeer::ComputeAmountbyEmpNoPeriodCode($record->getEmployeeNo(), $record->getPeriodCode()), 2).'</small>'
					, 'pass'=>'<small>'.$pass.'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		//$data[] = array('seq'=> $seq+1,'action'=>'TOTAL',  'employee_no'=> 'Acro = '. $acr, 'name'=> 'Mcs = '.$mcs, 'company'=> 'Nano = '. $nan, 'mom_group'=>'TCK = '.$tck, 'period_code'=>'', 'amount'=>'', 'pass'=>'', 'record_id'=>'');
		return $data;
	}
	
	public static function EmployeeJournal($pager)
	{
		$data = array();
		$seq = 0;
		$acr = 0;
		$mcs = 0;
		$nan = 0;
		$tck = 0;
		$race = '';
		foreach ($pager as $record):
			$seq ++ ;
			$bankCheck = 0;
			$cash =0;
			$totalCpf = 0;
			$totalDeduction = 0;
			$editLink = link_to('Edit', 'payroll/payslipEntry?id=' . $record->getId(), 'target="_BLANK' );
			$deleteLink = '';//link_to('Delete', 'payroll/PayslipDelete?id=' . $record->getId(),
							 //array('confirm' => 'Sure to delete this record? ' . $record->getName() )); 
			if (HrLib::getUser() <> 'emmanuel'):
				$editLink = link_to('View', 'payroll/payslipEntry?id=' . $record->getId(), 'target="_BLANK' );
				$deleteLink = '';
			endif;
			$momGroup = '';
			$pass = '';
			$pay = 0;
			$cpf_er = 0;
			$cpf_em = 0;
			$isType = 'FW';
			$employment = '';
			$empData = HrEmployeePeer::GetDatabyEmployeeNo($record->getEmployeeNo() ); 
			if ($empData):
				$race = $empData->getRace();
				$momGroup = $empData->getMomGroup();
				$pass = $empData->getRankCode();
				$employment = $empData->getTypeOfEmployment();
			endif;
			
			$cpfData = HrLib::PopulateCpfData($record->getPeriodCode(), array($record->getEmployeeNo()), 'bank');
			$cash    = PayEmployeeLedgerArchivePeer::GetCashTotalByPeriodCodeByEmployee($record->getPeriodCode(), $record->getEmployeeNo() );
			
			if (sizeof($cpfData)):
				$bankCheck = $cpfData['grossInc'][0];
				$totalCpf = $cpfData['tot_cpf'][0];
				$cpf_er = $cpfData['er_share'][0];
				$cpf_em = $cpfData['em_share'][0];
				$totalDeduction = $cpfData['grossDed'][0];
				$pay = $cpfData['grossInc'][0] + $cpfData['grossDed'][0];
			endif;
			if ($cash > 0):
				$pay = $cpfData['grossInc'][0] + $cpfData['grossDed'][0] + $cash;
			endif;
			if ( strtolower(substr($record->getEmployeeNo(),0, 1)) == 's'):
				$isType = 'SPR';
			endif;
//			echo "<pre>";
//			print_r($cpfData);
//			echo "</pre>";
//			exit();
			$addLevy = link_to('Add/Edit Employee Payslip ',  'payroll/levyListing?id=' . $record->getId());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$editLink .'</small>'  
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'  
					, 'name'=>'<small>'.substr($record->getName(), 0, 25).'</small>'
					, 'company'=>'<small>'.$record->getCompany().'</small>'
					, 'employment'=>'<small>'.$employment.'</small>'
					, 'type'=>'<small>'.$isType.'</small>'
					, 'bank_check'=>'<small>'.number_format($bankCheck, 2).'</small>'
					, 'cash'=>'<small>'.number_format($cash, 2).'</small>'
					, 'cpf_em'=>'<small>'.number_format($cpf_em, 2).'</small>'
					, 'cpf_er'=>'<small>'.number_format($cpf_er, 2).'</small>'
					, 'deduction'=>'<small>'.number_format($totalDeduction, 2).'</small>'
					, 'pay'=>'<small>'.number_format($pay, 2).'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		//$data[] = array('seq'=> $seq+1,'action'=>'TOTAL',  'employee_no'=> 'Acro = '. $acr, 'name'=> 'Mcs = '.$mcs, 'company'=> 'Nano = '. $nan, 'mom_group'=>'TCK = '.$tck, 'period_code'=>'', 'amount'=>'', 'pass'=>'', 'record_id'=>'');
		return $data;
	}
	
	public static function IRASSubmissionPeriodList($pager)
	{
		$data = array();
		$seq = 0;
		$dt = new PayComputeExtra();
		foreach ($pager as $record):
			$seq ++ ;
			$addLevy = link_to('Show Employee Income ',  'report/irasMonthlyPreview?period_code=' . $record->getPeriodCode());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</span>'
					, 'action'=>'<small>'.$addLevy.'</small>'  
					, 'month'=>'<small>'. DateUtils::DUFormat('F-Y', $dt->GetStartDate($record->getPeriodCode()) ).'</small>'
					, 'period_code'=>'<small>'.$record->getPeriodCode().'</small>'
					, 'from'=>'<small>'.$dt->GetStartDate($record->getPeriodCode()).'</small>'
					, 'to'=>'<small>'.$dt->GetEndDate($record->getPeriodCode()).'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		unset($dt);
		return $data;
	}
	
	public static function IrasPreviewMonthly($pager)
	{
		$data = array();
		$seq = 0;
		$sinID = '';
		$name = '';
		foreach ($pager as $record):
			$seq ++ ;
			$empData = HrEmployeePeer::GetDatabyEmployeeNo($record->getEmployeeNo());
			if ($empData):
				$sinID = $empData->getSinId() ? $empData->getSinId() : $empData->getEmployeeNo();
				$name = $empData->getName();
			endif;
			$deleteLink = link_to('Delete', 'report/irasMonthlyDelete?id=' . $record->getId()
			       		,array('confirm' => 'Continue Deleting this record ('.$record->getName().') ?')
        		); 
			
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$deleteLink.'</small>'  
					, 'nric_fin'=>'<small>'.$sinID.'</small>'  
					, 'name'=>'<small>'. $name .'</small>'
					, 'company'=>'<small>'.$record->getCompany().'</small>'
					, 'gross_inc'=>'<small>'.number_format($record->getGrossInc(),2).'</small>'
					, 'gross_ded'=>'<small>'.number_format($record->getGrossDed(),2).'</small>'
					, 'net_pay'=>'<small>'.number_format(($record->getGrossInc() +  $record->getGrossDed()),2).'</small>'
					, 'cpf'=>'<small>'.number_format($record->getCpf(),2).'</small>'
					, 'donation'=>'<small>'.number_format($record->getDonation(),2).'</small>'
					, 'others'=>'<small>'.$sinID.'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function EmployeePayslipEdit($pager)
	{
		$data = array();
		$seq = 0;
		$tincome = 0;
		$bIcnomev = 0;
		$cpfIncome = 0;
		$tdeduction = 0;
		$is_cpf = false;
		$cpf_er = '';
		$cpf_er = '';
		foreach ($pager as $record):
			$seq ++ ;
			$editLink = link_to('edit', 'payroll/payslipEditableEdit?id=' . $record->getId());
			$deleteLink = link_to('delete', 'payroll/payslipEditableDelete?id=' . $record->getId()
			,array('confirm' => 'Do you want to Delete this Entry?')
			);
			$action = '';
			if ($record->getAcctCode() <> 'CPF') :
        		$action = $editLink . ' | ' . $deleteLink;
        	else:
        		$action = $deleteLink . '<br> |'. link_to('Recompute CPF','payroll/computeEmployeeCPF?empNo='.$record->getEmployeeNo() .'&pcode='. $record->getPeriodCode()
        		,array('confirm' => 'Please update the Employee Information...\nRecompute will not be based on MANUAL ENTRY.\nContinue?')
        		); 
        	endif;
			if (HrLib::GetUser() == 'emmanuel' && $record->getAcctCode() == 'CPF'):
				$action .= '<br>| '.$editLink;
			endif;
			
			$inc = 0;
			$ded = 0;
			if ($record->getIncomeExpense() == 1) 
			{
			    $inc =  $record->getAmount();
			    $ded = '';
			    $tincome = $tincome + $inc;  
			    $bIcnome = $record->getBankCash() == 'BANK';
//			    if ($record->getBankCash() <> 'CASH' && $record->getAcctCode() <> 'CBS' ):
//			    	$cpfIncome += $record->getAmount();;
//			    endif;
			}else{
			    $ded =  $record->getAmount();
			    $inc = '';
			    $tdeduction = $tdeduction + $ded;
//			    if ($record->getBankCash() && 'CASH' && $record->getAcctCode() <> 'CPF' && $record->getAcctCode() <> 'CDAC' && $record->getAcctCode() <> 'MBMF' && $record->getAcctCode() <> 'SINDA' && $record->getAcctCode() <> 'AP' && $record->getAcctCode() <> 'UL' && $record->getAcctCode() <> 'TD'):
//			    	$cpfIncome += $record->getAmount();;
//			    endif;
			}
			$grossInc = PayEmployeeLedgerArchivePeer::GetTotalIncomeforCPFDeductable($record->getEmployeeNo(), $record->getPeriodCode());
			$unpaid = PayEmployeeLedgerArchivePeer::GetTotalDeductionforCPFDeductable($record->getEmployeeNo(), $record->getPeriodCode());
			$cpfIncome = $grossInc + $unpaid;
			if ($record->getAcctCode() == 'CPF' && $is_cpf == false ):
				$empData = HrEmployeePeer::GetDatabyEmployeeNo($record->getEmployeeNo());
				$empCpf  = PayBasicPayPeer::GetDatabyEmployeeNo($record->getEmployeeNo());
				$sdate 	 = PayEmployeeLedgerArchivePeer::GetStartDate($record->getPeriodCode());
				$cpf_er = '[Cpf ER: ' . number_format($record->getCpfEr(), 2) . ']';
				$cpf_em = '[Cpf EM: ' . number_format($record->getAmount(), 2) . ']';
				$monthyearContribution= DateUtils::DUFormat('F Y', $sdate);
				$monthyearContribution= 'January 2016';
				if ($empCpf):
					$sprRate = $empCpf->getCpfCitizenship() == 3? 2: 1;
					switch ($empCpf->getCpfCitizenship() <= 2):
					case 1:
						$cpfCalculator = link_to("Online Calculator<br>" .$cpf_er .' '. $cpf_em,
						'http://orion.micronclean/cpf/below3years.php?dob='.DateUtils::DUFormat('F Y', $empData->getDateOfBirth()) .'&wage='.$cpfIncome.'&cpfyear=1&monthyearContribution=' . $monthyearContribution
								,'target="_BLANK"');
														
						break;
					case 2:
						$cpfCalculator = link_to("Online Calculator<br>" .$cpf_er .' '. $cpf_em,
						'http://orion.micronclean/cpf/below3years.php?dob='.DateUtils::DUFormat('F Y', $empData->getDateOfBirth()) .'&wage='.$cpfIncome.'&cpfyear=2&monthyearContribution=' . $monthyearContribution
								,'target="_BLANK"');
											
						break;
					default:
						$cpfCalculator = link_to("Online Calculator<br>" .$cpf_er .' '. $cpf_em,
						'https://www.cpf.gov.sg/eSvc/Web/Miscellaneous/ContributionCalculator/Index?dob='.DateUtils::DUFormat('FY', $empData->getDateOfBirth()) .'&wage='.$cpfIncome.'&monthyearContribution=' . $monthyearContribution.'&isFirstAndSecondYear=0&isMember=1'
								,'target="_BLANK"');
						//'http://orion.micronclean/cpf/index.php?dob='.DateUtils::DUFormat('F%20Y', $empData->getDateOfBirth()) .'&wage='.$cpfIncome.'&monthyearContribution=' . $monthyearContribution
								
						break;
						//'http://www.cpf.gov.sg/Scripts/Calculate.asp?PROF=&chkDis=1&Type=PrvSec&DOBMonth='.DateUtils::DUFormat('m', $empData->getDateOfBirth()).'&DOBYear_mrr='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&DOBYear='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&ContriMonth='.DateUtils::DUFormat('m', $sdate).'&ContriYear='.DateUtils::DUFormat('Y', $sdate).'&SPRYear='.$empCpf->getCpfCitizenship().'&SPRRate='.$sprRate.'&income='.$cpfIncome.'&additional=0.00&btnCalculate=Calculate'
						
					endswitch;
				endif;
			endif;
			$desc = $record->getDescription();
			if ($record->getAcctCode() == 'CPF'):
				$desc .= '<br>' . $cpfCalculator;
				//$desc .= ' CPF Er:'.$cpf_er .'| CPF Em:'. $cpf_em ;
			endif;
			if (HrLib::getUser() <> 'emmanuel'):
				$action = '';
				//$deleteLink = '';
			endif;
			$inc = ($inc == 0) ? '' : ($inc);
			$ded = ($ded == 0) ? '' : ($ded) ;
			$addLevy = link_to('Edit ',  'payroll/irasMonthlyPreview?period_code=' . $record->getPeriodCode());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$action.'</small>'  
					, 'name'=>'<small>'. $record->getName().'</small>'
					, 'acct_code'=>'<small>'.$record->getAcctCode().'</small>'
					, 'description'=>'<small>'.$desc.'</small>'
					, 'income'=>'<small>'.$inc.'</small>'
					, 'deduction'=>'<small>'.$ded.'</small>'
					, 'bank_cash'=>'<small>'.$record->getBankCash().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	
	public static function EmployeePayslipNoTags($pager)
	{
		$data = array();
		$seq = 0;
		$tincome = 0;
		$bIcnomev = 0;
		$cpfIncome = 0;
		$tdeduction = 0;
		$is_cpf = false;
		$cpf_er = '';
		$cpf_er = '';
		foreach ($pager as $record):
			$seq ++ ;			
			$inc = 0;
			$ded = 0;
			if ($record->getIncomeExpense() == 1) 
			{
			    $inc =  $record->getAmount();
			    $ded = '';
			    $tincome = $tincome + $inc;  
			    $bIcnome = $record->getBankCash() == 'BANK';
			}else{
			    $ded =  $record->getAmount();
			    $inc = '';
			    $tdeduction = $tdeduction + $ded;
			}
			$grossInc = PayEmployeeLedgerArchivePeer::GetTotalIncomeforCPFDeductable($record->getEmployeeNo(), $record->getPeriodCode());
			$unpaid = PayEmployeeLedgerArchivePeer::GetTotalDeductionforCPFDeductable($record->getEmployeeNo(), $record->getPeriodCode());
			$cpfIncome = $grossInc + $unpaid;
			$desc = $record->getDescription();
			$inc = ($inc == 0) ? '' : ($inc);
			$ded = ($ded == 0) ? '' : ($ded) ;
			$data[] = array(
					  'seq'=>$seq
					, 'name'=>$record->getName()
					, 'acct_code'=>$record->getAcctCode()
					, 'description'=>$desc
					, 'income'=>$inc
					, 'deduction'=>$ded
					, 'bank_cash'=>$record->getBankCash()
			);
		endforeach;
		return $data;
	}
	
	
	public static function LeaveCredits($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getName();
			$editLink = 'Edit';
			$deleteLink = 'Delete';
			$editLink = link_to('Edit', 'leave/leaveCreditEdit?id=' . $record->getId());
			  
			$deleteLink = link_to('Delete', 'leave/leaveCreditDelete?id=' . $record->getId(),
			                    array('confirm' => 'Delete this ( '.$desc.') record?')); 

			//$consumed = link_to($record->getConsumed(), 'leave/leaveCreditSearch', array('onclick'=>remote_function($ajaxGetLeave) . ';return false;') );
		
			$lcId = HrIndividualLeavePeer::GetDatabyEmployeeNoLeaveTypeYear($record->getEmployeeNo(), $record->getLeaveType(), $record->getFiscalYear());
			$id = $lcId? $lcId->getId() : 0;
			
			if ( $id ) {
				$lc = link_to($record->getCredits(), 'maintenance/individualLeaveEdit?id=' . $id,
			                    array('confirm' => 'Change Leave Allocation for  '.$desc.'?','target'=>'_blank'));
			}else{
				$lID = HrLeavePeer::GetIDbyLeaveType($record->getLeaveType());
				$lc = link_to($record->getCredits(), 'maintenance/individualLeaveSet?empNo='. $record->getEmployeeNo().'&leave_id=' . $lID .'&ent='.$record->getCredits(),'target=_blank' );	                    
			}
			
			$empData = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($record->getEmployeeNo(), array('commence_date'));
			$comDate = $empData? $empData->get('COMMENCE_DATE') : 'No Record';
					                    
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</span>'
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'  
					, 'name'=>'<small>'. $desc .'</small>'
					, 'join_date'=>'<small>'.$comDate.'</small>'
					, 'leave'=>'<small>'.$record->getLeaveType().'</small>'
					, 'previous_year'=>'<small>'.(intval($record->getFiscalYear()) - 1) .'</small>'
					, 'balance'=>'<small>'.$record->getPreviousBalance().'</small>'
					, 'fiscal_year'=>'<small>'.$record->getFiscalYear().'</small>'
					, 'entitled'=>'<small>'.$lc.'</small>'
					, 'consumed'=>'<small>'.$record->getConsumed().'</small>'
					, 'available'=>'<small>'.$record->getCredits() - $record->getConsumed().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function ApplyLeaveSearch($pager)
	{
		$data = array();
		$seq = 0;
		$al = 0;
		$ml = 0;
		$ul = 0;
		$hl = 0;
		$ol = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getName();
			$editLink = 'Edit';
			$deleteLink = 'Delete';
			$editLink = link_to('Edit', 'leave/leaveApplyEdit?id=' . $record->getId());
			  
			$deleteLink = link_to('Delete', 'leave/leaveApplyDelete?id=' . $record->getId(),
			                    array('confirm' => 'Sure to delete this [ '.$desc.' ]record?')); 
			
			
			$checkBoxID = 'gridCheckBox_item_' . $record->getId();
			
			if ($record->getApprovedBy() ):
				$approveLink = '<span data-hint="Date Approved |'.$record->getDateApproved().'">'. $record->getApprovedBy().'</span>';
			else:
				$approveLink = link_to('Approved', 'leave/leaveApproveIndividual?id=' . $record->getId().'&approved=true',
									array('confirm' => 'Sure to mark as APPROVED '.$record->getName().' record?')); 
			endif;
			
			if ($record->getVerifiedBy() ): 
				$verifyLink = '<span data-hint="Date Approved |'.$record->getDateVerified().'">'. $record->getVerifiedBy().'</span>';
			else:
				$verifyLink = link_to('Verified', 'leave/leaveApproveIndividual?id=' . $record->getId().'&verified=true', 
									array('confirm' => 'Sure to mark as VERIFIED '.$record->getName().' record?')); 
			endif;
			
			switch(strtolower($record->getLeaveType()))
			{
			    case 'annual leave':
			        $al += $record->getNoDays();
			        break;
			    case 'medical leave':
			        $ml += $record->getNoDays();
			        break;
			    case 'leave without pay':
			        $ul += $record->getNoDays();
			        break;
			    case 'Hospitalization Leave':
			        $hl += $record->getNoDays();
			        break;
			    case 'others(basic only)':
			        $ol += $record->getNoDays();
			        break;
			}
			
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'action'=>'<small>'. $editLink . '|' . $deleteLink .'</small>'
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'
					, 'name'=>'<small>'.$desc.'</small>'
					, 'leave'=>'<small>'.$record->getLeaveType().'</small>'
					, 'reason'=>'<small>'.$record->getReasonLeave().'</small>'
					, 'from'=>'<small>'.$record->getInclusiveDateFrom().'</small>'
					, 'to'=>'<small>'.$record->getInclusiveDateTo().'</small>'
					, 'days'=>'<small>'.$record->getNoDays().'</small>'
					, 'half_day'=>'<small>'.$record->getHalfDay().'</small>'
					, 'verified'=>'<small>'.$verifyLink.'</small>'
					, 'approved'=>'<small>'.$approveLink.'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	
	public static function NanocleanPayslip($pager)
	{
		$data = array();
		$seq = 0;
		$sinID = '';
		$name = '';
		foreach ($pager as $record):
			$seq ++ ;
			$paysliplink= link_to($record->getPeriodCode(), 'payroll/nanoPayslipEditable?id=' . $record->getId() .'&empNo='.$record->getEmployeeNo());                    
			$editLink = link_to('Details', 'payroll/nanoPayslipEditable?id=' . $record->getId().'&empNo='.$record->getEmployeeNo());
			
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$editLink.'</small>'  
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'  
					, 'name'=>'<small>'. $record->getName() .'</small>'
					, 'company'=>'<small>'.$record->getCompany().'</small>'
					, 'period'=>'<small>'.$record->getPeriodCode().'</small>'
					//, 'amount'=>'<small>'.$record->getAmount().'</small>'
					, 'amount'=>'<small>'.number_format(PayEmployeeLedgerNanoPeer::ComputeAmountbyEmpNoPeriodCode($record->getEmployeeNo(), $record->getPeriodCode()), 2 ) .'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}

	public static function NanoPayslip()
	{
		$data = array();
		$seq = 0;
		$dt = new PayComputeExtra();
		$periodList = PayEmployeeLedgerArchivePeer::GetPeriodList();
		foreach ($periodList as $pcode):
			$seq ++ ;
			$addLevy = link_to('Add/Edit Employee Pay ',  'payroll/payslipNano?period_code=' . $pcode);
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$addLevy.'</small>'  
					, 'month'=>'<small>'. DateUtils::DUFormat('F-Y', $dt->GetStartDate($pcode) ).'</small>'
					, 'period_code'=>'<small>'.$pcode.'</small>'
					, 'from'=>'<small>'.$dt->GetStartDate($pcode).'</small>'
					, 'to'=>'<small>'.$dt->GetEndDate($pcode).'</small>'
					, 'record_id'=> 0
			);
		endforeach;
		unset($dt);
		return $data;
	}
	
	public static function NanoPayslipEdit($pager)
	{
		$data = array();
		$seq = 0;
		$tincome = 0;
		$bIcnomev = 0;
		$cpfIncome = 0;
		$tdeduction = 0;
		$is_cpf = false;
		$cpf_er = '';
		$cpf_er = '';
		foreach ($pager as $record):
			$seq ++ ;
			/*
			$editLink = link_to('edit', 'payroll/payslipEditableEdit?id=' . $record->getId());
			$deleteLink = link_to('delete', 'payroll/payslipEditableDelete?id=' . $record->getId()
			,array('confirm' => 'Do you want to Delete this Entry?')
			);
			$action = '';
			if ($record->getAcctCode() <> 'CPF') :
        		$action = $editLink . ' | ' . $deleteLink;
        	else:
        		$action = $deleteLink . '<br> |'. link_to('Recompute CPF','payroll/computeEmployeeCPF?empNo='.$record->getEmployeeNo() .'&pcode='. $record->getPeriodCode()
        		,array('confirm' => 'Please update the Employee Information...\nRecompute will not be based on MANUAL ENTRY.\nContinue?')
        		); 
        	endif;
			if (HrLib::GetUser() == 'emmanuel' && $record->getAcctCode() == 'CPF'):
				$action .= '<br>| '.$editLink;
			endif;
			*/
			$editLink = '';
			$deleteLink = '';
			$action = $editLink .'|'. $deleteLink;
			$inc = 0;
			$ded = 0;
			if ($record->getIncomeExpense() == 1) 
			{
			    $inc =  $record->getAmount();
			    $ded = '';
			    $tincome = $tincome + $inc;  
			    $bIcnome = $record->getBankCash() == 'BANK';
//			    if ($record->getBankCash() <> 'CASH' && $record->getAcctCode() <> 'CBS' ):
//			    	$cpfIncome += $record->getAmount();;
//			    endif;
			}else{
			    $ded =  $record->getAmount();
			    $inc = '';
			    $tdeduction = $tdeduction + $ded;
//			    if ($record->getBankCash() && 'CASH' && $record->getAcctCode() <> 'CPF' && $record->getAcctCode() <> 'CDAC' && $record->getAcctCode() <> 'MBMF' && $record->getAcctCode() <> 'SINDA' && $record->getAcctCode() <> 'AP' && $record->getAcctCode() <> 'UL' && $record->getAcctCode() <> 'TD'):
//			    	$cpfIncome += $record->getAmount();;
//			    endif;
			}
			$grossInc = PayEmployeeLedgerArchivePeer::GetTotalIncomeforCPFDeductable($record->getEmployeeNo(), $record->getPeriodCode());
			$unpaid = PayEmployeeLedgerArchivePeer::GetTotalDeductionforCPFDeductable($record->getEmployeeNo(), $record->getPeriodCode());
			$cpfIncome = $grossInc + $unpaid;
			if ($record->getAcctCode() == 'CPF' && $is_cpf == false ):
				$empData = HrEmployeePeer::GetDatabyEmployeeNo($record->getEmployeeNo());
				$empCpf  = PayBasicPayPeer::GetDatabyEmployeeNo($record->getEmployeeNo());
				$sdate 	 = PayEmployeeLedgerArchivePeer::GetStartDate($record->getPeriodCode());
				$cpf_er = '[Cpf ER: ' . number_format($record->getCpfEr(), 2) . ']';
				$cpf_em = '[Cpf EM: ' . number_format($record->getAmount(), 2) . ']';
				if ($empCpf):
					$sprRate = $empCpf->getCpfCitizenship() == 3? 2: 1;
					switch ($empCpf->getCpfCitizenship() <= 2):
					case 1:
						$cpfCalculator = link_to("Online Calculator<br>" .$cpf_er .' '. $cpf_em,
								'http://www.cpf.gov.sg/Scripts/SPR_Calculate.asp?PROF=&chkDis=1&Type=PrvSec&DOBMonth='.DateUtils::DUFormat('m', $empData->getDateOfBirth()).'&DOBYear_mrr='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&DOBYear='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&ContriMonth='.DateUtils::DUFormat('m', $sdate).'&ContriYear='.DateUtils::DUFormat('Y', $sdate).'&SPRYear='.$empCpf->getCpfCitizenship().'&SPRRate='.$sprRate.'&income='.$cpfIncome.'&additional=0.00&btnCalculate=Calculate'
								,'target="_BLANK"');
						
						break;
					case 2:
						$cpfCalculator = link_to("Online Calculator<br>" .$cpf_er .' '. $cpf_em,
						'http://www.cpf.gov.sg/Scripts/SPR_Calculate.asp?PROF=&chkDis=1&Type=PrvSec&DOBMonth='.DateUtils::DUFormat('m', $empData->getDateOfBirth()).'&DOBYear_mrr='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&DOBYear='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&ContriMonth='.DateUtils::DUFormat('m', $sdate).'&ContriYear='.DateUtils::DUFormat('Y', $sdate).'&SPRYear='.$empCpf->getCpfCitizenship().'&SPRRate='.$sprRate.'&income='.$cpfIncome.'&additional=0.00&btnCalculate=Calculate'
								,'target="_BLANK"');
					
						break;
					default:
						$cpfCalculator = link_to("Online Calculator<br>" .$cpf_er .' '. $cpf_em,
						'http://www.cpf.gov.sg/Scripts/Calculate.asp?PROF=&chkDis=1&Type=PrvSec&DOBMonth='.DateUtils::DUFormat('m', $empData->getDateOfBirth()).'&DOBYear_mrr='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&DOBYear='.DateUtils::DUFormat('Y', $empData->getDateOfBirth()).'&ContriMonth='.DateUtils::DUFormat('m', $sdate).'&ContriYear='.DateUtils::DUFormat('Y', $sdate).'&SPRYear='.$empCpf->getCpfCitizenship().'&SPRRate='.$sprRate.'&income='.$cpfIncome.'&additional=0.00&btnCalculate=Calculate'
								,'target="_BLANK"');
					
						break;
					endswitch;
				endif;
			endif;
			$desc = $record->getDescription();
			if ($record->getAcctCode() == 'CPF'):
				$desc .= '<br>' . $cpfCalculator;
				//$desc .= ' CPF Er:'.$cpf_er .'| CPF Em:'. $cpf_em ;
			endif;
			
			$inc = ($inc == 0) ? '' : ($inc);
			$ded = ($ded == 0) ? '' : ($ded) ;
			$addLevy = link_to('Edit ',  'payroll/irasMonthlyPreview?period_code=' . $record->getPeriodCode());
			$data[] = array(
					  'seq'=>'<small class="alignCenter">'.$seq.'</small>'
					, 'action'=>'<small>'.$action.'</small>'  
					, 'name'=>'<small>'. $record->getName().'</small>'
					, 'acct_code'=>'<small>'.$record->getAcctCode().'</small>'
					, 'description'=>'<small>'.$desc.'</small>'
					, 'income'=>'<small>'.$inc.'</small>'
					, 'deduction'=>'<small>'.$ded.'</small>'
					, 'bank_cash'=>'<small>'.$record->getBankCash().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function PayHistory($pager, $id)
	{
		$fileID = HrLib::randomID(20).'.json';
		$editDel = "";
		$data = array();
		$seq = 0; 
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
			$seq ++ ;
			$payStatus = PayBasicPayPeer::GetStatus($record->getStatus());
			$isActive  = $payStatus == "ACTIVE" ? link_to('SET INACTIVE', 'employee/basicSetActive?bpid=' . $record->getId() .'&id=' . $id  ) : $payStatus; 
			$data[] = array(
					  'seq'=>$seq
					, 'action'=> '<small>'.$isActive.'</small>'
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'monthly'=> '<small>'.$record->getScheduledAmount().'</small>'
					, 'allowance'=> '<small>'.$record->getAllowance() .'</small>'
					, 'rate_hr'=> '<small>'.$record->getHourlyRate() .'</small>'
					, 'levy'=> '<small>'.$record->getLevy().'</small>'
					, 'effectivity'=> '<small>'.$record->getEffectivityDate() .'</small>'
					, 'remark'=> '<small>'.$record->getRemark() .'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function FixedIncome($pager, $id)
	{
		$fileID = HrLib::randomID(20).'.json';
		$editDel = "";
		$data = array();
		$seq = 0; 
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
			$seq ++ ;
			$data[] = array(
					  'seq'=>$seq
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'description'=> '<small>'.$record->getDescription().'</small>'
					, 'amount'=> '<small>'.$record->getScheduledAmount() .'</small>'
					, 'remark'=> '<small>'.substr($record->getRemark(),0, 20) .'</small>'
					, 'effectivity'=> '<small>'.DateUtils::DUFormat('Y-m-d',$record->getFromDate())  .'</small>'
					, 'created_by'=> '<small>'.$record->getCreatedBy() .'</small>'
					, 'date_created'=> '<small>'.$record->getDateCreated() .'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function TicketRequestPager($pager)
	{
		$editDel = "";
		$data = array();
		$seq = 0; 
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
			$seq ++ ;
			$data[] = array(
					  'seq'=>$seq
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'request_type'=> '<small>'.$record->getRequestType().'</small>'
					, 'date_effective'=> '<small>'.$record->getDateEffective() .'</small>'
					, 'remark'=> '<small>'.substr($record->getRemarks(),0, 20) .'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function HolidayPager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getHoliday();
			
			$editLink = link_to('Edit', 'maintenance/holidayEdit?id=' . $record->getId());
			  
			$deleteLink = link_to('Delete', 'maintenance/holidayDelete?id=' . $record->getId(),
			                    array('confirm' => 'Sure to delete this [ '.$desc.' ]record?')); 
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'action'=>'<small>'. $editLink .' | '. $deleteLink.'</small>'
					, 'code'=>'<small>'.$record->getHolidayCode().'</small>'
					, 'description'=>'<small>'.$desc.'</small>'
					, 'date'=>'<small>'.$record->getDateHol().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function AcctCodePager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getDescription();
			
			$editLink = link_to('Edit', 'maintenance/AcctCodeEdit?id=' . $record->getId());
			  
			$deleteLink = link_to('Delete', 'maintenance/AcctCodeDelete?id=' . $record->getId(),
			                    array('confirm' => 'Sure to delete this [ '.$desc.' ]record?')); 
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'action'=>'<small>'. $editLink .' | '. $deleteLink.'</small>'
					, 'code'=>'<small>'.$record->getAcctCode().'</small>'
					, 'description'=>'<small>'.$desc.'</small>'
					, 'remark'=>'<small>'.$record->getRemarks().'</small>'
					, 'cpf_deductable'=>'<small>'.$record->getCpf().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function FiscalYearPager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getFiscalYear();
			
			$editLink = link_to('Edit', 'maintenance/fiscalYearEdit?id=' . $record->getId());
			  
			$deleteLink = link_to('Delete', 'maintenance/fiscalYearDelete?id=' . $record->getId(),
			                    array('confirm' => 'Sure to delete this [ '.$desc.' ]record?')); 
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'action'=>'<small>'. $editLink .' | '. $deleteLink.'</small>'
					, 'fiscal_year'=>'<small>'.$desc.'</small>'
					, 'previous_year'=>'<small>'.$record->getPreviousYear().'</small>'
					, 'start_date'=>'<small>'.$record->getStartDate().'</small>'
					, 'end_date'=>'<small>'.$record->getEndDate().'</small>'
					, 'current'=>'<small>'.$record->getIsCurrent().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function WorktemplatePager($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getDescription();
			
			$editLink = link_to('Edit', 'maintenance/workTemplateEdit?id=' . $record->getId());
			  
			$deleteLink = link_to('Delete', 'maintenance/workTemplateDelete?id=' . $record->getId(),
			                    array('confirm' => 'Sure to delete this [ '.$desc.' ]record?')); 
			$data[] = array(
					 'seq'=>'<span class="alignCenter">'.$seq.'</span>'
					, 'action'=>'<small>'. $editLink .' | '. $deleteLink.'</small>'
					, 'wortktemp_no'=>'<small>'.$record->getWorktempNo().'</small>'
					, 'description'=>'<small>'.$desc.'</small>'
					, 'pattern'=>'<small>'.$record->getTemplate().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function IR8AMonthlyIncome($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
			$seq ++ ;
			$desc = $record->getName();
			
			$data[] = array(
					 'seq'=>'<span class="alignCenter"><small>'.$seq.'</span>'
					, 'employee_no'=>'<small>'.$record->getEmployeeNo().'</small>'
					, 'name'=>'<small>'.$desc.'</small>'
					, 'company'=>'<small>'.$record->getCompany().'</small>'
					, 'period'=>'<small>'.PayEmployeeLedgerArchivePeer::HumanReadablePeriod( $record->getPeriodCode() ).'</small>'
					, 'gross_income'=>'<small>'.$record->getGrossInc().'</small>'
					, 'cpf_em'=>'<small>'.( $record->getCpfEm() * -1 ).'</small>'
					, 'cpf_er'=>'<small>'.( $record->getCpfEr() * -1 ).'</small>'
					, 'cpf_total'=>'<small>'.( $record->getCpf() ).'</small>'
					, 'mbf'=>'<small>'.$record->getMbf().'</small>'
					, 'donation'=>'<small>'.$record->getDonation().'</small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function GovtCPF($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
		$seq ++ ;
		$desc = $record->getDescription();
		$editLink = link_to('Edit', 'contribution/cpfGovtRuleEdit?id=' . $record->getId());
			
		$deleteLink = link_to('Delete', 'contribution/cpfGovtRuleDelete?id=' . $record->getId(),
				array('confirm' => 'Sure to delete this [ '.$desc.' ]record?'));
		$data[] = array(
				'seq'=>'<span class="alignCenter"><small>'.$seq.'</span>'
				, 'action'=>'<small>'. $editLink .' | '. $deleteLink.'</small>'
				, 'cpf_year'=>'<small>'.$record->getCpfYear().'</small>'
				, 'description'=>'<small>'.$desc.'</small>'
				, 'company_type'=>'<small>'.$record->getCompanyType().'</small>'
				, 'age_minimum'=>'<small>'.$record->getAgeMin().'</small>'
				, 'age_maximum'=>'<small>'.$record->getAgeMax().'</small>'
				, 'net_pay_min'=>'<small>'.$record->getPayMin().'</small>'
				, 'net_pay_max'=>'<small>'.$record->getPayMax().'</small>'
				, 'cpf_batch'=>'<small>'.$record->getCpfBatch().'</small>'
				, 'record_id'=>$record->getId()
		);
		endforeach;
		return $data;
	}
	
	public static function AssocDonation($pager)
	{
		$data = array();
		$seq = 0;
		foreach ($pager as $record):
		$seq ++ ;
		$desc = PayAccountCodePeer::GetDescriptionbyAcctCode($record->getAcctCode());
		$editLink = link_to('Edit', 'contribution/cpfAssocEdit?id=' . $record->getId());
			
		$deleteLink = link_to('Delete', 'contribution/cpfAssocDelete?id=' . $record->getId(),
				array('confirm' => 'Sure to delete this [ '.$desc.' ]record?'));
		$data[] = array(
				  'seq'=>'<span class="alignCenter"><small>'.$seq.'</span>'
				, 'action'=>'<small>'. $editLink .' | '. $deleteLink.'</small>'
				, 'agency'=>'<small>'.$record->getAcctCode().'</small>'
				, 'description'=>'<small>'.$desc.'</small>'
				, 'race'=>'<small>PRIVATE SECTOR</small>'
				, 'minimum'=>'<small>'.$record->getMin().'</small>'
				, 'maximum'=>'<small>'.$record->getMax().'</small>'
				, 'amount'=>'<small>'.$record->getAmount().'</small>'
				, 'record_id'=>$record->getId()
		);
		endforeach;
		return $data;
	}
	
	public static function PayrollTrendSearchEmployee($pager, $employeeList)
	{
		$editDel = "";
		$data = array();
		$seq = 0; 
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
			$seq ++ ;
	        $workid = TkDtrmasterPeer::GetWorkSchedulebyEmployeeNo($record->getEmployeeNo());
	        $isChecked = '';
	        if (array_key_exists($record->getEmployeeNo(), $employeeList) ):
	        	$isChecked = 'checked ';
	        endif;
			$data[] = array(
					  'seq'=>$seq
					, 'employee_no'=> '<small>'.$record->getEmployeeNo() . '<small>'
					, 'name'=> '<small>'.$record->getName().'</small>'
					, 'company'=> '<small>'.HrCompanyPeer::GetNamebyId($record->getHrCompanyId()).'</small>'
					, 'account_no'=> '<small>'.$record->getAcctNo().'</small>'
					, 'team'=> '<small>'.$record->getTeam().'</small>'
					, 'joined-date'=> '<small>'.$record->getCommenceDate().'</small>'
					, 'work-schedule'=> '<small>'.substr(TkWorktemplatePeer::GetDescriptionbyWorktempNo($workid), 0 ,30).'</small>'
					, 'type'=> '<small>'.$record->getTypeOfEmployment().'</small>'
					, 'mom'=> '<small>'.$record->getMomGroup().'</small>'
					, 'resigned'=> '<small>'.$record->getDateResigned().'</small>'
					, 'pass-type'=> '<small>'.$record->getRankCode().'</small>'
					//, 'action'=> '<small>'.HTMLLib::CreateCheckBox('chk_'.$record->getEmployeeNo() , '', $isChecked ) .'</small>'
					, 'action'=> '<small><input type="checkbox" id="chk_'.$record->getEmployeeNo().'" name="chk_'.$record->getEmployeeNo().'"  '.$isChecked.' ></small>'
					, 'record_id'=>$record->getId()
			);
		endforeach;
		return $data;
	}
	
	public static function SmsMessageOut($pager, $user=null)
	{
		$fileID = HrLib::randomID(20).'.json';
		$editDel = "";
		$data = array();
		$seq = 0;
		$editLink = '';
		$deleteLink = '';
		foreach ($pager as $record):
		$seq ++ ;
		$emp = HrEmployeePeer::GetDatabyMobileNo(substr($record->getReceiver(), 3 ) ); 
		if ($emp):
			$name = $emp->getName();
		endif;
		$data[] = array(
				'seq'=>'<small>'.$seq.'</small>'
				, 'receiver'=> '<small>'.$record->getReceiver() . '<small>'
				, 'msg'=> '<small>'. $name.'<br>'.str_replace('\0x0A', '<br>', $record->getMsg()).'</small>'
				, 'senttime'=> '<small>'.$record->getSenttime().'</small>'
				, 'record_id'=>$record->getId()
		);
		endforeach;
		return $data;
	}
	
	public static function McBenefitEmployeeList($pager)
	{
		$editDel = "";
		$data = array();
		$seq = 0;
		//$SN = 1;
		foreach ($pager as $record):
			$seq ++ ;
			$checkBoxID = 'gridCheckBox_item_' . $record->getId();
			$isActive = HrEmployeeMcbenefitPeer::IsActive($record->getEmployeeNo());
			//$chkbox = checkbox_tag($checkBoxID, trim($record->getEmployeeNo()),  $isActive);
			$chkbox = HTMLLib::CreateCheckBox($checkBoxID, '', $isActive, 'span1', '', trim($record->getEmployeeNo()) ) ;//. AjaxLib::AjaxScript($checkBoxID, 'employee/ajaxMcBenefit', '$checkBoxID');
			$data[] = array(
					'seq'=>'<small>'.$seq.'</small>'
					, 'action'=>'<small>'.$chkbox. '</small>'
					, 'name'=>'<small>'.$record->getName().'</small>'
					, 'employee_no'=> '<small>'.$record->getEmployeeNo().'</small>'
					, 'company'=> '<small>'.HrCompanyPeer::GetNamebyId($record->getHrCompanyId()).'</small>'
					, 'joined-date'=> '<small>'. $record->getCommenceDate() .'</small>'
					, 'months'=> '<small>'. DateUtils::DateDiff('m', $record->getCommenceDate(), DateUtils::DUNow()).'</small>'
					, 'record_id'=>$record->getId()
						
			);
			//$SN++;
		endforeach;
		return $data;
	}
}
