<?php
class Posts extends CI_Controller {
    public function index() {
        $this -> load -> model("post");
        $this -> load -> view("headerview");
        $this -> load -> view("addview"); //this is form add posts
        $all_data = json_decode($this -> post -> get_all_posts());
        for ($i = 0; $i < count($all_data -> id); $i++) {
            $data["id"] = $all_data -> id[$i];
            $data["d"] = $all_data -> d[$i];
            $this -> load -> view("view_one_post", array("data" => $data));
        }
        $this -> load -> view("footerview");
    }

    public function add_post() {
        $this -> load -> model("post");
        $this -> load -> library('form_validation');
        $this -> form_validation -> set_rules("description", "description", "required");
        if ($this -> form_validation -> run() == TRUE) {
            echo $this -> load -> view("view_one_post", array("data" => $this -> post -> make_post($this -> input -> post())));
        }
    }
    public function change_post() {
        $this -> load -> model("post");
        $id = $this -> input -> post("idpost");
        $new_d = $this -> input -> post("description");
        echo $this -> post -> change_something($id, $new_d);
    }

    public function delete_post($id) {
        $this -> load -> model("post");
        echo $this -> post -> kill_post($id);
    }
}
?>