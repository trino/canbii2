<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
    $generic = $this->requestAction('/pages/getGeneric');
    if(ucfirst($this->params['action']) == 'Index' && ucfirst($this->params['controller'])!='Strains')
    {
        $gtitle = 'Home';
    }
    else
    $gtitle = ucfirst($this->params['action']);
    ?>  
<meta charset="UTF-8" />
<meta property="og:image" content="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$this->webroot.'images/logo.png';?>" />
<meta property="og:title" content="<?php if(isset($title)){echo $title.' - Canbii';}else{echo str_replace('_',' ',$gtitle).' - '.$generic['title'];}?>" />
<meta property="og:type" content="website" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="format-detection" content="telephone=no" />

    <meta name="description" content="<?php if(isset($description)){echo $description;}else{echo $generic['description'];}?>">
    
    <meta name="keywords" content="<?php if(isset($keyword)){echo $keyword;}else{echo $generic['keyword'];}?>">
    <title><?php if(isset($title)){echo $title.' - Canbii';}else{echo str_replace('_',' ',$gtitle).' - '.$generic['title'];}?></title>

<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon"/>
<link rel="icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon"/>

<link rel="stylesheet" href="<?php echo $this->webroot;?>css/ui.css" />
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery-1.11.0.min.js"></script>



<script src="<?php echo $this->webroot;?>js/validate.js"></script>
<script src="<?php echo $this->webroot;?>js/ui.js"></script>

<!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Volkhov:400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/superfish.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/fancybox/jquery.fancybox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/jquery.qtip.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/responsive.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot;?>style2/animations.css" />


<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.ba-bbq.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.carouFredSel-5.6.4-packed.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.sliderControl.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.timeago.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.hint.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.isotope.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.isotope.masonry.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.qtip.min.js"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/jquery.blockUI.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo $this->webroot;?>js2/main.js"></script>
<script>
    $(function(){
        $(".noprint").hide();
    })
</script>
<!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

</head>
<?php echo $content_for_layout; ?>