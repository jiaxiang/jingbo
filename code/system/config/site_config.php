<?php defined('SYSPATH') OR die('No direct access allowed.');
$config['site']=array (
  	'type' => 1,
  	'site_title' => '竞波网',
	'site_title2' => '竞波',
  	'site_email' => 'webmaster@jingbo365.com',
	'site_email2' => 'siyew@jingbo365.com',
  	'name' => 'www.jingbo365.com',
  	'domain' => 'jingbo365.com',
	'keywords' => '竞波,竞彩,足彩,篮彩,足球,彩票合买,caipiao',
	'description' => '竞波网是一家服务于中国彩民的互联网彩票合买代购交易平台，是当前中国彩票互联网交易行业的领导者。竞波网以服务中国彩民为己任，为彩民提供全国各大联销型彩票的在线合买、代购和彩票软件开发、彩票增值短信业务、彩票WAP移动业务等服务。覆盖了足球彩票，体育彩票，福利彩票等各类中国彩票.',
	'kf_phone_num' => '400-820-2324',
	'kf_phone_num2' => '021-61176880',
	'cz_phone_num' => '021-61176883',
	'copyright' => 'Copyright © 2010-2011',
	'company_name' => '上海竞搏信息科技有限公司',
	'icp' => '沪ICP备11025247号',
  	'logo' => NULL,
  	'twitter' => 'Twitter链接设置',
  	'facebook' => 'Facebook链接设置',
  	'youtube' => 'Youtube链接设置',
  	'trustwave' => 'Trustwave链接设置',
  	'macfee' => 'Macfee代码',
  	'livechat' => 'livechat代码',
  	'head_code' => '',
  	'body_code' => '',
  	'index_code' => '',
  	'product_code' => '',
  	'payment_code' => '',
  	'pay_code' => '',
  	'register_mail_active' => '0',
  	'register_mail_check_pwd' => '!@DFsdfas12!@#!',    //验证邮箱密钥
  	'min_draw_money' => 1,         //最低提现金额
  	'max_draw_money' => 10000,     //最高底线金额
  	'max_day_draw_count' => 3,     //每日最高提现次数
  	'draw_money_ratio' => 30,      //提现本金消费比率
  	'draw_money_fee' => 10,        //提现本金超出本金消费比率的手续费
  	'alipay_account' => 'siyewang@sina.com',     //支付宝付款帐号
);
$config['match'] = array(
    'jczq_endtime' => 60*19, //竞彩足球截止购买时间 截止时间减去此处时间
	'jczq_endtime_ds' => 60*24, //竞彩足球单式截止购买时间 截止时间减去此处时间
    'jclq_endtime' => 60*19, //竞彩篮球截止购买时间 截止时间减去此处时间
	'bjdc_endtime' => 60*19, //北京单场截止购买时间 截止时间减去此处时间
	'zcsf_endtime' => 60*20, //足彩胜负截止购买时间 截止时间减去此处时间
	//'zcsf_endtime' => 60*1000000, //足彩胜负截止购买时间 截止时间减去此处时间
	'zcsf_endtime_ds' => 60*25, //足彩胜负单式截止购买时间 截止时间减去此	
	//'zcsf_endtime_ds' => 60*4000000, //足彩胜负单式截止购买时间 截止时间减去此	
);
$config['front_path'] = '/usr/local/cp/front'; //系统前台根目录
$config['hm_sd'] = array(
	'sd_userid' => 2352,//系统收底帐号id
	'sd_limit_buyed' => 0.9,//合买达90%及以上系统收底
);
$config['refuse_ipaddr'] = array(
		'96.127.156.50','173.236.26.150','94.27.81.63',
		'94.142.132.44','195.62.25.214','184.95.55.84',
		'192.162.19.195','84.23.57.211','198.20.65.204',
		'2.132.32.172','80.82.66.234',
		'82.193.117.23','112.101.64.103','108.171.251.2',
		'91.201.64.8','141.105.66.51',
		'216.244.65.146','176.227.198.66','87.98.134.243',
);
$config['refuse_network_24'] = array(
		'14.149.49.',
		'27.159.239.',
		'31.184.238.',
		'37.229.18.',
		'37.59.151.',
		'46.0.146.',
		'46.0.117.',
		'46.105.54.',
		'46.105.116.',
		'46.119.24.',
		'46.118.127.',
		'46.246.31.',
		'46.246.105.',
		'65.60.39.',
		'65.60.9.',
		'91.236.74.',
		'109.111.9.',
		'109.111.25.',
		'142.4.117.',
		'142.4.114.',
		'109.163.226.',
		'178.88.209.',
		'178.210.11.',
		'178.33.250.',
		'178.137.7.',
		'188.92.75.',
		'188.165.238.',
		'199.15.234.',
		'218.93.127.',
);	