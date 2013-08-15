<?php

class MemcacheQ {
	/**
	 * @var $conn MQ/DB连接对象
	 * @var blooean $isQueue是否开启队列
	 */
	var $conn;
	var $isQueue = true;
	private $server_pool=array(
		array('10.99.0.10',61000),
		//array('10.99.0.10',61001),
	);
	
	function MemcacheQ(){
		if($this->isQueue){
			/**
			 * 数据插入队列
			 */
			$this->conn = new Memcached();
			//var_dump($this->conn);
			if(!is_resource($this->conn)){
				//parent::addlog('Memcacheq error: Can not connect Memcacheq server.\n');
				//echo 'Memcacheq error: Can not connect Memcacheq server.\n';
				//return false;
			}
			$r = $this->conn->addServers($this->server_pool);
			//var_dump($r);
		}
		else{
			return false;
		}
	}
	/**
	 * @param $data sql语句
	 * @retrun boolean
	 */
	function set($data, $queueID = 'push_queue'){
		if($this->isQueue) {
			$this->conn->set($queueID, $data);
		}
		else {
			return false;
			//return $this->conn->query($data);
		}
		return true;
	}
	/**
	 * @param string $queueID
	 * @return data 
	 */
	function get($queueID){
		if($this->isQueue) {
			return $this->conn->get($queueID);
		}
		else {
			return false;
		}
	}
	
	function getStats(){
		return $this->conn->getStats();
	}
	
	function close(){
		if(is_resource($this->conn)){
			$this->conn->close();
		}
	}
}
?>