<script type="text/javascript">
    window.onload = function () {
        document.getElementById("UserPassword1").onchange = validatePassword;
        document.getElementById("UserConfirmPassword").onchange = validatePassword;
    };
    function validatePassword() {
        var pass2 = document.getElementById("UserConfirmPassword").value;
        var pass1 = document.getElementById("UserPassword1").value;
        if (pass1 != pass2) {
            document.getElementById("UserConfirmPassword").setCustomValidity("Passwords Don't Match");
        } else {
            document.getElementById("UserConfirmPassword").setCustomValidity('');
        }
        //empty string means no validation error
    }
</script>
<div class="page_layout page_margin_top clearfix">
    <div class="page_header clearfix">
        <div class="page_header_left">
            <h1 class="page_title">Login / Register</h1>
            <ul class="bread_crumb">
                <li>
                    <a href="<?= $this->webroot; ?>" title="Home">Home</a>
                </li>
                <li class="separator icon_small_arrow right_gray">&nbsp;</li>
                <li>Login / Register</li>
            </ul>
        </div>
        <div class="page_header_right">
            <!--form class="search">
                <input class="search_input hint" type="text" value="To search type and hit enter..." placeholder="To search type and hit enter...">
            </form-->
        </div>
    </div>

    <div class="clearfix page_margin_top ">
        <ul class="columns_3 page_margin_top clearfix">
            <li class="column">
                <ul>
                    <li class="home_box light_blue animated_element animation-fadeIn duration-500 fadeIn" style="height:100%;">
                        <h2>For the people, by the people.</h2>
                        <div class="news clearfix"><p></p>
                           <p class="text">Our goal is to raise the profile of cannabis as medicine, by providing the most complete and accurate data possible.</p>
                           <p></p>
                           <p class="text">Contributions in ways of strain reviews will be tallied up into a single report; providing an industry standard for cannabis' medical effects and properties.</p>
                        </div>
                    </li>
                    <!--li class="home_box blue animated_element animation-slideDown duration-800 delay-250 slideDown"
                        style="z-index: 2; -webkit-animation: 800ms 250ms; transition: 250ms; -webkit-transition: 250ms;">
                        <h2>
                            Why Sign Up?
                        </h2>
                        <div class="news clearfix"><p></p>
                            <p class="text" align="">
                                Here at medicenter we have individual doctor's lists. Click read more below to see
                                services and current timetable for our doctors.
                            </p>
                        </div>
                    </li-->
                </ul>
            </li>

            <li class="column">
                <div class="dropcap" style="border:1px solid #e8e8e8;padding: 0px 20px 10px 20px;">
                    <h2 class="box_header page_margin_top">Login</h2>
                    <div class="clearfix"></div>
                    <?php
                        $username = "";
                        $password = "";
                        if($GLOBALS["settings"]["islocal"]){
                            $username = "admin";
                            $password = "Pass1234!";
                        }
                        echo $this->Form->create('UserLogin',   array('url' => 'login?url=' . $url, 'class' => 'contact_form'));
                        echo $this->Form->input('username',     array('value' => $username, 'div' => array('class' => '')));
                        echo $this->Form->input('password',     array('value' => $password, 'div' => array('class' => '')));
                        echo $this->Form->submit('Login',       array('class' => 'more blue ', 'style' => 'float:left;margin-top:14px;'));
                        echo $this->Form->end();
                    ?>
                    <div style="padding-top: 10px;" class="clearfix"></div>
                    <a style="color: #999;" href="<?= $this->webroot; ?>users/forgot" class="forgot-password">Forgot Password?</a>
                </div>
            </li>

            <li class="column">
                <div class="dropcap" style="border:1px solid #e8e8e8;padding: 0px 20px 10px 20px;">
                    <h2 class="box_header page_margin_top">Register</h2>
                    <?php
                        echo $this->Form->create('User', array('url' => 'register', 'class' => 'contact_form',
                                                               'onsubmit' => "if($('.chh').is(':checked'))return true;else{ $('.check_error').show(); $('.check_error').fadeOut(5000); return false;}"));
                        echo '<fieldset>';
                            echo $this->Form->input('email', array('div' => array('class' => ''), 'label' => 'Email Address', 'type' => 'email'));
                            echo $this->Form->input('username', array('div' => array('class' => '')));
                        ?>
                            <div class="required">
                                <label for="UserPassword1">Password</label>
                                <input id="UserPassword1" type="password" required="required" name="data[User][password]"/>
                            </div>
                        <?php
                            //echo $this->Form->input('password',array('div'=>array('class'=>'form-row')));
                            echo $this->Form->input('confirm_password', array('div' => array('class' => ''), 'type' => 'password'));
                        ?>
                        <label class="checkbox"><input type="checkbox" name="check_field" class="chh"/>&nbsp; I have read and agree to the
                            <a href="<?= $this->webroot . 'pages/privacy'; ?>" target="_blank">Privacy Policy</a> and
                            <a href="<?= $this->webroot . 'pages/terms'; ?>" target="_blank">Terms & Conditions</a>.
                        </label>
                        <label class="check_error" style="color: red; display:none;"> Please agree to Privacy Policy and the Terms & Conditions.</label>
                        <?php
                            echo $this->Form->submit('Register', array('class' => 'more blue sbmt', 'style' => 'float:left;margin-top:0px;'));
                            echo $this->Form->end();
                        ?>
                    </fieldset>
                    <div class="clearfix"></div>
                </div>
            </li>
        </ul>
    </div>
</div>