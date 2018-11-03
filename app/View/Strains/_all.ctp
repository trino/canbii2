<script src="<?php echo $this->webroot;?>js/raty.js"></script>
<script src="<?php echo $this->webroot;?>js/labs.js"></script>
<script src="<?php echo $this->webroot;?>js/scroll.js"></script>
<link href="<?php echo $this->webroot;?>css/raty.css" rel="stylesheet" type="text/css" />

<?php
if(isset($_GET['effects'])&&$_GET['effects'])
{
    foreach($_GET['effects'] as $ef)
    {
        $effects[] = $ef;
    }
}
else
$effects = array();

if(isset($_GET['symptoms'])&&$_GET['symptoms'])
{
    foreach($_GET['symptoms'] as $ef)
    {
        $symptoms[] = $ef;
    }
}
else
$symptoms = array();
?>
<script>

    var recent_flag = 'ASC';
    var rated_flag = 'ASC';
    var alpha_flag = 'DESC';
    var viewed_flag = 'ASC';
    var reviewed_flag = 'ASC';
</script>





<div class="page_layout page_margin_top clearfix">
	<!-div class="page_header clearfix">
		<div class="page_header_left">
			<h1 class="page_title">Filter Strains</h1>
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
					Filter Strains
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


<ul class="tabs_navigation2" >
<li>


		<a href="#" class="eff1" id="recent">

	<strong>SORT:</strong></a>

	</li><li>
	<a href="javascript:void(0);" class="eff1" id="recent">

	Most Recent</a>
	</li>	<li>
	<a href="javascript:void(0)" class="eff1" id="rated">

	Top Rated</a>
	</li>	<li>
	<a href="javascript:void(0)" class="eff1" id="viewed">

	Most Viewed</a>
		</li>	<li>
	<a href="javascript:void(0)" class="eff1" id="reviewed">
	Most Reviewed</a>
		</li>	<li>
	<a href="javascript:void(0)" class="eff1" id="alpha">

	Alphabetically</a>

		</li>
</ul>



	<div class="page_left">
    <div class="listing">    <?php
    if($strain)
    {
        $j=0;
        foreach($strain as $s)
        {
            $j++;
            ?>

			<!--?php echo $s['Strain']['published_date'];?>

<a class="" href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>">
<h2>
<?php echo $s['Strain']['name'];?>
</h2><?php echo $s['StrainType']['title'];?>
</a>

<p><?php echo substr($s['Strain']['description'],0,130).'...';?></p>
<a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>" class="button-small">View Detail</a>
<div class="rating<?php echo $j;?> " style=""></div>

<?php if($s['Strain']['review'])echo '<a href="'.$this->webroot.'strains/review/'.$s['Strain']['slug'].'">'.$s['Strain']['review'].' Reviews</a>';else echo '0 Reviews';?>

<script>
$(function(){
$('.rating<?php echo $j;?>').raty({number:5,readOnly:true,score:<?php echo $s['Strain']['rating'];?>});
});
</script-->
 <div class="post-item">
<ul class="blog">
<li class="post">
<ul class="comment_box clearfix" style="">
	<li class="date clearfix">
		<div class="value">
		<a style="color:white;" href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>">
        <?php echo $s['StrainType']['title'];?>

        </a>
		</div>
	</li>
	<li class="comments_number" style="">
<?php if($s['Strain']['review'])echo '<a href="'.$this->webroot.'strains/review/'.$s['Strain']['slug'].'">'.$s['Strain']['review'].' Reviews</a>';else echo '0 Reviews';?>
	</li>
</ul>
<div class="post_content">
	<h2>
		<a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>">
<?php echo $s['Strain']['name'];?>
        </a>

	</h2>
<p>
<?php echo substr($s['Strain']['description'],0,160).'...';?>

</p>
<script>
$(function(){
    $('.rating<?php echo $s['Strain']['id'];?>').raty({number:5,readOnly:true,score:<?php echo $s['Strain']['rating'];?>});
});
</script>
<div class="rating<?php echo $s['Strain']['id'];?> " style=""></div>




	<div class="post_footer">
		<ul class="post_footer_details">
			<li>Posted in</li>
			<li>
				<a href="#" title="General">
					General,
				</a>
			</li>
			<li>
				<a href="#" title="Outpatient surgery">
					Outpatient surgery
				</a>
			</li>
		</ul>
		<ul class="post_footer_details">
			<li>Posted by </li>
			<li>
				<a href="#" title="John Doe">
					John Doe
				</a>
			</li>
		</ul>
	</div>
</div>
</li>
</ul>
</div>

	<?php
        }
    }
    ?>
    <div class="clear"></div>

	</div>
    <div id="spinner">
    <button id="more">Load More</button>
     <?php
         echo $this->Paginator->next('Show more...',array('style'=>'display:none;'));
    ?>
    </div>
    </div>
			<div class="page_right page_margin_top">
	<ul>
				<li class="home_box light_blue animated_element animation-fadeIn duration-500" style="z-index: 3;">
					<h2>
						<a href="?page=contact" title="Emergency Case">
							FILTER BY EFFECTS
						</a>
					</h2>
					<div class="news clearfix">

