<?php

class dbobjectold
{
  var $data = array();
  var $sql = "";
  var $conn = "";
  var $result;
  var $dbname;
  var $datacount;
  const computer = 'localhost';
  const user     = 'snapps';
  const pass     = 'athousandless';


  function __construct($sql, $dbname){
     $row;
     $this->sql    = $sql;
     $this->dbname = $dbname;
     $row = $this->executeSql();
     if ($row) {
       $this->procFillarraykeys($row);
       $this->procFillsarray();
     }
  }
  
  function __destruct(){
     unset($this->conn);
     unset($this->sql);
     unset($this->dbname);
     unset($this->data);
     unset($this->result);
  }

  private function executeSql(){
//     $cons = mysql_connect('localhost', 'root', 'mysql') or die('failed to connect');
//     $res = mysql_query("select * from reject order by index_no limit 10", $cons);
     $this->conn = mysql_connect(self::computer, self::user, self::pass) or die('failed to connect');		
     mysql_select_db($this->dbname, $this->conn) or die('failed to select database');
     $this->result = mysql_query($this->sql, $this->conn);
     $row = mysql_fetch_array($this->result, MYSQL_ASSOC);
     if (is_array($row)) {
    	return $row; 
     }else{
     	$this->datacount = 0;
     }
  }  

  private function procFillarraykeys($row){
     $strc = array();
     foreach($row as $kr=>$vr){
     	$strc = array(strtolower($kr)=>array());
     	$this->data = array_merge($this->data, $strc); 
     }
     //var_dump($this->data);
  }

  private function procFillsarray() {
  //--------------- < select* --->data[array] >
     $y=0;
     $val = '';
     $row;
     mysql_data_seek($this->result, 0);
     while ($row = mysql_fetch_row($this->result)){
        $x=0;
        foreach($this->data as $k=>$val){
           $this->data[$k][$y] = strtoupper($row[$x]);
           $x++;	 
        }
        $y++;
     }
     $this->datacount = $y;
   }

  function array_isearch($str, $array) {
     foreach($array as $k => $v) {
       if(strcasecmp($str, $v) == 0) return 'TRUE';
     }
     return 'FALSE';
  }
   
  function display_keys(){
     $x=1;
     foreach($this->data as $key=>$val){
        echo 'key ['.$x++.']: '.$key.'<br>';
     }
   }

  function displayResult(){
     $cntr = $this->get_countdata();	
     $keys = $this->get_keys();
     echo $cntr.' -- '.$keys;
     for($x=0; $x<$cntr; $x++) {
       echo '--------------- record no: '.$x.'  -------------<br>';
         foreach($keys as $k=>$val){
          echo '['.$k.']'.$val.": ".$this->data[$val][$x].'<br>';
       }
     }
  }
   
  function get_keys(){
     $keys= array();
     $x = 0;
     foreach($this->data as $key=>$val){
	$keys[$x] = trim($key);
        $x++;
     }
     return $keys;
  }
  
  function get_countdata(){
  	if ($this->datacount == 0) {
  		return 0;
  	} else {
     $cols = $this->get_keys($this->data);
     $col1 = $cols[0];
     return count($this->data[$col1]);
  	} 
  }

  function get_data($field){
  	if (count($this->data) > 0) {
     $keys = $this->get_keys($this->data);
     $dataset = array();
     if (array_search(strtolower($field), $keys) >= 0) {
	    $x=0;
        foreach($this->data[$field] as $k=>$val){
	      $dataset[$x++] = $val; 
	    }
     }
     return $dataset;
  	} //if count  
  }

  function get_uniqueset($field){
  	 $dataset = $this->get_data($field);
  	 $udata = array();
  	 $x=0;
  	 foreach($dataset as $ds=>$val){
  	 	if ($this->array_isearch($val, $udata) == 'FALSE') {
  	 	   $udata[$x] = $val;
  	       $x++;  	 	   
  	 	}
  	 }
 	 return $udata;
  }	
  
  //--------------------- search field1 and return field2 ('' - notfound || -0123... position )
  function finder($field, $value){
  	$arr = isset($this->data[$field])? $this->data[$field] : array(); 
    $pos =  array_search($value, $arr);
    return (in_array($value, $arr)) ? $pos : '';
  }
  
  function datefinder($field, $value){
    $arr = isset($this->data[$field])? $this->data[$field] : array();
//    for($x=) 
    $pos =  array_search($value, $arr);
    return (in_array($value, $arr)) ? $pos : '';
  }  
  
  //----------------------
  function get_data_in($field, $pos){
    if (count($this->data) > 0) {  	
  	  if (array_key_exists($field, $this->data)) {
  	     return $this->data[$field][$pos];
  	  }else {
         return 'not found';
      }
    }
  }
  
  //------------------ this value gets the unique value on reference of $ref value
  function get_subsetof($field1, $field2, $ref){
  	 $xdata = array();
  	 $ydata = array();
 	 $udata = array();
 	 $zdata = array();
  	 $x=0;
     $xdata = $this->get_data ($field1);
     $ydata = $this->get_data ($field2);
     for($y=0;$y<sizeof($ydata); $y++) {
     	if (strcasecmp($ydata[$y],$ref) == 0){
    		$udata[$x++] = $xdata[$y];
     	}
 	 }
  	 $x=0;
  	 foreach($udata as $ds=>$val){
  	 	if ($this->array_isearch($val, $zdata) == 'FALSE') {
  	 	   $zdata[$x] = $val;
  	       $x++;  	 	   
  	 	}
  	 }
 	 return $zdata;
  }  
  
  //  usage $fields = array(), $filters = array();
  function get_compute_count($flds, $filters ){
  	$dataset = array ();
  	$strc    = array ();
  	$fldname = '';
  	$x = 0;
  	$y = 0;
  	$tot = 0;
  	$conf = true;

  	//------------------ assign keyname to array
  	foreach($flds as $kfld=>$fldname) {
  	    $strc    = array($fldname=>array());
        $dataset = array_merge($dataset, $strc);
  	}
  	
  	//------------------ fills the data
    foreach($dataset as $kfld=>$fldname) {
    	$dataset[$kfld] = $this->get_data($kfld);
    }

    //------------------ compare each array with filters
    for($x=0; $x< sizeof($dataset[$kfld]); $x++ ) {
        $y=0;
        $sfld = '';
        $tfld = '';
        unset($strc);
        $strc = array();        
    	foreach ($dataset as $kfld=>$value){
    	  $sfld = trim($dataset[$kfld][$x]);
    	  $tfld = trim($filters[$y]);
          if ($sfld == $tfld ) {
        	  $strc[] = true;   
          }
          $y++;    		    		
    	}
//        echo sizeof($dataset).' -- ';
//    	echo count($strc)."  <------ counter <br>";
//        echo '/str [0]:'.$strc[0].'/str [1]:'.$strc[1].'/str [2]:'.$strc[2].'<br>';
        if (count($strc) == sizeof($dataset) ) {
        	$tot = $tot + 1;
        }
       //echo '<--- last state'.$tot.'<--- current count. <br><br>';        
    }
    return $tot;
  }

  function add_key($nfield){
  	$this->data= array_merge($this->data, array($nfield=>array()) );
  }
  
  function add_key_values($key) {
 	$x= 0;
  	$xref = $this->get_data("type");
  	foreach($xref as $ref=>$val) {
  		$cltype = array();
  		$cltype = explode(" ",$val);
  		$this->data[$key][$x] = 'CLASS '.$cltype[1];
  		$x++; 
  	}
  }
  
}   //------------------- class ends here



