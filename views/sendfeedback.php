<div data-role="page" id="sendfeedbackpage" data-add-back-btn="true" data-back-btn-text="back">
  <form action="/score" method="POST" id="tx_ifeedback_contactform" data-ajax="false" enctype="multipart/form-data" >
    <div data-role="header">
      <h1 class="header"><?php echo $texts[10] ?></h1>
      <a href="#" class="ui-btn-right" data-icon="arrow-r" data-iconpos="right" data-ajax="false" data-role="button" data-theme="d" data-inline="true" id="cf_header_send"><?php echo $texts[12] ?></a>
    </div>
    <div data-role="content">
      <div class="contentheader">
        <div class="container_12">
          <div class="grid_8 if_logo">
            <a href="#page27658" data-transition="none">
              <img src="/files/<?php echo $hotel['logo']; ?>"></a>
            </div>
            <div class="grid_4 langselector">
              <a href="#languages" data-role="button" data-mini="true" data-inline="true">
                <img class="flag" src="/files/<?php echo $language['flag'] ?>" />
              </a>
            </div>
          </div>
        </div>
        <div class="contentbody contentbodyheight">
          <h1><?php echo $texts[11] ?></h1>

          <div data-role="fieldcontain">
            <label for="tx_ifeedback_contactform_nationality"><?php echo $texts[13] ?></label>
            <input type="text" name="info[contact_nationality]" id="tx_ifeedback_contactform_nationality" value="" placeholder="<?php echo $texts[13] ?>" />
            <div id="d_nationality_req" class="d-f-req" style="display:none"><?php echo $texts[24] ?></div>
          </div>
          <input type="hidden" id="checkout_nationality" value="required" />

          <div data-role="fieldcontain">
            <label for="tx_ifeedback_contactform_mail"><?php echo $texts[18] ?></label>
            <input type="email" validationalert="No valid e-mail address." name="info[contact_mail]" id="tx_ifeedback_contactform_mail" value="" placeholder="<?php echo $texts[19] ?>" />
            <div id="d_mail_req" class="d-f-req" style="display:none"><?php echo $texts[24] ?></div>
          </div>
          <input type="hidden" id="checkout_mail" value="required" />

          <div data-role="fieldcontain">
            <label for="tx_ifeedback_contactform_roomno"><?php echo $texts[20] ?></label>
            <input type="text" name="info[contact_roomno]" id="tx_ifeedback_contactform_roomno" value="" placeholder="<?php echo $texts[21] ?>" />
            <div id="d_roomno_req" class="d-f-req" style="display:none"><?php echo $texts[24] ?></div>
          </div>
          <input type="hidden" id="checkout_roomno" value="required" />

          <div data-role="fieldcontain">
            <label for="tx_ifeedback_contactform_comments"><?php echo $texts[16] ?></label>
            <textarea name="info[contact_comments]" id="tx_ifeedback_contactform_comments" value=""></textarea>
            <div id="d_comments_req" class="d-f-req" style="display:none"><?php echo $texts[24] ?></div>
          </div>

          <div data-role="fieldcontain" id="tx_ifeedback_contactform_checkboxes"></div>
          <input type="hidden" id="requirement_attributes" lotteryreq="" callbackreq="<?php echo $texts[24] ?>" newsletterreq="" />
          <p id="send_button_wrapper" class="buttonaction">
            <input type="submit" id="tx_ifeedback_contactform_submit_button" name="info[contact_submit]" value="send" data-inline="true" data-icon="check" data-theme="a" />
            <input type="hidden" id="hi_idlesubmit" name="info[idle_submit]" value="no" />
          </p>
        </div>
      </div>
      <div data-role="footer">
        <?php include('views/footer.php'); ?>
      </div>
    </form>
  </div>