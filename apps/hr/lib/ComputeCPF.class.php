<?php

class ComputeCPF
{

    function __construct()
    {
    }

    function __destruct()
    {
    }

    public function GetCPF($dt, $net, $age, $cpfyear)
    {
//    	$age += 1;
//    	var_dump($dt);
//    	var_dump($net);
//    	var_dump($age);
//    	$age = 34;
//    	var_dump(floatval($age));
//    	var_dump($cpfyear);
//    	exit();
//    	echo '<br>';
// 		var_dump($age);
// 		exit();
        $mess = '';
        $cpfRule = CpfGovtRulePeer::GetAllData($dt, $net, $age, $cpfyear);
//        var_dump($cpfRule);
//        exit();
        if (!$cpfRule)
        {
            return;
        }
        $net       = ($net > 6000)? 6000 : $net;
        $tcpf      = 0;
        $emcpf     = 0;
        $mess      = $mess . $cpfRule->getDescription();
        $erformula = ($cpfRule->getErFormula()) ? $cpfRule->getErFormula() : 0;
        $emformula = ($cpfRule->getEmFormula()) ? $cpfRule->getEmFormula() : 0;
        eval("\$tcpf  = $erformula;");
        eval("\$emcpf = $emformula;");
        
		$emcpf = self::GetIntegerValue($emcpf);
// 		var_dump($empcpf);
// 		exit();
                
        $mess = array('total'=>round($tcpf), 'em_share'=>($emcpf), 'er_share'=>round($tcpf) - ($emcpf), 'desc'=>$cpfRule->getDescription(), 'cpfyear'=>$cpfRule->getCpfYear());
        //eval("\$emcpf = \"$emformula\";");

        return $mess;
    }
    
    public static function GetIntegerValue($vals)
    {
    	$vals = explode('.', $vals);
    	return ( isset($vals[0]) )? $vals[0] : 0;
    }
    






















} //class ends here