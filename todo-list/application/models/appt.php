<?php
date_default_timezone_set('America/Los_Angeles');
class Appt extends CI_Model {
    public function remove_appt($id){
        $this->db->query("delete from appointments where id=".$id);
    }
	public function make_appt($data){
        $this->db->query("INSERT INTO appointments(email, d, time, status,created_at,updated_at) VALUES ('".$this->session->userdata("auth")."','".$data["description"]."','".$data["time"]."','".$data["status"]."',".time().",".time().")");
	}
	public function get_appts_for_today($email){
        $today = date("F j, Y"); //the current date in string form
        $time_min = strtotime($today." 00:00"); //first second of today
        $time_max = strtotime($today." 23:59:59"); //last second of today
        $appts=array();
        $query = $this -> db -> query("select * from appointments where email='".$email."' and time<".$time_max." and time>".$time_min);
        foreach ($query->result() as $row) {
            $appt["d"]=$row->d;
            $appt["time"]=$row->time;
            $appt["status"]=$row->status;
            $appt["id"]=$row->id;
            array_push($appts, $appt);
        }
        return $appts;
	}

    public function get_future_appts($email){
        $today = date("F j, Y"); //the current date in string form
        $time_min = strtotime($today." 23:59:59"); //last second of today
        $appts=array();
        $query = $this -> db -> query("select * from appointments where email='".$email."' and time>".$time_min);
                $this->session->set_userdata("developer", $query->num_rows());
        foreach ($query->result() as $row) {
            $appt["d"]=$row->d;
            $appt["time"]=$row->time;
            $appt["status"]=$row->status;
            $appt["id"]=$row->id;

            array_push($appts, $appt);
        }
        return $appts;
    }
}
?>