<?php
class PasswordUpdate extends CI_Controller
{

   function __construct()
   {
      parent::__construct();      
   }

   public function updatePassword()
   {
      $listClients = new User();      
      $listClients->where('isdeleted', 0);      
      $user_list = $listClients->get();
      foreach ($user_list as $lip) {
         $userdetail=$lip->show_result();         
         $data['patientlist'][] = $userdetail;
     }
      foreach($data['patientlist'] as $users){         
         $hash_password = password_hash($users['password'], PASSWORD_DEFAULT);
         $update_user = "UPDATE users SET password = ? WHERE id = ?";
         $this->db->query($update_user, array($hash_password,$users['id']));
      }      
   }
}
