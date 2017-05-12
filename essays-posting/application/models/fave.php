<?php
class Fave extends CI_Model {
	public function model_add($eid){
		$query = "insert into faves (uid, eid) values (".$this->session->userdata("auth").",".$eid.")";
		$this-> db ->query($query);
	}
	//create a proper query and then forward it to another function for calling
	public function find_faves(){
		$query = 
			"select essays.title, essays.eid, essays.ca, categories.name as 'category' from essays
			left join categories on categories.cid = essays.cid
			left join faves on faves.eid = essays.eid
			where faves.uid = ".$this->session->userdata("auth").
			" order by category";
		return $this->do_query_essay_list($query);
	}
	//use this function to actually do the query and return json
	public function do_query_essay_list($query){
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
		if(isset($res)){
			return json_encode($res, true);
		}
		else{
			return json_encode("No favorites", true);
		}
	}
	public function model_remove($eid){
		if($uid = $this->session->userdata("auth")){//do only if user loggedin
			return $this -> db -> query("delete from faves where eid=".$eid." and uid=".$uid);
		}
		return false;
	}
	public function model_is_fave($eid){
		if($uid = $this-> session->userdata("auth")){//do only if user loggedin
			$q = $this -> db -> query("select * from faves where eid=".$eid." and uid=".$uid);
			if(($q->num_rows())>0){//this is the case where the essay is a fave
				return true;
			}
			else{//this is the case where the essay is not a fave
				return false;
			}
		}
		else//this is the case where no one is logged in
			return false;
	}
}