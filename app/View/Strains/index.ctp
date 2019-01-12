<script src="<?= $this->webroot; ?>js/raty.js"></script>
<script src="<?= $this->webroot; ?>js/labs.js"></script>
<link href="<?= $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>
<link href="<?= $this->webroot; ?>css/layout.css" rel="stylesheet" type="text/css" title="progress bar"/>
<script src="<?= $this->webroot; ?>js/bootstrap.min.js"></script>
<script src="<?= $this->webroot; ?>js/html2canvas.js"></script>
<script type="text/javascript" src="<?= $this->webroot; ?>js/jquery.plugin.html2canvas.js"></script>


<?php
    echo "<Strain id='" . $strain['Strain']['id'] . "' />";
    function iif($value, $true, $false = ""){
        if ($value) {
            return $true;
        }
        return $false;
    }


    function progressbar($webroot, $value, $textL = "", $textR = "", $color = "success", $color2 = "", $striped = false, $active = false, $min = 0, $max = 100) {
        if (false) {
            echo '<div width: ';
            echo (round($value, 2) > 100) ? 100 : round($value, 2);
            echo '%;height:25px;position: absolute;left:0;"/><em>' . round($value / 20, 2);
            echo '/5</em></div><div ></div>';
        } else {
            if ($textL) {
                echo '<div >' . $textL . '</div>';
            }
            echo '</div><div >';
            echo '<img src="' . $webroot . 'images/bar_chart/' . $color2 . '.png" style="width: ';
            echo (round($value, 2) > 100) ? 100 : round($value, 2);
            echo '%;height:20px;"/>';

            echo "</div>";
            return;
            echo '<div class="progress-bar progress-bar-';
            echo $color . '" role="progressbar" aria-valuenow="' . $value . '" aria-valuemin="' . $min . '" aria-valuemax="' . $max . '" style="';
            echo 'width: ' . round($value / ($max - $min) * 100) . '%"><div d>' . $textR . '</div></div></div>';
        }

    }

    function perc($scale) {
        return round($scale / 20, 2) . "/5";
    }
?>

