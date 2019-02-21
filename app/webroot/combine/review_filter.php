<SPAN debugtitle="combine/review_filter.php">
    <ul>
        <?php
            errorlog("include combine/review_filter.php");
            if($review) {
                $i = 0;
                foreach($review as $k=>$r) {
                    $i++;
                    $j=0;
                    if($r) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $rand1 = rand(100,999);
                        $rand2 = rand(100,999);
                        $q5 = $vip->find('first',array('conditions'=>array('review_id'=>$r['Review']['id'],'ip'=>$ip)));
                        if($q5){$vote = 1;$yes = $q5['VoteIp']['vote_yes'];}else{$vote = 0;}

                        $userid =   $review['Review']['user_id'];
                        $username = $this->requestAction('/strains/getUserName/' . $userid, false);
                        if($username === false){
                            $user = first("SELECT * FROM users WHERE email='roy@trinoweb.com'");
                            $userid = $user["id"];
                            $username = $user["username"];
                        }
                        ?>
                        <li class="comment clearfix">
                            <div class="comment_author_avatar">&nbsp;</div>
                            <div class="comment_details">
                                <div class="posted_by">
                                    Reviewed by
                                    <a class="author" href="<?= $this->webroot;?>strains/review/all?user=<?= $userid;?>" title="<?= $username; ?>">
                                        <?= $username;?>
                                    </a>
                                    <?php if($r['Review']['on_date']!= "0000-00-00") {echo " on " . $r['Review']['on_date'];}?>
                                </div>
                                <h3><?= $r['Strain']['name'];?></h3>
                                <div class="rates frate<?= $k;?>"></div>
                                <script>
                                    $(function(){
                                        $('.frate<?= $k;?>').raty({readOnly:true,score:<?= $r['Review']['rate'];?>});
                                    });
                                </script>
                                <p><?= $r['Review']['review'];?></p>

                                <?php /*Was this review helpful?<br /><br />
                                <?php if($vote==0){?>
                                    <a href="javascript:void(0);" id="<?php echo $rand1.'_'.$r['Review']['id'];?>" class="btns yes" style="background-color: #40b2e2; padding-left:6px; padding-right:6px; padding-top: 5px; padding-bottom: 5px; margin-right:5px"><strong style="color: white">YES<?php if($r['Review']['helpful']){?> (<?php echo $r['Review']['helpful'];?>)<?php }?></strong></a> <a class="btns no" href="javascript:void(0);" id="<?php echo ($rand1+1).'_'.$r['Review']['id'];?>" style="background-color: #1e84c6; padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px"><strong style="color: white">NO<?php if($r['Review']['not_helpful']){?> (<?php echo $r['Review']['not_helpful'];?>)<?php }?></strong></a>
                                <?php }else{
                                    if($yes==1)
                                    {
                                        $y1 = 'padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px;background:#e5e5e5;cursor:default;';
                                        $y2 = 'color:#fff';
                                        $n1 = 'background:#FFF;color:#CCC;cursor: default;padding:4px 7px;';
                                        $n2 = 'color:#CCC;';
                                    }
                                    else
                                    {
                                        $y1 = 'background:#FFF;color:#CCC;cursor: default;padding:4px 7px;';
                                        $y2 = 'color:#CCC;';
                                        $n1 = 'padding-left:10px; padding-right:10px; padding-top: 5px; padding-bottom: 5px; margin-right:5px;background:#e5e5e5;cursor:default;';
                                        $n2 = 'color:#fff';
                                    }
                                    ?>
                                    <a href="javascript:void(0);" id="" class="faded" style="<?php echo $y1;?>"><strong style="<?php echo $y2;?>">YES<?php if($r['Review']['helpful']){?> (<?php echo $r['Review']['helpful'];?>)<?php }?></strong></a> <a class="faded" href="javascript:void(0);" id="" style="<?php echo $n1;?>"><strong style="<?php echo $n2;?>">NO<?php if($r['Review']['not_helpful']){?> (<?php echo $r['Review']['not_helpful'];?>)<?php }?></strong></a>
                                <?php }?>

                                */?>
                                <a class="more blue" href="<?= $this->webroot;?>review/detail/<?= $r['Review']['id']?>">View Details →</a>
                            </div>
                        </li>
                        <?php
                    }
                }
            }
        ?>
    </ul>

    <div class="clear"></div>
    <div class="morelist" style="display: none;"></div>

    <?php
        if($reviewz && ($reviewz)>8){
            echo '<div class="loadmore"><a href="javascript:void(0);">Load More</a></div>';
        }
        errorlog("include combine/review_filter.php success");
    ?>

    <script>
        $(function(){
            var j =0;
            $('.comment').each(function(){
                j++;
            });
            if(j==<?= ($reviewz);?>) {
                $('.loadmore').hide();
            }
            var m=0;
            $('.loadmore').each(function(){
                m++;
                if(m!=1){
                    $(this).remove();
                }
           });
        });
    </script>
</SPAN>