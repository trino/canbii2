<?php
if (false) {
    echo "<pre>";
    $file = "C:\Users\dvt19\Desktop\september-1-hamiltonpizza.csv";
    //$file = "C:\Users\dvt19\Desktop\september-1-hamiltonpizza\d123.txt";
    $content = file_get_contents($file);
    $content = trim(preg_replace('/\s\s+/', ' ', $content));
    $content = trim(preg_replace("/\r|\n/", "", $content));


    $arr = explode(" ", $content);

    /*
    $i=0;
    $word ='1';
    foreach($arr as $single){
        $word = $word . ' ' . $single;
        if($i==2){
            $new[] = $word;
            $word = "";
            $i=0;
        }
    $i++;
    }
    $new = array_count_values($new);
    asort($new);
    print_r($new);

    die();
    */

    $arr = array_count_values($arr);
    asort($arr);

    print_r($arr);
    print_r(count($arr));
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
    $title .= ' - Canbii - Personalized Cannabis';
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
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?= $this->webroot; ?>upvote/upvote.css">
<script src="<?= $this->webroot; ?>upvote/jquery.upvote.js"></script>
<script src="<?= $this->webroot; ?>js2/bootstrap-modal.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/bootstrap-grid.min.css"/>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/style.css"/>
<script type="text/javascript" src="<?= $this->webroot; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/bootstrap.bundle.min.js"></script>
</head>


<?php if (false) { ?>
    <body class="background_image">
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column" style="background: rgba(0, 0, 0, 0.7);">
        <header class="masthead mb-auto">
            <div class="inner">
                <nav class="nav nav-masthead justify-content-center">
                    <a class="nav-link active" href="#">Home</a>
                    <a class="nav-link" href="#">Launching 02/19</a>
                </nav>
            </div>
        </header>
        <main role="main" class="cover">
            <div class="text-center pt-3">
                <a href="<?= $this->webroot; ?>" title="MEDICAL MARIJUANA"><img style="width: 220px" src="<?= $this->webroot; ?>images/logo.png"/></a>
                <br>
                <br>
                <p class="lead" style="max-width: 500px;margin:auto;">Canada's leading activity and value-based strain selection tool for recreational cannabis users.</p>
                <p class="lead"></p>
                <p class="lead"><a href="#" class="btn btn-lg btn-secondary">Website coming soon</a></p>
                <p class="lead"></p>
            </div>
        </main>
        <footer class="mastfoot mt-auto">
            <div class="inner mt-3 text-center">

                <p class="lead" style="font-size: .8rem !important;margin:auto;color:#999;max-width: 600px;">
                    Disclaimer: Canbii does not endorse, suggest, nor promote any specific effects or lifestyles related to recreational or medical cannabis consumption.
                </p>


                <p>
                    <a href="<?= protocol ?>canbii.com" title="canbii" target="_blank">Canbii.com</a> / Copyright <?php echo "2014-" . date('Y'); ?>
                    <?php if (false) { ?>
                        /
                        <a href="<?= $this->webroot . 'pages/privacy'; ?>" target="_blank">Privacy Policy</a>
                        / <a href="<?= $this->webroot . 'pages/terms'; ?>" target="_blank">Terms & Conditions</a>
                    <?php } ?>
                </p>
            </div>
        </footer>
    </div>
    </body>
<?php } else { ?>
    <body class="background_image">
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column" style="">
        <header class="masthead mb-auto">
            <div class="inner">
                <a href="<?= $this->webroot; ?>" title="MEDICAL MARIJUANA"><img style="width: 200px" src="<?= $this->webroot; ?>images/logo.png"/></a>
                <nav class="nav nav-masthead justify-content-center">
                    <a class="nav-link active" href="#">Home</a>
                    <a class="nav-link" href="#">Launching 02/19</a>
                </nav>
            </div>
        </header>

        <main role="main" class="cover">

            <input type="hidden" id="canbii_userID" value="<?= $this->Session->read("User.id"); ?>"/>
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light" style="padding:0">
                            <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <?php
                                    if (!function_exists("quicklistitem")) {
                                        function quicklistitem($webroot, $url, $value, $accesskey, $name)  {
                                            echo '<LI CLASS="nav-item';
                                            if ($value) {
                                                echo ' active current_page_item';
                                            }
                                            echo '"><A HREF="' . $webroot . $url . '" CLASS="nav-link">' . $name . '</A></LI>';
                                        }
                                    }
                                    // quicklistitem($this->webroot, "", $this->params['controller'] == 'pages' && $this->params['action'] == 'index', 1, 'Home');
                                    // quicklistitem($this->webroot, "strains/all", $this->params['controller'] == 'strains' || $this->params['controller'] == 'review', 2, 'View Strains');
                                    // quicklistitem($this->webroot, "pages/shop", $this->params['controller'] == 'pages' && $this->params['action'] == 'shop', 4, 'Shop');
                                    // quicklistitem($this->webroot, "pages/doctors", $this->params['controller'] == 'pages' && $this->params['action'] == 'doctors', 4, 'For Doctors');
                                    // quicklistitem($this->webroot, "pages/contact_us", $this->params['controller'] == 'pages' && $this->params['action'] == 'contact_us', 4, 'Contact');
                                    // if (!$this->Session->read('User')) {
                                    // quicklistitem($this->webroot, "users/register", $this->params['controller'] == 'users', 4, 'Login / Register');
                                    // }
                                    ?>
                                </ul>
                        </nav>

                        <div class="text-center py-4 my-4">
                            <h1 class="cover-heading">ADD CANBII TO YOUR LIFE</h1>
                            <p class="lead">Canada's leading activity and value-based strain selection tool for recreational cannabis users.</p>
                            <p class="lead"></p>
                            <p class="lead"><a href="#" class="btn btn-lg btn-secondary">Website coming soon</a></p>
                            <p class="lead"></p>
                        </div>

                        <?php
                            if (isset($homepage)) {
                                include("combine/newsite.php");
                            }
                            echo $this->Session->flash();
                            echo $this->fetch('content');
                        ?>
                    </div>
                </div>
            </div>
        </main>
        <footer class="mastfoot mt-auto">
            <div class="inner mt-3">
                <p>
                    <a href="<?= protocol ?>canbii.com" title="canbii" target="_blank">Canbii.com</a> / Copyright <?php echo "2014-" . date('Y'); ?>
                    / <a href="<?= $this->webroot . 'pages/privacy'; ?>" target="_blank">Privacy Policy</a>
                    / <a href="<?= $this->webroot . 'pages/terms'; ?>" target="_blank">Terms & Conditions</a>
                </p>
            </div>
        </footer>
    </div>
    </body>
<?php } ?>


</html>


<!--DIV ID="users-device-size"></DIV-->
<?php // echo $this->element('sql_dump'); ?>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c437a982227d36b"></script>

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
?>

<SCRIPT>
    var webroot = "<?= $this->webroot;?>";
    var currenturl = "<?= currentURL; ?>";

    refreshbootstrap();
    window.onresize = function (event) {
        refreshbootstrap();
    };

    function refreshbootstrap() {
        var mode = findBootstrapEnvironment();
        $("#users-device-size").text("Mode: " + mode + " Width: " + $(window).width() + " Container: " + $(".container").width());
        $(".responsive").each(function (index) {
            var ID = $(this).attr("id");//xs, sm, md, lg, xl
            $(this).removeClass(ID + "-xs").removeClass(ID + "-sm").removeClass(ID + "-md").removeClass(ID + "-lg").removeClass(ID + "-xl").addClass(ID + "-" + mode);
        });
    }

    function findBootstrapEnvironment() {
        let envs = ['xs', 'sm', 'md', 'lg', 'xl'];
        let el = document.createElement('div');
        document.body.appendChild(el);
        let curEnv = envs.shift();
        for (let env of envs.reverse()) {
            el.classList.add(`d-${env}-none`);
            if (window.getComputedStyle(el).display === 'none') {
                curEnv = env;
                break;
            }
        }
        document.body.removeChild(el);
        return curEnv;
    }
</SCRIPT>

<?php if (false) { ?>
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