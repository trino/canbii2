<div class="" id="comments_list">
    <?php
        if (isset($reviewid)) {
            echo "DELETE review ID: " . $reviewid;
        }
    ?>


    <div class=" clearfix">
        <?php if ($reviewz > 0) { ?>
        <ul class="columns full_width page_margin_top clearfix">

            <?php
                $j = 0;
                $id = -1;
                $count = 0;
                if (isset($_GET["delete"])) {
                    $id = $_GET["delete"];
                }
                foreach ($reviews as $review) {
                    if ($review['Strain']["id"] != $id) {
                        $strain_hexagon = $review;
                        //if ($j % 2 == 0) {echo "<div style='clear:both;border-bottom:1px solid #E8E8E8;padding:5px 0px;'> </div>"; }
                        //$j++;
                        $j=$review['Review']['id'];
                        ?>

                        <li class="<?php /*if($count % 2 == 0):?>column_left<?php else: ?>column_right<?php endif; */?> page_margin_top" style="margin-bottom: 15px;">
                            <div class="comment_author_avatar">&nbsp;</div>
                            <div class="comment_details">
                                <a href="<?php echo $this->webroot ?>strains/<?php echo $strain_hexagon['Strain']['slug']; ?>">
                                    <? include('combine/hexagon.php'); ?>
                                    <h2><?php echo $review['Strain']['name']; ?> <span style="font-size: 12px;"> View Report &raquo;</span>
                                    </h2>
                                </a>


                                <div class="rating<?php echo $j; ?> rat" style=""></div>
                                <script>
                                    $(function () {
                                        $('.rating<?php echo $j;?>').raty({
                                            number: 5,
                                            readOnly: true,
                                            score:<?php echo $review['Review']['rate'];?>
                                        });
                                    });
                                </script>

                                <p style="clear:both;padding-right:10px;">
                                    <?php echo substr($review['Review']['review'], 0, 70) . '...'; ?>
                                </p>


                                <div class="posted_by" style="font-size: 11px; color: #909090; line-height: 140%;">
                                    reviewed by <a class="author"
                                                   href="<?php echo $this->webroot; ?>strains/review/all?user=<?php echo $review['Review']['user_id']; ?>"
                                                   title="<?php echo $this->requestAction('/strains/getUserName/' . $review['Review']['user_id']); ?>"><?php echo $this->requestAction('/strains/getUserName/' . $review['Review']['user_id']); ?></a>                                    <?php if ($review['Review']['on_date'] != "0000-00-00") {
                                        echo " on <strong>" . $review['Review']['on_date']."</strong>";
                                    } ?>
                                </div>


                                <a style="margin-top: 10px;float: right;"
                                   href="<?php echo $this->webroot; ?>review/detail/<?php echo $review['Review']['id']; ?>"
                                   class="more blue">Go to Review →</a>
                                <!--A href="<!= $this->webroot . "review/add/" . $review['Strain']['slug'] . "?review=" . $review['Review']['id']; ?>" class="more dark_blue" style="margin-left: 10px;">Edit</A-->
                                <!--a href="<?php echo $this->webroot; ?>review/all?delete=<?php echo $review['Review']['strain_id']; ?>" onclick="return confirm('Are you sure you want to delete your review for <?= $review['Strain']['name'] ?>?');" class="more red">Delete</a-->

                            </div>
                            <div style="clear:both"></div>
                        </li>

                    <?php
                        $count++;

                        }
                } ?>











            <div class="clear"></div>
            <div class="morelist" style="display: none;"></div>
            <?php

                if ($reviewz && $reviewz > 1) {
                    echo '<div class="loadmore"><a href="javascript:void(0);">Load More</a></div>';
                } ?>
            <script>
                $(function () {
                    var j = 0;
                    $('.comment').each(function () {
                        j++;
                    })
                    if (j ==<?php echo ($reviewz);?>)
                        $('.loadmore').hide();
                    var m = 0
                    $('.loadmore').each(function () {
                        m++;
                        if (m != 1) {
                            $(this).remove();
                        }
                    });
                });
            </script>
            <?php
                }
                if (count($reviews) == 0) {
                    echo '<a href="' . $this->webroot . 'review/">';
                    echo "No reviews yet. Feel free to add one. </a>";
                } ?>
        </div>


    </div>