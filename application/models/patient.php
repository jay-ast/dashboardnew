<?php

class Patient extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }
    var $table="users";
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
            'company_id' => $this->company_id,            
            'password' => $this->password,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'physical_address' => $this->physical_address, 
            'emergency_contact' => $this->emergency_contact,
            'street' => $this->street,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'emergency_contact_name' => $this->emergency_contact_name,
        );
        return $temp;
    }

    function get_user_info($user_id) {
        $query = $this->db->query("SELECT * FROM exercise_folder WHERE client_id =".$user_id);
        return $query->row_array();
    }

    // public function get_folder_id() {
    //     $id=12;
    //     return $id;
    // }

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
