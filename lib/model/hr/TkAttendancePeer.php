<?php

/**
 * Subclass for performing query and update operations on the 'tk_attendance' table.
 *
 * 
 *
 * @package lib.model.hr
 */ 
class TkAttendancePeer extends BaseTkAttendancePeer
{
    const CUSTOM = "CUSTOM";
    
    public static function GetPager($cd)
    {        
        $startIndex = sfContext::getInstance()->getRequest()->getParameter('startIndex', 0);
        $rowsPerPage = sfContext::getInstance()->getRequest()->getParameter('results', 20);
        $page = (int) ( ($startIndex + 1) / $rowsPerPage);
        if (( ($startIndex + 1) % $rowsPerPage) != 0) {
            $page++;
        }
        
        $page = sfContext::getInstance()->getRequest()->getParameter('page', 1); 
        
        $c = clone($cd);
        $pager = new sfPropelPager('TkAttendance', $rowsPerPage);                    
                    
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();
        return $pager;
    }
    
   
   public static function CheckDuplicateforEmpnoTimeIn($emp, $tin)
   {
       $c = new Criteria();
       $c->add(self::EMPLOYEE_NO, $emp);
       $c->add(self::TIME_IN, $tin);
       $total = self::doCount($c);
       return ($total > 0);
   }
   
