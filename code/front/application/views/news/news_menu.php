<div id="recommend_right" class="fl">
  	<div class="news_serach fl mt5">
    <form name="search" action="/news/news_search" method="get">
  	  <input name="search" type="text" class="fl news_serachtext" id="search"  />
      <input  type="submit"  alt="搜索" value="搜  索"/>
      </form>
  	</div>
    <div class="news_list fl mt5">
    	<ul class="blue">
        	<?php 
				if(!empty($list1)):	
				foreach($list1 as $v):
				?>
					<li><a href="/news/infor_list/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
        </ul>
    </div>
    <p class="zj_right fl mt5"><span class="fr blue"><a href="#">更多 &gt;&gt;</a></span><span class="blue font14 bold">推荐新闻</span></p>
    <div class="zj_right_box fl blue">
    	<ul>
        	<?php 
				if(!empty($list2)):	
				foreach($list2 as $v):
				?>
					<li><a href="/news/infor_list/<?php echo $v['id']?>"><?php echo tool::cut_str($v['title'],22);?></a></li>
			  <?php endforeach;
			  endif;
			  ?>
        </ul>
    </div>
  </div>