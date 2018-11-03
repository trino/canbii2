<div class="page_layout page_margin_top clearfix">

<?php include_once('combine/strains.php');?>

<div class="clearfix" style="margin-top: 20px;"></div>

    <div class="announcement page_margin_top clearfix">
        <ul class="columns no_width">
            <li class="column_left">
                <h1>For the people, by the people</h1>
                <p>Canbii's goal is to raise the profile of cannabis as medicine, by providing the most complete and accurate data possible. </p>
            </li>
            <li class="column_right">
                <div class="vertical_align">
                    <div class="vertical_align_cell">
                        <a title="Make an Appointment" href="strains/all" class="more blue large animated_element animation-slideLeft slideLeft" style="">View Strains</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>






    <?php
if(false){
?>
<h2 class="box_header page_margin_top_section slide">
Latest Strains
</h2>


<script src="<?php echo $this->webroot;?>js/raty.js"></script>
<script src="<?php echo $this->webroot;?>js/labs.js"></script>
<link href="<?php echo $this->webroot;?>css/raty.css" rel="stylesheet" type="text/css" />


<?
if($strain)
{
?>
<div class="columns columns_4 page_margin_top clearfix">

<?php
$j=0;
foreach($strain as $s)
{
$j++;
?>
<ul class="column">
<li class="item_content clearfix">



<div style="float:left;background-image: url('images/features_small/icon.png');width:57px;height:66px;margin-right:10px;">
<p style="vertical-align:middle;text-align:center;color:white;font-size:18px;margin-top:-5px">
<?php
$name_arr = explode(' ',$s['Strain']['name']);
$i=0;
foreach($name_arr as $na)
{
$i++;
if($i==1){
echo ucfirst($na[0]);
}
else echo strtolower($na[0]);
}
?>
</p>
</div>



 <div class="icon2">


 <p style="vertical-align:middle;text-align:center;color:white;font-size:18px;margin-top:-5px">
<?php
$name_arr = explode(' ',$s['Strain']['name']);
$i=0;
foreach($name_arr as $na)
{
$i++;
if($i==1){
echo ucfirst($na[0]);
}
else echo strtolower($na[0]);
}
?>
</p>


 </div>


<div class="hexagon">123</div>
<div class="hex">

123

</div>

















<div style="float:left;">
<h3 class="block-title">
<a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>">
<?php echo $s['Strain']['name'];?>
</a>
</h3>

<ul class="">
<li><?php echo $s['StrainType']['title'];?></li>

</ul>



</div>
<div style="clear:both;">
<p>
<?php echo substr($s['Strain']['description'],0,160).'...';?>
</p>

<ul class="post_footer_details">
<li>Added on</li>
<li>
<?php echo $s['Strain']['published_date'];?>
</li>
</ul>


</div>


</li>
</ul>

<?
if(false){
?>
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
<a target="_blank" href="http://themeforest.net/item/medicenter-responsive-medical-health-template/4000598?ref=QuanticaLabs" title="Lorem ipsum dolor sit amat velum">



<a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>">
<?php echo $s['Strain']['name'];?>
</a>

</a>
</h2>
<p>
<?php echo substr($s['Strain']['description'],0,160).'...';?>

</p>
<div class="rating<?php echo $j;?> " style=""></div>


<script>
$(function(){
$('.rating<?php echo $j;?>').raty({number:10,readOnly:true,score:<?php echo $s['Strain']['rating'];?>});
});
</script>

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
<?}?>
<?php
}
?>

<?php
}
}
?>
</div>


<script>
function highlighteff(thiss){
if(thiss.attr('class').replace('searchact','')==thiss.attr('class'))
{
    thiss.addClass('searchact');
    $('.effe').append('<input type="hidden" name="effects[]" value="'+thiss.attr('id').replace('eff_','')+'" class="'+thiss.attr('id')+'"  />')}else{thiss.removeClass('searchact')

        $('.'+thiss.attr('id')).remove();
    }
    $('.key').val('');
}
function highlightsym(thiss){
if(thiss.attr('class').replace('searchact','')==thiss.attr('class'))
{
    thiss.addClass('searchact');
    $('.symp').append('<input type="hidden" name="symptoms[]" value="'+thiss.attr('id').replace('sym_','')+'" class="'+thiss.attr('id')+'"  />')}else{thiss.removeClass('searchact')

        $('.'+thiss.attr('id')).remove();
    }
    $('.key').val('');
}
</script>