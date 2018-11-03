<script src="<?php echo $this->webroot; ?>js/raty.js"></script>
<script src="<?php echo $this->webroot; ?>js/labs.js"></script>
<link href="<?php echo $this->webroot; ?>css/raty.css" rel="stylesheet" type="text/css"/>

<style>
    #qf_review__aesthetics__color .review-slider {
        display: inline-block;
    }

    #qf_review__aesthetics__flavor .review-slider {
        display: inline-block;
    }

    .page_title{
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;
        white-space: -o-pre-wrap;
        word-wrap: break-word;
    }
</style>

<?php
    if (!isset($review['Strain']) || !isset($review['Review'])) {
        return;//gracefully fail
    }
?>

<div class="page_layout page_margin_top clearfix">
    <div class="page_header clearfix">
        <div class="page_header_left">
            <h1 class="page_title">Review Detail
                of <?php echo ucfirst($review['Strain']['name']) . " on " . $review['Review']['on_date']; ?></h1>
            <ul class="bread_crumb">
                <li>
                    <a href="<?php echo $this->webroot ?>" title="Home">
                        Home
                    </a>
                </li>
                <li class="separator icon_small_arrow right_gray">
                    &nbsp;
                </li>
                <li>
                    New Cannabis Review
                </li>
            </ul>
        </div>
        <div class="page_header_right">
            <!--form class="search">
                <input class="search_input hint" type="text" value="To search type and hit enter..." placeholder="To search type and hit enter...">
            </form-->
        </div>
    </div>
    <div class="clearfix page_margin_top ">
        <a title="Read more" href="<?php echo $this->webroot; ?>users/dashboard"
           class="more large dark_blue icon_small_arrow margin_right_white">My Account</a>
        <a title="Read more" href="<?php echo $this->webroot; ?>users/settings"
           class="more large dark_blue icon_small_arrow margin_right_white margin_left_10">Settings</a>
        <a title="Read more" href="<?php echo $this->webroot; ?>review"
           class="active more large dark_blue icon_small_arrow margin_right_white margin_left_10">Add Review</a>
        <a title="Read more" href="<?php echo $this->webroot; ?>review/all"
           class="more large dark_blue icon_small_arrow margin_right_white margin_left_10">My Review</a>

        <div class="clearfix"></div>
        <?php //var_dump($review);
            $typ = array('', 'Extremely Active', 'Very Active', 'Active', 'Bit Active', 'Balanced', 'Bit Sedated', 'Sedated', 'Very Sedated', 'Extremely Sedated');
        ?>

        <fieldset id="qf_review__general" class="qf-fieldset">
            <h2 class="slide page_margin_top">General Rating</h2>

            <div id="qf_review__general__mscale__wrapper" class="qf-input-wrapper qf-slider-input-wrapper">
    <span id="qf_review__general__mscale__label_span" class="qf-label-span">
        <label id="qf_review__general__mscale__label" for="qf_review__general__mscale">Effect Scale (Active to
            Sedative)</label>
    </span>
    <span id="qf_review__general__mscale__span" class="qf-input-span qf-slider-input-span">
        <p id="qf_review__general__mscale__prompt"><?php echo $typ[$review['Review']['eff_scale']]; ?></p>
        <div>
            <input id="qf_review__general__mscale" class="qf-hidden-input qf-slider qf-input" type="hidden"
                   name="eff_scale" value="1" title="Effect Scale (Active to Sedative)"/>
        </div>
        <div id="qf_review__general__mscale__slider"
             class="qf-slider-bar ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
        </div>
    </span>
            </div>

            <div id="qf_review__general__strength__wrapper" class="qf-input-wrapper qf-slider-input-wrapper">
    <span id="qf_review__general__strength__label_span" class="qf-label-span">
        <label id="qf_review__general__strength__label" for="qf_review__general__strength">Effect Strength</label>
    </span>
    <span id="qf_review__general__strength__span" class="qf-input-span qf-slider-input-span">
        <p id="qf_review__general__strength__prompt"><?php echo $review['Review']['eff_strength']; ?>/5</p>
    <div>
        <input id="qf_review__general__strength" class="qf-hidden-input qf-slider qf-input" type="hidden"
               name="eff_strength" value="1" title="Effect Strength">
    </div>
    <div id="qf_review__general__strength__slider"
         class="qf-slider-bar ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
    </div>
    </span>
            </div>
            <div id="qf_review__general__duration__wrapper" class="qf-input-wrapper qf-slider-input-wrapper">
    <span id="qf_review__general__duration__label_span" class="qf-label-span">
        <label id="qf_review__general__duration__label" for="qf_review__general__duration">Effect Duration</label>
    </span>
    <span id="qf_review__general__duration__span" class="qf-input-span qf-slider-input-span">
    <p id="qf_review__general__duration__prompt"><?php echo $review['Review']['eff_duration']; ?> hrs</p>
    <div>
        <input id="qf_review__general__duration" class="qf-hidden-input qf-slider qf-input" type="hidden"
               name="eff_duration" value="1" title="Effect Duration">
    </div>
    <div id="qf_review__general__duration__slider"
         class="qf-slider-bar ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
    </div>
    </span>
            </div>
        </fieldset>
        <fieldset id="qf_review__effects" class="qf-fieldset">
            <h2 class="slide page_margin_top">Effect Ratings</h2>

            <div class="qf-select-wrapper" id="qf_review__effects__medical__wrapper">
