<!--div class="jumbotron bg-primary text-white">
    <div class="col-md-12">
        <br>
        <h1>Lifestyle Optimization</h1>
        <h3 style="font-size: 1.15rem !important;">Launching with the Ontario Cannabis Store</h3>
        <h3 style="font-size: 1.15rem !important;">Canada's leading activity and value-based strain selection tool for recreational cannabis users.
        </h3>
        <br>
    </div>
</div-->

<?php
    $multiple = $GLOBALS["settings"]["multiple"];
    $usetable = $GLOBALS["settings"]["usetable"];

    function getasarray($key) {
        $symptoms = array();
        if (isset($_GET[$key]) && $_GET[$key]) {
            $symptoms = $_GET[$key];
            if (!is_array($symptoms)) {
                $symptoms = explode(",", $symptoms);
            }
        }
        return $symptoms;
    }

    $effects = array();
    $symptoms = getasarray("symptoms");
    $activities = getasarray("activities");

    if (isset($_GET['effects']) && $_GET['effects']) {
        foreach ($_GET['effects'] as $ef) {
            $effects[] = $ef;
        }
    }

    $effectslist = Query("SELECT * FROM " . $usetable, true);// $this->requestAction('/pages/getSym');
?>

<script src="<?= $this->webroot; ?>js/raty.js"></script>
<script src="<?= $this->webroot; ?>js/labs.js"></script>
<link href="<?= $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>
<script>
    var recent_flag = 'ASC';
    var rated_flag = 'ASC';
    var alpha_flag = 'DESC';
    var viewed_flag = 'ASC';
    var reviewed_flag = 'ASC';
</script>

