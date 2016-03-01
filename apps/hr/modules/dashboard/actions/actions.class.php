<?php

/**
 * dashboard actions.
 *
 * @package    snapps
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class dashboardActions extends SnappsActions
{
    /**
     * Executes index action
     *
     */
	
  public function executeEmployeeSearch()
  {
  	$user = array('melvin', 'huiping');
  	if ($this->getRequest()->getMethod() != sfRequest::POST):
  		$this->_S('status', 'A');
  	endif;
  	$c = new Criteria();
  	$c->addJoin(HrEmployeePeer::HR_COMPANY_ID, HrCompanyPeer::ID);
  	if ($this->_G('status') == 'A'):
  		$c->add(HrEmployeePeer::DATE_RESIGNED, null, Criteria::ISNULL);
  	endif;
  	$c->addAscendingOrderByColumn(HrEmployeePeer::NAME);
  	$c->add(HrEmployeePeer::CREATED_BY, $user, Criteria::IN);
  	$this->pager = 	HrEmployeePeer::doSelect($c);
  }
  
	
	public function executeRequestTicket()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST  ):
			$ticket = new HrTicketRequest();
			$ticket->setDateCreated(DateUtils::DUNow());
			$ticket->setDateModified(DateUtils::DUNow());
			$ticket->setCreatedBy($this->_U());
			$ticket->setModifiedBy($this->_U());
			$ticket->setEmployeeNo(HrEmployeePeer::GetEmployeeNoByName($this->_G('name')));
			$ticket->setName($this->_G('name'));
			$ticket->setDateEffective($this->_G('date_resigned'));
			$ticket->setDateRequested($this->_G('date_requested'));
			$ticket->setRemarks($this->_G('remark'));
			$ticket->setRequestType('RESIGNED');
			$ticket->save();
		endif;
		$c = new Criteria();
		$c->addDescendingOrderByColumn(HrTicketRequestPeer::DATE_REQUESTED);
		$this->tpager = HrTicketRequestPeer::doSelect($c);
	}
	
	public function executeAjaxResigned()
	{
		
	}
	
	
	public function executeMfgQoutaCalculator()
	{
		$quota = new QuotaLevy();
		$this->mfgQuota = $quota->GetForeignWorkersQuotaForManufacturing();
		//$this->svsQuota = $quota->GetForeignWorkersQuotaForService();
	}
	
	public function executeAjaxQuotaUpdate()
	{
		$this->com_spr = $this->_G('com_spr');
		$this->com_spass = $this->_G('com_spass');
		$this->com_wp = $this->_G('com_wp');
		$this->com_prc = $this->_G('com_prc');
		
		if ($this->_G('spr_plus_1') ):
			$this->com_spr ++;
		endif;
		if ($this->_G('spr_minus_1') ):
			$this->com_spr --;
		endif;
		
		if ($this->_G('prc_plus_1') ):
			$this->com_prc ++;
		endif;
		if ($this->_G('prc_minus_1') ):
			$this->com_prc --;
		endif;
		
		if ($this->_G('spass_plus_1') ):
			$this->com_spass ++;
		endif;
		if ($this->_G('spass_minus_1') ):
			$this->com_spass --;
		endif;
		
		if ($this->_G('wp_plus_1') ):
			$this->com_wp ++;
		endif;
		if ($this->_G('wp_minus_1') ):
			$this->com_wp --;
		endif;
	}
	
	public function executeSvsQoutaCalculator()
	{
		$quota = new QuotaLevy();
		$this->svsQuota = $quota->GetForeignWorkersQuotaForService();
	}
	
	public function executeAttendanceLog()
	{
		if ($this->getRequest()->getMethod() != sfRequest::POST )
		{
			$currentMonth = HrCurrentMonthPeer::GetCurrent();
			$this->_S('sdate', $currentMonth['start'] );
			$this->_S('edate', $currentMonth['end'] );
			//$this->companyList = HrCompanyPeer::GetCompanyList();
		}	
		$this->company = array ("Micronclean"=>"Micronclean", "Acro Solution"=>"Acro Solution",
				"NanoClean"=>"NanoClean", "T.C. Khoo"=>"T.C. Khoo" );
		$this->empList = HrEmployeePeer::GetEmployeeNameList();
		if ($this->_U() == 'meizhen'):
			$this->company = array("Acro Solution"=>"Acro Solution");
			$this->empList = array();
		endif;
		if ($this->getRequest()->getMethod() == sfRequest::POST ):
			$this->showLog = 1;
		endif;
	}
	
	public function executeAjaxWorkersList()
	{	
		$momGroup = $this->_G('momGroup');
		$rankCode = $this->_G('rankCode');
		$this->empList = HrEmployeePeer::GetListByMomGroupRankCode($momGroup, $rankCode);
		
	}

	public function executeHrLogSearch()
	{
		$c = new HrLogCriteria();
		//$c->add(HrlogPeer::USER_ACTION, 'printing', Criteria::NOT_EQUAL);
		//$c->addDescendingOrderByColumn(HrlogPeer::DATE_CREATED);
		//$c->add(HrLogPeer::ID, '&& || &&', Criteria::CUSTOM);
		//$rs= HrLogPeer::doSelect($c);
		$this->pager = HrLogPeer::GetPager($c);
	}
	
    public function executeIndex()
    {
    	$no_of_days = 90;
		$cWP = new Criteria();
		$cWP->add(HrEmployeeIcPeer::DATE_OF_EXPIRY, HrEmployeeIcPeer::DATE_OF_EXPIRY . ' between now() and date_add(now(), interval '.$no_of_days.' day)  ', Criteria::CUSTOM);
		$cWP->addDescendingOrderByColumn(HrEmployeeIcPeer::DATE_OF_EXPIRY);
		$cWP->addJoin(HrEmployeeIcPeer::EMPLOYEE_NO, PayBasicPayPeer::EMPLOYEE_NO);
		$cWP->add(PayBasicPayPeer::STATUS, 'A');
		//$cWP->add(HrEmployeeIcPeer::ID, '&& || &&', Criteria::CUSTOM);
		$this->cWPpager = HrEmployeeIcPeer::GetPager($cWP);
		
		$quota = new QuotaLevy();
		$this->mfgQuota = $quota->GetForeignWorkersQuotaForManufacturing();
		$this->svsQuota = $quota->GetForeignWorkersQuotaForService();
		
		if ($this->getRequest()->getMethod() != sfRequest::POST) :
			$this->_S('period_code', PayEmployeeLedgerArchivePeer::GetLatestPeriodCode());
		endif;
			
		$this->_S('bank_cash', 'CASH');
		//if ($this->getRequest()->getMethod() == sfRequest::POST ) :
		$pcode = $this->_G('period_code');
		$bankCash = $this->_G('bank_cash');
		$c = new Criteria();
		$c->add(PayEmployeeLedgerArchivePeer::PERIOD_CODE, $pcode);
		$c->addGroupByColumn(PayEmployeeLedgerArchivePeer::EMPLOYEE_NO);
		if ($this->_G('company')) $c->add(PayEmployeeLedgerArchivePeer::COMPANY, $this->_G('company'));
		$c->add(PayEmployeeLedgerArchivePeer::BANK_CASH, $bankCash);
		$c->addAscendingOrderByColumn(PayEmployeeLedgerArchivePeer::NAME);
		//$c->add(PayEmployeeLedgerArchivePeer::ID, '&& || && ', Criteria::CUSTOM);
		$this->pager = PayEmployeeLedgerArchivePeer::GetPager($c, 200);
		
		if ($this->_G('createPDF')):
			$empList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCash($pcode);
		
		foreach($empList as $empNo):
			$this->OfficialPayslip($pcode, $bankCash, array($empNo));
		endforeach;
		endif;
    }
    
    public function executeSingaporeanContract()
    {
		$this->ContractPDF();
    }    
    
    public function executeUnderConstruction()
    {

    }
    
    public function ContractPDF()
    {
    	$pdf    = new PdfLibrary();
		$pdf->addPage();
		$x = 15 ;
		$y = 6;
		$xpos = 1;
		
		$pdf->printTCKhooHeaderVer2();
		$pdf->printLn(    $x, $xpos++ + $y   , 'NAME: ' );
		$xpos++;
		$pdf->printLn(    $x, $xpos++ + $y   , 'ADDRESS: ' );
		$xpos++;
		$pdf->printLn(    $x, $xpos++ + $y   , 'DATE: ' );
		$xpos++;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'DURATION OF CONTRACT' );
		$duration = "
		1.1  Employment Contract is also known as Employment Agreement, Appointment Letter, Offer Letter, etc. It is an agreement between an employee and employer that specifies the terms and conditions of employment. It is advisable to have a written employment contract in Singapore. Typically, only senior management employees might have the option of negotiating their employment contracts. A violation of one or more of the terms in an employment contract by either an employee or employer is considered breach of contract. Most employment contracts include several important clauses such as: 
		";
		$pdf->MyMultiCell($x, $xpos + $y - 1, $duration, 180, 5 );
		
		
		$xpos+=8;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'JOB TITLE AND FLEXIBILITY' );
		$jobTitle = "
		2.1  You are Employed as ________ reporting to __________.
		2.2  You are expected to perform all duties which may be required of you in this role and set out in the attached 
		        job description.  You must comply with all reasonable directions given to you and observe all the policies, 
		        procedures and rules of the employer as may be introduced and/or amended from time to time.
		2.3  The employer operates a policy of job flexibility and the Employer may, at its descretion, require you to 
		        perform additional or other duties, whether skilled or unskilled, not within the scope of your normal duties 
		        and may at its discretion amend your Job Description at any time.
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $jobTitle, 180, 6 );
		
		$xpos+=11;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'PLACE OF WORK' );
		$place = "
		3.1  Your normal place of work is our Office _______________.  The employe may require you however to  work at such other locations on a temporary basis as we may from time to time require.  The employer reserves the right to relocate you on a reasonable notice to such other locations as we may from time to time require.
		3.2  You may be required to travel around Singapore in order to fulfill the duties of your employment.  If using your own car to undertake work related you are required to ensure that you have adequate insurance cover for business use.
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $place, 180, 6 );		
		
		
		$xpos+=11;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'NORMAL WORKING HOURS' );
		$hours = "
		4.1  Your working hours will be from _________ to _________ or a total of _________hrs a day plus  A _________minutes meal break. 
		4.2  You are required to work such additional hours on top of the agreed hours as may be necessary or appropriate from time to time to enable you to carry out your duties properly.  You shall not be entitled to recieve any additional remuneration for work outside your normal hours.
		4.3  The Employer reserves the right, if it reasonably requires, to increase, reduce and/or otherwise vary or alter your hours or times of work.
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $hours, 180, 6 );
		
		//---------------------------------- PAGE 2
		$pdf->addPage();
		$x = 15 ;
		$y = 3;
		$xpos = 1;
		
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'LEAVE ENTITLEMENT' );
		$leaves = "
		5.1  Probation of 3 months will have NO leave entitlement.
		
		5.2  Annual leave, Medical Leave Computation is pro-rated after probation period. 
		     (e.g. Annual Leave = #months of service / 12(months) x 7(leave) )
		     
		5.3  An employee's annual leave entitlement can be forfeited if the employee: 
		           5.3.1 Absents him/herself from work without permission or reasonable excuse for more than 20% of the 
		                     working days in a month or year, as the case may be;
			          5.3.2 Fails to take his/her leave within 12 months after the end of 12 months of continuous service; or
			          5.3.3 Is dismissed on the grounds of misconduct.
			          
		5.4  An employee covered by the Employment Act is entitled to paid sick leave, including medical leave issued 
		       by a dentist if: 
		          5.4.1 The employee has served the employer for at least three months.
			          5.4.2 The employee has informed or attempted to inform the employer of his/her absence within 48 hours.
				                   Otherwise, the employee will be deemed to be absent from work without permission or reasonable 
				                   excuse.
			          5.4.3 The sick leave is certified by the company's doctor, or by a government doctor (including doctors
			                     from approved public medical institutions)
			                     
		5.5  An employee is entitled to six days of childcare leave per year if he/she is covered under the Child \n    Development Co-Savings Act. The Child Development Co-Savings Act covers all parents of Singapore citizens,     including managerial, executive or confidential staff if all four of the following conditions are met
		          5.5.1 The child (including legally adopted children or stepchildren) is below seven years of age on or after                      31 October 2008;
			          5.5.2 The child is a Singapore Citizen; 
			          5.5.3 The child's parents are lawfully married (including divorced or widowed parents); and 
			          5.5.4 The employee has worked for the employer for at least three months.
					  
		5.6 From 1 May 2013, working parents are eligible for 2 days of extended child care leave every year if  
			          5.6.1 The child is a Singapore Citizen
			          5.6.2 The youngest child is aged 7 to 12 years (inclusive)
			          
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $leaves, 180, 6 );
		
		$xpos+=42;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'ELIGIBILITY FOR RE-EMPLOYMENT' );
		$hours = "
		6.1 Employees who are Singapore Citizens or Permanent Residents are eligible for re-employment upon reaching the age of 62, if they meet the following criterion:
		      6.1.1  are assessed by their employer to have at least a satisfactory work performance; and
		      6.1.2  are medically fit to continue working.
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $hours, 180, 6 );
		//source: http://www.mom.gov.sg/employment-practices/employment-rights-conditions/retirement/Pages/retirement.aspx
				
		
		
		
		//---------------------------------- PAGE 2
		$pdf->addPage();
		$x = 15 ;
		$y = 3;
		$xpos = 1;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'TERMINATION' );
		$termination = "
		7.1  The employer or employee who intends to terminate the contract must give notice to the other party in 
	        writing.
		7.2  The notice period to be given must be as per contractual terms agreed upon at the time of employment.
		7.3  The day on which the notice is given is included in the notice period.
		7.4  In the absence of notice period being previously agreed upon, the following shall apply:
		        7.4.1 Employment period of less than 26 weeks 1 day notice period
		        7.4.2 Employment period of 26 weeks to 2 years 1 week notice period
		        7.4.3 Employment period of 2 to 5 years 2 weeks notice period
		        7.4.4 Employment period of 5 years and above 4 weeks notice period
		7.5  The notice period can be waived upon mutual agreement between both parties.
		7.6  Employees who have fully served the required notice period, are entitled to
		7.7  Central Provident Fund (CPF) contributions for the notice period salary that they receive.

		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $termination, 180, 6 );

		$xpos+=18;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'REMUNERATION' );
		$hours = "
		8.1  You are entitled to be paid at the rate of ___________. Your salary will be paid in monthly in arrears,\n       normally on every 7th of the Month by credit Transfer.
		8.2  Your rate of pay will be reviewed regularly. Your rate of pay will not necessarily increase as a result of the \n       review.
		8.3  You are entitled to be reimbursed for all reasonable expenses properly incurred in the performance of your\n     duties in accordance with Employer's advise.  The Employer reserves the right to amend, vary or alter the \n     policy on expenses at any time.
		8.4  Salary deductions will be deducted as allowed by Employment Act. See
		www.mom.gov.sg/employment-practices/employment-rights-conditions/salary/Pages/default.aspx#deduction
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $hours, 180, 6 );
		
		
		$xpos+=13;
		$pdf->printBoldLn(    $x, $xpos++ + $y   , 'DATA PROTECTION' );
		$hours = "
		8.1  The Employer may, for the purpose of your employment, hold, use or otherwise process personal data and sensitive personal data.
		8.2  You are require to inform the Employer immediately of any changes to any personal data relating to you which the Employer may hold, use or otherwise process including your name, address and emergency contact telephone numbers.
		8.3  The Employer reserves the right to carry out the following monitoring of employees:
		      8.3.1 random personal searches of you and your personal belongings, including without limitation the \n               contents of lockers, bags, briefcases and vehicles
		          8.3.2 random drug and alcohol screening
		          8.3.3 monitoring and recording telephone calls
		          8.3.4 monitoring of email and internet use.
		          
		          Details of the monitoring undertaken by Employer will be subject to approval. 
		";
		$pdf->MyMultiCell($x, $xpos + $y -1, $hours, 180, 6 );

		
		$pdf->closePDF('testing.pdf');
		exit();
		return sfView::NONE;
    }
    
