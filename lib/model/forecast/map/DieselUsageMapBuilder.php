<?php



class DieselUsageMapBuilder {

	
	const CLASS_NAME = 'lib.model.forecast.map.DieselUsageMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('forecast');

		$tMap = $this->dbMap->addTable('diesel_usage');
		$tMap->setPhpName('DieselUsage');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'string', CreoleTypes::BIGINT, true, null);

		$tMap->addColumn('TRANS_DATE', 'TransDate', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('CONSUMPTION', 'Consumption', 'double', CreoleTypes::FLOAT, false, 10);

		$tMap->addColumn('COST_PER_UNIT', 'CostPerUnit', 'double', CreoleTypes::FLOAT, false, 10);

		$tMap->addColumn('UNIT', 'Unit', 'string', CreoleTypes::VARCHAR, false, 45);

		$tMap->addColumn('AMOUNT', 'Amount', 'double', CreoleTypes::FLOAT, false, 10);

		$tMap->addColumn('CREATED_BY', 'CreatedBy', 'string', CreoleTypes::VARCHAR, true, 45);

		$tMap->addColumn('DATE_CREATED', 'DateCreated', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('MODIFIED_BY', 'ModifiedBy', 'string', CreoleTypes::VARCHAR, true, 45);

		$tMap->addColumn('DATE_MODIFIED', 'DateModified', 'int', CreoleTypes::TIMESTAMP, true, null);

	} 
} 