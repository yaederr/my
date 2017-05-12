<?php
class Essay extends CI_Model {
	public function make_essay($post) {
		$description = $this -> clean_input($post["description"]);
		$cid = 1;
		$title = "how the leopard got its spots";
		$link = "/application/texts";
		$this -> db -> query(
			"insert into essays (cid,title, ca, ua)
			values(".$cid .",'". $title ."',".time() . "," . time() . ")");
		$newpost["id"] = $this -> db -> insert_id();
		$newpost["d"] = $description;
		return $newpost;
	}
	public function get_essay_list() { //send json with list of all essays
		$query = "
			select essays.eid, essays.title, essays.ca, categories.name as 'category' from essays
			left join categories on categories.cid = essays.cid 
			order by category";
		$fetch_faves = $this -> db -> query($query);
		foreach ($fetch_faves->result() as $row) {
			$cat = $row->category;
			if(!isset($res[$cat])){//setup new category
				$res[$cat] = array();
				$res[$cat]["t"] = array();
				$res[$cat]["eid"] = array();
			}
			array_push($res[$cat]["t"], $row->title);
			array_push($res[$cat]["eid"], $row->eid);
		}
		return json_encode($res, true);
	}
	public function send_essay($eid=null){//serve a text file view
		if(isset($eid)){
			$title = $this->get_title($eid);
			$ca = $this->get_ca($eid);
			$string=file_get_contents("./application/texts/".$this->get_link($title, $ca));
			if($string===false){//give negative signal because file read failed
				return false;
			}
			else{//give the file contents because file read was a success
				return json_encode($string, true);
			}
		}
	}
	public function get_title($eid){
		$q = $this->db->query("select * from essays where essays.eid=".$eid);
		return $q->result()[0]->title;
	}	
	public function get_ca($eid){
		$q = $this->db->query("select * from essays where essays.eid=".$eid);
		return $q->result()[0]->ca;
	}
	//generate link (filename) rather than store it
	public function get_link($title, $ca){
		return preg_replace("/\W/", "-", strtolower($title.$ca));
	}
	public function clean_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
?>