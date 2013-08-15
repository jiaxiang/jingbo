<?php
	var_dump($expect_data["expect_type"]); 
	foreach($expect_data['expects'] as $value) { 
		if ($value==$expect_data['expect_num']) {
?>
<a data-val="<?php echo $value;?>"<?php if ($value==$cur_expect) {?> class="on"<?php } ?> title="当前期<?php echo $value;?>期" href="/zcsf/sfc_14c/<?php echo $value;?>">当前期<?php echo $value;?>期</a>|
<?php 
		}
		else { 
?>    
<a data-val="<?php echo $value;?>"<?php if ($value==$cur_expect) {?> class="on"<?php } ?> title="预售期<?php echo $value;?>期" href="/zcsf/sfc_14c/<?php echo $value;?>">预售期<?php echo $value;?>期</a>|
<?php 
		}
	} 
?>                
</span><span>单注最高奖金<b class="red">5,000,000</b>元<b class="kj"></b></span></dt>