<span class="qf-label-span" id="qf_review__effects__medical__label_span">
<label id="qf_review__effects__medical__label" for="qf_review__effects__medical">Medicinal Effects</label>
<p style="font-size: 9pt; color: #666; margin: 0 0 2px">How well did this strain help your medical condition(s)?</p>
</span>
<span class="qf-select-span" id="qf_review__effects__medical__span">
<span class="qf-select-inner" id="qf_review__effects__medical__inner">
<div class="qf-select review-selector" id="qf_review__effects__medical">
    <?php
        if (count($review['SymptomRating']) > 0) {
            echo count($review['SymptomRating']);
            foreach ($review['SymptomRating'] as $effect) {
                ?>
                <div id="efft_<?php echo $effect['id'];?>er" class="review-slider">
                    <label><?php echo $symptoms[$effect['symptom_id'] - 1]['Symptom']['title'];?></label>

                    <div id="<?php echo $effect['id'];?>er"></div>
                    <p><?php echo $effect['rate'];?>/5</p>

                    <div class="clear"></div>
                </div>
                <script>
                    $(function () {
                        $('#<?php echo $effect['id'];?>er').slider({
                            range: "min",
                            disabled: true,
                            value: <?php echo $effect['rate'];?>,
                            min: 0,
                            max: 5,
                            slide: function (event, ui) {
                                $('#' + id + 'p').html('' + ui.value + '/5');
                                $('#' + id + 'i').val(ui.value);
                            }
                        });
                    });
                </script>
            <?php }
        } else {
            echo "No Review For Medicinal Effects";
        }
    ?>
</div>

</span>
</span>
            </div>
            <div>
                <div class="clear"></div>
            </div>
            <div class="qf-select-wrapper" id="qf_review__effects__positive__wrapper">
<span class="qf-label-span" id="qf_review__effects__positive__label_span">
<label id="qf_review__effects__positive__label" for="qf_review__effects__positive">Positive Effects</label>
<p style="font-size: 9pt; color: #666; margin: 0 0 2px">What positive effect(s) did this strain have on you?</p>
</span>
<span class="qf-select-span" id="qf_review__effects__positive__span">
<span class="qf-select-inner" id="qf_review__effects__positive__inner">
<div class="qf-select review-selector" id="qf_review__effects__positive">
    <?php
        if(false){

        $pos = array();
        foreach ($effects as $e) {
            array_push($pos, $e['Effect']['id']);
        }

        foreach ($review['EffectRating'] as $effect) {
            if (in_array($effect['effect_id'], $pos)) {
                ?>
                <div id="efft_<?php echo $effect['id'];?>pe" class="review-slider">
                    <label><?php echo $effects[$effect['effect_id'] - 1]['Effect']['title'];?></label>

                    <div id="<?php echo $effect['id'];?>pe"></div>
                    <p><?php echo $effect['rate'];?>/5</p>

                    <div class="clear"></div>
                </div>
                <script>
                    $('#<?php echo $effect['id'];?>pe').slider({
                        range: "min",
                        disabled: true,
                        value: <?php echo $effect['rate'];?>,
                        min: 0,
                        max: 5,
                        slide: function (event, ui) {
                            $('#' + id + 'p').html('' + ui.value + '/5');
                            $('#' + id + 'i').val(ui.value);
                        }
                    });
                </script>
            <?php }
        }}
    ?>

</div>

</span>
</span>
            </div>
            <div>
                <div class="clear"></div>
            </div>
            <div class="qf-select-wrapper" id="qf_review__effects__negative__wrapper">
