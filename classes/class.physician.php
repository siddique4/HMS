<?php

require __DIR__.'/../config.php';
class physician{
	function __construct($staff_id)
	{
		$this->staff_id = $staff_id;
	}
	public function setWorkingHours($from,$to)
	{
		$this->sche_from = date('H:i:s',strtotime($from));
		$this->sche_to = date('H:i:s',strtotime($to));
		$diff = strtotime($to) - strtotime($from);
		$this->total_hours = date('H:i:s',$diff);
		$this->total_slots = [];
		$time = $this->sche_from;
		while ($time = date('H:i:s',strtotime('+30 minutes',strtotime($time)))) {
			$this->total_slots[] = $time;
			if ($time >= $this->sche_to) break;
		}
	}

	public function createScheduled()
	{
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);	
		$dates = [];
		$date = date('d-m-Y');
		for($i = 0; $i < 6 ; $i++){
			$dates[] = $date;
			$date = date('d-m-Y',strtotime('+1 days',strtotime($date)));
			
		}
		foreach ($dates as $date) {
			foreach ($this->total_slots as $key => $value) {
				$to = $this->total_slots[$key+1];
				if($to != ""){
					$date1 = date('H:i',strtotime('00:00:00'));
					if ($date1 > $to && $date1 < $value) $date2 = date('d-m-Y',strtotime('+1 days',strtotime($date)));
					else $date2 = $date;
					$query = "INSERT INTO doc_schedule (`phy_id`,`date`,`frm_time`,`to_time`) values ('$this->staff_id','$date2','$value','$to')";
					$con->query($query);
				}
			}
		}
		$con->close();
	}
	static function get_schedule($doc)
	{
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);	
		$schedules = [];
		$query = "SELECT consulting_hrs_frm,consulting_hrs_to from physician where id = '$doc'";
		$result = $con->query($query);
		while ($exe = $result->fetch_object()) 
		{
			// if($exe->date > date('d-m-Y'))
			// {
			// 	$exe->day_text = date('l',strtotime($exe->date));
			// 	$exe->day = date('d',strtotime($exe->date));
			$schedules[] = $exe;
			// }
		}
		$con->close();
		return $schedules;
	}
	static function get_schedule_time($date,$doc)
	{
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);	
		$schedules = [];
		$date = date('d-m-Y',strtotime($date));
 		$query = "SELECT * FROM doc_schedule where phy_id = $doc and `date` = '$date'";
		$result = $con->query($query);
		while ($exe = $result->fetch_object()) {
			$schedules[] = $exe;
		}
		$con->close();
		return $schedules;
	}
	static function schedule_time($time,$reg_obj)
	{
		$time = date('H:i:s',strtotime($time));
		$date = date('d-m-Y',strtotime($time));
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$query = "INSERT INTO doc_schedule (`phy_id`,`date`,`frm_time`,`reg_id`) VALUES ('$reg_obj->cons_id','$date','$time','$reg_obj->reg_id') ";
		$con->query($query);
		$con->close();
	}
	static function get_time($slot)
	{
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);	
		$query = "SELECT * FROM doc_schedule where slot_id = '$slot'";
		$result = $con->query($query);
		$exe = $result->fetch_object();
		$con->close();
		return $exe;
	}
}