<script src="<?php echo $this->webroot;?>js/raty.js"></script>
<script src="<?php echo $this->webroot;?>js/labs.js"></script>
<link href="<?php echo $this->webroot;?>css/raty.css" rel="stylesheet" type="text/css" />




<div class="page_layout page_margin_top clearfix">
	<div class="page_header clearfix">
		<div class="page_header_left">
			<h1 class="page_title">Reviews for - <?php echo $strain['Strain']['name'];?></h1>
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
					Reviews for - <?php echo $strain['Strain']['name'];?>
				</li>
			</ul>
		</div>
		<div class="page_header_right">
			<!--form class="search">
				<input class="search_input hint" type="text" value="To search type and hit enter..." placeholder="To search type and hit enter...">
			</form-->
		</div>
	</div>

	<div class="clearfix page_margin_top ">


	
<ul class="tabs_navigation2 clearfix" >
<li style=""><p>Sort by:</p></li>
<li>
<a href="<?php echo $this->webroot;?>strains/review/<?php echo $strain['Strain']['slug'];?>/recent">Most Recent</a> 
	</li><li>
<a href="<?php echo $this->webroot;?>strains/review/<?php echo $strain['Strain']['slug'];?>/helpful">Most Helpful</a>
	</li>
</ul>
<!--php include('combine/profile_filter.php'); // purple monkey dishwasher ?-->


		
<div class="comments clearfix page_margin_top">
<div id="comments_list">
<?php include('combine/review_filter.php');
// echo ($reviewz);?>
</div>
</div>
		
		
		
		
		
</div>
</div>
<div class="clear"></div>
<script>
$(function(){
    
    var profile='';
    $('.hidden_filter select').change(function(){
        profile = '';
        $('.hidden_filter select').each(function(){
        
        
        var value = $(this).val();
        
        if(value){
        var field = $(this).attr('name');            
        if(!profile)            
        profile = field+'='+value;
        else
        profile = profile+'&'+field+'='+value;
        
        
        }
        
        });
        
        val = profile;
        
        
        
        
        
        var more='<?php echo $limit?>';    
        var spinnerVisible = false; 
        var sort='<?php echo(isset($this->params['pass'][1]) && $this->params['pass'][1]!="")?$this->params['pass'][1]:"recent";?>';
        
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
            $('#comments_list').html(res);
           } 
        });
        
        
        
        
        
        
        
        
        
        
        
        
        
    });    
    
    
    
    
    var more='<?php echo $limit?>';    
    var spinnerVisible = false; 
    var sort='<?php echo(isset($this->params['pass'][1]) && $this->params['pass'][1]!="")?$this->params['pass'][1]:"recent";?>';    
    $('.loadmore a').live('click',function(){
        more=parseFloat(more)+8;
        var val = profile;
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

$('.yes').click(function(){
   var id = $(this).attr('id');
   var arr = id.split('_');
   var r_id = arr[1];
   $.ajax({
    url:'<?php echo $this->webroot;?>strains/helpful/'+r_id+'/yes',
   });
   $('#'+arr[0]+'_'+r_id).removeClass('yes');
   $('#'+arr[0]+'_'+r_id).attr('style','background:#FFF;color:#CCC;cursor: default;');
   $('#'+arr[0]+'_'+r_id).attr('onclick','return false;');
   var o = parseFloat(arr[0])+1;
   $('#'+o+'_'+r_id).removeClass('no');
   $('#'+o+'_'+r_id).attr('style','background:#FFF;color:#CCC;cursor: default;display:inline-block;padding:8px 7px;');
   $('#'+o+'_'+r_id+' strong').attr('style','color:#CCC;');
   $('#'+o+'_'+r_id).attr('onclick','return false;'); 
   $(this).attr('style',$(this).attr('style').replace('background:#FFF;','background:#e5e5e5;display:inline-block;padding:8px 7px;'));
});
$('.no').click(function(){
   var id = $(this).attr('id');
   
   var arr2 = id.split('_');
   var num = parseFloat(arr2[0]-1);
   var r_id = arr2[1];
   $.ajax({
    url:'<?php echo $this->webroot;?>strains/helpful/'+r_id+'/no',
   });
   $('#'+num+'_'+r_id).removeClass('yes');
   var o = parseFloat(num)+1;
   $('#'+o+'_'+r_id).removeClass('no'); 
   $('#'+num+'_'+r_id).attr('style','background:#FFF;color:#CCC;cursor: default;display:inline-block;padding:8px 7px;')
   $('#'+num+'_'+r_id+' strong').attr('style','color:#CCC;');
   //$('#'+num+'_'+r_id).attr('onclick','return false;');
   //$('#'+o+'_'+r_id).attr('style','background:#FFF;color:#CCC;cursor: default;');
   //$('#'+o+'_'+r_id).attr('onclick','return false;'); 
   $(this).attr('style','background:#e5e5e5;display:inline-block;padding:8px 7px;color:#CCC;cursor: default;');
});
});
</script>