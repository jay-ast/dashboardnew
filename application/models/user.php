<?php

class User extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }

    /**
     * <p>Returns all recoreds with all fields</p>
     * @param no prarameters
     * @return Object Class
     */
    public function showAllData() {
        $userObj = new User();
        $userObj->get();
        return $userObj;
    }

    public function show_result() {
        $temp = array(
            'id' => $this->id,
            'roles_id' => $this->roles_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone
        );
        return $temp;
    }

    public function userDetails($userid) {
        $temp = array();
        foreach ($getDetails as $ud) {
            $temp = array(
                'id' => $ud->id,
                'roles_id' => $ud->roles_id,
                'firstname' => $ud->firstname,
                'lastname' => $ud->lastname,
                'email' => $ud->email,
                'password' => $ud->password,
                'phone' => $ud->phone
            );
        }

        return $temp;
    }

    /**
     * <p>Pass all field name of Users table with values
     * This function automatically stores it</p>
     * @param array $para pass array of $key=>$value
     * @return Users.id/false
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

}
