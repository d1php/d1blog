<?php
class Tag_model extends CI_Model {
  
  public function add($post_id)
  {
  	if($article_tag=trim($this->input->post('article_tag')))
  	{
  		$tagarr=explode(' ', $article_tag);
  		foreach ($tagarr as $value)
  		{
  			if(!$tag_id=$this->is_tag_exist($value))
  			{
  				$data['blog_tag_name']=$value;
  				$this->db->insert('blog_tag',$data);
  				$data2['tag_id']=$this->db->insert_id();
  				$data2['post_id']=$post_id;
  				$this->db->insert('blog_tag_relationship',$data2);
  			}
  			else
  			{
  				$data2['tag_id']=$tag_id;
  				$data2['post_id']=$post_id;
  				$this->db->insert('blog_tag_relationship',$data2);
  			}
  		}
  	}
  }
  
  public function is_tag_exist($tagname)
  {
  	$this->db->select('id');
  	$query=$this->db->get_where('blog_tag',array('blog_tag_name'=>$tagname));
  	if($query->num_rows()>0)
  	{
  		return $query->row()->id;
  	}
  	else
  	{
  		return false;
  	}
  }
  
  public function edit($post_id)
  	{
  		if($article_tag=trim($this->input->post('article_tag')))
  		{
  			$tagarr=explode(' ', $article_tag);
  			$tag_id=$this->get_post_tag_id($post_id);
  			$i=0;
  			$taglen=count($tagarr);
  			$tagidnum=count($tag_id);
            if(!$tag_id)
            {
            		foreach ($tagarr as $value)
            		{
            		    if(!$old_tag_id=$this->is_tag_exist($value))
            			{
            			   $data['blog_tag_name']=$value;
            			   $this->db->insert('blog_tag',$data);
            			   $data2['tag_id']=$this->db->insert_id();
            			   $data2['post_id']=$post_id;
            			   $this->db->insert('blog_tag_relationship',$data2);
            			}
            			else 
            			{
            				$data2['tag_id']=$old_tag_id;
            				$data2['post_id']=$post_id;
            				$this->db->insert('blog_tag_relationship',$data2);
            			}
            		}

            }
            elseif($taglen>=$tagidnum)
            {
            	foreach ($tagarr as $value)
            	{
            		if($tag_id[$i]->id)
            		{
            			if(!$old_tag_id=$this->is_tag_exist($value))
            			{
            				$data['blog_tag_name']=$value;
            				$this->db->insert('blog_tag',$data);
            				$data2['tag_id']=$this->db->insert_id();
            				$this->db->update('blog_tag_relationship',$data2,array('id'=>$tag_id[$i]->id));
            			}
            			else 
            			{
            				$data2['tag_id']=$old_tag_id;
            				$data2['post_id']=$post_id;
            				$this->db->update('blog_tag_relationship',$data2,array('id'=>$tag_id[$i]->id));
            			}
            		}
            		else 
            		{
            			if(!$old_tag_id=$this->is_tag_exist($value))
            			{
            				$data['blog_tag_name']=$value;
            				$this->db->insert('blog_tag',$data);
            			}
            			if($this->db->insert_id())
            			$data2['tag_id']=$this->db->insert_id();
            			else
            			$data2['tag_id']=$old_tag_id;
            			$data2['post_id']=$post_id;
            			$this->db->insert('blog_tag_relationship',$data2);
            		}
                    $i++;
            	}
            }
            elseif($taglen<$tagidnum)
            {
            	foreach ($tag_id as $value)
            	{
            		if(!$this->is_tag_exist($tagarr[$i])&&$tagarr[$i])
            		{
                        $data['blog_tag_name']=$tagarr[$i];
            			$this->db->insert('blog_tag',$data);
            			$data2['tag_id']=$this->db->insert_id();
            			$this->db->update('blog_tag_relationship',$data2,array('id'=>$value->id));
            		}
            		elseif($this->is_tag_exist($tagarr[$i]))
            		{
            			$old_tag_id=$this->is_tag_exist($tagarr[$i]);
                        $data2['tag_id']=$old_tag_id;
            			$this->db->update('blog_tag_relationship',$data2,array('id'=>$value->id));
            		}elseif(!$tagarr[$i])
            		{
            			$this->delete_tag_by_id($value->id);
            		}
            		$i++;
            	}        	
            }
  		}
  		else
  		{
  			$this->delete_tag_by_post_id($post_id);
  			return false;
  		}
  	}

  public function delete_tag_by_id($id)
  {
  	$this->db->delete('blog_tag_relationship',array('id'=>$id));
  }
  
