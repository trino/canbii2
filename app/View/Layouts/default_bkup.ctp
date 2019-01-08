<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php
        $generic = $this->requestAction('/pages/getGeneric');
        if (ucfirst($this->params['action']) == 'Index' && ucfirst($this->params['controller']) != 'Strains') {
            $gtitle = 'Home';
        } else
            $gtitle = ucfirst($this->params['action']);
    ?>
    <meta charset="UTF-8"/>
    <meta property="og:image"
          content="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $this->webroot . 'images/logo.png'; ?>"/>
    <meta property="og:title" content="<?php if (isset($title)) {
        echo $title . ' - Canbii';
    } else {
        echo str_replace('_', ' ', $gtitle) . ' - ' . $generic['title'];
    } ?>"/>
    <meta property="og:type" content="website"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="format-detection" content="telephone=no"/>

    <meta name="description" content="<?php if (isset($description)) {
        echo $description;
    } else {
        echo $generic['description'];
    } ?>">

    <meta name="keywords" content="<?php if (isset($keyword)) {
        echo $keyword;
    } else {
        echo $generic['keyword'];
    } ?>">
    <title><?php if (isset($title)) {
            echo $title . ' - Canbii';
        } else {
            echo str_replace('_', ' ', $gtitle) . ' - ' . $generic['title'];
        } ?></title>

    <link rel="shortcut icon" href="<?= $this->webroot; ?>favicon.ico" type="image/x-icon"/>
    <link rel="icon" href="<?= $this->webroot; ?>favicon.ico" type="image/x-icon"/>

    <link rel="stylesheet" href="<?= $this->webroot; ?>css/ui.css"/>
    <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery-1.11.0.min.js"></script>


    <script src="<?= $this->webroot; ?>js/validate.js"></script>
    <script src="<?= $this->webroot; ?>js/ui.js"></script>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Volkhov:400italic' rel='stylesheet' type='text/css'>


    <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/reset.css"/>
    <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/superfish.css"/>
    <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/fancybox/jquery.fancybox.css"/>
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
    <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery.blockUI.js"></script>
    <!--script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script-->
    <!--script type="text/javascript" src="<!php echo $this->webroot;?>js2/main.js"></script-->


    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


    <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

</head>
<body>

<!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->


<div class="site_container">

    <div class="header_container">
        <div class="header clearfix">
            <div class="header_left">
                <a href="<?= $this->webroot; ?>" title="MEDICALMARIJUANA">
                    <img src="<?= $this->webroot; ?>images/logo.png" height=100 alt="logo"/>
                </a>
            </div>

            <ul class="sf-menu header_right">


                <li class="<?php if ($this->params['controller'] == 'pages' && $this->params['action'] == 'index') { ?>current_page_item<?php } ?>">
                    <a href="<?= $this->webroot; ?>" accesskey="1">Home</a></li>
                <li class="<?php if ($this->params['controller'] == 'strains' || $this->params['controller'] == 'review') { ?>current_page_item<?php } ?>">
                    <a href="<?php echo $this->webroot ?>strains/all" accesskey="2">Strains</a></li>
                <li class="<?php if ($this->params['controller'] == 'pages' && $this->params['action'] == 'about') { ?>current_page_item<?php } ?>">
                    <a href="<?= $this->webroot; ?>pages/about" accesskey="3">About</a></li>
                <li class="<?php if ($this->params['controller'] == 'pages' && $this->params['action'] == 'contact_us') { ?>current_page_item<?php } ?>">
                    <a href="<?= $this->webroot; ?>pages/contact_us" accesskey="4">Contact Us</a></li>
				
				<li><a href="<?= $this->webroot; ?>menu" accesskey="4">Shop</a></li>
					
                <?php if (!$this->Session->read('User')) { ?>
                    <li class="<?php if ($this->params['controller'] == 'users') { ?>current_page_item<?php } ?>"><a
                            href="<?= $this->webroot; ?>users/register" accesskey="4">Login /
                            Register</a></li>
                <?php } else { ?>
                    <li class="<?php if ($this->params['controller'] == 'users') { ?>current_page_item<?php } ?> submenu<?php echo(isset($_GET['page']) && ($_GET["page"] == "" || $_GET["page"] == "home") ? " selected" : ""); ?>">
                        <a href="<?= $this->webroot; ?>users/dashboard" accesskey="4"
                          ><?= ucfirst($this->Session->read('User.username')) ?>'s Account</a>
                        <ul>
                            <li<?php echo(isset($_GET['page']) && $_GET["page"] == "home" ? " class='selected'" : ""); ?>>
                                <!--<a style="color: #888!important;" class="darkmenu" href="<?= $this->webroot; ?>users/dashboard" accesskey="5">My Dashboard</A> -->
                                <a style="color: #888!important;" class="darkmenu"
                                   href="<?= $this->webroot; ?>users/logout" accesskey="5">Logout</a>
                            </li>

                        </ul>
                    </li>

                <?php } ?>
            </ul>
            <div class="mobile_menu">

                     <select class="mmenu" >
                <option value = "<?php echo $this->webroot?>" <?php if($this->params['controller']=='pages' && $this->params['action']=='index'){?>selected = "selected" <?php }?> > Home </option>
                <option value = "<?php echo $this->webroot?>strains/all" <?php if($this->params['controller']=='strains' || $this->params['controller']=='review'){?>selected = "selected"<?php }?> > Strains </option>
                <option value = "<?php echo $this->webroot;?>pages/about" <?php if($this->params['controller']=='pages' && $this->params['action']=='about'){?>selected = "selected"<?php }?> > About </option>
                <option value = "<?php echo $this->webroot;?>pages/contact_us" <?php if($this->params['controller']=='pages' && $this->params['action']=='contact_us'){?>selected = "selected"<?php }?> > Contact </option>

                
                <?php if(!$this->Session->read('User')){?>
                <option value = "<?php echo $this->webroot;?>users/register"
                <?php if($this->params['controller']=='users'){?>selected = "selected"<?php }?> > Login / Register </option>
                <?php }else{?>
                <option value = "<?php echo $this->webroot;?>users/dashboard"
                <?php if($this->params['controller']=='users'){?>selected = "selected"<?php }?> > <?=ucfirst($this->Session->read('User.username'))?> Dashboard </option>
                <option value = "<?php echo $this->webroot;?>users/logout" > Logout </option>
                <?php }?>


                </select>
            </div>

        </div>
    </div>

    <?php
        if(isset($homepage)) {
            include("combine/newsite.php");
        }
    ?>

    <div class="page clearfix">
        <?php
            echo $this->Session->flash();
            echo $this->fetch('content');
        ?>
    </div>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

