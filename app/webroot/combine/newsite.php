<!-- //////////////////////////////////////////////////////////////////////////////////////////// NEW SITE-->

<script>
    $(function () {
        $('.mmenu').change(function () {
            window.location = $(this).val();
        });
    });

    var spinnerVisible = false;

    function showProgress() {
        if (!spinnerVisible) {
            $("div#spinner").fadeIn("fast");
            spinnerVisible = true;
        }
    }

    function hideProgress() {
        if (spinnerVisible) {
            var spinner = $("div#spinner");
            spinner.stop();
            spinner.fadeOut("fast");
            spinnerVisible = false;
        }
    }

    function highlighteff(thiss) {
        if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
            thiss.addClass('searchact');
            $('.effe').append('<input type="hidden" name="effects[]" value="' + thiss.attr('id').replace('eff_', '') + '" class="' + thiss.attr('id') + '"  />')
        } else {
            thiss.removeClass('searchact');
            $('.' + thiss.attr('id')).remove();
        }
        $('.key').val('');
    }

    function highlightsym(thiss) {
        if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
            thiss.addClass('searchact');
            $('.symp').append('<input type="hidden" name="symptoms[]" value="' + thiss.attr('id').replace('sym_', '') + '" class="' + thiss.attr('id') + '"  />')
        } else {
            thiss.removeClass('searchact');
            $('.' + thiss.attr('id')).remove();
        }
        $('.key').val('');
    }

    /*
     function highlightsym(thiss) {
     if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
     thiss.addClass('searchact');
     $('.symp').append('<input type="hidden" name="symptoms[]" value="' + thiss.attr('id').replace('sym_', '') + '" class="' + thiss.attr('id') + '"  />')
     } else {
     thiss.removeClass('searchact')

     $('.' + thiss.attr('id')).remove();
     }
     $('.key').val('');
     }
     */

    function highlighteff2(thiss, order) {
        var sort = 1;
        if (thiss != 'recent' && thiss != 'rated' && thiss != 'alpha' && thiss != 'viewed' && thiss != 'reviewed') {
            sort = 0;
            if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
                thiss.addClass('searchact');
                $('.effe').append('<input type="hidden" name="effects[]" value="' + thiss.attr('id').replace('eff_', '') + '" class="effs ' + thiss.attr('id') + '"  />')
            } else {
                thiss.removeClass('searchact');
                $('.' + thiss.attr('id')).remove();
            }
            $('.key').val('');
        }
        showProgress();
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

        $('.symps').each(function () {
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
            val = val + '&key=';
        } else {
            val = 'key=';
        }
        if (sort) {
            val = val + '&sort=' + thiss + '&order=' + order;
        }

        $.ajax({
            url: 'filter',
            data: val,
            type: 'get',
            success: function (res) {
                hideProgress();
                $('.listing').html(res);
            }
        });
    }

    function highlightsym2(thiss) {
        if (thiss.attr('class').replace('searchact', '') == thiss.attr('class')) {
            thiss.addClass('searchact');
            $('.symp').append('<input type="hidden" name="symptoms[]" value="' + thiss.attr('id').replace('sym_', '') + '" class="symps ' + thiss.attr('id') + '"  />')
        } else {
            thiss.removeClass('searchact');
            $('.' + thiss.attr('id')).remove();
        }
        $('.key').val('');
        showProgress();
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
        $('.symps').each(function () {
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
            val = val + '&key=';
        } else {
            val = 'key=';
        }
        $.ajax({
            url: 'filter',
            data: val,
            type: 'get',
            success: function (res) {
                hideProgress();
                $('.listing').html(res);
            }
        });
    }
</script>

<div class="background_image">
    <div class="page" id="home_cannibis_frontpage" style="border-top:0;padding-bottom:0px;">
        <div class="clearfix" style="background: #000; background: rgba(0,0,0,0.65); border-radius: 3px; margin: 0 auto; padding:25px 20px;color:white !important;">
            <h1 id="H1_4">Add Canbii To Your Life</h1>
            <h1 id="H1_4" style="font-size: 30px">The Cannabis Lifestyle...</h1>
            <form id="FORM_13" class="contact_form" action="<?= $this->webroot ?>strains/all" method="get" id="search">

                <DIV CLASS="row text-left">
                    <?php
                    $effect = $this->requestAction('/pages/getSym');
                    $counter = 0;
                    $num_of_sys = count($effect);
                    foreach ($effect as $key => $e) {
                        echo '<div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=' . $e['Symptom']['id'] . '" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a></div>';
                    }

                    /*
                        foreach ($effect as $key => $e) {
                            $counter ++;
                            if($counter == 1){
                                echo '<div style="width: 50%; text-align: left;float:left" class="show479_767">';
                            }
                            echo '<div><a class="A_6" href="strains/all?symptoms=' . $e['Symptom']['id'] . '" onclick="highlightsym($(this))" id="sym_';
                            echo $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a></div>';
                            if($counter == ceil($num_of_sys/2)) {
                                $counter = 0;
                                echo "</div>";
                            }
                        }

                        if($counter != 0){
                            echo "</div>";
                        }


                        $counter = 0;
                        foreach ($effect as $key => $e) {
                            $counter ++;
                            if($counter == 1){
                                echo '<div style="width: 20%; text-align: left;float:left" class="hide767">';
                            }

                            echo '<div><!--a class="A_6" href="javascript:void(0)" onclick="highlightsym($(this))" id="sym_';
                            echo $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a-->';
                            echo '<a class="A_6" href="strains/all?symptoms=' . $e['Symptom']['id'] . '" onclick="highlightsym($(this))"';
                            echo 'id="sym_' . $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a></div>';

                            if($counter == 10){
                                $counter = 0;
                                echo '</div>';
                            }
                        }
                        if($counter != 0){
                            echo "</div>";
                        }
                    */

                    /*
                        foreach ($effect as $key => $e) {
                            $islast = $key == 18;
                            if ($key == 19) {
                            }
                            echo '<a class="A_6" href="javascript:void(0)" onclick="highlightsym($(this))"';
                            echo 'id="sym_' . $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a>';
                            if ($key + 1 == count($effect)) {
                                echo "</P>";
                            } elseif ($islast) {
                                echo ' or <a class="A_6" href="' . $this->webroot . 'strains/all">View all</a>';
                            }
                        }
                    */
                    ?>
                </DIV>

                <!--p id="P_5">
					Filter by Effects:
					<?php
                $effect = $this->requestAction('/pages/getEff');
                foreach ($effect as $key => $e) {
                    $islast = $key == 18;
                    if ($key == 19) {
                        echo "<a href='javascript:;' onclick=\"$('.more1').toggle();\" style='color:#fff;font-weight:bold;'> </a></p><p class='more1' id='P_5' style='display:none;'>";
                    }
                    echo '<a  href="javascript:void(0)" class="A_6" onclick="highlighteff($(this))" id="eff_' . $e['Effect']['id'] . '">' . $e['Effect']['title'] . '</a></a>';
                    if ($key + 1 == count($effect)) {
                        echo "</P>";
                    } elseif ($islast) {
                        echo ' or <a class="A_6" href="' . $this->webroot . 'strains/all">View all</a>';
                    }
                }
                ?>
				</p-->

                <p style="display: none;" class="effe"></p>
                <p style="display: none;" class="symp"></p>

                        <input id="" type="text" placeholder="or Search by Strain Name" name="key" class="key form-control"/>
                        <input id="" type="submit" value="Search" class="btn btn-primary"/>

            </form>
        </div>
    </div>
</div>