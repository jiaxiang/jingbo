<? if(!defined('IN_DISCUZ')) exit('Access Denied'); if(empty($gid) && $announcements) { ?>
<div id="ann">
<dl>
<dt>公告:</dt>
<dd>
<div id="annbody"><ul id="annbodylis"><?=$announcements?></ul></div>
</dd>
</dl>
</div>
<script type="text/javascript">announcement();</script>
<? } ?>