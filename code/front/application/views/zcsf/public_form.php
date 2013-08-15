          <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                  <tr>
                    <td class="td_title">合买设置</td>
                    <td class="td_content">
                        <p><span class="hide_sp red eng">*</span><span class="align_sp">我要分为：</span><input name="" class="mul" type="text" id="fsInput" disabled="disabled"/>份，  每份<span class="red eng" id="fsMoney">￥2.00</span>元  <span class="tips_sp" id="fsErr" style="display:none">！每份金额不能除尽，请重新填写份数</span></p>
                        <p><span class="hide_sp"></span><span class="align_sp">我要提成：</span><select name="" class="selt" id="tcSelect">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5" selected="selected">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        </select>% <s class="i-hp i-qw" data-help="<h5>关于提成</h5><p>提成比例设定为0%-8%之间，如果方案中奖又有盈利(税后奖金-合买方案总金额>0)，您就可以获得的税后奖金提成.提成金额=税后奖金×提成比例，方案不盈利将没有提成。</p><p>例如：合买方案总金额为10000元，税后奖金为20000元，提成比例为8%，20000*8%=1600元，最后您的提成金额是1600元。</p>"></s></p>
                        <p><span class="hide_sp"></span><span class="align_sp">是否公开：</span><label class="m_r25" for="gk1"><input type="radio" class="m_r3" checked="checked" id="gk1" name="gk" value="0">完全公开</label><label class="m_r25" for="gk2"><input type="radio" class="m_r3" id="gk2" name="gk" value="1">截止后公开</label><label class="m_r25" for="gk3"><input type="radio" class="m_r3" id="gk3" name="gk" value="2">仅对跟单用户公开</label></p>
                    </td>
                  </tr>
              <tr>
                <td class="td_title">认购设置</td>
                <td class="td_content"><div class="buy_btn"> <!-- a href="javascript:void%200" class="btn_buy_hm" title="发起合买" id="buy_hm">发起合买</a--> </div>
                  <p><span class="hide_sp"></span><span id="userMoneyInfo2">您尚未登录，请先<a href="javascript:void%200" title="" onclick="Yobj.postMsg('msg_login')">登录</a></span></p>
                  <p><span class="hide_sp"></span><span class="align_sp">我要认购：</span>
                    <input name="" class="mul" id="rgInput" value="1" type="text">
                    份，<span class="red eng" id="rgMoney">￥1.00</span>元（<span id="rgScale">50.00%</span>）<span class="tips_sp" id="rgErr" style="display:none">！至少需要认购3份</span></p>
                  <p><span class="hide_sp">
                    <input name="isbaodi" id="isbaodi" type="checkbox">
                    </span><span class="align_sp">我要保底：</span>
                    <input name="" class="mul" value="0" disabled="disabled" id="bdInput" type="text">
                    份，<span class="red eng" id="bdMoney">￥0.00</span>元（<span id="bdScale">0.00%</span>）<s class="i-hp i-qw" data-help="&lt;h5&gt;什么是保底？&lt;/h5&gt;&lt;p&gt;发起人承诺合买截止后，如果方案还没有满员，发起人再投入先前承诺的金额以最大限度让方案成交。最低保底金额为方案总金额的20%。保底时，系统将暂时冻结保底资金，在合买截止时如果方案还未满员的话，系统将会用冻结的保底资金去认购方案。如果在合买截止前方案已经满员，系统会解冻保底资金。&lt;/p&gt;"></s> <span class="tips_sp" id="bdErr" style="display:none">！最低保底20%</span></p>
                  <p class="gray"><span class="hide_sp"></span>[注]冻结资金将在网站截止销售时，根据该方案的销售情况，&gt;
                    返还到您的预付款中。</p>
                  <p><span class="hide_sp">
                    <input checked="checked" id="agreement_hm" type="checkbox">
                    </span>我已阅读并同意《<a href="javascript:void%200" onclick="Y.openUrl('/doc/webdoc/gmxy',530,550)">用户合买代购协议</a>》</p></td>
              </tr>
              <tr>
                <td class="td_ge_t">可选信息</td>
                <td class="td_ge"><p class="ge_selt"><span class="hide_sp">
                    <input id="moreCheckbox" type="checkbox">
                    </span>方案宣传与合买对象</p>
                  <p style="width: 320px;" class="ge_tips">方案宣传。</p></td>
              </tr>
              <tr id="case_ad" style="display: none;">
                <td class="td_title">方案宣传</td>
                <td class="td_content"><p><span class="hide_sp"></span><span class="align_sp">方案标题：</span>
                    <input maxlength="20" id="caseTitle" class="t_input" value="好方案，中大奖木有鸭梨！" type="text">
                    <span class="gray">已输入8个字符，最多20个</span></p>
                  <p><span class="hide_sp"></span><span class="align_sp">方案描述：</span>
                    <textarea id="caseInfo" class="p_input">说点什么吧，让您的方案被更多彩民认可．．．</textarea>
                    <span class="gray">已输入0个字符，最多200个字符</span></p></td>
              </tr>
              <tr class="last_tr" id="hm_target" style="display: none;">
                <td class="td_title">合买对象</td>
                <td class="td_content"><p><span class="hide_sp"></span>
                    <label class="m_r25" for="dx1">
                    <input class="m_r3" checked="checked" id="dx1" name="zgdx" value="1" type="radio">
                    彩友可以合买</label>
                    <label class="m_r25" for="dx2">
                    <input class="m_r3" id="dx2" name="zgdx" value="2" type="radio">
                    只有固定的彩友可以合买</label>
                  </p>
                  <div style="display:none" id="fixobj">
                    <p><span class="hide_sp"></span><span class="align_sp"></span>
                      <textarea name="buyuser" class="p_input" rows="10" cols="10">最多输入500个字符</textarea>
                    </p>
                    <p><span class="hide_sp"></span><span class="gray">[注]限定彩友的格式是：aaaaa,bbbbb,ccccc,ddddd（,为英文状态下的逗号）</span></p>
                  </div></td>
              </tr>
            </tbody>
          </table>