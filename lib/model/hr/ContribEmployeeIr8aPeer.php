<?php

/**
 * Subclass for performing query and update operations on the 'contrib_employee_ir8a' table.
 *
 *
 *
 * @package lib.model.hr
 */
class ContribEmployeeIr8aPeer extends BaseContribEmployeeIr8aPeer
{
	public static function GetPager($cd, $res = null)
	{
		$res = $res ? $res : 20;
		$startIndex = sfContext::getInstance()->getRequest()->getParameter('startIndex', 0);
		$rowsPerPage = sfContext::getInstance()->getRequest()->getParameter('results', $res);
		$page = (int) ( ($startIndex + 1) / $rowsPerPage);
		if (( ($startIndex + 1) % $rowsPerPage) != 0) {
			$page++;
		}

		$page = sfContext::getInstance()->getRequest()->getParameter('page', 1);

		$c = clone($cd);
		$pager = new sfPropelPager('ContribEmployeeIr8a', $rowsPerPage);
		//$pager = new sfPropelPager('PayEmployeeLedgerArchive', $rowsPerPage);

		$pager->setCriteria($c);
		$pager->setPage($page);
		$pager->init();
		return $pager;
	}


	public static function GenerateListing($period, $user, $empNo=null)
	{
		//$empNo = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankCheque($period);
		$chkList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCheckCPF($period);
		$bnkList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankCPF($period);
		$empList = array_merge($bnkList, $chkList);
		//$year = substr($period, 0, 4);
		if ($empNo){
			$empList = array(''=>$empNo);
		}
		foreach ($empList as  $val=>$empNo){
			//--------- amar singh, and lim tze seng not included
			if ($empNo == '83' || $empNo == 'S7434364C'){
				unset($empList[$val]);
			}
		}
		$cnt = 0;
		foreach($empList as $val=>$empNo){
			//echo $cnt++. ': ' .$empNo. '<br>';
			//$empNo = 'S8019101D';
			self::DeleteByEmployeePeriod($empNo, $period);
			if (in_array($empNo, $bnkList)) {
				$payInfo = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBank($period, $empNo);
			}else{
				$payInfo = PayEmployeeLedgerArchivePeer::GetEmployeeDataforCheque($period, $empNo);
			}
			if ($payInfo){
				$name = '';
				$company = '';
				$ginc = 0;
				$gded = 0;
				$natl = '';
				$ncode = '';
				$addr  = '';
				$amt = 0;
				$mbf = 0;
				$don = 0;
				$cpf = 0;
				$cpfer = 0;
				$ins = 0;
				$sal = 0;
				$oth = 0;
				$att = 0;
				$ginc =   PayEmployeeLedgerArchivePeer::GetIncomeTaxIncome($empNo, $period);
				$gded =   PayEmployeeLedgerArchivePeer::GetIncomeTaxDeduction($empNo, $period);
				
				foreach($payInfo as $r){
//					if ($r->getIncomeExpense() == 1){
//						$ginc += $r->getAmount();
//					}else{
//						$gded += $r->getAmount();
//					}
					switch(strtolower($r->getAcctCode())){
						case 'mbmf':
							$mbf = $r->getAmount() * -1;
							//$don += $r->getAmount() * -1;
							break;
						case 'cpf':
							$cpf += ($r->getAmount() * -1);
							$cpfer += ($r->getCpfEr() *-1);
							break;
//						case 'ot':
//							$sal += $r->getAmount();
//							break;
						case 'sinda':
							$don += $r->getAmount() * -1;
							break;
						case 'cdac':
							$don += $r->getAmount() * -1;
							break;
						default:
							//$oth += $r->getAmount();
							break;
							
					}
				}
//				var_dump ( $gded);
//				exit();
//				echo ' don: '.$don .'<br>';
//				echo 'mbf : '. $mbf.'<br>';
//				echo 'cpf : '. $cpf .'<br>';
//				exit(); 
				$oth = $gded + $don + $mbf + $cpf;
				$name = $r->getName();
				$company = $r->getCompany();
				
				//------------- employee number must be updated to the latest number, because a
				$empNo  = HrEmployeePeer::GetEmployeeNoByName($name);
				
				$natl = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($empNo, array('nationality'));
				$ncode = '';
				$addr  = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($empNo, array('bldg_room_no'));
				$amt = $ginc + $gded;


				$rec = new ContribEmployeeIr8a();
				$rec->setCreatedBy($user);
				$rec->setDateCreated(DateUtils::DUNow());
				$rec->setEmployeeNo($empNo);
				$rec->setName($name);
				$rec->setCompany($company);
				$rec->setPeriodCode($period);
				$rec->setGrossInc($ginc);
				$rec->setGrossDed($gded);
				$rec->setNationality($natl? $natl->get('NATIONALITY') : '');
				$rec->setNationalityCode($ncode);
				$rec->setAddress($addr? $addr->get('BLDG_ROOM_NO') : '');
				$rec->setAmount($ginc);
				$rec->setMbf($mbf);
				$rec->setCpf($cpf + $cpfer );
				$rec->setDonation($don);
				$rec->setInsurance($ins);
				$rec->setSalary($ginc);
				$rec->setBonus(0);
				$rec->setDirectorsFee(0);
				$rec->setOtherFee($oth);
				$rec->setCommission(0);
				$rec->setTransportAllowance(0);
				$rec->setEntertainment(0);
				$rec->setOtherAllowance(0);
				$rec->setCpfEm($cpf * -1);
				$rec->setCpfEr($cpfer * -1);
				$rec->setModifiedBy($user);
				$rec->setDateModified(DateUtils::DUNow());
				$rec->save();
			}
		}
		return;
	}

