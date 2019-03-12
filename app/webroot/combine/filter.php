<SPAN debugtitle="combine/filter.php">
    <?php
        errorlog("include combine/filter.php");
        function pluralize($text, $quantity) {
            if (substr(strtolower($text), -1) == "s") {
                $text = substr($text, 0, strlen($text) - 1);
            }
            if ($quantity <> 1) {
                return $text . "s";
            }
            return $text;
        }

        function queryappend($Query, $texttoappend) {
            if ($Query) {
                return $Query . "&" . $texttoappend;
            }
            return "?" . $texttoappend;
        }

        function cleanslug($slug = "lemon-skunk-capsules-2-5mg") {
            if (!is_array($slug)) {$slug = explode("-", strtolower($slug));}
            foreach($slug as $ID => $VALUE){
                $slug[$ID] = ucfirst($VALUE);
            }
            return implode(" ", $slug);
        }

        $u_cond = '';
        if (isset($nationality)) {
            $u_cond = '?nationality=' . $nationality;
        }

        if (isset($country)) {
            $u_cond = queryappend($u_cond, 'country= ' . $country);
        }

        if (isset($gender)) {
            $u_cond = queryappend($u_cond, 'gender= ' . $gender);
        }

        if (isset($age_group_from)) {
            $u_cond = queryappend($u_cond, 'age_group_from=' . $age_group_from);
        }

        if (isset($age_group_to)) {
            $u_cond = queryappend($u_cond, 'age_group_to=' . $age_group_to);
        }

        if (isset($health)) {
            $u_cond = queryappend($u_cond, 'health = "' . $health . '"');
        }

        if (isset($weight_from)) {
            $u_cond = queryappend($u_cond, 'weight_from=' . $weight_from);
        }

        if (isset($weight_to)) {
            $u_cond = queryappend($u_cond, 'weight_to=' . $weight_to);
        }

        if (isset($years_of_experience_from)) {
            $u_cond = queryappend($u_cond, 'years_of_experience_from=' . $years_of_experience_from);
        }

        if (isset($years_of_experience_to)) {
            $u_cond = queryappend($u_cond, 'years_of_experience_to=' . $years_of_experience_to);
        }

        if (isset($frequency)) {
            $u_cond = queryappend($u_cond, 'frequency=' . $frequency);
        }

        if (isset($body_type)) {
            $u_cond = queryappend($u_cond, 'body_type=' . $body_type);
        }

        //$u_cond = queryappend($u_cond, 'hasocs=1');

        $count = 0;

        if($offset == 0) {
            echo $strains . " result" . iif($strains != 1, "s") . " found";
        }

        $activitylist = query("SELECT * FROM activities", true);

        if ($strain) {
            $j = rand(1000000, 2147483647);
            foreach ($strain as $s) {
                $j++;
                $count++;
                $OCSdata = query("SELECT * FROM ocs WHERE strain_id = " . $s['Strain']["id"], true);
                echo '<DIV CLASS="jumbotron"><a href="' . $this->webroot . 'strains/' . $s['Strain']['slug'] . '/';
                if ($u_cond) {
                    echo $u_cond;
                }
                echo '">';
                $strain_hexagon = $s;
                include('combine/hexagon.php');
                echo '<h2>' . $s['Strain']['name'] . '</a></h2>';

                ?>
                    <div class="rating<?= $j; ?>"></div>
                    <script>
                        $(function () {
                            $('.rating<?= $j;?>').raty({number: 5, readOnly: true, score:<?= $s['Strain']['rating'];?>});
                        });
                    </script>
                <?php


                echo '<DIV style="padding-top:10px;">';

                echo substr($s['Strain']['description'], 0, 130) . '...';

                echo "<div style='clear;both;'></div>Available in ";

                $first = true;

                foreach($OCSdata as $OCS){
                    if($OCS["prices"]) {
                        $product = json_decode($OCS["prices"], true)[0];
                        if($first) {
                         //   echo "Producers: ";
                        } else {
                            echo ", ";
                        }
                      //  echo '<A CLASS="product" HREF="https://ocs.ca/products/' . $product["slug"] . '"><SPAN CLASS="vendor">' . $product["vendor"] . '</SPAN>';
                        if($product["category"] != "hardcoded") {
                            echo ' ' . cleanslug($product["category"]) . '';
                        }
                        echo '<SPAN CLASS=""> by ' . $product["vendor"] . '</SPAN>';
                        // echo '</A>';
                        $first = false;
                    }
                }

                $activities = [];
                foreach($s["Review"] as $review){
                    $activity = explode(",", $review["activities"]);
                    foreach($activity as $act){
                        $activities[$act] = getiterator($activitylist, "id", $act)["title"];
                    }
                }
                $activities = array_filter($activities);
                asort($activities);

                echo '<div style="clear;both;"></div>';

                if (isset($s['StrainType'])) {
                    echo "" .  $s['StrainType']['title'] . '';
                }

                if ($s['Strain']['review']) {
                    if ($s['Strain']['review'] == 1) {$Reviews = " Review";} else {$Reviews = " Reviews";}
                    echo ", " . $s['Strain']['review'] . pluralize(" Review", $s['Strain']['review']);
                } else {
                    echo ', 0 Reviews';
                }

                if ($s['Strain']['viewed']) {
                    echo ", " . $s['Strain']['viewed'] . pluralize(" View", $s['Strain']['viewed']);
                }

                if($activities) {
                    echo '<BR>';
                    foreach ($activities as $activity) {
                        echo '<a class="btn btn-primary mr-1 mb-1"> <span>#' . $activity . '</span></a>';
                    }
                }

                echo '</DIV></DIV>';
            }
        }

        if ($count == 0) {
            echo "No results found.";
        }

        if(isset($strains)) {
            echo '<div class="morelist"></div>';
            $remaining = $strains - $offset - $limit;
            //echo "Strains: " . $strains . " Limit: "  . $limit . " Offset: " . $offset . " Remaining: " . $remaining;
            if ($strains && ($strains) > $GLOBALS["settings"]["limit"]) {
                echo '<div class="loadmore mb-5"><a class="btn btn-primary" href="javascript:void(0);">Show more</a></div>';
            }
        } else {
            $strains = 0;
        }
    ?>
    <script>
        var strains = <?= $strains; ?>;
        var offset = <?= $offset; ?>;
        var limit = <?= $limit; ?>;
        var remaining = <?= $remaining; ?>;

        $(function () {
            var j = 0;
            $('.item_content').each(function () {
                j++;
            });
            if (j ==<?php echo($strains);?>) {
                $('.loadmore').hide();
            }
            var m = 0;
            $('.loadmore').each(function () {
                m++;
                if (m != 1) {
                    $(this).remove();
                }
            });
        });
        <?php
            if($remaining < 1){
                echo "$('.loadmore').hide();";
            }
        ?>
    </script>
</SPAN>
<?php errorlog("include combine/filter.php success!"); ?>