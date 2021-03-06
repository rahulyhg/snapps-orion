<?php

/**
 * Subclass for performing query and update operations on the 'pay_sched_deduction_log' table.
 *
 * 
 *
 * @package lib.model.hr
 */ 
class PaySchedDeductionLogPeer extends BasePaySchedDeductionLogPeer
{
    public static function GetDatabyPeriodCode($pcode)
    {
        $c = new Criteria();
        $c->add(self::PERIOD_CODE, $pcode );
        $rs = self::doSelect($c);
    }
        
    public static function GetTotalAmtPaid($id)
    {
        $sql = "
        SELECT sum(amount) as total FROM `pay_sched_deduction_log` where pay_scheduled_deduction_id = ".$id."
        ";
        $rs = self::DoSQL($sql);
        if ($rs)
        {
            $rs->next();
            return $rs->getFloat('total');    
        }
    }

    public static function DoSQL($sql)
    {
        $con = Propel::getConnection('hr');
        $stmt = $con->PrepareStatement($sql);
        $rs = $stmt->executeQuery(ResultSet::FETCHMODE_ASSOC);
        return $rs;
    }

    public static function DeleteDatabyPeriodCode($pcode)
    {
        $c = new Criteria();
        $c->add(self::PERIOD_CODE, $pcode );
        $rs = self::doDelete($c);
        return true;
    }    

    //---------------------------- data = records from archive
    public static function UpdatefromLedger($data)
    {
        if (!$data)
        {
            return;
        }
        $fin = false;
        foreach($data as $rec)
        {
            //--------------------- execute delete target data once
            if (!$fin)
            {
                $fin = self::DeleteDatabyPeriodCode($rec->getPeriodCode());
            }
            if ($rec->getProcessedAs() == 'D')
            {                        
                $record = new PaySchedDeductionLog();
                $record->setPayScheduledDeductionId($rec->getPayScheduledDeductionId());
                $record->setEmployeeNo($rec->getEmployeeNo());
                $record->setAcctCode($rec->getAcctCode());
                $record->setDescription($rec->getDescription());
                $record->setAmount($rec->getAmount()* -1);            
                $record->setPeriodCode($rec->getPeriodCode());
                $record->setCreatedBy($rec->getCreatedBy());
                $record->setDateCreated($rec->getDateCreated());
                $record->setModifiedBy($rec->getModifiedBy());
                $record->setDateModified($rec->getDateModified());
                $record->save();
            }
        }
    }







}
