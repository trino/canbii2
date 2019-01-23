<script src="<?= $this->webroot; ?>js/raty.js"></script>
<script src="<?= $this->webroot; ?>js/labs.js"></script>
<link href="<?= $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>
<link href="<?= $this->webroot; ?>css/layout.css" rel="stylesheet" type="text/css" title="progress bar"/>
<script src="<?= $this->webroot; ?>js/bootstrap.min.js"></script>
<script src="<?= $this->webroot; ?>js/html2canvas.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/jquery.plugin.html2canvas.js"></script>

<?php
    echo "<Strain id='" . $strain['Strain']['id'] . "' />";

    function progressbar($webroot, $value, $textL = "", $textR = "", $color = "success", $color2 = "", $striped = false, $active = false, $min = 0, $max = 100) {
        if (false) {
            /*
            echo '<div  class="pull-left" width: ';
            echo (round($value, 2) > 100) ? 100 : round($value, 2);
            echo '%;height:25px;position: absolute;left:0;"/>' . round($value / 20, 2);
            echo '/5</div>';
            */
        } else {
            if ($textL) {
                echo '<div class="pull-left" >&nbsp;' . $textL . '</div>';
            }
            echo '<div style="clear: both">';
            echo '<img src="' . $webroot . 'images/bar_chart/' . $color2 . '.png" style="width: ';
            echo (round($value, 2) > 100) ? 100 : round($value, 2);
            echo '%;height:20px;"/>';

            echo "</div>";
            return;
            echo '<div class="progress-bar progress-bar-';
            echo $color . '" role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="' . $min . '" aria-valuemax="' . $max . '" style="';
            echo 'width: ' . round($value / ($max - $min) * 100) . '%"><div  class="pull-left">' . $textR . '</div></div></div>';
        }

    }

    function perc($scale) {
        return '' . round($scale / 20, 2) . "/5";
    }

    $strain_hexagon = $strain;
    if (isset($s)) {
        echo '<a href="' . $this->webroot . 'strains/' . $s['Strain']['slug'] . '">';
        include('combine/hexagon.php');
        echo '</a>';
    }
?>

<div class="jumbotron" style="background: transparent">
<div class="row">
    <DIV CLASS="col-md-12">
        <h1><?= $strain['Strain']['name']; ?> - Report</h1>
        <?php
            switch ($strain['Strain']['type_id']) {
                case 1:
                    echo "Indica: Best suited for night time use.";
                    break;
                case 2:
                    echo "Sativa: Best suited for day time use.";
                    break;
                case 3:
                    echo "Hybrid Cannabis";
                    break;
            }
            ?><br>
       <?= strip_tags(html_entity_decode($strain['Strain']['description'])); ?>
    </DIV>
</div>
</div>

<div class="jumbotron bg-primary text-white">
<div class="row pb-2">

    <DIV CLASS="col-md-3">
        <h2 class="pt-3">Overall Rating</h2>
        <div class="rating"></div>
    </DIV>

    <DIV CLASS="col-md-4">
        <h2 class="pt-3"> Composition</h2>
        <DIV class="spanwordwrap">
            <?php
            $chemical = 0;
            function printchemical($chemical, $strain, $acronym, $wikipedia) {
                if ($strain['Strain'][strtolower($acronym)] != "0") {
                    $chemical++;
                    echo "<span class=' eff2' style='margin-right: 5px;'><a style='color: white' target='new' href='" . $wikipedia . "'>" . strtoupper($acronym) . ":</a> ";
                    echo $strain['Strain'][strtolower($acronym)] . "%</span> ";
                };
                return $chemical;
            }

            $chemical = printchemical($chemical, $strain, "thc", "http://en.wikipedia.org/wiki/Tetrahydrocannabinol");
            $chemical = printchemical($chemical, $strain, "cbd", "http://en.wikipedia.org/wiki/Cannabidiol");
            $chemical = printchemical($chemical, $strain, "cbn", "http://en.wikipedia.org/wiki/Cannabinol");
            $chemical = printchemical($chemical, $strain, "cbc", "http://en.wikipedia.org/wiki/Cannabichromene");
            $chemical = printchemical($chemical, $strain, "thcv", "http://en.wikipedia.org/wiki/Tetrahydrocannabivarin");
            if ($chemical == 0) {
                echo "<span class=' eff2' style=''>Not enough data, check back soon</span>";
            }
            ?>
        </DIV>
    </DIV>

    <DIV CLASS="col-md-5">
        <h2 class="pt-3">Flavors</h2>
        <?php
        if ($flavor) {
            foreach ($flavor as $f) {
                //$name = $this->requestAction('/strains/getFlavor/' . $f['FlavorRating']['flavor_id']); //class used to have this in it
                $flavor = first("SELECT * FROM flavors WHERE id=" . $f['FlavorRating']['flavor_id']);
                $name = $flavor["title"];
                ?>

                <img width="55" src="<?php
                $image = "images/icons/" . trim(strtolower($name)) . ".png";
                echo $this->webroot;
                if (file_exists(getcwd() . "/" . $image)) {
                    echo $image;
                } else {
                    echo "images/icons/unknown.png";
                    echo '" TITLE="File not found: ' . getcwd() . "/" . $image;
                }
                ?>">
                <?= $name; ?> &nbsp;&nbsp;&nbsp;
                <?php
            }
        } else {
            ?>
                <a class="text-white"  href="#">
                    No flavors yet. 
                    <span style="font-size: 26px;padding-left:10px;" class="fa fa-star-half-full"></span>
                </a>
            <?php
        }
        ?>
    </DIV>
