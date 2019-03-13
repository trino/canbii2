<ul class="page_margin_top clearfix">
    <?php
        if(!isset($typeid)){$typeid = "all";}
        if($typeid == "all" || $typeid == "1") {
            ?>
                <li class="column">
                    <div style="float:left;">
                        <img src="<?php echo $this->webroot; ?>images/IndicaIcon.png">
                    </div>
                    <div style="float:left;margin-left: 15px;">
                        <h1>Indica</h1>
                        Best for Night Time Use
                    </div>
                </li>
            <?php
        }
        if($typeid == "all" || $typeid == "2") {
            ?>
                <li class="column" style="clear:both;">
                    <div style="float:left;">
                        <img src="<?php echo $this->webroot;?>images/SativaIcon.png">
                    </div>
                    <div style="float:left;margin-left: 15px;">
                        <h1>Sativa</h1>
                        Best for Day Time Use
                    </div>
                </li>
            <?php
        }
        if($typeid == "all" || $typeid == "3") {
            ?>
                <li class="column" style="clear:both;">
                    <div style="float:left;">
                        <img src="<?php echo $this->webroot;?>images/HybridIcon.png">
                    </div>
                    <div style="float:left;margin-left: 15px;">
                        <h1>Hybrid</h1>
                        Best of Both Worlds
                    </div>
                </li>
            <?php
        }
    ?>
</ul>