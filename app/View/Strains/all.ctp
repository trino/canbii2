<script src="<?= $this->webroot; ?>js/raty.js"></script>
<script src="<?= $this->webroot; ?>js/labs.js"></script>
<link href="<?= $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>

<?php
if (isset($_GET['effects']) && $_GET['effects']) {
    foreach ($_GET['effects'] as $ef) {
        $effects[] = $ef;
    }
} else {
    $effects = array();
}

if (isset($_GET['symptoms']) && $_GET['symptoms']) {
    $symptoms = $_GET['symptoms'];
    if (!is_array($symptoms)) {
        $symptoms = explode(",", $symptoms);
    }

} else {
    $symptoms = array();
}
?>
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
                $effect = $this->requestAction('/pages/getSym');
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
                        $multiple = true;//disable for single queries only
                        if ($_SERVER["SERVER_NAME"] == "localhost" || $multiple) {//LOOK FOR ME!!!!
                            echo "javascript:void(";
                            echo $e['Symptom']['id'];
                            echo ");";
                        } else {
                            echo "?symptoms=";
                            echo $e['Symptom']['id'];
                        }
                        ?>" class="sym2 dialog_sym small-btn" data-parent="#dialog"
                           id="sym_<?php echo $e['Symptom']['id']; ?>"><?php echo $e['Symptom']['title'] ?></a>
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
<div class="page_layout page_margin_top clearx">
    <div style="padding-bottom: 10px;border-bottom:0;" class="page_header clearfix">
        <div class="page_header_left" id="by">


            <ul class="tabs_navigation2">
                <li><p>Filter By:</p></li>

                <li>
                    <a id="all_breed"
                       <?php if ($type == ''){ ?>style="border-bottom:2px solid #1b83c6 !important;"<?php } ?>
                       href="<?= $this->webroot; ?>strains/all<?php if (isset($_GET['key'])) echo "?key=" . $_GET['key']; ?>">
                        All</a>
                </li>

                <li>
                    <a id="indica"
                       <?php if ($type == 'indica'){ ?>style="border-bottom:2px solid #1b83c6 !important;"<?php } ?>
                       href="<?= $this->webroot; ?>strains/all/indica<?php if (isset($_GET['key'])) echo "?key=" . $_GET['key']; ?>">
                        Indica</a>
                </li>

                <li>
                    <a id="sativa"
                       <?php if ($type == 'sativa'){ ?>style="border-bottom:2px solid #1b83c6 !important;"<?php } ?>
                       href="<?= $this->webroot; ?>strains/all/sativa<?php if (isset($_GET['key'])) echo "?key=" . $_GET['key']; ?>">
                        Sativa</a>
                </li>

                <li>
                    <a id="hybrid"
                       <?php if ($type == 'hybrid'){ ?>style="border-bottom:2px solid #1b83c6 !important;"<?php } ?>
                       href="<?= $this->webroot; ?>strains/all/hybrid<?php if (isset($_GET['key'])) echo "?key=" . $_GET['key']; ?>">
                        Hybrid</a>
                </li>

                <div class="clearfix"></div>
            </ul>


            <br/>


            <ul class="tabs_navigation2">
                <li><p>Sort By:</p></li>

                <li>
                    <a href="javascript:void(0)" class="eff1" id="rated">Top Rated</a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="eff1" id="viewed">Most Viewed</a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="eff1" id="reviewed">Most Reviewed</a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="eff1" id="alpha">Alphabetically</a>
                </li>
                <div class="clearfix"></div>
            </ul>

        </div>



            <input id="BUTTON_18" type="reset" value="Reset Filter" class="more blue medium"
                 onclick="window.location='<?php echo $this->webroot; ?>strains/all';"/>

                    <h3>Filter</h3>
                    <br>


                            <?php
                            $effect = $this->requestAction('/pages/getSym');
                            $counter = 0;
                            foreach ($effect as $e) {
                                $counter++;
                                if ($counter == 1) {

                                }
                                ?>

                                    <a style="padding:2px;" href="<?php
                                    $multiple = true;//disable for single queries only
                                    if ($_SERVER["SERVER_NAME"] == "localhost" || $multiple) {//LOOK FOR ME!!!!
                                        echo "javascript:void(";
                                        echo $e['Symptom']['id'];
                                        echo ");";
                                    } else {
                                        echo "?symptoms=";
                                        echo $e['Symptom']['id'];
                                    }
                                    ?>" class="sym2 small-btn" data-parent="#filter_desktop"
                                       id="sym_<?= $e['Symptom']['id']; ?>"><?= $e['Symptom']['title'] ?></a>
                                <?php
                                if ($counter == ceil(count($effect) / 2)) {

                                    $counter = 0;
                                }
                            }
                            if ($counter != 0) {

                            }
                            ?>
                            <p style="display: none;" class="symp"></p>




        <div class="page_left listing ">
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
    var loading = '<DIV ALIGN="CENTER">Now Loading...<P><IMG SRC="<?= $this->webroot; ?>img/spinner.gif"></DIV>';
    var more = '<?= $limit; ?>';
    var spinnerVisible = false;
    var val = '';

    function showspinner() {
        $('.listing').html(loading);
        //$("div#spinner").fadeIn("fast");
        //spinnerVisible = true;
    }

    function hidespinner() {

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
            if (!spinnerVisible) {
                showspinner();
            }
            var i = 0;

            $('.effs').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'effects[]=' + $(this).val();
                    } else {
                        val = val + '&effects[]=' + $(this).val();
                    }
                }
            });

            $('.symp .symps').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'symptoms[]=' + $(this).val();
                    } else {
                        val = val + '&symptoms[]=' + $(this).val();
                    }
                }
            });

            if (val) {
                val = val + '&key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            } else {
                val = 'key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            }

            $('.eff1c').each(function () {
                //alert('test');
                var id = $(this).attr('id');
                var sort = $('.' + id).val();
                if (sort == 'DESC') {
                    sort = 'DESC';
                    //$('.'+id).val('DESC');
                } else {
                    sort = 'ASC';
                    // $('.'+id).val('ASC');
                }
                val = val + '&sort=' + id + '&order=' + sort;
            });
            if (profile && val) {
                val = val + '&' + profile;
            } else {
                val = profile;
            }
            showspinner();//$('.listing').html(loading);
            $.ajax({
                url: '<?php echo $this->webroot . "strains/filter/0"; if ($type) {
                    echo '/' . $type;
                } ?>',
                data: val,
                type: 'get',
                success: function (res) {
                    $('#indica').attr('href', '<?php echo $this->webroot;?>strains/all/indica?' + val);
                    $('#sativa').attr('href', '<?php echo $this->webroot;?>strains/all/sativa?' + val);
                    $('#hybrid').attr('href', '<?php echo $this->webroot;?>strains/all/hybrid?' + val);
                    $('#all_breed').attr('href', '<?php echo $this->webroot;?>strains/all?' + val);
                    if (spinnerVisible) {
                        var spinner = $("div#spinner");
                        spinner.stop();
                        spinner.fadeOut("fast");
                        spinnerVisible = false;
                    }
                    $('.listing').html(res);
                }
            });
        });

        var sort = '';
        $('.loadmore a').live('click', function () {
            more = parseFloat(more) + 8;
            var val = '';
            var i = 0;
            $('.effs').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'effects[]=' + $(this).val();
                    } else {
                        val = val + '&effects[]=' + $(this).val();
                    }
                }

            });
            $('.symp .symps').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'symptoms[]=' + $(this).val();
                    } else {
                        val = val + '&symptoms[]=' + $(this).val();
                    }
                }
            });
            if (val) {
                val = val + '&key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            } else {
                val = 'key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            }

            $('.eff1c').each(function () {
                //alert('test');
                var id = $(this).attr('id');
                var sort = $('.' + id).val();
                if (sort == 'DESC') {
                    sort = 'DESC';
                    //$('.'+id).val('DESC');
                } else {
                    sort = 'ASC';
                    // $('.'+id).val('ASC');
                }
                val = val + '&sort=' + id + '&order=' + sort;
            });

            if (profile) {
                val = val + '&' + profile;
            }
            //showspinner();//$('.listing').html(loading);
            $.ajax({
                url: '<?= $this->webroot;?>strains/filter/' + more + '<?php if ($type) {
                    echo '/' . $type;
                } ?>',
                data: val,
                type: 'get',
                success: function (res) {
                    $('#indica').attr('href', '<?= $this->webroot;?>strains/all/indica?' + val);
                    $('#sativa').attr('href', '<?= $this->webroot;?>strains/all/sativa?' + val);
                    $('#hybrid').attr('href', '<?= $this->webroot;?>strains/all/hybrid?' + val);
                    $('#all_breed').attr('href', '<?= $this->webroot;?>strains/all?' + val);
                    if (spinnerVisible) {
                        var spinner = $("div#spinner");
                        spinner.stop();
                        spinner.fadeOut("fast");
                        spinnerVisible = false;
                    }
                    $('.morelist').show();
                    $('.morelist').addClass('morelist2');
                    $('.morelist2').removeClass('morelist');
                    $('.morelist2').html(res);
                    $('.morelist2').removeClass('morelist2');
                }
            });
        });


        $('.sym2').click(function () {
            //alert(profile);
            val = "";
            //var sort =0;
            more = 0;

            if ($(this).attr('class').replace('searchact3', '') == $(this).attr('class')) {
                $("#filter_desktop #" + $(this).attr("id")).addClass('searchact3');
                $("#filter_dialog #" + $(this).attr("id")).addClass('searchact3');
                $('.symp').append('<input type="hidden" name="symptoms[]" value="' + $(this).attr('id').replace('sym_', '') + '" class="symps check' + $(this).attr('id') + ' ' + $(this).attr('id') + '"  />')
            } else {
                $("#filter_desktop #" + $(this).attr("id")).removeClass('searchact3');
                $("#filter_dialog #" + $(this).attr("id")).removeClass('searchact3');
                $('.' + $(this).attr('id')).remove();
            }
            if (($("#filter_dialog").data('bs.modal') || {}).isShown) {
                $("#filter_dialog").modal('hide');
            }

            $('.key').val('');

            /*else
             var sort = 1;*/
            if (!spinnerVisible) {
                $("div#spinner").fadeIn("fast");
                spinnerVisible = true;
            }
            var i = 0;

            $('.effs').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'effects=' + $(this).val();
                    } else {
                        val = val + ',' + $(this).val();
                    }
                }
            });

            $('.symp .symps').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'symptoms=' + $(this).val();
                    } else {
                        val = val + ',' + $(this).val();
                    }
                }
            });

            if (val) {
                val = val + '&key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            } else {
                val = 'key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            }

            $('.eff1c').each(function () {
                //alert('test');
                var id = $(this).attr('id');
                var sort = $('.' + id).val();
                if (sort == 'DESC') {
                    sort = 'DESC';
                    //$('.'+id).val('DESC');
                } else {
                    sort = 'ASC';
                    // $('.'+id).val('ASC');
                }
                val = val + '&sort=' + id + '&order=' + sort;
            });

            if (profile) {
                val = val + '&' + profile;
            }
            showspinner();//$('.listing').html(loading);
            $.ajax({
                url: '<?= $this->webroot;?>strains/filter/0<?php if ($type) echo '/' . $type?>',
                data: val,
                type: 'get',
                success: function (res) {
                    //alert(val);
                    $('#indica').attr('href', '<?= $this->webroot;?>strains/all/indica?' + val);
                    $('#sativa').attr('href', '<?= $this->webroot;?>strains/all/sativa?' + val);
                    $('#hybrid').attr('href', '<?= $this->webroot;?>strains/all/hybrid?' + val);
                    $('#all_breed').attr('href', '<?= $this->webroot;?>strains/all?' + val);
                    if (spinnerVisible) {
                        var spinner = $("div#spinner");
                        spinner.stop();
                        spinner.fadeOut("fast");
                        spinnerVisible = false;
                    }
                    $('.listing').html(res);
                }
            });

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
            /*else
             var sort = 1;*/
            if (!spinnerVisible) {
                $("div#spinner").fadeIn("fast");
                spinnerVisible = true;
            }
            var i = 0;
            var val = '';
            $('.effs').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'effects[]=' + $(this).val();
                    } else {
                        val = val + '&effects[]=' + $(this).val();
                    }
                }
            });

            $('.symp .symps').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'symptoms[]=' + $(this).val();
                    } else {
                        val = val + '&symptoms[]=' + $(this).val();
                    }
                }
            });

            if (val) {
                val = val + '&key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            } else {
                val = 'key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            }

            $('.eff1c').each(function () {
                //alert('test');
                var id = $(this).attr('id');
                var sort = $('.' + id).val();
                if (sort == 'DESC') {
                    sort = 'DESC';
                    //$('.'+id).val('DESC');
                } else {
                    sort = 'ASC';
                    // $('.'+id).val('ASC');
                }
                val = val + '&sort=' + id + '&order=' + sort;
            });

            if (profile) {
                val = val + '&' + profile;
            }
            showspinner();//$('.listing').html(loading);
            $.ajax({
                url: '<?= $this->webroot;?>strains/filter<?php if ($type) {
                    echo '/0/' . $type;
                } ?>',
                data: val,
                type: 'get',
                success: function (res) {
                    $('#indica').attr('href', '<?= $this->webroot;?>strains/all/indica?' + val);
                    $('#sativa').attr('href', '<?= $this->webroot;?>strains/all/sativa?' + val);
                    $('#hybrid').attr('href', '<?= $this->webroot;?>strains/all/hybrid?' + val);
                    $('#all_breed').attr('href', '<?= $this->webroot;?>strains/all?' + val);
                    if (spinnerVisible) {
                        hidespinner();
                    }
                    $('.listing').html(res);
                }
            });
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
            var id = $(this).attr('id');
            var sort = $('.' + id).val();
            if (sort == 'ASC') {
                sort = 'DESC';
                $('.' + id).val('DESC');
            } else {
                sort = 'ASC';
                $('.' + id).val('ASC');
            }
            if ((id != 'indica' && id != 'sativa' && id != 'hybrid') || sort == 'ASC') {
                $(this).addClass('searchact');
            }

            if (!spinnerVisible) {
                showspinner();
            }
            var i = 0;
            var val = '';
            $('.effs').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'effects[]=' + $(this).val();
                    } else {
                        val = val + '&effects[]=' + $(this).val();
                    }
                }
            });

            $('.symp .symps').each(function () {
                if ($(this).val()) {
                    i++;
                    if (i == 1) {
                        val = 'symptoms[]=' + $(this).val();
                    } else {
                        val = val + '&symptoms[]=' + $(this).val();
                    }
                }
            });
            if (val) {
                val = val + '&key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            } else {
                val = 'key=<?php if (isset($_GET['key'])) echo $_GET['key'];?>';
            }
            if (sort) {
                if ((id != 'indica' && id != 'sativa' && id != 'hybrid') || sort == 'ASC') {
                    val = val + '&sort=' + id + '&order=' + sort;
                }
            }
            if (profile) {
                val = val + '&' + profile;
            }
            showspinner();//$('.listing').html(loading);
            $.ajax({
                url: '<?= $this->webroot;?>strains/filter<?php if ($type) {
                    echo '/0/' . $type;
                } ?>',
                data: val,
                type: 'get',
                success: function (res) {
                    $('#indica').attr('href', '<?= $this->webroot;?>strains/all/indica?' + val);
                    $('#sativa').attr('href', '<?= $this->webroot;?>strains/all/sativa?' + val);
                    $('#hybrid').attr('href', '<?= $this->webroot;?>strains/all/hybrid?' + val);
                    $('#all_breed').attr('href', '<?= $this->webroot;?>strains/all?' + val);
                    if (spinnerVisible) {
                        var spinner = $("div#spinner");
                        spinner.stop();
                        spinner.fadeOut("fast");
                        spinnerVisible = false;
                    }
                    $('.listing').html(res);
                }
            });
        });

        $(".dialog_sym").click(function () {
            document.body.style.overflow = "visible";
            $("#filter_dialog").hide();
        });

        <?php
        if ($effects) {
            foreach ($effects as $eff) {
                echo "$('#eff_" . $eff . "').click();";
            }
        }
        if ($symptoms) {
            foreach ($symptoms as $eff) {
                echo "$('#filter_dialog #sym_" . $eff . "').click();";
            }
        }

        if (isset($_GET['sort']) && $_GET['sort']) {
            echo "$('#" . str_replace('reviewed', 'viewed', $_GET['sort']) . "').click();";
        }
        ?>
    });
</script>