	public static function GenerateAllIncome($period, $user, $empNo=null)
	{
		//declare all income except for singaporean cash,confirmed by kathy and florence March 04, 2011
		$empList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListByPeriod($period);
//		$chkList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforCheckCPF($period);
//		$bnkList = PayEmployeeLedgerArchivePeer::GetEmployeeNoListforBankCPF($period);
//		$empList = array_merge($bnkList, $chkList);
		//$year = substr($period, 0, 4);
		if ($empNo){
			$empList = array(''=>$empNo);
		}
		foreach ($empList as  $empNo=>$name){
			//--------- amar singh, and lim tze seng not included
			//--------- lim tze seng included in 2012 incomeTax
			if ($empNo == '83') { // || $empNo == 'S7434364C'){
				unset($empList[$empNo]);
			}
		}
		$cnt = 0;
//		$empList = array('S7838275I'=>'');
// 		var_dump($empList);
// 		exit();
		foreach($empList as $empNo=>$name){
			self::DeleteByEmployeePeriod($empNo, $period);
			if (substr($empNo, 0, 1) == "S")
			{
				$payInfo = PayEmployeeLedgerArchivePeer::GetEmployeeDataforBankCheque($period, $empNo);
			}else{
				$payInfo = PayEmployeeLedgerArchivePeer::GetDatabyEmpNoPeriodCode($empNo, $period);
			}
//			var_dump($payInfo);
//			exit();
			if (!$payInfo){
//				echo $empNo.'<br>';
//				exit();
			}
			if ($payInfo){
				$name = '';
				$company = '';
				$ginc = 0;
				$gded = 0;
				$natl = '';
				$ncode = '';
				$addr  = '';
				$amt = 0;
				$mbf = 0;
				$don = 0;
				$cpf = 0;
				$cpfer = 0;
				$ins = 0;
				$sal = 0;
				$oth = 0;
				$att = 0;
				$NewEmpNo = '';
				$ginc =   PayEmployeeLedgerArchivePeer::GetIncomeTaxIncome($empNo, $period);
				$gded =   PayEmployeeLedgerArchivePeer::GetIncomeTaxDeduction($empNo, $period);
				
				foreach($payInfo as $r){
//					if ($r->getIncomeExpense() == 1){
//						$ginc += $r->getAmount();
//					}else{
//						$gded += $r->getAmount();
//					}
					switch(strtolower($r->getAcctCode())){
						case 'mbmf':
							$mbf = $r->getAmount() * -1;
							//$don += $r->getAmount() * -1;
							break;
						case 'cpf':
							$cpf += ($r->getAmount() * -1);
							$cpfer += ($r->getCpfEr() *-1);
							break;
//						case 'ot':
//							$sal += $r->getAmount();
//							break;
						case 'sinda':
							$don += $r->getAmount() * -1;
							break;
						case 'cdac':
							$don += $r->getAmount() * -1;
							break;
						default:
							//$oth += $r->getAmount();
							break;
							
					}
				}
				
				$oth = 0;
				$name = $r->getName();
				$company = $r->getCompany();
				
				//------------- employee number must be updated to the latest number, because a
				$NewEmpNo  = HrEmployeePeer::GetEmployeeNoByName($name);
				if ($NewEmpNo):
					$empNo = $NewEmpNo;
					//echo 'here';
				endif;
				
				$natl = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($empNo, array('nationality'));
				$ncode = '';
				$addr  = HrEmployeePeer::GetOptimizedDatabyEmployeeNo($empNo, array('bldg_room_no'));
				$amt = $ginc + $gded;
				
				$rec = new ContribEmployeeIr8a();
				$rec->setCreatedBy($user);
				$rec->setDateCreated(DateUtils::DUNow());
				$rec->setEmployeeNo($empNo);
				$rec->setName($name);
				$rec->setCompany($company);
				$rec->setPeriodCode($period);
				$rec->setGrossInc($ginc);
				$rec->setGrossDed($gded);
				$rec->setNationality($natl? $natl->get('NATIONALITY') : '');
				$rec->setNationalityCode($ncode);
				$rec->setAddress($addr? $addr->get('BLDG_ROOM_NO') : '');
				$rec->setAmount($ginc);
				$rec->setMbf($mbf);
				//$rec->setCpf($cpf + $cpfer );
				$rec->setCpf($cpf);
				$rec->setDonation($don);
				$rec->setInsurance($ins);
				$rec->setSalary($ginc);
				$rec->setBonus(0);
				$rec->setDirectorsFee(0);
				$rec->setOtherFee($oth);
				$rec->setCommission(0);
				$rec->setTransportAllowance(0);
				$rec->setEntertainment(0);
				$rec->setOtherAllowance(0);
				$rec->setCpfEm($cpf * -1);
				$rec->setCpfEr($cpfer * -1);
				$rec->setModifiedBy($user);
				$rec->setDateModified(DateUtils::DUNow());
				$rec->save();
			}
		}

		return;
	}
	
	
	public static function DeleteByEmployeePeriod($empNo, $period)
	{
		$c = new criteria();
		$c->add(self::EMPLOYEE_NO, $empNo);
		$c->add(self::PERIOD_CODE, $period);
		$rs = self::doDelete($c);
	}

