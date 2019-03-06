<?php //https://css-tricks.com/snippets/css/a-guide-to-flexbox/
    //other values PATHINFO_DIRNAME (/mnt/files) | PATHINFO_BASENAME (??????.mp3) | PATHINFO_FILENAME (??????)
    errorlog("include combine/images.php");
    $needsTRstart=true;
    $needsTRend=false;
    if(!isset($GLOBALS["includedfancy"])){
        $GLOBALS["includedfancy"] = true;
        echo '<link rel="stylesheet" type="text/css" href="' . $this->webroot . 'style2/fancybox/jquery.fancybox.css"/>
              <script type="text/javascript" src="' . $this->webroot . 'js2/jquery.fancybox-1.3.4.pack.js"></script>';
    }

    function panelsection($section){
        if(!isset($GLOBALS["currentsection"]) || $GLOBALS["currentsection"] != $section){
            $GLOBALS["currentsection"] = $section;
            echo '<TR><TD COLSPAN="2" STYLE="background-color: lightblue">' . $section . '</TD></TR>';
        }
    }

    $sizes = [];
    function panelthumb($webroot, $dir, $image, $sections, $currentsection, &$sizes){
        //https://localhost/canbii2/images/strains/1313/shishkaberry-redecan-0.png
        if(is_array($image)){
            foreach($image as $img){
                panelthumb($webroot, $dir, $img, $sections, $currentsection, $sizes);
            }
            return;
        }

        $filesize = filesize($dir . "/" . $image);
        panelsection($currentsection);
        $URL = $webroot . $dir . "/" . $image;
        echo '<TR><TD><div align="center" style="float:left;"><a class="fancybox" rel="group" href="' . $URL . '"><img class="reportimage" src="' . $URL . '"/></a></div>';

        echo '</TD><TD>' . $image . '<BR>' . $filesize . ' bytes<BR><SELECT NAME="' . $image .'" ONCHANGE="imagepanel(this);"><OPTION VALUE="">Leave in ' . $currentsection . '</OPTION><OPTION';
        if(in_array($filesize, $sizes)){
            echo ' SELECTED TITLE="Likely a duplicate"';
        } else {
            $sizes[] = $filesize;
        }
        echo '>Delete</OPTION>';
        foreach($sections as $section){
            if($section != $currentsection) {
                echo '<OPTION VALUE="' . $section . '">Move to: ' . $section . '</OPTION>';
            }
        }
        echo '</SELECT></TD></TR>';
    }

    $breaker = 0;
    $dir = "images/strains/" . $strain['Strain']['id'];
    $scanned = false;
    if (is_dir($dir) || isset($images)) {
        if(!isset($images)) {
            $scanned = true;
            $images = scandir($dir, SCANDIR_SORT_ASCENDING);
        }
        if(isset($_GET["images"])){
            //if(!$scanned) {$images = scandir($dir, SCANDIR_SORT_ASCENDING);}
            echo '<TABLE WIDTH="100%"><TH>Image</TH><TH>Action</TH>';
            $breaker = 1;
            echo $dir . '<BR>';

            $sections = ["Dried flower images"];
            foreach ($DATA as $INDEX => $OCSDATA) {
                $sections[] = $DATA[$INDEX]["slug"];
            }

            foreach ($DATA as $INDEX => $OCSDATA) {
                panelthumb($this->webroot, $dir, $OCSDATA["images"], $sections, $DATA[$INDEX]["slug"], $sizes);
            }

            panelthumb($this->webroot, $dir, $images, $sections, $sections[0], $sizes);
            echo '<TR><TD COLSPAN="2"><BUTTON CLASS="btn btn-primary" STYLE="width:100%;" ONCLICK="sendpanel();">Submit</BUTTON></TD></TR></TABLE>';
        } else {
            $imagecount = 0;
            foreach ($images as $file) {//for ($i = 1; $i < 5; $i++) {
                $ext = getextension2($file);
                if ($ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "png") {
                    $imagecount += 1;
                }
            }

            if ($imagecount > 0) {
                $rows = ceil($imagecount / 2);
                $rowheight = round(100 / $rows);
                //echo '<div id="Border" align="center">';

                foreach ($images as $file) {//for ($i = 1; $i < 5; $i++) {
                    $ext = getextension2($file);
                    if ($ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "png") {
                        if ($needsTRstart) {
                            //echo '<div align="center" style="margin-left: 6%">';
                            $needsTRstart = false;
                            $needsTRend = true;
                        }

                        $image = "images/strains/" . $strain['Strain']['id'] . "/" . $file;
                        //$image = "images/strains/" . $strain['Strain']['id'] . "/" . $strain['Strain']['slug'] . "_" . $i . ".jpg";
                        $filename = getcwd() . "/" . $image; //C:\wamp\www\marijuana\app\webroot
                        $image = $this->webroot . $image;
                        if (!file_exists($filename) && file_exists(str_replace(".jpg", ".jpeg", $filename))) {
                            $image = str_replace(".jpg", ".jpeg", $image);
                            $filename = str_replace(".jpg", ".jpeg", $filename);
                        }

                        if (file_exists($filename)) {
                            $breaker++;
                            echo '<div align="center" style="float:left;"><a class="fancybox" rel="group" href="' . $image . '"><img class="reportimage" src="' . $image . '"/></a></div>';
                            if ($breaker % 2 == 0 && $breaker > 0) {
                                // echo "</div>";
                                $needsTRend = false;
                                $needsTRstart = true;
                            }
                        }
                    }
                }
                if ($needsTRend) {
                    echo '<div class="item" style="border: none" align="center"></div>';
                }
            }
        }
    }
    if ($breaker==0){
        echo "<P>No images yet</P>";
    }
    if(isset($_GET["images"])){
?>
<SCRIPT>
    var actions = {
        webroot:    "<?= $this->webroot; ?>",
        root:       '<?= addslashes(getcwd()); ?>',
        directory:  "<?= $dir; ?>",
        images: {}
    };

    function imagepanel(element){
        var image = $(element).attr("name");
        var value = $(element).val();
        actions["images"][image] = value;
        console.log(actions);
    }

    function sendpanel(){
        $.post(webroot + "call/images", actions, function (result) {
            alert(result);
            location.reload();
        });
    }
</SCRIPT>
<?php }
errorlog("include combine/images.php success");
?>