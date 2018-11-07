<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
            $generic = $this->requestAction('/pages/getGeneric');
            if (ucfirst($this->params['action']) == 'Index' && ucfirst($this->params['controller']) != 'Strains') {
                $gtitle = 'Home';
            } else {
                $gtitle = ucfirst($this->params['action']);
            }
            if (isset($title)) {
                $title .= ' - Canbii - Personalized Medical Cannabis';
            } else {
                $title = str_replace('_', ' ', $gtitle) . ' - ' . $generic['title'] . ' - Personalized Medical Cannabis';
            }
            if (!isset($description)) {
                $description = $generic['description'];
            }
            if (isset($keyword)) {
                $keyword = $generic['keyword'];
            }
        ?>
        <meta charset="UTF-8"/>
        <meta property="og:image" content="<?= protocol . $_SERVER['SERVER_NAME'] . $this->webroot . 'images/logo.png'; ?>"/>
        <meta property="og:title" content="<?= $title; ?>"/>
        <meta property="og:type" content="website"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="description" content="<?= $description; ?>">
        <meta name="keywords" content="<?= $keyword; ?>">
        <title><?=$title; ?></title>
    
        <link rel="shortcut icon" href="<?= $this->webroot; ?>favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="<?= $this->webroot; ?>favicon.ico" type="image/x-icon"/>
    
        <link rel="stylesheet" href="<?= $this->webroot; ?>css/ui.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/fancybox/jquery.fancybox.css"/>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery-1.11.0.min.js"></script>
    
        <script src="<?= $this->webroot; ?>js/validate.js"></script>
        <script src="<?= $this->webroot; ?>js/ui.js"></script>
    
        <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->
    
        <link href='<?= protocol ?>fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
        <link href='<?= protocol ?>fonts.googleapis.com/css?family=Volkhov:400italic' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/reset.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/superfish.css"/>
    
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/jquery.qtip.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/jquery-ui-1.9.2.custom.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/style.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/responsive.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/animations.css"/>

        <!--script type="text/javascript" src="<!php echo $this->webroot;?>js2/jquery-ui-1.9.2.custom.min.js"></script-->
        <!--script type="text/javascript" src="<!php echo $this->webroot;?>js2/jquery.carouFredSel-5.6.4-packed.js"></script-->
    
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.hint.js"></script>
    
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.ba-bbq.min.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.sliderControl.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.timeago.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.isotope.min.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.isotope.masonry.js"></script>
    
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.qtip.min.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.blockUI.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.fancybox-1.3.4.pack.js"></script>
        <!--script type="text/javascript" src="<?= protocol ?>maps.google.com/maps/api/js?sensor=false"></script-->
        <!--script type="text/javascript" src="<?= $this->webroot;?>js2/main.js"></script-->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53333c8154cd758d" async="async"></script>
    
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= $this->webroot; ?>upvote/upvote.css">
        <script src="<?= $this->webroot; ?>upvote/jquery.upvote.js"></script>
        <script src="<?= $this->webroot; ?>js2/bootstrap-modal.min.js"></script>

        <!-- Debugger -->
        <?php if($this->Session->check("User.id")){ ?>
            <!--script type="text/javascript" src="<?php echo $this->webroot;?>debugger/debug.plugin.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot;?>debugger/jquery-ui.min.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>debugger/debug.css" /-->
        <?php } ?>
    
        <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->
    
    </head>
    <body>
    
        <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

        <div class="site_container">
            <input type="hidden" id="canbii_userID" value="<?php echo $this->Session->read("User.id"); ?>" />
            <div class="header_container">
                <div class="header clearfix">
                    <div class="header_left" style="vertical-align: middle;position:relative">
                        <a href="<?= $this->webroot; ?>" title="MEDICALMARIJUANA">
                            <div style="float:left;width:80%;">
                                <img src="<?= $this->webroot; ?>images/logo.png" style="margin-top:10px;" height=80 alt="logo"/>
                            </div>
                        </a>
                    </div>

                    <ul class="sf-menu header_right">
                        <?php
                            if(!function_exists("quicklistitem")){
                                function quicklistitem($webroot, $value, $accesskey, $name){
                                    echo '<LI CLASS="';
                                    if ($value) {echo 'current_page_item';}
                                    echo '"><A HREF="' . $webroot . '" ACCESSKEY="' . $accesskey . '">' . $name . '</A></LI>';
                                }
                                function quickselectoption($webroot, $url, $text, $value){
                                    echo '<OPTION value="' . $webroot . $url . '" ';
                                    if($value){echo ' selected="selected"';}
                                    echo '> ' . $text . ' </OPTION>';
                                }
                            }
                            quicklistitem($this->webroot, $this->params['controller'] == 'pages' && $this->params['action'] == 'index', 1, 'Home');
                            quicklistitem($this->webroot, $this->params['controller'] == 'strains' || $this->params['controller'] == 'review', 2, 'Cannabis Strains');
                            quicklistitem($this->webroot, false, 4, 'Shop');
                            quicklistitem($this->webroot, $this->params['controller'] == 'pages' && $this->params['action'] == 'doctors', 4, 'For Doctors');
                            quicklistitem($this->webroot, $this->params['controller'] == 'pages' && $this->params['action'] == 'contact_us', 4, 'Contact');
                            if (!$this->Session->read('User')) {
                                quicklistitem($this->webroot, $this->params['controller'] == 'users', 4, 'Login / Register');
                            } else {
                                echo '<li class="submenu';
                                if ($this->params['controller'] == 'users') { echo ' current_page_item';}
                                echo(isset($_GET['page']) && ($_GET["page"] == "" || $_GET["page"] == "home") ? " selected" : "");
                                echo '"><a href="' . $this->webroot . 'users/dashboard" accesskey="4">' . ucfirst($this->Session->read('User.username'))  . "'s Account</a>";
                                echo '<ul><li' . isset($_GET['page']) && $_GET["page"] == "home" ? " class='selected'" : "" . '>';
                                /*echo '<!--<a style="color: #888!important;" class="darkmenu" href="<?= $this->webroot?>users/dashboard" accesskey="5" title="">My Dashboard</A> -->';*/
                                echo '<a style="color: #888!important;" class="darkmenu" href="' . $this->webroot . 'users/logout" accesskey="5" title="">Logout</a>';
                                echo '</li></ul></li>';
                            }
                        ?>
                    </ul>

                    <div class="mobile_menu">
                        <select class="mmenu">
                            <?php
                                quickselectoption($this->webroot, "", "Home", $this->params['controller']=='pages' && $this->params['action']=='index');
                                quickselectoption($this->webroot, "strains/all", "Cannabis Strains", $this->params['controller']=='strains' || $this->params['controller']=='review');
                                quickselectoption($this->webroot, "pages/shop", "Shop", true);
                                //quickselectoption($this->webroot, "pages/about", "About", $this->params['controller']=='pages' && $this->params['action']=='about');
                                quickselectoption($this->webroot, "pages/doctors", "For Doctors", $this->params['controller']=='pages' && $this->params['action']=='doctors');
                                quickselectoption($this->webroot, "pages/contact_us", "Contact", $this->params['controller']=='pages' && $this->params['action']=='contact_us');
                                if(!$this->Session->read('User')){
                                    quickselectoption($this->webroot, "users/register", "Login / Register", $this->params['controller']=='users');
                                } else {
                                    quickselectoption($this->webroot, "users/dashboard", ucfirst($this->Session->read('User.username')) . " My Account", $this->params['controller']=='users');
                                    quickselectoption($this->webroot, "users/logout", "Logout", true);
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->
            <!-- can you create a separate page for the following and include here? -->

            <script>
                $(function () {
                    $('.mmenu').change(function () {
                        window.location = $(this).val();
                    });
                });

                var spinnerVisible = false;

                function showProgress() {
                    if (!spinnerVisible) {
                        $("div#spinner").fadeIn("fast");
                        spinnerVisible = true;
                    }
                }

                function hideProgress() {
                    if (spinnerVisible) {
                        var spinner = $("div#spinner");
                        spinner.stop();
                        spinner.fadeOut("fast");
                        spinnerVisible = false;
                    }
                }

                function highlighteff(thiss) {
                    if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
                        thiss.addClass('searchact');
                        $('.effe').append('<input type="hidden" name="effects[]" value="' + thiss.attr('id').replace('eff_', '') + '" class="' + thiss.attr('id') + '"  />')
                    } else {
                        thiss.removeClass('searchact');
                        $('.' + thiss.attr('id')).remove();
                    }
                    $('.key').val('');
                }

                function highlightsym(thiss) {
                    if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
                        thiss.addClass('searchact');
                        $('.symp').append('<input type="hidden" name="symptoms[]" value="' + thiss.attr('id').replace('sym_', '') + '" class="' + thiss.attr('id') + '"  />')
                    } else {
                        thiss.removeClass('searchact');
                        $('.' + thiss.attr('id')).remove();
                    }
                    $('.key').val('');
                }

                /*
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
                 */

                function highlighteff2(thiss, order) {
                    var sort = 1;
                    if (thiss != 'recent' && thiss != 'rated' && thiss != 'alpha' && thiss != 'viewed' && thiss != 'reviewed') {
                        sort = 0;
                        if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
                            thiss.addClass('searchact');
                            $('.effe').append('<input type="hidden" name="effects[]" value="' + thiss.attr('id').replace('eff_', '') + '" class="effs ' + thiss.attr('id') + '"  />')
                        } else {
                            thiss.removeClass('searchact');
                            $('.' + thiss.attr('id')).remove();
                        }
                        $('.key').val('');
                    }
                    showProgress();
                    var i = 0;
                    var val = '';
                    $('.effs').each(function () {
                        if ($(this).val()) {
                            i++;
                            if (i == 1) {
                                val = 'effects[]=' + $(this).val();
                            }else {
                                val = val + '&effects[]=' + $(this).val();
                            }
                        }
                    });

                    $('.symps').each(function () {
                        if ($(this).val()) {
                            i++;
                            if (i == 1) {
                                val = 'symptoms[]=' + $(this).val();
                            }else {
                                val = val + '&symptoms[]=' + $(this).val();
                            }
                        }
                    });

                    if (val) {
                        val = val + '&key=';
                    } else {
                        val = 'key=';
                    }
                    if (sort) {
                        val = val + '&sort=' + thiss + '&order=' + order;
                    }

                    $.ajax({
                        url: 'filter',
                        data: val,
                        type: 'get',
                        success: function (res) {
                            hideProgress();
                            $('.listing').html(res);
                        }
                    });
                }

                function highlightsym2(thiss) {
                    if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
                        thiss.addClass('searchact');
                        $('.symp').append('<input type="hidden" name="symptoms[]" value="' + thiss.attr('id').replace('sym_', '') + '" class="symps ' + thiss.attr('id') + '"  />')
                    } else {
                        thiss.removeClass('searchact');
                        $('.' + thiss.attr('id')).remove();
                    }
                    $('.key').val('');
                    showProgress();
                    var i = 0;
                    var val = '';
                    $('.effs').each(function () {
                        if ($(this).val()) {
                            i++;
                            if (i == 1) {
                                val = 'effects[]=' + $(this).val();
                            } else {
                                val = val + '&effects[]=' + $(this).val();
                            }
                        }
                    });
                    $('.symps').each(function () {
                        if ($(this).val()) {
                            i++;
                            if (i == 1) {
                                val = 'symptoms[]=' + $(this).val();
                            } else {
                                val = val + '&symptoms[]=' + $(this).val();
                            }
                        }
                    });
                    if (val) {
                        val = val + '&key=';
                    } else {
                        val = 'key=';
                    }
                    $.ajax({
                        url: 'filter',
                        data: val,
                        type: 'get',
                        success: function (res) {
                            hideProgress();
                            $('.listing').html(res);
                        }
                    });
                }
            </script>

            <? if (isset($homepage)) { ?>
                <div class="background_image">
                    <div class="page" id="home_cannibis_frontpage" style="border-top:0;padding-bottom:0px;">
                        <div class="clearfix" style="background: #000; background: rgba(0,0,0,0.65); border-radius: 3px; margin: 0 auto; padding:25px 20px;">
                            <h1 id="H1_4">The Medical Marijuana Encyclopedia</h1>
                            <h1 id="H1_4" style="font-size: 30px">What Do You Suffer From?</h1>
                            <form id="FORM_13" class="contact_form" action="<?= $this->webroot?>strains/all" method="get" id="search" style="">
                                <p id="P_5">
                                    <?php
                                        $effect = $this->requestAction('/pages/getSym');
                                        //  debug($effect);
                                        $counter = 0;
                                        $num_of_sys = count($effect);

                                        foreach ($effect as $key => $e) {
                                            $counter ++;
                                            if($counter == 1){
                                                echo '<div style="width: 50%; text-align: left;float:left" class="show479_767">';
                                            }
                                            echo '<div><a class="A_6" style="" href="strains/all?symptoms=' . $e['Symptom']['id'] . '" onclick="highlightsym($(this))" id="sym_';
                                            echo $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a></div>';
                                            if($counter == ceil($num_of_sys/2)) {
                                                $counter = 0;
                                                echo "</div>";
                                            }
                                        }

                                        if($counter != 0){
                                            echo "</div>";
                                        }

                                        $counter = 0;

                                        foreach ($effect as $key => $e) {
                                            $counter ++;
                                            if($counter == 1){
                                                echo '<div style="width: 20%; text-align: left;float:left" class="hide767">';
                                            }

                                            echo '<div><!--a class="A_6" style="" href="javascript:void(0)" onclick="highlightsym($(this))" id="sym_';
                                            echo $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a-->';
                                            echo '<a class="A_6" style="" href="strains/all?symptoms=' . $e['Symptom']['id'] . '" onclick="highlightsym($(this))" class=""';
                                            echo 'id="sym_' . $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a></div>';

                                            if($counter == 10){
                                                $counter = 0;
                                                echo '</div>';
                                            }
                                        }
                                        if($counter != 0){
                                            echo "</div>";
                                        }

                                        /*
                                            foreach ($effect as $key => $e) {
                                                $islast = $key == 18;
                                                if ($key == 19) {
                                                }
                                                echo '<a class="A_6" style="" href="javascript:void(0)" onclick="highlightsym($(this))"';
                                                echo 'id="sym_' . $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a>';
                                                if ($key + 1 == count($effect)) {
                                                    echo "</P>";
                                                } elseif ($islast) {
                                                    echo ' or <a class="A_6" href="' . $this->webroot . 'strains/all">View all</a>';
                                                }
                                            }
                                        */
                                    ?>
                                </p>

                                <!--p id="P_5">
                                    Filter by Effects:
                                    <?php
                                        $effect = $this->requestAction('/pages/getEff');
                                        foreach ($effect as $key => $e) {
                                            $islast = $key == 18;
                                            if ($key == 19) {
                                                echo "<a href='javascript:;' onclick=\"$('.more1').toggle();\" style='color:#fff;font-weight:bold;'> </a></p><p class='more1' id='P_5' style='display:none;'>";
                                            }
                                            echo '<a  href="javascript:void(0)" class="A_6" onclick="highlighteff($(this))" id="eff_' . $e['Effect']['id'] . '">' . $e['Effect']['title'] . '</a></a>';
                                            if ($key + 1 == count($effect)) {
                                                echo "</P>";
                                            } elseif ($islast) {
                                                echo ' or <a class="A_6" href="' . $this->webroot . 'strains/all">View all</a>';
                                            }
                                        }
                                    ?>
                                </p-->

                                <p style="display: none;" class="effe"></p>
                                <p style="display: none;" class="symp"></p>
                                <div class="main2" style="padding-top: 40px;clear:both;">
                                    <div class="div12">
                                        <input id="INPUT_16" type="text" placeholder="or Search by Strain Name" name="key" class="key" style=""/>
                                        <input id="BUTTON_17" type="submit" value="Search" class="more blue medium " style=""/>
                                    </div>
                                </div>
                                <!-- dont know why but this div needs to be here -->
                                <div style="float:left;"></div>
                            </form>
                        </div>
                    </div>
                </div>
            <? } ?>

            <div class="page clearfix">
                <?= $this->Session->flash() . $this->fetch('content'); ?>
            </div>
            <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->
        </div>
        <div class="footer_container">
            <div class="footer">
                <ul class="footer_banner_box_container clearfix">
                    <li class="footer_banner_box super_light_blue animated_element animation-fadeIn duration-500">
                        <h2>Why Go Natural?</h2>

                        <p style="color: white;margin-bottom:20px;">
                            <a style="font-size:13px;" href="<?= $this->webroot?>pages/about" title="">The guide to MedicalCannabis &raquo;</a>
                        </p>
                    </li>
                    <li class="footer_banner_box light_blue animated_element animation-slideRight duration-800 delay-500">
                        <h2>Join The Movement</h2>

                        <p style="color: white;margin-bottom:20px;">
                            <a style="font-size:13px;" href="<?= $this->webroot?>users/register" title="">The more we know, the more we can help &raquo;</a>
                        </p>
                    </li>
                    <li class="footer_banner_box blue animated_element animation-slideRight200 duration-800 delay-1000">
                        <h2>Questions Or Concerns?</h2>

                        <p><a style="font-size:13px;" href="<?= $this->webroot?>pages/contact_us" title="">Feel free to contact us by clickinghere &raquo;</a></p>
                    </li>

                </ul>
                <div class="footer_box_container clearfix">
                    <div class="footer_box">
                        <h3 class="box_header">Canbii - <span style="font-size: 14px;"> Personalized Medical Cannabis</span></h3>

                        <p class="" style="color: #D5D5D5;" align="">
                            For the people, by the people. The more we know, the more we can help.

                            <br/>
                            <br/>
                            The medical cannabis movement is asking the scientific community to make examining the therapeutic potential of cannabis a priority. But the drug's controlled status is continuing to slow efforts to investigate the myriad compounds in the plant.

                            <br/>
                            <br/>
                            Please do your part in helping the world's largest clinical trial so that we can better understand the use and effects of the cannabis plant.
                        </p>

                        <a href="<?= $this->webroot?>pages/about" accesskey="3" title="" class="more blue" style="float:left;margin-top:10px;">Read More</a>
                    </div>
                    <div class="footer_box">
                        <div class="clearfix">
                            <div class="header_left">
                                <h3 class="box_header">Latest Reviews</h3>
                            </div>
                            <!--<div class="header_right">
                                <a href="#" id="footer_recent_posts_prev" class="scrolling_list_control_left icon_small_arrow left_white"></a>
                                <a href="#" id="footer_recent_posts_next" class="scrolling_list_control_right icon_small_arrow right_white"></a>
                            </div>-->
                        </div>
                        <div class="scrolling_list_wrapper">
                            <ul class="scrolling_list footer_recent_posts">
                                <?php
                                    $strains = $this->requestAction('pages/get_strain');
                                    $count = 0;
                                    if ($strains) {
                                        //var_dump($strains);
                                        foreach ($strains as $s) {
                                            $count += 1;
                                            ?>
                                            <li class="icon_small_arrow right_white">
                                                <a href="<?= $this->webroot; ?>review/detail/<?= $s['Review']['id']; ?>"><b><?= $s['Strain']['name']; ?></b><br></a>
                                                <br>
                                                <?= substr($s['Review']['review'], 0, 40) . '...'; ?>
                                                <abbr title="" class="timeago">
                                                    <span style="color:white;"><?= ucfirst($s['User']['username']); ?></span> &nbsp; <?= $s['Review']['on_date']; ?>
                                                    <!--a href="<?= $this->webroot; ?>strains/review/all/?user=<?= $s['Review']['user_id'];?>"><?= ucfirst($s['User']['username']); ?></a>&nbsp;
                                                    <?= $s['Review']['on_date']; ?>-->
                                                </abbr>
                                            </li>
                                            <?php
                                        }
                                    }
                                    if ($count == 0) {
                                        echo "No Results";
                                    }
                                ?>
                            </ul>
                            <a class="more blue" style="float:left;margin-top:10px;" title="" accesskey="3" href="<?= $this->webroot;?>review/showAll">View All</a>
                        </div>
                    </div>
                    <div class="footer_box last">
                        <div class="clearfix">
                            <div class="header_left">
                                <h3 class="box_header">Latest Tweets</h3>
                            </div>
                            <div class="header_right">
                                <!--a href="#" id="latest_tweets_prev" class="scrolling_list_control_left icon_small_arrow left_white"></a>
                                <a href="#" id="latest_tweets_next" class="scrolling_list_control_right icon_small_arrow right_white"></a-->
                            </div>
                        </div>
                        <div class="scrolling_list_wrapper">
                            <a class="twitter-timeline" data-height="282"data-chrome="noborders" href="https://twitter.com/canbiionline" data-widget-id="511869655112114176">Tweets by @canbiionline</a>
                            <script>!function (d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                        js = d.createElement(s);
                                        js.id = id;
                                        js.src = p + "://platform.twitter.com/widgets.js";
                                        fjs.parentNode.insertBefore(js, fjs);
                                    }
                                }(document, "script", "twitter-wjs");
                            </script>
                        </div>

                        <h3 class="box_header">Keep In Touch</h3>

                        <ul class="social_icons " style="float:left;margin-top:0px;">
                            <li><a class="social_icon facebook" href="https://www.facebook.com/pages/Canbii/1543633612534714" title="" target="_blank">&nbsp;</a></li>
                            <li><a class="social_icon twitter" href="https://twitter.com/canbiionline" title="" target="_blank">&nbsp;</a></li>
                            <li><a class="social_icon mail" href="mailto:info@canbii.com" title="">&nbsp;</a></li>
                        </ul>

                    </div>
                </div>
                <div class="copyright_area clearfix">
                    <div class="copyright_left">
                        <a href="<?= protocol ?>canbii.com" title="canbii" target="_blank">Canbii.com</a> © Copyright <?php echo "2014-" . date('Y'); ?> /
                        <a href="<?= $this->webroot . 'pages/privacy'; ?>" target="_blank">Privacy Policy</a> /
                        <a href="<?= $this->webroot . 'pages/terms'; ?>" target="_blank">Terms & Conditions</a>
                    </div>
                    <div class="copyright_right">
                        <a class="scroll_top icon_small_arrow top_white" href="#top" title="Scroll to top">Top</a>
                    </div>
                </div>
            </div>
        </div>

        <?php if($_SERVER['SERVER_NAME'] == "canbii.com"){ ?>
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                ga('create', 'UA-61032538-1', 'auto');
                ga('send', 'pageview');
            </script>
        <?php
        }
        echo '<!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->';
        echo $this->element('sql_dump');
        ?>
    </body>
</html>