</div>
<div class="footer_container">
    <div class="footer">
        <ul class="footer_banner_box_container clearfix">
            <li class="footer_banner_box super_light_blue animated_element animation-fadeIn duration-500">
                <h2>
                    Why Go Natural?
                </h2>

                <p style="color: white;margin-bottom:20px;">
                    <a href="<?= $this->webroot; ?>pages/about">The guide to Medical
                        Marijuana &raquo;</a>
                </p>
            </li>
            <li class="footer_banner_box light_blue animated_element animation-slideRight duration-800 delay-500">
                <h2>
                    Join the Movement
                </h2>

                <p style="color: white;margin-bottom:20px;">
                    <a href="<?= $this->webroot; ?>pages/about">Help make the world a better
                        place &raquo;</a>
                </p>
            </li>
            <li class="footer_banner_box blue animated_element animation-slideRight200 duration-800 delay-1000">
                <h2>
                    Questions or Concerns?
                </h2>

                <p>
                    <a href="<?= $this->webroot; ?>pages/contact_us">Feel free to contact us by clicking
                        here &raquo;</a>
                </p>
            </li>

        </ul>
        <div class="footer_box_container clearfix">
            <div class="footer_box">
                <h3 class="box_header">
                    Canbii - <span style="font-size: 14px;"> Personalized Medical Marijuana</span>
                </h3>

                <p style="color: #D5D5D5;" align="">
                    Medicinal marijuana is a growing movement and we're doing our part to spread the word.(name of site)
                    is an online database dedicated to educate the public on the benefits of medical marijuana. This all
                    natural plant is used to treat illnesses and to help those who suffer from chronic pain that affects
                    their daily lives.<br/>
                    <br/>
                    We need your input to enhance our information so we can help as many people as we can. <a
                        href="<?= $this->webroot; ?>users/register" accesskey="4">Sign up</a> today!
                </p>
                <ul class="social_icons clearfix">
                    <li>
                        <a class="social_icon facebook" href="https://www.facebook.com/pages/Canbii/1543633612534714"
                           target="_blank">
                            &nbsp;
                        </a>
                    </li>
                    <li>
                        <a class="social_icon twitter" href="https://twitter.com/canbiionline" target="_blank">
                            &nbsp;
                        </a>
                    </li>
                    <li>
                        <a class="social_icon mail" href="mailto:info@canbii.com">
                            &nbsp;
                        </a>
                    </li>
                </ul>
            </div>
            <div class="footer_box">
                <div class="clearfix">
                    <div class="header_left">
                        <h3 class="box_header">
                            Latest Reviews
                        </h3>
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
                                        <a href="<?= $this->webroot; ?>review/detail/<?php echo $s['Review']['id']; ?>">
                                            <b><?php echo $s['Strain']['name']; ?></b><br>


                                        </a>
                                        <br>
                                        <?php echo substr($s['Review']['review'], 0, 40) . '...'; ?>

                                        <abbr class="timeago">
                                            <?php echo "<a href='" . $this->webroot . "strains/review/all/?user=" . $s['Review']['user_id'] . "'>" . ucfirst($s['User']['username']) . "</a>&nbsp;" . $s['Review']['on_date']; ?>
                                        </abbr>
                                    </li>



                                <?php
                                }
                            }
                            if ($count == 0) {
                                echo "trdhfklhbf";
                            }
                        ?>


                    </ul>
                </div>
            </div>
            <div class="footer_box last">
                <div class="clearfix">
                    <div class="header_left">
                        <h3 class="box_header">
                            Latest Tweets
                        </h3>
                    </div>
                    <div class="header_right">
                        <!--a href="#" id="latest_tweets_prev" class="scrolling_list_control_left icon_small_arrow left_white"></a>
                        <a href="#" id="latest_tweets_next" class="scrolling_list_control_right icon_small_arrow right_white"></a-->
                    </div>
                </div>
                <div class="scrolling_list_wrapper">


                    <a class="twitter-timeline" data-chrome="noborders" href="https://twitter.com/canbiionline"
                       data-widget-id="511869655112114176">Tweets by @canbiionline</a>
                    <script>!function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + "://platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "twitter-wjs");</script>
                </div>
            </div>
        </div>
        <div class="copyright_area clearfix">
            <div class="copyright_left"><a href="http://canbii.com" title="canbii"
                                           target="_blank">Canbii.com</a> © Copyright <?php echo "2014-" . date('Y'); ?>
                /


                <a href="<?php echo $this->webroot . 'pages/privacy'; ?>" target="_blank">Privacy Policy</a> /
                <a href="<?php echo $this->webroot . 'pages/terms'; ?>" target="_blank">Terms & Conditions</a>


            </div>
            <div class="copyright_right">
                <a class="scroll_top icon_small_arrow top_white" href="#top" title="Scroll to top">Top</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

<?php echo $this->element('sql_dump'); ?>