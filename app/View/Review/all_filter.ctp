<?php if(count($reviews) > 0): ?>
<!--<div class="page_left">-->
<!---->
<!--<div class="comments clearfix page_margin_top">-->
<!--<div id="comments_list">-->
<!--<ul>-->
<?php
//$j=0;
$count = 0;
foreach($reviews as $review)
{
//$j++;

    $strain_hexagon = $review;
    $j=$review['Review']['id'];
    ?>

<li class="<?php if($count % 2 == 0):?>column_left<?php else: ?>column_right<?php endif; ?> page_margin_top comment clearfix">
    <div class="comment_author_avatar">
    &nbsp;
    </div>

    <div class="comment_details">
        <!--<div class="posted_by">-->
        <!--Reviewed by <a class="author" href="<?php //echo $this->webroot;?>strains/review/all?user=<?php //echo $review['Review']['user_id'];?>" title="<?php //echo $this->requestAction('/strains/getUserName/'.$review['Review']['user_id']);?>"><?php echo $this->requestAction('/strains/getUserName/'.$review['Review']['user_id']);?></a> <?php if($review['Review']['on_date'] != "0000-00-00"){ echo " on " . $review['Review']['on_date'];} ?>-->
        <!--</div>-->
        <!---->
        <!--<h3><?php //echo $review['Strain']['name'];?></h3>-->
        <a href="<?php echo $this->webroot ?>strains/<?php echo $strain_hexagon['Strain']['slug']; ?>">
            <? include('combine/hexagon.php'); ?>
            <h2><?php echo $review['Strain']['name']; ?> <span style="font-size: 12px;"> View Report &raquo;</span>
            </h2>
        </a>
        <div class="rating<?php echo $j;?> rat" style=""></div>
        <script>
        $(function(){
        $('.rating<?php echo $j;?>').raty({number:5,readOnly:true,score:<?php echo $review['Review']['rate'];?>});
        });
        </script>
        <p style="clear:both;padding-right:10px;">
            <?php echo substr($review['Review']['review'], 0, 70) . '...'; ?>
        </p>


        <div class="posted_by" style="font-size: 11px; color: #909090; line-height: 140%;">
            reviewed by <a class="author"
                           href="<?php echo $this->webroot; ?>strains/review/all?user=<?php echo $review['Review']['user_id']; ?>"
                           title="<?php echo $this->requestAction('/strains/getUserName/' . $review['Review']['user_id']); ?>"><?php echo $this->requestAction('/strains/getUserName/' . $review['Review']['user_id']); ?></a>                                    <?php if ($review['Review']['on_date'] != "0000-00-00") {
                echo " on " . $review['Review']['on_date'];
            } ?>
        </div>


        <a style="margin-top: 10px;float: right;"
           href="<?php echo $this->webroot; ?>review/detail/<?php echo $review['Review']['id']; ?>"
           class="more blue">Go to Review →</a>
        <!--A href="<!= $this->webroot . "review/add/" . $review['Strain']['slug'] . "?review=" . $review['Review']['id']; ?>" class="more dark_blue" style="margin-left: 10px;">Edit</A-->
        <!--a href="<?php echo $this->webroot; ?>review/all?delete=<?php echo $review['Review']['strain_id']; ?>" onclick="return confirm('Are you sure you want to delete your review for <?= $review['Strain']['name'] ?>?');" class="more red">Delete</a-->

        <!--<p>-->
        <!--<?php //echo $review['Review']['review'];?>-->
        <!--</p>-->
        <!--<a class="more reply_button" href="#comment_form">-->
        <!--<a href="<?php //echo $this->webroot;?>review/detail/<?php //echo $review['Review']['id'];?>" class="more blue">View Details →</a>-->
        <!--</a>-->
    </div>
</li>
<?php

$count++;
}?>
<!--</ul>-->
<div class="clear"></div>
<div class="morelist" style="display: none;"></div>
<?php
//if($reviewz && $reviewz >1){?>
<!--    <div class="loadmore"><a href="javascript:void(0);">Load More</a></div>-->
    <?php
//} ?>


<!--</div>-->
<!--</div>-->
<!---->
<!--</div>-->
<?php else: ?>
<p>
    You have no more reviews to display.
</p>
<?php endif; ?>
<script>
    $(function(){
        var j =0;
        var rev_count = "<?php echo count($reviews); ?>";
        $('.comment').each(function(){
            j++;
        })
        if(j==<?php echo ($reviewz);?> || $('.comment').length == 0 || rev_count == "0")
            $('.loadmore').hide();
        var m=0
       $('.loadmore').each(function(){
        m++;
        if(m!=1)
        {
            $(this).remove();
        }
       });
    });
    </script>