<div class="zuixindt">
				<div class="zxdt_h3"><img src="<?php echo url::base();?>media/images/led/b_zxdt_en.jpg" /></div>
				<div class="zxdt">
					<ul>
					<?php
					if (isset($jb_news[0])) { 
					?>
					<li><a href="<?php echo url::base();?>en/news/news_detail/<?php echo $jb_news[0]['id']?>">·<?php echo $jb_news[0]['title_en']?></a><font><?php echo date( 'Y-m-d',strtotime($jb_news[0]['created']));?></font></li>
					<?php
					} 
					?>
					</ul>
				</div>
				<div class="fr zxdt_title"><a href="<?php echo url::base();?>en/news/news_list/1">News</a> | <a href="<?php echo url::base();?>en/news/news_list/2">Information</a></div>
			</div>