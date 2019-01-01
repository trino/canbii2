<SPAN debugtitle="combine/filter.php">
    <?php
        errorlog("include combine/filter.php");
        function pluralize($text, $quantity){
            if (substr(strtolower($text),-1)=="s"){$text = substr($text, 0, strlen($text)-1); }
            if ($quantity<>1){return $text . "s";}
            return $text;
        }
        function queryappend($Query, $texttoappend){
            if($Query){
                return $Query . "&" . $texttoappend;
            }
            return "?" . $texttoappend;
        }

        $u_cond = '';
        if(isset($nationality)) {
            $u_cond = '?nationality='.$nationality;
        }

        if(isset($country)) {
            $u_cond = queryappend($u_cond, 'country= ' . $country);
        }

        if(isset($gender)) {
            $u_cond = queryappend($u_cond, 'gender= ' . $gender);
        }

        if(isset($age_group_from)) {
            $u_cond = queryappend($u_cond, 'age_group_from='.$age_group_from);
        }

        if(isset($age_group_to)) {
            $u_cond = queryappend($u_cond, 'age_group_to='.$age_group_to);
        }

        if(isset($health)) {
            $u_cond = queryappend($u_cond, 'health = "'.$health.'"');
        }

        if(isset($weight_from)) {
            $u_cond = queryappend($u_cond, 'weight_from='.$weight_from);
        }

        if(isset($weight_to)) {
            $u_cond = queryappend($u_cond, 'weight_to='.$weight_to);
        }

        if(isset($years_of_experience_from)) {
            $u_cond = queryappend($u_cond, 'years_of_experience_from='.$years_of_experience_from);
        }

        if(isset($years_of_experience_to)) {
            $u_cond = queryappend($u_cond, 'years_of_experience_to='.$years_of_experience_to);
        }

        if(isset($frequency)) {
            $u_cond = queryappend($u_cond, 'frequency='.$frequency);
        }

        if(isset($body_type)) {
            $u_cond = queryappend($u_cond, 'body_type='.$body_type);
        }

        $count=0;
        if($strain){
            echo '<ul>';
            $j=rand(1000000,2147483647);
            foreach($strain as $s){
                $j++;
                $count++;
                ?>
                <li class="item_content clearfix" style="border-bottom:0px solid #E8E8E8;">
                    <!--a class="thumb_image" href="#" style="margin:0px;width:13%; min-width:60px;">
                        <div style="text-align: center; float:left;background-image: url('<?= $this->webroot?>images/<?= $s['StrainType']['title'];?>.png');width:57px;height:66px;background-repeat: no-repeat;">
                            <p style="vertical-align:middle;text-align:center;color:white;font-size:18px; margin-top:15px">
                                <?php
                                    $name_arr = explode(' ',$s['Strain']['name']);
                                    $i=0;
                                    foreach($name_arr as $na){
                                        $i++;
                                        if($i==1 && $na){
                                            echo ucfirst($na[0]);
                                        } elseif($na){
                                            echo strtolower($na[0]);
                                        }
                                    }
                                ?>
                            </p>
                        </div>
                    </a-->

                    <div  style="width:13%; min-width:60px;float:left;">
                        <a href="<?= $this->webroot?>strains/<?= $s['Strain']['slug'];?>/<?php if($u_cond){echo $u_cond;} ?>">
                        <?php
                            // unset($strain_hexagon);
                            $strain_hexagon = $s;
                            include('combine/hexagon.php');
                        ?>
                    </div>

                    <div class="text" style="width:80%;float:left;">
                        <h2><?= $s['Strain']['name'];?></a></h2>
                        <p><?= substr($s['Strain']['description'],0,150).'...';?></p>

                        <ul class="post_footer_details">
                            <li><?php if(isset( $s['StrainType'])){echo  $s['StrainType']['title'];}?></li>
                            <li><?php if($s['Strain']['review']){
                                //if ($s['Strain']['review'] == 1) {$Reviews = " Review";} else {$Reviews = " Reviews";}
                                echo $s['Strain']['review'] . pluralize(" Review", $s['Strain']['review']) ;
                            }else{
                                echo '0 Reviews';
                            }
                            // [rating] => 3.27 [review] => 18 [viewed] => 33 [published_date] => 0000-00-00 [slug] => cadillac-purple [cbd] => 0 [cbn] => 0 [cbc] => 0 [thc] => 0 [thcv] => 0 )
                                if($s['Strain']['viewed']){ echo ", " . $s['Strain']['viewed'] . pluralize(" View", $s['Strain']['viewed']);}
                            ?></li>
                        </ul>

                        <ul class="post_footer_details" style="float:right;margin-top:-5px;">
                        <li>
                            <div class="rating<?php echo $j;?> "></div>
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
    <?php if($strains && ($strains)>8){echo '<div class="loadmore"><a href="javascript:void(0);">Load More</a></div>';}?>
    <script>
        $(function(){
            var j =0;
            $('.item_content').each(function(){
                j++;
            });
            if(j==<?php echo ($strains);?>) {
                $('.loadmore').hide();
            }
            var m=0;
            $('.loadmore').each(function(){
                m++;
                if(m!=1){
                    $(this).remove();
                }
           });
        });
    </script>
</SPAN>
<?php errorlog("include combine/filter.php success!"); ?>