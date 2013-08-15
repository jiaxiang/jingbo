<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<title>查看方案</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/szc'
), FALSE);
?>
</head>
<body style="background:none;">
	<div style="width:700px;" >
     <div class="tips_b">
      <div class="tips_box" >
        <div class="tips_title">
			<?php 
                    switch($detail['play_method']) {
                    case 1:  //14场胜负彩
                        $expect_text="胜负彩";	
                        break;		
                    case 2:	//9场任选
                        $expect_text="9场任选";	
                        break;
                    case 3://6场半
                        $expect_text="6场半全场";
                        break;
                    case 4://4场半
                        $expect_text="4场进球彩";
                        break;			
                    default:
                        $expect_text="胜负彩";
                        break;
                    }
		
				   if ($detail['codes']=="稍后上传"){      
					   $text2="单式";
					   $view_url="未上传";
				   }elseif ($detail['codes']=="文本文件上传"){
					   $text2="单式";	
					   $view_url="<a href=\"/".$detail['upload_filepath']."\" target=\"_blank\">查看</a>";		   
				   }else{
					   $text2="复式";	
					   $view_url="<a onclick=\"Y.openUrl('/zcsf/viewdetail2/".$detail['id']."',520,400);return false\" href=\"javascript:void(0)\">查看</a>";			   
				   }		
            ?>
        <h2><?php echo $expect_text;?> 第<?php echo $detail['expect'];?>期 <?php echo $user['lastname']; ?> 合买方案</h2>
        <span class="close"><a href="javascript:;" onClick="top.Y.closeUrl()">关闭</a></span>
        </div>
	    <div class="tips_info tips_info_np" style="height:450px;overflow-y:auto;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="faTable">
          <tr>
            <th>方案信息</th>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="tr1">
                  <td>玩法</td>
                  <td>注数</td>
                  <td>倍数</td>
                  <td>总金额</td>
                  <td>每份</td>
                  <td>保底</td>
                  <td>提成</td>
                                    <td>保密类型</td>
                                  </tr>
                <tr>
                  <td><?php echo $text2;?></td>
                  <td><?php echo $detail['copies'];?></td>
                  <td><?php echo $detail['rate'];?>倍</td>
                  <td>￥<?php echo $detail['price'];?>元</td>
                  <td>￥<?php echo $detail['price_one'];?>元</td>
                  <td><?php if($detail['is_baodi']==0){ echo "未保底"; }else{ echo "￥".$detail['end_price']*$detail['price_one']."元(<span class='red'>".number_format($detail['end_price']/$detail['copies']*100,1)."%</span>)";}?></td>
                  <td><span class="red eng"><?php echo $detail['deduct'];?>%</span></td>
                  <td><?php if($detail['is_open']==0){ echo "完全公开"; }elseif($detail['is_open']==1){ echo "截止后公开";}elseif($detail['is_open']==2){ echo "仅跟单人可看";}?></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <th>投注内容 </th>
            <td class="t2"> 
            
                 <?php if ($detail['codes']=="稍后上传" and $detail['is_upload']==0) {
							  echo "<p> 方案未传 </p>";
                	   }elseif($detail['is_upload']==1){
					        $upload_html="<p> 方案已传，请点击<font class='red'><a href='/".$detail['upload_filepath']."' target='_blank'>下载</a></font> </p>";
							if($detail['is_open']==2){
									if($join_data){
									  echo $upload_html;
									}else{
									  echo "<p> 对参与本方案合买者公开 </p>";
									} 
							}elseif($detail['is_open']==1){
									if(time()<strtotime($detail['time_end'])){
									  echo $upload_html;
									}else{
									  echo "<p> 截止后公开 </p>";
									} 								
							}else{
							  echo $upload_html;
							} ?>                   
                <?php } else { ?>
						   <?php if ($detail['is_select_code']==0) {
                                        echo "<p> 未选号 </p>";
                                 }else{
                                     $codes_tmp=explode(",",$detail['codes']);      
                ?>
                                            <div class="detail_d clearfix">
                                              <?php
                                               $a=0;
                                               $b=0;
                                               $c=0;
                                               foreach(explode(",",$detail['codes']) as $key=>$value){
                                               if(strlen($value)==1) $a++;
                                               if(strlen($value)==2) $b++;	   
                                               if(strlen($value)==3) $c++;		   
                                              }?>
                                         </div>
                                            <div class="tdbback"> 
                                              <!--点击展开查看方案begin-->
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablelay">
                                                <tr>
                                                  <th class="trbg trline3">场次</th>
                                                  <?php foreach($expect_list as $key=>$value){?>
                                                  <?php  if ($detail['play_method']==1 or $detail['play_method']==2 or $detail['play_method']==3){ ?>
                                                  <th class="trbg trline5"><?php echo $value['changci']; ?></th>
                                                  <?php }elseif($detail['play_method']==4){?>
                                                  <th class="trbg trline5" colspan="2"><?php echo $value['changci']; ?></th>
                                                  <?php }} ?>
                                                  <th class="trbg trline5">倍数</th>
                                                  <th class="trbg trline4 trline5">金额</th>
                                                </tr>
                                                <tr class="tr1">
                                                  <td class="trline trline3">对阵</td>
                                                  <?php foreach($expect_list as $key=>$value){?>
                                                  <?php  if ($detail['play_method']==1 or $detail['play_method']==2){ ?>
                                                  <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?> <span class="gray">
                                                      <?php if ($value['game_result']){ echo $value['game_result'];} else {echo " VS ";} ?>
                                                      </span> <?php echo $value['vs2']; ?> </div></td>
                                                  <?php }elseif($detail['play_method']==4){?>
                                                  <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?></div></td>
                                                  <td class="trline trline5"><div class="texts"><?php echo $value['vs2']; ?></div></td>
                                                  <?php }elseif($detail['play_method']==3){?>
                                                  <?php if($key==0 or $key==2 or $key==4 or $key==6 or $key==8 or $key==10){?>
                                                  <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?> <span class="gray"> VS </span> <?php echo $value['vs2']; ?> <span class="red">半</span> </div></td>
                                                  <?php }else{?>
                                                  <td class="trline trline5"><div class="texts"><?php echo $value['vs1']; ?> <span class="gray"> VS </span> <?php echo $value['vs2']; ?> <span class="red">全</span> </div></td>
                                                  <?php }}} ?>
                                                  <td class="trline trline5">&nbsp;</td>
                                                  <td class="gray trline trline4 trline5">单位（元）</td>
                                                </tr>
                                                <tr class="tr2">
                                                  <td class="gray trline trline3">选号</td>
                                                  <?php foreach(explode(",",$detail['codes']) as $key=>$value){ ?>
                                                  <td class="trline trline5"><?php echo $value; ?></td>
                                                  <?php }?>
                                                  <td class="trline trline5"><?php echo $detail['rate'];?></td>
                                                  <td class="red trline trline4 trline5">￥<?php echo $detail['price'];?></td>
                                                </tr>
                                              </table>
                                              <!--点击展开查看方案end--> </div>
                <?php }} ?>
		        </td>
      </tr>
      <tr>
        <th>认购信息</th>
        <td class="t2">您本次购买<strong class="eng red"><?php if($buynum){echo $buynum;}?></strong>份，需消费<strong class="eng red">￥<?php if($totalbuymoney)echo $totalbuymoney;?>.00</strong>元</td>
      </tr>
    </table>
      </div>
	  <div class="tips_sbt"><p align="center" style="padding-left:24px">
         <input type="button" class="btn_Lora_b" value="关 闭" onClick="top.Y.closeUrl()"/>
         <input type="button" class="btn_Dora_b" value="确 定" onClick="parent.regou();parent.Y.closeUrl();"/>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>