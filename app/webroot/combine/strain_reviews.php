<?php
errorlog("include combine/strain_reviews.php");
if ($helpful) {
    ?>
    <div class="">
        <div id="">
            <ul>
                <li class="comment clearfix">
                    <div class="comment_details">
                        <!--a href="<?= $this->webroot; ?>review/detail/<?= $helpful['Review']['id']; ?>">
                            <?php
                            $strain_hexagon = $strain;
                            include('combine/hexagon.php');
                            $j = 0;
                            $rand1 = rand(100, 999);
                            $rand2 = rand(100, 999);
                            $userid =   $helpful['Review']['user_id'];
                            $username = $this->requestAction('/strains/getUserName/' . $userid);
                            if($username == "Unknown"){
                                $user = first("SELECT * FROM users WHERE email='roy@trinoweb.com'");
                                $userid = $user["id"];
                                $username = $user["username"];
                            }
                            ?>
                        </a-->
                        <h2><?= $helpful['Strain']['name']; ?> Best Review</h2>

                        <script>
                            $(function () {
                                $('.rating<?php echo $j;?>').raty({
                                    number: 5,
                                    readOnly: true,
                                    score:<?php echo $helpful['Review']['rate'];?>
                                });
                            });
                        </script>
                        <div class="rating<?= $j; ?> rat"></div>
                        <p style="margin-top: 1.25rem">
                            <?=$helpful['Review']['review'];?>
                            <!--?= substr($helpful['Review']['review'], 0, 270) . '...'; ?-->
                        </p>
                        <div class="posted_by">
                            Reviewed by <a class="author" href="<?= $this->webroot; ?>strains/review/all?user=<?= $userid; ?>"
                                           title="<?= $username; ?>"><?= $username; ?></a>
                            <?php if ($helpful['Review']['on_date'] != "0000-00-00") {
                                echo " on " . $helpful['Review']['on_date'];
                            } ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

<?php } else {
    echo '<div style="padding-top: 10px;padding-bottom:10px;">No reviews yet</div>';
}
errorlog("include combine/strain_reviews.php success");
?>