//    public function executeHiringPolicy()
//    {
//		sfConfig::set('app_page_heading', sfConfig::get('app_page_heading') . ' &raquo; Hiring Policy');
//		$this->redirect('dashboard/hiringAdd');
//    }

    public function executeWorkRight()
    {

    	if ($this->getRequest()->getMethod() == sfRequest::POST  )
    	{
    		if ($this->_G('12hoursWork')):
    			$this->hours12 = true;
    		endif;
    		if ($this->_G('12hoursTabulated')):
    			$this->hours12Tabulated = true;
    		endif;
    		if ($this->_G('employeeRecordForm')):
    			$this->employeeRecordForm = true;
    		endif;
    		if ($this->_G('employeeOTPay')):
    			$this->employeeOTPay = true;
    		endif;
    		
    		if ($this->_G('runquery')):
	    		$period = '20131101-20131130-ALL-MONTHLY';
	    		$sdt = PayEmployeeLedgerArchivePeer::GetStartDate($period);
	    		$edt = PayEmployeeLedgerArchivePeer::GetEndDate($period);
// 	    		PayComputeExtra::TopUpSingaporeanTo12($sdt, $edt);
// 	    		HrLib::ProcessAttendance($sdt, $edt);
// 	    		echo 'RUN THE DTR SUMMARY';
// 	    		exit();
	    		 
	    		// //     	PayrollAttendanceSummaryPeer::UpdateMultiplier();
	    		// //       	PayrollAttendanceSummaryPeer::UpdateComplianceOT();
	    		// //       	exit();
	    		//      	//$auditTemp = PayrollAuditCompliancePeer::GetAllData('2013');
	    		$auditTemp = PayrollAuditCompliancePeer::GetAllData('', $period); //, 'S7383424D' );
	    		//$auditTemp = PayrollAuditCompliancePeer::GetAllData();
	    		//var_dump($auditTemp);
	    		//exit();
	    		foreach($auditTemp as $audit):
	    		$period = $audit->getPeriodCode();
	    		$empno = $audit->getEmployeeNo();
	    		$name = $audit->getName();
	    		//PayrollAttendanceSummaryPeer::GetTotalComplianceOt
	    		//$complianceOtOriginalTime = $otAmount['complianceOTOriginalTime'];
	    		$otAmount = TkDtrsummaryPeer::GetTotalComplianceOt($empno, $sdt, $edt);
	    		$complianceOt = $otAmount['complianceOT'];
	    		$complianceOtPay = $otAmount['complianceOTPay'];
	    		$ratePerHour = $otAmount['ratePerHour'];
	    		$detailAudit = PayEmployeeLedgerArchivePeer::GetPayDetailAudit($empno, $period);
	    		$allowance = ( $detailAudit['ml'] + $detailAudit['mcb'] + $detailAudit['meal']);
	    		//    		$deduction = $detailAudit['ul'];
	    		echo $detailAudit['name'] . ' ' . $period ;
	    		echo ' Overtime: ' . $complianceOt . ' || ';
	    		echo ' Allowance: ' .  $allowance  . ' || ';
	    		echo ' rate/hr: ' . $ratePerHour   . ' || ';
	    		echo ' <br>';
	    		
	    		//    			$audit->setComplianceDeductionAmount( $deduction * -1 );
	    		//    			$audit->setComplianceAmount( $audit->getBasicPay() + $complianceOt + $allowance  + $deduction);
	    		//    			$audit->setOtAmount( $detailAudit['ot'] + $detailAudit['ha'] );
	    		//     		$audit->setPaidAmount( $detailAudit['tot_income'] + $detailAudit['tot_deduction'] );
	    		
	    		//     		$audit->setOtComplianceAmountOriginalTime( $complianceOtOriginalTime );
	    		//     		$audit->setComplianceAmountOriginalTime( $audit->getBasicPay() + $complianceOtOriginalTime + $allowance  + $deduction);
	    			
	    		
	    		//      		$sundays = 0;
	    			
	    		// 			$tdays = (DateUtils::DUFormat('t', $sdt));
	    		// 			for($x=0; $x< $tdays; $x++):
	    		// 				$cdate = (DateUtils::AddDate($sdt, $x));
	    		// 				//echo $cdate ;
	    		// 				if ( DateUtils::DUFormat('D', $cdate) == 'Sun'):
	    		// 					$sundays++;
	    		// 				endif;
	    		// 			endfor;
	    		// 			$totalWorkingDays = $tdays - $sundays;
	    		//     		$audit->setTotalIncome($detailAudit['basic'] + $detailAudit['ot'] + $detailAudit['ha']);
	    		$audit->setBasicPay( $detailAudit['basic'] );
	    		$audit->setOtComplianceAmount( $complianceOtPay );
	    		$audit->setAllowance( $allowance );
	    		$audit->setPostedHa($detailAudit['ha']);
	    		$audit->setPostedOt($detailAudit['ot']);
	    		$audit->setRatePerHour($ratePerHour);
	    		$audit->setTotalOtHours($complianceOt);
	    		//$audit->setMomComplianceAmount($totalWorkingDays * $audit->getRatePerHour() * 1.5);
	    		$audit->save();
	    		endforeach;
    		endif;
    	}
    }

}
