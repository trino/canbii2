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
                        $userid =   $review['Review']['user_id'];
                        $username = $this->requestAction('/strains/getUserName/' . $userid, false);
                        if($username === false){
                            $user = first("SELECT * FROM users WHERE email='roy@trinoweb.com'");
                            $userid = $user["id"];
                            $username = $user["username"];
                        }
                        ?>

                        <li class="page_margin_top" style="margin: 15px;">
                            <div class="comment_author_avatar">&nbsp;</div>
                            <div class="comment_details">
                                <a href="<?php echo $this->webroot ?>strains/<?php echo $strain_hexagon['Strain']['slug']; ?>">
                                    <?php include('combine/hexagon.php'); ?>
                                    <h2><?php echo $review['Strain']['name']; ?> <span style="font-size: 12px;"> View Report &raquo;</span>
                                    </h2>
                                </a>


                                <div class="rating<?php echo $j; ?> rat"></div>
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
                                                   href="<?= $this->webroot; ?>strains/review/all?user=<?= $userid; ?>"
                                                   title="<?= $username; ?>"><?= $username; ?></a>
                                    <?php if ($review['Review']['on_date'] != "0000-00-00") {
                                        echo " on " . $review['Review']['on_date'];
                                    } ?>
                                </div>


                                <a style="margin-top: 10px;float: right;"
                                   href="<?= $this->webroot; ?>review/detail/<?php echo $review['Review']['id']; ?>"
                                   class="more blue">Go to Review →</a>
                                <!--A href="<!= $this->webroot . "review/add/" . $review['Strain']['slug'] . "?review=" . $review['Review']['id']; ?>" class="more dark_blue" style="margin-left: 10px;">Edit</A-->
                                <!--a href="<?= $this->webroot; ?>review/all?delete=<?php echo $review['Review']['strain_id']; ?>" onclick="return confirm('Are you sure you want to delete your review for <?= $review['Strain']['name'] ?>?');" class="more red">Delete</a-->

                            </div>
                            <div style="clear: both;"></div>
                        </li>

                    <?php
                        $count++;

                        }
                } ?>
                <div class="clear"></div>
            <div class="morelist" style="display: none;"></div>