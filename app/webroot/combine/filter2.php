<SPAN debugtitle="combine/filter2.php">
    <?php
        errorlog("include combine/filter2.php");
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
            $j=rand(1000000,9999999999);
            foreach($strain as $s){
                $j++;
                $count++;
                ?>
                    <li class="item_content clearfix" style="border-bottom:1px solid #E8E8E8;">
                        <div class="text" style="width:80%;float:left;">
                            <a href="<?= $this->webroot?>strains/<?= $s['Strain']['slug'];?>/<?php if($u_cond){echo $u_cond;}?>">
                                <h2><?= $s['Strain']['id'] . ' ' . $s['Strain']['name'];?></h2>
                            </a>
                        </div>
                    </li>
                <?php
            }
            echo '</ul>';
        }
        if($count==0){
            echo "No results found. (2)";
            vardump($GLOBALS["lastsql"]);
        }
        errorlog("include success");
    ?>
    <div class="clear"></div>
</SPAN>
    