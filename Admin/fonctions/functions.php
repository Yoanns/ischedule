<?php
function phone_number($sPhone){
    $sPhone = preg_replace("[^0-9]",'',$sPhone);
    if(strlen($sPhone) != 10) return(False);
    $sArea = substr($sPhone,0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,4);
    $sPhone = "(".$sArea.") ".$sPrefix." - ".$sNumber;
    return($sPhone);
} 

function psu_id($sPSU){
    $sPSU = preg_replace("[^0-9]",'',$sPSU);
    if(strlen($sPSU) != 9) return(False);
    $sArea = substr($sPSU,0,1);
    $sPrefix = substr($sPSU,1,4);
    $sNumber = substr($sPSU,5,4);
    $sPSU = $sArea." ".$sPrefix." ".$sNumber;
    return($sPSU);
} 


// Time format is UNIX timestamp or
  // PHP strtotime compatible strings
  function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
      }
    }
 
    // Return string with times
    return implode(", ", $times);
  }
  
  function first_day_of_week ($date)
	{
		if (date('Y-m-d',strtotime("-7 days",$date)) == date('Y-m-d',strtotime("last Sunday", $date)))
			$sunday = date('Y-m-d',strtotime("Sunday", $date));
		else
			$sunday = date('Y-m-d',strtotime("last Sunday", $date));
		return  $sunday;
	}
	
function last_day_of_week ($date)
	{
		if (date('Y-m-d',strtotime("+7 days",$date)) == date('Y-m-d',strtotime("Next Saturday", $date)))
			$saturday = date('Y-m-d',strtotime("Saturday", $date));
		else
			$saturday = date('Y-m-d',strtotime("Next Saturday", $date));
		return  $saturday;
	}	
	
	
	function chmod_R($path, $filemode, $dirmode) {
    if (is_dir($path) ) {
        if (!chmod($path, $dirmode)) {
            $dirmode_str=decoct($dirmode);
            print "Failed applying filemode '$dirmode_str' on directory '$path'\n";
            print "  `-> the directory '$path' will be skipped from recursive chmod\n";
            return;
        }
        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if($file != '.' && $file != '..') {  // skip self and parent pointing directories
                $fullpath = $path.'/'.$file;
                chmod_R($fullpath, $filemode,$dirmode);
            }
        }
        closedir($dh);
    } else {
        if (is_link($path)) {
            print "link '$path' is skipped\n";
            return;
        }
        if (!chmod($path, $filemode)) {
            $filemode_str=decoct($filemode);
            print "Failed applying filemode '$filemode_str' on file '$path'\n";
            return;
        }
    }
} 

  ?>