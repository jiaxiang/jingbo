<!--link-->
<div class="width">
	<div id="i_link" class="fl mt5">
    	<div class="fl" id="i_link_c">
       	  <div id="i_link_text" class="fl red">友情链接</div>
            <div id="i_link_list" class="fl blue">
                	<ul>
                    <?php if(!empty($site_link)):
						foreach($site_link as $list):?>
                    <li><a href="<?php echo $list['url']; ?>" target="_blank"><?php echo $list['name']?></a></li>
                    <?php endforeach;
						endif;?>
                    </ul>
            </div>
        </div>
    </div>
    <!--div id="foot_menu" class="fl tc"><font class="blue"><a href="about.html">公司简介</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="contact.html">联系方式</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="remittance.html">汇款地址</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="link.html">友情链接</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="join.html">加盟合作</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="sitemap.html">网站地图</a></font>　<font class="grayd0">|</font>　<font class="blue"><a href="customer.html">客服信息</a></font></div-->
</div>
<!--link_end-->