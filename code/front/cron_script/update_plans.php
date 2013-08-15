<?php

class Update_PT {
	
	private $sql;
	
	public $plan_tables = array(
		'plans_bjdcs',
		'plans_jczqs',
		'plans_jclqs',
		'plans_sfcs',
		'plans_lotty_orders',
	);
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
	}
	
	/**
	 * 数字彩，大乐透订单状态更新
	 */
	function updateDraw_dlt() {
		$query = 'select id, basic_id from plans_lotty_orders where cpstat=1';
		$this->sql->query($query);
		$data = array();
		while ($a = $this->sql->fetch_array()) {
			$data[] = $a;
		}
		for ($i = 0; $i < count($data); $i++) {
			$pid = $data[$i]['id'];
			$pbid = $data[$i]['basic_id'];
			$query = 'select plan_id,status,order_num from ticket_nums where order_num="'.$pbid.'" and plan_id="'.$pid.'"';
			$this->sql->query($query);
			$ticket = array();
			while ($a = $this->sql->fetch_array()) {
				$ticket[] = $a;
			}
			$ticket_num = count($ticket);
			$flag = 0;
			for ($k = 0; $k < $ticket_num; $k++) {
				if ($ticket[$k]['status'] == 1 || $ticket[$k]['status'] == 2 || $ticket[$k]['status'] == -1 ||
						$ticket[$k]['status'] == -2 || $ticket[$k]['status'] == -3 ) {
					$flag++;
				}
			}
			if ($ticket_num > 0 && $flag == $ticket_num) {
				$query = 'select pbid from sale_prousers where pid="'.$pid.'" and restat=0';
				$this->sql->query($query);
				if ($this->sql->num_rows() > 0) {
					$sales = $this->sql->fetch_array();
					$this->sql->query('update plans_lotty_orders set cpstat=2 where id="'.$pid.'"');
					$this->sql->query('update plans_basics set status=2 where id="'.$pbid.'"');
					echo $pbid.' 已出票<br />';
					//参与合买单子状态更新
					$query = 'select pbid from sale_prousers where pid="'.$pid.'"';
					$this->sql->query($query);
					if ($this->sql->num_rows() > 0) {
						$parent_basic_id = array();
						while ($a = $this->sql->fetch_array()) {
							$parent_basic_id[] = $a;
						}
						for ($l = 0; $l < count($parent_basic_id); $l++) {
							$this->sql->query('update plans_basics set status=2 where id="'.$parent_basic_id[$l]['pbid'].'"');
							echo $parent_basic_id[$l]['pbid'].' 参与合买基础方案已出票<br />';
						}
					}
				}
			}
		}
	}
	
	/**
	 * 更新出票状态
	 * Enter description here ...
	 */
	function updateDraw() {
		for ($i = 0; $i < count($this->plan_tables); $i++) {
			//取出方案中未出票的数据
			$this->sql->query('select id,basic_id from '.$this->plan_tables[$i].' where status=1 and parent_id=0');
			$data = array();
			while ($a = $this->sql->fetch_array()) {
				$data[] = $a;
			}
			for ($j = 0; $j < count($data); $j++) {
				//根据方案id取出彩票
				$this->sql->query('select plan_id,status,order_num from ticket_nums where order_num="'.$data[$j]['basic_id'].'" and plan_id="'.$data[$j]['id'].'"');
				$ticket = array();
				while ($a = $this->sql->fetch_array()) {
					$ticket[] = $a;
				}
				
				//检查所有的彩票是否都是已出票,1,2,-1,-2,-3
				$ticket_num = count($ticket);
				$flag = 0;
				for ($k = 0; $k < $ticket_num; $k++) {
					if ($ticket[$k]['status'] == 1 || $ticket[$k]['status'] == 2 || $ticket[$k]['status'] == -1 ||
					 $ticket[$k]['status'] == -2 || $ticket[$k]['status'] == -3 ) {
						$flag++;
					}
				}
			
				//方案中所有彩票均已出票，方案标记为已出票
				if ($ticket_num > 0 && $flag == $ticket_num) {
					$this->sql->query('update '.$this->plan_tables[$i].' set status=2 where id="'.$data[$j]['id'].'"');
					$this->sql->query('update plans_basics set status=2 where order_num="'.$data[$j]['basic_id'].'"');
					echo $data[$j]['basic_id'].' 已出票<br />';
					//参与合买单子状态更新
					$this->sql->query('select basic_id from '.$this->plan_tables[$i].' where parent_id="'.$data[$j]['id'].'"');
					if ($this->sql->num_rows() > 0) {
						$parent_basic_id = array();
						while ($a = $this->sql->fetch_array()) {
							$parent_basic_id[] = $a;
						}
						$this->sql->query('update '.$this->plan_tables[$i].' set status=2 where parent_id="'.$data[$j]['id'].'"');
						echo $data[$j]['id'].' 参与合买方案已出票<br />';
						for ($l = 0; $l < count($parent_basic_id); $l++) {
							$this->sql->query('update plans_basics set status=2 where order_num="'.$parent_basic_id[$l]['basic_id'].'"');
							echo $parent_basic_id[$l]['basic_id'].' 参与合买基础方案已出票<br />';
						}
					}
				}
			}
		}
	}
	
	/**
	 * 更新兑奖状态
	 * Enter description here ...
	 */
	function updateChange() {
		for ($i = 0; $i < count($this->plan_tables); $i++) {
			//取出方案中已出票的数据
			$this->sql->query('select id,basic_id from '.$this->plan_tables[$i].' where status=2 and parent_id=0');
			$data = array();
			while ($a = $this->sql->fetch_array()) {
				$data[] = $a;
			}
			
			for ($j = 0; $j < count($data); $j++) {
				//根据方案id取出彩票
				$this->sql->query('select plan_id,status,bonus,order_num from ticket_nums where order_num="'.$data[$j]['basic_id'].'" and plan_id="'.$data[$j]['id'].'"');
				$ticket = array();
				while ($a = $this->sql->fetch_array()) {
					$ticket[] = $a;
				}

				//print_r($ticket);
				
				//检查所有的彩票是否都已兑奖
				$ticket_num = count($ticket);
				$flag1 = 0;//未中奖
				$flag2 = 0;//已中奖
				$flag3 = 0;//确认作废
				$flag4 = 0;//已兑奖
				$bonus = 0;//中奖奖金
				$wait_bonus = 0;//待录奖
				for ($k = 0; $k < $ticket_num; $k++) {
					//足彩里待录奖的彩票
					if ($ticket[$k]['status'] == 2 && $ticket[$k]['bonus'] == -9999) {
						$wait_bonus++;
					}
					//已兑奖
					if (($ticket[$k]['status'] == 2 && $ticket[$k]['bonus'] != -9999) 
					|| $ticket[$k]['status'] == -2) {
						$flag4++;
						if ($ticket[$k]['bonus'] > 0) {
							$flag2++;
							$bonus += $ticket[$k]['bonus'];
						}
						else {
							$flag1++;
						}
					}
					//已确认作废
					if ($ticket[$k]['status'] == -2) {
						$flag3++;
					}
				}
				//已中奖
				if ($flag4 == $ticket_num && $flag2 > 0 && $wait_bonus == 0) {
					$this->sql->query('update '.$this->plan_tables[$i].' set status=4,bonus="'.$bonus.'" where id="'.$data[$j]['id'].'"');
					$this->sql->query('update plans_basics set status=4,bonus='.$bonus.' where order_num="'.$data[$j]['basic_id'].'"');
					echo $data[$j]['basic_id'].' 已中奖<br />';
				}
				//未中奖
				if ($flag1 == $ticket_num) {
					$this->sql->query('update '.$this->plan_tables[$i].' set status=3 where id="'.$data[$j]['id'].'"');
					$this->sql->query('update plans_basics set status=3 where order_num="'.$data[$j]['basic_id'].'"');
					echo $data[$j]['basic_id'].' 未中奖<br />';
					//参与合买单子状态更新
					$this->sql->query('select basic_id from '.$this->plan_tables[$i].' where parent_id="'.$data[$j]['id'].'"');
					if ($this->sql->num_rows() > 0) {
						$parent_basic_id = array();
						while ($a = $this->sql->fetch_array()) {
							$parent_basic_id[] = $a;
						}
						$this->sql->query('update '.$this->plan_tables[$i].' set status=3 where parent_id="'.$data[$j]['id'].'"');
						echo $data[$j]['id'].' 参与合买方案未中奖<br />';
						for ($l = 0; $l < count($parent_basic_id); $l++) {
							$this->sql->query('update plans_basics set status=3 where order_num="'.$parent_basic_id[$l]['basic_id'].'"');
							echo $parent_basic_id[$l]['basic_id'].' 参与合买基础方案未中奖<br />';
						}
					}
				}
				//确认作废
				if ($flag3 == $ticket_num) {
					$this->sql->query('update '.$this->plan_tables[$i].' set status=6 where id="'.$data[$j]['id'].'"');
					$this->sql->query('update plans_basics set status=6 where order_num="'.$data[$j]['basic_id'].'"');
					echo $data[$j]['basic_id'].' 确认作废<br />';
					//参与合买单子状态更新
					$this->sql->query('select basic_id from '.$this->plan_tables[$i].' where parent_id="'.$data[$j]['id'].'"');
					if ($this->sql->num_rows() > 0) {
						$parent_basic_id = array();
						while ($a = $this->sql->fetch_array()) {
							$parent_basic_id[] = $a;
						}
						$this->sql->query('update '.$this->plan_tables[$i].' set status=6 where parent_id="'.$data[$j]['id'].'"');
						echo $data[$j]['id'].' 参与合买方案确认作废<br />';
						for ($l = 0; $l < count($parent_basic_id); $l++) {
							$this->sql->query('update plans_basics set status=6 where order_num="'.$parent_basic_id[$l]['basic_id'].'"');
							echo $parent_basic_id[$l]['basic_id'].' 参与合买基础方案确认作废<br />';
						}
					}
				}
			}
		}
	}
	
}
$u = new Update_PT();
require_once 'File_Lock.php';
if (!File_Lock::isExists('plans_update')) {
	File_Lock::lockFile();
	$u->updateDraw();
	$u->updateChange();
	$u->updateDraw_dlt();
	File_Lock::unlockFile();
}
?>