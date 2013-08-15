<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Digg pagination style
 * 
 * @preview  « Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next »
 */
?>

	<?php if ($previous_page): ?>
   		 <a class="h_l" href="javascript:void(0)" title="" onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', 1, $url) ?>','list_data');">首页</a> <a title="上一页" class="pre" href="javascript:void(0)" onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $previous_page, $url) ?>','list_data');"></a>
	
		<!--<a><<</a>-->
	<?php endif ?>

	<?php if ($total_pages < 8): /* « Previous  1 2 3 4 5 6 7 8 9 10 11 12  Next » */ ?>
		<?php for ($i = 1; $i <= $total_pages; $i++): ?>
			<?php if ($i == $current_page): ?>
				<a class="curpage" href="javascript:void(0)" title=""><?php echo $i ?></a>
			<?php else: ?>
				<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $i, $url) ?>','list_data');"><?php echo $i ?></a>
			<?php endif ?>
		<?php endfor ?>
	<?php elseif ($current_page < 4): /* « Previous  1 2 3 4 5 6 7 8 9 10 … 25 26  Next » */ ?>
		<?php for ($i = 1; $i <= 5; $i++): ?>
			<?php if ($i == $current_page): ?>
				<a class="curpage" href="javascript:void(0)" title=""><?php echo $i ?></a>
			<?php else: ?>
				<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $i, $url) ?>','list_data');"><?php echo $i ?></a>
			<?php endif ?>
		<?php endfor ?>
		&hellip;
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $total_pages - 1, $url) ?>','list_data');"><?php echo $total_pages - 1 ?></a>
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $total_pages, $url) ?>','list_data');"><?php echo $total_pages ?></a>
	<?php elseif ($current_page > $total_pages - 8): /* « Previous  1 2 … 17 18 19 20 21 22 23 24 25 26  Next » */ ?>
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', 1, $url) ?>','list_data');">1</a>
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', 2, $url) ?>','list_data');">2</a>
		&hellip;
		<?php for ($i = $total_pages - 4; $i <= $total_pages; $i++): ?>
			<?php if ($i == $current_page): ?>
				<a class="curpage" href="javascript:void(0)" title=""><?php echo $i ?></a>
			<?php else: ?>
				<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $i, $url) ?>','list_data');"><?php echo $i ?></a>
			<?php endif ?>
		<?php endfor ?>
	<?php else: /* « Previous  1 2 … 5 6 7 8 9 10 11 12 13 14 … 25 26  Next » */ ?>
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', 1, $url) ?>','list_data');">1</a>
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', 2, $url) ?>','list_data');">2</a>
		&hellip;
		<?php for ($i = $current_page - 5; $i <= $current_page + 5; $i++): ?>
			<?php if ($i == $current_page): ?>
				<a class="curpage" href="javascript:void(0)" title=""><?php echo $i ?></a>
			<?php else: ?>
				<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $i, $url) ?>','list_data');"><?php echo $i ?></a>
			<?php endif ?>
		<?php endfor ?>
		&hellip;
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $total_pages - 1, $url) ?>','list_data');"><?php echo $total_pages - 1 ?></a>
		<a onclick="javascript:loadDataByUrl('<?php echo str_replace('{page}', $total_pages, $url) ?>','list_data');"><?php echo $total_pages ?></a>
	<?php endif ?>
	<?php if ($next_page): ?>
 			<a title="下一页" class="next" href="javascript:void(0)" onclick="loadDataByUrl('<?php echo str_replace('{page}', $next_page, $url) ?>','list_data');return false;">下一页</a>
            <a class="h_l" href="javascript:void(0)" title="" onclick="loadDataByUrl('<?php echo str_replace('{page}', $total_pages, $url) ?>','list_data');return false;">尾页</a>    
	<?php else: ?>
		<!--<a>>></a>-->
	<?php endif ?>