  public function delete_tag_by_post_id($post_id)
  {
  	$this->db->delete('blog_tag_relationship',array('post_id'=>$post_id));
  }
  
  public function get_post_tag($post_id,$str=false)
  {
  	$sql = "SELECT t2.id,t2.blog_tag_name FROM blog_tag_relationship t1, blog_tag t2 WHERE t1.tag_id = t2.id AND t1.post_id =? ORDER BY t2.id ASC";
  	$query=$this->db->query($sql, array($post_id));
  	if($query->num_rows()>0)
  	{
  		if($str=='link')
  		{
  			$tag='';
  			foreach($query->result() as $value)
  			{
  				$tag.='<a href="'.site_url('article/listbytag/'.$value->id).'">'.$value->blog_tag_name.'</a>, ';
  			}
  			return trim(substr($tag,0,-2));
  		}
  		else if($str=='string')
  		{
  			$tag='';
  			foreach($query->result() as $value)
  			{
  				$tag.=$value->blog_tag_name.' ';
  			}
  			return trim($tag);
  		}
  		else 
  		{
  			return $query->result();
  		}
  	}
  	else 
  	{
  		return false;
  	}
  }
  
  public function get_post_tag_id($post_id)
  {
  	$this->db->select('id');
  	$this->db->order_by('id asc');
  	$query=$this->db->get_where('blog_tag_relationship',array('post_id'=>$post_id));
  	if($query->num_rows())
    return $query->result();
  	else
  	return false;	
  }
  
  public function get_all_tag()
  {
  	$query=$this->db->get('blog_tag');
  	if($query->num_rows()>0)
  	{
  		$tag=$query->result();
  		foreach ($tag as $key=>$value)
  		{
  			$this->db->where('tag_id',$value->id);
  			$this->db->from('blog_tag_relationship');
  			$tag_post_num=$this->db->count_all_results();
  			$value->tag_post_num=$tag_post_num;
  		}
  		return $tag;
  	}
  	else
  	{
  		return false;
  	}
  		
  }
  
  public function get_tag_list($start=false,$end=false)
  {
  	if(!$start&&$end)
  	{
  		$this->db->limit($end);
  		$this->db->order_by('id asc');
  	}
  	elseif($start&&$end){
  		$this->db->limit($end,$start);
  		$this->db->order_by('id asc');
  	}elseif(!$start&&!$end){
  		$this->db->order_by('id asc');
  	}
  	$query=$this->db->get('blog_tag');
  	if($query->num_rows())
  	{
  		$taglist=$query->result();
  		foreach ($taglist as $key=>$value)
  		{
  			$sql="SELECT COUNT( tag_id ) as total_num FROM blog_tag_relationship WHERE tag_id = ?";
  			$query_post_num=$this->db->query($sql,array($value->id));
  			$value->article_num=$query_post_num->row()->total_num;
  		}
  		return $taglist;
  	}
  	else
  	{
  		return false;
  	}
  
  }
  
  public function get_tag_total_num(){
  	return $this->db->count_all('blog_tag');
  }
  
  public function ajaxedit()
  {
  	$tag_id=$this->input->post('id');
  	$data['blog_tag_name']=$this->input->post('newtagname');
  	$this->db->update('blog_tag',$data,array('id'=>$tag_id));
  	$json['id']=$tag_id;
  	$json['name']=$data['blog_tag_name'];
  	$json['url']=site_url('admin/article/listbytag/'.$tag_id);
  	echo json_encode($json);
  }
  
  public function ajaxeditall()
  {
    $data=json_decode($this->input->post('editdata'));
    foreach ($data as $key=>$value)
    {
    	$this->db->update('blog_tag',array('blog_tag_name'=>$value->name),array('id'=>$value->id));
    	$json[$key]['id']=$value->id;
    	$json[$key]['name']=$value->name;
    	$json[$key]['url']=site_url('admin/article/listbytag/'.$value->id);
    }
    $json['len']=count($data);
  	echo json_encode($json);
  }
  
  public function delete()
  {
  	$tag_id=$this->input->post('id');
  	$this->db->delete('blog_tag',array('id'=>$tag_id));
  	$this->db->delete('blog_tag_relationship',array('tag_id'=>$tag_id));
  	return $this->get_tag_total_num();
  }
  
  public function deleteall($deletedata)
  {
  	foreach ($deletedata as $key=>$value)
  	{
  		$this->db->delete('blog_tag',array('id'=>$value->id));
  		$this->db->delete('blog_tag_relationship',array('tag_id'=>$value->id));
  		$json[$key]['id']=$value->id;
  	}
  	$json['page_num']=$this->get_tag_total_num();
  	return $json;
  }
}
?>