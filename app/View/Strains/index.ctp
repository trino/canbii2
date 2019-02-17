<script src="<?= $this->webroot; ?>js/raty.js"></script>
<script src="<?= $this->webroot; ?>js/labs.js"></script>
<link href="<?= $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>
<link href="<?= $this->webroot; ?>css/layout.css" rel="stylesheet" type="text/css" title="progress bar"/>
<script src="<?= $this->webroot; ?>js/bootstrap.min.js"></script>
<script src="<?= $this->webroot; ?>js/html2canvas.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/jquery.plugin.html2canvas.js"></script>

<?php
$DATA = query("SELECT * FROM ocs WHERE strain_id=" . $strain['Strain']['id'], true);

echo "<Strain id='" . $strain['Strain']['id'] . "' />";

function progressbar($webroot, $value, $textL = "", $textR = "", $color = "success", $color2 = "", $striped = false, $active = false, $min = 0, $max = 100)
{
    if ($textL) {
        echo '<div class="pull-left" >&nbsp;' . $textL . '</div>';
    }
    echo '<div class="progress" style="clear: both">';
    echo '<img src="' . $webroot . 'images/bar_chart/' . $color2 . '.png" style="width: ';
    echo (round($value, 2) > 100) ? 100 : round($value, 2);
    echo '%;height:20px;"/>';
    echo "</div>";
    return;
    echo '<div class="progress-bar progress-bar-';
    echo $color . '" role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="' . $min . '" aria-valuemax="' . $max . '" style="';
    echo 'width: ' . round($value / ($max - $min) * 100) . '%"><div  class="pull-left">' . $textR . '</div></div></div>';
}

function perc($scale)
{
    return '' . round($scale / 20, 2) . "/5";
}

$strain_hexagon = $strain;
if (isset($s)) {
    echo '<a href="' . $this->webroot . 'strains/' . $s['Strain']['slug'] . '">';
    include('combine/hexagon.php');
    echo '</a>';
}
?>
<!--pre> <span style="color:green">
<?php print_r($strain['Strain']); ?></span>
</pre-->

<div class="jumbotron" style="background: transparent;padding-bottom:0 !important;padding-top:0 !important;">
    <div class="row">
        <DIV CLASS="col-md-12">
            <h1 class="text-center" style="font-size: 2.5rem !important;"><?= $strain['Strain']['name']; ?> Canbii Report</h1>
           <p class="pt-0 pb-3 text-center" ><?php
            switch ($strain['Strain']['type_id']) {
                case 1:
                    echo "Indica strain - best suited for night time use";
                    break;
                case 2:
                    echo "Sativa strain - best suited for day time use";
                    break;
                case 3:
                    echo "Hybrid strain - balanced high";
                    break;
            }
            ?></p>
            <?= strip_tags(html_entity_decode($strain['Strain']['description'])); ?>
        </DIV>
    </div>
</div>

<div class="jumbotron bg-primary text-white">
    <div class="row pb-2">

        <DIV CLASS="col-md-3">
            <h2 class="pt-2">Canbii Rating</h2>
            <div class="rating"></div>
        </DIV>

        <DIV CLASS="col-md-4">
            <h2 class="pt-2"> Composition</h2>
            <DIV class="spanwordwrap">
                <?php
                $chemical = 0;
                function printchemical($chemical, $strain, $DATA, $acronym, $wikipedia)
                {
                    $acronym = strtolower($acronym);
                    if ($strain['Strain'][$acronym] == "0") {
                        foreach ($DATA as $CELL) {
                            foreach (["ocs_", "thc_"] as $site) {
                                if (isset($CELL[$site . $acronym]) && $CELL[$site . $acronym] && $CELL[$site . $acronym] != "0" && $strain['Strain'][$acronym] == "0") {
                                    $strain['Strain'][$acronym] = $CELL[$site . $acronym];
                                }
                            }
                        }
                    }
                    if ($strain['Strain'][$acronym] != "0") {
                        $chemical++;
                        echo '<span class="eff2" style="margin-right: 5px;"><a style="color: white" target="new" href="' . $wikipedia . '">' . strtoupper($acronym) . ':</a> ' . $strain['Strain'][$acronym] . '%</span> ';
                    };
                    return $chemical;
                }

                $chemical = printchemical($chemical, $strain, $DATA, "thc", "http://en.wikipedia.org/wiki/Tetrahydrocannabinol");
                $chemical = printchemical($chemical, $strain, $DATA, "cbd", "http://en.wikipedia.org/wiki/Cannabidiol");
                $chemical = printchemical($chemical, $strain, $DATA, "cbn", "http://en.wikipedia.org/wiki/Cannabinol");
                $chemical = printchemical($chemical, $strain, $DATA, "cbc", "http://en.wikipedia.org/wiki/Cannabichromene");
                $chemical = printchemical($chemical, $strain, $DATA, "thcv", "http://en.wikipedia.org/wiki/Tetrahydrocannabivarin");
                if ($chemical == 0) {
                    echo "<span class=' eff2' style=''>Not enough data, check back soon</span>";
                }
                ?>
            </DIV>
        </DIV>

        <DIV CLASS="col-md-5">
            <h2 class="pt-2">Flavors</h2>
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
                <!--a class="text-white" href="#">
                    <span style="font-size: 26px;padding-left:10px;" class="fa fa-star-half-full"></span>
                </a-->                    No flavors yet

                <?php
            }
            ?>
        </DIV>
    </div>
