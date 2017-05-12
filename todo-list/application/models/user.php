<?php
class User extends CI_Model {
	public function make_user($data){
        $this->db->query("INSERT INTO users(fname, lname, email, password,created_at,updated_at, dob) VALUES ('".$data["first_name"]."','".$data["last_name"]."','".$data["email"]."','".$data["pw"]."',".time().",".time().",".$data["dob"].")");
	}
	public function get_user_info($id){
        $query = $this -> db -> query("select fname, lname, email from users where users.email='".$id."'");
        foreach ($query->result() as $row) {
        	$user["fname"] = $row->fname;
        	$user["lname"] = $row->lname;
        	$user["email"] = $row->email;
        }
        return $user;
	}
    public function get_pw($email){
        $query_results = $this->db->query("select * from users where email='".$email."'")->result();
        if(count($query_results)>0) return $query_results[0]->password;
        else return false;
    }
}
?>