<span class="qf-label-span" id="qf_review__effects__negative__label_span">
<label id="qf_review__effects__negative__label" for="qf_review__effects__negative">Negative Effects</label>
<p style="font-size: 9pt; color: #666; margin: 0 0 2px">What negative effect(s) did this strain have on you?</p>
</span>
<span class="qf-select-span" id="qf_review__effects__negative__span">
<span class="qf-select-inner" id="qf_review__effects__negative__inner">
<div class="qf-select review-selector" id="qf_review__effects__negative">
    <?php
        $pos = array();
        foreach ($negative as $e) {
            array_push($pos, $e['Effect']['id']);
        }

        foreach ($review['EffectRating'] as $effect) {
            if (in_array($effect['effect_id'], $pos)) {
                ?>
                <div id="efft_<?php echo $effect['id'];?>ne" class="review-slider">
                    <label><?php echo $effectz[$effect['effect_id'] - 1]['Effect']['title'];?></label>

                    <div id="<?php echo $effect['id'];?>ne"></div>
                    <p><?php echo $effect['rate'];?>/5</p>

                    <div class="clear"></div>
                </div>
                <script>
                    $('#<?php echo $effect['id'];?>ne').slider({
                        range: "min",
                        disabled: true,
                        value: <?php echo $effect['rate'];?>,
                        min: 0,
                        max: 5,
                        slide: function (event, ui) {
                            $('#' + id + 'p').html('' + ui.value + '/5');
                            $('#' + id + 'i').val(ui.value);
                        }
                    });
                </script>
            <?php }
        }
    ?>

</div>

</span>
</span>
            </div>
        </fieldset>
        <fieldset id="qf_review__aesthetics" class="qf-fieldset">
            <h2 class="slide page_margin_top">Aesthetic Rating</h2>

            <div class="qf-select-wrapper" id="qf_review__aesthetics__color__wrapper">
<span class="qf-label-span" id="qf_review__aesthetics__color__label_span">
<label id="qf_review__aesthetics__color__label" for="qf_review__aesthetics__color">Color</label>
<p style="font-size: 9pt; color: #666; margin: 0 0 2px">What color(s) stand out in this bud?</p>
</span>
<span class="qf-select-span" id="qf_review__aesthetics__color__span">
<span class="qf-select-inner" id="qf_review__aesthetics__color__inner">
<div class="qf-select review-selector" id="qf_review__aesthetics__color">
    <?php foreach ($review['ColourRating'] as $effect) {
        ?>
        <div id="efft_<?php echo $effect['id'];?>" class="review-slider">
            <label><?php echo $colours[$effect['colour_id'] - 1]['Colour']['title'];?></label>
            <!--<div class="slider" id="<?php echo $effect['id'];?>s"></div><p><?php echo $effect['rate'];?>/5</p><div class="clear"> </div>-->
        </div>
        <script>
            $('#<?php echo $effect['id'];?>s').slider({
                range: "min",
                disabled: true,
                value: <?php echo $effect['rate'];?>,
                min: 0,
                max: 5,
                slide: function (event, ui) {
                    $('#' + id + 'p').html('' + ui.value + '/5');
                    $('#' + id + 'i').val(ui.value);
                }
            });
        </script>
    <?php }
    ?>

</div>

</span>
</span>
            </div>
            <div>
                <div class="clear"></div>
            </div>
            <div class="qf-select-wrapper" id="qf_review__aesthetics__flavor__wrapper">
<span class="qf-label-span" id="qf_review__aesthetics__flavor__label_span">
<label id="qf_review__aesthetics__flavor__label" for="qf_review__aesthetics__flavor">Flavor / Scent</label>
<p style="font-size: 9pt; color: #666; margin: 0 0 2px">How does this strain taste & smell?</p>
</span>
<span class="qf-select-span" id="qf_review__aesthetics__flavor__span">
<span class="qf-select-inner" id="qf_review__aesthetics__flavor__inner">
<div class="qf-select review-selector" id="qf_review__aesthetics__flavor">
    <?php foreach ($review['FlavorRating'] as $effect) {
        ?>
        <div id="efft_<?php echo $effect['id'];?>" class="review-slider">
            <label><?php echo $flavors[$effect['flavor_id'] - 1]['Flavor']['title'];?></label>
            <!--<div class="slider" id="<?php echo $effect['id'];?>s"></div><p><?php echo $effect['rate'];?>/5</p><div class="clear"> </div>-->
        </div>
        <script>
            $('#<?php echo $effect['id'];?>s').slider({
                range: "min",
                disabled: true,
                value: <?php echo $effect['rate'];?>,
                min: 0,
                max: 5,
                slide: function (event, ui) {
                    $('#' + id + 'p').html('' + ui.value + '/5');
                    $('#' + id + 'i').val(ui.value);
                }
            });
        </script>
    <?php }
    ?>

</div>

</span>
</span>
            </div>
        </fieldset>
        <fieldset id="qf_review__other" class="qf-fieldset">
            <legend>Comments, etc.</legend>
            <div class="qf-input-wrapper qf-slider-input-wrapper" id="qf_review__other__overall__wrapper">