</div>
<?php
function fixtext($text)
{
    $text = html_entity_decode(html_entity_decode(htmlspecialchars_decode($text)));
    $text = str_replace(['&nbsp;<a data-target=".product__description" class="js-scroll-to text-cta">Learn More</a>', 'ain’'], ["", "'"], $text);
    return trim($text);
}

function slugtotext($key)
{
    if (textcontains($key, "-")) {
        $key = explode("-", $key);
        foreach ($key as $INDEX => $VALUE) {
            $key[$INDEX] = ucfirst($VALUE);
        }
        return implode(" ", $key);
    }
    return $key;
}

$imagedir = getcwd() . "/images/strains/" . $strain['Strain']['id'] . "/";
$webroot = $this->webroot . "images/strains/" . $strain['Strain']['id'] . "/";
$images = scandir($imagedir);
unset($images[0]);
unset($images[1]);


echo '<div class="jumbotron"><h3>Ontario Cannabis Store</h3>';

foreach ($DATA as $OCSDATA) {
    /*$dir = getcwd() . "/ocs/";
$filename = $dir . $strain['Strain']['slug'] . ".json";
$data = false;
if(file_exists($filename )) {
    $data = json_decode(file_get_contents($filename), true);
}*/

    echo '<div class="row">';
    echo '<div class="clearfix"></div>';

    $slug = false;
    if ($OCSDATA["prices"]) {
        $pricelist = json_decode($OCSDATA["prices"], true);
        $prices = [];
        $hasname = false;
        foreach ($pricelist as $data) {
            $prices[$data["slug"]][] = $data;
            $slug = $data["slug"];
        }

        echo '<div class="col-md-6">';

        foreach ($prices as $slug => $pricelist) {


            foreach ($pricelist as $data) {
                $text = slugtotext($data["category"]);

                if (!$hasname) {
                    if ($text != "hardcoded") {
                        echo '<div class="clearfix py-1"></div>';

                        echo "<strong>" . slugtotext($data["category"]) . ' from ' . $data["vendor"] . '</strong>';
                        echo '<div class="clearfix"></div>';

                        echo fixtext($OCSDATA["content"]);
                        echo '<div class="clearfix py-1"></div>';

                    }
                    $hasname = true;
                }

                echo '<span class="badge badge-secondary mr-2">' . $data["title"] . ' for ' . money_format(LC_MONETARY, $data["price"] * 0.01) . '</span>';
            }            echo '<div class="clearfix p-1"></div>';
            echo '<div class="clearfix p-1"></div>';

            echo '<A HREF="' . "https://ocs.ca/products/" . $slug . '" CLASS="btn btn-success btn-block" TARGET="_new">Purchase from ' . $data["vendor"] . '</A>';
            echo '<div class="clearfix p-1"></div>';

        }
        echo '</div>';


        if ($slug) {

            echo '<div class="col-md-6">';

            foreach ($images as $image) {
                if (startswith($image, $slug)) {
                    echo '<IMG SRC="' . $webroot . $image . '" CLASS="reportimage">';
                }
            }


            echo '</div>';

        }


    } else {

        echo "<br><br>234234324324324324 do we use this?<br><br>";
        $slugs["Purchase Now"] = $strain['Strain']['slug'];
        echo money_format(LC_MONETARY, $OCSDATA["price"] * 0.01);


    }


    echo '</div>';
    echo '<div class="clearfix py-4"></div>';


    // echo '<BR>Terpenes: ' . $OCSDATA["terpenes"];
    //$shorttext = fixtext($OCSDATA["shorttext"]);  echo $shorttext;
    //echo '<br><strong>Available:</strong> ' . iif($OCSDATA["available"] == 1, "Yes", "No");

}
echo "</div>";