<div >
    <div  >
        <div  >
            <?php
                $strain_hexagon = $strain;
                if (isset($s)) {
                    echo '<a href="' . $this->webroot . 'strains/' . $s['Strain']['slug'] . '">';
                    include('combine/hexagon.php');
                    echo '</a>';
                }
            ?>

            <div >
                <h1><?= $strain['Strain']['name']; ?> - Report</h1>
                
                <p ><?php
                        switch ($strain['Strain']['type_id']) {
                            case 1:
                                echo "Indica Cannabis: Best suited for night time use.";
                                break;
                            case 2:
                                echo "Sativa Cannabis: Best suited for day time use.";
                                break;
                            case 3:
                                echo "Hybrid Cannabis";
                                break;
                        }
                    ?>
                </p>
            </div>

            <!--li  >
                <p>
                    <?php
                        switch ($strain['Strain']['type_id']) {
                            case 1:
                                echo "Indica Cannabis: Best suited for night time use.";
                                break;
                            case 2:
                                echo "Sativa Cannabis: Best suited for day time use.";
                                break;
                            case 3:
                                echo "Hybrid Cannabis: Suited for day or night time use.";
                                break;
                        }
                    ?>
                </p>
            </li-->

        </div>

    </div>


    <div >
        <ul>
            <li>
                <p><?= strip_tags(html_entity_decode($strain['Strain']['description'])); ?></p>
            </li>
        </ul>
    </div>

    <div ></div>



    <ul >
        <li >
            <div>
                <h3 >Symptoms</h3>
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
                        $symptom_rate = $this->requestAction('/strains/getSymptomRate/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
                        //var_dump($symptom_rate);
                        $cnt = 0;
                        $eff_id = 0;
                        $total_rate = 0;
                        foreach ($symptom_rate as $er) {
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
                    }else {
                        $arrs = array();
                    }
                    //var_dump($arr);
                    $i = 0;
                    if ($arrs) {
                    foreach ($arrs as $e) {
                        $ars = explode('_', $e);
                        $i++;
                        if ($i == 16) {
                            break;
                        }
                        $rate = $ars[0];
                        $length = 20 * $rate;;
                ?>
                <div >
                    <div  >
                        <span ><?= $this->requestAction('/strains/getSymptom/' . $ars[1]); ?></span>
                        <?php progressbar($this->webroot, $length, perc($length), "", "info", "light-blue"); ?>

                    </div>
                    <?php
                        }
                    } else {
                        ?>
                        <i>
                            <a href="<?= $this->webroot; ?>review/add/<?= $strain['Strain']['slug']; ?>">
                                No ratings yet. Review this strain
                                <i ></i>
                            </a>
                        </i>
                    <?php
                    }
                    ?>
                </div>
                <div ></div>
        </li>


        <li >
            <div>
                <h3 >General Ratings</h3>
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

                <div >
                    <div  >Sedative
                        <?php progressbar($this->webroot, $scale, perc($scale), "", "warning", "light-purple"); ?>
                    </div>
                    <?php
                        }
                        if ($strength) {
                    ?>
                    <div >
                        <div  >
                            Strength
                            <?php progressbar($this->webroot, $strength, perc($strength), "", "warning", "light-purple"); ?>
                        </div>
                        <?php
                            }
                            if ($duration) {
                        ?>
                        <div >
                            <div  >
                                Duration
                                <?php progressbar($this->webroot, $duration, perc($duration), "", "warning", "light-purple"); ?>
                            </div>
                            <?php
                                }
                                if (!$duration && !$strength && !$scale) {
                                    ?>
                                    <i>
                                        <a href="<?= $this->webroot; ?>review/add/<?= $strain['Strain']['slug']; ?>">
                                            No ratings yet. Review this strain
                                            <i ></i>
                                        </a>
                                    </i>
                                <?php
                                }
                            ?>

                        </div>
                        <div class="">
                <h3>Effects:</h3>
                
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
                                foreach ($strain['OverallEffectRating'] as $oer) {
                                    if ($this->requestAction('/strains/getPosEff/' . $oer['effect_id'])) {
                                        $arr[] = $oer['rate'] . '_' . $oer['effect_id'];
                                    }else {
                                        $arr_neg[] = $oer['rate'] . '_' . $oer['effect_id'];
                                    }
                                }
                            } else {
                                $effect_rate = $this->requestAction('/strains/getEffectRate/' . urlencode($profile_filter) . '/' . $strain['Strain']['id']);
                                //var_dump($effect_rate);
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
                                            }else {
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

                                //die('here');
                            }
                            //die('there');
                            if (isset($arr)) {
                                rsort($arr);
                            }else {
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
                                    $length = 20 * $rate;;
                                    ?>
                <div >
                    <div
                         ><?= $this->requestAction('/strains/getEffect/' . $ar[1]); ?>
                        <?php progressbar($this->webroot, $length, perc($length), "", "success", "light-green"); ?>
                    </div>
                    <?php
                                }
                            } else {
                                ?>


                        <i>  <a href="<?= $this->webroot; ?>review/add/<?= $strain['Strain']['slug']; ?>"> No ratings yet. Review this
                                strain <i
                                          ></i></a></i>

                    <?php
                            }
                        ?>
                </div>


                        <div>
                            <h3 >Negative Effects</h3>
                            <p>What are the negative effects?</p>
                            
                            <?php
                                if (isset($arr_neg)) {
                                    rsort($arr_neg);
                                }else {
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
                            ?>
                            <div >
                                <div  >
                                    <span ><?= $this->requestAction('/strains/getEffect/' . $ar[1]); ?></span>
                                    <?php progressbar($this->webroot, $length, perc($length), "", "danger", "light-red"); ?>
                                </div>
                                <?php
                                    }
                                    } else {
                                    ?>
                                    <i>
                                        <a href="<?= $this->webroot; ?>review/add/<?= $strain['Strain']['slug']; ?>">
                                            No ratings yet. Review this strain
                                            <i ></i>
                                        </a>
                                    </i>
                                <?php
                                }
                                ?>
                            </div>





        </li>


    </ul>


    <div  ></div>
    <ul >

        <li >
            <h3  > Most Helpful User Review</h3>
            <!--h2 >Dominant Color(s)</h2>
            <div >
                <?php
                    $c = $this->requestAction('/strains/getcolors/' . $strain['Strain']['id']);
                    foreach ($c as $col) {
                        if ($col['ReviewColor']['color'] != "") {
                            ?>

                                <div   display: inline-block;
                                    float:left;width: 25px; height: 25px;padding:0;margin:0;clear:none;background:<?= $col['ReviewColor']['color']; ?>;">
                                    &nbsp;</div>
                            <?php
                        }
                    }
            ?>
            </div-->

            <?php include_once('combine/strain_reviews.php'); ?>

            <script type="text/javascript">
                $(document).ready(function () {
                    $(".fancybox").fancybox();
                });
            </script>

            <div ></div>

            <a href="<?= $this->webroot; ?>strains/review/<?= $strain['Strain']['slug']; ?>"  >
                See All Reviews for <?= $strain['Strain']['name']; ?> &raquo;
            </a>

        </li>


        <li >
            <h3 ><?= $strain['Strain']['name']; ?> Images</h3>

            <!--table>
                <tr>
                <?php
                    $breaker = 0;
                    for ($i = 1; $i < 5; $i++) {
                        $image = "images/strains/" . $strain['Strain']['id'] . "/" . $strain['Strain']['slug'] . "_" . $i . ".jpg";
                        $filename = getcwd() . "/" . $image; //C:\wamp\www\marijuana\app\webroot
                        $image = $this->webroot . $image;
                        if (!file_exists($filename) && file_exists(str_replace(".jpg", ".jpeg", $filename))) {
                            $image = str_replace(".jpg", ".jpeg", $image);
                            $filename = str_replace(".jpg", ".jpeg", $filename);
                        }
                        if (file_exists($filename)) {
                            $breaker++;
                            if ($breaker == 2) {
                                echo "</tr><tr>";
                            }
                        }
                    }
                ?>
                </tr>
            </table-->
            <?php include('combine/images.php'); ?>
        </li>
    </ul>
    <ul >
        <li ></li>
        <li ></li>
    </ul>
