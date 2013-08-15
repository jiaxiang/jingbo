<?php defined('SYSPATH') OR die('No direct access allowed.');
Event::clear('system.404');
Event::add('system.404', 'my_404');

function my_404() 
{
    $page = Router::$current_uri.Router::$url_suffix.Router::$query_string;
    Kohana::log('error','404: '.$page);
    header('HTTP/1.1 404 File Not Found');
	url::redirect('error404');
}
