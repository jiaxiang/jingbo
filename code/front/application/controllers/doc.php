<?php
defined('SYSPATH') or die('No direct access allowed.');

class Doc_Controller extends Template_Controller {
    
	public function doc_detail($id){
		$query_struct_list = array(
					'where'		=>array('category_id'=>6),
					'orderby'	=>array('order'=>'desc','id'=>'desc'),
					'limit'		=>array('per_page'=>10,'offset'=>0)
					);
			
		$data['about_list'] = Mydoc::instance()->list_doc_num($query_struct_list);
		$query_struct_detail = array('where'=>array('id'=>$id));
		$data['doc_detail'] = Mydoc::instance()->list_doc_num($query_struct_detail);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $view = new View('docs/doc_detail', $data);
        $view->set_global('_user', $this->_user);
		$view->set_global('_topnav','is_service');
        $view->render(TRUE); 
	}
	public function help(){
		
		//购彩帮助 id=7
		$query_struct_gcbz = array(
				'where'		=>	array('category_id'=>7),
				'orderby'	=>	array('order'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page=>5','offset'=>0)
				);
		//彩种介绍 id=8	
		$query_struct_czjs = array(
				'where'		=>	array('category_id'=>8),
				'orderby'	=>	array('order'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page=>5','offset'=>0)
				);
		
		//新手入门 id=10
		$query_struct_xsrm = array(
				'where'		=>	array('category_id'=>10),
				'orderby'	=>	array('order'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page'=>5,'offset'=>0)
				);
				
		//常见问题 id=9
		$query_struct_cjwt = array(
				'where'		=>	array('category_id'=>9),
				'orderby'	=>	array('order'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page'=>5,'offset'=>0)
		);
		
		$data['gcbz'] = Mydoc::instance()->list_doc_num($query_struct_gcbz);
		$data['czjs'] = Mydoc::instance()->list_doc_num($query_struct_czjs);
		$data['xsrm'] = Mydoc::instance()->list_doc_num($query_struct_xsrm);
		$data['cjwt'] = Mydoc::instance()->list_doc_num($query_struct_cjwt);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $view = new View('docs/help', $data);
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
        $view->render(TRUE);
	}
			
	public function help_detail($id){
		//购彩帮助 id=7
		$query_struct_gcbz = array(
				'where'		=>	array('category_id'=>7),
				'orderby'	=>	array('order'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page=>5','offset'=>0)
				);
		//彩种介绍 id=8	
		$query_struct_czjs = array(
				'where'		=>	array('category_id'=>8),
				'orderby'	=>	array('order'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page=>5','offset'=>0)
				);
				
		$query_struct_detail = array('where'=>array('id'=>$id));
		$data['help_detail'] = Mydoc::instance()->list_doc_num($query_struct_detail);
		$data['gcbz'] = Mydoc::instance()->list_doc_num($query_struct_gcbz);
		$data['czjs'] = Mydoc::instance()->list_doc_num($query_struct_czjs);

		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $view = new View('docs/help_detail', $data);
        $view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
        $view->render(TRUE);
	}
	
    public function view($permalink)
    {
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
        $doc_id = Mydoc::instance()->link2id($permalink);
        $doc_data = Mydoc::instance($doc_id)->get();
        
        if(!$doc_data['id']){
            url::redirect('404');
        }
        /*meta信息*/
        $this->template->title = $doc_data['title'] . (!empty($this->template->title) ? ' - ' . $this->template->title : '');
        $this->template->keywords = $doc_data['title'] . (!empty($this->template->keywords) ? ' - ' . $this->template->keywords : '');
        $this->template->description = $doc_data['title'] . (!empty($this->template->description) ? ' - ' . $this->template->description : '');
        if($doc_data['show_type'] == 0){
            $view = new View('doc_view');
            $view->data = $doc_data;
            $this->template->content = $view;            
        }else if($doc_data['show_type'] == 1){
            $view = $doc_data['content'];
            $this->template->content = $view;
        }else if($doc_data['show_type'] == 2){
            header('Content-Type: text/html; charset=UTF-8');
            $this->template = new View('blank');
            echo $doc_data['content'];
        }
    }
    
  public function faq()
    {
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);

        $permalink = $this->uri->segment(1);
        
        if(Myroute::instance()->get_action('faq') != $permalink){
            url::redirect('404');
        }
        
        $faqs = Mysite::instance()->faqs();
        /*meta信息*/
        $this->template->title = 'FAQ' . (!empty($this->template->title) ? ' - ' . $this->template->title : '');
        $this->template->keywords = 'FAQ' . (!empty($this->template->keywords) ? ' - ' . $this->template->keywords : '');
        $this->template->description = 'FAQ' . (!empty($this->template->description) ? ' - ' . $this->template->description : '');
        /*调用模板*/
        $view = new View('faq_view');
        $view->data = $faqs;
        $this->template->content = $view;
    }
    
    public function contact_us()
    {
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
        
        $permalink = $this->uri->segment(1);
        if(Myroute::instance()->get_action('contact_us') != $permalink){
            url::redirect('404');
        }
        
        if($_POST){
        	//过滤标签
        	tool::filter_strip_tags($_POST);
            $token = $this->input->post('token_contact_us');
            //验证token
            if(empty($token) || !form_token::is_token($token))
            {
            	remind::set(kohana::lang('o_global.bad_request'), 'error', route::action('contact_us'));
            }else{
            	//验证成功，删除token
            	form_token::drop_token($token);
            }
        	
            $data = array ();
            $data['site_id'] = Mysite::instance()->id();
            $data['email'] = $this->input->post('email');
            $data['name'] = $this->input->post('name');
            $data['message'] = $this->input->post('message');
            $data['active'] = 1;
            $data['ip'] = tool::get_long_ip();
            
            $contact_us = Mycontact_us::instance()->add($data);
            
            if($contact_us){
                //发邮件
                $email_flag = 'contact_us';
                $title_param = array ();
                
                $content_param = array ();
                $content_param['{message}'] = $data['message'];
                
                $server_email = Mysite::instance()->email();
                $from_email = $data['email'];
                
                $is_send = mail::send_mail($data['site_id'], $email_flag, $server_email, $from_email, $title_param, $content_param);
                
                if($is_send){
                    $contact_us['is_receive'] = 1;
                    Mycontact_us::instance($contact_us['id'])->edit($contact_us);
                }
                remind::set(kohana::lang('o_doc.o_doc_contact_us_success'), 'success',route::action('contact_us'));
            
            }else{
                remind::set(kohana::lang('o_global.message_submit_error'), 'error',route::action('contact_us'));
            }
        }
        /*meta信息*/
        $this->template->title = 'Contact Us' . (!empty($this->template->title) ? ' - ' . $this->template->title : '');
        $this->template->keywords = 'Contact Us' . (!empty($this->template->keywords) ? ' - ' . $this->template->keywords : '');
        $this->template->description = 'Contact Us' . (!empty($this->template->description) ? ' - ' . $this->template->description : '');
        /*调用模板*/
        $content = new View('contact_us');
		$this->template->content = $content;
        $this->template->set_global('_user', $this->_user);
        $this->template->content->token_contact_us = form_token::grante_token();
    }
    
    /*
     * 
     */
    public function webdoc($mark)
    {
        if (empty($mark))
        {
            url::redirect('404');
        }
        $mark = '/doc/webdoc/'.$mark;
        
        $obj = Mydoc::instance();
        $result = $obj->get_by_url($mark);
        
        if (empty($result))
        {
            url::redirect('404');
        }
         
        $view = new View('docs/webdoc', $result);
		$view->set_global('_user', $this->_user);
        $view->render(TRUE);
    }
	    
   public function html($key){
		//echo $key;die;
		switch($key)
			{
				case "about":
					$str='docs/html/about';
					break;
				case "contact":
					$str='docs/html/contact';
					break;
				case "sitemap":
					$str='docs/html/sitemap';
					break;
				case "remittance":
					$str='docs/html/remittance';
					break;
				case "service":
					$str='docs/html/service';
					break;
				case "cooperate":
					$str='docs/html/cooperate';
					break;
				default:
					$str='docs/html/about';
			}
   		$view = new View($str);
        $view->set_global('_user', $this->_user);
		    
        $view->render(TRUE);
   } 
   
   
   
    /*
     * 显示详细
     */
    public function detail() 
    {
		 //$view->set_global('_user', $this->_user);
         //$view->set_global('_nav', NULL);
        
         $id = $this->uri->segment(3);
         $result = doc::get_instance()->get_byid($id);
                  
         $this->template = new View('doc_single', $result);
         $this->template->render(TRUE);
    }   
   
   
    

}
