<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
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
<meta property="og:image"
      content="<?= protocol . $_SERVER['SERVER_NAME'] . $this->webroot . 'images/logo.png'; ?>"/>
<meta property="og:title" content="<?= $title; ?>"/>
<meta property="og:type" content="website"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="description" content="<?= $description; ?>">
<meta name="keywords" content="<?= $keyword; ?>">
<title><?= $title; ?></title>

<link rel="shortcut icon" href="<?= $this->webroot; ?>favicon.ico" type="image/x-icon"/>
<link rel="icon" href="<?= $this->webroot; ?>favicon.ico" type="image/x-icon"/>

<link rel="stylesheet" href="<?= $this->webroot; ?>css/ui.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>style2/fancybox/jquery.fancybox.css"/>
<script type="text/javascript" src="<?= $this->webroot; ?>js2/jquery-1.11.0.min.js"></script>

<script src="<?= $this->webroot; ?>js/validate.js"></script>
<script src="<?= $this->webroot; ?>js/ui.js"></script>

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
<!--script type="text/javascript" src="<?= $this->webroot; ?>js2/main.js"></script-->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53333c8154cd758d"
        async="async"></script>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= $this->webroot; ?>upvote/upvote.css">
<script src="<?= $this->webroot; ?>upvote/jquery.upvote.js"></script>
<script src="<?= $this->webroot; ?>js2/bootstrap-modal.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/bootstrap-grid.min.css"/>
<script type="text/javascript" src="<?= $this->webroot; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/bootstrap.bundle.min.js"></script>

<!-- Debugger -->
<?php if ($this->Session->check("User.id")) { ?>
    <!--script type="text/javascript" src="<?= $this->webroot; ?>debugger/debug.plugin.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>debugger/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>debugger/debug.css" /-->
<?php } ?>
</head>
<body style="background:#d7d7d7">


<input type="hidden" id="canbii_userID" value="<?= $this->Session->read("User.id"); ?>"/>


