<?php

class Exercise extends DataMapper {

    public function __construct($id = NULL) {
        parent::__construct($id);
    }

    var $table = "exercise";

    /**
     * <p>Returns all recoreds with all fields</p>
     * @param no prarameters
     * @return Object Class
     */
    public function showAllData() {
        $this->get();
        return $this->all_to_array();
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
        if ($this->save()) {
            return $this->id;
        } else {
            return false;
        }
    }

    public function show_result() {
        //count videos
        $countVideos = new Exercise_videos();
        $countVideos->where('isdeleted', 0);
        $countVideos->get_by_exercise_id($this->id);
        
        $videoList=new Video();
        
        $latest = new Video();

        $temp = array(
            'id' => $this->id,
            'therapist_id' => $this->therapist_id,
            'name' => $this->name,
            'description' => $this->description,
            'total_videos' => $countVideos->result_count(),
            'thumbnail' => $this->getLatestThumbanil($this->id),
            'videosList' => $this->listVideos($this->id),
        );
        return $temp;
    }

    public function getLatestThumbanil($xer_id) {
        $this->db->select('videos.*');
        $this->db->from('exercise_videos');
        $this->db->join('videos', 'videos.id=exercise_videos.videos_id','left');
        $this->db->where('exercise_videos.isdeleted', 0);
        $this->db->where('videos.isdeleted', 0);
        $this->db->where('exercise_videos.exercise_id', $xer_id);
        $this->db->order_by('exercise_videos.order', 'ASC');
        $this->db->limit(1);
        $last_video = $this->db->get();
        //echo $this->db->last_query();
        if ($last_video->num_rows() > 0) {
            $r = (array)$last_video->result();
            $parse=(array)$r[0];
                      
            if ($parse['thumbnail'] != null)
                return base_url('assets/uploads/exercises/thumbnails') . "/" . $parse['thumbnail'];
            else {
                return "";
            }
        } else {
            return "";
        }
    }
    
    public function listVideos($exerciseid) {
        $getVidoes = new Exercise_videos();
        $getVidoes->where('isdeleted', 0);
        $getVidoes->order_by('order', 'ASC');
        $getVidoes->get_by_exercise_id($exerciseid);
        //echo $this->db->last_query();
        if ($getVidoes->exists()) {
            $order = 0;
            foreach ($getVidoes as $gv) {
                $video_id = $gv->videos_id;
                $vDetaile = new Video();
                $vDetaile->get_by_id($video_id);
                if ($vDetaile->exists()) {
                    $temp = array(
                        'id' => $vDetaile->id,
                        'title' => $vDetaile->title,
                        'name' => base_url('assets/uploads/exercises') . "/" . $vDetaile->name,
                        'thumbnail' => base_url('assets/uploads/exercises/thumbnails') . "/" . $vDetaile->thumbnail,
                        'exercise_id' => $exerciseid,
                        'order' => ++$order
                    );
                    $videosList[] = $temp;
                }
            }
            return $videosList;
        } else {
            return FALSE;
        }
    }
}
