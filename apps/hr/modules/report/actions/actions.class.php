<?php

/**
 * report actions.
 *
 * @package    qualityRecords
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class reportActions extends SnappsActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
  
  public function executeDummyPayslip()
  {
  	if ($this->getRequest()->getMethod() != sfRequest::POST )
  	{
  		$this->_S('cmonth', DateUtils::GetThisMonthStartDate());
  		//$this->_S('cyear', sfConfig::get('fiscal_year'));
  		$this->_S('basic_pay', 25000);
  		$this->_S('cpf_em', 925);
  		$this->_S('cpf_er', 700);
  		$this->_S('cdac', 1);
  		
  		$this->_S('employee_no', 'S1650240E');
  		$this->_S('name', 'QUEK SWEEE CHONG');
  	}
  
  	if ($this->getRequest()->getMethod() == sfRequest::POST )
  	{
  		
  		$sdate = DateUtils::DUFormat('Y-m-d', $this->_G('cmonth'));
  		$pcode = DateUtils::DUFormat('Ymd', $sdate).'-'.DateUtils::DUFormat('Ymt', $sdate).'-ALL-MONTHLY';
   		$edate = DateUtils::GetLastDate($sdate);
//   		var_dump($pcode);
//   		var_dump($sdate);
//   		var_dump($edate);
//   		exit();
  		$empNo = $this->_G('employee_no');
  		$name  = $this->_G('name');
  		$pdf = new PdfLibrary();
  		$this->UnOfficialPayslip($pcode, 'BANK', array($empNo=>$name), $this->_G('basic_pay'), $this->_G('cpf_em'), $this->_G('cpf_er'), $this->_G('cdac'), $this->_G('bonus') );
  	}
  }
  
  public function UnOfficialPayslip( $pcode, $mess, $empNoList, $dummyPay, $cpfEm, $cpfEr, $cdac, $bonus)
  {
  	$sdt = $this->GetStartDate($pcode);
  	$edt = $this->GetEndDate($pcode);
  	$pos = 0;
  	$oldno = null;
  	$gtot  = 0;
  
  	$pdf    = new PdfLibrary(array(210, 99));
  	foreach($empNoList as $empNo=>$name)
  	{
  		$summ    = TkDtrsummaryPeer::GetSummaryPerEmployeeDate($empNo, $this->GetStartDate($pcode), $this->GetEndDate($pcode) );
  		$bp      = PayBasicPayPeer::GetDatabyEmployeeNo($empNo);
  		$ot1    = 0;
  		$ot2    = 0;
  		$ot3    = 0;
  		$ot1amt = 0;
  		$ot2amt = 0;
  		$ot3amt = 0;
  		$ot1rat = 0;
  		$ot2rat = 0;
  		$ot3rat = 0;
  		$dsubtot = 0;
  		$isubtot = 0;
  
  		$cpf    = $cpfEm;
  		$cdac   = $cdac;
  		$sinda  = 0;
  		$cbs    = 0;
  		$dinner = 0;
  		$mall   = 0;
  		$basic  = 0;
  		$levy   = 0;
  		$tardy  = 0;
  		$loan   = 0;
  		$ap     = 0;
  		$ot     = array();
  		$otCode = 0;
  		$mcb = 0;
  
  
  		$tot  = 0;
  		$etot = 0;
  		$inc  = 0;
  		$ded  = 0;
  		$iother = 0;
  		$dother = 0;
  
  		$tothours = 0;
  		$mcLeave  = 0;
  		$pdLeave  = 0;
  		$updLeave = 0;
  		$subtot   = 0;

  		//$tot = $basic;   //this is to fix the monthly based on basic pay
  
  			
  		$tothours = 168;
  		$mcLeave  = 0;
  		$pdLeave  = 0;
  		$updLeave = 0;
  		$levy     = 0;
  		$iother   = 0;
  		$dother   = 0;
  			
  		$basic = $dummyPay;
  		$all   = ($tot - $dummyPay );
  			
  		if ($all > 0){
  			$mall = $all;
  		}else{
  			$dother = $all;
  		}
  		$dother = 0;
  		$inc = $basic + $mall;
  		$ded = $dother;
  			
  		$isubtot  = $basic + $ot1amt + $ot2amt + $ot3amt + $dinner + $mall + $cbs + $mcb + $bonus;
  		$dsubtot  = $tardy + $cpf + $sinda + $cdac + $levy + $loan + $ap;
  		
  		//$cpf = 540;
  		$tot = $isubtot - $dsubtot;
  			
  		
  			
  		//			var_dump($inc);
  		//			var_dump($basic);
  		//			var_dump($all);
  		//			exit();
  			
  		$pdf->addPage();
  		$x = 12;
  		$y = 1;
  		$xpos = 1;
  		setlocale(LC_MONETARY, 'en_US');
  		//$tardy= ($tot - PayEmployeeLedgerArchivePeer::GetTakeHomePay($empNo, $pcode)) * -1;
  		$ded = ($ded + $tardy) ;
  		$dsubtot = ($dsubtot + $tardy) ;
  		$pdf->printLn($x+100,    $xpos   + $y, 'Payslip for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ','Arial', '12' );
  		$pdf->printBoldLn(    $x,       $xpos++     + $y, 'ASC GYNAE ASSOCIATES PTE LTD' );
  		$pdf->printLn(    $x,       $xpos     + $y, 'Co. Reg No. 2011206164','Arial', '10');
  		//$pdf->printLn(    $x,       $xpos     + $y, $empInfo->get('COMPANY') . '(S) Pte Ltd', 'Arial', '11' );
  		$pdf->printLn(    $x+42, $xpos     + $y, 'Name: ', 'Arial', '12');
  		$pdf->printLn(    $x+57,  $xpos   + $y, $name);
  		$pdf->printLn(    $x+126,       $xpos + $y     , 'NRIC No: ' );
  		$pdf->printLn(    $x+144,    $xpos++ + $y     , $empNo );
  		$pdf->printLn(    $x, $xpos++   + $y, '========================================================================================', 'Arial', '10');
  		$pdf->printLn(    $x+158, $xpos++ + $y   , '' );
  		$y = 0;
  		$x = 30;
  		$pdf->printLn(    $x, $xpos   + $y, 'BASIC', 'Arial', '9');
  		$pdf->printBoldLn(    $x+40, $xpos   + $y, money_format('%-#5n',$basic), 'Arial', '9');
  		//			$pdf->printLn(    $x+80, $xpos   + $y, 'HOURLY', 'Arial', '9');
  		//			$pdf->printBoldLn(    $x+118, $xpos   + $y, money_format('%-#5n',($basic/24/8) ), 'Arial', '9');
			$xpos++;
			$pdf->printBoldLn(    $x, $xpos   + $y, 'OVERTIME HOURS', 'Arial', '9');
			///$pdf->printLn(    $x+40, $xpos   + $y, $tothours, 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'ABSENCES/TARDY', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n',$tardy), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'OT <1.5>             HRS', 'Arial', '9');
			$pdf->printLn(    $x+17, $xpos   + $y, $ot1, 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, '$'.$ot1rat .' = '. money_format('%-#5n',$ot1amt), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'CPF', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n',$cpf), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'OT <2.0>             HRS', 'Arial', '9');
			$pdf->printLn(    $x+17, $xpos   + $y, $ot2, 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, '$'.$ot2rat .' = '. money_format('%-#5n',$ot2amt), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'SINDA', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n',$sinda), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'OT <2.5>             HRS', 'Arial', '9');
			$pdf->printLn(    $x+17, $xpos   + $y, $ot3 , 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, '$'.$ot3rat .' = '. money_format('%-#5n',$ot3amt), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'CDAC', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n',$cdac), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'ALLOWANCES', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, money_format('%-#5n', $mall), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'UNPAID ALLOWANCE', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n', $levy), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'BONUS', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, money_format('%-#5n',$bonus), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'LOAN', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n',$loan), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'DINNER', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, money_format('%-#5n',$dinner) , 'Arial', '9'); //. " | ( ".$isubtot.")"
			$pdf->printLn(    $x+80, $xpos   + $y, 'ADVANCE PAY', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, money_format('%-#5n',$ap), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'MC BENEFIT', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, money_format('%-#5n',$mcb), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'SUB-TOTAL', 'Arial', '9');
			$pdf->printLn(    $x+125, $xpos   + $y, money_format('%-#5n',$dsubtot), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'PAID-LEAVE', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, $pdLeave.' DAY(S)', 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'UNPAID LEAVES', 'Arial', '9');
			$pdf->printLn(    $x+118, $xpos   + $y, $updLeave.' DAY(S)', 'Arial', '9');

			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'PAID-MC(S)', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, $mcLeave.' DAY(S)', 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'UNPAID ALLOWANCE', 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printLn(    $x, $xpos   + $y, 'OTHERS', 'Arial', '9');
			$pdf->printLn(    $x+40, $xpos   + $y, money_format('%-#5n',$iother), 'Arial', '9');
			$pdf->printLn(    $x+80, $xpos   + $y, 'OTHERS', 'Arial', '9');
			$pdf->printLn(    $x+120, $xpos   + $y, money_format('%-#5n',$dother), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printBoldLn(    $x+08, $xpos   + $y, 'TOTAL', 'Arial', '9');
			$pdf->printBoldLn(    $x+40, $xpos   + $y, money_format('%-#5n',$isubtot), 'Arial', '9');
			$pdf->printBoldLn(    $x+88, $xpos   + $y, 'TOTAL', 'Arial', '9');
			$pdf->printBoldLn(    $x+118, $xpos   + $y, money_format('%-#5n',$dsubtot), 'Arial', '9');
			$pdf->printLn(    $x+36, $xpos++   + $y, ':                                                                               :', 'Arial', '10');
			$pdf->printBoldLn(    $x+50, $xpos   + $y, 'TOTAL', 'Arial', '11');
			$pdf->printBoldLn(    $x+70, $xpos   + $y, money_format('%= #5.2n', $tot), 'Arial', '11');
			//$pdf->printLn( 12,     18, date('Y-m-d H:i:s'), 'Arial', '6' );
			//$pdf->footer('');
  		$gtot = $gtot + $tot;
  		//            $pdf->closePDF('testing.pdf');
  		//            return;
  	}
  	$pdf->closePDF('testing.pdf');
  
  	exit();
  	return sfView::NONE;
  
  }
  
	public function executeSignPayslip()
	{
		if ($this->getRequest()->getMethod() != sfRequest::POST) :
			$this->_S('bank_cash', 'CASH'); 
			$this->_S('period_code', PayEmployeeLedgerArchivePeer::GetLatestPeriodCode());
		endif;
			
			$pcode = $this->_G('period_code');
			$bankCash = $this->_G('bank_cash');
			$c = new Criteria();
			$c->add(PayEmployeeLedgerArchivePeer::PERIOD_CODE, $pcode);
			$c->addGroupByColumn(PayEmployeeLedgerArchivePeer::EMPLOYEE_NO);
			if ($this->_G('company')) $c->add(PayEmployeeLedgerArchivePeer::COMPANY, $this->_G('company'));
			$c->add(PayEmployeeLedgerArchivePeer::BANK_CASH, $bankCash);
			$c->addAscendingOrderByColumn(PayEmployeeLedgerArchivePeer::NAME);
			//$c->add(PayEmployeeLedgerArchivePeer::ID, '&& || && ', Criteria::CUSTOM);
			$this->pager = PayEmployeeLedgerArchivePeer::doSelect($c);
	}
  
	public function executeIndividualPayslip()
	{
		$this->pcode  = $this->_G('pcode');
		$this->mess   = $this->_G('bank_cash');
		$this->sdt    = $this->GetStartDate($this->pcode);
		$this->edt    = $this->GetEndDate($this->pcode);
		$this->empNo  = $this->_G('empno');
	}
	
	public function executeSavePayslipSignature()
	{
		$redirect = $_SERVER['HTTP_REFERER'];
		if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
        	$empno  = $this->_G('employee_no');
        	$period = $this->_G('period_code');
        	$name   = $this->_G('name');
			$data = HrEmployeePaySignaturePeer::GetDataByEmployeeNoPeriod($empno, $period);
			if (! $data):
				$data = new HrEmployeePaySignature();
				$data->setDateCreated(DateUtils::DUNow());
				$data->setCreatedBy($this->_U());
			endif;
			$data->setDateModified(DateUtils::DUNow());
			$data->setModifiedBy($this->_U());
			$data->setEmployeeNo($empno);
			$data->setName($name);
			$data->setPeriodCode($period);
			$data->setCashSigned('data:'. $this->_G('signature_data'));
			$data->setDateCashSigned(DateUtils::DUNow());
			$data->setCreatedBy($this->_U());
			$data->save();
        }
        //$this->setTemplate('index');
        $this->redirect($redirect);
	}
	
  public function GetStartDate($pcode)
  {
  	$dt = substr($pcode, 0, 8);
  	//return DateUtils::DUFormat('Y-m-d', mktime(1, 1, 1, strval(substr($dt, 4, 2)), strval(substr($dt, 6, 2)), strval(substr($dt, 0, 4)) ) );
  	return date('Y-m-d', mktime(1, 1, 1, intval(substr($dt, 4, 2)), intval(substr($dt, 6, 2)), intval(substr($dt, 0, 4)) ) );
  }
  
  public function GetEndDate($pcode)
  {
  	$dt = substr($pcode, 9, 8);
  	return date('Y-m-d', mktime(1, 1, 1, intval(substr($dt, 4, 2)), intval(substr($dt, 6, 2)), intval(substr($dt, 0, 4)) ) );
  }
  
  public function executeEmployeeDetailReport()
  {
  	$removefromList = HrEmployeePeer::RemoveFromList();
  	$c = new Criteria();
  	$c->addJoin(HrEmployeePeer::HR_COMPANY_ID, HrCompanyPeer::ID);
  	$c->addJoin(HrEmployeePeer::EMPLOYEE_NO, PayBasicPayPeer::EMPLOYEE_NO);
  	$c->add(PayBasicPayPeer::STATUS, 'A');
  	$c->add(HrEmployeePeer::DATE_RESIGNED, null, Criteria::ISNULL);
  	$c->addAscendingOrderByColumn(HrEmployeePeer::NAME);
  	$c->add(HrEmployeePeer::EMPLOYEE_NO, $removefromList, Criteria::NOT_IN);
  	if ($this->getRequest()->getMethod() !== sfRequest::POST):
  		$this->cols = array('seq', 'employee_no','name', 'company', 'team');
  		$this->_S('chk_seq', 'on');
  		$this->_S('chk_employee_no', 'on');
  		$this->_S('chk_name', 'on');
  		$this->_S('chk_company', 'on');
  		$this->_S('chk_team', 'on');
  	endif;
  	if ($this->getRequest()->getMethod() == sfRequest::POST):
  		$this->cols = array();
  		foreach($_POST as $k => $v):
  			if (substr($k, 0, 4) == 'chk_'):
  				$this->cols[] = str_replace('chk_', '', $k); 
  			endif;
  		endforeach;
  		if ($this->_G('rank_code')):
	  		switch($this->_G('rank_code')):
			  	case 'SPR':
			  		$c->add(HrEmployeePeer::EMPLOYEE_NO, 'substr('.HrEmployeePeer::EMPLOYEE_NO.', 1, 1) = "S"',Criteria::CUSTOM);
			  		$c->add(PayBasicPayPeer::CPF, 'YES');
	 		  		break;
	 		  	case 'S':
	 		  		$passList = array('PR');
	 		  		$c->add(HrEmployeePeer::EMPLOYEE_NO, 'substr('.HrEmployeePeer::EMPLOYEE_NO.', 1, 1) = "S"',Criteria::CUSTOM);
	 		  		$c->addJoin(HrEmployeeIcPeer::EMPLOYEE_NO, HrEmployeePeer::EMPLOYEE_NO);
	 		  		//$c->add(HrEmployeeIcPeer::PASS_TYPE, 'PR', Criteria::NOT_EQUAL);
	 		  		//$c->add(HrEmployeeIcPeer::DATE_OF_APPLICATION, '&& || &&', Criteria::CUSTOM);
	 		  		break;
	 		  	case 'PR':
	 		  		$c->addJoin(HrEmployeeIcPeer::EMPLOYEE_NO, HrEmployeePeer::EMPLOYEE_NO);
	 		  		$c->add(HrEmployeeIcPeer::PASS_TYPE, 'PR');
	 		  		break;
 		  		case 'FW':
 		  			$c->add(HrEmployeePeer::EMPLOYEE_NO, 'substr('.HrEmployeePeer::EMPLOYEE_NO.', 1, 1) <> "S"',Criteria::CUSTOM);
 		  			$c->addJoin(HrEmployeeIcPeer::EMPLOYEE_NO, HrEmployeePeer::EMPLOYEE_NO);
 		  			//$c->add(HrEmployeeIcPeer::PASS_TYPE, 'PR', Criteria::NOT_EQUAL);
 		  			//$c->add(HrEmployeeIcPeer::DATE_OF_APPLICATION, '&& || &&', Criteria::CUSTOM);
 		  			break;
			  	default:
			  		$c->add(HrEmployeePeer::RANK_CODE, $this->_G('rank_code'));
			endswitch;
		endif;
  		if ($this->_G('company_filter')):
  			$c->add(HrCompanyPeer::ID, $this->_G('company_filter'));
  		endif; 		
  	endif;
  	//$c->add(HrCompanyPeer::COMP_ADDRESS, '&& || &&', Criteria::CUSTOM);
  	$this->pager = 	HrEmployeePeer::doSelect($c);
//  	echo '<pre>';
//  	echo print_r($this->pager);
//  	echo '</pre>';
//  	exit();
  }
  
  public function executeEmployeeLedgerAnnual()
  {  
  		if ($this->getRequest()->getMethod() !== sfRequest::POST):
  			$this->year = HrFiscalYearPeer::GetFiscalYearListYK();
  			$this->empList = HrEmployeePeer::GetAllEmployeeList();
  		endif;
  }
  
  public function executeEmployeeAnnualIncome()
  {  
  		
  		$this->year = HrFiscalYearPeer::GetFiscalYearListYK();
  		$this->empList = HrEmployeePeer::GetAllEmployeeList();
  		$this->data = '';  	
  		if ($this->getRequest()->getMethod() != sfRequest::POST):
  			$this->_S('year', HrFiscalYearPeer::getPreviousYear());
  		endif;	
  		
  		if ($this->getRequest()->getMethod() == sfRequest::POST):
  		  	//$rows = array('BP'=>'Basic Pay', 'OT'=>'Overtime', 'ML'=>'Monthly Allowance', 'CPF' => 'CPF Employee Share', 'HA' => 'Hardship Allowance', 'MCB' => 'MC Benefit', 'OTHERS' => 'Take Home Pay');
 			$this->_S('account', 'Taxable Income');
  			if ($this->_G('name')):
  				$empData = HrEmployeePeer::GetDatabyEmployeeNo($this->_G('empno')); 
  				$empNo = $empData->getEmployeeNo();
  				$name = $empData->getName();
  				$this->empList = array($empNo=>$name);
  			else:
		  		$empNo = HrEmployeePeer::GetEmployeeNoByName($this->_G('name'));
		  		$this->empList = PayEmployeeLedgerArchivePeer::GetEmployeeListBySource('',$this->_G('year'), $this->_G('source'));
		  	endif;
		  	$periodList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($this->_G('year'));
		  	$data = array();

		  	foreach($periodList as $period):
	  			foreach($this->empList as $empNo=>$name):
	  				if ($this->_G('account') == 'Taxable Income' ):
		  				$taxableAmount = PayEmployeeLedgerArchivePeer::GetIncomeBySource($empNo, $period, $this->_G('source'));
			  			if (!isset($data[$name][$period][$this->_G('account')])):
			  				$data[$name][$period][$this->_G('account')] = 0;
			  			endif;
		  				$data[$name][$period][$this->_G('account')] += $taxableAmount;
		  			endif;
					endforeach;
		  	endforeach;
//		  	$this->var_dump($data);
//		  	exit();
		  	$this->data = $data;
		  	$this->periodList = $periodList;
		endif;
  }
  
  public function executeShowLedgerAnnual()
  {
  	$rows = array('BP'=>'Basic Pay', 'OT'=>'Overtime', 'ML'=>'Monthly Allowance', 'CPF' => 'CPF Employee Share', 'HA' => 'Hardship Allowance', 'MCB' => 'MC Benefit', 'OTHERS' => 'Take Home Pay');
  	$empNo = HrEmployeePeer::GetEmployeeNoByName($this->_G('name'));
  	$periodList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($this->_G('year'));
  	$data = array();
  	foreach($periodList as $period):
  			$takeHome = 0;
  			$empledger = PayEmployeeLedgerArchivePeer::GetDataByEmployeePeriodCode($empNo, $period);
  			foreach($empledger as $r):
  				foreach($rows as $row => $anything):
		  			if (!isset($data[$period][$row])):
		  				$data[$period][$row] = 0;
		  			endif;
	  				if ($row == $r->getAcctCode()):
	  					$data[$period][$row] += $r->getAmount();
	  				endif;
	  			endforeach;
	  			if ($r->getAcctCode() == 'PI'):
	  				$data[$period]['BP'] += $r->getAmount();
	  			endif;
    			if ($r->getAcctCode() == 'VA'):
  					//echo $r->getPeriodCode() .' ] '.$r->getAcctCode() .' : ' . $r->getAmount() .'<br>';
  					$data[$period]['OT'] += $r->getAmount();
  				endif;
	  			//echo $r->getPeriodCode() .' ] ' . $r->getAcctCode() . '<br>';
  				$takeHome += $r->getAmount();
  			endforeach;
  			$data[$period]['OTHERS'] = $takeHome; 
  	endforeach;
//  	$this->var_dump($data);
//  	exit();
  	$this->data = $data;
  	$this->rows = $rows;
  	$this->periodList = $periodList;
  }
  
	public function executePrintCpfContribution()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST )
		{
			if ( $this->_G('cpf') )
			{
				$this->PreviewContribution($this->_G('period_code'), $this->_G('company'), $this->_G('source'), $this->_G('penalty_interest'), $this->_G('mom_group'));
			}

			if ( $this->_G('cpfnet') )
			{
				$this->PreviewNetContribution($this->_G('period_code'), $this->_G('company'), $this->_G('source'));
			}

			if ( $this->_G('cpftemp') )
			{
				$this->PreviewCpfContribution($this->_G('period_code'), $this->_G('company'), $this->_G('source'));
			}

			if ( $this->_G('cpfdata') )
			{
				$this->PreviewCpfData($this->_G('period_code'), $this->_G('penalty_interest'), $this->_G('mom_group'));
				//$this->PreviewCpfDataBefore2009($this->_G('period_code'), $this->_G('penalty_interest'), $this->_G('rmonth'));
			}
			
			if ( $this->_G('cpfmanual') )
			{
				$this->EmployeeMasterlistCPFPDF($this->_G('period_code'), $this->_G('mom_group'), $this->_G('company'), $this->_G('worksched'), $this->_G('team'), $this->_G('race') );
			}


			return sfView::NONE;
		}

	}
	
	
	public function PreviewContribution($batch, $company, $mess, $penalty=null, $momGroup)
	{
		if ($mess <> 'CASH')
		{
			$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankChequeForLevy($batch,'', $momGroup);
		}
		$empData = HrLib::PopulateCpfData($batch, $empNoList, $mess);
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);
		$pdf = new PdfLibrary();

		$gacro = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gmcs  = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gnano = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gtc   = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gaddlvy = 0;
		$pos = 0;
		//--------------- donor
		$dcda = 0;
		$dsin = 0;
		$dmbm = 0;
		$dsdl = 0;
		$decf = 0;
//		var_dump($empData['company']);
//		echo '<br>';
//		var_dump($empData['mom_group']);
//		exit();
		foreach ($empData['mom_group'] as $kemp=>$vno)
		{
			if ($empData['tot_cpf'][$pos] <> 0 ||
			$empData['mbmf'][$pos]    ||
			$empData['sinda'][$pos]   ||
			$empData['ecf'][$pos]     ||
			$empData['cdac'][$pos]    )
			{
				switch($vno)
				{
					case 'Acro Solution':
						$gacro['count']++;
						$gacro['wages'] = $gacro['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gacro['em_share'] = $gacro['em_share'] + $empData['em_share'][$pos];
						$gacro['cdac'] = $gacro['cdac'] + $empData['cdac'][$pos];
						$gacro['sinda'] = $gacro['sinda'] + $empData['sinda'][$pos];
						$gacro['mbmf'] = $gacro['mbmf'] + $empData['mbmf'][$pos];
						$gacro['sdl'] = $gacro['sdl'] + $empData['sdl'][$pos];
						$gacro['ecf'] = $gacro['ecf'] + $empData['ecf'][$pos];
						$gacro['er_share'] = $gacro['er_share'] + $empData['er_share'][$pos];
						$gacro['total'] = $gacro['em_share'] +  $gacro['cdac'] + $gacro['sinda'] + $gacro['mbmf'] + $gacro['sdl']+ $gacro['er_share'] + $gacro['ecf'];
						break;
					case 'Micronclean':
						$gmcs['count']++;
						$gmcs['wages'] = $gmcs['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gmcs['em_share'] = $gmcs['em_share'] + $empData['em_share'][$pos];
						$gmcs['cdac'] = $gmcs['cdac'] + $empData['cdac'][$pos];
						$gmcs['sinda'] = $gmcs['sinda'] + $empData['sinda'][$pos];
						$gmcs['mbmf'] = $gmcs['mbmf'] + $empData['mbmf'][$pos];
						$gmcs['sdl'] = $gmcs['sdl'] + $empData['sdl'][$pos];
						$gmcs['ecf'] = $gmcs['ecf'] + $empData['ecf'][$pos];
						$gmcs['er_share'] = $gmcs['er_share'] + $empData['er_share'][$pos];
						$gmcs['total'] = $gmcs['em_share'] +  $gmcs['cdac'] + $gmcs['sinda'] + $gmcs['mbmf'] + $gmcs['sdl']+ $gmcs['er_share']+ $gmcs['ecf'];
						break;
					case 'NanoClean':
						$gnano['count']++;
						$gnano['wages'] = $gnano['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gnano['em_share'] = $gnano['em_share'] + $empData['em_share'][$pos];
						$gnano['cdac'] = $gnano['cdac'] + $empData['cdac'][$pos];
						$gnano['sinda'] = $gnano['sinda'] + $empData['sinda'][$pos];
						$gnano['mbmf'] = $gnano['mbmf'] + $empData['mbmf'][$pos];
						$gnano['sdl'] = $gnano['sdl'] + $empData['sdl'][$pos];
						$gnano['ecf'] = $gnano['ecf'] + $empData['ecf'][$pos];
						$gnano['er_share'] = $gnano['er_share'] + $empData['er_share'][$pos];
						$gnano['total'] = $gnano['em_share'] +  $gnano['cdac'] + $gnano['sinda'] + $gnano['mbmf'] + $gnano['sdl']+ $gnano['er_share'] + $gnano['ecf'];
						break;
					case $momGroup:
						$gtc['count']++;
						$gtc['wages'] = $gtc['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gtc['em_share'] = $gtc['em_share'] + $empData['em_share'][$pos];
						$gtc['cdac'] = $gtc['cdac'] + $empData['cdac'][$pos];
						$gtc['sinda'] = $gtc['sinda'] + $empData['sinda'][$pos];
						$gtc['mbmf'] = $gtc['mbmf'] + $empData['mbmf'][$pos];
						$gtc['sdl'] = $gtc['sdl'] + $empData['sdl'][$pos];
						$gtc['ecf'] = $gtc['ecf'] + $empData['ecf'][$pos];
						$gtc['er_share'] = $gtc['er_share'] + $empData['er_share'][$pos];
						$gtc['total'] = $gtc['em_share'] +  $gtc['cdac'] + $gtc['sinda'] + $gtc['mbmf'] + $gtc['sdl']+ $gtc['er_share'] + $gtc['ecf'];
						break;
				}
				$dcda = $dcda + (($empData['cdac'][$pos])  ? 1 : 0 );
				$dmbm = $dmbm + (($empData['mbmf'][$pos])  ? 1 : 0 );
				$dsdl = $dsdl + (($empData['sdl'][$pos])   ? 1 : 0 );
				$dsin = $dsin + (($empData['sinda'][$pos]) ? 1 : 0 );
				$decf = $decf + (($empData['ecf'][$pos])   ? 1 : 0 );

				//echo $empData['empno'][$pos] .' - '. $empData['name'][$pos] .' - '. $vno . '<br>';
			}

			//-------------------------- levy
			if ($empData['islevy'][$pos])
			{
				$gaddlvy = $gaddlvy + ($empData['sdl'][$pos]);
				
			}
			$pos++;

		}
		//$gaddlvy = 420;
		//--------------- front page summary
		$fgwage = $gacro['wages'] + $gmcs['wages'] + $gnano['wages'] + $gtc['wages'];
		$fgem   = $gacro['em_share'] + $gmcs['em_share'] + $gnano['em_share'] + $gtc['em_share'];
		$fgcd   = $gacro['cdac'] + $gmcs['cdac'] + $gnano['cdac'] + $gtc['cdac'];
		$fgsi   = $gacro['sinda'] + $gmcs['sinda'] + $gnano['sinda'] + $gtc['sinda'];
		$fgmb   = $gacro['mbmf'] + $gmcs['mbmf'] + $gnano['mbmf'] + $gtc['mbmf'];
		$fgsd   = intval($gacro['sdl'] + $gmcs['sdl'] + $gnano['sdl'] + $gtc['sdl']);
		$fger   = $gacro['er_share'] + $gmcs['er_share'] + $gnano['er_share'] + $gtc['er_share'];
		$ecf    = $gacro['ecf'] + $gmcs['ecf'] + $gnano['ecf'] + $gtc['ecf'];
		$fgto   = $fgem + $fgcd + $fgsi + $fgmb + $fgsd + $fger + $ecf;
		$gaddlvy = intval($gaddlvy);
		$pdf->addPage('Arial', 10, 'L');
		$pdf->printTCKhooHeader();
		setlocale(LC_MONETARY, 'en_US');
		$y = 5;
		$x = 13;
		$xpos = 0;

		$pdf->printBoldLn( $x,    $xpos++   + $y, 'PAYROLL :  CPF CONTRIBUTION ( ' . $momGroup . ' )', 'Arial', 10);
		//$pdf->printLn( $x,        $xpos   + $y, 'T.C. KHOO & CO. (PTE) LTD.');
		$y+=2;
		$pdf->printBoldLn( $x+100,    $xpos++ + $y, 'Payroll Period: '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt), 'Arial', 12);
		$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                            COMPANY                                 #EMP             SUBCON         EE-SHARE           CDAC          SINDA         MBMF            SDL          ER-SHARE       TOTAL', 'Arial', 10);
		//$pdf->printLn( $x,    $xpos++   + $y, '                            COMPANY                                 #EMP       RENUMERATION   EE-SHARE           CDAC          SINDA         MBMF            SDL          ER-SHARE       TOTAL', 'Arial', 10);		
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$seq = 1;
		$pdf->printLn( $x+20, $xpos      + $y, strtoupper($momGroup), 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, $gtc['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y, money_format('%(#8n', $gtc['wages'] ), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $gtc['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $gtc['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $gtc['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $gtc['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $gtc['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $gtc['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $gtc['total']), 'Arial', 10) ;
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');

		$pdf->printLn( $x+80, $xpos      + $y, $gacro['count'] + $gmcs['count'] + $gnano['count'] + $gtc['count'] , 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y,  money_format('%(#8n', $fgwage), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $fgem), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $fgcd), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $fgsi), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $fgmb), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $fgsd), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $fger), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $fgto), 'Arial', 10) ;

		setlocale(LC_MONETARY, 'en_US');
		$xpos+=3;
		$penalty = $penalty? $penalty : 0.0;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total CPF Contributions', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++    + $y,  money_format('%(#8n', ($fgem + $fger)), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'CPF Late Payment Interest', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', $penalty), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Foreign Worker Levy', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', 0.0), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'FWL Late Payment Interest', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', 0.0), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Skills Development Levy (SDL)                               +                              = ', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgsd) , 'Arial', 10) ;
		$pdf->printLn( $x+135,$xpos       + $y, money_format('%(#8n', $gaddlvy) , 'Arial', 10) ;
		$pdf->printBoldLn( $x+170,$xpos++     + $y, money_format('%(#8n', $fgsd + $gaddlvy), 'Arial', 10) ;
//		if ($momGroup == 'T.C. Khoo Mfg'):
//			$gaddlvy = $gaddlvy + 13;
//			$pdf->printBoldLn( $x+170,$xpos++     + $y, money_format('%(#8n', $fgsd + $gaddlvy) . '   +  ( $13 jun month )', 'Arial', 10) ;
//		else:
//			$pdf->printBoldLn( $x+170,$xpos++     + $y, money_format('%(#8n', $fgsd + $gaddlvy), 'Arial', 10) ;
//		endif;
		$pdf->printLn( $x+50, $xpos       + $y, 'Donation to Community                                                      Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', 0.0), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, 0, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total MBMF Contributions                                                  Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgmb), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $dmbm, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total SINDA Contributions                                                  Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgsi), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $dsin, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total CDAC Contributions                                                   Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgcd), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $dcda, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total ECF Contributions                                                      Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $ecf), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $decf, 'Arial', 10) ;
		$pdf->printBoldLn( $x+50, $xpos       + $y, 'Grand Total', 'Arial', 10) ;
		$pdf->printBoldLn( $x+105,$xpos++     + $y, money_format('%(#8n', $fgto + $gaddlvy + $penalty), 'Arial', 10) ;


		$pdf->Footer();
		

		//----------------------------------------- print cpf contribution
		$gross = 0;
		$gwage = 0;
		$gemsh = 0;
		$gcdac = 0;
		$gsinda= 0;
		$gmbmf = 0;
		$gsdl  = 0;
		$gersh = 0;

		$xpos =  0;
		$pos = 0;
		$cntr = 0;
		$gbank  = 0;
		$gcash  = 0;
		$gdinner= 0;
		$seq = 1;
		foreach ($empData['mom_group'] as $kemp=>$vno)
		{
			if ($xpos >= 38 || $xpos == 0)
			{
				$pdf->addPage('Arial', 10, 'L');
				//$pdf->printTCKhooHeader();
				$x = 13;
				$y = 2;
				$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
				$xpos = 0;
				$pdf->printBoldLn( $x,    $xpos++   + $y, ' - CPF Contribution ( ' . $momGroup . ' )', 'Arial', 10);
				$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
				$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
				$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME                              COMPANY                  SUBCON         EE-SHARE           CDAC          SINDA         MBMF            SDL          ER-SHARE    TOTAL', 'Arial', 10);
				$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
			}
//			echo $cComp .' - '. $rec . '<br>';
//			exit();
			
			if ( true ) //($cComp == $rec) )
			{
				if ($empData['tot_cpf'][$pos] <> 0  ||
				$empData['mbmf'][$pos]    ||
				$empData['sinda'][$pos]   ||
				$empData['cdac'][$pos]    )
				{
					//Kebot
					//$pdf->printLn ($x, $xpos + $y, $pos+1 .'. '. $empData['name'][$pos] .'  wages: '. $empData['wages'][$pos] .'  salary: '. $empData['salary'][$pos] .' = '. ($empData['wages'][$pos] + $empData['salary'][$pos]) );
					//$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
					if ($seq % 2):
						$bgcolor = array(255,255,255);
					else:
						$bgcolor = array(235,235,235);
					endif;
					//------------ those who took cash... who left the company early
					//$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
					$pdf->printLnBox( $x,      $xpos   + $y, $seq++.'.', 275, $bgcolor, 'Arial', 10 );
					
					$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 38) );
					$pdf->printLn( $x+70,   $xpos   + $y, $empData['mom_group'][$pos] );
					$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $empData['wage'][$pos] + $empData['additional'][$pos]));
					$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $empData['em_share'][$pos]));
					$pdf->printLn( $x+150,  $xpos   + $y, money_format('%(#6n', $empData['cdac'][$pos]) );
					$pdf->printLn( $x+170,  $xpos   + $y, money_format('%(#6n', $empData['sinda'][$pos]) );
					$pdf->printLn( $x+190,  $xpos   + $y, money_format('%(#6n', $empData['mbmf'][$pos]) );
					$pdf->printLn( $x+210,  $xpos    + $y, money_format('%(#6n',$empData['sdl'][$pos] ) );
					$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos]));
					$pdf->printLn( $x+250,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos] + $empData['cdac'][$pos] + $empData['sinda'][$pos] + $empData['mbmf'][$pos] + $empData['em_share'][$pos] + $empData['sdl'][$pos]));
					$xpos ++;

					$gwage = $gwage +  $empData['wage'][$pos] + $empData['additional'][$pos];
					$gemsh = $gemsh +  $empData['em_share'][$pos];
					$gcdac = $gcdac +  $empData['cdac'][$pos];
					$gsinda= $gsinda + $empData['sinda'][$pos];
					$gmbmf = $gmbmf  + $empData['mbmf'][$pos];
					$gsdl  = $gsdl   + $empData['sdl'][$pos];
					$gersh = $gersh  + $empData['er_share'][$pos];

					$gross = $gemsh + $gcdac + $gsinda + $gmbmf + $gsdl + $gersh;
				}
			}
			$pos++;
		}

		$pdf->printLn( $x,     $xpos++   + $y, '****************************************************************************************************************************************************************************************************' );
		$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $gwage));
		$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $gemsh));
		$pdf->printLn( $x+150,  $xpos   + $y, money_format('%(#6n', $gcdac) );
		$pdf->printLn( $x+170,  $xpos   + $y, money_format('%(#6n', $gsinda) );
		$pdf->printLn( $x+190,  $xpos   + $y, money_format('%(#6n', $gmbmf) );
		//$pdf->printLn( $x+210,  $xpos    + $y, '$  '.$xsdl); //money_format('%(#6n',$xsdl ) );
		$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $gersh));
		$pdf->printLn( $x+250,  $xpos + $y, money_format('%(#6n', $gross));
		$pdf->printLn( $x+210,  $xpos++    + $y, money_format('%(#6n',$gsdl ) );
		


//		foreach ($empData['mom_group'] as $kemp=>$vno)
//		{
			$gross = 0;
			$gwage = 0;
			$gemsh = 0;
			$gcdac = 0;
			$gsinda= 0;
			$gmbmf = 0;
			$gsdl  = 0;
			$gersh = 0;

			$xpos =  0;
			$pos = 0;
			$cntr = 0;
			$gbank  = 0;
			$gcash  = 0;
			$gdinner= 0;
			$seq = 1;
			foreach ($empData['mom_group'] as $kemp=>$vno)
			{
				$tempWage = 0;
				$tempSdl  = 0;
				if ($xpos >= 55 || $xpos == 0)
				{
					$pdf->addPage('Arial', 10);
					//$pdf->printTCKhooHeader();
					//kebot
					$x = 13;
					$y = 2;
					$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
					$xpos = 0;
					$pdf->printBoldLn( $x,    $xpos++   + $y, ' - SDL Contribution ( ' . $momGroup . ' )', 'Arial', 10);
					$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
					$pdf->printLn( $x,       $xpos++   + $y, '========================================================================================');
					$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME                              COMPANY                  WAGES           				SDL', 'Arial', 10);
					$pdf->printLn( $x,       $xpos++   + $y, '========================================================================================' );
				}
				//echo $cComp .' - '. $rec . '<br>';

				if ( true )//($cComp == $rec) )
				{
					if ($empData['islevy'][$pos] <> 0   )
					{

						//if ( ! ($batch == '20120301-20120331-ALL-MONTHLY' && ($empData['empno'][$pos] == '057659408290508' || $empData['empno'][$pos] == '034974063221010' ) ) ):
						//$pdf->printLn ($x, $xpos + $y, $pos+1 .'. '. $empData['name'][$pos] .'  wages: '. $empData['wages'][$pos] .'  salary: '. $empData['salary'][$pos] .' = '. ($empData['wages'][$pos] + $empData['salary'][$pos]) );
						$tempWage = $empData['grossInc'][$pos];
						$tempSdl  = $empData['sdl'][$pos];
						if ($seq % 2):
							$bgcolor = array(255,255,255);
						else:
							$bgcolor = array(235,235,235);
						endif;
						//------------ those who took cash... who left the company early
						//$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
						$pdf->printLnBox( $x,      $xpos   + $y, $seq++.'.', 185, $bgcolor, 'Arial', 10 );
						$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 38) );
						$pdf->printLn( $x+70,   $xpos   + $y, $momGroup );
						$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $tempWage));
						$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $tempSdl));
						$xpos ++;

						$gwage = $gwage +  $tempWage;
						$gsdl  = $gsdl   + $tempSdl;
						//endif;


					}
				}
				$pos++;
			}
			$pdf->printLn( $x,     $xpos++   + $y, '***********************************************************************************************************************************' );
			$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $gwage));
			$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $gsdl));

		$pdf->Footer();
		$pdf->closePDF('testing.pdf');
		exit();



	}

	public function PreviewNetContribution($batch, $company, $mess)
	{
		if ($mess <> 'CASH')
		{
			//$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankPerCompany($batch, $company);
			$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankCheque($batch);
		}

		//$empNoList = array('S1553425G');
		$empData = array('empno'=>array(), 'name'=>array(), 'amount'=>array(),
                   'er_share'=>array(), 'em_share'=>array(), 'cdac'=>array(),
                   'sinda'=>array(), 'mbmf'=>array(), 
                   'er_share'=>array(), 'em_share'=>array(), 'tot_cpf'=>array(),
                   'sdl'=>array(), 'wage'=>array(),
                   'total'=>array() );
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);
		foreach ($empNoList as $kemp=>$vno)
		{
			if ($mess <> 'CASH')
			{
				$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBankCheque($batch, $vno);
			}
			$empno = '';
			$name  = '';
			$basic = 0;
			$ot    = 0;
			$bank  = 0;
			$ap    = 0;
			$advot = 0;
			$others= 0;
			$tot   = 0;
			$meal  = 0;
			$cdac  = 0;
			$sinda = 0;
			$mbmf  = 0;
			$all   = 0;
			$bk    = 0;
			$cpf   = 0;
			$ha    = 0;
			$lv    = 0;
			$mr    = 0;
			$ml    = 0;
			$td    = 0;
			$ul    = 0;
			$pi    = 0;
			$co    = '';
			$em_share = 0;
			$er_share = 0;
			$tot_cpf  = 0;
			$total = 0;
			$sdl   = 0;

			foreach($data as $rec)
			{
				switch($rec->getAcctCode())
				{
					case 'BP':
						$basic = $basic + $rec->getAmount();
						break;
					case 'PI':
						$basic = $basic + $rec->getAmount();
						break;
					case 'CDAC':
						$cdac  = $cdac + $rec->getAmount();
						break;
					case 'SINDA':
						$sinda  = $sinda + $rec->getAmount();
						break;
					case 'MBMF':
						$mbmf  = $mbmf + $rec->getAmount();
						break;
					case 'CPF' :
						$cpf  = $cpf + $rec->getAmount();
						$em_share = $em_share + $rec->getAmount();
						$er_share = $er_share + $rec->getCpfEr();
						$tot_cpf  = $tot_cpf  + $rec->getCpfTotal();
						break;
					case 'AP':
						$ap  = $ap + $rec->getAmount() ;
						break;
					case 'OT':
						if ($rec->getAmount() > 0)
						{
							$ot = $ot + $rec->getAmount();
						}else{
							$advot = $advot + $rec->getAmount() ;
						}
						break;
					default:
						if ($rec->getAcctCode() <> 'CBS')
						{
							$others = $others + $rec->getAmount();
						}
						break;
				}
				$empno = $rec->getEmployeeNo();
				$name  = $rec->getName();
				$co    = $rec->getCompany();
				//                echo $empno .' - '.  $rec->getAcctCode() .' = ' . $rec->getAmount() . ' [ot] ' . $ot;
				//                echo '<br>';

			}
			$basic = $basic + (($basic > 0) ? 0 : (-1 * $ap));
			$basic = $basic + $pi;

			$total = $basic + $ot + $advot + $others + $ap;
			$sdl = $total * .01;
			if ($total <= 200)
			{
				$sdl = 2;
			}

			if ($total > 2000)
			{
				$sdl = 0;
			}

			$empData['empno'][]    = $empno;
			$empData['name'][]     = $name;
			$empData['company'][]  = $co;
			$empData['basic'][]    = $basic;
			$empData['ot'][]       = $ot;
			$empData['ap'][]       = (-1 * $ap);
			$empData['adv_ot'][]   = 0; //(-1 * $advot);
			$empData['cdac'][]     = (-1 * $cdac);
			$empData['sinda'][]    = (-1 * $sinda);
			$empData['mbmf'][]     = (-1 * $mbmf);
			$empData['cpf'][]      = $cpf;
			$empData['others'][]   = $others;
			$empData['sdl'][]      = $sdl;
			$empData['em_share'][]   = ($em_share <> 0 )? $em_share * -1 : 0 ;
			$empData['er_share'][]   = ($er_share <> 0 )? $er_share * -1 : 0 ;
			$empData['tot_cpf'][]    = ($tot_cpf <> 0 )?  $tot_cpf * -1 : 0 ;
			$empData['wage'][]       = $total;
		}

		$pdf = new PdfLibrary();

		$gacro = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'er_share'=>0, 'total'=>0 );
		$gmcs  = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'er_share'=>0, 'total'=>0 );
		$gnano = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'er_share'=>0, 'total'=>0 );
		$gtc   = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'er_share'=>0, 'total'=>0 );
		$pos = 0;
		foreach ($empData['company'] as $kemp=>$vno)
		{
			//            if ($empData['tot_cpf'][$pos] <> 0 )
			//            {
			switch($vno)
			{
				case 'Acro Solution':
					$gacro['count']++;
					$gacro['wages'] = $gacro['wages'] + $empData['wage'][$pos];
					$gacro['em_share'] = $gacro['em_share'] + $empData['em_share'][$pos];
					$gacro['cdac'] = $gacro['cdac'] + $empData['cdac'][$pos];
					$gacro['sinda'] = $gacro['sinda'] + $empData['sinda'][$pos];
					$gacro['mbmf'] = $gacro['mbmf'] + $empData['mbmf'][$pos];
					$gacro['sdl'] = $gacro['sdl'] + $empData['sdl'][$pos];
					$gacro['er_share'] = $gacro['er_share'] + $empData['er_share'][$pos];
					$gacro['total'] = $gacro['em_share'] +  $gacro['cdac'] + $gacro['sinda'] + $gacro['mbmf'] + $gacro['sdl']+ $gacro['er_share'];
					break;
				case 'Micronclean':
					$gmcs['count']++;
					$gmcs['wages'] = $gmcs['wages'] + $empData['wage'][$pos];
					$gmcs['em_share'] = $gmcs['em_share'] + $empData['em_share'][$pos];
					$gmcs['cdac'] = $gmcs['cdac'] + $empData['cdac'][$pos];
					$gmcs['sinda'] = $gmcs['sinda'] + $empData['sinda'][$pos];
					$gmcs['mbmf'] = $gmcs['mbmf'] + $empData['mbmf'][$pos];
					$gmcs['sdl'] = $gmcs['sdl'] + $empData['sdl'][$pos];
					$gmcs['er_share'] = $gmcs['er_share'] + $empData['er_share'][$pos];
					$gmcs['total'] = $gmcs['em_share'] +  $gmcs['cdac'] + $gmcs['sinda'] + $gmcs['mbmf'] + $gmcs['sdl']+ $gmcs['er_share'];
					break;
				case 'NanoClean':
					$gnano['count']++;
					$gnano['wages'] = $gnano['wages'] + $empData['wage'][$pos];
					$gnano['em_share'] = $gnano['em_share'] + $empData['em_share'][$pos];
					$gnano['cdac'] = $gnano['cdac'] + $empData['cdac'][$pos];
					$gnano['sinda'] = $gnano['sinda'] + $empData['sinda'][$pos];
					$gnano['mbmf'] = $gnano['mbmf'] + $empData['mbmf'][$pos];
					$gnano['sdl'] = $gnano['sdl'] + $empData['sdl'][$pos];
					$gnano['er_share'] = $gnano['er_share'] + $empData['er_share'][$pos];
					$gnano['total'] = $gnano['em_share'] +  $gnano['cdac'] + $gnano['sinda'] + $gnano['mbmf'] + $gnano['sdl']+ $gnano['er_share'];
					break;
				case 'T.C. Khoo':
					$gtc['count']++;
					$gtc['wages'] = $gtc['wages'] + $empData['wage'][$pos];
					$gtc['em_share'] = $gtc['em_share'] + $empData['em_share'][$pos];
					$gtc['cdac'] = $gtc['cdac'] + $empData['cdac'][$pos];
					$gtc['sinda'] = $gtc['sinda'] + $empData['sinda'][$pos];
					$gtc['mbmf'] = $gtc['mbmf'] + $empData['mbmf'][$pos];
					$gtc['sdl'] = $gtc['sdl'] + $empData['sdl'][$pos];
					$gtc['er_share'] = $gtc['er_share'] + $empData['er_share'][$pos];
					$gtc['total'] = $gtc['em_share'] +  $gtc['cdac'] + $gtc['sinda'] + $gtc['mbmf'] + $gtc['sdl']+ $gtc['er_share'];
					break;

			}
			//echo $empData['empno'][$pos] .' - '. $empData['name'][$pos] .' - '. $vno . '<br>';
			//            }
			//
			$pos++;

		}

		$pdf->addPage('Arial', 10, 'L');
		$pdf->printTCKhooHeader();
		//setlocale(LC_MONETARY, 'en_US');
		$y = 5;
		$x = 13;
		$xpos = 0;

		$pdf->printBoldLn( $x,    $xpos++   + $y, 'PAYROLL :  CPF CONTRIBUTION', 'Arial', 10);
		//$pdf->printLn( $x,        $xpos   + $y, 'T.C. KHOO & CO. (PTE) LTD.');
		$y+=2;
		$pdf->printBoldLn( $x+100,    $xpos++ + $y, 'Payroll Period: '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt), 'Arial', 12);
		$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                            COMPANY                       #EMP        GROSS       EE-SHARE         CDAC          SINDA         MBMF            NET PAY        SDL        ER-SHARE       TOTAL', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$seq = 1;
		$pdf->printLn( $x+20, $xpos      + $y,'ACRO SOLUTIONS', 'Arial', 10) ;
		$pdf->printLn( $x+70, $xpos      + $y, $gacro['count'], 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, money_format('%(#8n', $gacro['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+102, $xpos      + $y, money_format('%(#8n', $gacro['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+125, $xpos      + $y, money_format('%(#8n', $gacro['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+145, $xpos      + $y, money_format('%(#8n', $gacro['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+165, $xpos      + $y, money_format('%(#8n', $gacro['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+190, $xpos      + $y, money_format('%(#8n', $gacro['wages'] - $gacro['em_share']- $gacro['cdac'] - $gacro['sinda'] - $gacro['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+210, $xpos      + $y, money_format('%(#8n', $gacro['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+230, $xpos      + $y, money_format('%(#8n', $gacro['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+252, $xpos++      + $y, money_format('%(#8n', $gacro['total']), 'Arial', 10) ;
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);

		$pdf->printLn( $x+20, $xpos      + $y,'MICRONCLEAN', 'Arial', 10) ;
		$pdf->printLn( $x+70, $xpos      + $y, $gmcs['count'], 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, money_format('%(#8n', $gmcs['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+102, $xpos      + $y, money_format('%(#8n', $gmcs['em_share']), 'Arial', 10) ;

		$pdf->printLn( $x+125, $xpos      + $y, money_format('%(#8n', $gmcs['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+145, $xpos      + $y, money_format('%(#8n', $gmcs['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+165, $xpos      + $y, money_format('%(#8n', $gmcs['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+190, $xpos      + $y, money_format('%(#8n', $gmcs['wages'] - $gmcs['em_share'] - $gmcs['cdac'] - $gmcs['sinda'] - $gmcs['mbmf']), 'Arial', 10) ;

		$pdf->printLn( $x+210, $xpos      + $y, money_format('%(#8n', $gmcs['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+230, $xpos      + $y, money_format('%(#8n', $gmcs['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+252, $xpos++      + $y, money_format('%(#8n', $gmcs['total']), 'Arial', 10) ;
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+20, $xpos      + $y,'NANOCLEAN', 'Arial', 10) ;
		$pdf->printLn( $x+70, $xpos      + $y, $gnano['count'], 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, money_format('%(#8n', $gnano['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+102, $xpos      + $y, money_format('%(#8n', $gnano['em_share']), 'Arial', 10) ;

		$pdf->printLn( $x+125, $xpos      + $y, money_format('%(#8n', $gnano['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+145, $xpos      + $y, money_format('%(#8n', $gnano['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+165, $xpos      + $y, money_format('%(#8n', $gnano['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+190, $xpos      + $y, money_format('%(#8n', $gnano['wages'] - $gnano['em_share'] - $gnano['cdac'] - $gnano['sinda'] - $gnano['mbmf']), 'Arial', 10) ;

		$pdf->printLn( $x+210, $xpos      + $y, money_format('%(#8n', $gnano['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+230, $xpos      + $y, money_format('%(#8n', $gnano['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+252, $xpos++      + $y, money_format('%(#8n', $gnano['total']), 'Arial', 10) ;
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+20, $xpos      + $y,'T.C. KHOO', 'Arial', 10) ;
		$pdf->printLn( $x+70, $xpos      + $y, $gtc['count'], 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, money_format('%(#8n', $gtc['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+102, $xpos      + $y, money_format('%(#8n', $gtc['em_share']), 'Arial', 10) ;

		$pdf->printLn( $x+125, $xpos      + $y, money_format('%(#8n', $gtc['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+145, $xpos      + $y, money_format('%(#8n', $gtc['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+165, $xpos      + $y, money_format('%(#8n', $gtc['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+190, $xpos      + $y, money_format('%(#8n',  $gtc['wages'] - $gtc['em_share'] - $gtc['cdac'] - $gtc['sinda'] - $gtc['mbmf']), 'Arial', 10) ;

		$pdf->printLn( $x+210, $xpos      + $y, money_format('%(#8n', $gtc['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+230, $xpos      + $y, money_format('%(#8n', $gtc['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+252, $xpos++      + $y, money_format('%(#8n', $gtc['total']), 'Arial', 10) ;
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');

		$pdf->printLn( $x+70, $xpos       + $y, $gacro['count'] + $gmcs['count'] + $gnano['count'] + $gtc['count'] , 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos       + $y, money_format('%(#8n', $gacro['wages'] + $gmcs['wages'] + $gnano['wages'] + $gtc['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+102, $xpos      + $y, money_format('%(#8n', $gacro['em_share'] + $gmcs['em_share'] + $gnano['em_share'] + $gtc['em_share']), 'Arial', 10) ;

		$pdf->printLn( $x+125, $xpos      + $y, money_format('%(#8n', $gacro['cdac'] + $gmcs['cdac'] + $gnano['cdac'] + $gtc['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+145, $xpos      + $y, money_format('%(#8n', $gacro['sinda'] + $gmcs['sinda'] + $gnano['sinda'] + $gtc['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+165, $xpos      + $y, money_format('%(#8n', $gacro['mbmf'] + $gmcs['mbmf'] + $gnano['mbmf'] + $gtc['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+190, $xpos      + $y, money_format('%(#8n', ($gacro['wages'] + $gmcs['wages'] + $gnano['wages'] + $gtc['wages']) -
		($gacro['em_share'] + $gmcs['em_share'] + $gnano['em_share'] + $gtc['em_share']) -
		($gacro['cdac'] + $gmcs['cdac'] + $gnano['cdac'] + $gtc['cdac'])  -
		($gacro['sinda'] + $gmcs['sinda'] + $gnano['sinda'] + $gtc['sinda'])  -
		($gacro['mbmf'] + $gmcs['mbmf'] + $gnano['mbmf'] + $gtc['mbmf']) )
		, 'Arial', 10) ;

		$pdf->printLn( $x+210, $xpos      + $y, money_format('%(#8n', $gacro['sdl'] + $gmcs['sdl'] + $gnano['sdl'] + $gtc['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+230, $xpos      + $y, money_format('%(#8n', $gacro['er_share'] + $gmcs['er_share'] + $gnano['er_share'] + $gtc['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+252, $xpos++    + $y, money_format('%(#8n', $gacro['total'] + $gmcs['total'] + $gnano['total'] + $gtc['total']), 'Arial', 10) ;
		$pdf->Footer();

		foreach (sfConfig::get('compGroup') as $kcomp=>$cComp)
		{
			$gross = 0;
			$gwage = 0;
			$gemsh = 0;
			$gcdac = 0;
			$gsinda= 0;
			$gmbmf = 0;
			$gsdl  = 0;
			$gersh = 0;
			$gecf  = 0;

			$xpos =  0;
			$pos = 0;
			$cntr = 0;
			$gbank  = 0;
			$gcash  = 0;
			$gdinner= 0;
			//            $xpos = 0;
			$seq = 1;
			$xcpf = 0;
			$tcpf = 0;
			foreach ($empData['company'] as $rec)
			{
				if ( ($cComp == $rec) )
				//&& $empData['tot_cpf'][$pos] <> 0 )
				{
					if ($xpos == 38 || $xpos == 0)
					{
						$pdf->addPage('Arial', 10, 'L');
						//$pdf->printTCKhooHeader();
						$x = 13;
						$y = 2;
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printBoldLn( $x,    $xpos++   + $y, $cComp.' - CPF Contribution', 'Arial', 10);
						$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
						$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
						$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME                           COMPANY         SUBCON         EE-SHARE        NET PAY      CDAC      SINDA         MBMF         SDL       ER-SHARE    TOTAL', 'Arial', 10);
						$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
					}
					$xcpf = $empData['em_share'][$pos] + $empData['cdac'][$pos] + $empData['sinda'][$pos] + $empData['mbmf'][$pos];
					$tcpf = $empData['er_share'][$pos] + $empData['cdac'][$pos] + $empData['sinda'][$pos] + $empData['mbmf'][$pos] + $empData['em_share'][$pos] + $empData['sdl'][$pos];
					$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
					$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 38) );
					$pdf->printLn( $x+65,   $xpos   + $y, $empData['company'][$pos] );
					$pdf->printLn( $x+90,  $xpos   + $y, money_format('%(#6n', $empData['wage'][$pos]));
					$pdf->printLn( $x+114,  $xpos   + $y, money_format('%(#6n', $empData['em_share'][$pos]));
					$pdf->printLn( $x+140,  $xpos   + $y, money_format('%(#6n', $empData['wage'][$pos] - $xcpf) );
					$pdf->printLn( $x+158,  $xpos   + $y, money_format('%(#6n', $empData['cdac'][$pos]) );
					$pdf->printLn( $x+176,  $xpos   + $y, money_format('%(#6n', $empData['sinda'][$pos]) );
					$pdf->printLn( $x+194,  $xpos   + $y, money_format('%(#6n', $empData['mbmf'][$pos]) );
					$pdf->printLn( $x+212,  $xpos    + $y, money_format('%(#6n',$empData['sdl'][$pos] ) );
					$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos]));
					$pdf->printLn( $x+250,  $xpos   + $y, money_format('%(#6n', $tcpf));
					$xpos ++;

					$gwage = $gwage +  $empData['wage'][$pos];
					$gemsh = $gemsh +  $empData['em_share'][$pos];
					$gcdac = $gcdac +  $empData['cdac'][$pos];
					$gsinda= $gsinda + $empData['sinda'][$pos];
					$gmbmf = $gmbmf  + $empData['mbmf'][$pos];
					$gsdl  = $gsdl   + $empData['sdl'][$pos];
					$gecf  = $gecf   + $empData['ecf'][$pos];
					$gersh = $gersh  + $empData['er_share'][$pos];

					$gross = $gemsh + $gcdac + $gsinda + $gmbmf + $gsdl + $gersh + $gecf;
				}
				$pos++;
			}
			$pdf->printLn( $x,     $xpos++   + $y, '****************************************************************************************************************************************************************************************************' );
			$pdf->printLn( $x+90,  $xpos   + $y, money_format('%(#6n', $gwage));
			$pdf->printLn( $x+114,  $xpos   + $y, money_format('%(#6n', $gemsh));
			$pdf->printLn( $x+140,  $xpos   + $y, money_format('%(#6n', $gwage - $gemsh - $gcdac - $gsinda - $gmbmf));
			$pdf->printLn( $x+158,  $xpos   + $y, money_format('%(#6n', $gcdac) );
			$pdf->printLn( $x+176,  $xpos   + $y, money_format('%(#6n', $gsinda) );
			$pdf->printLn( $x+194,  $xpos   + $y, money_format('%(#6n', $gmbmf) );
			//$pdf->printLn( $x+210,  $xpos    + $y, '$  '.$xsdl); //money_format('%(#6n',$xsdl ) );
			$pdf->printLn( $x+212,  $xpos   + $y, money_format('%(#6n',$gsdl ) );
			$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $gersh));
			$pdf->printLn( $x+250,  $xpos++ + $y, money_format('%(#6n', $gross));

			$pdf->Footer();
		}
		$pdf->closePDF('testing.pdf');
	}
	
	

	
	public function PreviewCpfData($batch, $penalty, $momGroup)
	{
//		$batch = '20080901-20080930-ALL-MONTHLY';
//		echo 'kebot';
//		exit();
		//$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankChequeorderbyName($batch);
		$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankChequeForLevy($batch,'', $momGroup);
		//$empNoList = array('S8517315D','S0016882C');
		$empData = HrLib::PopulateCpfData($batch, $empNoList, 'BANK');
		$rmonth  = $this->GetStartDate($batch);
		$pos    = 0;
		$tCpf   = 0;
		$tMbmf  = 0;
		$mcnt   = 0;
		$tCdac  = 0;
		$tSinda = 0;
		$scnt   = 0;
		$ccnt   = 0;
		$tSdl   = 0;
		$csdl   = 0;
		$seq    = 0;
		$tcontrib = 0;
		$twage  = 0;
		$ter    = 0;
		$tem    = 0;
		$cr     = '<br>';
		$mcpf   = 0;
		$addsdl = 0;
		$eSdl = 0;
		$tEmployeeTotal = 0;
		$xtraSDL = 0;
		$cpfList = array();
		$tEcf = 0; 
		$cecf = 0;
		foreach($empData['empno'] as $ke=>$rec)
		{
	

			$employeeTotal = 0;
						
			if ( $empData['tot_cpf'][$pos] ||
			$empData['mbmf'][$pos]    ||
			$empData['sinda'][$pos]   ||
			$empData['ecf'][$pos]   ||
			$empData['cdac'][$pos]    )
			{
				$tCpf   = $tCpf   + $empData['tot_cpf'][$pos];
				$tMbmf  = $tMbmf  + $empData['mbmf'][$pos];
				$tSinda = $tSinda + $empData['sinda'][$pos];
				$tCdac  = $tCdac  + $empData['cdac'][$pos];
				$twage  = $twage  + $empData['wage'][$pos];
				$ter    = $ter    + $empData['er_share'][$pos];
				$tem    = $tem    + $empData['em_share'][$pos];
				$eSdl   = $eSdl   + $empData['sdl'][$pos];
				$tEcf   = $tEcf   + $empData['ecf'][$pos];

				//---------------- record pointer for cpf contributors
				$cpfList[] = $pos;
				$tSdl      = $tSdl + $empData['sdl'][$pos];
				$seq++;
				
			}
			$mcpf = $mcpf + (($empData['tot_cpf'][$pos]  <> 0)? 1: 0);
			$mcnt = $mcnt + (($empData['mbmf'][$pos]  <> 0)? 1: 0);
			$scnt = $scnt + (($empData['sinda'][$pos] <> 0)? 1: 0);
			$ccnt = $ccnt + (($empData['cdac'][$pos]  <> 0)? 1: 0);
			$csdl = $csdl + (($empData['sdl'][$pos]   <> 0)? 1: 0);
			$cecf = $cecf + (($empData['ecf'][$pos]   <> 0)? 1: 0);
			
			if ($empData['islevy'][$pos])
			{
				$addsdl = $addsdl + $empData['sdl'][$pos];
			}
			$employeeTotal = 
				  $empData['em_share'][$pos]
				+ $empData['er_share'][$pos]
				;
			$pos ++ ;
		}

		
		$tSdl = (intval($tSdl) + intval($addsdl) + $xtraSDL);
		$tcontrib = ($tem + $ter + $tMbmf + $tSinda + $tCdac +  $tSdl + $penalty + $tEcf);
//		echo 'em Share: '.$tem . "<br>";
//		echo 'er Share: '.$ter . "<br>";
//		echo 'Mbmf: '.$tMbmf . "<br>";
//		echo 'Sinda: '.$tSinda . "<br>";
//		echo 'Cdac: '.$tCdac . "<br>";
//		echo 'Ecf: '.$tEcf . "<br>";
//		echo 'Sdl: '.$tSdl . "<br>";
//		echo 'Penalty: '.$penalty . "<br>";
//		exit();
		
		$dateTime = Date('Y-m-d H:i:s');
		$mess = array();
		$subMode = 'F';
		$fchar  = '_';
		$erRefNo = '1630482';
		$advCode = '01';
		$fDate   = DateUtils::DUFormat('Ymd', $dateTime);
		$ftime   = DateUtils::DUFormat('His', $dateTime);
		$fID     = 'FTP.DTL';
		$rType   = '0';
		$cpfCode = '01';
		$mbmfCode= '02';
		$sinCode = '03';
		$cdacCode= '04';
		$ecfCode = '05';
		$penCode = '07';
		$sdlCode = '11';
		$csn     = '197500399G';
		$ptype   = 'PTE';
		//$Sno     = '01';
		if ($momGroup == 'T.C. Khoo Mfg') :
			$Sno     = '01';
		else:
			$Sno     = '02';
		endif;
		
		$endfill = 109;
		$relevant= $this->GetStartDate($batch);

		//------------------------------ make line 1 header
		$mess[] = $subMode . $fchar . $csn . $ptype . $Sno . $fchar . $advCode . $fDate . $ftime . $fID . str_pad('', $endfill, $fchar) ;

		//----------- total cpf
// 		var_dump($ter);
// 		var_dump($cecf);
// 		exit();
		$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $cpfCode . $this->leading_zero($tCpf, 12) . '0000000' . str_pad('', $endfill-6, $fchar);

		if ($mcnt)
		{
			//----------- total mbmf
			$mess[] = $subMode . $rType . $csn . $ptype . $Sno  . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $mbmfCode . $this->leading_zero($tMbmf, 12) . $this->leading_zero_nochange($mcnt, 7, false) .str_pad('',$endfill-6, $fchar);
		}

		if ($scnt)
		{
			//----------- total sinda
			$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $sinCode . $this->leading_zero($tSinda, 12) . $this->leading_zero_nochange($scnt, 7, false) .str_pad('', $endfill-6, $fchar);
		}
		if ($ccnt)
		{
			//----------- total cdac
			$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $cdacCode . $this->leading_zero($tCdac, 12) . $this->leading_zero_nochange($ccnt, 7, false) .str_pad('', $endfill-6, $fchar);
		}
		

		if ($cecf)
		{
			//----------- total ecf
			$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $ecfCode . $this->leading_zero($tEcf, 12) . $this->leading_zero_nochange($cecf, 7, false) .str_pad('', $endfill-6, $fchar);
		}
		
		if ($penalty)
		{
			//----------- total penalty
			$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $penCode . $this->leading_zero($penalty, 12) . '0000000' .str_pad('', $endfill-6, $fchar);
		}

		if ($csdl)
		{
			//----------- total sdl
			$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $advCode . DateUtils::DUFormat('Ym',$rmonth) . $sdlCode . $this->leading_zero(intval($tSdl), 12) . '0000000' .str_pad('', $endfill-6, $fchar);
		}

		$cpfadv = '01';
		$mbmadv = 1;
		$sinadv = 1;
		$cdaadv = 1;
		$rType  = '1';
		$cpfStatus = array();
		$name = '';
		$chkcpf = 0;
		//-------------------------------- detail entry
		foreach($cpfList as $klist=>$vlist)
		{
			//echo $empData['name'][$vlist] . ',cpf,' . $empData['tot_cpf'][$vlist]  . ',mbmf,' . $empData['mbmf'][$vlist] . ',sinda,' . $empData['sinda'][$vlist] . ',cdac,' . $empData['cdac'][$vlist] . ',ecf,' . $empData['ecf'][$vlist]. "\r\n";

			//-------------------------------- cpf detail
			if ($empData['tot_cpf'][$vlist])
			{
				$chkcpf = $chkcpf + $empData['tot_cpf'][$vlist];
				$cpfStatus = $this->CpfStatus($empData['empno'][$vlist], $batch);
				$name = substr($empData['name'][$vlist], 0 , 22);
				$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar .  $cpfadv .
				DateUtils::DUFormat('Ym',$rmonth) . $cpfCode . $empData['empno'][$vlist]
				. $this->leading_zero($empData['tot_cpf'][$vlist], 12)
				. $this->leading_zero_rounded($empData['wage'][$vlist], 10)
				. $this->leading_zero_rounded($empData['additional'][$vlist], 10) //has been added on June 12, 2014  
				//. str_pad('',10, '0') 
				. $cpfStatus['status']
				. str_pad($name,22, $fchar)
				. $cpfStatus['type'] . str_pad('',$endfill-52, $fchar);
			}
			//-------------------------------- mbmf
			if ($empData['mbmf'][$vlist])
			{
				//$chkcpf = $chkcpf + $empData['mbmf'][$vlist];
				$name = substr($empData['name'][$vlist], 0 , 22);
				$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar .  $cpfadv .
				DateUtils::DUFormat('Ym',$rmonth) . $mbmfCode . $empData['empno'][$vlist]
				. $this->leading_zero($empData['mbmf'][$vlist], 12)
				. $this->leading_zero(0, 10)
				. str_pad('',10, '0') . '_'
				. str_pad($name,22, $fchar)
				. '_' . str_pad('',$endfill-52, $fchar);
			}
			//-------------------------------- cdac
			if ($empData['cdac'][$vlist])
			{
				$name = substr($empData['name'][$vlist], 0 , 22);
				$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar .  $cpfadv .
				DateUtils::DUFormat('Ym',$rmonth) . $cdacCode . $empData['empno'][$vlist]
				. $this->leading_zero($empData['cdac'][$vlist], 12)
				. $this->leading_zero(0, 10)
				. str_pad('',10, '0') . '_'
				. str_pad($name,22, $fchar)
				. '_' . str_pad('',$endfill-52, $fchar);
			}

			//-------------------------------- sinda
			if ($empData['sinda'][$vlist])
			{
				//$chkcpf = $chkcpf + $empData['sinda'][$vlist];
				$name = substr($empData['name'][$vlist], 0 , 22);
				$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar .  $cpfadv .
				DateUtils::DUFormat('Ym',$rmonth) . $sinCode . $empData['empno'][$vlist]
				. $this->leading_zero($empData['sinda'][$vlist], 12)
				. $this->leading_zero(0, 10)
				. str_pad('',10, '0') . '_'
				. str_pad($name,22, $fchar)
				. '_' . str_pad('',$endfill-52, $fchar);
			}
			
			//-------------------------------- sinda
			if ($empData['ecf'][$vlist])
			{
				//$chkcpf = $chkcpf + $empData['sinda'][$vlist];
				$name = substr($empData['name'][$vlist], 0 , 22);
				$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar .  $cpfadv .
				DateUtils::DUFormat('Ym',$rmonth) . $ecfCode . $empData['empno'][$vlist]
				. $this->leading_zero($empData['ecf'][$vlist], 12)
				. $this->leading_zero(0, 10)
				. str_pad('',10, '0') . '_'
				. str_pad($name,22, $fchar)
				. '_' . str_pad('',$endfill-52, $fchar);
			}

		}
		//------------------------------------ footer
		$rType = '9';
		$mess[] = $subMode . $rType . $csn . $ptype . $Sno . $fchar . $cpfadv . $this->leading_zero_nochange(count($mess)+1, 7, false)
		. $this->leading_zero_not_rounded($tcontrib, 15). str_pad('',$endfill-1, $fchar);
		//------------------------------------ write to file
		$filename = $csn . $ptype . $Sno . DateUtils::DUFormat('MY', $relevant).'01.txt';

		header('Content-type: application/txt');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		foreach($mess as $km=>$vm)
		{
			echo str_replace('_',' ',  $vm) . "\r\n" ;
			
		}

		exit();
	}
	
	public function leading_zero($number, $num_digits, $decimals=true)
	{
		//--------- remove the decimal places
		if ($number > 0)
		{
			$number = intval($number * 100, 0);
			$number = "$number";
			return str_pad($number, $num_digits, "0", STR_PAD_LEFT);
		}else{
			return str_repeat("0", $num_digits);
		}
	}
	
	
	public function leading_zero_nochange($number, $num_digits, $decimals=true)
	{
		return str_pad($number, $num_digits, "0", STR_PAD_LEFT);
	}
	
	public function CpfStatus($empNo, $batch)
	{
		$cpfstat = 'E';
		$eff = PayBasicPayPeer::GetEffectivityDate($empNo);
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);
		if ( $eff >= $sdt && $eff <= $edt)
		{
			$cpfstat = 'N';
		}
		return array('status'=>$cpfstat, 'type'=>'_');
	}
	
	public function leading_zero_not_rounded($number, $num_digits, $decimals=true)
	{
		//--------- remove the decimal places
		if ($number > 0)
		{
			//$number = round($number, 0);
			$number = intval(round($number * 100), 0); //remove decimal places
			$number = "$number";
			return str_pad($number, $num_digits, "0", STR_PAD_LEFT);
		}else{
			return str_repeat("0", $num_digits);
		}
	}
	
	public function leading_zero_rounded($number, $num_digits, $decimals=true)
	{
		//--------- remove the decimal places
		if ($number > 0)
		{
			$number = round($number, 0);
			$number = "$number";
			return str_pad($number, $num_digits, "0", STR_PAD_LEFT);
		}else{
			return str_repeat("0", $num_digits);
		}
	}
	
	public function executeYearlyTax()
	{
		if ($this->_G('year')):
			$periodList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($this->_G('year'));
			$c = new Criteria();
			$c->add(PayEmployeeLedgerArchivePeer::PERIOD_CODE, $periodList, Criteria::IN);
			$c->addGroupByColumn(PayEmployeeLedgerArchivePeer::PERIOD_CODE);
			$c->addAscendingOrderByColumn(PayEmployeeLedgerArchivePeer::PERIOD_CODE);
			$this->pager = PayEmployeeLedgerArchivePeer::doSelect($c);
			if ($this->_G('generate_employee_tax')):
				$periodList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($this->_G('year'));
				foreach($periodList as $pcode):
					ContribEmployeeIr8aPeer::GenerateAllIncome($pcode, $this->_U());
				endforeach;
			endif;
			if ($this->_G('generate_tax_file')):
				$this->redirect('report/CreateTaxTxtFile?year=' . $this->_G('year') );
			endif;
		endif;
	}
	
	public function executeIrasMonthlyPreview()
	{
		$pcode = $this->_G('period_code');
		$c = new Criteria();
		$c->add(ContribEmployeeIr8aPeer::PERIOD_CODE, $pcode);
		$c->addAscendingOrderByColumn(ContribEmployeeIr8aPeer::NAME);
		$this->pager = ContribEmployeeIr8aPeer::doSelect($c);
	}
	
	public function executeInternalBilling()
	{
		if ($this->getRequest()->getMethod() != sfRequest::POST){
			$this->_S('rounding_error', 0);
		}
			
	    if ($this->getRequest()->getMethod() == sfRequest::POST)
        {
	        //$this->var_dump($_POST);
	        //exit();
            $this->internalBillingPDF($this->_G('period_code'), $this->_G('rounding_error'));
        }			
	}
	
	
	public function InternalBillingPDF($pcode, $roundErr)
	{
		//kebots
		//var_dump($roundErr);
		//exit();

		
		$penalty = $this->_G('penalty_interest');
		$pdf = new PdfLibrary();

		//------------------------------ 
		//            Payment Voucher
		//------------------------------
		$paidType = array('ALL', 'BANK', 'CASH', 'CHEQUE','CASH-CHECK');
		//$paidType = array('CASH-CHECK');
		foreach($paidType as $k=>$mess){
			$sdt = $this->GetStartDate($pcode);
			$edt = $this->GetEndDate($pcode);
			$pos = 0;
			$oldno = null;
			if ( $mess == ( 'BANK' ) )
			{
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBank($pcode);
			}
			if ( $mess == ( 'CASH' ) )
			{
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCash($pcode);
			}
			if ( $mess == ( 'CHEQUE' ) )
			{
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCheque($pcode);
			}
			if ( $mess == ( 'CASH-CHECK' ) )
			{
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashCheck($pcode);
			}
			if ( $mess == ( 'ALL' ) )
			{
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListbyCompany($pcode);
			}
			//$empNoList = array('S8079741I');
			$empVoucher = array('empno'=>array(), 'name'=>array(), 'company'=>array(), 'salary'=>array(), 'wages'=>array());
			foreach($empNoList as $ke=>$empNo)
			{
				//$empNo = 'S7838275I';
				//$dtrmast = TkDtrmasterPeer::GetDatabyEmployeeNo($empNo);
				$empInfo = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
				if ( $mess == ( 'BANK' ) )
				{
					$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($pcode, $empNo);
				}
				if ( $mess == ( 'CASH' ) )
				{
					$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCash($pcode, $empNo);
				}
				if ( $mess == ( 'CHEQUE' ) )
				{
					$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCheque($pcode, $empNo);
				}
				if ( $mess == ( 'CASH-CHECK' ) )
				{
					$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCashCheck($pcode, $empNo);
				}
				if ( $mess == ( 'ALL' ) )
				{
					$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDatabyPeriod($pcode, $empNo);
				}
	
				$salary = 0;
				$income = 0;
				$deduct = 0;
				$sal = 0;
				$wag = 0;
				
				foreach ($data as $rec)
				{
					if ($rec->getAcctCode() == 'BP' || $rec->getAcctCode() == 'PI')
					{
						$salary = $salary + $rec->getAmount();
					}
	
					$income = $income + ( ($rec->getIncomeExpense() == 1 )? $rec->getAmount(): 0);
					$deduct = $deduct + ( ($rec->getIncomeExpense() == 2 )? $rec->getAmount(): 0);
					//echo $rec->getName().' - '.$rec->getDescription().' - '.$rec->getAmount().'<br>';
				}
				//echo $dtrmast->getName() .' - '.  $dtrmast->getCompany() .' sal: '. $salary.' inc: '. $income.' ded: '. $deduct.'<br>';
				if ( $salary + $deduct < 0)
				{
					$sal = 0;
					$wag = $income + $deduct;
				}else{
					$sal = $salary + $deduct;
					$wag = $income - $salary;
				}
				$empVoucher['empno'][]   = $empNo;
				$empVoucher['name'][]    = $rec->getName();
				$empVoucher['company'][] = $rec->getCompany(); //$dtrmast->getCompany();
				$empVoucher['salary'][]  = $sal;
				$empVoucher['wages'][]   = $wag;
				//exit();
			}
			$wacro= 0;
			$wmcs = 0;
			$wnano= 0;
			$wtck = 0;
			$wmdr = 0;
			$sacro= 0;
			$smcs = 0;
			$snano= 0;
			$stck = 0;
			$smdr = 0;
			$tot = 0;
			$pos = 0;
			$total = 0;
			$others = 0;
			foreach ($empVoucher['company'] as $rec)
			{
				switch( strtolower($rec))
				{
					case 'acro solution':
						$wacro = $wacro + $empVoucher['wages'][$pos] ;
						$sacro = $sacro + $empVoucher['salary'][$pos] ;
						break;
					case 'micronclean':
						$wmcs = $wmcs + $empVoucher['wages'][$pos] ;
						$smcs = $smcs + $empVoucher['salary'][$pos] ;
						break;
					case 'nanoclean':
						$wnano = $wnano + $empVoucher['wages'][$pos] ;
						$snano = $snano + $empVoucher['salary'][$pos] ;
						break;
					case 't.c. khoo':
						$wtck = $wtck + $empVoucher['wages'][$pos] ;
						$stck = $stck + $empVoucher['salary'][$pos] ;
						break;
					case 'microndr':
						$wmdr = $wmdr + $empVoucher['wages'][$pos] ;
						$smdr = $smdr + $empVoucher['salary'][$pos] ;
						break;
					default:
						$others = $others + $total;
						break;
				}
				//echo $pos .'. '. $empCash['name'][$pos] .'  wages: '. $empCash['wages'][$pos] .'  salary: '. $empCash['salary'][$pos] .' = '. ($empCash['wages'][$pos] + $empCash['salary'][$pos]). '<br>';
				//            $tot =  $tot + ($empCash['wages'][$pos] + $empCash['salary'][$pos]);
				$pos++;
			}
			$x = 0;
			$y = 0;
	
			$pdf->addPage();
			$xpos = 2;
	
			$pdf->printTCKhooHeader();
			$y = 5;
			$x = 13;
			$gross = 0;
			$amt = 0;
			//        $pdf->addPage('Arial', 10);
			setlocale(LC_MONETARY, 'en_US');
			$pdf->printBoldLn( $x,    $xpos   + $y, 'PAYMENT VOUCHER', 'Arial', 10);
			$pdf->printLn( $x+120,    $xpos++ + $y, 'Voucher No:  ___________________');
			$pdf->printLn( $x,        $xpos   + $y, 'T.C. KHOO & CO. (PTE) LTD.');
			$pdf->printLn( $x+120,    $xpos++ + $y, 'DATE    : '.Date('d-M-Y'));
			$y++;
			if ($mess == 'BANK' || $mess == 'CHEQUE' || $mess == 'CASH-CHECK')
			{
				$pdf->printBoldLn( $x+40,    $xpos++ + $y, 'PAY TO: PAYROLL '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')', 'Arial', 12);
			}
			if ($mess == 'CASH')
			{
				$pdf->printBoldLn( $x+37,    $xpos++ + $y, 'PAY TO: SUB-CONTRACTOR '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')', 'Arial', 12);
			}
			if ($mess == 'ALL')
			{
				$pdf->printBoldLn( $x+37,    $xpos++ + $y, 'PAY TO: PAYROLL/SUB-CON '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')', 'Arial', 12);
			}
			$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
			$y++;
			$pdf->printLn( $x+60,    $xpos++   + $y, 'D E S C R I P T I O N                                                   AMOUNT', 'Arial', 12);
			$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10);
			$pdf->printLn( $x,    $xpos++   + $y, '                 GIRO                       ACRO               MCS                  NANO                    TCK           MDR               TOTAL', 'Arial', 10);
			$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
			$seq = 1;
			$pdf->printLn( $x,    $xpos     + $y, '                 SUBCON', 'Arial', 10);
			//money_format('%(#10n', $number)
			//$pdf->printLn( $x+50, $xpos     + $y, number_format('%(#8n', $wacro), 'Arial', 10);
			$pdf->printLn( $x+45, $xpos     + $y, number_format($wacro, 2 ), 'Arial', 10);
			$pdf->printLn( $x+70, $xpos     + $y, number_format($wmcs, 2), 'Arial', 10);
			$pdf->printLn( $x+96,$xpos     + $y, number_format($wnano, 2), 'Arial', 10);
			$pdf->printLn( $x+124,$xpos     + $y, number_format($wtck, 2), 'Arial', 10);
			$pdf->printLn( $x+144,$xpos     + $y, number_format($wmdr, 2), 'Arial', 10);
			$pdf->printLn( $x+165, $xpos++     + $y, number_format($wacro+$wmcs+$wnano+$wtck+$wmdr, 2), 'Arial', 10);
			$pdf->printLn( $x+10,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
			$pdf->printLn( $x,    $xpos     + $y, '                 SALARY', 'Arial', 10);
			$pdf->printLn( $x+45, $xpos     + $y, number_format($sacro, 2), 'Arial', 10);
			$pdf->printLn( $x+70, $xpos     + $y, number_format($smcs, 2), 'Arial', 10);
			$pdf->printLn( $x+96,$xpos     + $y, number_format($snano, 2), 'Arial', 10);
			$pdf->printLn( $x+124,$xpos     + $y, number_format($stck, 2), 'Arial', 10);
			$pdf->printLn( $x+144,$xpos     + $y, number_format($smdr, 2), 'Arial', 10);
			$pdf->printLn( $x+165, $xpos++     + $y, number_format($sacro+$smcs+$snano+$stck+$smdr, 2), 'Arial', 10);
			$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
			$pdf->printLn( $x,    $xpos     + $y, 'TOTAL:' );
			$pdf->printLn( $x+45, $xpos     + $y, number_format($sacro+$wacro, 2), 'Arial', 10);
			$pdf->printLn( $x+70, $xpos     + $y, number_format($smcs+$wmcs, 2), 'Arial', 10);
			$pdf->printLn( $x+96,$xpos     + $y, number_format($snano+$wnano, 2), 'Arial', 10);
			$pdf->printLn( $x+124,$xpos     + $y, number_format($stck+$wtck, 2), 'Arial', 10);
			$pdf->printLn( $x+144,$xpos     + $y, number_format($smdr+$wmdr, 2), 'Arial', 10);
			$pdf->printBoldLn( $x+165, $xpos++     + $y, number_format($sacro+$wacro+$smcs+$wmcs+$snano+$wnano+$stck+$wtck+$smdr+$wmdr, 2), 'Arial', 10);
			//        $pdf->pritnBoldln($x+160, $xpos++     + $y, )
			$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' , 'Arial', 10);
			$pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
			
		}

		//------------------------------ 
		//            Journal Listing
		//------------------------------
		
		$batch = $pcode;
		$paidType = array('BANK', 'CASH', 'CHEQUE', 'CASH-CHECK');
		$companyList = HrCompanyPeer::OptCompanyNameList();
		foreach($paidType as $k=>$mess){
		foreach ($companyList as $company=>$cname) {
			switch($mess)
			{
				case 'BANK':
					$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankPerCompany($batch, $company);
					break;
				case 'CASH':
					$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashPerCompany($batch, $company);
					break;
				case 'CASH-CHECK':
					$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashCheckPerCompany($batch, $company);
					break;
				default    :
					$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforChequePerCompany($batch, $company);
					break;
			}


			//$empNoList = array('S8079741I');
			$empData = array('empno'=>array(), 'name'=>array(), 'basic'=>array(),
	                         'ot'=>array(), 'cbs'=>array(), 'ap'=>array(), 
	                         'adv_ot'=>array(), 'meal'=>array(), 'cdac'=>array(), 
	                         'sinda'=>array(), 'mbmf'=>array(),  'others'=>array(), 
	                         'all'=>array(), 'bk'=>array(),  'cpf'=>array(),
	                         'ha'=>array(), 'lv'=>array(),  'mr'=>array(),
	                         'ml'=>array(), 'td'=>array(),  'ul'=>array(),
	                         'total'=>array());

			
			foreach ($empNoList as $kemp=>$vno)
			{
				switch($mess)
				{
					case 'BANK':
						$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($batch, $vno);
						break;
					case 'CASH':
						$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCash($batch, $vno);
						break;
					case 'CASH-CHECK':
						$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCashCheck($batch, $vno);
						break;
					default    :
						$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCheque($batch, $vno);
						break;
				}
// 				echo $mess;
// 				HTMLLib::vardump($data);
// 				exit();
				$empno = '';
				$name  = '';
				$basic = 0;
				$ot    = 0;
				$bank  = 0;
				$ap    = 0;
				$advot = 0;
				$others= 0;
				$tot   = 0;
				$meal  = 0;
				$cdac  = 0;
				$sinda = 0;
				$mbmf  = 0;
				$all   = 0;
				$bk    = 0;
				$cpf   = 0;
				$ha    = 0;
				$lv    = 0;
				$mr    = 0;
				$ml    = 0;
				$td    = 0;
				$ul    = 0;
				foreach($data as $rec)
				{
					switch($rec->getAcctCode())
					{
						case 'AL':
							$all = $all + $rec->getAmount();
							break;
							//                    case 'BK':
							//                        $bk = $bk + $rec->getAmount();
							//                        break;
						case 'BP':
							$basic = $basic + $rec->getAmount();
							break;
						case 'CPF':
							$cpf = $cpf + $rec->getAmount();
							break;
						case 'HA':
							$ha = $ha + $rec->getAmount();
							break;
						case 'LV':
							$lv = $lv + $rec->getAmount();
							break;
						case 'MR':
							$mr = $mr + $rec->getAmount();
							break;
						case 'ML':
							$ml = $ml + $rec->getAmount();
							break;
						case 'TD':
							$td = $td + $rec->getAmount();
							break;
						case 'UL':
							$ul = $ul + $rec->getAmount();
							break;
	
						case 'PI':
							$basic = $basic + $rec->getAmount();
							break;
						case 'CBS':
							$bank  = $bank + $rec->getAmount();
							break;
						case 'AP':
							$ap  = $ap + $rec->getAmount();
							break;
						case 'OT':
							if ($rec->getAmount() > 0)
							{
								$ot = $ot + $rec->getAmount();
							}else{
								$advot = $advot + $rec->getAmount();
							}
							break;
						case 'MEAL':
							$meal  = $meal + $rec->getAmount();
							break;
						case 'CDAC':
							$cdac  = $cdac + $rec->getAmount();
							break;
						case 'SINDA':
							$sinda  = $sinda + $rec->getAmount();
							break;
						case 'MBMF':
							$mbmf  = $mbmf + $rec->getAmount();
							break;
	
						default:
							$others = $others + $rec->getAmount();
							break;
					}
					$empno = $rec->getEmployeeNo();
					$name  = $rec->getName();
					//                echo $empno .' - '.  $rec->getAcctCode() .' = ' . $rec->getAmount() . ' [ot] ' . $ot;
					//                echo '<br>';
					$tot = $tot + $rec->getAmount();
				}
				//kebot
				$empData['empno'][]    = $empno;
				$empData['name'][]     = $name;
				$empData['basic'][]    = $basic;
				$empData['ot'][]       = $ot + $advot;
				$empData['cbs'][]      = $bank;
				$empData['ap'][]       = $ap;
				$empData['adv_ot'][]   = $advot;
				$empData['meal'][]     = $meal + $mr;
				$empData['cdac'][]     = $cdac;
				$empData['sinda'][]    = $sinda;
				$empData['mbmf'][]     = $mbmf;
	
				$empData['all'][]   = $all + $ha;
				$empData['bk'][]   = $bk;
				$empData['cpf'][]   = $cpf;
				//$empData['ha'][]   = $ha;
				$empData['lv'][]   = $lv;
				//$empData['mr'][]   = $mr;
				$empData['ml'][]   = $ml;
				//$empData['td'][]   = $td;
				$empData['ul'][]   = $ul + $td;
	
				$empData['others'][]   = $others;
				$empData['total'][]    = $tot;
			}
			if (sizeof($empData['empno']) > 0):
				$extra = new ComputeCPF();
				$gross = 0;
				$amt = 0;
				$xpos = 0;
				$y = 5;
				$x = 13;
				$sdt = $this->GetStartDate($batch);
				$edt = $this->GetEndDate($batch);
				$pdf->addPage('Arial', 10, 'L');
				$pdf->printTCKhooHeader();
				$pdf->printBoldLn( $x,    $xpos++   + $y, 'JOURNAL LISTING  '.$company, 'Arial', 10);
				$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')','Arial', '10' );
				$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
				$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME           ALL       MBMF      BASIC    CBS       SINDA    MEAL         ML          OT         AP         CDAC        CPF  UNPD ALL  UL        OTHERS   TOTAL', 'Arial', 10);
				$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
				$seq = 1;
				$pos = 0;
				//$y = 5;
				//setlocale(LC_MONETARY, 'en_SG');
				$gross = 0;
				$gall = 0;
				$gmbm = 0;
				$gbas = 0;
				$gcbs = 0;
				$gsin = 0;
				$gmea = 0;
				$gml  = 0;
				$got  = 0;
				$gap  = 0;
				$gcda = 0;
				$gcpf = 0;
				$glv  = 0;
				$gul  = 0;
				$goth = 0;
		
				foreach ($empNoList as $kemp=>$vno)
				{
					if ($xpos + $y == 38)
					{
						$xpos = 1;
						$y = 1;
						$pdf->Footer();
						$pdf->addPage('Arial', 10, 'L');
						$pdf->printBoldLn( $x,    $xpos++   + $y, 'JOURNAL LISTING  '.$company, 'Arial', 10);
						$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')','Arial', '10' );
						$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
						$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME           ALL       MBMF      BASIC    CBS       SINDA    MEAL         ML          OT         AP         CDAC        CPF  UNPD ALL  UL        OTHERS   TOTAL', 'Arial', 10);
						$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
					}
					$total = 0;
					$total = $total + $empData['all'][$pos] + $empData['bk'][$pos] +
					$empData['basic'][$pos] + $empData['cbs'][$pos] +
					$empData['meal'][$pos] + $empData['ml'][$pos] + $empData['ot'][$pos] +
					$empData['ap'][$pos] + $empData['cdac'][$pos] + $empData['cpf'][$pos] +
					$empData['lv'][$pos] + $empData['ul'][$pos] + $empData['others'][$pos] +
					$empData['mbmf'][$pos] + $empData['sinda'][$pos];
					// + $empData['ha'][$pos]
		
		
		
					$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
					$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 15) );
					$pdf->printLn( $x+50,   $xpos   + $y, number_format ($empData['all'][$pos], 2));
					$pdf->printLn( $x+65,   $xpos   + $y, number_format ($empData['mbmf'][$pos], 2));
					$pdf->printLn( $x+80,   $xpos   + $y, number_format ($empData['basic'][$pos], 2));
					$pdf->printLn( $x+95,   $xpos   + $y, number_format ($empData['cbs'][$pos], 2));
					$pdf->printLn( $x+110,  $xpos   + $y, number_format ($empData['sinda'][$pos], 2));
					$pdf->printLn( $x+125,  $xpos   + $y, number_format ($empData['meal'][$pos], 2));
					$pdf->printLn( $x+140,  $xpos   + $y, number_format ($empData['ml'][$pos], 2));
					$pdf->printLn( $x+155,  $xpos   + $y, number_format ($empData['ot'][$pos], 2));
					$pdf->printLn( $x+170,  $xpos   + $y, number_format ($empData['ap'][$pos], 2));
					$pdf->printLn( $x+185,  $xpos   + $y, number_format ($empData['cdac'][$pos], 2));
					$pdf->printLn( $x+200,  $xpos   + $y, number_format ($empData['cpf'][$pos], 2));
					$pdf->printLn( $x+215,  $xpos   + $y, number_format ($empData['lv'][$pos], 2));
					$pdf->printLn( $x+230,  $xpos   + $y, number_format ($empData['ul'][$pos], 2));
					$pdf->printLn( $x+245,  $xpos   + $y, number_format ($empData['others'][$pos], 2));
					$pdf->printLn( $x+260,  $xpos   + $y, number_format ($total, 2) );
		
		
					$gross = $gross + $total;
					$gall = $gall  + $empData['all'][$pos];
					$gmbm = $gmbm  + $empData['mbmf'][$pos];
					$gbas = $gbas  + $empData['basic'][$pos];
					$gcbs = $gcbs  + $empData['cbs'][$pos];
					$gsin = $gsin  + $empData['sinda'][$pos];
					$gmea = $gmea  + $empData['meal'][$pos];
					$gml  = $gml   + $empData['ml'][$pos];
					$got  = $got   + $empData['ot'][$pos];
					$gap  = $gap   + $empData['ap'][$pos];
					$gcda = $gcda  + $empData['cdac'][$pos];
					$gcpf = $gcpf  + $empData['cpf'][$pos];
					$glv  = $glv   + $empData['lv'][$pos];
					$gul  = $gul   + $empData['ul'][$pos];
					$goth = $goth  + $empData['others'][$pos];
		
					$xpos ++;
					$pos++;
		
				}
				$pdf->printLn( $x,     $xpos++   + $y, '****************************************************************************************************************************************************************************************************' );
				$pdf->printLn( $x+50,   $xpos   + $y, number_format ($gall, 2));
				$pdf->printLn( $x+65,   $xpos   + $y, number_format ($gmbm, 2));
				$pdf->printLn( $x+80,   $xpos   + $y, number_format ($gbas, 2));
				$pdf->printLn( $x+95,   $xpos   + $y, number_format ($gcbs, 2));
				$pdf->printLn( $x+110,  $xpos   + $y, number_format ($gsin, 2));
				$pdf->printLn( $x+125,  $xpos   + $y, number_format ($gmea, 2));
				$pdf->printLn( $x+140,  $xpos   + $y, number_format ($gml, 2));
				$pdf->printLn( $x+155,  $xpos   + $y, number_format ($got, 2));
				$pdf->printLn( $x+170,  $xpos   + $y, number_format ($gap, 2));
				$pdf->printLn( $x+185,  $xpos   + $y, number_format ($gcda, 2));
				$pdf->printLn( $x+200,  $xpos   + $y, number_format ($gcpf, 2));
				$pdf->printLn( $x+215,  $xpos   + $y, number_format ($glv, 2));
				$pdf->printLn( $x+230,  $xpos   + $y, number_format ($gul, 2));
				$pdf->printLn( $x+245,  $xpos   + $y, number_format ($goth, 2));
				$pdf->printBoldLn( $x+260,  $xpos   + $y, number_format ($gross, 2));
					$pdf->Footer();
		endif; //if sizeofEmpData
		} //foreach company 
		} //foreach bank, cash, check

		//------------------------------ 
		//            CPF REMITTANCES
		//------------------------------
		$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankChequeForLevy($batch);
		//$empData = $this->PopulateCpfData($batch, $empNoList, $mess);
		$empData = HrLib::PopulateCpfData($batch, $empNoList, $mess);
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);

		$gacro = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gmcs  = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gnano = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gtc   = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gmdr  = array('count'=>0, 'wages'=>0, 'em_share'=>0, 'cdac'=>0, 'sinda'=>0, 'mbmf'=>0, 'sdl'=>0, 'ecf'=>0, 'er_share'=>0, 'total'=>0 );
		$gaddlvy = 0;
		$pos = 0;
		//--------------- donor
		$dcda = 0;
		$dsin = 0;
		$dmbm = 0;
		$dsdl = 0;
		$decf = 0;
		
		
		foreach ($empData['company'] as $kemp=>$vno)
		{
			if ($empData['tot_cpf'][$pos] <> 0 ||
			$empData['mbmf'][$pos]    ||
			$empData['sinda'][$pos]   ||
			$empData['ecf'][$pos]   ||
			$empData['cdac'][$pos]    )
			{
				switch($vno)
				{
					case 'Acro Solution':
						$gacro['count']++;
						$gacro['wages'] = $gacro['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gacro['em_share'] = $gacro['em_share'] + $empData['em_share'][$pos];
						$gacro['cdac'] = $gacro['cdac'] + $empData['cdac'][$pos];
						$gacro['sinda'] = $gacro['sinda'] + $empData['sinda'][$pos];
						$gacro['mbmf'] = $gacro['mbmf'] + $empData['mbmf'][$pos];
						$gacro['sdl'] = $gacro['sdl'] + $empData['sdl'][$pos];
						$gacro['ecf'] = $gacro['ecf'] + $empData['ecf'][$pos];
						$gacro['er_share'] = $gacro['er_share'] + $empData['er_share'][$pos];
						$gacro['total'] = $gacro['em_share'] +  $gacro['cdac'] + $gacro['sinda'] + $gacro['mbmf'] + $gacro['sdl']+ $gacro['er_share'];
						break;
					case 'Micronclean':
						$gmcs['count']++;
						$gmcs['wages'] = $gmcs['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gmcs['em_share'] = $gmcs['em_share'] + $empData['em_share'][$pos];
						$gmcs['cdac'] = $gmcs['cdac'] + $empData['cdac'][$pos];
						$gmcs['sinda'] = $gmcs['sinda'] + $empData['sinda'][$pos];
						$gmcs['mbmf'] = $gmcs['mbmf'] + $empData['mbmf'][$pos];
						$gmcs['sdl'] = $gmcs['sdl'] + $empData['sdl'][$pos];
						$gmcs['ecf'] = $gmcs['ecf'] + $empData['ecf'][$pos];
						$gmcs['er_share'] = $gmcs['er_share'] + $empData['er_share'][$pos];
						$gmcs['total'] = $gmcs['em_share'] +  $gmcs['cdac'] + $gmcs['sinda'] + $gmcs['mbmf'] + $gmcs['sdl']+ $gmcs['er_share'];
						break;
					case 'NanoClean':
						$gnano['count']++;
						$gnano['wages'] = $gnano['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gnano['em_share'] = $gnano['em_share'] + $empData['em_share'][$pos];
						$gnano['cdac'] = $gnano['cdac'] + $empData['cdac'][$pos];
						$gnano['sinda'] = $gnano['sinda'] + $empData['sinda'][$pos];
						$gnano['mbmf'] = $gnano['mbmf'] + $empData['mbmf'][$pos];
						$gnano['sdl'] = $gnano['sdl'] + $empData['sdl'][$pos];
						$gnano['ecf'] = $gnano['ecf'] + $empData['ecf'][$pos];
						$gnano['er_share'] = $gnano['er_share'] + $empData['er_share'][$pos];
						$gnano['total'] = $gnano['em_share'] +  $gnano['cdac'] + $gnano['sinda'] + $gnano['mbmf'] + $gnano['sdl']+ $gnano['er_share'];
						break;
					case 'T.C. Khoo':
						$gtc['count']++;
						$gtc['wages'] = $gtc['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gtc['em_share'] = $gtc['em_share'] + $empData['em_share'][$pos];
						$gtc['cdac'] = $gtc['cdac'] + $empData['cdac'][$pos];
						$gtc['sinda'] = $gtc['sinda'] + $empData['sinda'][$pos];
						$gtc['mbmf'] = $gtc['mbmf'] + $empData['mbmf'][$pos];
						$gtc['sdl'] = $gtc['sdl'] + $empData['sdl'][$pos];
						$gtc['ecf'] = $gtc['ecf'] + $empData['ecf'][$pos];
						$gtc['er_share'] = $gtc['er_share'] + $empData['er_share'][$pos];
						$gtc['total'] = $gtc['em_share'] +  $gtc['cdac'] + $gtc['sinda'] + $gtc['mbmf'] + $gtc['sdl']+ $gtc['er_share'];
						break;
					case 'micronDR':
						$gmdr['count']++;
						$gmdr['wages'] = $gmdr['wages'] + $empData['wage'][$pos] + $empData['additional'][$pos];
						$gmdr['em_share'] = $gmdr['em_share'] + $empData['em_share'][$pos];
						$gmdr['cdac'] = $gmdr['cdac'] + $empData['cdac'][$pos];
						$gmdr['sinda'] = $gmdr['sinda'] + $empData['sinda'][$pos];
						$gmdr['mbmf'] = $gmdr['mbmf'] + $empData['mbmf'][$pos];
						$gmdr['sdl'] = $gmdr['sdl'] + $empData['sdl'][$pos];
						$gmdr['ecf'] = $gmdr['ecf'] + $empData['ecf'][$pos];
						$gmdr['er_share'] = $gmdr['er_share'] + $empData['er_share'][$pos];
						$gmdr['total'] = $gmdr['em_share'] +  $gmdr['cdac'] + $gmdr['sinda'] + $gmdr['mbmf'] + $gmdr['sdl']+ $gmdr['er_share'];
						break;
						
				}
				$dcda = $dcda + (($empData['cdac'][$pos])  ? 1 : 0 );
				$dmbm = $dmbm + (($empData['mbmf'][$pos])  ? 1 : 0 );
				$dsdl = $dsdl + (($empData['sdl'][$pos])   ? 1 : 0 );
				$dsin = $dsin + (($empData['sinda'][$pos]) ? 1 : 0 );
				$decf = $decf + (($empData['ecf'][$pos]) ? 1 : 0 );
//				if ($empData['ecf'][$pos]):
//					echo $empData['empno'][$pos] .' - '. $empData['name'][$pos] .' - '. $empData['ecf'][$pos] .' ('.$decf.')' . '<br>';
//				endif;
			}

			//-------------------------- levy
			if ($empData['islevy'][$pos])
			{
				$gaddlvy = $gaddlvy + ($empData['sdl'][$pos]);
			}

			$pos++;

		}
		//--------------- front page summary
		$fgwage = $gacro['wages'] + $gmcs['wages'] + $gnano['wages'] + $gtc['wages'] + $gmdr['wages'];
		$fgem   = $gacro['em_share'] + $gmcs['em_share'] + $gnano['em_share'] + $gtc['em_share'] + $gmdr['em_share'];
		$fgcd   = $gacro['cdac'] + $gmcs['cdac'] + $gnano['cdac'] + $gtc['cdac'] + $gmdr['cdac'];
		$fgsi   = $gacro['sinda'] + $gmcs['sinda'] + $gnano['sinda'] + $gtc['sinda'] + $gmdr['sinda'];
		$fgmb   = $gacro['mbmf'] + $gmcs['mbmf'] + $gnano['mbmf'] + $gtc['mbmf'] + $gmdr['mbmf'];
		$fecf   = $gacro['ecf'] + $gmcs['ecf'] + $gnano['ecf'] + $gtc['ecf'] + $gmdr['ecf'];
		$fgsd   = intval($gacro['sdl'] + $gmcs['sdl'] + $gnano['sdl'] + $gtc['sdl'] + $gmdr['sdl']);
		$fger   = $gacro['er_share'] + $gmcs['er_share'] + $gnano['er_share'] + $gtc['er_share'] + $gmdr['er_share'];
		$fgto   = $fgem + $fgcd + $fgsi + $fgmb + $fgsd + $fger;
		$gaddlvy = intval($gaddlvy);
		
		$pdf->addPage('Arial', 10, 'L');
		$pdf->printTCKhooHeader();
		//setlocale(LC_MONETARY, 'en_US');
		$y = 5;
		$x = 13;
		$xpos = 0;

		$pdf->printBoldLn( $x,    $xpos++   + $y, 'PAYROLL :  CPF CONTRIBUTION', 'Arial', 10);
		$y+=2;
		$pdf->printBoldLn( $x+100,    $xpos++ + $y, 'Payroll Period: '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt), 'Arial', 12);
		$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                            COMPANY                                 #EMP             SUBCON         EE-SHARE           CDAC          SINDA         MBMF            SDL          ER-SHARE       TOTAL', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$seq = 1;
		$pdf->printLn( $x+20, $xpos      + $y,'ACRO SOLUTIONS', 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, $gacro['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y, money_format('%(#8n', $gacro['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $gacro['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $gacro['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $gacro['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $gacro['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $gacro['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $gacro['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $gacro['total']), 'Arial', 10) ;
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+20, $xpos      + $y,'MICRONCLEAN', 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, $gmcs['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y, money_format('%(#8n', $gmcs['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $gmcs['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $gmcs['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $gmcs['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $gmcs['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $gmcs['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $gmcs['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $gmcs['total']), 'Arial', 10) ;
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+20, $xpos      + $y,'NANOCLEAN', 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, $gnano['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y, money_format('%(#8n', $gnano['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $gnano['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $gnano['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $gnano['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $gnano['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $gnano['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $gnano['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $gnano['total']), 'Arial', 10) ;
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+20, $xpos      + $y,'T.C. KHOO', 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, $gtc['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y, money_format('%(#8n', $gtc['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $gtc['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $gtc['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $gtc['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $gtc['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $gtc['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $gtc['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $gtc['total']), 'Arial', 10) ;
		
		$pdf->printLn( $x+15,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+20, $xpos      + $y,'MICRON DR', 'Arial', 10) ;
		$pdf->printLn( $x+80, $xpos      + $y, $gmdr['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y, money_format('%(#8n', $gmdr['wages']), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $gmdr['em_share']), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $gmdr['cdac']), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $gmdr['sinda']), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $gmdr['mbmf']), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $gmdr['sdl']), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $gmdr['er_share']), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $gmdr['total']), 'Arial', 10) ;
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		
		$pdf->printLn( $x+80, $xpos      + $y, $gacro['count'] + $gmcs['count'] + $gnano['count'] + $gtc['count'] + $gmdr['count'], 'Arial', 10) ;
		$pdf->printLn( $x+95, $xpos      + $y,  money_format('%(#8n', $fgwage), 'Arial', 10) ;
		$pdf->printLn( $x+118, $xpos      + $y, money_format('%(#8n', $fgem), 'Arial', 10) ;
		$pdf->printLn( $x+143, $xpos      + $y, money_format('%(#8n', $fgcd), 'Arial', 10) ;
		$pdf->printLn( $x+163, $xpos      + $y, money_format('%(#8n', $fgsi), 'Arial', 10) ;
		$pdf->printLn( $x+184, $xpos      + $y, money_format('%(#8n', $fgmb), 'Arial', 10) ;
		$pdf->printLn( $x+205, $xpos      + $y, money_format('%(#8n', $fgsd), 'Arial', 10) ;
		$pdf->printLn( $x+225, $xpos      + $y, money_format('%(#8n', $fger), 'Arial', 10) ;
		$pdf->printLn( $x+248, $xpos++      + $y, money_format('%(#8n', $fgto), 'Arial', 10) ;
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		
		setlocale(LC_MONETARY, 'en_US');
		$xpos+=3;
		$penalty = $penalty? $penalty : 0.0;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total CPF Contributions', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++    + $y,  money_format('%(#8n', ($fgem + $fger)), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'CPF Late Payment Interest', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', $penalty), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Foreign Worker Levy', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', 0.0), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'FWL Late Payment Interest', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', 0.0), 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Skills Development Levy (SDL)                               +                              = ', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgsd), 'Arial', 10) ;
		//$gaddlvy = 374;
		$pdf->printLn( $x+135,$xpos       + $y, money_format('%(#8n', $gaddlvy) , 'Arial', 10) ;
		$pdf->printBoldLn( $x+170,$xpos++     + $y, money_format('%(#8n', $fgsd + $gaddlvy), 'Arial', 10) ;
		//$pdf->printBoldLn( $x+170,$xpos++     + $y, money_format('%(#8n', $fgsd + $gaddlvy +13 ) . '   +  ( $13 jun month )', 'Arial', 10) ;
		//$gaddlvy = $gaddlvy + 13 ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Donation to Community                                                      Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', 0.0), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, 0, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total MBMF Contributions                                                  Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgmb), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $dmbm, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total SINDA Contributions                                                  Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgsi), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $dsin, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total CDAC Contributions                                                   Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fgcd), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $dcda, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'Total ECF Contributions                                                      Donor Count', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos       + $y, money_format('%(#8n', $fecf), 'Arial', 10) ;
		$pdf->printLn( $x+170,$xpos++     + $y, $decf, 'Arial', 10) ;
		$pdf->printLn( $x+50, $xpos       + $y, 'SDL Rounding Error', 'Arial', 10) ;
		$pdf->printLn( $x+105,$xpos++     + $y, money_format('%(#8n', $roundErr), 'Arial', 10) ;
		//$pdf->printLn( $x+170,$xpos++     + $y, 0, 'Arial', 10) ;
		$pdf->printBoldLn( $x+50, $xpos       + $y, 'Grand Total', 'Arial', 10) ;
		$pdf->printBoldLn( $x+105,$xpos++     + $y, money_format('%(#8n', ($fgto + $gaddlvy + $penalty + $roundErr + $fecf) ), 'Arial', 10) ;
		$pdf->Footer();
		
// 		$this->var_dump(sfConfig::get('compGroup'));
// 		exit();
		
		foreach (sfConfig::get('compGroup') as $kcomp=>$cComp)
		{
			$gross = 0;
			$gwage = 0;
			$gemsh = 0;
			$gcdac = 0;
			$gsinda= 0;
			$gmbmf = 0;
			$gsdl  = 0;
			$gersh = 0;

			$xpos =  0;
			$pos = 0;
			$cntr = 0;
			$gbank  = 0;
			$gcash  = 0;
			$gdinner= 0;
			$seq = 1;
			foreach ($empData['company'] as $rec)
			{
				if ($xpos >= 38 || $xpos == 0)
				{
					$pdf->addPage('Arial', 10, 'L');
					//$pdf->printTCKhooHeader();
					$x = 13;
					$y = 2;
					$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
					$xpos = 0;
					$pdf->printBoldLn( $x,    $xpos++   + $y, $cComp.' - CPF Contribution', 'Arial', 10);
					$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
					$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
					$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME                              COMPANY                  PAYROLL        EE-SHARE           CDAC          SINDA         MBMF            SDL          ER-SHARE    TOTAL', 'Arial', 10);
					$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
				}
				//echo $cComp .' - '. $rec . '<br>';

				if ( ($cComp == $rec) )
				{
					if ($empData['tot_cpf'][$pos] <> 0  ||
					$empData['mbmf'][$pos]    ||
					$empData['sinda'][$pos]   ||
					$empData['cdac'][$pos]    )
					{
						//$pdf->printLn ($x, $xpos + $y, $pos+1 .'. '. $empData['name'][$pos] .'  wages: '. $empData['wages'][$pos] .'  salary: '. $empData['salary'][$pos] .' = '. ($empData['wages'][$pos] + $empData['salary'][$pos]) );
						$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
						$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 38) );
						$pdf->printLn( $x+70,   $xpos   + $y, $empData['company'][$pos] );
						$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $empData['wage'][$pos] + $empData['additional'][$pos] )); //kebot
						$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $empData['em_share'][$pos]));
						$pdf->printLn( $x+150,  $xpos   + $y, money_format('%(#6n', $empData['cdac'][$pos]) );
						$pdf->printLn( $x+170,  $xpos   + $y, money_format('%(#6n', $empData['sinda'][$pos]) );
						$pdf->printLn( $x+190,  $xpos   + $y, money_format('%(#6n', $empData['mbmf'][$pos]) );
						$pdf->printLn( $x+210,  $xpos    + $y, money_format('%(#6n',$empData['sdl'][$pos] ) );
						$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos]));
						$pdf->printLn( $x+250,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos] + $empData['cdac'][$pos] + $empData['sinda'][$pos] + $empData['mbmf'][$pos] + $empData['em_share'][$pos] + $empData['sdl'][$pos]));
						$xpos ++;

						$gwage = $gwage +  $empData['wage'][$pos] + $empData['additional'][$pos];
						$gemsh = $gemsh +  $empData['em_share'][$pos];
						$gcdac = $gcdac +  $empData['cdac'][$pos];
						$gsinda= $gsinda + $empData['sinda'][$pos];
						$gmbmf = $gmbmf  + $empData['mbmf'][$pos];
						$gsdl  = $gsdl   + $empData['sdl'][$pos];
						$gersh = $gersh  + $empData['er_share'][$pos];

						$gross = $gemsh + $gcdac + $gsinda + $gmbmf + $gsdl + $gersh;
					}
				}
				$pos++;
			}

			$pdf->printLn( $x,     $xpos++   + $y, '****************************************************************************************************************************************************************************************************' );
			$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $gwage));
			$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $gemsh));
			$pdf->printLn( $x+150,  $xpos   + $y, money_format('%(#6n', $gcdac) );
			$pdf->printLn( $x+170,  $xpos   + $y, money_format('%(#6n', $gsinda) );
			$pdf->printLn( $x+190,  $xpos   + $y, money_format('%(#6n', $gmbmf) );
			//$pdf->printLn( $x+210,  $xpos    + $y, '$  '.$xsdl); //money_format('%(#6n',$xsdl ) );
			$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $gersh));
			$pdf->printLn( $x+250,  $xpos + $y, money_format('%(#6n', $gross));
			$pdf->printLn( $x+210,  $xpos++    + $y, money_format('%(#6n',$gsdl ) );

		}
		
		//christina boss and ladyboss only
		{
			$gross = 0;
			$gwage = 0;
			$gemsh = 0;
			$gcdac = 0;
			$gsinda= 0;
			$gmbmf = 0;
			$gsdl  = 0;
			$gersh = 0;
		
			$xpos =  0;
			$pos = 0;
			$cntr = 0;
			$gbank  = 0;
			$gcash  = 0;
			$gdinner= 0;
			$seq = 1;
			$employeeName = array('ANG LUCY', 'CHEN SAU NGEN', 'CHRISTINA CHAI HUI LING');
			foreach ($empData['company'] as $rec)
			{
				if ($xpos >= 38 || $xpos == 0)
				{
					$pdf->addPage('Arial', 10, 'L');
					//$pdf->printTCKhooHeader();
					$x = 13;
					$y = 2;
					$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
					$xpos = 0;
					$pdf->printBoldLn( $x,    $xpos++   + $y, 'Directors - CPF Contribution', 'Arial', 10);
					$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
					$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
					$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME                              COMPANY                  PAYROLL        EE-SHARE           CDAC          SINDA         MBMF            SDL          ER-SHARE    TOTAL', 'Arial', 10);
					$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
				}
				//echo $cComp .' - '. $rec . '<br>';
		
				if ( in_array($empData['name'][$pos], $employeeName) )
				{
					if ($empData['tot_cpf'][$pos] <> 0  ||
							$empData['mbmf'][$pos]    ||
							$empData['sinda'][$pos]   ||
							$empData['cdac'][$pos]    )
					{
						//$pdf->printLn ($x, $xpos + $y, $pos+1 .'. '. $empData['name'][$pos] .'  wages: '. $empData['wages'][$pos] .'  salary: '. $empData['salary'][$pos] .' = '. ($empData['wages'][$pos] + $empData['salary'][$pos]) );
						$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
						$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 38) );
						$pdf->printLn( $x+70,   $xpos   + $y, $empData['company'][$pos] );
						$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $empData['wage'][$pos] + $empData['additional'][$pos] )); //kebot
						$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $empData['em_share'][$pos]));
						$pdf->printLn( $x+150,  $xpos   + $y, money_format('%(#6n', $empData['cdac'][$pos]) );
						$pdf->printLn( $x+170,  $xpos   + $y, money_format('%(#6n', $empData['sinda'][$pos]) );
						$pdf->printLn( $x+190,  $xpos   + $y, money_format('%(#6n', $empData['mbmf'][$pos]) );
						$pdf->printLn( $x+210,  $xpos    + $y, money_format('%(#6n',$empData['sdl'][$pos] ) );
						$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos]));
						$pdf->printLn( $x+250,  $xpos   + $y, money_format('%(#6n', $empData['er_share'][$pos] + $empData['cdac'][$pos] + $empData['sinda'][$pos] + $empData['mbmf'][$pos] + $empData['em_share'][$pos] + $empData['sdl'][$pos]));
						$xpos ++;
		
						$gwage = $gwage +  $empData['wage'][$pos] + $empData['additional'][$pos];
						$gemsh = $gemsh +  $empData['em_share'][$pos];
						$gcdac = $gcdac +  $empData['cdac'][$pos];
						$gsinda= $gsinda + $empData['sinda'][$pos];
						$gmbmf = $gmbmf  + $empData['mbmf'][$pos];
						$gsdl  = $gsdl   + $empData['sdl'][$pos];
						$gersh = $gersh  + $empData['er_share'][$pos];
		
						$gross = $gemsh + $gcdac + $gsinda + $gmbmf + $gsdl + $gersh;
					}
				}
				$pos++;
			}
		
			$pdf->printLn( $x,     $xpos++   + $y, '****************************************************************************************************************************************************************************************************' );
			$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $gwage));
			$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $gemsh));
			$pdf->printLn( $x+150,  $xpos   + $y, money_format('%(#6n', $gcdac) );
			$pdf->printLn( $x+170,  $xpos   + $y, money_format('%(#6n', $gsinda) );
			$pdf->printLn( $x+190,  $xpos   + $y, money_format('%(#6n', $gmbmf) );
			//$pdf->printLn( $x+210,  $xpos    + $y, '$  '.$xsdl); //money_format('%(#6n',$xsdl ) );
			$pdf->printLn( $x+230,  $xpos   + $y, money_format('%(#6n', $gersh));
			$pdf->printLn( $x+250,  $xpos + $y, money_format('%(#6n', $gross));
			$pdf->printLn( $x+210,  $xpos++    + $y, money_format('%(#6n',$gsdl ) );
		
		}
		//end christina boss and ladyboss only
		
		foreach (sfConfig::get('compGroup') as $kcomp=>$cComp)
		{
			$gross = 0;
			$gwage = 0;
			$gemsh = 0;
			$gcdac = 0;
			$gsinda= 0;
			$gmbmf = 0;
			$gsdl  = 0;
			$gersh = 0;

			$xpos =  0;
			$pos = 0;
			$cntr = 0;
			$gbank  = 0;
			$gcash  = 0;
			$gdinner= 0;
			$seq = 1;
			foreach ($empData['company'] as $rec)
			{

				if ( ($cComp == $rec) )
				{	
					if ( ($xpos >= 55 || $xpos == 0) && ($empData['islevy'][$pos] <> 0 ) )
					{
						$pdf->addPage('Arial', 10);
						//$pdf->printTCKhooHeader();
						$x = 13;
						$y = 2;
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printBoldLn( $x,    $xpos++   + $y, $cComp.' - SDL Contribution', 'Arial', 10);
						$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
						$pdf->printLn( $x,       $xpos++   + $y, '========================================================================================');
						$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME                              COMPANY                  WAGES           				SDL', 'Arial', 10);
						$pdf->printLn( $x,       $xpos++   + $y, '========================================================================================' );
					}
				
					if  ($empData['islevy'][$pos] <> 0   ) //(PayEmployeeLevyPeer::CheckEmployeePeriod($empData['empno'][$pos], $batch) ) //($empData['islevy'][$pos] <> 0   ) // ( substr($empData['empno'][$pos], 0,1) <> 'S') //(PayEmployeeLevyPeer::CheckEmployeePeriod($empData['empno'][$pos], $batch) ) //($empData['islevy'][$pos] <> 0   )
					{
						$pdf->printLn( $x,      $xpos   + $y, $seq++.'.');
						$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 38) );
						$pdf->printLn( $x+70,   $xpos   + $y, $empData['company'][$pos] );
						$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $empData['grossInc'][$pos]));
						$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $empData['sdl'][$pos]));
						//$pdf->printLn( $x+140,   $xpos   + $y, substr($empData['empno'][$pos], 0, 38) );
						$xpos ++;

						$gwage = $gwage +  $empData['grossInc'][$pos];
						$gsdl  = $gsdl   + $empData['sdl'][$pos];


					}
				}
				$pos++;
			}
			$pdf->printLn( $x,     $xpos++   + $y, '***********************************************************************************************************************************' );
			$pdf->printLn( $x+100,  $xpos   + $y, money_format('%(#6n', $gwage));
			$pdf->printLn( $x+125,  $xpos   + $y, money_format('%(#6n', $gsdl));
		}

		//------------------------------ 
		//            levy Contribution
		//------------------------------
		$period = $batch;
		$dataList = PayEmployeeLevyPeer::GetDataByPeriod($period);
		$y = 7;
		$x = 13;
		$xpos = 0;
		$wt = 0;
		//$pdf->printTCHeader();
		$sdt    = $this->GetStartDate($period);
		$edt    = $this->GetEndDate($period);
		$mess = 'test';
		//------------------------------------------------------------- per company
		foreach (sfConfig::get('compGroup')  as $cGroup)
		{
			$pos = 0;
			$xpos = 0;
			$lr = 0;
			$ld = 0;
			$tot = 0;
			$cntr = 0;
			foreach ($dataList as $r)
			{
				if ( ($r->getCompany() == $cGroup ))
				{
					if ($xpos == 54 || $xpos == 0)
					{
						$x = 13;
						$y = 2;
						$pdf->addPage();
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printLn( $x,    $xpos++   + $y, DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$cGroup.' LEVY CONTRIBUTION)', 'Arial', 10);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
						$pdf->printLn( $x,     $xpos++   + $y, 'SEQ #               NAME                          COMPANY            LEVY RATE      LEVY DED     AMOUNT', 'Arial', 11);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
						//$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
					}
					$pdf->printLn( $x+2,     $xpos   + $y, $cntr+1 .'. ', 'Arial', 10);
					$pdf->printLn( $x+12,     $xpos   + $y, $r->getName(), 'Arial', 10);
					$pdf->printLn( $x+70,     $xpos   + $y, $r->getCompany(), 'Arial', 10);
					$pdf->printLn( $x+100,     $xpos   + $y, money_format('%(#8n', $r->getLevyRate()), 'Arial', 10);
					$pdf->printLn( $x+125,     $xpos   + $y, money_format('%(#8n', $r->getLevyDed()), 'Arial', 10);
					$pdf->printLn( $x+150,     $xpos   + $y, money_format('%(#8n', $r->getLevyRate() - $r->getLevyDed()), 'Arial', 10);
					$lr  += $r->getLevyRate();
					$ld  += $r->getLevyDed();
					$tot += ($r->getLevyRate() - $r->getLevyDed());
					$cntr++;
					$xpos++;
				}
				$pos++;
			}
			if ($tot){
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
				$pdf->printLn( $x+70,     $xpos   + $y, 'Total', 'Arial', 10);
				$pdf->printLn( $x+100,     $xpos   + $y, money_format('%(#8n', $lr), 'Arial', 10);
				$pdf->printLn( $x+125,     $xpos   + $y, money_format('%(#8n', $ld), 'Arial', 10);
				$pdf->printLn( $x+150,     $xpos   + $y, money_format('%(#8n',  $tot), 'Arial', 10);
			}
		}
		$pdf->closePDF('testing.pdf');
		return;
		
	}
	
	public function executeCreateTaxTxtFile()
	{
//		$id =  $this->_G('id');
//		$pg =  $this->_G('page');
//		$pcode = $this->_G('perio');
//		$sdt = $this->GetStartDate($pcode);
//		DateUtils::DUFormat('Y', '2014-01-01');
//		var_dump($this->_G('year'));
//		exit();
		$hdr = ContribCompanyIr8aPeer::GetInfo();
		if (!$hdr){
			$this->_ERF('Header Detail Not Found, Table: Contrib_Company_Ir8a');
			$this->redirect('report/yearlyTax');
		}
		$context = ContribEmployeeIr8aPeer::GenerateTextFile($this->_G('year'), $hdr);

		$filename = "IR8A ( DECEMBER".$this->_G('year').' SUBMISSION ).txt';

		header('Content-type: application/txt');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		foreach($context as $km=>$vm)
		{
			echo str_replace('_',' ',  $vm) . "\r\n" ;
		}

		exit();
	}
	
	
	
	public function executeIrasMonthlyDelete()
	{
		$id = $this->_G('id');
		$this->record = ContribEmployeeIr8aPeer::retrieveByPK($id);
		if ($this->record){
			$empNo = $this->record->getEmployeeNo();
			$batch = $this->record->getPeriodCode();
			$rec = $this->record->getName().' - ' .'( ' . $this->record->getAmount() .' )';
			$this->record->delete();
			$this->_SUF($rec.' has been deleted successfuly.');
		}
		$this->redirect('report/irasMonthlyPreview?period_code=' . $batch);
	}
	
	public function PrintBankTransmittal($batch, $docdate, $depdate, $to, $attn, $from, $mess, $acctNo)
	{

		//$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($batch, $empNo);
		$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBank($batch);
		//$empNoList = array('S7863014J');
		$pdf = new PdfLibrary();
		$x = 0;
		$y = 0;

		$pdf->addPage();
		$xpos = 2;

		//$pdf->image('/web/images/hr/mclogo.jpg', $x, $y);
		//        $pdf->printHeader();
		$y = 5;
		$x = 13;
		$gross = 0;
		$amt = 0;
		//        $pdf->addPage('Arial', 10);
		$pdf->printLn( $x,    $xpos   + $y, 'TO         : '.$to, 'Arial', 10);
		$pdf->printLn( $x+100,    $xpos++ + $y, 'DATE    : ' . $docdate );
		//$pdf->printLn( $x,    $xpos++   + $y, 'ATTN    : '.$attn);
		$pdf->printLn( $x,    $xpos++   + $y, 'FROM   : '.$from);
		$xpos+=2;
		$pdf->printLn( $x+10,    $xpos++   + $y, $mess, 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                                         ACCOUNT #                          ACTUAL PAY', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
		$seq = 1;
		setlocale(LC_MONETARY, 'en_US');
		foreach ($empNoList as $kemp=>$vno)
		{
			if ( $xpos == 46 )
			{
				$pdf->printLn( $x,     $xpos++   + $y, '*****************************************************************************************************************************' );
				$pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
				$pdf->addPage('Arial', 10);
				//                $xpos = -2;
				$xpos = 2;
				//                $x = 16;
				$pdf->printLn( $x,    $xpos   + $y, 'TO         : '.$to, 'Arial', 10);
				$pdf->printLn( $x+100,    $xpos++ + $y, 'DATE    : '.$docdate );
				//$pdf->printLn( $x,    $xpos++   + $y, 'ATTN    : '.$attn);
				$pdf->printLn( $x,    $xpos++   + $y, 'FROM   : '.$from);
				$xpos+=2;
				$pdf->printLn( $x+10,    $xpos++   + $y, $mess, 'Arial', 10);
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
				$pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                                         ACCOUNT #                          ACTUAL PAY', 'Arial', 10);
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );

				//                $pdf->printLn( $x,     $xpos++   + $y, '*****************************************************************************************************************************' );
			}else{
				$pdf->setMyFont('Arial', '', 10);
			}
			$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($batch, $vno);
			$empInfo = HrEmployeePeer::GetDatabyEmployeeNo($vno);
			$amt = 0;
			$fntsize = 12;
			foreach($data as $rec)
			{
				$amt  = $amt + $rec->getAmount();
			}
					
//				if ($rec->getEmployeeNo() == '07368854-180110'):
//					var_dump($amt);
//					exit();
//				endif;
			
			$amt = ($amt > 0) ? $amt : 0;
			if ($amt > 0 )
			{

				if ($vno == '' || $vno == '')
				{
					$pdf->printLn( $x,     $xpos   + $y, $seq++.'.');
					$pdf->printLn( $x+10,  $xpos   + $y, 'LUCY ANG');
					$pdf->printLn( $x+100, $xpos   + $y, '0410-094999-8');
					$pdf->printLn( $x+145, $xpos++   + $y, money_format('%=*#8.2n', $amt) );
				}else{
					if (strlen($rec->getName()) > 30) $fntsize = 8;
					//$pdf->printLn( $x,     $xpos-5   + $y, $fntsize);
					$pdf->printLn( $x,     $xpos   + $y, $seq++.'.');
					$pdf->printLn( $x+10,  $xpos   + $y, $rec->getName(), 'Arial', $fntsize);
					$pdf->printLn( $x+100, $xpos   + $y, (($empInfo)? $empInfo->getAcctNo():'Data Unavailable' ));
					$pdf->printLn( $x+145, $xpos++   + $y, money_format('%=*#8.2n', $amt) );
				}
				$gross = $amt + $gross;
			}
		}
		$pdf->printLn( $x,     $xpos++   + $y, '*****************************************************************************************************************************' );
		$pdf->printBoldLn( $x+120, $xpos++   + $y, 'TOTAL:   '.money_format('%=*(#8.2n', $gross), 'Arial', 12 );
		$xpos+=2;
		$pdf->printLn( $x,     $xpos++   + $y, 'PLEASE DEBIT FROM OUR ACCOUNT NO.             '.$acctNo.'     TO CREDIT' );
		$pdf->printLn( $x,     $xpos++   + $y, 'TO THE ABOVE STAFF ACCOUNT NUMBER ON     '.$depdate );
		$xpos++;
		$pdf->printLn( $x,     $xpos++   + $y,  'Thank you.' );
		$pdf->printLn( $x,     $xpos+=2   + $y, 'YOURS FAITHFULLY,' );
		$pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
		$pdf->closePDF('testing.pdf','', true);
		return sfView::NONE;
	}
	
	public function PrintCashWithdrawal($batch)
	{
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);
		$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCash($batch);
		$pdf = new PdfLibrary();
		$x = 13;
		$y = 0;
		$xpos =5;
		$empData = array('empno'=>array(), 'name'=>array(), 'company'=>array(), '50'=>array(), '10'=>array(), '2'=>array(), '1'=>array(), 'total'=>array());
		$acr50 = 0;
		$acr10 = 0;
		$acr2  = 0;
		$acr1  = 0;
		$acramt= 0;

		$mcs50 = 0;
		$mcs10 = 0;
		$mcs2  = 0;
		$mcs1  = 0;
		$mcsamt= 0;

		$nan50 = 0;
		$nan10 = 0;
		$nan2  = 0;
		$nan1  = 0;
		$nanamt= 0;

		$tck50 = 0;
		$tck10 = 0;
		$tck2  = 0;
		$tck1  = 0;
		$tckamt= 0;

		$oth50 = 0;
		$oth10 = 0;
		$oth2  = 0;
		$oth1  = 0;
		$othamt= 0;

		$gr50 = 0;
		$gr10 = 0;
		$gr2  = 0;
		$gr1  = 0;
		$gramt= 0;
		$gcnt = 0;

		$acnt = 0;
		$mcnt = 0;
		$ncnt = 0;
		$tcnt = 0;
		$ocnt = 0;

		foreach($empNoList as $ke=>$empNo)
		{
			$amt = 0;
			$name = '';
			$comp = '';
			$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCash($batch, $empNo);
			foreach($data as $rec)
			{
				$amt  = $amt + $rec->getAmount();
				$name = $rec->getName();
				$comp = $rec->getCompany();
			}
			$fifty = $this->FiftyDenomination($amt);
			$ten   = $this->TenDenomination($amt - ($fifty * 50) );
			$two   = $this->TwoDenomination($amt - ($fifty * 50) - ($ten * 10) );
			$one   = $this->OneDenomination($amt - ($fifty * 50) - ($ten * 10) - ($two * 2));
			$gr50 = $gr50 + $fifty;
			$gr10 = $gr10 + $ten;
			$gr2  = $gr2 + $two;
			$gr1  = $gr1 + $one;
			$gramt= $gramt + $amt;
			$gcnt ++;
			switch(strtolower($comp))
			{
				case 'acro solution':
					$acr50 = $acr50 + $fifty;
					$acr10 = $acr10 + $ten;
					$acr2  = $acr2  + $two;
					$acr1  = $acr1  + $one;
					$acramt = $acramt + $amt;
					$acnt ++;
					break;
				case 'micronclean':
					$mcs50 = $mcs50 + $fifty;
					$mcs10 = $mcs10 + $ten;
					$mcs2  = $mcs2  + $two;
					$mcs1  = $mcs1  + $one;
					$mcsamt = $mcsamt + $amt;
					$mcnt ++;
					break;
				case 'nanoclean':
					$nan50 = $nan50 + $fifty;
					$nan10 = $nan10 + $ten;
					$nan2  = $nan2  + $two;
					$nan1  = $nan1  + $one;
					$nanamt = $nanamt + $amt;
					$ncnt ++;
					break;
				case 't.c. khoo':
					$tck50 = $tck50 + $fifty;
					$tck10 = $tck10 + $ten;
					$tck2  = $tck2  + $two;
					$tck1  = $tck1  + $one;
					$tckamt = $tckamt + $amt;
					$tcnt ++;
					break;
				default:
					$oth50 = $oth50 + $fifty;
					$oth10 = $oth10 + $ten;
					$oth2  = $oth2  + $two;
					$oth1  = $oth1  + $one;
					$othamt = $othamt + $amt;
					$ocnt ++;
					break;
			}
			$empData['empno'][] = $empNo;
			$empData['name'][]  = $name;
			$empData['company'][] = $comp;
			$empData['50'][]    = $fifty;
			$empData['10'][]    = $ten;
			$empData['2'][]     = $two;
			$empData['1'][]     = $one;
			$empData['total'][] = $amt;
		}
		setlocale(LC_MONETARY, 'en_US');
		$pdf->addPage();
		$pdf->printTCKhooHeader();
		$pdf->printBoldLn( $x,    $xpos++   + $y, 'Cash Withdrawal', 'Arial', 10);
		$pdf->printLn( $x,        $xpos++   + $y, 'T.C. KHOO & CO. (PTE) LTD.');
		$y++;
		$pdf->printBoldLn( $x+40,    $xpos++ + $y, 'CASH WITHDRAWAL '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt), 'Arial', 12);
		$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
		$y++;
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                             COMPANY             #EMP           $ 50              $ 10            $ 2               $ 1                  AMOUNT', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
		$seq = 1;
		$pdf->printLn( $x+15, $xpos   + $y, '        ACRO SOLUTION ', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $acnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $acr50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $acr10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $acr2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $acr1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos   + $y, money_format('%(#6n', $acramt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+16, $xpos   + $y, '          MICRONCLEAN', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $mcnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $mcs50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $mcs10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $mcs2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $mcs1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos  + $y, money_format('%(#6n', $mcsamt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+18, $xpos   + $y, '            NANOCLEAN', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $ncnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $nan50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $nan10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $nan2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $nan1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos  + $y, money_format('%(#6n', $nanamt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+21, $xpos   + $y, '             T.C.KHOO', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $tcnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $tck50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $tck10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $tck2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $tck1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos  + $y, money_format('%(#6n', $tckamt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+22, $xpos   + $y, '              OTHERS', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $ocnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $oth50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $oth10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $oth2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $oth1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos   + $y, money_format('%(#6n', $othamt), 'Arial', 10);
		$xpos++;


		$pdf->printLn( $x, $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
		$pdf->printLn( $x+38, $xpos  + $y, 'TOTAL' );
		$pdf->printLn( $x+62, $xpos   + $y,  $gcnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $gr50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $gr10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $gr2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $gr1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos   + $y, money_format('%(#6n', $gramt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x, $xpos++   + $y, '=========================================================================================' , 'Arial', 10);
		$pdf->printLn( $x+79, $xpos++   + $y, $pdf->Footer() );
		foreach (sfConfig::get('compGroup') as $kcomp=>$cComp)
		{
			$xpos = 0;
			$pos  = 0;
			$seq  = 1;

			$net50 = 0;
			$net10 = 0;
			$net2  = 0;
			$net1  = 0;
			$netamt= 0;


			foreach ($empData['company'] as $rec)
			{
				if ( (strtolower($cComp) == strtolower($rec) ) )
				{
					if ($xpos == 55 || $xpos == 0)
					{
						$pdf->addPage('Arial', 10);
						$x = 13;
						$y = 2;
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printBoldLn( $x,    $xpos++   + $y, $cComp.' - CASH DISTRIBUTION', 'Arial', 10);
						$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
						$pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                  $ 50              $ 10            $ 2               $ 1                  AMOUNT', 'Arial', 10);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
					}
					$pdf->printLn( $x,     $xpos   + $y,  $seq++.'.');
					$pdf->printLn( $x+10,  $xpos   + $y,  substr($empData['name'][$pos], 0, 15 ) );
					$pdf->printLn( $x+50,  $xpos   + $y,  $empData['company'][$pos]);
					$pdf->printLn( $x+80,  $xpos    + $y, $empData['50'][$pos]);
					$pdf->printLn( $x+100, $xpos   + $y,  $empData['10'][$pos]);
					$pdf->printLn( $x+120, $xpos   + $y,  $empData['2'][$pos]);
					$pdf->printLn( $x+140, $xpos   + $y,  $empData['1'][$pos]);
					$pdf->printLn( $x+155, $xpos++   + $y, money_format("%=*(#8.2n", $empData['total'][$pos]) );
					$net50 = $net50 + $empData['50'][$pos];
					$net10 = $net10 + $empData['10'][$pos];
					$net2  = $net2  + $empData['2'][$pos];
					$net1  = $net1  + $empData['1'][$pos];
					$netamt = $netamt + $empData['total'][$pos];

				}
				$pos++;
			}
			$pdf->printLn( $x,     $xpos++   + $y, '*************************************************************************************************************************************' );
			$pdf->printLn( $x+80,  $xpos    + $y, $net50);
			$pdf->printLn( $x+100, $xpos   + $y,  $net10);
			$pdf->printLn( $x+120, $xpos   + $y,  $net2);
			$pdf->printLn( $x+140, $xpos   + $y,  $net1);
			$pdf->printLn( $x+155, $xpos++   + $y, money_format('%=*#8.2n', $netamt) );

		}
		//$pdf->printLn( $x+55, $xpos   + $y, money_format('%(#6n', $acr50), 'Arial', 10);

		//        $pdf->addPage();
		//        $xpos = 2;
		//        $y = 5;
		//        $x = 13;
		//        $gross = 0;
		//        $amt = 0;
		//        //        $pdf->addPage('Arial', 10);
		//        $pdf->printLn( $x,    $xpos   + $y, 'TO         : MAYBANK ( WOODLANDS )', 'Arial', 10);
		//        $pdf->printLn( $x+100,    $xpos++ + $y, 'DATE    : '.Date('d-M-Y'));
		//        $pdf->printLn( $x,    $xpos++   + $y, 'ATTN    : MS KELLIE POH');
		//        $pdf->printLn( $x,    $xpos++   + $y, 'FROM   : LUCY ANG');
		//        //$xpos+=2;
		//        $pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
		//        $pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                  $ 50              $ 10            $ 2               $ 1                  AMOUNT', 'Arial', 10);
		//        $pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
		//        $seq = 1;
		//        setlocale(LC_MONETARY, 'en_US');
		//        $tfifty = 0;
		//        $ttwenty = 0;
		//        $tten = 0;
		//        $ttwo = 0;
		//        $tone = 0;
		//
		//        foreach ($empNoList as $kemp=>$vno)
		//        {
		//
		//            if ( $xpos == 50 )
		//            {
		//                $pdf->printLn( $x,     $xpos++   + $y, '*************************************************************************************************************************************' );
		//                $pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
		//                $pdf->addPage('Arial', 10);
		//                //                $xpos = -2;
		//                $xpos = 2;
		//                //                $x = 16;
		//                $pdf->printLn( $x,    $xpos   + $y, 'TO         : MAYBANK ( WOODLANDS )');
		//                $pdf->printLn( $x+100,    $xpos++ + $y, 'DATE    : '.Date('d-M-Y'));
		//                $pdf->printLn( $x,    $xpos++   + $y, 'ATTN    : MS KELLIE POH');
		//                $pdf->printLn( $x,    $xpos++   + $y, 'FROM   : LUCY ANG');
		//                $pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
		//                $pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                  $ 50              $ 10            $ 2               $ 1                  AMOUNT', 'Arial', 10);
		//                $pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
		//
		//                //                $pdf->printLn( $x,     $xpos++   + $y, '*****************************************************************************************************************************' );
		//            }else{
		//                $pdf->setFont('Arial', 10);
		//            }
		//
		//

		//            $pdf->printLn( $x,     $xpos   + $y,  $seq++.'.');
		//            $pdf->printLn( $x+10,  $xpos   + $y,  $empInfo->getName());
		//            $pdf->printLn( $x+80,  $xpos    + $y, $fifty);
		//            //$pdf->printLn( $x+95,  $xpos    + $y, $twenty);
		//            $pdf->printLn( $x+100, $xpos   + $y,  $ten);
		//            $pdf->printLn( $x+120, $xpos   + $y,  $two);
		//            $pdf->printLn( $x+140, $xpos   + $y,  $one);
		//            $pdf->printLn( $x+155, $xpos++   + $y, money_format('%=*#8.2n', $amt) );
		//            $tfifty = $tfifty  + $fifty;
		//            //$ttwenty= $ttwenty + $twenty;
		//            $tten   = $tten    + $ten;
		//            $ttwo   = $ttwo    + $two;
		//            $tone   = $tone    + $one;
		//            $gross = $amt + $gross;
		//        }
		//        $pdf->printLn( $x,     $xpos++   + $y, '**************************************************************************************************************************************' );
		//        $pdf->printLn( $x+50,  $xpos    + $y, "TOTAL:",'Arial', 12);
		//        $pdf->printLn( $x+80,  $xpos    + $y, $tfifty);
		//        //$pdf->printLn( $x+95,  $xpos    + $y, $ttwenty);
		//        $pdf->printLn( $x+100, $xpos   + $y,  $tten);
		//        $pdf->printLn( $x+120, $xpos   + $y,  $ttwo);
		//        $pdf->printLn( $x+140, $xpos   + $y,  $tone);
		//        $pdf->printBoldLn( $x+150, $xpos++   + $y, money_format('%=*(#8.2n', $gross), 'Arial', 12 );
		//        $xpos+=2;
		//        $pdf->printLn( $x,     $xpos++   + $y, 'PLEASE DEBIT FROM OUR ACCOUNT NO.             0404-0953532     TO CREDIT' );
		//        $pdf->printLn( $x,     $xpos++   + $y, 'TO THE ABOVE STAFF ACCOUNT NUMBER ON     '.Date('d-M-Y') );
		//        $xpos++;
		//        $pdf->printLn( $x,     $xpos++   + $y,  'Thank you.' );
		//        $pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
		$pdf->closePDF('testing.pdf','', true);
		return sfView::NONE;
	}
	
	public function PrintCashCheckWithdrawal($batch)
	{
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);
		//$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCash($batch);
		$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashCheck($batch);
		$pdf = new PdfLibrary();
		$x = 13;
		$y = 0;
		$xpos =5;
		$empData = array('empno'=>array(), 'name'=>array(), 'company'=>array(), '50'=>array(), '10'=>array(), '2'=>array(), '1'=>array(), 'total'=>array());
		$acr50 = 0;
		$acr10 = 0;
		$acr2  = 0;
		$acr1  = 0;
		$acramt= 0;
	
		$mcs50 = 0;
		$mcs10 = 0;
		$mcs2  = 0;
		$mcs1  = 0;
		$mcsamt= 0;
	
		$nan50 = 0;
		$nan10 = 0;
		$nan2  = 0;
		$nan1  = 0;
		$nanamt= 0;
	
		$tck50 = 0;
		$tck10 = 0;
		$tck2  = 0;
		$tck1  = 0;
		$tckamt= 0;
	
		$oth50 = 0;
		$oth10 = 0;
		$oth2  = 0;
		$oth1  = 0;
		$othamt= 0;
	
		$gr50 = 0;
		$gr10 = 0;
		$gr2  = 0;
		$gr1  = 0;
		$gramt= 0;
		$gcnt = 0;
	
		$acnt = 0;
		$mcnt = 0;
		$ncnt = 0;
		$tcnt = 0;
		$ocnt = 0;
	
		foreach($empNoList as $ke=>$empNo)
		{
			$amt = 0;
			$name = '';
			$comp = '';
			$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCashCheck($batch, $empNo);
			foreach($data as $rec)
			{
				$amt  = $amt + $rec->getAmount();
				$name = $rec->getName();
				$comp = $rec->getCompany();
			}
			$fifty = $this->FiftyDenomination($amt);
			$ten   = $this->TenDenomination($amt - ($fifty * 50) );
			$two   = $this->TwoDenomination($amt - ($fifty * 50) - ($ten * 10) );
			$one   = $this->OneDenomination($amt - ($fifty * 50) - ($ten * 10) - ($two * 2));
			$gr50 = $gr50 + $fifty;
			$gr10 = $gr10 + $ten;
			$gr2  = $gr2 + $two;
			$gr1  = $gr1 + $one;
			$gramt= $gramt + $amt;
			$gcnt ++;
			switch(strtolower($comp))
			{
				case 'acro solution':
					$acr50 = $acr50 + $fifty;
					$acr10 = $acr10 + $ten;
					$acr2  = $acr2  + $two;
					$acr1  = $acr1  + $one;
					$acramt = $acramt + $amt;
					$acnt ++;
					break;
				case 'micronclean':
					$mcs50 = $mcs50 + $fifty;
					$mcs10 = $mcs10 + $ten;
					$mcs2  = $mcs2  + $two;
					$mcs1  = $mcs1  + $one;
					$mcsamt = $mcsamt + $amt;
					$mcnt ++;
					break;
				case 'nanoclean':
					$nan50 = $nan50 + $fifty;
					$nan10 = $nan10 + $ten;
					$nan2  = $nan2  + $two;
					$nan1  = $nan1  + $one;
					$nanamt = $nanamt + $amt;
					$ncnt ++;
					break;
				case 't.c. khoo':
					$tck50 = $tck50 + $fifty;
					$tck10 = $tck10 + $ten;
					$tck2  = $tck2  + $two;
					$tck1  = $tck1  + $one;
					$tckamt = $tckamt + $amt;
					$tcnt ++;
					break;
				default:
					$oth50 = $oth50 + $fifty;
					$oth10 = $oth10 + $ten;
					$oth2  = $oth2  + $two;
					$oth1  = $oth1  + $one;
					$othamt = $othamt + $amt;
					$ocnt ++;
					break;
			}
			$empData['empno'][] = $empNo;
			$empData['name'][]  = $name;
			$empData['company'][] = $comp;
			$empData['50'][]    = $fifty;
			$empData['10'][]    = $ten;
			$empData['2'][]     = $two;
			$empData['1'][]     = $one;
			$empData['total'][] = $amt;
		}
		setlocale(LC_MONETARY, 'en_US');
		$pdf->addPage();
		$pdf->printTCKhooHeader();
		$pdf->printBoldLn( $x,    $xpos++   + $y, 'Cash-Check Withdrawal', 'Arial', 10);
		$pdf->printLn( $x,        $xpos++   + $y, 'T.C. KHOO & CO. (PTE) LTD.');
		$y++;
		$pdf->printBoldLn( $x+40,    $xpos++ + $y, 'CASH-CHECK WITHDRAWAL '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt), 'Arial', 12);
		$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
		$y++;
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                             COMPANY             #EMP           $ 50              $ 10            $ 2               $ 1                  AMOUNT', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
		$seq = 1;
		$pdf->printLn( $x+15, $xpos   + $y, '        ACRO SOLUTION ', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $acnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $acr50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $acr10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $acr2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $acr1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos   + $y, money_format('%(#6n', $acramt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+16, $xpos   + $y, '          MICRONCLEAN', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $mcnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $mcs50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $mcs10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $mcs2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $mcs1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos  + $y, money_format('%(#6n', $mcsamt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+18, $xpos   + $y, '            NANOCLEAN', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $ncnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $nan50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $nan10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $nan2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $nan1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos  + $y, money_format('%(#6n', $nanamt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+21, $xpos   + $y, '             T.C.KHOO', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $tcnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $tck50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $tck10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $tck2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $tck1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos  + $y, money_format('%(#6n', $tckamt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x+10, $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x+22, $xpos   + $y, '              OTHERS', 'Arial', 10);
		$pdf->printLn( $x+62, $xpos   + $y,  $ocnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $oth50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $oth10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $oth2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $oth1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos   + $y, money_format('%(#6n', $othamt), 'Arial', 10);
		$xpos++;
	
	
		$pdf->printLn( $x, $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
		$pdf->printLn( $x+38, $xpos  + $y, 'TOTAL' );
		$pdf->printLn( $x+62, $xpos   + $y,  $gcnt,  'Arial', 10);
		$pdf->printLn( $x+80, $xpos   + $y,  $gr50, 'Arial', 10);
		$pdf->printLn( $x+100,$xpos   + $y,  $gr10, 'Arial', 10);
		$pdf->printLn( $x+120,$xpos   + $y,  $gr2, 'Arial', 10);
		$pdf->printLn( $x+140,$xpos   + $y,  $gr1, 'Arial', 10);
		$pdf->printLn( $x+160, $xpos   + $y, money_format('%(#6n', $gramt), 'Arial', 10);
		$xpos++;
		$pdf->printLn( $x, $xpos++   + $y, '=========================================================================================' , 'Arial', 10);
		$pdf->printLn( $x+79, $xpos++   + $y, $pdf->Footer() );
		foreach (sfConfig::get('compGroup') as $kcomp=>$cComp)
		{
			$xpos = 0;
			$pos  = 0;
			$seq  = 1;
	
			$net50 = 0;
			$net10 = 0;
			$net2  = 0;
			$net1  = 0;
			$netamt= 0;
	
	
			foreach ($empData['company'] as $rec)
			{
				if ( (strtolower($cComp) == strtolower($rec) ) )
				{
					if ($xpos == 55 || $xpos == 0)
					{
						$pdf->addPage('Arial', 10);
						$x = 13;
						$y = 2;
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printBoldLn( $x,    $xpos++   + $y, $cComp.' - CASH CHECK DISTRIBUTION', 'Arial', 10);
						$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt),'Arial', '10' );
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
						$pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                  $ 50              $ 10            $ 2               $ 1                  AMOUNT', 'Arial', 10);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
					}
					$pdf->printLn( $x,     $xpos   + $y,  $seq++.'.');
					$pdf->printLn( $x+10,  $xpos   + $y,  substr($empData['name'][$pos], 0, 15 ) );
					$pdf->printLn( $x+50,  $xpos   + $y,  $empData['company'][$pos]);
					$pdf->printLn( $x+80,  $xpos    + $y, $empData['50'][$pos]);
					$pdf->printLn( $x+100, $xpos   + $y,  $empData['10'][$pos]);
					$pdf->printLn( $x+120, $xpos   + $y,  $empData['2'][$pos]);
					$pdf->printLn( $x+140, $xpos   + $y,  $empData['1'][$pos]);
					$pdf->printLn( $x+155, $xpos++   + $y, money_format("%=*(#8.2n", $empData['total'][$pos]) );
					$net50 = $net50 + $empData['50'][$pos];
					$net10 = $net10 + $empData['10'][$pos];
					$net2  = $net2  + $empData['2'][$pos];
					$net1  = $net1  + $empData['1'][$pos];
					$netamt = $netamt + $empData['total'][$pos];
	
				}
				$pos++;
// 				$pdf->printLn( $x,     $xpos++   + $y, '*************************************************************************************************************************************' );
// 				$pdf->printLn( $x+80,  $xpos    + $y, $net50);
// 				$pdf->printLn( $x+100, $xpos   + $y,  $net10);
// 				$pdf->printLn( $x+120, $xpos   + $y,  $net2);
// 				$pdf->printLn( $x+140, $xpos   + $y,  $net1);
// 				$pdf->printLn( $x+155, $xpos++   + $y, money_format('%=*#8.2n', $netamt) );
			}
			
		}
		$pdf->closePDF('testing.pdf','', true);
		return sfView::NONE;
	}

	public function PrintChequeWithdrawal($batch)
	{

		$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCheque($batch);
		$pdf = new PdfLibrary();
		$x = 0;
		$y = 0;

		$pdf->addPage();
		$xpos = 2;

		//$pdf->image('/web/images/hr/mclogo.jpg', $x, $y);
		//        $pdf->printHeader();
		$y = 5;
		$x = 13;
		$gross = 0;
		$amt = 0;
		//        $pdf->addPage('Arial', 10);
		$pdf->printLn( $x,    $xpos   + $y, 'TO         : MAYBANK ', 'Arial', 10);
		$pdf->printLn( $x+100,    $xpos++ + $y, 'DATE    : '.Date('d-M-Y'));
		//$pdf->printLn( $x,    $xpos++   + $y, 'ATTN    : MS KELLIE POH');
		$pdf->printLn( $x,    $xpos++   + $y, 'FROM   : LUCY ANG');
		//$xpos+=2;
		$pdf->printLn( $x,    $xpos++   + $y, 'CHEQUE  WITHDRAWAL', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
		$pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                                                                                           AMOUNT', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );
		$seq = 1;
		setlocale(LC_MONETARY, 'en_US');
		$tfifty = 0;
		$ttwenty = 0;
		$tten = 0;
		$ttwo = 0;
		$tone = 0;

		foreach ($empNoList as $kemp=>$vno)
		{

			if ( $xpos == 50 )
			{
				$pdf->printLn( $x,     $xpos++   + $y, '*************************************************************************************************************************************' );
				$pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
				$pdf->addPage('Arial', 10);
				//                $xpos = -2;
				$xpos = 2;
				//                $x = 16;
				$pdf->printLn( $x,    $xpos   + $y, 'TO         : MAYBANK ');
				$pdf->printLn( $x+100,    $xpos++ + $y, 'DATE    : '.Date('d-M-Y'));
				//$pdf->printLn( $x,    $xpos++   + $y, 'ATTN    : MS KELLIE POH');
				$pdf->printLn( $x,    $xpos++   + $y, 'FROM   : LUCY ANG');
				$pdf->printLn( $x,    $xpos++   + $y, 'CHEQUE  WITHDRAWAL', 'Arial', 10);
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================');
				$pdf->printLn( $x,    $xpos++   + $y, '                                   NAME                                                                                                           AMOUNT', 'Arial', 10);
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' );

				//                $pdf->printLn( $x,     $xpos++   + $y, '*****************************************************************************************************************************' );
			}else{
				$pdf->setMyFont('Arial','', 10);
			}
			$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCheque($batch, $vno);
			$empInfo = HrEmployeePeer::GetDatabyEmployeeNo($vno);
			$amt = 0;
			foreach($data as $rec)
			{
				$amt  = $amt + $rec->getAmount();
			}
			$pdf->printLn( $x,     $xpos   + $y,  $seq++.'.');
			$pdf->printLn( $x+10,  $xpos   + $y,  $empInfo->getName());
			$pdf->printLn( $x+155, $xpos++   + $y, money_format('%=*#8.2n', $amt) );
			$gross = $amt + $gross;
		}
		$pdf->printLn( $x,     $xpos++   + $y, '**************************************************************************************************************************************' );
		$pdf->printLn( $x+50,  $xpos    + $y, "TOTAL:",'Arial', 12);
		$pdf->printBoldLn( $x+150, $xpos++   + $y, money_format('%=*(#8.2n', $gross), 'Arial', 12 );
		$xpos+=2;
		$pdf->printLn( $x,     $xpos++   + $y, 'PLEASE DEBIT FROM OUR ACCOUNT NO.             0404-0953532     TO CREDIT' );
		$pdf->printLn( $x,     $xpos++   + $y, 'TO THE ABOVE STAFF ACCOUNT NUMBER ON     '.Date('d-M-Y') );
		$xpos++;
		$pdf->printLn( $x,     $xpos++   + $y,  'Thank you.' );
		$pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
		$pdf->closePDF('testing.pdf', '', true);
		return sfView::NONE;
	}


	public function executeBankTransmittal()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST )
		{
			if ( $this->_G('bank') )
			{
				$this->PrintBankTransmittal($this->_G('period_code'), $this->_G('docdate'), $this->_G('depdate'), $this->_G('to'), $this->_G('attn'), $this->_G('from'), $this->_G('mess'), $this->_G('acct_no'));
				return sfView::NONE;
			}

			if ( $this->_G('cash') )
			{
				$this->PrintCashWithdrawal($this->_G('period_code'));
				return sfView::NONE;
			}
			
			if ( $this->_G('cash_check') )
			{
				$this->PrintCashCheckWithdrawal($this->_G('period_code'));
				return sfView::NONE;
			}

			if ( $this->_G('cheque') )
			{
				$this->PrintChequeWithdrawal($this->_G('period_code'));
				return sfView::NONE;
			}


			if ( $this->_G('all') )
			{
				$this->PrintBankCashListing($this->_G('period_code'));
				return sfView::NONE;
			}
		}
	}

	public function FiftyDenomination($amt)
	{
		return intval($amt/50);
	}

	public function TwentyDenomination($amt)
	{
		return intval($amt/20);
	}

	public function TenDenomination($amt)
	{
		return intval($amt/10);
	}

	public function TwoDenomination($amt)
	{
		return intval($amt/2);
	}

	public function OneDenomination($amt)
	{
		return intval($amt/1);
	}
	
	
	public function executeIncomeTax()
	{
		if ($this->getRequest()->getMethod() != sfRequest::POST )
		{	
			$this->_S('erName', 'T.C. KHOO & CO (PTE) LTD.' );
			$this->_S('rcb_no', '197500399G' );
			$this->_S('erAddr', '35 SENOKO WAY, WOODLANDS EAST, SINGAPORE 758051' );
			
			$this->_S('erCPer', 'FLORENCE HAN' );
			$this->_S('designation', 'FINANCE MANAGER' );			
			$this->_S('contact_no', '67582119' );
			
// 			$this->_S('erCPer', 'KATHY' );
// 			$this->_S('designation', 'ADMIN OFFICER' );
// 			$this->_S('contact_no', '67585043' );
			
			$this->_S('cyear', HrFiscalYearPeer::getPreviousYear());
 			$this->_S('nassign', '');
			$this->_S('d_prep', Date('Y-m-d'));			
		}
		
		
		$this->showMonthly = false;
		if ($this->getRequest()->getMethod() == sfRequest::POST)
		{
			if($this->_G('retrieve_from_ic') ):
				$empIc = HrEmployeeIcPeer::GetDatabyEmployeeNo($this->_G('employee_no'));
				if ($empIc):
					$this->_S('nassign', $empIc->getOccupation() );
					$this->_S('assign', 'OTHER' );
				endif;
			endif;
			
			if($this->_G('monthly') && $this->_G('employee_no')  )
			{
//				var_dump($this->_G('employee_no'));
//				exit();
				$pList = array();
				$pList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($this->_G('cyear'));
				foreach ($pList as $k=>$period) 
				{
					ContribEmployeeIr8aPeer::GenerateListing($period, $this->_U(), $this->_G('employee_no') );
				}
				$contrib = new Criteria();
				$contrib->add(ContribEmployeeIr8aPeer::EMPLOYEE_NO, $this->_G('employee_no'));
				$contrib->add(ContribEmployeeIr8aPeer::PERIOD_CODE, 'substr('.ContribEmployeeIr8aPeer::PERIOD_CODE.', 1, 4) = "'. $this->_G('cyear') .'"', Criteria::CUSTOM );
				$contrib->addDescendingOrderByColumn(ContribEmployeeIr8aPeer::PERIOD_CODE);
				//$contrib->add(ContribEmployeeIr8aPeer::NAME, '&& || &&', Criteria::CUSTOM);
				//$this->contrib = ContribEmployeeIr8aPeer::GetPager($contrib);
				$this->pager = ContribEmployeeIr8aPeer::doSelect($contrib);
				$this->showMonthly = true;
			}

			if ($this->_G('company') && (! $this->_G('employee_no')) ):
				$pList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($this->_G('cyear'));
				$empList = ContribEmployeeIr8aPeer::GetListWhenTotalIncomeIsAtLeast(22000, $pList);
				$pager = new Criteria();
				$pager->add(ContribEmployeeIr8aPeer::COMPANY, $this->_G('company'));
				//$pager->add(ContribEmployeeIr8aPeer::PERIOD_CODE, 'substr('.ContribEmployeeIr8aPeer::PERIOD_CODE.', 1, 4) = "'. $this->_G('cyear') .'"', Criteria::CUSTOM );
				$pager->add(ContribEmployeeIr8aPeer::EMPLOYEE_NO, $empList, Criteria::IN);
				$pager->addAscendingOrderByColumn(ContribEmployeeIr8aPeer::NAME);
				$pager->addGroupByColumn(ContribEmployeeIr8aPeer::EMPLOYEE_NO);
				$this->pager = ContribEmployeeIr8aPeer::GetPager($pager, 500);
				$this->showMonthly = false;
			endif;
			
			if ($this->_G('show') )
			{

				if ($this->_G('employee_no')):
					//$this->EmployeeLedgerPDF(array($this->_G('employee_no')=>''), $this->_G('cmonth'), $pdf);
//					var_dump($this->_G('cyear'));
//					exit();
					switch ($this->_G('cyear')):
						case '2014':
							$this->PDFIr8a2014('', '', $this->_G('d_prep'), array($this->_G('employee_no')));
							break;
						case '2013':
							$this->PDFIr8a2013('', '', $this->_G('d_prep'), array($this->_G('employee_no')));
							break;
						case '2012': 
							$this->PDFIr8a2012('', '', $this->_G('d_prep'), array($this->_G('employee_no')));
							break;					
						case '2011': 
							$this->PDFIr8a2011('', '', $this->_G('d_prep'), array($this->_G('employee_no')));
							break;
						default:
							$this->PDFIr8a2010('', '', $this->_G('d_prep'));
							break;
					endswitch;
					//echo 'here ' . $this->_G('cyear');
					//exit();					
					//$this->PDFIr8a2010('', '', $this->_G('d_prep'));
					//$this->MasterlistPDF('', '');
				else:
				 	for($x=1; $x<=500; $x++):
				 		$empListing[$this->_G ('gridCheckBox_item_'. $x)] = $this->_G ('gridCheckBox_item_'. $x);
				 	endfor;
// 				 	echo 'here';
// 				 	var_dump($empListing);
// 				 	exit();
					$this->PDFIr8a2012('', '', $this->_G('d_prep'), $empListing );
				endif;
				return sfView::NONE;
			}			
		}
		
	}

	public function PDFIr8a2014($co=null, $wt=null, $dprep=null, $empList)
	{
		//var_dump($empList);
		//exit();
		$fname = 'ir8a'. (intval($this->_G('cyear')) + 1) .'.png';
		//		var_dump($fname);
		//		exit();
		$allowance = 0;
		//$bik = 45300;  //benefits in kind
		$bik = 0;
		$occupation = '';
		$pdf = new PdfLibrary();
		foreach($empList as $empNo):
		if ($empNo):
		$pdf->addPage('Arial', 10, 'P');
		$pdf->myimage(SF_ROOT_DIR . '/web/images/hr/'.$fname, 0, 0 );
		//$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($this->_G('employee_no'));
		$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
		$adjx = 3;
		$adjy = -.6;
		$address = trim($empInfo->getBldgRoomNo() .' '. $empInfo->getStreet()  );
		$address = $address? $address : '35 Senoko Way, Woodlands East';
		$pdf->printLn( 020 + $adjx, 8 + $adjy, $this->_G('rcb_no'), 'Arial', 11);
		$pdf->printLn( 110+ $adjx, 8 + $adjy, $empInfo->getEmployeeNo() . ($empInfo->getSinId()? ' / '. $empInfo->getSinId() : '') , 'Arial', 11);
		$pdf->printLn( 020+ $adjx, 9.3 + $adjy, $empInfo->getName(), 'Arial', 11);
		$pdf->printLn( 110+ $adjx, 9.3 + $adjy, DateUtils::DUFormat('d/m/Y', $empInfo->getDateOfBirth()), 'Arial', 11);
		$pdf->printLn( 140+ $adjx, 9.3 + $adjy, ($empInfo->getGender() == 'F')? 'FEMALE' :  'MALE' , 'Arial', 11);
		$pdf->printLn( 165+ $adjx, 9.3 + $adjy, $empInfo->getNationality(), 'Arial', 11);
		$pdf->printLn( 020+ $adjx, 10.7 + $adjy,  $address, 'Arial', 8);
	
		if ($this->_G('assign') != 'OTHER'){
			$occupation = $this->_G('assign');
		}else{
			$occupation = $this->_G('nassign');
		}
		if (sizeof($empList) > 1 ):
		$occupation = HrEmployeeIcPeer::GetOccupationByEmployeeNo($empNo);
		endif;
		$occupation = $occupation? $occupation : $this->_G('assign');
		$pdf->printLn( 110, 10,  $occupation, 'Arial', 11);
		$pdf->printLn( 160, 10,  'MAYBANK', 'Arial', 11);
	
		//$pdf->printLn( 115, 11,  $empInfo->getJobTitle(), 'Arial', 11);
	
		if ($empInfo->getDateResigned() )
		{
			$dateResigned = DateUtils::DUFormat('d/m/Y', $empInfo->getDateResigned());
		}else{
			$dateResigned = '';
		}
		
		if ($empInfo->getCommenceDate() )
		{
			if ($this->_G('cyear') == DateUtils::DUFormat('Y', $empInfo->getCommenceDate())){
				$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
			}else{
				$dateCommence = '';
			}
		}else{
			$dateCommence = '';
		}
		
		//$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
		
		$pdf->printLn( 115, 11.5, $dateCommence, 'Arial', 11);
		$pdf->printLn( 170, 11.5,  $dateResigned, 'Arial', 11);
	
		$comDetail = ContribEmployeeIr8aPeer::GetYearlyEmployeeIr8a($empNo, $this->_G('cyear'));
		if ($comDetail)
		{
			$pdf->printLn( 173, 13.5,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
			$pdf->printLn( 173, 18,  number_format($allowance, 2), 'Arial', 11);
			$pdf->printLn( 173, 39,  number_format($bik, 2), 'Arial', 11);
			$pdf->printLn( 173, 40.8,  number_format($comDetail['gross_inc'] + $allowance + $bik, 2), 'Arial', 11);
			$pdf->printLn( 175, 48,  number_format($comDetail['cpf_em'], 2), 'Arial', 11);
			$pdf->printLn( 175, 50.5,  number_format($comDetail['don'], 2), 'Arial', 11);
			$pdf->printLn( 175, 52,  number_format($comDetail['mbf'], 2), 'Arial', 11);
		}
	
		$adjx = 2;
		$adjy = 2.5;
		$dprep = $dprep? $dprep : date('d-m-Y');
		$pdf->printLn( 55 + $adjx, 51.4 + $adjy,  $this->_G('erName'), 'Arial', 10);
		$pdf->printLn( 55 + $adjx, 52.4+ $adjy,  $this->_G('erAddr'), 'Arial', 10);
		$pdf->printLn( 40 + $adjx, 53.4 + $adjy,  $this->_G('erCPer'), 'Arial', 10);
		$pdf->printLn( 78 + $adjx, 53.4 + $adjy,  $this->_G('designation'), 'Arial', 10);
		$pdf->printLn( 115 + $adjx, 53.4 + $adjy, $this->_G('contact_no'), 'Arial', 10);
		$pdf->printLn( 174 + $adjx, 53.4 + $adjy,  $dprep, 'Arial', 10);
		endif;
		endforeach;
		$pdf->closePDF('testing.pdf', '' , true );
		exit();
	
	}	
	
	public function PDFIr8a2013($co=null, $wt=null, $dprep=null, $empList)
	{
		//var_dump($empList);
		//exit();
		$fname = 'ir8a'. (intval($this->_G('cyear')) + 1) .'.png';
		//		var_dump($fname);
		//		exit();
		$allowance = 0;
		//$bik = 45300;  //benefits in kind
		$bik = 0;
		$occupation = '';
		$pdf = new PdfLibrary();
		foreach($empList as $empNo):
		if ($empNo):
		$pdf->addPage('Arial', 10, 'P');
		$pdf->myimage(SF_ROOT_DIR . '/web/images/hr/'.$fname, 0, 0 );
		//$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($this->_G('employee_no'));
		$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
		$adjx = 3;
		$adjy = -.6;
		$address = trim($empInfo->getBldgRoomNo() .' '. $empInfo->getStreet()  );
		$address = $address? $address : '35 Senoko Way, Woodlands East';
		$pdf->printLn( 020 + $adjx, 8 + $adjy, $this->_G('rcb_no'), 'Arial', 11);
		$pdf->printLn( 110+ $adjx, 8 + $adjy, $empInfo->getEmployeeNo() . ($empInfo->getSinId()? ' / '. $empInfo->getSinId() : '') , 'Arial', 11);
		$pdf->printLn( 020+ $adjx, 9.3 + $adjy, $empInfo->getName(), 'Arial', 11);
		$pdf->printLn( 110+ $adjx, 9.3 + $adjy, DateUtils::DUFormat('d/m/Y', $empInfo->getDateOfBirth()), 'Arial', 11);
		$pdf->printLn( 140+ $adjx, 9.3 + $adjy, ($empInfo->getGender() == 'F')? 'FEMALE' :  'MALE' , 'Arial', 11);
		$pdf->printLn( 165+ $adjx, 9.3 + $adjy, $empInfo->getNationality(), 'Arial', 11);
		$pdf->printLn( 020+ $adjx, 10.7 + $adjy,  $address, 'Arial', 8);
	
		if ($this->_G('assign') != 'OTHER'){
			$occupation = $this->_G('assign');
		}else{
			$occupation = $this->_G('nassign');
		}
		if (sizeof($empList) > 1 ):
		$occupation = HrEmployeeIcPeer::GetOccupationByEmployeeNo($empNo);
		endif;
		$occupation = $occupation? $occupation : $this->_G('assign');
		$pdf->printLn( 120, 10,  $occupation, 'Arial', 11);
	
		//$pdf->printLn( 115, 11,  $empInfo->getJobTitle(), 'Arial', 11);
	
		if ($empInfo->getDateResigned() )
		{
			$dateResigned = DateUtils::DUFormat('d/m/Y', $empInfo->getDateResigned());
		}else{
			$dateResigned = '';
		}
		
		if ($empInfo->getCommenceDate() )
		{
			if ($this->_G('cyear') == DateUtils::DUFormat('Y', $empInfo->getCommenceDate())){
				$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
			}else{
				$dateCommence = '';
			}
		}else{
			$dateCommence = '';
		}
		
		//$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
		
		$pdf->printLn( 115, 11.5, $dateCommence, 'Arial', 11);
		$pdf->printLn( 170, 11.5,  $dateResigned, 'Arial', 11);
	
		$comDetail = ContribEmployeeIr8aPeer::GetYearlyEmployeeIr8a($empNo, $this->_G('cyear'));
		if ($comDetail)
		{
			$pdf->printLn( 173, 13.5,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
			$pdf->printLn( 173, 18,  number_format($allowance, 2), 'Arial', 11);
			$pdf->printLn( 173, 39,  number_format($bik, 2), 'Arial', 11);
			$pdf->printLn( 173, 40.8,  number_format($comDetail['gross_inc'] + $allowance + $bik, 2), 'Arial', 11);
			$pdf->printLn( 170, 48,  number_format($comDetail['cpf_em'], 2), 'Arial', 11);
			$pdf->printLn( 175, 50.5,  number_format($comDetail['don'], 2), 'Arial', 11);
			$pdf->printLn( 175, 52,  number_format($comDetail['mbf'], 2), 'Arial', 11);
		}
	
		$adjx = 3;
		$adjy = 3;
		$dprep = $dprep? $dprep : date('d-m-Y');
		$pdf->printLn( 55 + $adjx, 51.6 + $adjy,  $this->_G('erName'), 'Arial', 10);
		$pdf->printLn( 55 + $adjx, 52.5+ $adjy,  $this->_G('erAddr'), 'Arial', 10);
		$pdf->printLn( 40 + $adjx, 53.5 + $adjy,  $this->_G('erCPer'), 'Arial', 10);
		$pdf->printLn( 78 + $adjx, 53.5 + $adjy,  $this->_G('designation'), 'Arial', 10);
		$pdf->printLn( 115 + $adjx, 53.5 + $adjy, $this->_G('contact_no'), 'Arial', 10);
		$pdf->printLn( 174 + $adjx, 53.5 + $adjy,  $dprep, 'Arial', 10);
		endif;
		endforeach;
		$pdf->closePDF('testing.pdf', '' , true );
		exit();
	
	}
		
	public function PDFIr8a2012($co=null, $wt=null, $dprep=null, $empList)
	{
		//var_dump($empList);
		//exit();
		$fname = 'ir8a'. (intval($this->_G('cyear')) + 1) .'.png';
//		var_dump($fname);
//		exit();
		$allowance = 0;
		$bik = 45300;  //benefits in kind
		$bik = 0;
		$occupation = '';
		$pdf = new PdfLibrary();
		foreach($empList as $empNo):
			if ($empNo):
				$pdf->addPage('Arial', 10, 'P');
				$pdf->myimage(SF_ROOT_DIR . '/web/images/hr/'.$fname, 0, 0 );
				//$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($this->_G('employee_no'));
				$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
				$adjx = 3;
				$adjy = -.8;
				$address = trim($empInfo->getBldgRoomNo() .' '. $empInfo->getStreet()  );
				$address = $address? $address : '35 Senoko Way, Woodlands East';
				$pdf->printLn( 020 + $adjx, 8 + $adjy, $this->_G('rcb_no'), 'Arial', 11);
				$pdf->printLn( 110+ $adjx, 8 + $adjy, $empInfo->getEmployeeNo() . ($empInfo->getSinId()? ' / '. $empInfo->getSinId() : '') , 'Arial', 11);
				$pdf->printLn( 020+ $adjx, 9.3 + $adjy, $empInfo->getName(), 'Arial', 11);
				$pdf->printLn( 110+ $adjx, 9.3 + $adjy, DateUtils::DUFormat('d/m/Y', $empInfo->getDateOfBirth()), 'Arial', 11);
				$pdf->printLn( 140+ $adjx, 9.3 + $adjy, ($empInfo->getGender() == 'F')? 'FEMALE' :  'MALE' , 'Arial', 11);
				//$pdf->printLn( 165+ $adjx, 9.3 + $adjy, $empInfo->getStatus(), 'Arial', 11);
				$pdf->printLn( 020+ $adjx, 10.5 + $adjy,  $address, 'Arial', 8);
				
				if ($this->_G('assign') != 'OTHER'){
					$occupation = $this->_G('assign');
				}else{
					$occupation = $this->_G('nassign');
				}
				if (sizeof($empList) > 1 ):
					$occupation = HrEmployeeIcPeer::GetOccupationByEmployeeNo($empNo);
				endif;
				$occupation = $occupation? $occupation : $this->_G('assign');
				$pdf->printLn( 120, 9.7,  $occupation, 'Arial', 11);
				
				//$pdf->printLn( 115, 11,  $empInfo->getJobTitle(), 'Arial', 11);
		
				if ($empInfo->getDateResigned() )
				{
					$dateResigned = DateUtils::DUFormat('d/m/Y', $empInfo->getDateResigned());
				}else{
					$dateResigned = '';
				}
		
				if ($empInfo->getCommenceDate() )
				{
					if ($this->_G('cyear') == DateUtils::DUFormat('Y', $empInfo->getCommenceDate())){
						$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
					}else{
						$dateCommence = '';
					}
				}else{
					$dateCommence = '';
				}
		
				$pdf->printLn( 115, 11, $dateCommence, 'Arial', 11);
				$pdf->printLn( 170, 11,  $dateResigned, 'Arial', 11);
		
				$comDetail = ContribEmployeeIr8aPeer::GetYearlyEmployeeIr8a($empNo, $this->_G('cyear'));
				if ($comDetail)
				{
					$pdf->printLn( 173, 13,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
					$pdf->printLn( 173, 18,  number_format($allowance, 2), 'Arial', 11);
					$pdf->printLn( 173, 37,  number_format($bik, 2), 'Arial', 11);
					$pdf->printLn( 173, 38.5,  number_format($comDetail['gross_inc'] + $allowance + $bik, 2), 'Arial', 11);
					$pdf->printLn( 170, 46,  number_format($comDetail['cpf_em'], 2), 'Arial', 11);
					$pdf->printLn( 175, 48,  number_format($comDetail['don'], 2), 'Arial', 11);
					$pdf->printLn( 175, 49.5,  number_format($comDetail['mbf'], 2), 'Arial', 11);
				}
		
				$adjx = 3;
				$adjy = 1;
				$dprep = $dprep? $dprep : date('d-m-Y');
				$pdf->printLn( 55 + $adjx, 51.6 + $adjy,  $this->_G('erName'), 'Arial', 10);
				$pdf->printLn( 55 + $adjx, 52.5+ $adjy,  $this->_G('erAddr'), 'Arial', 10);
				$pdf->printLn( 40 + $adjx, 53.5 + $adjy,  $this->_G('erCPer'), 'Arial', 10);
				$pdf->printLn( 78 + $adjx, 53.5 + $adjy,  $this->_G('designation'), 'Arial', 10);
				$pdf->printLn( 115 + $adjx, 53.5 + $adjy, $this->_G('contact_no'), 'Arial', 10);
				$pdf->printLn( 174 + $adjx, 53.5 + $adjy,  $dprep, 'Arial', 10);
			endif;
		endforeach;
		$pdf->closePDF('testing.pdf', '' , true );
		exit();

	}	

	public function PDFIr8a2011($co=null, $wt=null, $dprep=null, $empList)
	{
		//var_dump($empList);
		//exit();
		$fname = 'ir8a'. (intval($this->_G('cyear')) + 1) .'.png';
//		var_dump($fname);
//		exit();
		$pdf = new PdfLibrary();
		foreach($empList as $empNo):
			if ($empNo):
				$pdf->addPage('Arial', 10, 'P');
				$pdf->myimage(SF_ROOT_DIR . '/web/images/hr/'.$fname, 0, 0 );
				//$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($this->_G('employee_no'));
				$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
				$adjx = 3;
				$adjy = -.8;
				$pdf->printLn( 020 + $adjx, 8 + $adjy, $this->_G('rcb_no'), 'Arial', 11);
				$pdf->printLn( 110+ $adjx, 8 + $adjy, $empInfo->getEmployeeNo() . ($empInfo->getSinId()? ' / '. $empInfo->getSinId() : '') , 'Arial', 11);
				$pdf->printLn( 020+ $adjx, 9.3 + $adjy, $empInfo->getName(), 'Arial', 11);
				$pdf->printLn( 110+ $adjx, 9.3 + $adjy, DateUtils::DUFormat('d/m/Y', $empInfo->getDateOfBirth()), 'Arial', 11);
				$pdf->printLn( 140+ $adjx, 9.3 + $adjy, ($empInfo->getGender() == 'F')? 'FEMALE' :  'MALE' , 'Arial', 11);
				$pdf->printLn( 165+ $adjx, 9.3 + $adjy, $empInfo->getStatus(), 'Arial', 11);
				$pdf->printLn( 020+ $adjx, 10.5 + $adjy,  trim($empInfo->getStreet() .' '. $empInfo->getBldgRoomNo()), 'Arial', 8);
				if ($this->_G('assign') != 'OTHER'){
					$pdf->printLn( 120, 9.7,  $this->_G('assign'), 'Arial', 11);
				}else{
					$pdf->printLn( 120, 9.7,  $this->_G('nassign'), 'Arial', 11);
				}
				//$pdf->printLn( 115, 11,  $empInfo->getJobTitle(), 'Arial', 11);
		
				if ($empInfo->getDateResigned() )
				{
					$dateResigned = DateUtils::DUFormat('d/m/Y', $empInfo->getDateResigned());
				}else{
					$dateResigned = '';
				}
		
				if ($empInfo->getCommenceDate() )
				{
					if ($this->_G('cyear') == DateUtils::DUFormat('Y', $empInfo->getCommenceDate())){
						$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
					}else{
						$dateCommence = '';
					}
				}else{
					$dateCommence = '';
				}
		
				$pdf->printLn( 115, 11.3, $dateCommence, 'Arial', 11);
				$pdf->printLn( 170, 11.3,  $dateResigned, 'Arial', 11);
		
				$comDetail = ContribEmployeeIr8aPeer::GetYearlyEmployeeIr8a($empNo, $this->_G('cyear'));
				if ($comDetail)
				{
					$pdf->printLn( 115, 13.5, 'JAN-DEC ' . $this->_G('cyear'), 'Arial', 11);
					$pdf->printLn( 170, 13.5,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
					$pdf->printLn( 170, 40,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
					$pdf->printLn( 170, 46,  number_format($comDetail['cpf_em'], 2), 'Arial', 11);
					$pdf->printLn( 175, 48,  number_format($comDetail['don'], 2), 'Arial', 11);
					$pdf->printLn( 175, 49.5,  number_format($comDetail['mbf'], 2), 'Arial', 11);
				}
		
				$adjx = 3;
				$adjy = 1;
				$dprep = $dprep? $dprep : date('d-m-Y');
				$pdf->printLn( 55 + $adjx, 52.5 + $adjy,  $this->_G('erName'), 'Arial', 10);
				$pdf->printLn( 55 + $adjx, 53.8 + $adjy,  $this->_G('erAddr'), 'Arial', 10);
				$pdf->printLn( 40 + $adjx, 54.8 + $adjy,  $this->_G('erCPer'), 'Arial', 10);
				$pdf->printLn( 80 + $adjx, 55 + $adjy,  $this->_G('designation'), 'Arial', 10);
				$pdf->printLn( 115 + $adjx, 55 + $adjy, $this->_G('contact_no'), 'Arial', 10);
				$pdf->printLn( 168 + $adjx, 55 + $adjy,  $dprep, 'Arial', 10);
			endif;
		endforeach;
		$pdf->closePDF('testing.pdf');
		exit();

	}
	
	public function PDFIr8a2010($co=null, $wt=null, $dprep=null)
	{
		
		$fname = 'ir8a'.$this->_G('cyear').'.png';
//		if (file_exists($fname)) {
//		    $fname = 'ir8a'.$this->_G('cyear').'.png';
//		} else {
//		    $fname = 'ir8a'.$this->_G('cyear').'.jpg';
//		}
//		var_dump(SF_ROOT_DIR . '/web/images/hr/'.$fname);
//		var_dump(SF_IMAGE_DIR. $fname );
//		exit();
		$pdf = new PdfLibrary();
		$pdf->addPage('Arial', 10, 'P');
		$pdf->myimage(SF_ROOT_DIR . '/web/images/hr/'.$fname, 0, 0 );
		$empInfo  = HrEmployeePeer::GetDatabyEmployeeNo($this->_G('employee_no'));
		$adjx = 3;
		$adjy = -.3;
		$pdf->printLn( 020 + $adjx, 7.7 + $adjy, $this->_G('rcb_no'), 'Arial', 11);
		$pdf->printLn( 110+ $adjx, 7.7 + $adjy, $empInfo->getEmployeeNo() . ($empInfo->getSinId()? ' / '. $empInfo->getSinId() : '') , 'Arial', 11);
		$pdf->printLn( 020+ $adjx, 9.3 + $adjy, $empInfo->getName(), 'Arial', 11);
		$pdf->printLn( 110+ $adjx, 9.3 + $adjy, DateUtils::DUFormat('d/m/Y', $empInfo->getDateOfBirth()), 'Arial', 11);
		$pdf->printLn( 140+ $adjx, 9.3 + $adjy, ($empInfo->getGender() == 'F')? 'FEMALE' :  'MALE' , 'Arial', 11);
		$pdf->printLn( 165+ $adjx, 9.3 + $adjy, $empInfo->getStatus(), 'Arial', 11);
		$pdf->printLn( 020+ $adjx, 11 + $adjy,  trim($empInfo->getStreet() .' '. $empInfo->getBldgRoomNo()), 'Arial', 8);
		if ($this->_G('assign') != 'OTHER'){
			$pdf->printLn( 110, 10.5,  $this->_G('assign'), 'Arial', 11);
		}else{
			$pdf->printLn( 110, 10.5,  $this->_G('nassign'), 'Arial', 11);
		}
		//$pdf->printLn( 115, 11,  $empInfo->getJobTitle(), 'Arial', 11);

		if ($empInfo->getDateResigned() )
		{
			$dateResigned = DateUtils::DUFormat('d/m/Y', $empInfo->getDateResigned());
		}else{
			$dateResigned = '';
		}

		if ($empInfo->getCommenceDate() )
		{
			if ($this->_G('cyear') == DateUtils::DUFormat('Y', $empInfo->getCommenceDate())){
				$dateCommence = DateUtils::DUFormat('d/m/Y', $empInfo->getCommenceDate());
			}else{
				$dateCommence = '';
			}
		}else{
			$dateCommence = '';
		}

		$pdf->printLn( 115, 12.6, $dateCommence, 'Arial', 11);
		$pdf->printLn( 170, 12.6,  $dateResigned, 'Arial', 11);

		$comDetail = ContribEmployeeIr8aPeer::GetYearlyEmployeeIr8a($this->_G('employee_no'), $this->_G('cyear'));
		if ($comDetail)
		{
//			var_dump($dateResigned);
//			exit();
			if (! $dateResigned):
				$pdf->printLn( 115, 14.5, 'JAN-DEC ' . $this->_G('cyear'), 'Arial', 11);
			else:
				//$pdf->printLn( 115, 14, 'JAN-test ' . $this->_G('cyear'), 'Arial', 11);
				$pdf->printLn( 115, 14.5, 'JAN-'.DateUtils::DUFormat('M', $dateResigned).' ' . $this->_G('cyear'), 'Arial', 11);
			endif;
			$pdf->printLn( 170, 14.5,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
			$pdf->printLn( 170, 41,  number_format($comDetail['gross_inc'], 2), 'Arial', 11);
			$pdf->printLn( 170, 47,  number_format($comDetail['cpf'], 2), 'Arial', 11);
			$pdf->printLn( 178, 50,  number_format($comDetail['don'], 2), 'Arial', 11);
			$pdf->printLn( 178, 51.5,  number_format($comDetail['mbf'], 2), 'Arial', 11);
		}

		$adjx = 3;
		$adjy = 1;
		$dprep = $dprep? $dprep : date('d-m-Y');
		$pdf->printLn( 55 + $adjx, 52.5 + $adjy,  $this->_G('erName'), 'Arial', 10);
		$pdf->printLn( 55 + $adjx, 53.8 + $adjy,  $this->_G('erAddr'), 'Arial', 10);
		$pdf->printLn( 40 + $adjx, 54.8 + $adjy,  $this->_G('erCPer'), 'Arial', 10);
		$pdf->printLn( 80 + $adjx, 55 + $adjy,  $this->_G('designation'), 'Arial', 10);
		$pdf->printLn( 115 + $adjx, 55 + $adjy, $this->_G('contact_no'), 'Arial', 10);
		$pdf->printLn( 168 + $adjx, 55 + $adjy,  $dprep, 'Arial', 10);

		$pdf->closePDF('testing.pdf');
		exit();

	}
	
	public function executeJournalListing()
	{
		//    	echo 'here';
		//    	exit();
		if ($this->getRequest()->getMethod() == sfRequest::POST )
		{

			if ( $this->_G('journal') )
			{
				$this->PreviewJournalListing($this->_G('period_code'), $this->_G('company'), $this->_G('source'), $this->_G('nric_type'), $this->_G('mom_group'));
			}
			if ( $this->_G('income_only') )
			{
				$this->PreviewJournalIncomeOnly($this->_G('period_code'), $this->_G('company'), $this->_G('source'));
			}

			if ( $this->_G('dinner') )
			{
				$this->DinnerList($this->_G('period_code'), $this->_G('company'));
			}

			if ( $this->_G('employment') )
			{
				$this->PreviewEmploymentGroup($this->_G('period_code'), $this->_G('company'), $this->_G('egroup'), $this->_G('target'));
			}


			return sfView::NONE;
		}
	}
	
	public function PreviewJournalListing($batch, $company, $mess, $nric = null, $momgroup= null)
	{
		$momgroups = $momgroup? array($momgroup) : array('T.C. Khoo Mfg', 'T.C. Khoo Svs');
		switch($mess)
		{
			case 'BANK':
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankPerCompany($batch, $company);
				break;
			case 'CASH':
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashPerCompany($batch, $company);
				break;
			case 'CHEQUEANDBANK':
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankChequePerCompany($batch, $company);
				break;
			case 'ALL':
				$company = ($company <> 'ALL') ? $company : '';
//				var_dump($company);
//				exit();
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListbyCompany($batch, $company);
				break;
			default    :
				$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforChequePerCompany($batch, $company);
				break;
		}
//		var_dump($empNoList);
//		exit();
		$empData = array('empno'=>array(), 'name'=>array(), 'basic'=>array(),
                         'ot'=>array(), 'cbs'=>array(), 'ap'=>array(), 
                         'adv_ot'=>array(), 'meal'=>array(), 'cdac'=>array(), 
                         'sinda'=>array(), 'mbmf'=>array(),  'others'=>array(), 
                         'all'=>array(), 'bk'=>array(),  'cpf'=>array(),
                         'ha'=>array(), 'lv'=>array(),  'mr'=>array(),
                         'ml'=>array(), 'td'=>array(),  'ul'=>array(),
                         'total'=>array());
		// $empNoList = array('S1553425G');
		$empList = array();
		foreach ($empNoList as $empno):
			switch($nric):
				case 'SPR':
					if (substr($empno, 0, 1) == 'S'):
						 $empList[$empno] = $empno;
					endif;
					break;
				case 'FW':
					if (substr($empno, 0, 1) !== 'S'):
						 $empList[$empno] = $empno;
					endif;
					break;
				default:
					$empList[$empno] = $empno;
					break;
			endswitch; 
		endforeach;
		$empNoList = $empList;
		foreach ($empList as $kemp=>$vno)
		{
			switch($mess)
			{
				case 'BANK':
					$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($batch, $vno);
					break;
				case 'CASH':
					$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCash($batch, $vno);
					break;
				case 'ALL':	
					$data = PayEmployeeLedgerArchivePeer::GetEmployeeData($batch, $vno);
					break;
				case 'CHEQUE':
					$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCheque($batch, $vno);
					break;
				case 'CHEQUEANDBANK':
					$data = PayEmployeeLedgerArchivePeer::GetEmployeeDataforChequeandBank($batch, $vno);
					break;
				default    :
			}
			
			$empno = '';
			$name  = '';
			$basic = 0;
			$ot    = 0;
			$bank  = 0;
			$ap    = 0;
			$advot = 0;
			$others= 0;
			$tot   = 0;
			$meal  = 0;
			$cdac  = 0;
			$sinda = 0;
			$mbmf  = 0;
			$all   = 0;
			$bk    = 0;
			$cpf   = 0;
			$ha    = 0;
			$lv    = 0;
			$mr    = 0;
			$ml    = 0;
			$td    = 0;
			$ul    = 0;
			foreach($data as $rec)
			{
				switch($rec->getAcctCode())
				{
					case 'AL':
						$all = $all + $rec->getAmount();
						break;
						//                    case 'BK':
						//                        $bk = $bk + $rec->getAmount();
						//                        break;
					case 'BP':
						$basic = $basic + $rec->getAmount();
						break;
					case 'CPF':
						$cpf = $cpf + $rec->getAmount();
						break;
					case 'HA':
						$ha = $ha + $rec->getAmount();
						break;
					case 'LV':
						$lv = $lv + $rec->getAmount();
						break;
					case 'MR':
						$mr = $mr + $rec->getAmount();
						break;
					case 'ML':
						$ml = $ml + $rec->getAmount();
						break;
					case 'TD':
						$td = $td + $rec->getAmount();
						break;
					case 'UL':
						$ul = $ul + $rec->getAmount();
						break;

					case 'PI':
						$basic = $basic + $rec->getAmount();
						break;
					case 'CBS':
						$bank  = $bank + $rec->getAmount();
						break;
					case 'AP':
						$ap  = $ap + $rec->getAmount();
						break;
					case 'OT':
						if ($rec->getAmount() > 0)
						{
							$ot = $ot + $rec->getAmount();
						}else{
							$advot = $advot + $rec->getAmount();
						}
						break;
					case 'MEAL':
						$meal  = $meal + $rec->getAmount();
						break;
					case 'CDAC':
						$cdac  = $cdac + $rec->getAmount();
						break;
					case 'SINDA':
						$sinda  = $sinda + $rec->getAmount();
						break;
					case 'MBMF':
						$mbmf  = $mbmf + $rec->getAmount();
						break;

					default:
						$others = $others + $rec->getAmount();
						break;
				}
				$empno = $rec->getEmployeeNo();
				$name  = $rec->getName();
//                echo $empno .' - '.  $rec->getAcctCode() .' = ' . $rec->getAmount() . ' [ot] ' . $ot;
//                echo '<br>';
				$tot = $tot + $rec->getAmount();
			}
			$empData['empno'][]    = $empno;
			$empData['name'][]     = $name;
			$empData['basic'][]    = $basic;
			$empData['ot'][]       = $ot + $advot;
			$empData['cbs'][]      = $bank;
			$empData['ap'][]       = $ap;
			$empData['adv_ot'][]   = $advot;
			$empData['meal'][]     = $meal + $mr;
			$empData['cdac'][]     = $cdac;
			$empData['sinda'][]    = $sinda;
			$empData['mbmf'][]     = $mbmf;

			$empData['all'][]   = $all + $ha;
			$empData['bk'][]   = $bk;
			$empData['cpf'][]   = $cpf;
			//$empData['ha'][]   = $ha;
			$empData['lv'][]   = $lv;
			//$empData['mr'][]   = $mr;
			$empData['ml'][]   = $ml;
			//$empData['td'][]   = $td;
			$empData['ul'][]   = $ul + $td;

			$empData['others'][]   = $others;
			$empData['total'][]    = $tot;
		}
		$extra = new ComputeCPF();
		$pdf = new PdfLibrary();
		$gross = 0;
		$amt = 0;
		$xpos = 0;
		$y = 5;
		$x = 13;
		$sdt = $this->GetStartDate($batch);
		$edt = $this->GetEndDate($batch);
		$pdf->addPage('Arial', 10, 'L');
		$pdf->printTCKhooHeader();
		$comp = $company;
		$bankCash = $mess;
		if ($company == 'ALL'):
			$comp = '';
			$bankCash = 'Monthly Payroll';
		endif;
		$pdf->printBoldLn( $x,    $xpos++   + $y, 'JOURNAL LISTING  '.$momgroup, 'Arial', 10);
		$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$bankCash.')','Arial', '10' );
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME           ALL       MBMF      BASIC    CBS       SINDA    MEAL         ML          OT         AP         CDAC        CPF UNPDALL UL        OTHERS   TOTAL', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
		$seq = 1;
		$pos = 0;
		//$y = 5;
		//setlocale(LC_MONETARY, 'en_SG');
		$gross = 0;
		$gall = 0;
		$gmbm = 0;
		$gbas = 0;
		$gcbs = 0;
		$gsin = 0;
		$gmea = 0;
		$gml  = 0;
		$got  = 0;
		$gap  = 0;
		$gcda = 0;
		$gcpf = 0;
		$glv  = 0;
		$gul  = 0;
		$goth = 0;
		foreach ($empNoList as $kemp=>$vno)
		{
			$employeeDetail = HrEmployeePeer::GetDatabyEmployeeNo($empData['empno'][$pos]);
			//echo $empData['name'][$pos] .' '.$batch . ' ' . $employeeDetail->getMomGroup() .'<br>';
			if (in_array($employeeDetail->getMomGroup(), $momgroups)):
				if ($xpos + $y == 38)
				{
					$xpos = 1;
					$y = 1;
					$pdf->Footer();
					$pdf->addPage('Arial', 10, 'L');
					$pdf->printBoldLn( $x,    $xpos++   + $y, 'JOURNAL LISTING  '.$comp, 'Arial', 10);
					$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$bankCash.')','Arial', '10' );
					$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
					$pdf->printLn( $x,       $xpos++   + $y, ' SEQ#                    NAME           ALL       MBMF      BASIC    CBS       SINDA    MEAL         ML          OT         AP         CDAC        CPF UNPDALL UL        OTHERS   TOTAL', 'Arial', 10);
					$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================' );
				}
				$total = 0;
				$total = $total + $empData['all'][$pos] + $empData['bk'][$pos] +
				$empData['basic'][$pos] + $empData['cbs'][$pos] +
				$empData['meal'][$pos] + $empData['ml'][$pos] + $empData['ot'][$pos] +
				$empData['ap'][$pos] + $empData['cdac'][$pos] + $empData['cpf'][$pos] +
				$empData['lv'][$pos] + $empData['ul'][$pos] + $empData['others'][$pos] +
				$empData['mbmf'][$pos] + $empData['sinda'][$pos];
				// + $empData['ha'][$pos]
	
	
				
				$pdf->printLn( $x-10,      $xpos   + $y, $seq++.'.', 'Arial', 7);
				$pdf->printLn( $x-5,      $xpos   + $y, $employeeDetail->getSinId(), 'Arial', 7);
				$pdf->printLn( $x+10,   $xpos   + $y, substr($empData['name'][$pos], 0, 20), 'Arial', 8 );
				$pdf->printLn( $x+50,   $xpos   + $y, money_format('%i', $empData['all'][$pos]));
				$pdf->printLn( $x+65,   $xpos   + $y, money_format('%i', $empData['mbmf'][$pos]));
				$pdf->printLn( $x+80,   $xpos   + $y, money_format('%i', $empData['basic'][$pos]));
				$pdf->printLn( $x+95,   $xpos   + $y, money_format('%i', $empData['cbs'][$pos]));
				$pdf->printLn( $x+110,  $xpos   + $y, money_format('%i', $empData['sinda'][$pos]));
				$pdf->printLn( $x+125,  $xpos   + $y, money_format('%i', $empData['meal'][$pos]));
				$pdf->printLn( $x+140,  $xpos   + $y, money_format('%i', $empData['ml'][$pos]));
				$pdf->printLn( $x+155,  $xpos   + $y, money_format('%i', $empData['ot'][$pos]));
				$pdf->printLn( $x+170,  $xpos   + $y, money_format('%i', $empData['ap'][$pos]));
				$pdf->printLn( $x+185,  $xpos   + $y, money_format('%i', $empData['cdac'][$pos]));
				$pdf->printLn( $x+200,  $xpos   + $y, money_format('%i', $empData['cpf'][$pos]));
				$pdf->printLn( $x+215,  $xpos   + $y, money_format('%i', $empData['lv'][$pos]));
				$pdf->printLn( $x+230,  $xpos   + $y, money_format('%i', $empData['ul'][$pos]));
				$pdf->printLn( $x+245,  $xpos   + $y, money_format('%i', $empData['others'][$pos]));
				$pdf->printLn( $x+260,  $xpos   + $y, money_format('%i', $total));
	
	
				$gross = $gross + $total;
				$gall = $gall  + $empData['all'][$pos];
				$gmbm = $gmbm  + $empData['mbmf'][$pos];
				$gbas = $gbas  + $empData['basic'][$pos];
				$gcbs = $gcbs  + $empData['cbs'][$pos];
				$gsin = $gsin  + $empData['sinda'][$pos];
				$gmea = $gmea  + $empData['meal'][$pos];
				$gml  = $gml   + $empData['ml'][$pos];
				$got  = $got   + $empData['ot'][$pos];
				$gap  = $gap   + $empData['ap'][$pos];
				$gcda = $gcda  + $empData['cdac'][$pos];
				$gcpf = $gcpf  + $empData['cpf'][$pos];
				$glv  = $glv   + $empData['lv'][$pos];
				$gul  = $gul   + $empData['ul'][$pos];
				$goth = $goth  + $empData['others'][$pos];
	
				$xpos ++;
			else:
				//echo $empData['name'][$pos] .' '.$employeeDetail->getName() . ' ' . $employeeDetail->getMomGroup() .'<br>';
				//echo $empData['empno'][$pos] . '<br>';
			endif;
			$pos++;

		}
		$pdf->printLn( $x,     $xpos++   + $y, '****************************************************************************************************************************************************************************************************' );
		$pdf->printLn( $x+50,   $xpos   + $y, money_format('%i', $gall), 'Arial', 8);
		$pdf->printLn( $x+65,   $xpos   + $y, money_format('%i', $gmbm), 'Arial', 8);
		$pdf->printLn( $x+80,   $xpos   + $y, money_format('%i', $gbas), 'Arial', 8);
		$pdf->printLn( $x+95,   $xpos   + $y, money_format('%i', $gcbs), 'Arial', 8);
		$pdf->printLn( $x+110,  $xpos   + $y, money_format('%i', $gsin), 'Arial', 8);
		$pdf->printLn( $x+125,  $xpos   + $y, money_format('%i', $gmea), 'Arial', 8);
		$pdf->printLn( $x+140,  $xpos   + $y, money_format('%i', $gml), 'Arial', 8);
		$pdf->printLn( $x+155,  $xpos   + $y, money_format('%i', $got), 'Arial', 8);
		$pdf->printLn( $x+170,  $xpos   + $y, money_format('%i', $gap), 'Arial', 8);
		$pdf->printLn( $x+185,  $xpos   + $y, money_format('%i', $gcda), 'Arial', 8);
		$pdf->printLn( $x+200,  $xpos   + $y, money_format('%i', $gcpf), 'Arial', 8);
		$pdf->printLn( $x+215,  $xpos   + $y, money_format('%i', $glv), 'Arial', 8);
		$pdf->printLn( $x+230,  $xpos   + $y, money_format('%i', $gul), 'Arial', 8);
		$pdf->printLn( $x+245,  $xpos   + $y, money_format('%i', $goth), 'Arial', 8);
		$pdf->printBoldLn( $x+260,  $xpos   + $y, money_format('%i', $gross), 'Arial', 8);

		//$pdf->printBoldLn( $x+220, $xpos++   + $y, 'TOTAL:   '.money_format('%=*(#8.2n', $gross), 'Arial', 12 );
		$pdf->Footer();
		
		$xpos = 1;
		$y = 1;
		$pdf->Footer();
		$pdf->addPage('Arial', 10, 'L');
		$pdf->printBoldLn( $x,    $xpos++   + $y, 'JOURNAL LISTING  '.$comp, 'Arial', 10);
		$pdf->printBoldLn( $x,    $xpos++   + $y, 'for '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$bankCash.')','Arial', '10' );
		$pdf->printLn( $x,       $xpos++   + $y, '====================================================================================================================================');
		$pdf->printBoldLn( $x,       $xpos++   + $y, ' LEGEND ', 'Arial', 10);
		$x = $x + 10;
		$pdf->printLn( $x,       $xpos++   + $y, ' ALL - ALLOWANCE', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' MBMF - DONATION', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' BASIC - BASIC PAY', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' CBS - BANK SUBSIDY', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' SINDA - DONATION', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' MEAL - MEAL ALLOWANCE', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' ML - MONTHLY ALLOWANCE', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' OT - OVERTIME', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' AP - ADVANCE PAY', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' CDAC - DONATION', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' CPF - EMPLOYEE SHARE', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' REFUND - ANY REFUND', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' UL - UNPAID LEAVE', 'Arial', 10);
		$pdf->printLn( $x,       $xpos++   + $y, ' OTHERS - ADJUSTMENT ', 'Arial', 10);
		$pdf->Footer();
		$pdf->closePDF('testing.pdf');

	}
	
	
	public function executeAcctDistributionPrint()
	{
		if ($this->getRequest()->getMethod() == sfRequest::POST )
		{
			$pCode = $this->_G('period_code');
			$acct  = $this->_G('acct_code');
			$comp  = $this->_G('company');
			$src   = $this->_G('source');
			$list  = PayEmployeeLedgerArchivePeer::GetAllDatabyPeriodCodeAcctCode($pCode, $acct, $src);
			if (! $list)
			{
				return sfView::NONE;
			}
			if ( $this->_G('printList'))
			{
				$this->AcctDistributionPreview($list, PayAccountCodePeer::GetDescriptionbyAcctCode($acct), $pCode, $comp, $src);
			}
	
			if ($this->_G('printGroup'))
			{
				$this->AccountDistPDF($pCode, 'ALL', $acct);
			}
	
			return sfView::NONE;
		}
	}
	
	public function AccountDistPDF($pcode, $mess, $acct)
	{
		//kebot
		$sdt = $this->GetStartDate($pcode);
		$edt = $this->GetEndDate($pcode);
		$pos = 0;
		$oldno = null;
		if ( $mess == ( 'BANK' ) )
		{
			$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankNoSubConbyCompany($pcode);
			$subconList= PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankSubConbyCompany($pcode);
		}
		if ( $mess == ( 'CASH' ) )
		{
			$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashNoSubConbyCompany($pcode);
			$subconList= PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCashSubConbyCompany($pcode);
		}
		if ( $mess == ( 'ALL' ) )
		{
			$empNoList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListNoSubConbyCompany($pcode);
			$subconList= PayEmployeeLedgerArchivePeer::GetEmployeeNoListforSubConbyCompany($pcode);
	
		}
		$empVoucher = array('empno'=>array(), 'name'=>array(), 'company'=>array(), 'salary'=>array(), 'wages'=>array());
		foreach($empNoList as $ke=>$empNo)
		{
			//$empNo = 'S7838275I';
			//$dtrmast = TkDtrmasterPeer::GetDatabyEmployeeNo($empNo);
			$empInfo = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
			if ( $mess == ( 'BANK' ) )
			{
				$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($pcode, $empNo);
			}
			if ( $mess == ( 'CASH' ) )
			{
				$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCash($pcode, $empNo);
			}
			if ( $mess == ( 'ALL' ) )
			{
				$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDatabyPeriodbyAcct($pcode, $empNo, $acct);
			}
			$salary = 0;
			$income = 0;
			$deduct = 0;
			$sal = 0;
			$wag = 0;
			$dname = '';
			$dco   = '';
			foreach ($data as $rec)
			{
				if ($rec->getAcctCode() == 'BP' || $rec->getAcctCode() == 'PI')
				{
					$salary = $salary + $rec->getAmount();
				}
	
				$income = $income + ( ($rec->getIncomeExpense() == 1 )? $rec->getAmount(): 0);
				$deduct = $deduct + ( ($rec->getIncomeExpense() == 2 )? $rec->getAmount(): 0);
				$dname = $rec->getName();
				$dco   = $rec->getCompany();
				//echo $rec->getName().' - '.$rec->getDescription().' - '.$rec->getAmount().'<br>';
			}
			//echo $dtrmast->getName() .' - '.  $dtrmast->getCompany() .' sal: '. $salary.' inc: '. $income.' ded: '. $deduct.'<br>';
			if ( $salary + $deduct < 0)
			{
				$sal = 0;
				$wag = $income + $deduct;
			}else{
				$sal = $salary + $deduct;
				$wag = $income - $salary;
			}
			//echo $empNo.' - '.$dname.' - '.$dco.' - '.$sal.' - '.$wag.'<br>';
			$empVoucher['empno'][]   = $empNo;
			$empVoucher['name'][]    = $dname;
			$empVoucher['company'][] = $dco;
			$empVoucher['salary'][]  = $sal;
			$empVoucher['wages'][]   = $wag;
			//exit();
		}
		//----------------------------------------------------- subcon
		$subCon = array('empno'=>array(), 'name'=>array(), 'company'=>array(), 'salary'=>array(), 'wages'=>array());
		foreach($subconList as $ke=>$empNo)
		{
			//$empNo = 'S2719062F';
			//$dtrmast = TkDtrmasterPeer::GetDatabyEmployeeNo($empNo);
			//$empInfo = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
			if ( $mess == ( 'BANK' ) )
			{
				$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($pcode, $empNo);
			}
			if ( $mess == ( 'CASH' ) )
			{
				$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCash($pcode, $empNo);
			}
			if ( $mess == ( 'ALL' ) )
			{
				$data      = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCashandBankbyAcct($pcode, $empNo, $acct);
			}
			$salary = 0;
			$income = 0;
			$deduct = 0;
			$sal = 0;
			$wag = 0;
			foreach ($data as $rec)
			{
				if ($rec->getAcctCode() == 'BP' || $rec->getAcctCode() == 'PI')
				{
					$salary = $salary + $rec->getAmount();
				}
	
				$income = $income + ( ($rec->getIncomeExpense() == 1 )? $rec->getAmount(): 0);
				$deduct = $deduct + ( ($rec->getIncomeExpense() == 2 )? $rec->getAmount(): 0);
				//echo $rec->getName().' - '.$rec->getDescription().' - '.$rec->getAmount().'<br>';
			}
			//echo $dtrmast->getName() .' - '.  $dtrmast->getCompany() .' sal: '. $salary.' inc: '. $income.' ded: '. $deduct.'<br>';
			if ( $salary + $deduct < 0)
			{
				$sal = 0;
				$wag = $income + $deduct;
			}else{
				$sal = $salary + $deduct;
				$wag = $income - $salary;
			}
	
			$subCon['empno'][]   = $empNo;
			$subCon['name'][]    = $rec->getName();
			$subCon['company'][] = $rec->getCompany();
			$subCon['salary'][]  = $sal;
			$subCon['wages'][]   = $wag;
			//exit();
		}
	
	
	
		$wacro= 0;
		$wmcs = 0;
		$wnano= 0;
		$wtck = 0;
		$sacro= 0;
		$smcs = 0;
		$snano= 0;
		$stck = 0;
	
		$tot = 0;
		$pos = 0;
		$total = 0;
		$others = 0;
		foreach ($empVoucher['company'] as $rec)
		{
			switch( strtolower($rec))
			{
				case 'acro solution':
					$wacro = $wacro + $empVoucher['wages'][$pos] ;
					$sacro = $sacro + $empVoucher['salary'][$pos] ;
					break;
				case 'micronclean':
					$wmcs = $wmcs + $empVoucher['wages'][$pos] ;
					$smcs = $smcs + $empVoucher['salary'][$pos] ;
					break;
				case 'nanoclean':
					$wnano = $wnano + $empVoucher['wages'][$pos] ;
					$snano = $snano + $empVoucher['salary'][$pos] ;
					break;
				case 't.c. khoo':
					$wtck = $wtck + $empVoucher['wages'][$pos] ;
					$stck = $stck + $empVoucher['salary'][$pos] ;
					break;
				default:
					$others = $others + $total;
					break;
			}
			//echo $pos .'. '. $empCash['name'][$pos] .'  wages: '. $empCash['wages'][$pos] .'  salary: '. $empCash['salary'][$pos] .' = '. ($empCash['wages'][$pos] + $empCash['salary'][$pos]). '<br>';
			//            $tot =  $tot + ($empCash['wages'][$pos] + $empCash['salary'][$pos]);
			$pos++;
		}
	
	
		$scacro= 0;
		$scmcs = 0;
		$scnano= 0;
		$sctck = 0;
		$scothers= 0;
		$pos = 0;
		foreach ($subCon['company'] as $rec)
		{
			switch( strtolower($rec))
			{
				case 'acro solution':
					$scacro = $scacro + $subCon['salary'][$pos] + $subCon['wages'][$pos] ;
					break;
				case 'micronclean':
					$scmcs = $scmcs   + $subCon['salary'][$pos] + $subCon['wages'][$pos];
					break;
				case 'nanoclean':
					$scnano = $scnano + $subCon['salary'][$pos] + $subCon['wages'][$pos];
					break;
				case 't.c. khoo':
					$sctck = $sctck   + $subCon['salary'][$pos] + $subCon['wages'][$pos];
					break;
			}
			$pos++;
		}
	
	
		$pdf = new PdfLibrary();
		$x = 0;
		$y = 0;
	
		$pdf->addPage();
		$xpos = 2;
	
		$pdf->printTCKhooHeader();
		$y = 5;
		$x = 13;
		$gross = 0;
		$amt = 0;
		//        $pdf->addPage('Arial', 10);
		setlocale(LC_MONETARY, 'en_US');
		$pdf->printBoldLn( $x,    $xpos   + $y, 'ACCOUNT DISTRIBUTION', 'Arial', 10);
		$pdf->printLn( $x+120,    $xpos++ + $y, 'Voucher No:  ___________________');
		$pdf->printLn( $x,        $xpos   + $y, 'T.C. KHOO & CO. (PTE) LTD.');
		$pdf->printLn( $x+120,    $xpos++ + $y, 'DATE    : '.Date('d-M-Y'));
		$y++;
		$pdf->printBoldLn( $x+40,    $xpos++ + $y, 'PAY TO: PAYROLL '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')', 'Arial', 12);
		$pdf->printBoldLn( $x+60,    $xpos++ + $y, PayAccountCodePeer::GetDescriptionbyAcctCode( $acct ), 'Arial', 12);
		$pdf->printBoldLn( $x+50,    $xpos++ + $y, '', 'Arial', 10);
		$y++;
		$pdf->printLn( $x+60,    $xpos++   + $y, 'D E S C R I P T I O N                                                   AMOUNT', 'Arial', 12);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '                 GIRO                                    ACRO                   MCS                    NANO                  TCK          ', 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
		$seq = 1;
		$pdf->printLn( $x,    $xpos     + $y, '                 WAGES', 'Arial', 10);
		//money_format('%(#10n', $number)
		$pdf->printLn( $x+50, $xpos     + $y, money_format('%(#8n', $wacro), 'Arial', 10);
		$pdf->printLn( $x+78, $xpos     + $y, money_format('%(#8n', $wmcs), 'Arial', 10);
		$pdf->printLn( $x+108,$xpos     + $y, money_format('%(#8n', $wnano), 'Arial', 10);
		$pdf->printLn( $x+138,$xpos     + $y, money_format('%(#8n', $wtck), 'Arial', 10);
		$pdf->printLn( $x+160, $xpos++     + $y, money_format('%(#8n', $wacro+$wmcs+$wnano+$wtck), 'Arial', 10);
		$pdf->printLn( $x+10,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x,    $xpos     + $y, '                 SALARY', 'Arial', 10);
		$pdf->printLn( $x+50, $xpos     + $y, money_format('%(#8n', $sacro), 'Arial', 10);
		$pdf->printLn( $x+78, $xpos     + $y, money_format('%(#8n', $smcs), 'Arial', 10);
		$pdf->printLn( $x+108,$xpos     + $y, money_format('%(#8n', $snano), 'Arial', 10);
		$pdf->printLn( $x+138,$xpos     + $y, money_format('%(#8n', $stck), 'Arial', 10);
		$pdf->printLn( $x+160, $xpos++     + $y, money_format('%(#8n', $sacro+$smcs+$snano+$stck), 'Arial', 10);
		$pdf->printLn( $x+10,    $xpos++   + $y, '---------------------------------------------------------------------------------------------------------------------------------------------------', 'Arial', 10);
		$pdf->printLn( $x,    $xpos     + $y, '                 SUBCON', 'Arial', 10);
		$pdf->printLn( $x+50, $xpos     + $y, money_format('%(#8n', $scacro), 'Arial', 10);
		$pdf->printLn( $x+78, $xpos     + $y, money_format('%(#8n', $scmcs), 'Arial', 10);
		$pdf->printLn( $x+108,$xpos     + $y, money_format('%(#8n', $scnano), 'Arial', 10);
		$pdf->printLn( $x+138,$xpos     + $y, money_format('%(#8n', $sctck), 'Arial', 10);
		$pdf->printLn( $x+160, $xpos++     + $y, money_format('%(#8n', $scacro+$scmcs+$scnano+$sctck), 'Arial', 10);
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
		$pdf->printLn( $x,    $xpos     + $y, 'TOTAL:' );
		$pdf->printLn( $x+50, $xpos     + $y, money_format('%(#8n', $sacro+$wacro+$scacro), 'Arial', 10);
		$pdf->printLn( $x+78, $xpos     + $y, money_format('%(#8n', $smcs+$wmcs+$scmcs), 'Arial', 10);
		$pdf->printLn( $x+108,$xpos     + $y, money_format('%(#8n', $snano+$wnano+$scnano), 'Arial', 10);
		$pdf->printLn( $x+138,$xpos     + $y, money_format('%(#8n', $stck+$wtck+$sctck), 'Arial', 10);
		$pdf->printBoldLn( $x+160, $xpos++     + $y, money_format('%(#8n', $sacro+$wacro+$smcs+$wmcs+$snano+$wnano+$stck+$wtck+$scacro+$scmcs+$scnano+$sctck), 'Arial', 10);
		//        $pdf->pritnBoldln($x+160, $xpos++     + $y, )
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================' , 'Arial', 10);
		$pdf->printLn( $x+79,     $xpos++   + $y, $pdf->Footer() );
		$compGroup = array('Acro Solution', 'Micronclean', 'NanoClean', 'T.C. Khoo');
		//$compGroup = array('micronclean', 'nanoclean', 't.c. khoo');
		//$compGroup = array('micronclean');
		//------------------------------------------------------------- per company
		foreach ($compGroup as $cGroup)
		{
			$pos = 0;
			$xpos = 0;
			$sal = 0;
			$wage = 0;
			$cntr = 0;
			foreach ($empVoucher['company'] as $rec)
			{
				if ( ($rec == $cGroup ) && ($empVoucher['salary'][$pos] + $empVoucher['wages'][$pos]) <> 0 )
				{
					if ($xpos == 54 || $xpos == 0)
					{
						$x = 13;
						$y = 2;
						$pdf->addPage();
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printLn( $x,    $xpos++   + $y, $rec .'  '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.')', 'Arial', 10);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
						$pdf->printLn( $x,     $xpos++   + $y, 'SEQ #               NAME                          COMPANY                SUBCON                   SALARY             TOTAL', 'Arial', 11);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
						//$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
					}
					//$pdf->printLn ($x, $xpos + $y, $pos+1 .'. '. $empVoucher['name'][$pos] .'  wages: '. $empVoucher['wages'][$pos] .'  salary: '. $empVoucher['salary'][$pos] .' = '. ($empVoucher['wages'][$pos] + $empVoucher['salary'][$pos]) );
					$pdf->printLn( $x+2,     $xpos   + $y, $cntr+1 .'. ', 'Arial', 10);
					$pdf->printLn( $x+12,     $xpos   + $y, $empVoucher['name'][$pos], 'Arial', 10);
					$pdf->printLn( $x+70,     $xpos   + $y, $empVoucher['company'][$pos], 'Arial', 10);
					$pdf->printLn( $x+100,     $xpos   + $y, money_format('%(#8n', $empVoucher['wages'][$pos]), 'Arial', 10);
					$pdf->printLn( $x+135,    $xpos   + $y, money_format('%(#8n', $empVoucher['salary'][$pos]), 'Arial', 10);
					$pdf->printLn( $x+160,    $xpos++   + $y, money_format('%(#8n', ($empVoucher['wages'][$pos] + $empVoucher['salary'][$pos])), 'Arial', 10);
					$sal  = $sal  + $empVoucher['salary'][$pos];
					$wage = $wage + $empVoucher['wages'][$pos];
					$cntr++;
				}
				$pos++;
			}
			if ($wage <> 0 || $sal <> 0 )
			{
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
				$pdf->printBoldLn( $x,    $xpos     + $y, 'TOTAL', 'Arial', 10 );
				$pdf->printBoldLn( $x+100 ,    $xpos     + $y, money_format('%(#8n', $wage), 'Arial', 10 );
				$pdf->printBoldLn( $x+135,    $xpos     + $y, money_format('%(#8n', $sal), 'Arial', 10 );
				$pdf->printBoldLn( $x+160,    $xpos++   + $y, money_format('%(#8n', $wage+$sal), 'Arial', 10 );
			}
	
			$sal = 0;
			$wage = 0;
			$pos = 0;
			$xpos = 0;
			$cntr = 0;
			foreach ($subCon['company'] as $rec)
			{
				if ( ($rec == $cGroup )   && ($subCon['salary'][$pos] + $subCon['wages'][$pos]) <> 0 )
				{
	
					if ($xpos == 54 || $xpos == 0)
					{
						$x = 13;
						$y = 2;
						$pdf->addPage();
						$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
						$xpos = 0;
						$pdf->printLn( $x,    $xpos++   + $y, $rec .'  '.DateUtils::DUFormat('F j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt).' ('.$mess.') - SUB-CON', 'Arial', 10);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
						$pdf->printLn( $x,     $xpos++   + $y, 'SEQ #               NAME                          COMPANY                SUBCON                   SALARY             TOTAL', 'Arial', 11);
						$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
						//$pdf->printLn( $x,     $xpos++   + $y, $pdf->Footer() );
					}
					//$pdf->printLn ($x, $xpos + $y, $pos+1 .'. '. $subCon['name'][$pos] .'  wages: '. $subCon['wages'][$pos] .'  salary: '. $subCon['salary'][$pos] .' = '. ($subCon['wages'][$pos] + $subCon['salary'][$pos]) );
					$pdf->printLn( $x+2,     $xpos   + $y, $cntr+1 .'. ', 'Arial', 10);
					$pdf->printLn( $x+12,     $xpos   + $y, $subCon['name'][$pos], 'Arial', 10);
					$pdf->printLn( $x+70,     $xpos   + $y, $subCon['company'][$pos], 'Arial', 10);
					$pdf->printLn( $x+100,     $xpos   + $y, money_format('%(#8n', $subCon['wages'][$pos]), 'Arial', 10);
					$pdf->printLn( $x+135,    $xpos   + $y, money_format('%(#8n', $subCon['salary'][$pos]), 'Arial', 10);
					$pdf->printLn( $x+160,    $xpos++   + $y, money_format('%(#8n', ($subCon['wages'][$pos] + $subCon['salary'][$pos])), 'Arial', 10);
					$sal  = $sal  + $subCon['salary'][$pos];
					$wage = $wage + $subCon['wages'][$pos];
					$cntr++;
				}
				$pos++;
			}
			if ($wage <> 0 || $sal <> 0 )
			{
				$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
				$pdf->printBoldLn( $x,    $xpos     + $y, 'TOTAL', 'Arial', 10 );
				$pdf->printBoldLn( $x+100 ,    $xpos     + $y, money_format('%(#8n', $wage), 'Arial', 10 );
				$pdf->printBoldLn( $x+135,    $xpos     + $y, money_format('%(#8n', $sal), 'Arial', 10 );
				$pdf->printBoldLn( $x+160,    $xpos++   + $y, money_format('%(#8n', $wage+$sal), 'Arial', 10 );
			}
			//------------------------------------------------------------- per company
		}
		$pdf->closePDF('testing.pdf');
		return sfView::NONE;
	
	
	}
	
	
	public function AcctDistributionPreview($list, $acct, $pCode, $comp, $src)
	{
		$sdt = $this->GetStartDate($pCode);
		$edt = $this->GetEndDate($pCode);
	
		$pdf = new PdfLibrary();
		$x = 0;
		$y = 0;
	
		$pdf->addPage();
		$xpos = 2;
	
		//$pdf->image('/web/images/hr/mclogo.jpg', $x, $y);
		$pdf->printTCKhooHeader();
		$x = 13;
		$y = 5;
		$pdf->printBoldLn( $x+70,   $xpos++ + $y, $acct.' Masterlist','Arial', '13' );
		$pdf->printBoldLn( $x+55,   $xpos++ + $y, ' For the Payroll Period '. DateUtils::DUFormat('M j - ', $sdt).DateUtils::DUFormat('j,', $edt).DateUtils::DUFormat(' Y', $sdt) ,'Arial', '12' );
		$xpos++;
		$pdf->printLn( $x,          $xpos++   + $y, '=========================================================================================', 'Arial', 10);
		$pdf->printLn( $x,          $xpos++   + $y, '        SEQ                        NAME                                                                        COMPANY                      AMOUNT              ', 'Arial', 10);
		$pdf->printLn( $x,          $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
		$seq = 1;
		setlocale(LC_MONETARY, 'en_US');
		$pos = 0;
		$tot = 0;
		$eGroup = HrEmployeePeer::OptionEmploymentGroup();
		$dCnt = 0;
		foreach($eGroup as $eGrp=>$ve)
		{
			foreach($list as $rec)
			{
				$nGrp = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($rec->getEmployeeNo(), array('employment_as'));
				if ($eGrp == $nGrp->get('EMPLOYMENT_AS'))
				{
					if ($comp <> 'ALL'  && $comp == $rec->getCompany() )
					{
						if ($xpos+$y == 55 || $xpos == 0)
						{
							$pdf->printBoldLn( $x, $xpos++ + $y, $pdf->Footer('seq #') );
							$pdf->addPage();
							$xpos = 1;
							$y = 1;
						}
						$pdf->printLn( $x+10,          $xpos    + $y, $seq++);
						$pdf->printLn( $x+25,          $xpos    + $y, $rec->getName());
						$pdf->printLn( $x+85,          $xpos    + $y, $eGrp);
						$pdf->printLn( $x+120,         $xpos    + $y, strtoupper($rec->getCompany()) );
						$pdf->printLn( $x+160,         $xpos++  + $y,  money_format('%(#8n', $rec->getAmount()));
						$tot = $tot + $rec->getAmount();
						$dCnt = $dCnt + $rec->getAmount();
					}
				}
			}
			if ($dCnt)
			{
				$pdf->printLn( $x+25,          $xpos    + $y, '----------------------------------------------------------------------------------------------------', 'Arial', 10 );
				$pdf->printLn( $x+145,         $xpos++    + $y,  money_format('%(#8n', $dCnt));
				$dCnt = 0;
			}
		}// foreach
		$pdf->printLn( $x,    $xpos++   + $y, '=========================================================================================', 'Arial', 10 );
		$pdf->printLn( $x+120,    $xpos     + $y, 'TOTAL: ');
		$pdf->printLn( $x+150,    $xpos     + $y, money_format('%(#8n', $tot));
		$pdf->closePDF('testing.pdf');
	
	}
	
}
