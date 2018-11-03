<?php
function pluralize($text, $quantity){
    if (substr(strtolower($text),-1)=="s"){$text = substr($text, 0, strlen($text)-1); }
    if ($quantity<>1){return $text . "s";}
    return $text;
}

$u_cond = '';
        if(isset($nationality))
        {
            $u_cond = '?nationality='.$nationality;

        }
        if(isset($country))
        {
            if(!$u_cond)
            $u_cond = '?country= '.$country;
            else
            $u_cond = $u_cond.'&country='.$country;

        }
        if(isset($gender))
        {
            if(!$u_cond)
            $u_cond = '?gender='.$gender;
            else
            $u_cond = $u_cond.'&gender='.$gender.'"';

        }
        if(isset($age_group_from))
        {

                if(!$u_cond)
                $u_cond = '?age_group_from='.$age_group_from;
                else
                $u_cond = $u_cond.'&age_group_from='.$age_group_from.'"';


        }
        if(isset($age_group_to))
        {

                if(!$u_cond)
                $u_cond = '?age_group_to='.$age_group_to;
                else
                $u_cond = $u_cond.'&age_group_to='.$age_group_to.'"';


        }
        if(isset($health))
        {

            if(!$u_cond)
            $u_cond = '?health = "'.$health.'"';
            else
            $u_cond = $u_cond.'&health='.$health;
        }

        if(isset($weight_from))
        {

                if(!$u_cond)
                $u_cond = '?weight_from='.$weight_from;
                else
                $u_cond = $u_cond.'&weight_from='.$weight_from.'"';


        }
        if(isset($weight_to))
        {

                if(!$u_cond)
                $u_cond = '?weight_to='.$weight_to;
                else
                $u_cond = $u_cond.'&weight_to='.$weight_to.'"';

        }

        if(isset($years_of_experience_from))
        {

                if(!$u_cond)
                $u_cond = '?years_of_experience_from='.$years_of_experience_from;
                else
                $u_cond = $u_cond.'&years_of_experience_from='.$years_of_experience_from.'"';

        }
        if(isset($years_of_experience_to))
        {

                if(!$u_cond)
                $u_cond = '?years_of_experience_to='.$years_of_experience_to;
                else
                $u_cond = $u_cond.'&years_of_experience_to='.$years_of_experience_to.'"';

        }
        if(isset($frequency))
        {

                if(!$u_cond)
                $u_cond = '?frequency='.$frequency;
                else
                $u_cond = $u_cond.'&frequency='.$frequency.'"';

        }
        if(isset($body_type))
        {

                if(!$u_cond)
                $u_cond = '?body_type='.$body_type;
                else
                $u_cond = $u_cond.'&body_type='.$body_type.'"';

        }


$count=0;
    if($strain){
        echo '<ul class="">';
        $j=rand(1000000,9999999999);
        foreach($strain as $s){
            $j++;
            $count++;
            ?>


<li class="item_content clearfix" style="border-bottom:1px solid #E8E8E8;">


<!--a class="thumb_image" href="#" style="margin:0px;width:13%; min-width:60px;">

<div style="text-align: center; float:left;background-image: url('<?php echo $this->webroot?>images/<?php echo $s['StrainType']['title'];?>.png');width:57px;height:66px;background-repeat: no-repeat;">
<p style="vertical-align:middle;text-align:center;color:white;font-size:18px; margin-top:15px">
<?php
$name_arr = explode(' ',$s['Strain']['name']);
$i=0;

foreach($name_arr as $na)
{
$i++;
if($i==1 && $na){
echo ucfirst($na[0]);
}
elseif($na) echo strtolower($na[0]);
}
?>
</p>
</div>

</a-->

<div  style="width:13%; min-width:60px;float:left;">
    <a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>/<?php if($u_cond)echo $u_cond;?>">
<?php
// unset($strain_hexagon);
$strain_hexagon = $s;
include('combine/hexagon.php');?>
		</div>

<div class="text" style="width:80%;float:left;">

<h2>

<?php echo $s['Strain']['name'];?>
</a>
</h2>


<p>
<?php echo substr($s['Strain']['description'],0,150).'...';?>
</p>


<ul class="post_footer_details">
<li class="">
<?php if(isset( $s['StrainType'])){echo  $s['StrainType']['title'];}?>
</li>
<li class="" style="">
<?php if($s['Strain']['review']){
    //if ($s['Strain']['review'] == 1) {$Reviews = " Review";} else {$Reviews = " Reviews";}
    echo $s['Strain']['review'] . pluralize(" Review", $s['Strain']['review']) ;
}else{
    echo '0 Reviews';
}
// [rating] => 3.27 [review] => 18 [viewed] => 33 [published_date] => 0000-00-00 [slug] => cadillac-purple [cbd] => 0 [cbn] => 0 [cbc] => 0 [thc] => 0 [thcv] => 0 )
    if($s['Strain']['viewed']){ echo ", " . $s['Strain']['viewed'] . pluralize(" View", $s['Strain']['viewed']);}
?>
</li>
</ul>

<ul class="post_footer_details" style="float:right;margin-top:-5px;">
<li>
<div class="rating<?php echo $j;?> " style=""></div>
<script>
$(function(){
$('.rating<?php echo $j;?>').raty({number:5,readOnly:true,score:<?php echo $s['Strain']['rating'];?>});
});
</script>
</li>
</ul>
</div>

</li>



<?php
}
echo '</ul>';
}
if($count==0){
    echo "No results found.";
    if (isset($_GET["key"])){
        if (strlen($_GET["key"])>0){ echo " for '" . $_GET["key"] . "'";}
    }
}
?>






    <div class="clear"></div>
    <div class="morelist" style="display: none;"></div>
    <?php if($strains && ($strains)>8){?>
    <div class="loadmore"><a href="javascript:void(0);">Load More</a></div>
    <?php }?>
    <script>
    $(function(){
        var j =0;
        $('.item_content').each(function(){
            j++;
        })
        if(j==<?php echo ($strains);?>)
            $('.loadmore').hide();
        var m=0
       $('.loadmore').each(function(){
        m++;
        if(m!=1)
        {
            $(this).remove();
        }
       });
    });
    </script>