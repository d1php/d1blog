<?php
class Siteconfig_model extends CI_Model {
	
  public function get_all_config()
  {
    $query=$this->db->get('blog_options');
    if($query->num_rows()>0)
    {
    	$siteconfig=$query->result();
        $site=new stdClass();
    	foreach ($siteconfig as $key=>$value)
    	{
    		$meta=$value->meta;
    		$site->$meta=html_escape($value->value);
    	}
    	return $site;
    }
  }
  
  public function add_all_config()
  {
  	foreach ($_POST as $key=>$value)
  	{
  		if($this->is_meta_exist($key))
  		{
  			$this->update_meta_value($key,$value);
  		}
  		else
  		{
  			$data['meta']=$key;
  			$data['value']=$value;
  			$this->db->insert('blog_options',$data);
  		}
  	}
  }
  
  public function is_meta_exist($name)
  {
  	$query=$this->db->get_where('blog_options',array('meta'=>$name));
  	if($query->num_rows()>0)
  		return true;
  	else
  		return false;
  }
  
  public function update_meta_value($name,$value)
  {
  	$this->db->update('blog_options',array('value'=>$value),array('meta'=>$name));
  }
  
}
?>