<span class="qf-label-span" id="qf_review__other__overall__label_span">
<label id="qf_review__other__overall__label" for="qf_review__other__overall">Overall Rating</label>
</span>

                <div id="preci">
                    <div id="precision" class="left" style="cursor: pointer;">
                    </div>

                    <div class="errorz" style="display: none;">Overall Rating Is Mandatory.</div>

                </div>

                <div id="precision-hint" class="input hint left marleft"></div>
<span class="qf-input-span qf-slider-input-span" id="qf_review__other__overall__span">
<p id="qf_review__other__overall__prompt">1/5</p>
<div>
    <input title="Overall Rating" value="0" type="hidden" name="rate" id="qf_review__other__overall"
           class="qf-hidden-input qf-slider qf-input"/>
</div>
<div class="qf-slider-bar" id="qf_review__other__overall__slider"></div>
</span>
            </div>
            <div class="qf-textarea-wrapper" id="qf_review__other__comments__wrapper">
<span class="qf-label-span" id="qf_review__other__comments__label_span">
<label id="qf_review__other__comments__label" for="qf_review__other__comments">Comments</label>

</span>
                <br/><br/>
                <em><?php echo $review['Review']['review']; ?></em>

            </div>
        </fieldset>
    </div>
</div>
<script>
    $(function () {

        $("#qf_review__general__mscale__slider").slider({
            'min': 1,
            disabled: true,
            'max': 9,
            'step': 1,
            'value':<?php echo $review['Review']['eff_scale'];?>,
            'slide': function (e, ui) {
                $('#qf_review__general__mscale').val(ui.value);
                var vals = ['Extremely Active', 'Very Active', 'Active', 'Bit Active', 'Balanced', 'Bit Sedated', 'Sedated', 'Very Sedated', 'Extremely Sedated'];
                $('#qf_review__general__mscale__prompt').html(vals[Math.ceil(((ui.value + 1 - 1) / (9 + 1 - 1)) * vals.length) - 1]);
            },
            'range': 'min'
        });
        $("#qf_review__general__strength__slider").slider({
            'min': 1,
            'max': 5,
            disabled: true,
            'step': 1,
            'value':<?php echo $review['Review']['eff_strength'];?>,
            'slide': function (e, ui) {
                $('#qf_review__general__strength').val(ui.value);
                $('#qf_review__general__strength__prompt').html('' + ui.value + '/5');
            },
            'range': 'min'
        });
        $("#qf_review__general__duration__slider").slider({
            'min': 1,
            'max': 5,
            'step': 1,
            disabled: true,
            'value':<?php echo $review['Review']['eff_duration'];?>,
            'slide': function (e, ui) {
                $('#qf_review__general__duration').val(ui.value);
                $('#qf_review__general__duration__prompt').html('' + ui.value + ' hrs');
            },
            'range': 'min'
        });
        $("#qf_review__aesthetics__hairs__slider").slider({
            'min': 1,
            'max': 5,
            'step': 1,
            disabled: true,
            'value':<?php echo $review['Review']['eff_scale'];?>,
            'slide': function (e, ui) {
                $('#qf_review__aesthetics__hairs').val(ui.value);
                $('#qf_review__aesthetics__hairs__prompt').html('' + ui.value + '/5');
            },
            'range': 'min'
        });
        $("#qf_review__aesthetics__crystals__slider").slider({
            'min': 1,
            'max': 5,
            'step': 1,
            disabled: true,
            'value':<?php echo $review['Review']['eff_scale'];?>,
            'slide': function (e, ui) {
                $('#qf_review__aesthetics__crystals').val(ui.value);
                $('#qf_review__aesthetics__crystals__prompt').html('' + ui.value + '/5');
            },
            'range': 'min'
        });
        //$("#qf_review__other__overall__slider").slider({'min':1,'max':5,'step':1,'value':1,'slide':function(e,ui){ $('#qf_review__other__overall').val(ui.value);$('#qf_review__other__overall__prompt').html(''+ui.value+'/5'); },'range':'min'});
        $('#precision').raty({
            cancel: false,
            readOnly: true,
            cancelOff: 'cancel-off.png',
            cancelOn: 'cancel-on.png',
            path: '<?php echo $this->webroot;?>raty/images',
            starHalf: 'star-half.png',
            starOff: 'star-off.png',
            starOn: 'star-on.png',
            target: '#qf_review__other__overall__prompt',
            targetKeep: true,
            precision: true,
            number: 5,
            score: <?php echo $review['Review']['rate'];?>,
            //hints      : ['1/10','2/10','3/10','4/10','5/10','6/10','7/10','8/10','9/10','10/10'],
            click: function (score) {
                $('#qf_review__other__overall').val(score.toFixed(2));
                $('.errorz').hide();
            }
        });


    });
</script>