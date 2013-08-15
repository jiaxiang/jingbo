  <div class="tips_m" style="display: none; width: 360px; position: absolute;" id="loginLay">
    <div class="tips_b">
      <div class="tips_box">
        <div style="cursor: move;" class="tips_title">
          <h2>用户登录</h2>
          <span class="close" id="flclose"><a href="javascript:void(0);">关闭</a></span> </div>
        <div class="tips_text">
          <div class="dl_tips" id="error_tips" style="display:none;"><b class="dl_err"></b>您输入的账户名和密码不匹配，请重新输入。</div>
          <form method="post" action="" onsubmit="return false;" id="loginForm">
            <table class="dl_tbl" border="0" cellpadding="0" cellspacing="0" width="100%">
              <colgroup>
              <col width="52">
              <col width="180">
              <col width="">
              </colgroup>
              <tbody>
                <tr>
                  <td>用户名：</td>
                  <td><input class="tips_txt text_on" id="lu" name="username" type="text"></td>
                  <td class="t_ar"><a href="<?php echo url::base();?>user/register" target="_blank" tabindex="-1">免费注册</a></td>
                </tr>
                <tr>
                  <td>密&nbsp;&nbsp;码：</td>
                  <td><input class="tips_txt" id="lp" name="password" type="password"></td>
                  <td class="t_ar"><a href="<?php echo url::base();?>user/getpassword" target="_blank" tabindex="-1">忘记密码</a></td>
                </tr>
                <tr>
                  <td valign="top">验证码：</td>
                  <td colspan="2">
<input class="tips_yzm" id="yzmtext" name="secode" type="text">
<input  type="hidden" name="secode_time" id="yzm_time"/> 
<img  alt="验证码"  src="<?php echo url::base();?>site/secoder?id=login_secoder&flag=1" style=" height: 25px;" id='login_secoder' />   
<a class="kbq" href="javascript:void%200" id="yzmup">看不清，换一张</a>
            </td>
                
                </tr>
                <tr>
                  <td></td>
                  <td colspan="2"><input class="btn_Dora_b" value="登 录" id="floginbtn" style="margin-right: 18px;" type="button">
                  <?php /* ?>
                    <a href="javascript:void%200" id="tenpaylogin">QQ登录</a> <span class="gray">|</span> <a href="javascript:void%200" id="zfblogin">支付宝登录</a>
                  <?php */?>
                    </td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <input value="1" name="t" type="hidden">
            <input value="" name="rw" id="rw" type="hidden">
            <input value="0" name="islogin" type="hidden">
			
          </form>
        </div>
      </div>
    </div>
  </div>