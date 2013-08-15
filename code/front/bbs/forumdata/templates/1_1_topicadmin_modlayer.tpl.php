<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div id="modlayer" style="display: none;position:position">
<input type="hidden" name="optgroup" />
<input type="hidden" name="operation" />
<a class="collapse" href="javascript:;" onclick="$('modlayer').className='collapsed'"><img src="<?=IMGDIR?>/collapsed_yes.gif" alt="缩小" title="缩小" /></a>
<label><input class="checkbox" type="checkbox" name="chkall" onclick="if(!($('modcount').innerHTML = modclickcount = checkall(this.form, 'moderate'))) {$('modlayer').style.display = 'none';}" /> 全选</label>
<span>选中</span><strong onmouseover="$('moremodoption').style.display='block'" onclick="$('modlayer').className=''" id="modcount"></strong><span>篇: </span>
<? if($allowdelpost) { ?>
<strong><a href="javascript:;" onclick="tmodthreads(3, 'delete');return false;">删除</a></strong>
<span class="pipe">|</span>
<? } if($allowmovethread) { ?>
<strong><a href="javascript:;" onclick="tmodthreads(2, 'move');return false;">移动</a></strong>
<span class="pipe">|</span>
<? } if($allowedittypethread) { ?>
<strong><a href="javascript:;" onclick="tmodthreads(2, 'type');return false;">分类</a></strong>
<? } ?>

<div id="moremodoption">
<hr class="solidline" />
<? if($allowstickthread) { ?>
<a href="javascript:;" onclick="tmodthreads(1, 'stick');return false;">置顶</a>
<? } if($allowdigestthread) { ?>
<a href="javascript:;" onclick="tmodthreads(1, 'digest');return false;">精华</a>
<? } if($allowhighlightthread) { ?>
<a href="javascript:;" onclick="tmodthreads(1, 'highlight');return false;">高亮</a>
<? } if($allowrecommendthread && $forum['modrecommend']['open'] && $forum['modrecommend']['sort'] != 1) { ?>
<a href="javascript:;" onclick="tmodthreads(1, 'recommend');return false;">推荐</a>
<? } if($allowbumpthread || $allowclosethread) { ?>
<span class="pipe">|</span>
<? } if($allowbumpthread) { ?>
<a href="javascript:;" onclick="tmodthreads(3, 'bump');return false;">提升下沉</a>
&nbsp;
<? } if($allowclosethread) { ?>
<a href="javascript:;" onclick="tmodthreads(4);return false;">关闭打开</a>
<? } ?>
</div>
</div>