	public static function GenerateTextFile($year, $hdr)
	{
		$elist = array();
		$pyear = $year;
		$period = $pyear.'-01-01';
		$periodList = array( 
			 self::YearMonthPeriodCode($pyear, '01')
			,self::YearMonthPeriodCode($pyear, '02')
			,self::YearMonthPeriodCode($pyear, '03')
			,self::YearMonthPeriodCode($pyear, '04')
			,self::YearMonthPeriodCode($pyear, '05')
			,self::YearMonthPeriodCode($pyear, '06')
			,self::YearMonthPeriodCode($pyear, '07')
			,self::YearMonthPeriodCode($pyear, '08')
			,self::YearMonthPeriodCode($pyear, '09')
			,self::YearMonthPeriodCode($pyear, '10')
			,self::YearMonthPeriodCode($pyear, '11')
			,self::YearMonthPeriodCode($pyear, '12')
			);
			
//		var_dump(DateUtils::DUFormat('Y' , self::GetStartDate($period)));
//		exit();
		//$empList = array('S7838275I' );
		$empList = self::GetListWhenTotalIncomeIsAtLeast(0, $periodList, $elist );
		PayEmployeeContribYearlyPeer::DeleteByYear($pyear);
		$mess = array();
		$f    = '_';
		$batch= 'O';  //A = amendment O = Original
		//------------------------------ header
		$mess[] = '0' . self::Sfil($hdr->getSource(), 1) 
		. $pyear
		. '08'
		. self::Sfil($hdr->getOrgIdType(), 1) . self::Sfil($hdr->getOrgIdNo(), 12, $f)
		. self::Sfil($hdr->getAuthorizedPerson(), 30)
		. self::Sfil($hdr->getAuthDesignation(), 30)
		. self::Sfil($hdr->getEmployer(), 60)
		. self::Sfil($hdr->getTelNo(), 20)
		. self::Sfil($hdr->getEmail(), 60)
		. $batch
		. Date('Ymd')
		. self::Sfil('DIVISION', 30, $f)
		. self::Sfil('IR8A', 10, $f)
		. self::Sfil('_', 930, $f)
		;

		//------------------------------ detail
		$cnt = 0;
		$amount = 0;
		$tsal = 0;
		$tbon = 0;
		$tdfe = 0;
		$toth = 0;
		$tdon = 0;
		$tcpf = 0;
		$tins = 0;
		$tmbf = 0;
		
		foreach($empList as $empNo){
			$r = self::GetYearlyDataByEmployeeNoPeriodList($empNo, $periodList);
			//$r = PayEmployeeLedgerArchivePeer::GetYearlyDataByEmployeeNoPeriodList($empNo, $periodList);
			$cnt ++;
			$emp = HrEmployeePeer::GetDatabyEmployeeNo($empNo);
			$mbf = self::AmountPresentation($r->get('MBF'));
			$donation = self::AmountPresentation($r->get('DONATION'));
			$insurance =  self::AmountPresentation($r->get('INSURANCE'));
			$salary = self::AmountPresentation($r->get('SALARY'));
			$bonus =   self::AmountPresentation($r->get('BONUS'));
			$dfee = self::AmountPresentation($r->get('DIRECTORS_FEE'));
			$cpf = self::AmountPresentation($r->get('CPF'));
			$others = 0; //intval($r->getOtherFee());

			$frDate = ($emp->getCommenceDate() < dateUtils::DUFormat('Y-01-01', self::GetStartDate($period)))?
					$pyear.'0101' :
					dateUtils::DUFormat('Ymd', $emp->getCommenceDate());
			$comm = $frDate;
			
			if ($emp->getDateResigned())
			{
				$toDate = ($emp->getDateResigned() > dateUtils::DUFormat('Y-12-31', self::GetStartDate($period)))? 
						$pyear.'1231' :
						dateUtils::DUFormat('Ymd', $emp->getDateResigned())  ; 
				$cess = $toDate;
			}else{
				$toDate = $pyear.'1231';
				$cess = $toDate;
			}
						
			$addr = ($emp->getBldgRoomNo()? $emp->getBldgRoomNo() : '35 Senoko Way, Woodlands East, 758751 Singapore');
			$addr ='';
			$house = '35';
			$street = 'Senoko Way';
			$level  = '';
			$unit   = '';
			$postal = '758751';
			

			$amount += $salary + $bonus + $dfee + $others;
			$tsal += $salary;
			$tbon += $bonus;
			$tdfe += $dfee;
			$toth += $toth;
			$tdon += $donation;
			$tcpf += $cpf;
			$tins += $insurance;
			$tmbf += $mbf;
			
			$frDate = '20150101';
			$toDate = '20151231';
			$comm = '20150101';
			$cess = '20151231';
//			var_dump($frDate);
//			var_dump($toDate);
//			echo '*********';
//			var_dump($comm);
//			var_dump($cess);
//			exit();

			$sinID = ($emp->getSinId()? $emp->getSinId() : $empNo);
			$mess[] = '1'
			. $emp->getTaxId()
			. self::Sfil($sinID, 12, $f)
			. self::Sfil($r->get('NAME'), 80, $f)
			. 'L'
			. self::Sfil($house, 10, $f)
			. self::Sfil($street, 32, $f)
			. self::Sfil($level, 3, $f)
			. self::Sfil($unit, 5, $f)
			. self::Sfil($postal, 6, $f)
			. self::Sfil('_', 90, $addr)
//			. self::Sfil('_', 30, $f)
//			. self::Sfil('_', 30, $f)
			. self::Sfil('_', 6, $f)
			. self::Sfil('_', 3, $f)
			. self::Sfil(ContribCountryCodePeer::NationalityCode($emp->getNationality()), 3)
			. self::Sfil($emp->getGender(), 1, $f)
			. self::Sfil(DateUtils::DUFormat('Ymd' , $emp->getDateOfBirth()), 8, $f)
			. self::Amtfil($salary + $bonus + $dfee + $others, 9, $f)
			. $frDate					//dateUtils::DUFormat('Y0101', self::GetStartDate($period))
			. $toDate 					//dateUtils::DUFormat('Y1231', self::GetEndDate($period))
			. self::Amtfil($mbf, 5, $f)
			. self::Amtfil($donation, 5, $f)
			. self::Amtfil($cpf, 7, $f)
			. self::Amtfil($insurance, 5, $f)
			. self::Amtfil($salary, 9, $f)
			. self::Amtfil($bonus, 9, $f)
			. self::Amtfil($dfee, 9, $f)
			. self::Amtfil($others, 9, $f)
			. self::Amtfil(0, 9, $f)
			. self::Sfil('_', 9, $f)
			. self::Amtfil(0, 9, $f)
			. self::Amtfil(0, 9, $f)
			. self::Sfil('_', 1, $f)	//benefits in-kind
			. self::Sfil('_', 1, $f)	//Section 45
			. self::Sfil('N', 1, $f)	//Income tax Borne by Employer
			. self::Sfil('_', 1, $f)	//Gratuity
			. self::Sfil('_', 1, $f)	//compensation retrenchment benefits 
			. self::Sfil('_', 1, $f)   	//approval obtained from IRAS
			. self::Sfil('_', 8, $f)	//date of Approval #27b
			. self::Sfil('_', 1, $f)
			. self::Sfil('_', 1, $f)
			. self::Sfil('_', 1, $f)  //line28: cessation yes/no
			. self::Sfil('_', 1, $f)  //leave blank
			. self::Amtfil(0, 11, $f)
			. self::Sfil('_', 8, $f)	// commission from
			. self::Sfil('_', 8, $f)	// commission to  						
			. self::Sfil('_', 1, $f)	// commission Monthly | Other than monthly | Both
			. self::Amtfil(0, 11, $f)	//pension			
			. self::Amtfil($r->get('TRANSPORT_ALLOWANCE'), 11, $f)	//transport
			. self::Amtfil($r->get('ENTERTAINMENT'), 11, $f)	//entertainment						
			. self::Amtfil($r->get('OTHER_ALLOWANCE'), 11, $f)	//other allowance
			. self::Amtfil(0, 11, $f) // gratuity			
			. self::Amtfil(0, 11, $f) // retrenchment benefits
			. self::Amtfil(0, 11, $f) // retirement benefits from 1992
			. self::Amtfil(0, 11, $f) // retirement benefits from 1993
			. self::Amtfil(0, 11, $f) // Employer contribution to pension/funds outside Singapore
			. self::Amtfil(0, 11, $f) // Employer excess CPF Contribution
			. self::Amtfil(0, 11, $f) // gain/profit from share options
			. self::Amtfil(0, 11, $f) // benefits in-kind
			. self::Amtfil(0, 7, $f) // employees CPF by contract of Employment
			. self::Sfil('_', 30, $f)	// designation
			. self::Sfil($comm, 8, $f)	// Date of Commence
			. self::Sfil($cess, 8, $f)	// Date of Cessation
			. self::Sfil('_', 8, $f)	// Date of Bonus Declaration
			. self::Sfil('_', 8, $f)	// Date of Approval Director's Fees
			. self::Sfil('_', 60, $f)	// Name of Retirement Fund/Benefits
			. self::Sfil('_', 60, $f)	// Name of Designated Pension Plan employee  made compulsory contribution
			. self::Sfil('_', 1, $f)	// Name of Bank = 1 - DBS/POSB | 2 - UOB/OUB | 3 - OCBC | 4 - Others			
			. dateUtils::DUFormat('Ym07', self::GetStartDate($period))
			. self::Sfil('_', 393, $f)	// Fillers
			. self::Sfil('_', 50, $f)	// Reserved
			;
			
			$eContrib = new PayEmployeeContribYearly();
			$eContrib->setEmployeeNo($emp->getEmployeeNo());	
			$eContrib->setName($r->get('NAME'));
			$eContrib->setDepartment('');
			$eContrib->setCompany($r->get('COMPANY'));
			$eContrib->setPeriodCode( substr($period ,0 , 4 ) );
			$eContrib->setSubcon($salary + $bonus + $dfee + $others);
			$eContrib->setWage($salary);
			$eContrib->setErShare(0);
			$eContrib->setEmShare($cpf);
			$eContrib->setCdac($donation);
			$eContrib->setSinda($donation);
			$eContrib->setMbmf($mbf);
			$eContrib->setModifiedBy(HrLib::GetUser() );
			$eContrib->setDateModified( DateUtils::DUNow() );
			$eContrib->setCreatedBy( HrLib::GetUser() );
			$eContrib->setDateCreated( DateUtils::DUNow() );
			$eContrib->save();
		}

		// footer
//		echo $amount .' - '. $tsal .' - '. $tbon .' - '. $tdfe .' - '.$toth;
//		exit();
		$mess[] = '2'
		. self::Amtfil($cnt, 6, $f)
		. self::Amtfil($amount, 12, $f)
		. self::Amtfil($tsal, 12, $f)
		. self::Amtfil($tbon, 12, $f)
		. self::Amtfil($tdfe, 12, $f)
		. self::Amtfil($toth, 12, $f)
		. self::Amtfil(0, 12, $f)    //total exempt
		. self::Amtfil(0, 12, $f)	 //tax borne by employer
		. self::Amtfil(0, 12, $f)	 //income tax by employee for tax 
		. self::Amtfil($tdon, 12, $f)
		. self::Amtfil($tcpf, 12, $f)
		. self::Amtfil($tins, 12, $f)
		. self::Amtfil($tmbf, 12, $f)
		. self::Sfil('_', 1049, $f)
		;
		return $mess;
	}

