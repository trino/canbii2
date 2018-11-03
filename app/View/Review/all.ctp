<script src="<?php echo $this->webroot;?>js/raty.js"></script>
<script src="<?php echo $this->webroot;?>js/labs.js"></script>
<link href="<?php echo $this->webroot;?>css/raty.css" rel="stylesheet" type="text/css" />
<div class="page_layout page_margin_top clearfix">
<div class="page_header clearfix">
<?php if($this->params['action']=='review'){
    //echo $this->params['action'];?>

<div class="page_header_left">
<h1 class="page_title"><?php if(!isset($_GET['user'])){?>My Reviews<?php }else{?>Reviews by <?php echo $this->requestAction('/strains/getUserName/'.$_GET['user']);?><?php  }?></h1>
<ul class="bread_crumb">
<li>
<a href="<?php echo $this->webroot?>" title="Home">
Home
</a>
</li>
<li class="separator icon_small_arrow right_gray">
&nbsp;
</li>
<li>
User Reviews
</li>
</ul>
</div>


<?php }

if(!isset($_GET['user'])){
    ?>
<div class="page_header_left">
			<h1 class="page_title">My Reviews</h1>
			<ul class="bread_crumb">
				<li>
					<a href="<?php echo $this->webroot;?>" title="Home">
						Home
					</a>
				</li>
				<li class="separator icon_small_arrow right_gray">
					&nbsp;
				</li>
				<li>
					My Reviews
				</li>
			</ul>
		</div>
<div class="page_header_right">
<a style="margin-right:10px" title="Read more"  href="<?php  echo $this->webroot; ?>users/dashboard" class="more large dark_blue icon_small_arrow margin_right_white">My Account</a>
<a style="margin-right:10px" title="Read more"  href="<?php  echo $this->webroot; ?>users/settings" class="more large dark_blue icon_small_arrow margin_right_white  ">Settings</a>
<a style="margin-right:10px" title="Read more" href="<?php  echo $this->webroot; ?>review"  class="more large dark_blue icon_small_arrow margin_right_white  ">Add Review</a>
<a style="" title="Read more" href="<?php  echo $this->webroot; ?>review/all"  class="active more large dark_blue icon_small_arrow margin_right_white  ">My Reviews</a>
</div>

<?php
}
?>
<div class="clearfix"></div>
</div>

<div class="clearfix page_margin_top revi">

<?php include_once('combine/my_reviews.php');?>

</div>
</div>

<?php if($this->params['action']=='review'){
    //echo $this->params['action'];?>
<script>
$(function(){
    var more='<?php echo $limit?>';
    var spinnerVisible = false;
    var sort='<?php echo(isset($this->params['pass'][1]) && $this->params['pass'][1]!="")?$this->params['pass'][1]:"recent";?>';
    $('.loadmore a').live('click',function(){
        more=parseFloat(more)+8;
        var val = '';
        var user = '<?php echo (isset($_GET['user']))?$_GET['user']:"";?>';
        if(user !="")
        {
            user = "?user="+user;
        }
        else
            user = "";
        var i=0;
		
       $.ajax({
           url:'<?php echo $this->webroot;?>strains/review_filter/<?php echo $slug;?>/'+sort+'/'+more+user,
           data:val,
           type:'get',
           success:function(res){
             if (spinnerVisible) {
        var spinner = $("div#spinner");
        spinner.stop();
        spinner.fadeOut("fast");
        spinnerVisible = false;
    }
            $('.morelist').show();
            $('.morelist').addClass('morelist2');
            $('.morelist2').removeClass('morelist');
            $('.morelist2').html(res);
            $('.morelist2').removeClass('morelist2');
           }
        });
    });
$('.rates img').each(function(){
    var src = $(this).attr('src');
    src = src.replace('../','<?php echo $this->webroot;?>');
    $(this).attr('src',src);
});
})
</script>
<?php }

elseif($this->params['controller']=='review' && $this->params['action']=='all')
{?>
 <script>
$(function(){
    var more='<?php echo $limit?>';
    var spinnerVisible = false;

    $('.loadmore a').live('click',function(){
        more=parseFloat(more)+4;
        var val = '';
        var i=0;
       $.ajax({
           url:'<?php echo $this->webroot;?>review/all_filter/'+more,
           data:val,
           type:'get',
           success:function(res){
           if (spinnerVisible) {
                var spinner = $("div#spinner");
                spinner.stop();
                spinner.fadeOut("fast");
                spinnerVisible = false;
            }
            $('.morelist').show();
            $('.morelist').addClass('morelist2');
            $('.morelist2').removeClass('morelist');
            $('.morelist2').html(res);
            $('.morelist2').removeClass('morelist2');
           }
        });
    });
$('.rates img').each(function(){
    var src = $(this).attr('src');
    src = src.replace('../','<?php echo $this->webroot;?>');
    $(this).attr('src',src);
});
})
</script>

<?php
}
?>