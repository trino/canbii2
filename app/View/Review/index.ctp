<div class="page_layout page_margin_top clearfix">
	<div class="page_header clearfix">
		<div class="page_header_left">
			<h1 class="page_title">New Cannabis Review</h1>
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
					New Cannabis Review
				</li>
			</ul>
		</div>
		<div class="page_header_right">
<a style="margin-right:10px;" title="Read more"  href="<?php  echo $this->webroot; ?>users/dashboard" class="more large dark_blue icon_small_arrow margin_right_white">My Account</a>
<a style="margin-right:10px;"  title="Read more"  href="<?php  echo $this->webroot; ?>users/settings" class="more large dark_blue icon_small_arrow margin_right_white  ">Settings</a>
<a style="margin-right:10px;" title="Read more" href="<?php  echo $this->webroot; ?>review"  class="active more large dark_blue icon_small_arrow margin_right_white  ">Add Review</a>
<a style="" title="Read more" href="<?php  echo $this->webroot; ?>review/all"  class="more large dark_blue icon_small_arrow margin_right_white  ">My Reviews</a>
</div>
	</div>

	<div class="clearfix page_margin_top ">



<div class="page_left">





<div class="clearfix"></div>

<form class="contact_form page_margin_top" action="" method="post">
<h2>Cannabis Name:</h2>
<input type="text" id="searchName" value="" placeholder="3 characters minimum" />
<span class="extra">(e.g. Purple Kush, AK47, Blue Dream)</span>
<div class="results" style="display: none;">
<label>Select Item to Review:</label><br />
<input type="hidden" name="strain" value="" id="strainz"  />
<div class="butt" style="color:red;"></div>
</div>
</form>

</div>



        <div class="page_right">



            <div class="backgroundcolor page_margin_top">
                <h2>
                    Best Suited Time of Use</h2>


                <ul class=" page_margin_top clearfix">
                    <li class="column"  style="">
                        <div style="float:left;">
                            <img src="<?php echo $this->webroot;?>images/IndicaIcon.png" alt="" style="">
                        </div>
                        <div style="float:left;margin-left: 15px;">
                            <h1>Indica</h1>
                            Best for Night Time Use
                        </div>
                    </li>
                    <li class="column" style="clear:both;">

                        <div style="float:left;">
                            <img src="<?php echo $this->webroot;?>images/SativaIcon.png" alt="" style="">
                        </div>
                        <div style="float:left;margin-left: 15px;">
                            <h1>Sativa</h1>
                            Best for Day Time Use
                        </div>
                    </li>
                    <li class="column" style="clear:both;">
                        <div style="float:left;">
                            <img src="<?php echo $this->webroot;?>images/HybridIcon.png" alt="">
                        </div>
                        <div style="float:left;margin-left: 15px;">
                            <h1>Hybrid</h1>
                            Best of Both Worlds
                        </div>
                    </li>
                </ul>



            </div>

		

</div>
</div>
</div>
<script>
    var lastsearch;

$(function(){
$('.opt').live('click',function(){
	$("#strainz").val($(this).attr("title"));
   $("#sub").removeAttr("disabled"); 
  if($(this).attr('class').replace('sel',"")!=$(this).attr('class'))
	{
		$(this).removeClass('sel');
		return
	}
	$('.opt').each(function(){
		$(this).removeClass('sel');
	});
	$(this).addClass('sel');
})
$('#searchName').on('keydown keyup click input submit mouseenter', function(){
	var txt = $(this).val();
    if (txt.length > 2 && txt !=lastsearch) {
        lastsearch=txt;
        $('.butt').html("Now loading...");
        $.ajax({
            type: "post",
            url: "<?php echo $this->webroot;?>strains/ajax_search",
            data: "str=" + txt,
            success: function (msg) {
                $('.results').show();
                $('.butt').html(msg);
            }
        })
    }
});
});

$(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});
</script>