</div>
</div>
<?php
    function fixtext($text){
        $text = html_entity_decode(html_entity_decode($text));
        $text = str_replace('&nbsp;<a data-target=".product__description" class="js-scroll-to text-cta">Learn More</a>', "", $text);
        return trim($text);
    }

    $OCSDATA = first("SELECT * FROM ocs WHERE strain_id=" . $strain['Strain']['id']);
    echo '<DIV class="jumbotron" ID="csodata"> <h3>Ontario Cannabis Store</h3>';
    if($OCSDATA){
        /*$dir = getcwd() . "/ocs/";
        $filename = $dir . $strain['Strain']['slug'] . ".json";
        $data = false;
        if(file_exists($filename )) {
            $data = json_decode(file_get_contents($filename), true);
        }*/
        $shorttext = fixtext($OCSDATA["shorttext"]);
        echo $shorttext;
        echo '<BR>' . html_entity_decode($OCSDATA["content"]);
        echo '<BR>Prices: ';

        $slugs = [];
        if($OCSDATA["prices"]) {
            $prices = json_decode($OCSDATA["prices"], true);
            //vardump($OCSDATA["prices"]); vardump($prices);
            foreach($prices as $data){
                //"price", "slug", "title", "category"
                if(!in_array($data["slug"], $slugs)) {
                    $slugs[ $data["category"] ] = $data["slug"];
                }
                echo money_format(LC_MONETARY, $data["price"] * 0.01) . " (" . $data["title"] . ") ";
            }
        } else {
            $slugs["Purchase Now"] = $strain['Strain']['slug'];
            echo money_format(LC_MONETARY, $OCSDATA["price"] * 0.01);
        }

       // echo '<BR>Terpenes: ' . $OCSDATA["terpenes"];
        echo '<BR>Available: ' . iif($OCSDATA["available"] == 1, "Yes", "No");
        echo '<div class="clearfix mt-2"></div>';
        foreach($slugs as $key => $slug) {
            $URL = "https://ocs.ca/products/" . $slug;
            if(textcontains($key, "-")){
                $key = explode("-", $key);
                foreach($key as $INDEX => $VALUE){
                    $key[$INDEX] = ucfirst($VALUE);
                }
                $key = "Purchase " . implode(" ", $key) . ' Now';
            }
            echo '<a href="' . $URL . '" class="btn btn-success float-left mr-2" TARGET="_new">' . $key . '</a>';
        }
        echo '<div class="clearfix"></div>';
    } else {
        echo 'MISSING DATA: ' .  $strain['Strain']['id'];
    }
    echo '</DIV>';
