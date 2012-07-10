<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

	public function doadd($post_id)
	{
		$this->load->model('Comment_model','',TRUE);
        $this->Comment_model->add($post_id); 
        $this->load->model('Webmaster_model','',TRUE);
        $webmaster=$this->Webmaster_model->get_admin_detail();
        if($webmaster->usr_email)
        {
        	$this->load->model('Article_model','',TRUE);
        	$article_title=$this->Article_model->get_post_title($post_id);
        	$this->load->library('email');
        	if($webmaster->is_smtp)
        	{
        		$config['protocol'] = 'smtp';
        		$config['smtp_host']=$webmaster->usr_email_smtp;
        		$config['smtp_user']=$webmaster->usr_email_account;
        		$config['smtp_pass']=$webmaster->usr_email_pwd;
        		$config['smtp_port']=$webmaster->usr_email_port?$webmaster->usr_email_port:'25';
        	}
        	else
        	{
        		$config['protocol'] = 'mail';
        	}
        	$config['charset'] = 'utf-8';
        	$config['wordwrap'] = TRUE;
        	$this->email->initialize($config);
        	$this->email->from($webmaster->usr_email_account, $webmaster->usr_nickname);
        	$this->email->to($webmaster->usr_email);
        	$this->email->subject('您的文章《'.$article_title.'》有了新评论');
        	$this->email->message('查看评论：'.site_url('article/view/'.$post_id.'#comment'));
        	$this->email->send();
        }
        redirect('article/view/'.$post_id.'#comment');
	}
	
	public function addcontact()
	{
		$this->load->model('Comment_model','',TRUE);
		$this->Comment_model->add();
		$this->load->model('Webmaster_model','',TRUE);
		$webmaster=$this->Webmaster_model->get_admin_detail();
		if($webmaster->usr_email)
		{
			$this->load->library('email');
			if($webmaster->is_smtp)
			{
				$config['protocol'] = 'smtp';
				$config['smtp_host']=$webmaster->usr_email_smtp;
				$config['smtp_user']=$webmaster->usr_email_account;
				$config['smtp_pass']=$webmaster->usr_email_pwd;
				$config['smtp_port']=$webmaster->usr_email_port?$webmaster->usr_email_port:'25';
			}
			else
			{
				$config['protocol'] = 'mail';
			}
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->from($webmaster->usr_email_account, $webmaster->usr_nickname);
			$this->email->to($webmaster->usr_email);
			$this->email->subject('有人给你留言了');
			$this->email->message('查看留言：'.site_url('contact/#comment'));
			$this->email->send();
		}
		redirect('contact/#comment');
	}
}

?>
