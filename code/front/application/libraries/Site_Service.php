<?php defined('SYSPATH') OR die('No direct access allowed.');

class Site_Service_Core extends DefaultService_Core 
{
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
	   
    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    public function echo_header() {
    	$header = View::factory('header_')->render();
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host]) && isset($dis_site_config[$host]['header_url'])) {
    		$site_config = $dis_site_config[$host];
    		$header = View::factory($site_config['header_url'])->render();
    		/* $frame = '<div align="center">
					<iframe src="'.$site_config['header_url'].'" align="center" frameborder="0" scrolling="no" width="100%" height="'.$site_config['height'].'"></iframe>
					</div>';
    		$css = html::stylesheet(array
				(
					'media/css/style/style.css?v=201110120',
				), FALSE); 
    		$css_sp = '';
    		if (isset($site_config['body-background-css']) && $site_config['body-background-css'] != '') {
    			$css_sp = html::stylesheet(array
    				(
    						'media/css/'.$site_config['body-background-css'],
    				), FALSE);
    		}
    		$header = $css.$css_sp.$frame; */
    	}
    	return $header;
    }
    
    public function echo_footer() {
    	$footer = View::factory('footer_')->render();
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host]) && isset($dis_site_config[$host]['footer_url'])) {
    		$site_config = $dis_site_config[$host];
    		$footer = View::factory($site_config['footer_url'])->render();
    		/* $frame = '<div align="center">
    		 <iframe src="'.$site_config['header_url'].'" align="center" frameborder="0" scrolling="no" width="100%" height="'.$site_config['height'].'"></iframe>
    		</div>';
    		$css = html::stylesheet(array
    				(
    						'media/css/style/style.css?v=201110120',
    				), FALSE);
    		$css_sp = '';
    		if (isset($site_config['body-background-css']) && $site_config['body-background-css'] != '') {
    		$css_sp = html::stylesheet(array
    				(
    						'media/css/'.$site_config['body-background-css'],
    				), FALSE);
    		}
    		$header = $css.$css_sp.$frame; */
    	}
    	return $footer;
    }
    
    public function echo_friend_links($link_data) {
    	$return = true;
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
    		if (isset($dis_site_config[$host]['friend_links']) && $dis_site_config[$host]['friend_links'] == false) {
    			$return = false;
    		}
    		else {
    			$return = true;
    		}
    	}
    	if ($return == true) {
    		$data['site_link'] = $link_data;
    		$return = View::factory('friend_link', $data)->render();
    	}
    	else {
    		$return = '';
    	}
    	return $return;
    }
    
    public function echo_adflash() {
    	$xml_name = 'ad_index201211300';
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
    		if (isset($dis_site_config[$host]['index_adflash_xml']) && $dis_site_config[$host]['index_adflash_xml'] != '') {
    			$xml_name = 'ad_index_'.$dis_site_config[$host]['index_adflash_xml'];
    		}
    	}
    	$data['xml_name'] = $xml_name;
    	$return = View::factory('ad_flash', $data)->render();
    	return $return;
    }
    
    public function echo_jczq_rqspf() {
    	$url = 'jczq/rangqiushengpingfu';
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host]) && isset($dis_site_config[$host]['jczq_rqspf_url'])) {
    		$site_config = $dis_site_config[$host];
    		$url = $site_config['jczq_rqspf_url'];
    	}
    	return $url;
    }
    
    public function echo_index() {
    	$url = 'index';
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host]) && isset($dis_site_config[$host]['index_url'])) {
    		$site_config = $dis_site_config[$host];
    		$url = $site_config['index_url'];
    	}
    	return $url;
    }
}