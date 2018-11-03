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






<div class="text" style="width:80%;float:left;">
<a href="<?php echo $this->webroot?>strains/<?php echo $s['Strain']['slug'];?>/<?php if($u_cond)echo $u_cond;?>">
<h2>

<?php echo $s['Strain']['id'];?> <?php echo $s['Strain']['name'];?>
</a>
</h2>


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
    