<div id="filter_dialog" class="modal" title="Filter Search">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php
                    $effect = $effectslist;
                    $counter = 0;
                    $second_div = 0;
                    foreach ($effect as $e) {
                        $counter++;
                        if ($counter == 1) {
                            echo "<div style='";
                            if ($second_div == 1) {
                                echo "float:right;";
                                $second_div = 0;
                            }
                            echo "width: 50%;display:inline-block;'>";
                        }
                        ?>
                        <div>
                            <a style="color:black;padding:2px;" href="<?php
                            if ($_SERVER["SERVER_NAME"] == "localhost" || $multiple) {//LOOK FOR ME!!!!
                                echo "javascript:void(" . $e['id'] . ");";
                            } else {
                                echo "?" . $usetable . "=" . $e['id'];
                            }
                            ?>" class="sym2 dialog_sym small-btn" data-parent="#dialog" id="sym_<?= $e['id']; ?>"><?= $e['title'] ?></a>
                        </div>
                        <?php
                        if ($counter == ceil(count($effect) / 2)) {
                            echo "</div>";
                            $counter = 0;
                            $second_div = 1;
                        }
                    }
                    if ($counter != 0) {
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<div class="jumbotron_top jumbotron" style="">
    <div class="text-center">
        <h1 style="font-size: 2.5rem !important;">Launching with the Ontario Cannabis Store</h1>
        <p class="pt-2 pb-3">Canada's leading activity and value-based strain selection tool for recreational cannabis users.</p>
    </div>

    <div class=" row ">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <div style="float:left;">
                        <img src="<?= $this->webroot; ?>images/IndicaIcon.png" alt="">
                    </div>
                    <div style="float:left;padding-left: 15px;padding-bottom: 15px;">
                        <h1>Indica</h1>
                        Night Time Use
                    </div>
                </div>
                <div class="col-md-4">

                    <div style="float:left;">
                        <img src="<?= $this->webroot; ?>images/SativaIcon.png" alt="">
                    </div>
                    <div style="float:left;padding-left: 15px;padding-bottom: 15px;">
                        <h1>Sativa</h1>
                        Day Time Use
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="float:left;">
                        <img src="<?= $this->webroot; ?>images/HybridIcon.png" alt="">
                    </div>
                    <div style="float:left;padding-left: 15px;padding-bottom: 15px;">
                        <h1>Hybrid</h1>
                        Best of Both Worlds
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<div class="jumbotron" style="">
    <div class="row">
        <div class="col-md-12">
            <h1>Filter By</h1>
            <?php
                $URL = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $types = [
                    "all_breed" => ["type" => "", "addtourl" => false, "title" => "All"],
                    "indica" => [],
                    "sativa" => [],
                    "hybrid" => [],
                ];
                foreach ($types as $ID => $data) {
                    echo '<a id="' . $ID . '" class="mr-1 mb-1 btn ';
                    if (!isset($data["type"])) {
                        $data["type"] = $ID;
                    }
                    if ($type == $data["type"]) {
                        echo 'btn-success';
                    } else {
                        echo 'btn-primary';
                    }
                    echo '" href="' . $this->webroot . 'strains/all';
                    if (!isset($data["addtourl"]) || $data["addtourl"]) {
                        echo '/' . $ID;
                    }
                    if (!isset($data["title"])) {
                        $data["title"] = ucfirst($ID);
                    }
                    if (isset($_GET['key'])) {
                        echo "?key=" . $_GET['key'];
                    }
                    echo '">#' . $data["title"] . '</a>';
                }
            ?>
            <div class="clearfix py-1"></div>
        </div>
        <!--div class="col-md-2">
        <ul class="">
            <li><p>Sort By</p></li>
        <?php
            $sorts = [
                "rated" => "Top Rated",
                "viewed" => "Most Viewed",
                "reviewed" => "Most Reviewed",
                "alpha" => "Alphabetically"
            ];
            foreach ($sorts as $ID => $sort) {
                echo '<li><a href="javascript:void(0)" class="eff1" id="' . $ID . '">' . $sort . '</a></li>';
            }
            $class = left($usetable, 3);
        ?>
        </ul>
    </div-->
        <div class="col-md-12">
            <div class="clearfix py-1"></div>
            <h1>Canbii Activity</h1>

            <a href="<?= $this->webroot; ?>strains/all" value="Reset Filter" class="<?= $class ?>2 btn btn-success mr-1 mb-1">All</a>
            <?php
                $effect = $effectslist;
                $counter = 0;
                foreach ($effect as $e) {
                    $counter++;
                    echo '<a style="" href="';
                    if ($_SERVER["SERVER_NAME"] == "localhost" || $multiple) {//LOOK FOR ME!!!!
                        echo "javascript:void(" . $e['id'] . ");";
                    } else {
                        echo "?" . $usetable . "=" . $e['id'];
                    }
                    echo '" class="' . $class . '2 btn btn-primary mr-1 mb-1" data-parent="#filter_desktop" id="' . $class . '_';
                    echo $e['id'] . '"> <span>#' . $e['title'] . '</span></a>';
                    if ($counter == ceil(count($effect) / 2)) {
                        $counter = 0;
                    }
                }
            ?>
            <p style="display: none;" class="symp"></p>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-md-12 pb-3">
        <h1>Online Store</h1>
    </div>
</div>

<div class="listing ">
    <?php include_once('combine/filter.php'); ?>
</div>

<input type="hidden" class="recent" value="ASC"/>
<input type="hidden" class="rated" value="ASC"/>
<input type="hidden" class="viewed" value="ASC"/>
<input type="hidden" class="reviewed" value="ASC"/>
<input type="hidden" class="alpha" value="DESC"/>
<input type="hidden" class="sativa" value="DESC"/>
<input type="hidden" class="indica" value="DESC"/>
<input type="hidden" class="hybrid" value="DESC"/>
<div class="clearfix"></div>

<script>
    var loading = '<DIV ALIGN="CENTER" ID="spinner">Now Loading...<P><IMG SRC="<?= $this->webroot; ?>img/spinner.gif"></DIV>';
    var more = '<?= $GLOBALS["settings"]["limit"]; ?>';
    var spinnerVisible = false;
    var val = '';
    var currentlisting = "";

    function toggleclass(element){
        if($(element).hasClass('btn-primary')) {
            $(element).removeClass('btn-primary');
            $(element).addClass('btn-success');
            return false;
        } else {
            $(element).removeClass('btn-success');
            $(element).addClass('btn-primary');
            return true;
        }
    }

    function showspinner() {
        if (!spinnerVisible) {
            $('.morelist').html(loading);
            $("#spinner").fadeIn("fast");
            spinnerVisible = true;
        }
    }

    function hidespinner() {
        if (spinnerVisible) {
            $('.morelist').html('');
            var spinner = $("#spinner");
            spinner.stop();
            spinner.fadeOut("fast");
            spinnerVisible = false;
        }
    }

    $(function () {
        if ($(document).width() <= 479) {
            $(".page_header_right").css({"width": "300px"});
        }

        var profile = '';
        $('.hidden_filter select').change(function () {
            profile = '';
            val = '';
            $('.hidden_filter select').each(function () {
                var value = $(this).val();
                if (value) {
                    var field = $(this).attr('name');
                    if (!profile) {
                        profile = field + '=' + value;
                    } else {
                        profile = profile + '&' + field + '=' + value;
                        //alert(profile);
                    }
                }

            });
            doquery(0, false, "hidden_filter select");
        });

        function appendtoquery(query, text) {
            if (query) {
                return query + "&" + text;
            }
            return text;
        }

        var limit = 0;

        function doquery(more, showmore, tag) {
            showspinner();
            var val = {effects: [], symptoms: [], activities: []};
            var i = 0;
            $('.effs').each(function () {
                if ($(this).val()) {
                    val.effects.push($(this).val());
                }
            });
            $('.symp .symps').each(function () {
                if ($(this).val()) {
                    val.symptoms.push($(this).val());
                }
            });
            $('.symp .acts').each(function () {
                if ($(this).val()) {
                    val.activities.push($(this).val());
                }
            });

            //val = appendtoquery(val, 'key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>');
            val.key = '<?php if (isset($_GET['key'])) echo $_GET['key'];?>';

            $('.eff1c').each(function () {
                //alert('test');
                var id = $(this).attr('id');
                var sort = $('.' + id).val();
                if (sort != 'DESC') {
                    sort = 'ASC';
                }
                //val = appendtoquery(val, 'sort=' + id + '&order=' + sort);
                val.sort = id;
                val.order = sort;
            });

            if (profile) {
                //val = appendtoquery(val, profile);
                $.extend(true, val, profile);
            }

            if (sort && sortid) {
                if ((sortid != 'indica' && sortid != 'sativa' && sortid != 'hybrid') || sort == 'ASC') {
                    //val = appendtoquery(val, 'sort=' + sortid + '&order=' + sort);
                    val.sort = sortid;
                    val.order = sort;
                }
            }

            val.table = "<?= $usetable; ?>";
            limit += <?= $GLOBALS["settings"]["limit"]; ?>;
            val.limit = limit;
            //log("ATTEMPTING POST TO: <?= $this->webroot; ?>strains/filter/" + more + '<?php if ($type) {
            echo '/' . $type;
        } ?>');
            //log(JSON.stringify(val));
            $.ajax({
                url: '<?= $this->webroot; ?>strains/filter/' + more + '<?php if ($type) {
                    echo '/' . $type;
                } ?>',
                data: val,
                type: 'POST',
                success: function (res) {
                 //   log("TAG: " + tag + " showmore: " + showmore + " more: " + more + " val: " + val + " limit: " + limit);

                    $('#indica').attr('href', '<?= $this->webroot;?>strains/all/indica?' + val);
                    $('#sativa').attr('href', '<?= $this->webroot;?>strains/all/sativa?' + val);
                    $('#hybrid').attr('href', '<?= $this->webroot;?>strains/all/hybrid?' + val);
                    $('#all_breed').attr('href', '<?= $this->webroot;?>strains/all?' + val);
                    hidespinner();
                    if (showmore) {
                        //$('.listing').append('' + res);

                        $('.morelist').show();
                        $('.morelist').addClass('morelist2');
                        $('.morelist2').removeClass('morelist');
                        $('.morelist2').html(res);
                        $('.morelist2').removeClass('morelist2');

                        scrolltobottom();

                    } else {
                        $('.listing').html(res);
                    }
                }
            });
        }

        var sort = '';
        var sortid = '';
        $('.loadmore a').live('click', function () {
            more = parseFloat(more);
            doquery(more, true, "loadmore.click");
            more += <?= $GLOBALS["settings"]["limit"]; ?>;
        });

        function filternonnumeric(myString) {
            return myString.replace(/\D/g, '');
        }

        $('.sym2, .act2').click(function () {
            var val = "";
            more = 0;
            var eletype = "symptoms";
            var eleclass = "symps";
            var ID = $(this).attr("id");
            if ($(this).hasClass("act2")) {
                eletype = "activities";
                eleclass = "acts";
            }
            var test = toggleclass(this);


            //  log("Testing: " + test);
            if (test) {
                $("#filter_desktop #" + ID).removeClass('searchact3');
                $("#filter_dialog #" + ID).removeClass('searchact3');
                $('#in_' + eleclass + ID).remove();
            } else {
                $("#filter_desktop #" + ID).addClass('searchact3');
                $("#filter_dialog #" + ID).addClass('searchact3');
                $('.symp').append('<input ID="in_' + eleclass + ID + '" type="hidden" name="' + eletype + '[]" value="' + filternonnumeric(ID) + '" class="' + eleclass + ' check' + ID + ' ' + eleclass + ID + '"  />')
            }
            if (($("#filter_dialog").data('bs.modal') || {}).isShown) {
                $("#filter_dialog").modal('hide');
            }

            $('.key').val('');

            doquery(0, false, "sym2, .act2.click");
            $('#rated').click();
        });

        $('.eff2').click(function () {
            more = 0;
            //var sort =0;
            if ($(this).attr('class').replace('searchact2', '') == $(this).attr('class')) {
                $(this).addClass('searchact2');
                $('.effe').append('<input type="hidden" name="effects[]" value="' + $(this).attr('id').replace('eff_', '') + '" class="effs ' + $(this).attr('id') + '"  />')
            } else {
                $(this).removeClass('searchact2');
                $('.' + $(this).attr('id')).remove();
            }
            $('.key').val('');
            doquery(0, false, "eff2.click");
        });

        $('.eff1').click(function () {
            var thisid = $(this).attr('id');
            if (thisid == 'indica' || thisid == 'sativa' || thisid == 'hybrid') {
                var typefilter = 1;
            } else {
                var typefilter = 0;
            }
            more = 0;
            $('.eff1').each(function () {
                $(this).removeClass('eff1c');
                $(this).removeClass('searchact');
            });
            $(this).addClass('eff1c');
            sortid = $(this).attr('id');
            sort = $('.' + sortid).val();
            if (sort == 'ASC') {
                sort = 'DESC';
                $('.' + sortid).val('DESC');
            } else {
                sort = 'ASC';
                $('.' + sortid).val('ASC');
            }
            if ((sortid != 'indica' && sortid != 'sativa' && sortid != 'hybrid') || sort == 'ASC') {
                $(this).addClass('searchact');
            }
            doquery(0, false, "eff1.click");
        });

        $(".dialog_sym").click(function () {
            document.body.style.overflow = "visible";
            $("#filter_dialog").hide();
        });

        <?php
            if ($effects) {
                foreach ($effects as $eff) {
                    echo PHP_EOL . "$('#eff_" . $eff . "').click();";
                }
            }
            if ($activities) {
                foreach ($activities as $act) {
                    echo PHP_EOL . "$('#act_" . $act . "').click();";
                }
            }
            if ($symptoms) {
                foreach ($symptoms as $eff) {
                    echo PHP_EOL . "$('#filter_dialog #sym_" . $eff . "').click();";
                }
            }
            if (isset($_GET['sort']) && $_GET['sort']) {
                echo PHP_EOL . "$('#" . str_replace('reviewed', 'viewed', $_GET['sort']) . "').click();";
            }
        ?>
    });
</script>