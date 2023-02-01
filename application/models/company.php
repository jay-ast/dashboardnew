<?php

class Company extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }
    var $table="companies";
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
            'company_name' => $this->company_name,
            'company_admin' => $this->company_admin,
            'company_logo' => $this->company_logo,
            'company_address' => $this->company_address,
            'company_email' => $this->company_email,
            'insert_at' => $this->insert_at,
            'update_at' => $this->update_at,
            'isdeleted' => $this->isdeleted,
            'delete_at' => $this->delete_at
        );
        return $temp;
    }

    /**
     * <p>Pass all field name of Comapnies table with values
     * This function automatically stores it</p>
     * @param array $para pass array of $key=>$value
     * @return Comapnies.id/false
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
