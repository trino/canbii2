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
            if (!isset($title)) {
                $title = str_replace('_', ' ', $gtitle) . ' - ' . $generic['title'];
            }
            $title .= ' - Canbii - Personalized Medical Cannabis';
            if (!isset($description)) {
                $description = $generic['description'];
            }
            if (!isset($keyword)) {
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

        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/bootstrap-grid.min.css"/>
        <script type="text/javascript" src="<?= $this->webroot; ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $this->webroot; ?>js/bootstrap.bundle.min.js"></script>

        <!-- Debugger -->
        <?php if($this->Session->check("User.id")){ ?>
            <!--script type="text/javascript" src="<?= $this->webroot;?>debugger/debug.plugin.js"></script>
            <script type="text/javascript" src="<?= $this->webroot;?>debugger/jquery-ui.min.js"></script>
            <link rel="stylesheet" type="text/css" href="<?= $this->webroot;?>debugger/debug.css" /-->
        <?php } ?>
    </head>
    <body>
        <div class="site_container">
            <input type="hidden" id="canbii_userID" value="<?= $this->Session->read("User.id"); ?>" />
            <div class="header_container">
                <div class="header clearfix">
                    <div class="header_left" style="vertical-align: middle;position:relative">
                        <a href="<?= $this->webroot; ?>" title="MEDICAL MARIJUANA">
                            <div style="float:left;width:80%;">
                                <img src="<?= $this->webroot; ?>images/logo.png" style="margin-top:10px;" height=80 alt="logo"/>
                            </div>
                        </a>
                    </div>

                    <DIV CLAS="row">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light col-lg-12 col-md-12 col-sm-12 col-xs-6">
                            <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <?php
                                        if(!function_exists("quicklistitem")){
                                            //use findBootstrapEnvironment(); in javascript to detect the current Bootstrap screen mode
                                            function quicklistitem($webroot, $url, $value, $accesskey, $name){
                                                echo '<LI CLASS="nav-item';
                                                if ($value) {echo ' active current_page_item';}
                                                echo '"><A HREF="' . $webroot . $url . '" CLASS="nav-link">' . $name . '</A></LI>';
                                            }
                                        }
                                        quicklistitem($this->webroot, "", $this->params['controller'] == 'pages' && $this->params['action'] == 'index', 1, 'Home');
                                        quicklistitem($this->webroot, "strains/all", $this->params['controller'] == 'strains' || $this->params['controller'] == 'review', 2, 'Cannabis Strains');
                                        quicklistitem($this->webroot, "pages/shop", $this->params['controller'] == 'pages' && $this->params['action'] == 'shop', 4, 'Shop');
                                        quicklistitem($this->webroot, "pages/doctors", $this->params['controller'] == 'pages' && $this->params['action'] == 'doctors', 4, 'For Doctors');
                                        quicklistitem($this->webroot, "pages/contact_us", $this->params['controller'] == 'pages' && $this->params['action'] == 'contact_us', 4, 'Contact');
                                        if (!$this->Session->read('User')) {
                                            quicklistitem($this->webroot, "users/register", $this->params['controller'] == 'users', 4, 'Login / Register');
                                        } else {
                                            echo '<li class="nav-item dropdown">';
                                            echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                                            echo ucfirst($this->Session->read('User.username'))  . "'s Account</a>" . '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                            $dashboardclass = "";
                                            if ($this->params['controller'] == 'users') { $dashboardclass .= ' current_page_item';}
                                            if(isset($_GET['page']) && ($_GET["page"] == "" || $_GET["page"] == "home")){$dashboardclass .= " selected";}
                                            echo '<a class="dropdown-item' . $dashboardclass . '" href="' . $this->webroot . 'users/dashboard">Dashboard</a>';
                                            echo '<a class="dropdown-item darkmenu" style="color: #888!important;" href="' . $this->webroot . 'users/logout">Logout</a>';
                                            echo '</div></li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </nav>
                    </DIV>
                </div>
            </div>
            <?php
                if(isset($homepage)) {
                    include("combine/newsite.php");
                }
                echo '<div class="page clearfix">';
                echo $this->Session->flash();
                echo $this->fetch('content');
                echo '</div>';
            ?>
        </div>
        <div class="footer_container">
            <div class="footer container">
                <ul class="footer_banner_box_container clearfix actualfooter row">
                    <li class="footer_banner_box super_light_blue animated_element animation-fadeIn duration-500 col-lg-4">
                        <h2 class="scaletowidth no-wrap">Why Go Natural?</h2>
                        <p style="color: white;margin-bottom:20px;">
                            <a style="font-size:13px;" href="<?= $this->webroot?>pages/about">The guide to Medical Cannabis &raquo;</a>
                        </p>
                    </li>
                    <li class="footer_banner_box light_blue animated_element animation-slideRight duration-800 delay-500 col-lg-4">
                        <h2 class="scaletowidth no-wrap">Join The Movement</h2>
                        <p style="color: white;margin-bottom:20px;">
                            <a style="font-size:13px;" href="<?= $this->webroot?>users/register">The more we know, the more we can help &raquo;</a>
                        </p>
                    </li>
                    <li class="footer_banner_box blue animated_element animation-slideRight200 duration-800 delay-1000 col-lg-4">
                        <h2 class="scaletowidth no-wrap">Questions Or Concerns?</h2>
                        <p style="color: white;margin-bottom:20px;">
                            <a style="font-size:13px;" href="<?= $this->webroot?>pages/contact_us">Feel free to contact us by clicking here &raquo;</a>
                        </p>
                    </li>
                </ul>
                <div class="footer_box_container clearfix row has-float-bottom-35">
                    <div class="footer_box col-lg-4 col-md-6">
                        <h3 class="box_header">Canbii - <span style="font-size: 14px;"> Personalized Medical Cannabis</span></h3>

                        <p style="color: #D5D5D5;">
                            For the people, by the people. The more we know, the more we can help.

                            <br/>
                            <br/>
                            The medical cannabis movement is asking the scientific community to make examining the therapeutic potential of cannabis a priority. But the drug's controlled status is continuing to slow efforts to investigate the myriad compounds in the plant.

                            <br/>
                            <br/>
                            Please do your part in helping the world's largest clinical trial so that we can better understand the use and effects of the cannabis plant.
                        </p>

                        <a href="<?= $this->webroot?>pages/about" accesskey="3" class="more blue float-bottom" style="float:left;margin-top:10px;">Read More</a>
                    </div>
                    <div class="footer_box col-lg-4 col-md-6">
                        <div class="clearfix">
                            <div class="header_left">
                                <h3 class="box_header">Latest Reviews</h3>
                            </div>
                            <!--<div class="header_right">
                                <a href="#" id="footer_recent_posts_prev" class="scrolling_list_control_left icon_small_arrow left_white"></a>
                                <a href="#" id="footer_recent_posts_next" class="scrolling_list_control_right icon_small_arrow right_white"></a>
                            </div>-->
                        </div>
                        <div class="scrolling_list_wrapper has-float-bottom-35">
                            <ul class="scrolling_list footer_recent_posts">
                                <?php
                                    $strains = $this->requestAction('pages/get_strain');
                                    $count = 0;
                                    if ($strains) {
                                        //var_dump($strains);
                                        foreach ($strains as $s) {
                                            $count += 1;
                                            echo '<li class="icon_small_arrow right_white">';
                                            echo '<a href="' . $this->webroot . 'review/detail/' . $s['Review']['id'] . '"><b>' . $s['Strain']['name'] . '</b><br></a><br>';
                                            echo substr($s['Review']['review'], 0, 40) . '...';
                                            echo '<abbr class="timeago"><span style="color:white;">' . ucfirst($s['User']['username']) . '</span> &nbsp; ' . $s['Review']['on_date'];
                                            //echo '<!--a href="' . $this->webroot . 'strains/review/all/?user=' . $s['Review']['user_id'] . '">' . ucfirst($s['User']['username']) . '</a>&nbsp;' . $s['Review']['on_date'] . '-->';
                                            echo '</abbr></li>';
                                        }
                                    }
                                    if ($count == 0) {
                                        echo "No Results";
                                    }
                                ?>
                            </ul>
                            <a class="more blue float-bottom" style="float: left; margin-top: 10px;" accesskey="3" href="<?= $this->webroot;?>review/showAll">View All</a>
                        </div>
                    </div>
                    <div class="footer_box last col-lg-4 col-md-6">
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
                            <li><a class="social_icon facebook" href="https://www.facebook.com/pages/Canbii/1543633612534714" target="_blank">&nbsp;</a></li>
                            <li><a class="social_icon twitter" href="https://twitter.com/canbiionline" target="_blank">&nbsp;</a></li>
                            <li><a class="social_icon mail" href="mailto:info@canbii.com">&nbsp;</a></li>
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
        <DIV CLASS="sticky-footer">Bootstrap mode: <SPAN id="users-device-size"></SPAN></DIV>
        <SCRIPT>
            refreshbootstrap();
            window.onresize = function(event) {
                refreshbootstrap();
            };
            function refreshbootstrap(){
                $("#users-device-size").text( findBootstrapEnvironment() + " Width: " + $(window).width() );
            }
        </SCRIPT>
    </body>
</html>