	public static function Scuts($txt, $ln)  //string cut
	{
		return substr($txt,0, $ln);
	}

	public static function Sfil($txt, $ln, $f=null)
	{
		$f = ($f? $f : '_');
		if (strlen($txt) >= $ln){
			return substr($txt,0, $ln);
		}else{
			return str_pad($txt, $ln, $f );
		}
	}

	public static function Amtfil($txt, $ln, $f)
	{
		$f = '0';
		if ($txt == 0 ){
			$txt = '';
		}
		$str = strval($txt);
		$str = str_pad($str, $ln, $f, STR_PAD_LEFT );
		return $str;
	}
	
	
	public static function Amtfil2($txt, $ln, $f)
	{
		$f = '0';
		if ($txt == 0 ){
			$txt = '';
		}
		$txt = strval($txt);
		$str = str_replace(',', '', $txt);
		$str = str_replace('.', '', $str);
		return str_pad($str, $ln, $f, STR_PAD_LEFT );
	}	

	public static function GetStartDate($pcode)
	{
		$dt = substr($pcode, 0, 8);
		return date('Y-m-d', mktime(1, 1, 1, intval(substr($dt, 4, 2)), intval(substr($dt, 6, 2)), intval(substr($dt, 0, 4)) ) );
	}

	public static function GetEndDate($pcode)
	{
		$dt = substr($pcode, 9, 8);
		return date('Y-m-d', mktime(1, 1, 1, intval(substr($dt, 4, 2)), intval(substr($dt, 6, 2)), intval(substr($dt, 0, 4)) ) );
	}

