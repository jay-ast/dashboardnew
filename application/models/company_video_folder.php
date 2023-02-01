<?php

class Company_video_folder extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }
    var $table="company_video_folder";
    /**
     * <p>Returns all recoreds with all fields</p>
     * @param no prarameters
     * @return Object Class
     */
    public function showAllData() {
        $compObj = new Companies();
        $compObj->get();
        return $compObj;
    }

    public function show_result() {
        $temp = array(
            'id' => $this->id,
            'company_id' => $this->company_id,
            'client_id' => $this->client_id,
            'folder_name' => $this->folder_name,
            'folder_type' => $this->folder_type,
            'insert_at' => $this->insert_at,           
            
        );
        return $temp;
    }

    
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
