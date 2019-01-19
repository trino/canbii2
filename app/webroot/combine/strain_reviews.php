    <?php
        errorlog("include combine/strain_reviews.php");
        if ($helpful) {
    ?>
        <div class="">
            <div id="">
                <ul>
                    <li class="comment clearfix">
                        <div class="comment_details">
                            <a href="<?= $this->webroot; ?>review/detail/<?= $helpful['Review']['id']; ?>">
                                <?php
                                    $strain_hexagon = $strain;
                                    include('combine/hexagon.php');
                                    $j = 0;
                                    $rand1 = rand(100, 999);
                                    $rand2 = rand(100, 999);
                                ?>
                                <h2><?= $helpful['Strain']['name'];?></h2>
                            </a>

                            <script>
                                $(function () {
                                    $('.rating<?php echo $j;?>').raty({
                                        number: 5,
                                        readOnly: true,
                                        score:<?php echo $helpful['Review']['rate'];?>
                                    });
                                });
                            </script>
                            <div class="rating<?= $j;?> rat"></div>
                            <p style="margin-top: .5rem">
                                <?= substr( $helpful['Review']['review'], 0, 270) . '...'; ?>
                            </p>
                            <div class="posted_by">
                                Reviewed by <a class="author" href="<?php echo $this->webroot;?>strains/review/all?user=<?php echo $helpful['Review']['user_id'];?>"
                                               title="<?php echo $this->requestAction('/strains/getUserName/' . $helpful['Review']['user_id']);?>"><?php echo $this->requestAction('/strains/getUserName/' . $helpful['Review']['user_id']);?></a>
                                <?php if($helpful['Review']['on_date']!= "0000-00-00") {echo " on " . $helpful['Review']['on_date'];}?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    <?php } else {
        echo '<div style="padding-top: 10px;padding-bottom:10px;"><i>No reviews yet<br></i></div>';
    }
    errorlog("include combine/strain_reviews.php success");
?>