	public static function IdType($emp){
		$empId = array('id'=>'', 'type'=>'');
		if ( $emp->getTaxId() > 0 ){
			$empId['id'] = $emp->getSinId();
			$empId['type'] = $emp->getTaxId();
			return $empId;
		}
		$empNo = $emp->getEmployeeNo();
		switch ( substr($empNo, 0, 1) ){
			case 'S':
				$empId['type'] = '1';
				break;
			case '5':
				$empId['type'] = '5';
				break;
			case 'M':
				$empId['type'] = '6';
				break;
			default:
				$empId['type'] = '5';				
				break;
		}
		$empId['id'] = $empNo;
		return $empId;				
		// 1 - NRIC
		// 2 - FIN
		// 3 - Immigration File Ref
		// 4 - Work Permit
		// 5 - Malaysian
		// 6 - passport
		
	}
	
	public static function TotalGrossIncome($period)
	{
		$c = new Criteria();
		$c->add(self::PERIOD_CODE, $period);	
 		$rs = self::doSelect($c);
 		$inc = 0;
 		$ded = 0;
 		$cpf = 0;
 		$mbf = 0;
 		$don = 0;
		foreach($rs as $r)		{
			$inc = $inc + $r->getGrossInc();
			$ded = $ded + $r->getGrossDed();
			$cpf = $cpf + $r->getCPF();
			$mbf = $mbf + $r->getMbf();
			$don = $don + $r->getDonation();
		}
		return array('gross_inc'=>$inc, 'gross_ded'=>$ded, 'cpf'=>$cpf, 'mbf'=>$mbf, 'don'=>$don);
	}