</div>


<script>
    function takeScreenShot() {
        html2canvas(window.parent.document.body, {
            onrendered: function (canvas) {
                var cand = document.getElementsByTagName('canvas');
                if (cand[0] === undefined || cand[0] === null) {

                } else {
                    //cand[0].remove();
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

        //$('#target').html2canvas({
        //    onrendered: function (canvas) {

        //Set hidden field's value to image data (base-64 string)
        //$('#img_val').val(canvas.toDataURL("image/png"));
        //Submit the form manually
        //document.getElementById("myForm").submit();
        //   }
        //});
    }
</script>

<script>
    $(function () {
        var makeVote =function(data){
            symp = data.id;

            up= data.upvoted;
            down= data.downvoted;
            console.log(up);

            setZero = true;

            $.each(data.classList,function(i,e){
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
                url: "<?= Router::url(array('controller' => 'symptomvote', 'action' => 'sendVote'));?>/<?= $strain['Strain']['id'] ?>/"+symp,
                data: {up: up, down: down},
                success:function(response){
                    console.log(response);
                }
            });

            //}
        };
        $('div.upvote').each(function(i,e){
            $(this).upvote({ele:$(this),classList:$(this).find("a"),id:$(this).find(".vote_symp").val(),callback:makeVote});
        });

        //$(".upvote a.upvote").click(function(){
        //    makeVote($(this),1);
        //});
        //$(".upvote a.downvote").click(function(){
        //    makeVote($(this),0);
        //});
        <?php
            if(!$p_filter) {
                $rate = $strain['Strain']['rating'];
            } else {
                $effect_reviews = $this->requestAction('/strains/getEffectReview/'.urlencode($profile_filter).'/'.$strain['Strain']['id']);
                $count_rate=0;
                $rate = 0;
                foreach($effect_reviews as $oar) {
                    if($oar['Review']['rate']==0){
                        continue;
                    }else{
                        $count_rate++;
                        $rate = $rate+$oar['Review']['rate'];
                    }
                }
                if($count_rate==0){
                    $rate = 0;
                } else {
                    $rate = $rate/$count_rate;
                }
                $rate = number_format($rate,2);
            }
        ?>
        $('.rating').raty({number: 5, readOnly: true, score:<?= $rate;?>});

        <?php if($helpful){?>
        $('.frate').raty({readOnly: true, score:<?= $helpful['Review']['rate'];?>});
        $('.srate').raty({readOnly: true, score:<?= $recent['Review']['rate'];?>});
        <?php }?>
        $('.emotion').text('<?= ($strain['Strain']['rating']).'/5';?> ');
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
                    url: '<?= $this->webroot;?>strains/helpful/' + r_id + '/no',
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


<style>
    @media print {
        .eff.symps{margin-bottom:0px!important;}
        .page_layout{border:2px solid #e5e5e5;padding:10px}
        .strain_banner{width:320px!important;}
        li.column_left{width:464px!important;}
        li.column_right{width:464px!important;}
        .header_container {
            display: none;
            margin-left: auto;
            margin-right: auto;
        }

        .footer_container {
            display: none;
        }

        .cake-sql-log {
            display: none;
        }

        .footer_banner_box_container {
            display: none;
        }

        .print {
            display: none
        }
    }

    .page_header{padding-bottom:10px!important;}

    .eff .left {
        position: relative;
    }

    .eff em {
        z-index: 10000;
        text-align: center;
        position: relative;
        top: 6px;
    }

    em {
        letter-spacing: 2px;
        font-style: normal;
    }

    .ratewrap {
        width: 63%;
        /*background: #fff;*/
        text-align: center;
        height: 25px;
    }

    .length {
        padding-top: 25px;
        background: #42B3E5;
        position: absolute;
        top: 0;
    }

    @media print {
        .page_layout{font-size:20px!important;}
        .page_header_right a{display:none;}
        .toprint{display: block!important;}
        .noprint {
            display: none;
        }

        .printer {
            color: #FFF;
            text-shadow: 0 0 0 #ccc;
        }

        @media print and (-webkit-min-device-pixel-ratio: 0) {
            .printer {
                color: #FFF;
                -webkit-print-color-adjust: exact;
            }
        }
    }
</style>