?>


    <div class="jumbotron">
        <h3>Symptoms</h3>
        <p>How does this strain help with my medical condition?</p>

        <?php
        if (!isset($p_filter)) {
            $p_filter = false;
        }
        if (!$p_filter) {
            foreach ($strain['OverallSymptomRating'] as $oer) {
                $arrs[] = $oer['rate'] . '_' . $oer['symptom_id'];
            }
        } else {
            //$symptom_rate = $this->requestAction('/strains/getSymptomRate/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
            $symptom_rate = Query("SELECT * FROM symptom_ratings WHERE strain_id=" . $strain['Strain']['id']);
            $cnt = 0;
            $eff_id = 0;
            $total_rate = 0;
            foreach ($symptom_rate as $er) {
                $er['SymptomRating'] = $er;
                $cnt++;
                if ($eff_id != $er['SymptomRating']['symptom_id']) {
                    if ($cnt != 1) {
                        $tots = $total_rate;
                        $total_rate = $er['SymptomRating']['rate'];
                        $avg_rate = $tots / ($cnt - 1);
                        $cnt = 0;
                        $arrs[] = $avg_rate . '_' . $eff_id;
                        $total_rate = 0;
                    } else {
                        $total_rate = $er['SymptomRating']['rate'];
                    }
                } else {
                    $total_rate = $total_rate + $er['SymptomRating']['rate'];
                }
                $eff_id = $er['SymptomRating']['symptom_id'];
            }
        }
        if (isset($arrs)) {
            rsort($arrs);
        } else {
            $arrs = array();
        }
        $i = 0;
        if ($arrs) {
            $ids = [];
            foreach ($arrs as $id => $e) {
                $arrs[$id] =  explode('_', $e);
                $ids[] = $arrs[$id][1];
            }
            $names = Query("SELECT * FROM symptoms WHERE id IN(" . implode(",", $ids ) . ")");
            foreach ($arrs as $ars) {
                $i++;
                if ($i == 16) {
                    break;
                }
                $rate = $ars[0];
                $length = 20 * $rate;
                //$name =  $this->requestAction('/strains/getSymptom/' . $ars[1]);
                $name = getiterator($names, "id", $ars[1])["title"];
                ?>
                <div class="pull-left"><?= $name ?></div>
                <?php progressbar($this->webroot, $length, perc($length), "", "info", "light-blue");
            }
        } else {
            ?>
            <!--a href="<?= $this->webroot; ?>review/add/<?= $strain['Strain']['slug']; ?>">No ratings yet. </a-->
            <a href="#">No ratings yet. </a>
            <?php
        }
        ?>

    </div>
    <div class="jumbotron">
        <h3>General Ratings</h3>
        <p> What are the general ratings?</p>
        <?php
        $scale = 0;
        $strength = 0;
        $duration = 0;
        $count = "";
        if (!$p_filter) {
            $count = count($strain['Review']);
            if ($count) {
                foreach ($strain['Review'] as $r) {
                    $scale = $scale + $r['eff_scale'];
                    $strength = $strength + $r['eff_strength'];
                    $duration = $duration + $r['eff_duration'];
                }
            }
        } else {
            $effect_review = $this->requestAction('/strains/getEffectReview/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
            $count = count($strain['Review']);
            if ($count) {
                foreach ($effect_review as $r) {
                    $scale = $scale + $r['Review']['eff_scale'];
                    $strength = $strength + $r['Review']['eff_strength'];
                    $duration = $duration + $r['Review']['eff_duration'];
                }
            }
        }
        if ($count) {
            $Factor = 10;//20;
            $scale = ($scale / $count) * $Factor;
            $strength = ($strength / $count) * $Factor;
            $duration = ($duration / $count) * $Factor;
        }
        if ($scale) {
            ?>
            <div class="pull-left"> Sedative</div>
            <?php progressbar($this->webroot, $scale, perc($scale), "", "warning", "light-purple");
        }
        if ($strength) {
            ?>
            <div class="pull-left">
                Strength
            </div>
            <?php progressbar($this->webroot, $strength, perc($strength), "", "warning", "light-purple");
        }
        if ($duration) {
            ?>
            <div class="pull-left">
                Duration
            </div>
            <?php progressbar($this->webroot, $duration, perc($duration), "", "warning", "light-purple");
        }
        if (!$duration && !$strength && !$scale) {
            ?>
            <a href="#">No ratings yet. </a>
            <?php
        }
        ?>

    </div>
    <div class="jumbotron">
        <h3>Effects</h3>
        <p> What are the positive effects?</p>

        <?php
        $p_filter = 0;
        if (isset($arr_filter)) {
            foreach ($arr_filter as $filterwith) {
                if (isset($_GET[$filterwith])) {
                    $p_filter = 1;
                }
            }
        }

        if (!$p_filter) {
            $effectids = collapsearray($strain['OverallEffectRating'], "effect_id");
            if($effectids) {
                $effects = Query("SELECT * FROM effects WHERE id IN (" . implode(",", $effectids) . ")", true);
                foreach ($strain['OverallEffectRating'] as $oer) {
                    $effect = getiterator($effects, "id", $oer['effect_id']);
                    //if ($this->requestAction('/strains/getPosEff/' . $oer['effect_id'])) {
                    if($effect["negative"]){
                        $arr[] = $oer['rate'] . '_' . $oer['effect_id'];
                    } else {
                        $arr_neg[] = $oer['rate'] . '_' . $oer['effect_id'];
                    }
                }
            }
        } else {
            $effect_rate = $this->requestAction('/strains/getEffectRate/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
            $cnt = 0;
            $eff_id = 0;
            $total_rate = 0;
            foreach ($effect_rate as $er) {
                $cnt++;
                if ($eff_id != $er['Effect_rating']['effect_id']) {
                    if ($cnt != 1) {
                        $tots = $total_rate;
                        $total_rate = $er['Effect_rating']['rate'];
                        $avg_rate = $tots / ($cnt - 1);
                        $cnt = 0;
                        if ($this->requestAction('/strains/getPosEff/' . $er['Effect_rating']['effect_id'])) {
                            $arr[] = $avg_rate . '_' . $eff_id;
                        } else {
                            $arr_neg[] = $avg_rate . '_' . $eff_id;
                        }
                        $total_rate = 0;
                    } else {
                        $total_rate = $er['Effect_rating']['rate'];
                    }
                } else {
                    $total_rate = $total_rate + $er['Effect_rating']['rate'];
                }
                $eff_id = $er['Effect_rating']['effect_id'];

            }
        }

        if (isset($arr)) {
            rsort($arr);
        } else {
            $arr = array();
        }
        $i = 0;
        if ($arr) {
            foreach ($arr as $e) {
                $ar = explode('_', $e);
                $i++;
                if ($i == 6) {
                    break;
                }
                $rate = $ar[0];
                $length = 20 * $rate;
                $effect = getiterator($effects, "id", $ar[1]);
                $name = $effect["title"];//$this->requestAction('/strains/getEffect/' . $ar[1])
                ?>
                <div class="pull-left"><?= $name; ?></div>
                <?php
                    progressbar($this->webroot, $length, perc($length), "", "success", "light-green");
            }
        } else {
            ?>
            <a href="#"> No ratings yet.  </a>
            <?php
        }
        ?>
    </div>
    <div class="jumbotron">
        <h3>Negative Effects</h3>
        <p>What are the negative effects?</p>
        <?php
        if (isset($arr_neg)) {
            rsort($arr_neg);
        } else {
            $arr_neg = array();
        }
        $i = 0;
        if ($arr_neg) {
            foreach ($arr_neg as $e) {
                $ar = explode('_', $e);
                $i++;
                if ($i == 6) {
                    break;
                }
                $rate = $ar[0];
                $length = 20 * $rate;
                $effect = getiterator($effects, "id", $ar[1]);
                $name = $effect["title"];//$this->requestAction('/strains/getEffect/' . $ar[1])
                ?>
                <div class="pull-left"><?= $name; ?></div>
                <?php
                    progressbar($this->webroot, $length, perc($length), "", "danger", "light-red");
            }
        } else {
            ?>
            <i>
                <a href="#">
                    No ratings yet. 
                    <i></i>
                </a>
            </i>
            <?php
        }
        ?>
    </div>
    <div class="jumbotron">
        <h3> Most Helpful User Review</h3>

        <?php include_once('combine/strain_reviews.php'); ?>

        <script type="text/javascript">
            $(document).ready(function () {
                $(".fancybox").fancybox();
            });
        </script>

        <a href="<?= $this->webroot; ?>strains/review/<?= $strain['Strain']['slug']; ?>">
            See All Reviews for <?= $strain['Strain']['name']; ?> &raquo;
        </a>
    </div>
    <div class="jumbotron">
        <h3><?= $strain['Strain']['name']; ?> Images</h3>
        <?php include('combine/images.php'); ?>
        <div class="clearfix"></div>
    </div>


<script>
    function takeScreenShot() {
        html2canvas(window.parent.document.body, {
            onrendered: function (canvas) {
                var cand = document.getElementsByTagName('canvas');
                if (cand[0] === undefined || cand[0] === null) {

                } else {
                    document.body.removeChild(cand[0]);
                }
                document.body.appendChild(canvas);
            }
        });
    }

    function postImage() {
        var cand = document.getElementsByTagName('canvas');
        var canvasData = cand[0].toDataURL("image/png");
        var ajax = new XMLHttpRequest();
        ajax.open("POST", '/pr/custom/testSave.php', false);
        ajax.setRequestHeader('Content-Type', 'application/upload');
        ajax.send(canvasData);
        alert('done');
    }

    function save() {
        Rectangle
        screenRect = new Rectangle(Toolkit.getDefaultToolkit().getScreenSize());
        BufferedImage
        capture = new Robot().createScreenCapture(screenRect);
        ImageIO.write(capture, "bmp", new File(args[0]));
    }
</script>

<script>
    $(function () {
        var makeVote = function (data) {
            symp = data.id;

            up = data.upvoted;
            down = data.downvoted;
            console.log(up);

            setZero = true;

            $.each(data.classList, function (i, e) {
                if (e.className.indexOf('downvote-on') != -1 || e.className.indexOf('upvote-on') != -1) {
                    setZero = false;

                    if (e.className.indexOf('downvote-on') != -1) {
                        down = true;
                        up = 0;
                    }
                    else if (e.className.indexOf('upvote-on') != -1) {
                        up = true;
                        down = 0;
                    }
                }
            });

            if (setZero) {
                up = 0;
                down = 0;
            }
            console.log(up);
//
//if (access == true) {
            $.ajax({
                type: "POST",
                url: "<?= Router::url(array('controller' => 'symptomvote', 'action' => 'sendVote'));?>/<?= $strain['Strain']['id'] ?>/" + symp,
                data: {up: up, down: down},
                success: function (response) {
                    console.log(response);
                }
            });
//}
        };

        $('div.upvote').each(function (i, e) {
            $(this).upvote({ele: $(this), classList: $(this).find("a"), id: $(this).find(".vote_symp").val(), callback: makeVote});
        });

        <?php
            if (!$p_filter) {
                $rate = $strain['Strain']['rating'];
            } else {
                $effect_reviews = $this->requestAction('/strains/getEffectReview/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
                $count_rate = 0;
                $rate = 0;
                foreach ($effect_reviews as $oar) {
                    if ($oar['Review']['rate'] == 0) {
                        continue;
                    } else {
                        $count_rate++;
                        $rate = $rate + $oar['Review']['rate'];
                    }
                }
                if ($count_rate == 0) {
                    $rate = 0;
                } else {
                    $rate = $rate / $count_rate;
                }
                $rate = number_format($rate, 2);
            }
        ?>

        $('.rating').raty({number: 5, readOnly: true, score:<?= $rate;?>});

        <?php if($helpful){?>
            $('.frate').raty({readOnly: true, score:<?= $helpful['Review']['rate'];?>});
            $('.srate').raty({readOnly: true, score:<?= $recent['Review']['rate'];?>});
        <?php }?>
        $('.emotion').text('<?= ($strain['Strain']['rating']) . '/5';?> ');
        var check = 0;
        $('.yes').click(function () {
            if (check == 0) {
                check++;
                var id = $(this).attr('id');
                var arr = id.split('_');
                var r_id = arr[1];
                $.ajax({
                    url: '<?= $this->webroot;?>strains/helpful/' + r_id + '/yes',
                });
//$('#'+arr[0]+'_'+r_id).removeClass('yes');
                $('#' + arr[0] + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;');
//$('#'+arr[0]+'_'+r_id).attr('onclick','return false;');
                var o = parseFloat(arr[0]) + 1;
//$('#'+o+'_'+r_id).removeClass('no');
                $('#' + o + '_' + r_id).attr('style', 'background:#FFF;cursor: default;display:inline-block;padding:4px 7px;');
                $('#' + o + '_' + r_id + ' strong').attr('style', 'color:#eee');
                $//('#'+o+'_'+r_id).attr('onclick','return false;');
                $(this).attr('style', $(this).attr('style').replace('background:#FFF;', 'background:#e5e5e5;display:inline-block;padding:4px 7px;'));
            }
        });
        $('.no').click(function () {
            if (check == 0) {
                check++;
                var id = $(this).attr('id');

                var arr2 = id.split('_');
                var num = parseFloat(arr2[0]) - 1;
                var r_id = arr2[1];
                $.ajax({
                    url: webroot + 'strains/helpful/' + r_id + '/no',
                });
                $('#' + arr2[0] + '_' + r_id).removeClass('yes');
                var o = parseFloat(arr2[0]) + 1;
//$('#'+o+'_'+r_id).removeClass('no');
                $('#' + num + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;display:inline-block;padding:4px 7px;')
                $('#' + num + '_' + r_id + ' strong').attr('style', 'color:#CCC;')
//$('#'+arr2[0]+'_'+r_id).attr('onclick','return false;');
                $('#' + o + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;');
//$('#'+o+'_'+r_id).attr('onclick','return false;');
                $(this).attr('style', 'padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px;background:#e5e5e5;cursor:default;');
            }
        });
    });
</script>

