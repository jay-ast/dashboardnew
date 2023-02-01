<?php

class Video extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }

    var $table = "videos";

    /**
     * <p>Returns all recoreds with all fields</p>
     * @param no prarameters
     * @return Object Class
     */
    public function showAllData() {
        $data = $this->get();
        return $data;
    }

    public function show_result() {
        $temp = array(
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'therapist_id' => $this->exercise_id
        );
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
