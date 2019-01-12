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
<div class="row bg-primary text-white">
    <div class="col-md-12 pa-3">
        <br>
        <h1 class="">Add Canbii to Your Life</h1>
        <h3>Lifestyle Optimization Tool</h3>

        <br>

    </div>
</div><br>
<div class="page responsive" id="home_cannibis_frontpage">
    <div class="clearfix" id="home_cannibis_frontpage_clearfix">
        <form id="FORM_13" class="contact_form" action="<?= $this->webroot ?>strains/all" method="get" id="search">
            <DIV CLASS="row text-left">

                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#hiking</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#reading</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#movies</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#meditation</a></div>


                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#yoga</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#video games</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#excercise</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#hangingwithfriends</a></div>



                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#napping</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#studying</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#painting</a></div>
                <div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=3" onclick="highlightsym($(this))" id="sym_';
                        echo $e['Symptom']['id'] . '">#driving</a></div>


                <hr>
                <?php


                $effect = $this->requestAction('/pages/getSym');
                $counter = 0;
                $num_of_sys = count($effect);
                foreach ($effect as $key => $e) {
                    echo '<div CLASS="col-xs-6 col-sm-6 col-md-3 col-lg-3"><a class="A_6" href="strains/all?symptoms=' . $e['Symptom']['id'] . '" onclick="highlightsym($(this))" id="sym_';
                    echo $e['Symptom']['id'] . '">' . $e['Symptom']['title'] . '</a></div>';
                }
                ?>
            </DIV>
            <p style="display: none;" class="effe"></p>
            <p style="display: none;" class="symp"></p>
            <!--input id="strainname" type="text" placeholder="or Search by Strain Name" name="key" class="key form-control"/>
            <input id="strainsubmit" type="submit" value="Search" class="btn btn-primary"/-->
        </form>
    </div>
</div>
<hr>