if (!isset($p_filter)) {
    $p_filter = false;
}


echo '<div class="jumbotron"><h3>Canbii Activities</h3><p>What activities are enhanced with this strain?</p>';
getsymptomactivity($strain, "activities", "activity", false, "activity_id", $this->webroot, $p_filter, "light-blue");
echo "</div>";

function getsymptomactivity($strain, $plural, $singular, $OverallRating = false, $IDKEY, $webroot, $p_filter, $color)
{
    /*if ($p_filter === false && is_array($OverallRating)) { //i dont know what this is for
        foreach ($OverallRating as $oer) {
            $arrs[] = $oer['rate'] . '_' . $oer[$IDKEY];
        }
    } else {*/
    //$symptom_rate = $this->requestAction('/strains/getSymptomRate/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
    $symptom_rate = Query("SELECT * FROM " . $singular . "_ratings WHERE strain_id=" . $strain['Strain']['id'], true);
    $symptom_list = [];
    foreach ($symptom_rate as $data) {
        $ID = $data[$singular . "_id"];
        if (!isset($symptom_list[$ID])) {
            $symptom_list[$ID] = ["count" => 0, "total" => 0];
        }
        $symptom_list[$ID]["count"]++;
        $symptom_list[$ID]["total"] += $data["rate"];
    }
    if ($symptom_list) {
        $symptom_name = Query("SELECT * FROM " . $plural . " WHERE id IN(" . implode(",", array_keys($symptom_list)) . ")", true);
        foreach ($symptom_name as $symptom) {
            $ID = $symptom["id"];
            $symptom_list[$ID]["name"] = $symptom["title"];
            $symptom_list[$ID]["average"] = 0;
            if ($symptom_list[$ID]["count"]) {
                $symptom_list[$ID]["average"] = $symptom_list[$ID]["total"] / $symptom_list[$ID]["count"];
            }
        }
    }

    if ($symptom_list) {
        $i = 0;
        foreach ($symptom_list as $symptom) {
            $i++;
            if ($i == 16) {
                break;
            }
            $rate = $symptom["average"];
            $length = 20 * $rate;
            //$name =  $this->requestAction('/strains/getSymptom/' . $ars[1]);
            $name = $symptom["name"];// getiterator($names, "id", $ars[1])["title"];
            echo '<div class="pull-left">' . $name . '</div>';
            progressbar($webroot, $length, perc($length), "", "info", $color);
        }
    } else {
        printnoreviewlink($strain, $webroot);
    }
}

function printnoreviewlink($strain, $webroot)
{
    if ($GLOBALS["settings"]["allowreviews"]) {//set allowreviews in API.php to false if you don't want this link
        // echo '<a href="' . $webroot . 'review/add/' . $strain['Strain']['slug'] . '" CLASS="review">No ratings yet. </a>';
        echo 'No ratings yet';

    } else {
        echo 'No ratings yet';
    }
}

?>

<!--div class="jumbotron">
    <h3>Symptoms</h3>
    <p>How does this strain help with my medical condition?</p>
    <?php
    getsymptomactivity($strain, "symptoms", "symptom", $strain['OverallSymptomRating'], "symptom_id", $this->webroot, $p_filter, "light-blue");
    ?>
