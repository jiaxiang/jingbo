<div id="ft">
      <!--底部包含文件-->

      <!--未登录提示层-->
      <?php echo View::factory('login')->render();?>
      <!--默认提示层-->
      <div class="tips_m" style="display:none;" id="defLay">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="defTopClose"><a href="javascript:void(0);">关闭</a></span> </div>
            <div class="tips_text" id="defConent" style="padding:18px;text-align:center;"></div>
            <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
              <input class="btn_Lblue_m" value="关闭" id="defCloseBtn" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--号码示例层-->
      <div class="tips_m" style="display:none;" id="codeTpl">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="codeTplClose"><a href="javascript:void(0);">关闭</a></span> </div>
            <div class="tips_text" id="codeTplConent" style="padding:18px;"></div>
            <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
              <input class="btn_Lora_b" value="知道了" id="codeTplYes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--余额不足内容-->
      <div class="tips_m" style="top: 300px; display: none; position: absolute;" id="addMoneyLay">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>可用余额不足</h2>
              <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
            <div class="tips_text">
              <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>
                (点充值跳到"充值"页面，点"返回"可进行修改)</p>
            </div>
            <div class="tips_sbt">
              <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button">
              <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--代购确认-->
      <div class="tips_m" style="display: none; position: absolute;" id="b2_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="b2_dlg_title">确认投注内容</h2>
              <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_info" id="b2_dlg_content"></div>
            <div class="tips_sbt">
              <input value="取 消" class="btn_Lora_b" id="b2_dlg_no" type="button">
              <input value="确 定" class="btn_Dora_b" id="b2_dlg_yes" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--机选号码列表-->
      <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="jx_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div class="tips_title">
              <h2>机选号码列表</h2>
              <span class="close" id="jx_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_text">
              <ul class="tips_text_list" id="jx_dlg_list">
              </ul>
            </div>
            <div class="tips_sbt">
              <input value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re" type="button">
              <input value="选好了" class="s-ok s-ok-sp" id="jx_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--查看胆拖明细列表-->
      <div class="tips_m" style="top: 300px; width: 300px; display: none; position: absolute;" id="split_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>查看投注明细</h2>
              <span class="close" id="split_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_text">
              <ul class="tips_text_list" id="split_dlg_list" style="height:284px;overflow:auto;">
              </ul>
            </div>
            <div class="tips_sbt">
              <input value="关 闭" class="s-ok" id="split_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!--温馨提示-->
      <div style="top: 700px; display: none; width: 500px; position: absolute;" class="tips_m" id="info_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2>温馨提示</h2>
              <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="alert_c">
              <div class="state error">
                <div class="stateInfo f14 p_t10" id="info_dlg_content"></div>
              </div>
            </div>
            <div class="tips_sbt">
              <input class="btn_Dora_b" value="确 定" id="info_dlg_ok" type="button">
            </div>
          </div>
        </div>
      </div>
      <!-- 确认投注内容 -->
      <div class="tips_m" style="width: 700px; display: none; position: absolute;" id="ishm_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="ishm_dlg_title">方案合买</h2>
              <span class="close"><a href="javascript:void%200" id="ishm_dlg_close">关闭</a></span> </div>
            <div class="tips_info tips_info_np" id="ishm_dlg_content"></div>
            <div class="tips_sbt">
              <input value="确认投注" class="btn_Dora_b" id="ishm_dlg_yes" type="button">
              <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a> </div>
          </div>
        </div>
      </div>
      <!--提示确认-->
      <div class="tips_m" style="display: none; position: absolute;" id="confirm_dlg">
        <div class="tips_b">
          <div class="tips_box">
            <div style="cursor: move;" class="tips_title">
              <h2 id="confirm_dlg_title">温馨提示</h2>
              <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span> </div>
            <div class="tips_info" id="confirm_dlg_content"></div>
            <div class="tips_sbt">
              <input value="取 消" class="btn_Lora_b" id="confirm_dlg_no" type="button">
              <input value="确 定" class="btn_Dora_b" id="confirm_dlg_yes" type="button">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--弹窗内容文件-->
  </div>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="images/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="images/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="images/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="alert_c">
        <div class="state error">
          <div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>
        </div>
      </div>
      <div class="tips_sbt">
        <input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_confirm_title">温馨提示</h2>
        <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span> </div>
      <div class="tips_info" id="yclass_confirm_content" style="zoom:1"></div>
      <div class="tips_sbt">
        <input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
        <input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
</div>
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>