	public static function GetYearlyEmployeeIr8a($empNo, $year)
	{
		$pList = PayEmployeeLedgerArchivePeer::GetPeriodListManual($year);
		$c = new Criteria();
		$c->add(self::EMPLOYEE_NO, $empNo);
		$c->add(self::PERIOD_CODE, $pList, Criteria::IN);
		//$c->add(self::NAME, '&& || &&', Criteria::CUSTOM);
 		$rs = self::doSelect($c);
 		$inc = 0;
 		$ded = 0;
 		$cpf = 0;
 		$mbf = 0;
 		$don = 0;
 		$cper = 0;
 		$cpem = 0;
 		$bik  = 0;  //benefits in Kind
		foreach($rs as $r)		{
			if (self::GetPeriodYear($r->getPeriodCode() ) == $year){
				$inc  = $inc + $r->getGrossInc();
				$ded  = $ded + $r->getGrossDed();
				$mbf  = $mbf + $r->getMbf();
				$don  = $don + $r->getDonation();
				$cpem = $cpem + $r->getCpfEm() * -1;
				$cper = $cper + $r->getCpfEr() * -1;
				$cpf  = $cpf + ($r->getCpfEm() * -1) + ($r->getCpfEr() * -1);
			}
		}
// 		if ($empNo == '024747352270509' && $year == '2012'):
// 			$inc = 48000;
// 		endif;
//		var_dump($cpf);
//		exit();
		return array('gross_inc'=>$inc, 'gross_ded'=>$ded, 'cpf'=>$cpf, 'mbf'=>$mbf, 'don'=>$don, 'cpf_em'=>$cpem, 'cpf_er'=>$cper );
	}

