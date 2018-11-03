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
			<h1 class="page_title">All Reviews</h1>
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
					All Reviews
				</li>
			</ul>
		</div>
<div class="clearfix"></div>        
<div class="page_header_left"><br />
<?php
if(!isset($_GET['sort']))
{
    $sort = 'desc';
}
else
$sort = $_GET['sort'];

if($sort=='asc')
$sort = 'desc';
else
$sort = 'asc';

if(!isset($_GET['filter']))
$filter = '';
else
$filter = $_GET['filter'];
?>
			<strong>Filter By: </strong><a class="filter_by" href="<?php echo $this->request->webroot;?>review/showAll/?filter=rate&sort=<?php echo $sort;?>">Most Rated</a> <a class="filter_by" href="<?php echo $this->request->webroot;?>review/showAll/?filter=on_date&sort=<?php echo $sort;?>">Most Recent</a> 
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


    
<script>
$(function(){
    var more='<?php echo $offset?>';
    
    var spinnerVisible = false;
    
    $('.loadmore a').live('click',function(){
        //alert('test');
        more=parseFloat(more)+8;
       $.ajax({
           url:'<?php echo $this->webroot;?>review/show_all_blank/'+more+'<?php if($filter){echo '?filter='.$filter.'&sort='.$sort;}?>',
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
<style>
.filter_by{
    display:inline-block;padding:6px 12px;margin-left: 10px;background:#e5e5e5;color:#666;
}
</style>