<div class="choose_eff" >
<?php $effect = $this->requestAction('/pages/getEff');
foreach($effect as $e)
{
?>
<a style="color:white;" href="javascript:void(0)" class="small-btn eff2" id="eff_<?php echo $e['Effect']['id'];?>"><?php echo $e['Effect']['title']?></a>
<?php
}
?>
<p style="display: none;" class="effe"></p>
</div>
			</div>
				</li>
				<li class="home_box blue animated_element animation-slideDown duration-800 delay-250" style="z-index: 2;">
					<h2>
						<a href="?page=timetable" title="Doctors Timetable">
		FILTER BY SYMPTOM
						</a>
					</h2>
					<div class="news clearfix">
<div class="choose_sym">
<?php $effect = $this->requestAction('/pages/getSym');
foreach($effect as $e)
{
?>
<a  style="color:white;"  href="javascript:void(0)" class="sym2 small-btn" id="sym_<?php echo $e['Symptom']['id'];?>"><?php echo $e['Symptom']['title']?></a>
<?php
}
?>
<p style="display: none;" class="symp"></p>
</div>

					</div>
				</li>

			</ul>

			</div>

			</div>

			</div>



    <input type="hidden" class="recent" value="ASC" />
    <input type="hidden" class="rated" value="ASC" />
    <input type="hidden" class="viewed" value="ASC" />
    <input type="hidden" class="reviewed" value="ASC" />
    <input type="hidden" class="alpha" value="DESC" />

	<div class="clearfix"></div>


    <script>
    var spinnerVisible = false;


    $(function(){

    $("#more").click(function(){
    $('.listing').infinitescroll('retrieve');
        return false;
    });
        var $container = $('.listing');

    $container.infinitescroll({
      behavior: 'local',
      navSelector  : '.next',    // selector for the paged navigation
      nextSelector : '.next a',  // selector for the NEXT link (to page 2)
      itemSelector : '.post-item',     // selector for all items you'll retrieve
      debug         : true,
      dataType      : 'html',
      loading: {
          finishedMsg: 'No more Strains.',
          img: '<?php echo $this->webroot; ?>img/spinner.gif'
        }
      }
    );

   $(window).unbind('.infscr');
    $('.sym2').click(function(){

        var sort =0;
if($(this).attr('class').replace('searchact2','')==$(this).attr('class'))
{

    $(this).addClass('searchact2');
    $('.effe').append('<input type="hidden" name="symptoms[]" value="'+$(this).attr('id').replace('sym_','')+'" class="symps '+$(this).attr('id')+'"  />')}else{$(this).removeClass('searchact2')

        $('.'+$(this).attr('id')).remove();
    }
    $('.key').val('');
    /*else
    var sort = 1;*/
    if (!spinnerVisible) {
        $("div#spinner").fadeIn("fast");
        spinnerVisible = true;
    }
        var i=0;
        var val = '';
       $('.effs').each(function(){
        if($(this).val()){
        i++;
        if(i==1)
            val = 'effects[]='+$(this).val();
        else
            val = val+'&effects[]='+$(this).val();
            }

       });
       $('.symps').each(function(){
        if($(this).val()){
        i++;
        if(i==1)
            val = 'symptoms[]='+$(this).val();
        else
            val = val+'&symptoms[]='+$(this).val();
            }
    });
    if(val){
        val = val+'&key=';
        }
        else
        val = 'key=';



        $.ajax({
           url:'<?php echo $this->webroot;?>strains/filter',
           data:val,
           type:'get',
           success:function(res){
             if (spinnerVisible) {
        var spinner = $("div#spinner");
        spinner.stop();
        spinner.fadeOut("fast");
        spinnerVisible = false;
    }
            $('.listing').html(res);
           }
        });

    });

    $('.eff2').click(function(){
        var sort =0;
if($(this).attr('class').replace('searchact2','')==$(this).attr('class'))
{

    $(this).addClass('searchact2');
    $('.effe').append('<input type="hidden" name="effects[]" value="'+$(this).attr('id').replace('eff_','')+'" class="effs '+$(this).attr('id')+'"  />')}else{$(this).removeClass('searchact2')

        $('.'+$(this).attr('id')).remove();
    }
    $('.key').val('');
    /*else
    var sort = 1;*/
    if (!spinnerVisible) {
        $("div#spinner").fadeIn("fast");
        spinnerVisible = true;
    }
        var i=0;
        var val = '';
       $('.effs').each(function(){
        if($(this).val()){
        i++;
        if(i==1)
            val = 'effects[]='+$(this).val();
        else
            val = val+'&effects[]='+$(this).val();
            }

       });
       $('.symps').each(function(){
        if($(this).val()){
        i++;
        if(i==1)
            val = 'symptoms[]='+$(this).val();
        else
            val = val+'&symptoms[]='+$(this).val();
            }
    });
    if(val){
        val = val+'&key=';
        }
        else
        val = 'key=';



        $.ajax({
           url:'<?php echo $this->webroot;?>strains/filter',
           data:val,
           type:'get',
           success:function(res){
             if (spinnerVisible) {
        var spinner = $("div#spinner");
        spinner.stop();
        spinner.fadeOut("fast");
        spinnerVisible = false;
    }
            $('.listing').html(res);
           }
        });

    });

    $('.eff1').click(function(){
        var id = $(this).attr('id');
        var sort = $('.'+id).val();
        if(sort == 'ASC')
        {
            sort = 'DESC';
            $('.'+id).val('DESC');
        }
        else
        {
            sort = 'ASC';
            $('.'+id).val('ASC');
        }






    if (!spinnerVisible) {
        $("div#spinner").fadeIn("fast");
        spinnerVisible = true;
    }
        var i=0;
        var val = '';
       $('.effs').each(function(){
        if($(this).val()){
        i++;
        if(i==1)
            val = 'effects[]='+$(this).val();
        else
            val = val+'&effects[]='+$(this).val();
            }

       });
       $('.symps').each(function(){
        if($(this).val()){
        i++;
        if(i==1)
            val = 'symptoms[]='+$(this).val();
        else
            val = val+'&symptoms[]='+$(this).val();
            }
    });
    if(val){
        val = val+'&key=';
        }
        else
        val = 'key=';
        if(sort)
        {
            val = val+'&sort='+id+'&order='+sort;
        }



        $.ajax({
           url:'<?php echo $this->webroot;?>strains/filter',
           data:val,
           type:'get',
           success:function(res){
             if (spinnerVisible) {
        var spinner = $("div#spinner");
        spinner.stop();
        spinner.fadeOut("fast");
        spinnerVisible = false;
    }
            $('.listing').html(res);
           }
        });

    });
    <?php
    if($effects)
    {
        foreach($effects as $eff)
        {
            ?>
            $('#eff_<?php echo $eff;?>').click();
            <?php
        }
    }
    if($symptoms)
    {
        foreach($symptoms as $eff)
        {
            ?>
            $('#sym_<?php echo $eff;?>').click();
            <?php
        }
    }
    ?>
    });
    </script>