	public static function GetListWhenTotalIncomeIsAtLeast($leastAmt, $periodList, $elist=null)
	{
		$exclude = array(
		"400945020241209" //CHAI YEE BOON
		,"03456907-241109" //JAYARAMAN PURUSHOTHAMAN
		,"402846828150110" //K.PRAKASH A/L KUNASEGARAN
		,"518282360281209"
//	//,"05765886-220"
		,"53434418-120705"
		,"073643430210110"
		,"03513297-200810"
//	//,"40183365-130"
//	//,"07368854-180"
		,"073604303180110"
//	//,"07408995-170"
		, "S83"
		);
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn('SUM(' . self::GROSS_INC . ') AS INCOME');
		$c->addSelectColumn(self::EMPLOYEE_NO);
		$c->addSelectColumn(self::NAME);
		$c->add(self::PERIOD_CODE, $periodList, Criteria::IN);
		$c->addGroupByColumn(self::EMPLOYEE_NO);
		$c->addAscendingOrderByColumn(self::NAME);
		$c->add(self::EMPLOYEE_NO, $exclude, Criteria::NOT_IN );
		$c->addJoin(self::EMPLOYEE_NO, HrEmployeePeer::EMPLOYEE_NO );
		if ($elist) $c->add(self::EMPLOYEE_NO, $elist, Criteria::IN);
//		$c->add(self::ID, '&& || &&', Criteria::CUSTOM);
		
//		$c->add(self::EMPLOYEE_NO, '400945020241209', Criteria::NOT_EQUAL);
//		$crit = new Criteria();
//		$c1 = $crit->getNewCriterion(self::GROSS_INC, 'INCOME > ' . $leastAmt, Criteria::CUSTOM);
//		$c2 = $crit->getNewCriterion(self::EMPLOYEE_NO, 'SUBSTR ( '.self::EMPLOYEE_NO.'1, 1) = "S"', Criteria::CUSTOM);
//		$c1->addOr($c2);
//		$c->addHaving($c1);
//		$c->add(self::NAME, "period <>", Criteria::CUSTOM );
		$rs = self::doSelectRS($c);
		$rs->setFetchMode(ResultSet::FETCHMODE_ASSOC);
				
//		var_dump($rs);
//		exit();
		$list =  array();
		while ($rs->next())
		{
			if ($rs->get('INCOME') > $leastAmt) $list[] = $rs->get('EMPLOYEE_NO');
			if (substr($rs->get('EMPLOYEE_NO'), 0, 1) == "S") $list[] = $rs->get('EMPLOYEE_NO');
		}
		return array_unique($list);
	}
	public static function GetPeriodYear($pcode){
		//echo $pcode . '<br>';
		 return substr($pcode, 0, 4);
	}

