<?php

class Exercisefolder_exercise extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }
    var $table="exercisefolder_exercise";
    /**
     * <p>Returns all recoreds with all fields</p>
     * @param no prarameters
     * @return Object Class
     */
   

    public function show_result() {
        $temp = array(
            'id' => $this->id,
            'exercise_id' => $this->exercise_id,
            'exercisefolder_id' => $this->exercisefolder_id,
            'company_id' => $this->company_id,            
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
