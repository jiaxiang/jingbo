	<div id="buy_left" class="fl">
    	<h3 class="font14 red" id="buy_title">合买中心首页</h3>
        <ul class=" black">
        	<!--<li class="bold">推荐方案</li>
            <li class="bg2">今日截止</li>
            <li class="bg2">人气方案</li>-->
            <li class="bold">彩种列表</li>
            <li class="<?php if($ticket_type==1 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/jczq">竞彩足彩</a></li>
            <li class="<?php if($ticket_type==6 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/jclq">竞彩篮球</a></li>
            <!--<li class="bg2">竞彩篮球</li>-->            
            <li class="<?php if($ticket_type==2 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/sfc_14c">十四场胜负彩</a></li>
            <li class="<?php if($ticket_type==2 and $play_method==4){echo "red"; } ?> bg2"><a href="/buycenter/sfc_4c">进球彩</a></li>
            <li class="<?php if($ticket_type==2 and $play_method==2){echo "red"; } ?> bg2"><a href="/buycenter/sfc_9c">九场胜负彩</a></li> 
            <li class="<?php if($ticket_type==2 and $play_method==3){echo "red"; } ?> bg2"><a href="/buycenter/sfc_6c">六场半全</a></li>
            <li class="<?php if($ticket_type==8 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/lottnumpub/8/">超级大乐透</a></li>         
            <li class="<?php if($ticket_type==11 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/lottnumpub/11/">排列三</a></li> 
			<li class="<?php if($ticket_type==9 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/lottnumpub/9/">排列五</a></li> 
			<li class="<?php if($ticket_type==10 and $play_method==1){echo "red"; } ?> bg2"><a href="/buycenter/lottnumpub/10/">七星彩</a></li> 
            <li class="bg2">单场竞猜</li>           
        </ul>
    </div>