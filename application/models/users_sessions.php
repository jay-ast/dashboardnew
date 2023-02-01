<?php

class Users_sessions extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }

    var $table = "users_sessions";

    /**
     * <p>Returns all recoreds with all fields</p>
     * @param no prarameters
     * @return Object Class
     */
    public function showAllData() {
        $obj = $this->get();
        return $obj;
    }

    public function show_result() {
        $temp = array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'session_id' => $this->session_id,
            'pushtoken' => $this->pushtoken,
            'insert_at' => $this->insert_at
        );
        return $temp;
    }

    /**
     * <p>Pass all field name of table with values
     * This function automatically stores it</p>
     * @param array $para pass array of $key=>$value
     * @return id/false
     */
    public function create($para) {

        foreach ($para as $key => $value) {
            $this->$key = $value;
        }
        $this->save();
        if ($this->save()) {
            return $this->id;
        } else {
            return false;
        }
    }

    //function for group members operation
}
