<?php


abstract class BaseHrIndividualLeave extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $employee_no = 'null';


	
	protected $name = 'null';


	
	protected $hr_leave_id = 'null';


	
	protected $leave_type;


	
	protected $description;


	
	protected $status;


	
	protected $days_entitled;


	
	protected $fiscal_year;


	
	protected $remark;


	
	protected $created_by;


	
	protected $date_created;


	
	protected $modified_by;


	
	protected $date_modified;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getEmployeeNo()
	{

		return $this->employee_no;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getHrLeaveId()
	{

		return $this->hr_leave_id;
	}

	
	public function getLeaveType()
	{

		return $this->leave_type;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getDaysEntitled()
	{

		return $this->days_entitled;
	}

	
	public function getFiscalYear()
	{

		return $this->fiscal_year;
	}

	
	public function getRemark()
	{

		return $this->remark;
	}

	
	public function getCreatedBy()
	{

		return $this->created_by;
	}

	
	public function getDateCreated($format = 'Y-m-d H:i:s')
	{

		if ($this->date_created === null || $this->date_created === '') {
			return null;
		} elseif (!is_int($this->date_created)) {
						$ts = strtotime($this->date_created);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [date_created] as date/time value: " . var_export($this->date_created, true));
			}
		} else {
			$ts = $this->date_created;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getModifiedBy()
	{

		return $this->modified_by;
	}

	
	public function getDateModified($format = 'Y-m-d H:i:s')
	{

		if ($this->date_modified === null || $this->date_modified === '') {
			return null;
		} elseif (!is_int($this->date_modified)) {
						$ts = strtotime($this->date_modified);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [date_modified] as date/time value: " . var_export($this->date_modified, true));
			}
		} else {
			$ts = $this->date_modified;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::ID;
		}

	} 
	
	public function setEmployeeNo($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->employee_no !== $v || $v === 'null') {
			$this->employee_no = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::EMPLOYEE_NO;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v || $v === 'null') {
			$this->name = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::NAME;
		}

	} 
	
	public function setHrLeaveId($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->hr_leave_id !== $v || $v === 'null') {
			$this->hr_leave_id = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::HR_LEAVE_ID;
		}

	} 
	
	public function setLeaveType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->leave_type !== $v) {
			$this->leave_type = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::LEAVE_TYPE;
		}

	} 
	
	public function setDescription($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::DESCRIPTION;
		}

	} 
	
	public function setStatus($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::STATUS;
		}

	} 
	
	public function setDaysEntitled($v)
	{

		if ($this->days_entitled !== $v) {
			$this->days_entitled = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::DAYS_ENTITLED;
		}

	} 
	
	public function setFiscalYear($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->fiscal_year !== $v) {
			$this->fiscal_year = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::FISCAL_YEAR;
		}

	} 
	
	public function setRemark($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->remark !== $v) {
			$this->remark = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::REMARK;
		}

	} 
	
	public function setCreatedBy($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::CREATED_BY;
		}

	} 
	
	public function setDateCreated($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [date_created] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date_created !== $ts) {
			$this->date_created = $ts;
			$this->modifiedColumns[] = HrIndividualLeavePeer::DATE_CREATED;
		}

	} 
	
	public function setModifiedBy($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->modified_by !== $v) {
			$this->modified_by = $v;
			$this->modifiedColumns[] = HrIndividualLeavePeer::MODIFIED_BY;
		}

	} 
	
	public function setDateModified($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [date_modified] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date_modified !== $ts) {
			$this->date_modified = $ts;
			$this->modifiedColumns[] = HrIndividualLeavePeer::DATE_MODIFIED;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getString($startcol + 0);

			$this->employee_no = $rs->getString($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->hr_leave_id = $rs->getString($startcol + 3);

			$this->leave_type = $rs->getString($startcol + 4);

			$this->description = $rs->getString($startcol + 5);

			$this->status = $rs->getString($startcol + 6);

			$this->days_entitled = $rs->getFloat($startcol + 7);

			$this->fiscal_year = $rs->getString($startcol + 8);

			$this->remark = $rs->getString($startcol + 9);

			$this->created_by = $rs->getString($startcol + 10);

			$this->date_created = $rs->getTimestamp($startcol + 11, null);

			$this->modified_by = $rs->getString($startcol + 12);

			$this->date_modified = $rs->getTimestamp($startcol + 13, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 14; 
		} catch (Exception $e) {
			throw new PropelException("Error populating HrIndividualLeave object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(HrIndividualLeavePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			HrIndividualLeavePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(HrIndividualLeavePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = HrIndividualLeavePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += HrIndividualLeavePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = HrIndividualLeavePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HrIndividualLeavePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getEmployeeNo();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getHrLeaveId();
				break;
			case 4:
				return $this->getLeaveType();
				break;
			case 5:
				return $this->getDescription();
				break;
			case 6:
				return $this->getStatus();
				break;
			case 7:
				return $this->getDaysEntitled();
				break;
			case 8:
				return $this->getFiscalYear();
				break;
			case 9:
				return $this->getRemark();
				break;
			case 10:
				return $this->getCreatedBy();
				break;
			case 11:
				return $this->getDateCreated();
				break;
			case 12:
				return $this->getModifiedBy();
				break;
			case 13:
				return $this->getDateModified();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HrIndividualLeavePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getEmployeeNo(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getHrLeaveId(),
			$keys[4] => $this->getLeaveType(),
			$keys[5] => $this->getDescription(),
			$keys[6] => $this->getStatus(),
			$keys[7] => $this->getDaysEntitled(),
			$keys[8] => $this->getFiscalYear(),
			$keys[9] => $this->getRemark(),
			$keys[10] => $this->getCreatedBy(),
			$keys[11] => $this->getDateCreated(),
			$keys[12] => $this->getModifiedBy(),
			$keys[13] => $this->getDateModified(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = HrIndividualLeavePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setEmployeeNo($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setHrLeaveId($value);
				break;
			case 4:
				$this->setLeaveType($value);
				break;
			case 5:
				$this->setDescription($value);
				break;
			case 6:
				$this->setStatus($value);
				break;
			case 7:
				$this->setDaysEntitled($value);
				break;
			case 8:
				$this->setFiscalYear($value);
				break;
			case 9:
				$this->setRemark($value);
				break;
			case 10:
				$this->setCreatedBy($value);
				break;
			case 11:
				$this->setDateCreated($value);
				break;
			case 12:
				$this->setModifiedBy($value);
				break;
			case 13:
				$this->setDateModified($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = HrIndividualLeavePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setEmployeeNo($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setHrLeaveId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLeaveType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStatus($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDaysEntitled($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setFiscalYear($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRemark($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedBy($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDateCreated($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setModifiedBy($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setDateModified($arr[$keys[13]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(HrIndividualLeavePeer::DATABASE_NAME);

		if ($this->isColumnModified(HrIndividualLeavePeer::ID)) $criteria->add(HrIndividualLeavePeer::ID, $this->id);
		if ($this->isColumnModified(HrIndividualLeavePeer::EMPLOYEE_NO)) $criteria->add(HrIndividualLeavePeer::EMPLOYEE_NO, $this->employee_no);
		if ($this->isColumnModified(HrIndividualLeavePeer::NAME)) $criteria->add(HrIndividualLeavePeer::NAME, $this->name);
		if ($this->isColumnModified(HrIndividualLeavePeer::HR_LEAVE_ID)) $criteria->add(HrIndividualLeavePeer::HR_LEAVE_ID, $this->hr_leave_id);
		if ($this->isColumnModified(HrIndividualLeavePeer::LEAVE_TYPE)) $criteria->add(HrIndividualLeavePeer::LEAVE_TYPE, $this->leave_type);
		if ($this->isColumnModified(HrIndividualLeavePeer::DESCRIPTION)) $criteria->add(HrIndividualLeavePeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(HrIndividualLeavePeer::STATUS)) $criteria->add(HrIndividualLeavePeer::STATUS, $this->status);
		if ($this->isColumnModified(HrIndividualLeavePeer::DAYS_ENTITLED)) $criteria->add(HrIndividualLeavePeer::DAYS_ENTITLED, $this->days_entitled);
		if ($this->isColumnModified(HrIndividualLeavePeer::FISCAL_YEAR)) $criteria->add(HrIndividualLeavePeer::FISCAL_YEAR, $this->fiscal_year);
		if ($this->isColumnModified(HrIndividualLeavePeer::REMARK)) $criteria->add(HrIndividualLeavePeer::REMARK, $this->remark);
		if ($this->isColumnModified(HrIndividualLeavePeer::CREATED_BY)) $criteria->add(HrIndividualLeavePeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(HrIndividualLeavePeer::DATE_CREATED)) $criteria->add(HrIndividualLeavePeer::DATE_CREATED, $this->date_created);
		if ($this->isColumnModified(HrIndividualLeavePeer::MODIFIED_BY)) $criteria->add(HrIndividualLeavePeer::MODIFIED_BY, $this->modified_by);
		if ($this->isColumnModified(HrIndividualLeavePeer::DATE_MODIFIED)) $criteria->add(HrIndividualLeavePeer::DATE_MODIFIED, $this->date_modified);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(HrIndividualLeavePeer::DATABASE_NAME);

		$criteria->add(HrIndividualLeavePeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setEmployeeNo($this->employee_no);

		$copyObj->setName($this->name);

		$copyObj->setHrLeaveId($this->hr_leave_id);

		$copyObj->setLeaveType($this->leave_type);

		$copyObj->setDescription($this->description);

		$copyObj->setStatus($this->status);

		$copyObj->setDaysEntitled($this->days_entitled);

		$copyObj->setFiscalYear($this->fiscal_year);

		$copyObj->setRemark($this->remark);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setDateCreated($this->date_created);

		$copyObj->setModifiedBy($this->modified_by);

		$copyObj->setDateModified($this->date_modified);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new HrIndividualLeavePeer();
		}
		return self::$peer;
	}

} 