<div class="container" style="background: white !important;">

            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a href="<?= $this->webroot; ?>" title="MEDICAL MARIJUANA"><img src="<?= $this->webroot; ?>images/logo.png"/></a>
                        <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <?php
                                if (!function_exists("quicklistitem")) {
//use findBootstrapEnvironment(); in javascript to detect the current Bootstrap screen mode
                                    function quicklistitem($webroot, $url, $value, $accesskey, $name)
                                    {
                                        echo '<LI CLASS="nav-item';
                                        if ($value) {
                                            echo ' active current_page_item';
                                        }
                                        echo '"><A HREF="' . $webroot . $url . '" CLASS="nav-link">' . $name . '</A></LI>';
                                    }
                                }
                                quicklistitem($this->webroot, "", $this->params['controller'] == 'pages' && $this->params['action'] == 'index', 1, 'Home');
                                quicklistitem($this->webroot, "strains/all", $this->params['controller'] == 'strains' || $this->params['controller'] == 'review', 2, 'Strains');
                                //        quicklistitem($this->webroot, "pages/shop", $this->params['controller'] == 'pages' && $this->params['action'] == 'shop', 4, 'Shop');
                                //        quicklistitem($this->webroot, "pages/doctors", $this->params['controller'] == 'pages' && $this->params['action'] == 'doctors', 4, 'For Doctors');
                                //        quicklistitem($this->webroot, "pages/contact_us", $this->params['controller'] == 'pages' && $this->params['action'] == 'contact_us', 4, 'Contact');
                                if (!$this->Session->read('User')) {
                                    //            quicklistitem($this->webroot, "users/register", $this->params['controller'] == 'users', 4, 'Login / Register');
                                } else {
                                    /*
                                    echo '<li class="nav-item dropdown">';
                                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                                    echo ucfirst($this->Session->read('User.username')) . "'s Account</a>" . '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                    $dashboardclass = "";
                                    if ($this->params['controller'] == 'users') {
                                        $dashboardclass .= ' current_page_item';
                                    }
                                    if (isset($_GET['page']) && ($_GET["page"] == "" || $_GET["page"] == "home")) {
                                        $dashboardclass .= " selected";
                                    }
                                    echo '<a class="dropdown-item' . $dashboardclass . '" href="' . $this->webroot . 'users/dashboard">Dashboard</a>';
                                    echo '<a class="dropdown-item darkmenu" >Logout</a>';
                                    echo '</div></li>';
                                    */
                                }
                                ?>
                            </ul>
                    </nav>


                    <?php
                    if (isset($homepage)) {
                        include("combine/newsite.php");
                    }
                    echo $this->Session->flash();
                    echo $this->fetch('content');
                    ?>


                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">

                    <h3>Why Go Natural?</h3>
                    <a href="pages/about">The guide to Medical Cannabis &raquo;</a></div>
                <div class="col-md-4">

                    <h3>Join The Movement</h3>
                    <a href="users/register">The more we know, the more we can help &raquo;</a></div>
                <div class="col-md-4">
                    <h3>Questions Or Concerns?</h3>
                    <a href="pages/contact_us">Feel free to contact us by clicking here &raquo;</a></div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">


                    <h3> Personalized Medical Cannabis</span></h3>


                    For the people, by the people. The more we know, the more we can help.
                    <br/>
                    <br/>
                    The medical cannabis movement is asking the scientific community to make examining the therapeutic
                    potential of cannabis a priority. But the drug's controlled status is continuing to slow efforts to
                    investigate the myriad compounds in the plant.
                    <br/>
                    <br/>
                    Please do your part in helping the world's largest clinical trial so that we can better understand the use and effects of the cannabis plant.
                    <a href="<?= $this->webroot ?>pages/about" accesskey="3">Read More</a>


                </div>
                <div class="col-md-4">


                    <h3>Latest Reviews</h3>
                    <?php
                    $strains = $this->requestAction('pages/get_strain');
                    $count = 0;
                    if ($strains) {
//var_dump($strains);
                        foreach ($strains as $s) {
                            $count += 1;
                            echo '<li >';
                            echo '<a href="' . $this->webroot . 'review/detail/' . $s['Review']['id'] . '"><b>' . $s['Strain']['name'] . '</b><br></a><br>';
                            echo substr($s['Review']['review'], 0, 40) . '...';
                            echo '<abbr >' . ucfirst($s['User']['username']) . '</span> &nbsp; ' . $s['Review']['on_date'];
//echo '<!--a href="' . $this->webroot . 'strains/review/all/?user=' . $s['Review']['user_id'] . '">' . ucfirst($s['User']['username']) . '</a>&nbsp;' . $s['Review']['on_date'] . '-->';
                            echo '</abbr></li>';
                        }
                    }
                    if ($count == 0) {
                        echo "No Results";
                    }
                    ?>


                </div>
                <div class="col-md-4">


                    <h3>Latest Tweets</h3>
                    <a>Tweets by @canbiionline</a>
                    <script>!function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0],
                                p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + "://platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "twitter-wjs");
                    </script>


                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 pb-3">
                    <a href="<?= protocol ?>canbii.com" title="canbii" target="_blank">Canbii.com</a> Copyright <?php echo "2014-" . date('Y'); ?> /<a href="<?= $this->webroot . 'pages/privacy'; ?>" target="_blank">Privacy
                        Policy</a>
                    /<a href="<?= $this->webroot . 'pages/terms'; ?>" target="_blank">Terms & Conditions</a>
                </div>
            </div>

</div>


<hr>

</body>
</html>


<?php if ($_SERVER['SERVER_NAME'] == "canbii.com") { ?>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-61032538-1', 'auto');
        ga('send', 'pageview');
    </script>
    <?php
}
echo $this->element('sql_dump');
?>


<SCRIPT>
    refreshbootstrap();
    window.onresize = function (event) {
        refreshbootstrap();
    };

    function refreshbootstrap() {
        $("#users-device-size").text(findBootstrapEnvironment() + " Width: " + $(window).width());
    }
</SCRIPT>
<?php if (true) { ?>
    <style>
        .row {
            border: 5px solid orange !important;
        }

        div[class^="col-"], div[class*=" col-"] {
            border: 5px solid red !important;
        }

        .container, .container-fluid {
            border: 5px solid green;
        }

        div {
            border: 1px solid black;
        }

    </style>
<?php } ?>