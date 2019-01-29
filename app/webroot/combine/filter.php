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
    if ($strain) {
        $j = rand(1000000, 2147483647);
        foreach ($strain as $s) {
            $j++;
            $count++;
            ?>

            <a href="<?= $this->webroot ?>strains/<?= $s['Strain']['slug']; ?>/<?php if ($u_cond) {
                echo $u_cond;
            } ?>">

            <?php
                $strain_hexagon = $s;
                include('combine/hexagon.php');
            ?>

            <h2><?= $s['Strain']['name']; ?></a></h2>

            <?= substr($s['Strain']['description'], 0, 150) . '...'; ?>

            <?php if (isset($s['StrainType'])) {
                echo $s['StrainType']['title'];
            }

            if ($s['Strain']['review']) {
                //if ($s['Strain']['review'] == 1) {$Reviews = " Review";} else {$Reviews = " Reviews";}
                echo $s['Strain']['review'] . pluralize(" Review", $s['Strain']['review']);
            } else {
                echo '0 Reviews';
            }

            if ($s['Strain']['viewed']) {
                echo ", " . $s['Strain']['viewed'] . pluralize(" View", $s['Strain']['viewed']);
            }
        ?>
            <div style="float: right" class="rating<?= $j; ?> "></div>
            <script>
                $(function () {
                    $('.rating<?= $j;?>').raty({number: 5, readOnly: true, score:<?= $s['Strain']['rating'];?>});
                });
            </script>
            <div style="clear: both;padding: 11px;"></div>
            <?php
        }
    }
    if ($count == 0) {
        echo "No results found. (1)";

        /*
        App::import('Model', 'Strain');
        $this->Strain = new Strain();
        $log = $this->Strain->getLastQuery();
        vardump($log);
        */

        vardump($GLOBALS["lastsql"]);

    }
    ?>
    <div class="morelist"></div>
    <?php if ($strains && ($strains) > 8) {
        echo '<div class="loadmore mb-5"><a class="btn btn-primary" href="javascript:void(0);">Show more</a></div>';
    } ?>
    <script>
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
    </script>
</SPAN>
<?php errorlog("include combine/filter.php success!"); ?>