<?php
 /**
 * 自动打票分配到队列
 */
ini_set('display_errors', 1);
set_time_limit(600);
require_once 'Socket_Ticket.php';
$s = new Socket_Ticket();
$s->set_jczq_memcacheq();
$r = $s->get_jczq_memcacheq('51101');
var_dump($r);

/*require_once 'Socket_Ticket.php';
require_once 'MemcacheQ.php';
$memcacheq = new MemcacheQ();
$s = new Socket_Ticket();
$c = $memcacheq->get('test');
var_dump($c);
$a = array("id"=> "4291" ,"codes"=>  "23478|2001[2:0,2:1,3:1,3:2,1:1]/23479|2002[2:1,1:1,0:1,0:2,1:2]/23484|2007[2:1,3:1,3:2,4:1,4:2]/23497|2020[1:3]/23513|3016[1:4]/23498|3001[1:3];6串15" ,"rate"=>  "2","money"=> "16.000" ,"play_method"=> "1" );
$sr = $memcacheq->set($a, 't');
var_dump($sr);
$gs = $memcacheq->getStats();
var_dump($gs);
$b = $memcacheq->get('t');
var_dump($b);*/
?>