<?php

    if (isset($user)) {
        $nationality = $user['User']['nationality'];
        $gender = $user['User']['gender'];
        $age_group = $user['User']['age_group'];
        $health = $user['User']['health'];
        $weight = $user['User']['weight'];
        $exp = $user['User']['years_of_experience'];
        $frequency = $user['User']['frequency'];
        $body_type = $user['User']['body_type'];
        $symptoms = $user['User']['symptoms'];
        $card_id = $user['User']['card_id'];
        $country = $user['User']['country'];
    } else {
        $nationality = "";
        $gender = '';
        $age_group = "";
        $health = "";
        $weight = "";
        $exp = "";
        $frequency = "";
        $body_type = "";
        $symptoms = "";
        $card_id = "";
        $country = "";
    }

?>
<div class="page_layout page_margin_top clearfix">
    <div class="page_header clearfix">
        <div class="page_header_left">
            <h1 class="page_title">My Account</h1>
            <ul class="bread_crumb">
                <li>
                    <a href="<?php echo $this->webroot ?>" title="Home">
                        Home
                    </a>
                </li>
                <li class="separator icon_small_arrow right_gray">
                    &nbsp;
                </li>
                <li>
                    My Account
                </li>
            </ul>
        </div>
        <div class="page_header_right"><!-- float:right;-->
            <a style="margin-right:10px;" title="Read more" href="<?php echo $this->webroot; ?>users/dashboard"
               class="active more large dark_blue icon_small_arrow margin_right_white dashboarditem">My Account</a>
            <a style="margin-right:10px;" title="Read more" href="<?php echo $this->webroot; ?>users/settings"
               class="more large dark_blue icon_small_arrow margin_right_white  ">Settings</a>
            <a style="margin-right:10px;" title="Read more" href="<?php echo $this->webroot; ?>review"
               class="more large dark_blue icon_small_arrow margin_right_white  ">Add Review</a>
            <a style="" title="Read more" href="<?php echo $this->webroot; ?>review/all"
               class="more large dark_blue icon_small_arrow margin_right_white">My Reviews</a>
        </div>

        <div class="clearfix">
        </div>

        <form action="" method="post" id="dashboard" class="contact_form">
            <div class="page_left page_margin_top">
                <div class="backgroundcolor"><p>Please ensure accuracy in your information so
                        we can further help personalize medication for other patients.</p></div>

                <?php include('combine/profile_filter_inc.php'); ?>
                <div class="clearfix"></div>

                <input type="submit" name="submit" value="Save" class="blue more" style=""/>

            </div>

            <div class="page_right page_margin_top"
            ">


<h3>The more we know, the more we can help.</h3>
            <a style="width:100%;padding:0px;" title="Read more" href="<?php echo $this->webroot; ?>review"
               class="more dark_blue icon_small_arrow margin_right_white  "><h1 style="padding:20px;color:white;">Add A Review</h1></a>




            <!--div id="dashboard_symptom" style="background:#42B3E5; padding:15px;">
                <p id="P_5">
                    <?php
                        $effect = $this->requestAction('/pages/getSym');
                        $symp = explode(',', $symptoms);
                        foreach ($effect as $e) {
                            ?>
                            <a class="A_6 <?php if (in_array($e['Symptom']['id'], $symp)) { ?>searchact<?php } ?>"
                               style="font-size: 15px;" href="javascript:void(0)" onclick="highlightsym($(this))" class=""
                               id="sym_<?php echo $e['Symptom']['id']; ?>"><?php echo $e['Symptom']['title'] ?></a>
                        <?php
                        } ?>
                </p>

                <p style="display: none;" class="symp">
                    <?php
                        if ($symp) {
                            foreach ($symp as $sy) {
                                ?>
                                <input class="sym_<?php echo $sy; ?>" type="hidden" value="<?php echo $sy; ?>"
                                       name="symptoms[]">
                            <?php
                            }
                        } ?>
                </p>

                <div class="clearfix"></div>
            </div-->


        </form>

    </div>
</div>
</div>
<script>
    function highlightsym(thiss) {
        if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
            thiss.addClass('searchact');
            $('.symp').append('<input type="hidden" name="symptoms[]" value="' + thiss.attr('id').replace('sym_', '') + '" class="' + thiss.attr('id') + '"  />')
        } else {
            thiss.removeClass('searchact')
            $('.' + thiss.attr('id')).remove();
        }
        $('.key').val('');
    }
</script>