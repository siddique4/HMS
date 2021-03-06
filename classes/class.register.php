<?php

require __DIR__.'/../config.php';
include Class_path.'class.amount.php';
include Class_path.'class.mailer.php';
// include Class_path.'class.pharmacy.php';
class register{
	public $pat_id;
	function __construct($pat_id)
	{
		$this->pat_id = $pat_id;
	}
	function register_op($consultant_id,$inp_pat)
	{
		$this->cons_id = $consultant_id;
		$query = "insert into registration (patient_id,consultant_id,is_inp) values ('$this->pat_id','$consultant_id',$inp_pat)";
		$charge = amountController::get_consultation_amt($consultant_id);

		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);

		$con->query($query);
		$query = "SELECT * from registration where patient_id = '$this->pat_id' order by in_at DESC";
		$result = $con->query($query);
		$exe = $result->fetch_array();
		$con->close();

		$this->reg_id = $exe['registration_id'];
		amountController::add_amt(3,$this->reg_id,$charge,1);		
	}
	function getLatestReg($pat)
	{
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);	
		$query = "SELECT * from registration rg join registration_flow rf on rf.registration_id = rg.registration_id left join staff stf on stf.staff_id = rg.consultant_id where rg.patient_id = '$pat'  order by rg.in_at DESC limit 1";
		// print_r($query);
		$result = $con->query($query);
		$exe = $result->fetch_object();
		$con->close();
		return $exe;
	}
	function register_compliant($data)
	{
		$query = "insert into registration_flow (patient_id,registration_id,complaint) values ('$this->pat_id','$this->reg_id','$data')";
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$this->complaint = $con->query($query);
		
		$con->close();	
	}
	function patient_update($data)
	{
		$query = "insert into patient (name) values ('$data[name]')";
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$con->query($query);
		$name = $data['name'];
		$query1 = "SELECT id from patient where name = '$name' order by added_at DESC limit 1";
		$res = $con->query($query1);
		$exe = $res->fetch_array();
		
		foreach ($data as $key => $value) {
			$query = "UPDATE patient set `$key` = '$value' where id = '$exe[id]'"	;
			$con->query($query);
		}
		$con->close();	
		return $exe['id'];
	}
	function register_ip($room_id,$insurance)
	{
		$res = $this->register_room($room_id);
		if($res)
		{
			$query = "update registration set ins_num = '$insurance' where patient_id = '$this->pat_id' and registration_id = '$this->reg_id'";
			$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
			$res = $con->query($query);
		}

		$con->close();		
		return $res;
	}
	function register_room($room_id)
	{
		$query = "update registration set room_id = '$room_id' where patient_id = '$this->pat_id' and registration_id =  '$this->reg_id'";
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$res = $con->query($query);
		if($res)
		{
			$sql6 = "update rooms set status = 1 where room_id = '$room_id'";
			$this->query = $sql6;
			$res = $con->query($sql6);
			if($res)
			{
				$amt = amountController::get_room_amt($room_id);
				$res = amountController::add_amt(4,$this->reg_id,$amt,0);
				$this->room = $room_id;
			}
		}
		return $res;
	}
	function send_mail()
	{
		$this->mail_result = mailer::registration($this->reg_id);
	}
	function waiting_list()
	{
		$query = "SELECT name,at_time,in_at FROM registration rg join patient pt on pt.id = rg.patient_id where is_inp = 0";
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$result = $con->query($query);
		$re = [];
		while ($exe = $result->fetch_assoc())
		{
			$re[] = $exe;
		}
		
		$con->close();
		return $re;
	}
	function addVitals($data,$reg_id)
	{
		$query = "insert into vitals (reg_id) values ($reg_id)";
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$con->query($query);
		$query = "SELECT * FROM vitals Where reg_id = $reg_id order by created_at DESC";
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$result = $con->query($query);
		$exe = $result->fetch_object();
		foreach ($data as $key => $value) {
			$value = mysqli_real_escape_string($con,$value);
			$query = "UPDATE vitals set `$key` = '$value' where vit_id = '$exe->vit_id'"	;
			$con->query($query);
		}
		$con->close();	
		return true;
	}
	function at_time($time)
	{
		$this->at_time = date('H:i:s',strtotime($time));
		$this->at_date = date('d-m-Y',strtotime($time));
		$query = "update registration set at_date = '$this->at_date',at_time = '$this->at_time' where patient_id = '$this->pat_id' and registration_id =  '$this->reg_id'";
		// print_r($query);
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$res = $con->query($query);		
	}
	function getAppointment()
	{
		$query = 'select concat("Dr. " , stf.f_name, " " , stf.m_name , " " , stf.l_name) as doc_name,pt.name as pt_name,ds.date as scheduled_date,ds.frm_time as scheduled_time,rg.complaint from doc_schedule ds 
			join registration_flow rg on rg.registration_id = ds.reg_id 
			join patient pt on pt.id = rg.patient_id 
			join staff stf on stf.staff_id = ds.phy_id  where ds.reg_id is not null';	
		$con = new MySQLi(DBHOST,DBUSER,DBPASS,DBNAME);
		$res = $con->query($query);		

		$re = [];
		while ($exe = $res->fetch_object())
		{
			$re[] = $exe;
		}		
		$con->close();
		return $re;
	}
}