   public static function GetAllEmployeeTimeIn($sdt, $edt)
   {
       $c = new Criteria();
       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $edt . '\'', self::CUSTOM);
       $rs = self::doSelect($c);
       $list = array();
       if ($rs) {
            foreach ($rs as $r) {
                $key = $r->getEmployeeNo() . '_' . $r->getTimeIn();
                $list[] = $key;
            }
       }
       return $list;
       
   }
   
   public static function GetDateProcessed()
   {
       $c = new Criteria();
       $c->addGroupByColumn(self::TIME_IN);
       $rs = self::doSelect($c);
       return !empty($rs) > 0 ? $rs[0] : null;
   }
   
   public static function GetAttendance($empno, $sdt, $edt)
   {
       $c = new Criteria();
       $c->add(self::EMPLOYEE_NO, $empno);
       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $edt . '\'', self::CUSTOM);
       $c->addAscendingOrderByColumn(self::TIME_IN);
       //$c->addJoin(self::)
       //$c->add(self::ID, '& || &&', Criteria::CUSTOM);
       $rs = self::doSelect($c);
       return !empty($rs) > 0 ? $rs : null;
   }

   public static function GetAttendanceFromList($sdt, $edt, $list)
   {
//   	var_dump($sdt);
//   	var_dump($edt);
//   	exit();
	   //$list = array('024747352270509');
       $c = new Criteria();
       $c->add(self::EMPLOYEE_NO, $list, Criteria::IN);
       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $edt . '\'', self::CUSTOM);
       $c->addAscendingOrderByColumn(self::TIME_IN);
       $rs = self::doSelect($c);
       return !empty($rs) > 0 ? $rs : null;
   }     

   public static function GetEmpDaily($empno, $sdt)
   {
       $c = new Criteria();
       $c->add(self::EMPLOYEE_NO, $empno);
//       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $sdt . '\'', self::CUSTOM);
       $c1 = $c->getNewCriterion(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $sdt . '\'', self::CUSTOM);
//       $c2 = $c->getNewCriterion(self::TIME_OUT,  'DATE(' . self::TIME_OUT . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_OUT . ') <= \'' . $sdt . '\'', self::CUSTOM);
//       $c1->addOr($c2);
       $c->add($c1);
       $rs = self::doSelectOne($c);
       return !empty($rs) > 0 ? $rs : null;
   }

   public static function GetEmpDailyBiometrics($empno, $sdt)
   {
       $c = new Criteria();
       $c->add(self::EMPLOYEE_NO, $empno);
       $c->add(self::CREATED_BY, 'BIOMETRICS');
//       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $sdt . '\'', self::CUSTOM);
       $c1 = $c->getNewCriterion(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $sdt . '\'', self::CUSTOM);
       $c2 = $c->getNewCriterion(self::TIME_OUT,  'DATE(' . self::TIME_OUT . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_OUT . ') <= \'' . $sdt . '\'', self::CUSTOM);
       $c1->addOr($c2);
       $c->add($c1);
       $rs = self::doSelectOne($c);
       return !empty($rs) > 0 ? $rs : null;
   }   
   
   public static function GetDaily($empno, $sdt)
   {
       $c = new Criteria();
       $c->add(self::EMPLOYEE_NO, $empno);
       $c1 = $c->getNewCriterion(self::TIME_IN,  'DATE(' . self::TIME_IN . ') = "'.$sdt .'"', Criteria::CUSTOM);
       $c2 = $c->getNewCriterion(self::TIME_OUT,  'DATE(' . self::TIME_OUT . ') = "'.$sdt .'"', Criteria::CUSTOM);
       //$c1 = $c->getNewCriterion(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_OUT . ') <= \'' . $sdt . '\'', self::CUSTOM);
       //$c2 = $c->getNewCriterion(self::TIME_OUT,  'DATE(' . self::TIME_OUT . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_OUT . ') <= \'' . $sdt . '\'', self::CUSTOM);
       $c1->addOr($c2);
       $c->add($c1);
       //$c->add(self::CREATED_BY, '&& || &&', Criteria::CUSTOM);
       $rs = self::doSelectOne($c);
       return !empty($rs) > 0 ? $rs : null;
   }   
   
   public static function DeleteEmployeeTimeIn($sdt, $edt, $empNo=null)
   {
       $c = new Criteria();
       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $edt . '\'', self::CUSTOM);
       if($empNo)
       {
           $c->add(self::EMPLOYEE_NO, $empNo);
       }
       self::doDelete($c);
       return;
   }
   
    public static function ToolTipLog($dura, $rec)
    {
        
        $txt = '';
        if ($rec){
            $txt = '<a href="#" class="tt">'.$dura.'<span class="tooltip">
    		<span class="top"></span><span class="middle">
    		Created: '.$rec->getDateCreated()
            .' <br /> Created by: '.(strtoupper($rec->getCreatedBy()) ? strtoupper($rec->getCreatedBy()) : 'SYSTEM') 
            .' <br /> Modified:'.$rec->getDateModified()
            .' <br /> Modified by:'.(strtoupper($rec->getModifiedBy()) ? strtoupper($rec->getModifiedBy()) : 'SYSTEM' )
            .'</span>
			<span class="bottom"></span></span></a>';
        }else{
        $txt = '<a href="#" class="tt">'.$dura.'<span class="tooltip">
    		<span class="top"></span><span class="middle">
    		Log: Empty<span class="bottom"></span></span></a>';
            
        }
        return $txt;
    }
    
   public static function GetDailyRecord($sdt)
   {
       $c = new Criteria();
       $c->add(self::TIME_IN,  'DATE(' . self::TIME_IN . ') = "'. $sdt .'"', Criteria::CUSTOM);
//       $c->add(self::TIME_OUT_ORIG, '&& || &&', Criteria::CUSTOM);
//       $c1 = $c->getNewCriterion(self::TIME_IN,  'DATE(' . self::TIME_IN . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_IN . ') <= \'' . $sdt . '\'', self::CUSTOM);
//       $c2 = $c->getNewCriterion(self::TIME_OUT,  'DATE(' . self::TIME_OUT . ') >= \'' . $sdt . '\' AND DATE(' . self::TIME_OUT . ') <= \'' . $sdt . '\'', self::CUSTOM);
//       $c1->addOr($c2);
//       $c->add($c1);
	   $c->addAscendingOrderByColumn(self::NAME);
       $rs = self::doSelect($c);
       return $rs;
   }  
   
   public static function GetEmployeeTotalHoursByDateRangeByTeam($empno, $sdt, $edt, $team )
   {
   	// 		var_dump($sdt);
   	// 		var_dump($edt);
   	// 		exit();
   	$c = new Criteria();
   	$c->clearSelectColumns();
   	$c->addSelectColumn('sum( if(ac_dura > 0, ac_dura, 0 ) ) as TOTAL_HOURS' );
   	$c->addSelectColumn('sum( if(overtimes > 0, overtimes, 0 ) ) as TOTAL_OT' );
   	$c->addSelectColumn('avg( if(rate_per_hour > 0, rate_per_hour, 0 ) ) as RATE_PER_HOUR' );
   	$c->addSelectColumn('sum( if(normal > 0, normal, 0 ) ) as NORMAL_HOUR' );
   	$c->addSelectColumn('sum( if(posted_amount > 0, posted_amount, 0 ) ) as POSTED_AMOUNT' ) ;
   	$c->add(self::EMPLOYEE_NO, $empno);
   	$c->add(self::TRANS_DATE,  'DATE(' . self::TRANS_DATE . ') >= \'' . $sdt . '\' AND DATE(' . self::TRANS_DATE . ') <= \'' . $edt . '\'', self::CUSTOM);
   	if (sizeof($team) <= 9) $c->add(self::TEAM, $team, Criteria::IN);
   
   	$c->addAscendingOrderByColumn(self::TRANS_DATE);
   	//$c->add(self::ID,'&& || &&', Criteria::CUSTOM);
   	$rs = self::doSelectRS($c);
   	$rs->setFetchMode(ResultSet::FETCHMODE_ASSOC);
   	return $rs;
   	//	        while ($rs->next())
   		//        {
   		//            var_dump($rs);
   		//            exit();
   		//            return $rs; // nr of column in select clause
   		//        }
   }
}
