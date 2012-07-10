<?php
class User extends CI_Model {
	
  var $usr_email='';
  var $usr_nickname='';
  var $usr_pwd='';
  
  public function check_login()
  {
    $usr_email=$this->input->post('usrname');
    $usr_pwd=md5($this->input->post('usrpwd'));
    $sql = "SELECT id,usr_account,usr_nickname FROM `blog_usr` WHERE usr_account = ? AND usr_pwd = ?";
    $usr_query=$this->db->query($sql, array($usr_email,$usr_pwd));
    if($usr_query->num_rows())
    {
        $usr_detail=$usr_query->row();
        if($this->input->post('rememberme'))$usr_detail->rememberme=$this->input->post('rememberme');
        return $usr_detail;
    }
    else
    {
        return false;	
    }
  }
  
  public function is_user_exist($userid)
  {
  	$this->db->where(array('id'=>$userid));
  	$query=$this->db->get('blog_usr');
  	if($query->num_rows()>0)
  		return true;
  	else 
  		return false;
  }
}
?>