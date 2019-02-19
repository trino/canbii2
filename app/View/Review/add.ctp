<script src="<?= $this->webroot; ?>js/raty.js"></script>
<script src="<?= $this->webroot; ?>js/labs.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/colorpicker.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/eye.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/utils.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/layout.js?ver=1.0.2"></script>
<link href="<?= $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>
<link href="<?= $this->webroot; ?>css/colorpicker.css" rel="stylesheet" type="text/css"/>
<link href="<?= $this->webroot; ?>css/layout.css" rel="stylesheet" type="text/css" title="progress bar"/>
<!-- script src="<?= $this->webroot; ?>js/bootstrap.min.js"></script-->

<div class="page_layout page_margin_top clearfix">
    <div class="page_header clearfix" style="white-space: nowrap;">
        <div class="page_header_left" style="white-space: nowrap;">

            <?php
                function setslider($ID, $rating){
                    echo '<script>$(function () {setslider("' . $ID . '", ' . $rating . ', true);});</script>';
                }

                function hiif($value, $true, $false = "") {
                    if ($value) {
                        return $true;
                    }
                    return $false;
                }

                // http://localhost/metronic/templates/admin/ui_general.html
                // Acceptable colors:
                // Metronic: success (green), info (blue), warning (yellow), danger (red). Active does not work
                // Old: light-purple, light-red, light-blue, light-green
                function progressbar($webroot, $value, $textL = "", $textR = "", $color = "success", $color2 = "light-purple", $striped = false, $active = false, $min = 0, $max = 5) {
                    if ($textL) {
                        echo '<label style="margin-top: 0px;">' . $textL;
                        if ($textR != "noshow") {
                            echo '<Div style="float:right;">' . $value . "/" . $max . "</div>";
                        }
                        echo "</label>";
                    }
                    echo '<div class="progress' . hiif($striped, " progress-striped") . iif($active, " active") . '" style="margin-bottom: 8px;">';
                    echo '<img src="' . $webroot . 'images/bar_chart/' . $color2 . '.png" style="width: ';
                    echo (round($value, 2) > $max) ? $max : round($value / ($max - $min) * 100, 2);
                    echo '%;height:20px;"/></div>';
                }

                function perc($scale) {
                    return round($scale / 20, 2) . "/5";
                }

                function getdata($r, $name, $default = "") {
                    if (isset($r[$name])) {
                        return $r['Review'][$name];
                    }
                    return $default;
                }

                function findsymptom($symptoms, $ID, $Field = 'Symptom') {
                    foreach ($symptoms as $symptom) {
                        if($Field) {
                            if ($symptom[$Field]['id'] == $ID) {
                                return $symptom[$Field];
                            }
                        } else {
                            if ($symptom['id'] == $ID) {
                                return $symptom;
                            }
                        }
                    }
                }

                // unset($strain_hexagon);
                if (isset($strain)) {
                    $strain_hexagon = $strain;
                } else {
                    $strain_hexagon = $review;
                }

                if ($this->params['action'] != 'add') {
                    echo '<a href="' . $this->webroot . 'strains/' . $review['Strain']['slug'] . '">';
                }
                include('combine/hexagon.php');
                if ($this->params['action'] != 'add') {
                    echo '</a>';
                }

                $types = [1 => "Indica", 2 => "Sativa", 3 => "Hybrid"];
                $type = $types[$strain['Strain']['type_id']];

                if ($this->params['action'] == 'add') {
            ?>
                <div style="white-space: nowrap;float:none;">
                    <h1 class="page_title" style=" float:none !important;"><?= $strain_name ?> Review</h1>
                    <p style="white-space: nowrap;">
                        <?= $type; ?> Cannabis
                    </p>
                </div>

            <?php } else { ?>

                <div style="white-space: nowrap;">
                    <h1>
                        <?= ucfirst($review['Strain']['name']); ?> Review
                    </h1>
                    <p style="white-space: nowrap;">
                        By <?= $this->requestAction('/strains/getUserName/' . $review['Review']['user_id']); ?>
                        on <?= $review['Review']['on_date']; ?>
                    </p>
                </div>
            <?php }
                if (!isset($_GET["review"])) {
                    $editreview = array();
                }
            ?>
        </div>
        <?php if ($this->Session->read('User') && $this->params['action'] != 'detail') { ?>
            <div class="page_header_right">
                <a style="margin-right:10px;" title="Read more" href="<?= $this->webroot; ?>users/dashboard" class=" more large dark_blue icon_small_arrow margin_right_white">My Account</a>
                <a style="margin-right:10px;" title="Read more" href="<?= $this->webroot; ?>users/settings" class="more large dark_blue icon_small_arrow margin_right_white">Settings</a>
                <a style="margin-right:10px;" title="Read more" href="<?= $this->webroot; ?>review" class="more large dark_blue icon_small_arrow margin_right_white active">Add Review</a>
                <a title="Read more" href="<?= $this->webroot; ?>review/all" class="more large dark_blue icon_small_arrow margin_right_white  ">My Reviews</a>
            </div>
        <?php } ?>
    </div>

    <div class="clearfix">
        <div class="page_left page_margin_top">
            <?php if ($this->params['action'] == 'add') { ?>
                <div class="backgroundcolor"><p>Please be as precise as possible so we can further help personalize medication for other patients. We thank you for your help and support.</p></div>
            <?php } ?>

            <form action="" method="post" id="reviews1">
                <fieldset id="qf_review__general" class="qf-fieldset">
                    <h2 class="slide page_margin_top">
                        General Rating
                    </h2>

                    <div class="backgroundcolor">
                        <h3>Effect Scale (Sedative to Active)</h3>
                        <?php if (isset($review) && $review['Review']['eff_scale'] < 2) {
                            echo "<strong>No Review</strong><br/>";
                        } else { ?>
                            <p id="qf_review__general__mscale__prompt">
                            <?php if ($this->params['action'] == 'add') { ?>
                                </p>
                                <div><input id="qf_review__general__mscale" class="qf-hidden-input qf-slider qf-input" type="hidden" name="eff_scale" value="0" title="Effect Scale (Active to Sedative)"/></div>
                                <div id="qf_review__general__mscale__slider" class="qf-slider-bar ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
                            <?php } else {
                                $typ = array('', 'NULL', 'Extremely Sedated', 'Very Sedated', 'Sedated', 'Bit Sedated', 'Balanced', 'Bit Active', 'Active', 'Very Active', 'Extremely Active');
                                progressbar($this->webroot, $review['Review']['eff_scale'], $typ[$review['Review']['eff_scale']], "noshow", "warning", "light-purple", false, false, 0, 9);
                                //echo $typ[$review['Review']['eff_scale']];
                            }
                        } ?>
                        <h3>Effect Strength</h3>
                        <?php if (isset($review) && $review['Review']['eff_strength'] == 0) {
                            echo "<strong>No Review</strong><br/>";
                        } elseif (isset($review)) {
                            $strengths = array("", "Very weak", "Weak", "Average", "Strong", "Very Strong");
                            progressbar($this->webroot, $review['Review']['eff_strength'], $strengths[$review['Review']['eff_strength']]);
                        } else {
                            ?>
                            <p id="qf_review__general__strength__prompt">
                                <?php if ($this->params['action'] == 'add') echo '0'; else if (isset($review)) echo $review['Review']['eff_strength']; ?>
                                /5
                            </p>
                            <div>
                                <input id="qf_review__general__strength" class="qf-hidden-input qf-slider qf-input" type="hidden" name="eff_strength" value="0" title="Effect Strength">
                            </div>
                            <div id="qf_review__general__strength__slider" class="qf-slider-bar ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                            </div>
                        <?php } ?>
                        <h3>Effect Duration</h3>
                        <?php if (isset($review) && $review['Review']['eff_duration'] == 0) {
                            echo "<strong>No Review</strong><br/>";
                        } elseif (isset($review)) {
                            progressbar($this->webroot, $review['Review']['eff_duration'], $review['Review']['eff_duration'] . " hours");
                        } else {
                            ?>
                            <p id="qf_review__general__duration__prompt"><?php if ($this->params['action'] == 'add') echo ''; else echo $review['Review']['eff_duration'] . " hrs"; ?></p>
                            <div>
                                <input id="qf_review__general__duration" class="qf-hidden-input qf-slider qf-input" type="hidden" name="eff_duration" value="0" title="Effect Duration">
                            </div>
                            <div id="qf_review__general__duration__slider" class="qf-slider-bar ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
                        <?php } ?>
                    </div>
                </fieldset>

                <div class="clear"></div>


                <fieldset id="qf_review__activities" class="qf-fieldset">
                    <div class="backgroundcolor">
                        <h2 class="slide page_margin_top">
                            Activities Rating
                        </h2>
                        <p>How much did this strain enhance your activity/activities?</p>
                        <span id="qf_review__effects__activity__inner">
                            <?php
                                $symptoms = Query("SELECT * FROM activities", true);
                                if ($this->params['action'] == 'add') {
                                    foreach ($symptoms as $effect) { ?>
                                        <a href="javascript:void(0);" onclick="toggleclass(this, 'sel');" title="<?= $effect['id']; ?>"
                                           class="eff3 btn qf_review__effects__activity"><?= ucfirst($effect['title']); ?></a>
                                    <?php }
                                } else {
                                    $ActivityRating = Query("SELECT * FROM activity_ratings WHERE review_id=" . $review['Review']['id'], true);
                                    if (count($ActivityRating) > 0){
                                        foreach ($ActivityRating as $effect){
                                            if (count($symptoms) > $effect['activity_id'] - 1) {
                                                $symptom = findsymptom($symptoms, $effect['activity_id'], false);
                                                progressbar($this->webroot, $effect['rate'], $symptom['title'], "", "info", "light-red");
                                                setslider($effect['id'] . "ac", $effect['rate']);
                                            }
                                        }
                                    } else {
                                        echo "<strong>No Review For Activities</strong>";
                                    }
                                }
                            ?>
                        </span>
                    </div>
                </fieldset>

                <div class="clear"></div>

                <fieldset id="qf_review__effects" class="qf-fieldset">
                    <h2 class="slide page_margin_top">
                        Effects Rating
                    </h2>

                    <div class="backgroundcolor">
                        <h3>
                            Medicinal Effects
                        </h3>
                        <p>How well did this strain help your medical condition(s)?</p>

                        <span id="qf_review__effects__medical__inner">
                            <?php
                                if ($this->params['action'] == 'add') {
                                    $symptoms = Query("SELECT * FROM symptoms", true);
                                    foreach ($symptoms as $effect) { ?>
                                        <a href="javascript:void(0);" onclick="toggleclass(this, 'sel');" title="<?= $effect['id']; ?>"
                                           class="eff3 btn qf_review__effects__medical"><?= ucfirst($effect['title']); ?></a>
                                    <?php }
                                } else if (count($review['SymptomRating']) > 0){
                                    foreach ($review['SymptomRating'] as $effect){
                                        if (count($symptoms) > $effect['symptom_id'] - 1) {
                                            $symptom = findsymptom($symptoms, $effect['symptom_id']);
                                            progressbar($this->webroot, $effect['rate'], $symptom['title'], "", "info", "light-blue");
                                            setslider($effect['id'] . "er", $effect['rate']);
                                        }
                                    }
                                } else {
                                    echo "<strong>No Review For Medicinal Effects</strong>";
                                }
                            ?>
                        </span>

                        <div class="clear"></div>




                        <DIV>
                        <div style="border-bottom: 1px solid #dadada;margin:10px 0;"></div>
                        <h3>
                            Positive Effects
                        </h3>
                        <p>What positive effect(s) did this strain have on you?</p>
                        <span id="qf_review__effects__positive__inner">
                        <?php
                            $pos = Query("SELECT * FROM effects WHERE negative=0", true);
                            if ($this->params['action'] == 'add') {
                                foreach ($pos as $effect) { ?>
                                    <a href="javascript:void(0);" onclick="toggleclass(this, 'sel');" title="<?= $effect['id']; ?>"
                                        class="eff3 btn btn-info qf_review__effects__positive"><?= ucfirst($effect['title']); ?></a>
                                <?php }
                            } else {
                                if ($pos > 0){
                                    foreach ($pos as $effect){
                                        $theeffect = findsymptom($effects, $effect['effect_id'], 'Effect');
                                        progressbar($this->webroot, $effect['rate'], $theeffect['title'], "", "success", "light-green");
                                        setslider($effect['id'] . "pe", $effect['rate']);
                                    }
                                } else {
                                    echo "<strong>No Review For Positive Effects</strong>";
                                }
                            }
                        ?>
                        </div>


                        <div style="border-bottom: 1px solid #dadada;margin:10px 0;"></div>

                        <h3>
                            Negative Effects
                        </h3>

                        <p>What negative effect(s) did this strain have on you?</p>

                        <span id="qf_review__effects__negative__inner">

                        <?php
                            if ($this->params['action'] == 'add') {
                                if(!isset($negative)){
                                    $negative = Query("SELECT * FROM effects WHERE negative=1", true);
                                }
                                foreach ($negative as $effect) {
                                    if(!isset($effect["Effect"])){
                                        $effect["Effect"] = $effect;
                                    }
                                    ?>
                                     <a href="javascript:void(0);" onclick="toggleclass(this, 'sel');" title="<?php echo $effect['Effect']['id']; ?>"
                                            class="eff3 btn btn-info qf_review__effects__negative"><?php echo ucfirst($effect['Effect']['title']); ?></a>
                                <?php }
                            } else {
                                $pos = array();
                                foreach ($negative as $e) {
                                    array_push($pos, $e['Effect']['id']);
                                }
                                $cnt = 0;
                                foreach ($review['EffectRating'] as $effect) {
                                    if (in_array($effect['effect_id'], $pos)) {
                                        $cnt++;
                                    }
                                }
                                if ($cnt > 0){
                                    foreach ($review['EffectRating'] as $effect){
                                        if (in_array($effect['effect_id'], $pos)){
                                            $theeffect = findsymptom($effectz, $effect['effect_id'], 'Effect');
                                            progressbar($this->webroot, $effect['rate'], $theeffect['title'], "", "danger", "light-red");
                                            setslider($effect['id'] . "ne", $effect['rate']);
                                        }
                                    }
                                } else {
                                    echo "<strong>No Review For Negative Effects</strong>";
                                }
                            } ?>
                        </span>
                    </div>
                </div>
            </fieldset>

            <fieldset id="qf_review__aesthetics" class="qf-fieldset">

                <h2 class="slide page_margin_top">
                    Aesthetic Rating
                </h2>

                <div class="backgroundcolor">
                    <?php if (false) { ?>
                        <h3>
                            Color
                        </h3>

                        <p>What color(s) stand out in this bud?</p>

                        <span id="qf_review__aesthetics__color__inner">

                            <?php
                                if ($this->params['action'] == 'add') {
                                    include("combine/picker.php");
                                    ?>
                                    <!--<p id="colorpickerHolder">
                                    </p>-->
                                    <span class="morecolours"></span>
                                    <?php
                                        /* foreach($colours as $colour) { ?>
                                            <a href="javascript:void(0);" onclick="toggleclass(this, 'sel');"
                                                title="<?php echo $colour['Colour']['id'];?>" class="eff3 btn btn-info qf_review__aesthetics__color"><?php echo ucfirst($colour['Colour']['title']);?></a>
                                            <?php
                                        }*/
                                } else {
                                    /*
                                    if(count($review['ColourRating'])>0){
                                        foreach($review['ColourRating'] as $effect){ ?>
                                            <span id="efft_<?php echo $effect['id'];?>" class="eff3 sel btn btn-info"><?php echo $colours[$effect['colour_id']-1]['Colour']['title'];?></span>
                                            <?php
                                        }
                                    }*/
                                    //var_dump($review_color);
                                    if (count($review_color) > 0) {
                                        echo "<span>";
                                        foreach ($review_color as $r) {
                                            echo "<div style='background-color:" . $r['ReviewColor']['color'] . ";width:20px;height:20px;float:left;margin:5px;'></div>";
                                        }
                                        echo '</span><div class="clear"></div>';
                                    } else {
                                        echo "<strong>No Review For Color</strong>";
                                    }
                                }
                            ?>
                        </span>

                        <div class="clear"></div>

                        <div style="border-bottom: 1px solid #dadada;margin:10px 0;"></div>

                    <?php } ?>

                    <h3>
                        Flavor & Scent
                    </h3>

                    <p>How does this strain taste & smell?</p>

                    <span id="qf_review__aesthetics__flavor__inner">
                        <?php
                            if ($this->params['action'] == 'add') {
                                if(!isset($flavors)){
                                    $flavors = Query("SELECT * FROM flavors", true);;
                                }
                                foreach ($flavors as $flavor) {
                                    if(!isset($flavor['Flavor'])){
                                        $flavor['Flavor'] = $flavor;
                                    }
                                    ?>
                                    <a href="javascript:void(0);" onclick="toggleclass(this, 'sel');"
                                          title="<?php echo $flavor['Flavor']['id']; ?>" class="eff3 btn btn-info qf_review__aesthetics__flavor"><?= ucfirst($flavor['Flavor']['title']); ?></a>
                                <?php }
                            } else {
                                if (count($review['FlavorRating']) > 0) {
                                    foreach ($review['FlavorRating'] as $effect) { ?>
                                        <span id="efft_<?= $effect['id']; ?>" class="eff3 sel btn btn-info"><?= $flavors[$effect['flavor_id'] - 1]['Flavor']['title']; ?></span>
                                    <?php }
                                } else {
                                    echo "<strong>No Review For Flavour & Scent</strong>";
                                }
                            }
                        ?>
                    </span>
                </div>

            </fieldset>

            <h2 class="slide page_margin_top">
                Rating & Comment <?php if ($this->params['action'] == 'add') echo '(Required)'; ?>
            </h2>

            <div class="backgroundcolor">

                <h3>canbii Rating</h3>

                <div id="preci" data-score="2">
                    <div id="precision" data-score="1" class="left" style="cursor: pointer;"></div>
                    <div class="errorz" style="display: none;">Overall Rating Is Mandatory.</div>
                </div>

                <p id="qf_review__other__overall__prompt">1/5</p>

                <input title="Overall Rating" value="<?= getdata($editreview, 'rate', 0); ?>" type="hidden" name="rate" id="qf_review__other__overall" class="qf-hidden-input qf-slider qf-input"/>

                <div class="qf-slider-bar" score="4" id="qf_review__other__overall__slider"></div>

                <h3 class="page_margin_top">Comments</h3>

                <?php
                    if (isset($_GET["review"])) {
                        $score = getdata($editreview, 'rate');
                    }
                    if ($this->params['action'] == 'add') { ?>
                        <textarea title="Comments" rows="8" maxlength="4000" name="review" STYLE="width: 100%"
                                  id="qf_review__other__comments" class="qf-maxlength-4000 qf-required qf-textarea"
                                  required="required"><?= getdata($editreview, 'review'); ?></textarea>
                        <div class="submit">
                            <input type="submit" name="submit" value="Save My Review" class="button more blue"/>
                        </div>

                    <?php } else {
                        echo '<br/>' . $review['Review']['review'];
                    }
                ?>

                <div class="clear"></div>
            </div>

        </form>
    </div>

    <div class="page_right page_margin_top">
        <?php
            $breaker = 0;
            if (isset($strain)) {
                echo "<h2>Strain Images</h2>";
                include('combine/images.php');
            }
        ?>
    </div>

    <?php
        if ($this->Session->read('User') && $this->params['action'] != 'detail') {
            //GNDN
        } elseif ($this->Session->read('User')['id'] == $review['Review']['user_id']) {//http://localhost/marijuana/
    ?>
            <div class="clearfix"></div>
            <div class="vote" style="position:fixed;bottom: 0;right:0;background:#e5e5e5;padding:20px;z-index:100000;" align="center">
                <strong>Would you like to delete this review?</strong><br/><br/>
                <a href="<?= $this->webroot;?>review/all?delete=<?= $review['Review']['id']; ?>"
                   class="btns yes"
                   onclick="return confirm('Are you sure you want to delete your review?');"
                   style="background-color: #40b2e2; padding-left:6px; padding-right:6px; padding-top: 5px; padding-bottom: 5px; margin-right:5px"><strong style="color: white">YES</strong></a>
            </div>
        <?php } else { ?>
            <div class="clearfix"></div>
            <div class="vote" style="position:fixed;bottom: 0;right:0;background:#e5e5e5;padding:20px;z-index:100000;">
                <?php
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $rand1 = rand(100, 999);
                    //$rand2 = rand(100, 999);
                    $q5 = $vip->find('first', array('conditions' => array('review_id' => $review['Review']['id'], 'ip' => $ip)));

                    if ($q5) {
                        $vote = 1;
                        $yes = $q5['VoteIp']['vote_yes'];
                    } else {
                        $vote = 0;
                    }
                ?>

                <strong>Was this review helpful?</strong><br/><br/>

                <div align="Center">
                    <?php if ($vote == 0){ ?>
                        <a href="javascript:void(0);" id="<?= $rand1 . '_' . $review['Review']['id']; ?>" class="btns yes" style="background-color: #40b2e2; padding-left:6px; padding-right:6px; padding-top: 5px; padding-bottom: 5px; margin-right:5px">
                            <strong style="color: white">YES<?php if ($review['Review']['helpful']) { ?> (<?php echo $review['Review']['helpful']; ?>)<?php } ?></strong>
                        </a>
                        <a class="btns no" href="javascript:void(0);" id="<?php echo ($rand1 + 1) . '_' . $review['Review']['id']; ?>" style="background-color: #1e84c6; padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px">
                            <strong style="color: white">NO<?php if ($review['Review']['not_helpful']) { ?> (<?php echo $review['Review']['not_helpful']; ?>)<?php } ?></strong>
                        </a>
                    <?php } else{
                        $lightcolor = ':#CCC;';
                        $darkcolor = ':#aaa;';
                        if ($yes == 1) {
                            $y1 = 'padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px;background:#e5e5e5;cursor:default;';
                            $y2 = 'color' . $darkcolor;//'color:#fff';
                            $n1 = 'background' . $darkcolor . 'color' . $lightcolor . 'cursor: default;padding:4px 7px;';
                            $n2 = 'color' . $lightcolor;//:#CCC;';
                        } else {
                            $y1 = 'background' . $darkcolor . 'color' . $lightcolor . 'cursor: default;padding:4px 7px;';
                            $y2 = 'color' . $lightcolor;//:#CCC;';
                            $n1 = 'padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px;background:#e5e5e5;cursor:default;';
                            $n2 = 'color' . $darkcolor;//'color:#fff';
                        }
                    ?>
                        <a href="javascript:void(0);" id="" class="faded" style="<?php echo $y1; ?>">
                            <span style="<?php echo $y2; ?>">YES<?php if ($review['Review']['helpful']) { echo " (" . $review['Review']['helpful'] . ")"; } ?></span>
                        </a>
                        <a class="faded" href="javascript:void(0);" id="" style="<?php echo $n1; ?>">
                            <span style="<?php echo $n2; ?>">NO<?php if ($review['Review']['not_helpful']) { echo " (" . $review['Review']['not_helpful'] . ")";} ?></span>
                        </a>
                        <div style="color: #37A319;margin-top:15px;clear:both;">Thanks for voting!</div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

<script>
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });

    function toggleclass(element, classname){
        if($(element).hasClass(classname)) {
            $(element).removeClass(classname);
        } else {
            $(element).addClass(classname);
        }
    }

    function setslider(ID, rating, disabled) {
        $('#' + ID).slider({
            range: "min",
            disabled: disabled,
            value: rating,
            min: 0,
            max: 5,
            slide: function (event, ui, ID) {
                var ID = $(event.target).attr("id");
                ID = ID.left(ID.length-1);
                console.log(ID + " VALUE " + JSON.stringify(ui));
                $('#' + ID + 'p').html('' + ui.value + '/5');
                $('#' + ID + 'i').val(ui.value);
            }
        });
    }

    function setslider2(ID, value, disabled){
        $("#" + ID + "__slider").slider({
            'min': 0,
            'max': 5,
            disabled: disabled,
            'step': 1,
            'value': value,
            'slide': function (e, ui) {
                var ID = $(event.target).attr("id");
                ID = ID.left(ID.length-8);
                $('#' + ID).val(ui.value);
                $('#' + ID + '__prompt').html('' + ui.value + '/5');
            },
            'range': 'min'
        });
    }

    function openWindowWithPost(data, url) {
        var form = document.createElement("form");
        form.method = "POST";
        if(isUndefined(url)){
            url = window.location.href;
        }
        form.id = "postform";
        form.action = url;
        form.style.display = "none";
        for (var key in data) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }
        document.body.appendChild(form);
        $("#postform").submit();
    }

    function formsubmithandler(){
        if ($('#qf_review__other__overall').val() == '0') {
            $('.errorz').show();
            return false;
        }
        $('.errorz').hide();
        var data = getform("#reviews1");
        $(".review-slider").each(function(){
            var ID = $(this).attr("id");
            if(ID.startswith("flavor")){
                data["flavor[" + ID.right(ID.length - 6) + "]"] = 5;
            }
        });
        openWindowWithPost(data);
    }

    $(function () {
        $('#colorpickerHolder').ColorPicker({
            flat: true,
            onSubmit: function (hsb, hex, rgb) {
                $('.morecolours').html("<div style='background-color:#" + hex + "; width:40px;height:20px;margin:5px;float:left;'><input type='hidden' name='color[]'value='" + hex + "'/></div>")
                //$('#colorSelector div').css('backgroundColor', '#' + hex);
            }
        });

        <?php if($this->params['action']=='add'){ ?>
            $('#reviews1').submit(function (event) {
                event.preventDefault();
                formsubmithandler();
                return false;
            });

            $('.qf_review__effects__medical').click(function () {
                addSlider($(this), 'medical');
            });

            $('.qf_review__effects__activity').click(function () {
                addSlider($(this), 'activity');
            });
            /*$('.qf_review__aesthetics__color').click(function () {
             addSlider($(this), 'color');
             });*/
            $('.qf_review__aesthetics__flavor').click(function () {
                addSlider($(this), 'flavor');
            });
            $('.qf_review__effects__positive').click(function () {
                addSlider($(this), 'positive');
            });
            $('.qf_review__effects__negative').click(function () {
                addSlider($(this), 'negative');
            });


            function addSlider(jQ, type) {
                var sel = jQ.attr('title');
                if (sel <= 0) return false;
                var opt = jQ.find('option:selected');
                var txt = jQ.text();
                var id = type + sel;
                var value = 0;
                var h = "";
                if ($('#' + id).length != 0) {
                    opt.removeClass("selected");
                    $('#' + id).remove();
                } else {
                    opt.addClass("selected");
                    var cat = (type == 'color' || type == 'flavor') ? 'aesthetics' : 'effects';
                    if (cat == 'aesthetics') {
                        h = "display:none";
                        value = 1;
                    }
                    var innerId = '#qf_review__' + cat + '__' + type + '__inner';
                    if (type == 'positive' || type == 'negative') {
                        type = 'effect';
                    }
                    if( $(innerId).length == 0){
                        console.log(innerId + " not found");
                    } else {
                        var HTML = '<div id="' + id + '" class="review-slider" style="' + h + '"><h4>' + txt + '</h4>';
                        HTML += '<input type="hidden" id="' + id + 'i" name="' + type + '[' + sel + ']" value="' + value + '"/>';
                        HTML += '<div class="slider"  id="' + id + 's"></div><p CLASS="display" id="' + id + 'p" >' + value + '/5</p><div class="clear"> </div></div>';
                        $(innerId).append(HTML);
                        setslider(id + 's', 0, false);
                    }
                }
                jQ.val("");
            }

            $("#qf_review__general__mscale__slider").slider({
                'min': 0, 'max': 9, 'step': 1, 'value': 0, 'slide': function (e, ui) {
                    $('#qf_review__general__mscale').val(ui.value);
                    var vals = ['', 'Extremely Sedated', 'Very Sedated', 'Sedated', 'Bit Sedated', 'Balanced', 'Bit Active', 'Active', 'Very Active', 'Extremely Active'];
                    $('#qf_review__general__mscale__prompt').html(vals[Math.ceil(((ui.value + 1 - 1) / (9 + 1 - 1)) * vals.length) - 1]);
                }, 'range': 'min'
            });

            setslider2('qf_review__general__strength', 0, false);
            setslider2('qf_review__general__duration', 0, false);
            setslider2('qf_review__aesthetics__hairs', 5, false);
            setslider2('qf_review__aesthetics__crystals', 5, false);

            $('#precision').raty({
                <?php if (isset($_GET['review'])){
                    echo "score    :  " . $score . ",";
                } ?>
                cancel: false,
                cancelOff: 'cancel-off.png',
                cancelOn: 'cancel-on.png',
                path: '<?= $this->webroot;?>raty/images',
                starHalf: 'star-half.png',
                starOff: 'star-off.png',
                starOn: 'star-on.png',
                target: '#qf_review__other__overall__prompt',
                targetKeep: true,
                precision: true,
                number: 5,
                //hints      : ['1/5','2/5','3/5','4/5','5/5'],
                click: function (score) {
                    $('#qf_review__other__overall').val(score.toFixed(2));
                    $('.errorz').hide();
                }
            });
        <?php } else { ?>
            $("#qf_review__general__mscale__slider").slider({
                'min': 0,
                disabled: true,
                'max': 9,
                'step': 1,
                'value':<?= $review['Review']['eff_scale'];?>,
                'slide': function (e, ui) {
                    $('#qf_review__general__mscale').val(ui.value);
                    var vals = ['', 'Extremely Active', 'Very Active', 'Active', 'Bit Active', 'Balanced', 'Bit Sedated', 'Sedated', 'Very Sedated', 'Extremely Sedated'];
                    $('#qf_review__general__mscale__prompt').html(vals[Math.ceil(((ui.value + 1 - 1) / (9 + 1 - 1)) * vals.length) - 1]);
                },
                'range': 'min'
            });

            setslider2('qf_review__general__strength', <?= $review['Review']['eff_strength'];?>, true);
            setslider2('qf_review__general__duration', <?= $review['Review']['eff_duration'];?>, true);
            setslider2('qf_review__aesthetics__hairs', <?= $review['Review']['eff_scale'];?>, true);
            setslider2('qf_review__aesthetics__crystals', <?= $review['Review']['eff_scale'];?>, true);

            //$("#qf_review__other__overall__slider").slider({'min':1,'max':5,'step':1,'value':1,'slide':function(e,ui){ $('#qf_review__other__overall').val(ui.value);$('#qf_review__other__overall__prompt').html(''+ui.value+'/5'); },'range':'min'});
            $('#precision').raty({
                cancel: false,
                readOnly: true,
                cancelOff: 'cancel-off.png',
                cancelOn: 'cancel-on.png',
                path: '<?= $this->webroot;?>raty/images',
                starHalf: 'star-half.png',
                starOff: 'star-off.png',
                starOn: 'star-on.png',
                target: '#qf_review__other__overall__prompt',
                targetKeep: true,
                precision: true,
                number: 5,
                score: <?= $review['Review']['rate'];?>,
                //hints      : ['1/10','2/10','3/10','4/10','5/10','6/10','7/10','8/10','9/10','10/10'],
                click: function (score) {
                    $('#qf_review__other__overall').val(score.toFixed(2));
                    $('.errorz').hide();
                }
            });
        <?php } ?>

        $('.yes').click(function () {
            var id = $(this).attr('id');
            var arr = id.split('_');
            var r_id = arr[1];
            $.ajax({
                url: '<?php echo $this->webroot;?>strains/helpful/' + r_id + '/yes',
            });
            $('#' + arr[0] + '_' + r_id).removeClass('yes');
            $('#' + arr[0] + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;');
            $('#' + arr[0] + '_' + r_id).attr('onclick', 'return false;');
            var o = parseFloat(arr[0]) + 1;
            $('#' + o + '_' + r_id).removeClass('no');
            $('#' + o + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;display:inline-block;padding:8px 7px;');
            $('#' + o + '_' + r_id + ' strong').attr('style', 'color:#CCC;');
            $('#' + o + '_' + r_id).attr('onclick', 'return false;');
            $(this).attr('style', $(this).attr('style').replace('background:#FFF;', 'background:#e5e5e5;display:inline-block;padding:8px 7px;'));
        });

        $('.no').click(function () {
            var id = $(this).attr('id');

            var arr2 = id.split('_');
            var num = parseFloat(arr2[0] - 1);
            var r_id = arr2[1];
            $.ajax({
                url: '<?= $this->webroot;?>strains/helpful/' + r_id + '/no',
            });
            $('#' + num + '_' + r_id).removeClass('yes');
            var o = parseFloat(num) + 1;
            $('#' + o + '_' + r_id).removeClass('no');
            $('#' + num + '_' + r_id).attr('style', 'background:#FFF;color:#CCC;cursor: default;display:inline-block;padding:8px 7px;')
            $('#' + num + '_' + r_id + ' strong').attr('style', 'color:#CCC;');
            //$('#'+num+'_'+r_id).attr('onclick','return false;');
            //$('#'+o+'_'+r_id).attr('style','background:#FFF;color:#CCC;cursor: default;');
            //$('#'+o+'_'+r_id).attr('onclick','return false;');
            $(this).attr('style', 'background:#e5e5e5;display:inline-block;padding:8px 7px;color:#CCC;cursor: default;');
        });
    });
</script>