</div-->

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
        if ($effectids) {
            $effects = Query("SELECT * FROM effects WHERE id IN (" . implode(",", $effectids) . ")", true);
            foreach ($strain['OverallEffectRating'] as $oer) {
                $effect = getiterator($effects, "id", $oer['effect_id']);
                //if ($this->requestAction('/strains/getPosEff/' . $oer['effect_id'])) {
                if ($effect["negative"]) {
                    $arr_neg[] = $oer['rate'] . '_' . $oer['effect_id'];
                } else {
                    $arr[] = $oer['rate'] . '_' . $oer['effect_id'];
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
            echo '<div class="pull-left">' . $name . '</div>';
            progressbar($this->webroot, $length, perc($length), "", "success", "light-green");
        }
    } else {
        printnoreviewlink($strain, $this->webroot);
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
    $count_effects = 0;
    if (!$p_filter) {
        $count = count($strain['Review']);
        if ($count) {
            foreach ($strain['Review'] as $r) {

                if ($r['eff_scale'] != 0 && $r['eff_strength'] != 0 && $r['eff_duration'] != 0) {
                    $count_effects++;
                    // echo $r['eff_scale'] . $r['eff_strength'] . $r['eff_duration'];
                    $scale = $scale + $r['eff_scale'];
                    $strength = $strength + $r['eff_strength'];
                    $duration = $duration + $r['eff_duration'];
                }
            }
        }
    } else {
        $effect_review = $this->requestAction('/strains/getEffectReview/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
        $count = count($strain['Review']);
        if ($count) {
            foreach ($effect_review as $r) {
                if ($r['Review']['eff_scale'] != 0 && $r['Review']['eff_strength'] != 0 && $r['Review']['eff_duration'] != 0) {
                    $count_effects++;
                    $scale = $scale + $r['Review']['eff_scale'];
                    $strength = $strength + $r['Review']['eff_strength'];
                    $duration = $duration + $r['Review']['eff_duration'];
                }
            }
        }
    }
    if ($count_effects) {
        $Factor = 20;//20;
        $scale = ($scale / $count_effects) * $Factor;
        $strength = ($strength / $count_effects) * $Factor;
        $duration = ($duration / $count_effects) * $Factor;
    }
    if ($scale) {
        echo '<div class="pull-left">Sedative</div>';
        progressbar($this->webroot, $scale, perc($scale), "", "warning", "light-purple");
    }
    if ($strength) {
        echo '<div class="pull-left">Strength</div>';
        progressbar($this->webroot, $strength, perc($strength), "", "warning", "light-purple");
    }
    if ($duration) {
        echo '<div class="pull-left">Duration</div>';
        progressbar($this->webroot, $duration, perc($duration), "", "warning", "light-purple");
    }
    if (!$duration && !$strength && !$scale) {
        printnoreviewlink($strain, $this->webroot);
    }
    ?>
</div>


<?php if (false) { ?>
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
                echo '<div class="pull-left">' . $name . '</div>';
                progressbar($this->webroot, $length, perc($length), "", "danger", "light-red");
            }
        } else {
            echo '<I>';
            printnoreviewlink($strain, $this->webroot);
            echo '</I>';
        }
        ?>
    </div>

<?php } ?>
<div class="jumbotron">
    <?php include_once('combine/strain_reviews.php'); ?>
    <a href="<?= $this->webroot; ?>strains/review/<?= $strain['Strain']['slug']; ?>">
        Hide This on Live - See All Reviews for <?= $strain['Strain']['id'] . ": " . $strain['Strain']['name']; ?> &raquo;
    </a>
</div>

<div class="jumbotron">
    <h3><?= $strain['Strain']['name']; ?> Dried Flower Images</h3>
    <?php include('combine/images.php'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".fancybox").fancybox();
        });
    </script>
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
        Rectangle();
        screenRect = new Rectangle(Toolkit.getDefaultToolkit().getScreenSize());
        BufferedImage();
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
                    } else if (e.className.indexOf('upvote-on') != -1) {
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
            $.ajax({
                type: "POST",
                url: "<?= Router::url(array('controller' => 'symptomvote', 'action' => 'sendVote'));?>/<?= $strain['Strain']['id'] ?>/" + symp,
                data: {up: up, down: down},
                success: function (response) {
                    console.log(response);
                }
            });
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

        <?php if($helpful){ ?>
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
                $('#' + arr[0] + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;');
                var o = parseFloat(arr[0]) + 1;
                $('#' + o + '_' + r_id).attr('style', 'background:#FFF;cursor: default;display:inline-block;padding:4px 7px;');
                $('#' + o + '_' + r_id + ' strong').attr('style', 'color:#eee');
                //$('#'+o+'_'+r_id).attr('onclick','return false;');
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
                    url: webroot + 'strains/helpful/' + r_id + '/no'
                });
                $('#' + arr2[0] + '_' + r_id).removeClass('yes');
                var o = parseFloat(arr2[0]) + 1;
                $('#' + num + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;display:inline-block;padding:4px 7px;');
                $('#' + num + '_' + r_id + ' strong').attr('style', 'color:#CCC;');
                $('#' + o + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;');
                $(this).attr('style', 'padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px;background:#e5e5e5;cursor:default;');
            }
        });
    });
</script>
