<?php
class Post extends CI_Model {
    public function make_post($post) {
        $description = $this -> clean_input($post["description"]);
        $this -> db -> query("insert into posts (description, created_at, updated_at) values('" . $description . "'," . time() . "," . time() . ")");
        $newpost["id"] = $this -> db -> insert_id();
        $newpost["d"] = $description;
        return $newpost;
    }

    public function get_all_posts() {
        $posts["id"] = array();
        $posts["d"] = array();
        $post_query = $this -> db -> query("select * from posts");
        foreach ($post_query->result() as $row) {
            array_push($posts["d"], $row -> description);
            array_push($posts["id"], $row -> id);
        }
        return json_encode($posts, true);
    }

    public function kill_post($id) {
        $query = "delete from posts where id=" . $id;
        $this -> db -> query($query);
        $report["killed"] = $id;
        return json_encode($report, true);
    }

    public function change_something($id, $d) {
        if ($this -> db -> query("update posts set description='" . $d . "' where id=" . $id)) {
            $changed["id"] = $id;
            $changed["d"] = $d;
        }
        return json_encode($changed, true);
    }

    public function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
?>