	public static function YearMonthPeriodCode($year, $month)
	{
		$dt = $year.'-'.$month.'-01';
		return $year.$month.'01-'.$year.$month.DateUtils::DUFormat('t', $dt).'-ALL-MONTHLY';
	}

	public static function GetYearlyDataByEmployeeNoPeriodList($empNo, $periodList)
	{
		$c = new Criteria();
		$c->clearSelectColumns();
		$c->addSelectColumn(self::EMPLOYEE_NO);
		$c->addSelectColumn(self::NAME);
		$c->addSelectColumn(self::COMPANY);
		$c->addSelectColumn('SUM(' . self::GROSS_INC . ') AS INCOME');
		$c->addSelectColumn('SUM(' . self::MBF . ') AS MBF');
		$c->addSelectColumn('SUM(' . self::DONATION. ') AS DONATION');
		$c->addSelectColumn('SUM(' . self::CPF. ') AS CPF');
		$c->addSelectColumn('SUM(' . self::INSURANCE. ') AS INSURANCE');
		$c->addSelectColumn('SUM(' . self::SALARY. ') AS SALARY');
		$c->addSelectColumn('SUM(' . self::BONUS. ') AS BONUS');
		$c->addSelectColumn('SUM(' . self::DIRECTORS_FEE. ') AS DIRECTORS_FEE');
		$c->addSelectColumn('SUM(' . self::OTHER_FEE. ') AS OTHER_FEE');
		$c->addSelectColumn('SUM(' . self::COMMISSION. ') AS COMMISSION');
		$c->addSelectColumn('SUM(' . self::TRANSPORT_ALLOWANCE. ') AS TRANSPORT_ALLOWANCE');
		$c->addSelectColumn('SUM(' . self::ENTERTAINMENT. ') AS ENTERTAINMENT');
		$c->addSelectColumn('SUM(' . self::OTHER_ALLOWANCE. ') AS OTHER_ALLOWANCE');
		$c->addSelectColumn('SUM(' . self::CPF_EM. ') AS CPF_EM');
		$c->addSelectColumn('SUM(' . self::CPF_ER. ') AS CPF_ER');
		$c->add(self::EMPLOYEE_NO, $empNo);
		$c->add(self::PERIOD_CODE, $periodList, Criteria::IN);
		//$c->add(self::COMPANY, 'period <> 0', Criteria::CUSTOM);
		$c->addGroupByColumn(self::EMPLOYEE_NO);
		$rs = self::doSelectRS($c);
		$rs->setFetchMode(ResultSet::FETCHMODE_ASSOC);
		while ($rs->next())
		{
			return $rs;	
		}
		
	}
		
	public static function AmountPresentation($amount)
	{
		// this is based on this document 
		// http://iras.gov.sg/pv_obj_cache/pv_obj_id_74C717E0A8D12875DC071FE1EAD5BF775F9C0100/filename/fileformatthingstonotejan2008.pdf
		return $amount - intval($amount ) > 0? intval($amount) + 1 : intval($amount);
		
	}
	
	public static function GetEmployeeNameList($year) {
		$c = new Criteria();
		$c->addAscendingOrderByColumn(self::NAME);
		$c->add(self::PERIOD_CODE,'substr(period,0,4) == '. $year, "CUSTOM");
		$rs = self::doSelect($c);
		$val[] = '';
		foreach($rs as $res){
			$val[$res->getEmployeeNo()] = $res->getName();
		}
		return $val;
	}	
	
	public static function MalaysianID()
	{
		// report the 26 malaysian ID	
		$elist = array(
			 '033761201150311'
			 ,'033039697150212'
			 ,'034204489241210'
			 ,'034208255241210'
			 ,'034275785150311'
			 ,'034369925290410'
			 ,'034471428230609'
			 ,'034590257170910'
			 ,'034696624280910'
			 ,'034973288221010' //pushpanathan
			 ,'035141499260810'
			 ,'035185712261010'
			 ,'057005874220908'
			 ,'057501626290508'
			 ,'057658746220908'
			 ,'057659068290508'
			 ,'057659408290508'
			 ,'072432088150408'
			 ,'072778758230708' // lizheng
			 ,'072791177250310'
			 ,'072839641011010'
			 ,'073311713140510'
			 ,'073786401250310'
			 ,'074089976170910'
			 ,'074136990181010'
			 ,'402688270100210'
		);	
		return $elist;
	}
	
}

