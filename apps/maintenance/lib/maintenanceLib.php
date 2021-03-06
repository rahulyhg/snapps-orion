<?php
class maintenanceLib
{
	public static function ComputeDailyPowerConsumption($sdt, $edt)
	{
// 		$sdt = '2015-01-01';
// 		$edt = Date('Y-m-d');
		//PowerUsagePeer::DeletePowerConsumptionbyDateRange( $sdt , $edt);
		$days = HrLib::GetDateDaysByRange( $sdt , $edt);
		$yesterdayDate = $sdt;
		$yesterDayRecord = '';
		$baseReading = 0;
		$todayReading = 0;
		$consumption = 0;
		$reading = array();
		foreach($days as $day):
			$reading[$day] = 0;
		endforeach;
		

		
		foreach($days as $day):
			$reading[$day] = PowerUsagePeer::GetPowerReadingForTheDay($day) ;
		endforeach;
		
 
		
		$dailies = array();
		$baseReading = 0;
		$topUp = 0;
		$topUpDay = array();
		foreach($reading as $day => $read):
			$currentConsumption = $read - $baseReading;
			$topUp = 0;
			switch(true):
			case $currentConsumption > 1000:
				$dailies[$day] = 0;
				break;
			case $currentConsumption < 1:
				if ( DateUtils::DUFormat('D', $day) == 'Sat' || DateUtils::DUFormat('D', $day) == 'Sun' ):
					$topUp = rand(200, 240);
				else:
					$topUp = rand(350, 370);
				endif;
				$reading[$day] = $baseReading + $topUp;
				$dailies[$day] = $topUp;
				break;
			default:
				$dailies[$day] = $currentConsumption;
				break;
			endswitch;
//			$dailies[$day] = $currentConsumption;
			$baseReading = $reading[$day]; //$read > 0 ? $read : $baseReading;
			echo $day .' : ' . $reading[$day] . ' ' . ' (topup: ' . $topUp .') '. ' baseReading =' .$baseReading .' <br>';
		endforeach;
		
// 		echo '<pre>';
// 		print_r($reading);
// 		print_r($dailies);
// 		echo '</pre>';
// 		exit();
				
// 		foreach($reading as $day => $read):
// 			echo $day . ' is a '. DateUtils::DUFormat('D', $day) . '<br>';
// 		endforeach;
				
		foreach($dailies as $day => $read):
			$record = new PowerUsage();
			$record->setCreatedBy('AUTO');
			$record->setDateCreated(DateUtils::DUNow());
			$record->setReading($reading[$day]);
			$record->setDate(DateUtils::DUFormat('Y-m-d', $day) );
			$record->setTime(DateUtils::DUFormat('Y-m-d h:i:s', $day) );
			$record->setAmpm('DL');
			$record->setConsumption($dailies[$day]);
			$record->setUnit('KiloWatt Hour');
			$record->setUnitPrice(.02);
			$record->setConversionFactor(15);
			$record->setTotalCost($dailies[$day] * .02 * 15);
			$record->setModifiedBy('AUTO');
			$record->setDateModified(DateUtils::DUNow());
			$record->save();
		endforeach;
				
// 			$this->var_dump($topUpDay);
// 			$this->var_dump($dailies);
// 			$this->var_dump($reading);
		
// 			exit();
	}

	public static function ComputeDailyWaterConsumption($sdt, $edt)
	{
// 		$sdt = '2014-11-06';
// 		//$edt = Date('Y-m-d');
// 		$edt = '2015-06-14';
		//PowerUsagePeer::DeletePowerConsumptionbyDateRange( $sdt , $edt);
		$days = HrLib::GetDateDaysByRange( $sdt , $edt);
		$yesterdayDate = $sdt;
		$yesterDayRecord = '';
		$baseReading = 0;
		$todayReading = 0;
		$consumption = 0;
		$reading = array();
		foreach($days as $day):
		$reading[$day] = 0;
		endforeach;
	
	
	
		foreach($days as $day):
			$reading[$day] = WaterUsagePeer::GetWaterReadingForTheDay($day) ;
		endforeach;
	
	
	
		$dailies = array();
		$baseReading = 0;
		$topUp = 0;
		$topUpDay = array();
		foreach($reading as $day => $read):
			$currentConsumption = $read - $baseReading;
			$topUp = 0;
			switch(true):
			case $currentConsumption > 50000:
				$dailies[$day] = 0;
				break;
			case $currentConsumption < 1:
				if ( DateUtils::DUFormat('D', $day) == 'Sat' || DateUtils::DUFormat('D', $day) == 'Sun' ):
					$topUp = rand(200, 400);
				else:
					$topUp = rand(700, 900);
				endif;
				$reading[$day] = $baseReading + $topUp;
				$dailies[$day] = $topUp;
				break;
			default:
				$dailies[$day] = $currentConsumption;
				break;
			endswitch;
			//			$dailies[$day] = $currentConsumption;
			$baseReading = $reading[$day]; //$read > 0 ? $read : $baseReading;
			echo $day .' : ' . $reading[$day] . ' ' . ' (topup: ' . $topUp .') '. ' baseReading =' .$baseReading .' <br>';
		endforeach;
	
// 					echo '<pre>';
// 					print_r($reading);
// 					print_r($dailies);
// 					echo '</pre>';
// 					exit();
	
			// 		foreach($reading as $day => $read):
			// 			echo $day . ' is a '. DateUtils::DUFormat('D', $day) . '<br>';
			// 		endforeach;
	
			foreach($dailies as $day => $read):
				$record = new WaterUsage();
				$record->setCreatedBy('AUTO');
				$record->setDateCreated(DateUtils::DUNow());
				$record->setReading($reading[$day]);
				$record->setDate(DateUtils::DUFormat('Y-m-d', $day) );
				$record->setTime(DateUtils::DUFormat('Y-m-d h:i:s', $day) );
				$record->setAmpm('DL');
				$record->setConsumption($dailies[$day]);
				$record->setUnit('KiloWatt Hour');
				$record->setUnitPrice(.02);
				$record->setConversionFactor(15);
				$record->setTotalCost($dailies[$day] * .02 * 15);
				$record->setModifiedBy('AUTO');
				$record->setDateModified(DateUtils::DUNow());
				$record->save();
			endforeach;
	
			// 			$this->var_dump($topUpDay);
			// 			$this->var_dump($dailies);
			// 			$this->var_dump($reading);
	
			// 			exit();
	}

}
