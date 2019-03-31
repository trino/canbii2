<?php

die('here');
    header( 'Content-type: text/html; charset=utf-8' );
    @ini_set('zlib.output_compression',0);
    @ini_set('implicit_flush',1);
    @ob_end_clean();
    $dir = getcwd() . "/ocs";
    $me = getme();
    set_time_limit(0);

    $options = [
        "makenewstrains"    => true,//disable to prevent new strains from bedownloadimagesing created
        "downloadimages"    => true,//disable to prevent downloading images
        "forceratingcalc"   => false,//enable to force a recalculation of the rating average              ONLY DO THIS ONCE!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        "forcefull"         => false,//enable to purge old data to load all of it fresh
    ];

    function filterheader($text, $withwhat = ''){
        $text = preg_replace('/[0-9]/', $withwhat, $text);
        $text = str_replace(['"', ","], "", $text);
        return trim($text);
    }

    function parserory($filename){
        $handle = fopen($filename, "r");
        $data = [];
        if ($handle) {
            $mode = false;
            $tonum = false;
            $tobool = false;
            while (($line = fgets($handle)) !== false) {
                $line = str_getcsv($line);
                $key = filterheader($line[0]);
                switch($key){
                    case "URL": case "Strain": break;//not needed
                    case "General":
                        $mode = $key;
                        break;
                    case "Effects":
                        $mode = $key;
                        $tonum = true;
                        break;
                    case "Flavours (marked )":
                        $mode = "Flavors";
                        $tobool = true;
                        break;
                    default:
                        unset($line[0]);
                        foreach($line as $index => $value){
                            $value = trim($value);
                            if(!isset($data[$index])){
                                $data[$index] = [];
                            }
                            if($mode){
                                if($tobool) {
                                    if (strlen($value) > 0) {
                                        $data[$index][$mode][$key] = 5;//since he didn't rate it, give it a fake rating that won't throw off the system.
                                    }
                                } else if($tonum){
                                    if (strlen($value) > 0 && $value > 0) {
                                        $data[$index][$mode][$key] = intval($value);
                                    }
                                } else {
                                    $data[$index][$mode][$key] = $value;
                                }
                            } else {
                                $data[$index][$key] = $value;
                            }
                        }
                }
            }
            fclose($handle);
        }
        return $data;
    }

    if(isset($_GET["action"])) {
        switch(strtolower($_GET["action"])){
            case "rory":
                $data = parserory($dir . "/rory.csv");
                $tables = [
                    "Effects" => query("SELECT * FROM effects"),
                    "Flavors" => query("SELECT * FROM flavors")
                ];
                foreach($data as $newdata){
                    $strain = first("SELECT * FROM strains WHERE slug='" . $newdata["Slug"] . "'");
                    if($strain) {
                        insertdb("strains", ["id" => $strain["id"], "description" => $newdata["Description"]]);
                        if(!isset($newdata["General"]["Duration"])){$newdata["General"]["Duration"] = 0;}
                        if(!isset($newdata["General"]["Strength"])){$newdata["General"]["Strength"] = 0;}
                        if(!isset($newdata["General"]["Scale"])){$newdata["General"]["Scale"] = 0;}
                        $reviewid = insertdb("reviews", [
                            "strain_id"     => $strain["id"],
                            "user_id"       => $me,
                            "form"          => "rory",
                            "rate"          => -1,//tells the system not to average it
                            "eff_scale"     => $newdata["General"]["Scale"],
                            "eff_duration"  => $newdata["General"]["Duration"],
                            "eff_strength"  => $newdata["General"]["Strength"]
                        ]);
                        foreach($tables as $tablename => $tabledata){
                            $ratetable = left(strtolower($tablename), strlen($tablename) - 1) . "_ratings";
                            if(isset($newdata[$tablename])){
                                $alleffects = [];
                                foreach($newdata[$tablename] as $title => $rating){
                                    $effect = getiterator($tabledata, "title", $title);
                                    if($effect){
                                        $alleffects[] = $effect["id"];
                                        insertdb($ratetable,[
                                            "strain_id"     => $strain["id"],
                                            "user_id"       => $me,
                                            "review_id"     => $reviewid,
                                            "rate"          => $rating,
                                            str_replace("_ratings", "_id", $ratetable) => $effect["id"]
                                        ]);
                                    }
                                }
                                if($tablename == "Effects" && $alleffects){
                                    insertdb("reviews", [
                                        "id"            => $reviewid,
                                        "effectscount"  => count($alleffects),
                                        "effects"       => implode(",", $alleffects)
                                    ]);
                                }
                            }
                        }
                    }
                }
                break;
            default:
                die($_GET["action"] . " not handled");
        }
        die($_GET["action"] . " done");
    }

    $uniques = collapsearray(query("SELECT MIN(id) as id FROM flavors GROUP BY title HAVING MIN(id) IS NOT NULL", true), "id");
    $uniques = implode(",", $uniques);
    query("DELETE FROM flavors WHERE id NOT IN (" . $uniques . ")");

    table_has_column("reviews", "effectscount", "INT(11)");
    table_has_column("reviews", "effects", "VARCHAR(2048)");
    $query = query("SELECT id FROM reviews WHERE effectscount=0");
    if ($query) {
        $total = mysqli_num_rows($query);
        $current = 0;
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $current+=1;
            $ratings = query("SELECT effect_id FROM effect_ratings WHERE review_id =" . $row["id"], true);
            $row["effectscount"] = count($ratings);
            $row["effects"] = "";
            if($row["effectscount"]) {
                $row["effects"] = implode(",", collapsearray($ratings, "effect_id"));
                insertdb("reviews", $row);
            }
            purge("<BR>Repaired: " . $current . "/" . $total . " (" . floor(($current/$total)*100) . "%) = " . $row["effects"] . " (" . $row["effectscount"] . ")");
        }
    }

    die("<BR>effects repaired");

    $ratingstables = ['activity_ratings', 'colour_ratings', 'effect_ratings', 'flavor_ratings', 'symptom_ratings'];
    $SQL = '';
    foreach($ratingstables as $table){
        if($SQL){
            $SQL .= " UNION ";
        }
        $SQL .= "SELECT id, rate, '" . $table . "' as tablename FROM " . $table . " WHERE rate > 5";
    }

    $data = query($SQL, true);
    if($data){
        $options["ratingserror"] = true;
        $options["forceratingcalc"] = true;
        //foreach($ratingstables as $table){
        //    query("UPDATE '" . $table . "' SET rate = rate / 20 WHERE rate > 5");
        //}
        foreach($data as $row){
            insertdb($row["tablename"], ["id" => $row["id"], "rate" => $row["rate"] / 20]);
        }
    }

    function is_item_array($array){
        foreach($array as $key => $value){
            if(!is_numeric($key)){
                return true;
            }
        }
        return false;
    }

    /*
    $FILENAME = getcwd() . '/description.csv';
    if(file_exists($FILENAME)) {
        $data = loadCSV($FILENAME);
        foreach ($data as $ID => $ROW) {
            $DATABASE = first("SELECT * FROM strains WHERE slug='" . $ROW["slug"] . "'");
            if(is_array($DATABASE)){
                foreach ($DATABASE as $KEY => $VALUE) {
                    if (isset($ROW[$KEY]) && $ROW[$KEY]) {
                        $DATABASE[$KEY] = $ROW[$KEY];
                    }
                }
                insertdb("strains", $DATABASE);
            } else {
                echo '<BR>' .  $ROW["slug"] . " not found";
            }
        }
    } else {
        echo $FILENAME . " not found";
    }
    die("<BR>DONE");
    */

    App::uses('ReviewController', 'Controller');
    $ReviewController = new ReviewController();
?>
<SCRIPT>
    function bottom(){
        window.scrollTo(0,document.body.scrollHeight);
    }
</SCRIPT>
<STYLE>
    .parent{
        position: relative;
        top: -9px;
        width: 100%;
        min-width: 100px;
    }
    .progress{
        background-color: lightblue;
        position: absolute;
        left: 0;
        top: 0;
        height: 18px;
        z-index: 1;
        border-radius: 0px !important;
    }
    .indicator{
        width: 100%;
        text-align: center;
        z-index: 20;
        color: red;
        position: absolute;
        left: 0;
        top: 0;
        height: 18px;
        border-radius: 0px !important;
    }
    .error{
        color: white;
        background-color: red;
        font-weight: bold;
        text-align: center;
        animation: blinker 1s cubic-bezier(.5, 0, .5, .5) infinite alternate;
    }
    @keyframes blinker { to { opacity: 0; } }
    .stack-trace{
        color: black;
    }
</STYLE>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/style.css"/>
<TABLE WIDTH="100%"><TR><TD>
<?php
    $CAT = '?cat=strain';
    $negativeeffects = ["bad taste", "cough", "dry mouth", "harsh", "headache", "lazy", "red eyes", "talkative", "weak"];
    include("extradata.php");

    function saveCSV($file, $data){
        $file = fopen($file,"w");
        $first = true;
        foreach($data as $line) {
            if($first){
                $KEYS = array_keys($line);
                fputcsv($file, $KEYS);
                $first = false;
            }
            fputcsv($file, array_combine($KEYS, $line));
        }
        fclose($file);
    }
    function loadCSV($file){
        $csv = array_map('str_getcsv', file($file));
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv); # remove column header
        return $csv;
    }

    function extractreviews($page = false, $URL = false, $count = false){
        if(is_numeric($page)){//10 per page
            $start = strpos($URL, "?");
            $URL = left($URL, $start) . '/reviews';//https://www.leafly.com/products/details/liiv-bali-kush/reviews
            if($page > 1){
                $URL .= "?page=" . $page;
            }
            $HTML = file_get_contents($URL);
            $REVIEWS = explode('<div class="product-review"', $HTML);
        } else {//3 per page
            $REVIEWS = explode('<div class="product-review"', getbetween($page, '<div class="product-reviews">', '<p class="heading"><span class="heading-text">About Us</span></p>'));
        }
        unset($REVIEWS[0]);
        foreach($REVIEWS as $INDEX => $REVIEWHTML) {
            $REVIEWS[$INDEX] = [
                "name" => getbetween($REVIEWHTML, '<div class="author">', '</div>'),
                "rate" => getbetween($REVIEWHTML, 'star-rating="', '" class'),
                "time" => trim(getbetween($REVIEWHTML, '<span am-time-ago="', '" title'), "'"),
                "text" => getbetween($REVIEWHTML,'<div class="full-review-text">', '</div>')
            ];
        }
        return array_values($REVIEWS);
    }

    function isURL($text){
        //if(textcontains($text, "<") || textcontains($text, PHP_EOL) || strlen($text) > 255){return false;}
        //if(startswith($text, "http://") || startswith($text, "https://")) {
            return filter_var($text, FILTER_VALIDATE_URL);
        //}
        //return false;
    }

    function cleanhtml($HTML){
        $HTML = preg_replace('/\R/', '', $HTML);
        $HTML = preg_replace('/\s+/', ' ', $HTML);
        $HTML = str_replace('> <', '><', $HTML);
        return $HTML;
    }

    function extractleafly($URL, $type = "product"){
        //$URL = https://www.leafly.com/products/details/liiv-bali-kush?q=bali-kush&cat=product
        $HTML = $URL;
        $DATA = [];
        if(isURL($URL)) {
            $DATA["url"] = $URL;
            $HTML = file_get_contents($URL);
        }
        switch($type) {
            case "product":
                $SCRIPT = '<script type="application/ld+json">';
                $DATA["reviews"] = [];
                $start = strpos($HTML, $SCRIPT);
                while ($start !== false) {
                    $end = strpos($HTML, '</script>', $start);
                    $JSON = mid($HTML, $start + strlen($SCRIPT), $end - strlen($SCRIPT) - $start);
                    $DATA = array_merge($DATA, json_decode($JSON, true));
                    $start = strpos($HTML, $SCRIPT, $end);
                }
                if ($DATA["aggregateRating"]["reviewCount"] > 0) {
                    $pages = ceil($DATA["aggregateRating"]["reviewCount"] / 10);
                    echo '<BR>' . $URL . " " . $DATA["aggregateRating"]["reviewCount"] . " Reviews found across " . $pages . " pages";
                    if ($DATA["aggregateRating"]["reviewCount"] > 3) {
                        $REVIEWS = [];
                        for ($page = 1; $page <= $pages; $page++) {
                            $REVIEWS = array_merge($REVIEWS, extractreviews($page, $URL, $DATA["aggregateRating"]["reviewCount"]));
                        }
                    } else {
                        $REVIEWS = extractreviews($HTML);
                    }
                    $DATA["reviews"] = $REVIEWS;
                }
                break;
            case "strain":
                $description = getbetween($HTML, '<div class="description" itemprop="description">', '</div>');
                $description = trim(strip_tags($description, '<p><br>'));
                $description = trim2(trim2($description, '<p>'), '</p>');
                $DATA = [
                    "url"           => $URL,
                    "name"          => getbetween($HTML, '<h1 class="heading--sm heading-md--lg l--spacer" itemprop="name">', '</h1>'),
                    "description"   => $description,
                    "effects"       => extractleafly($HTML, 'Effects'),
                    "medical"       => extractleafly($HTML, 'Medical'),
                    "negatives"     => extractleafly($HTML, 'Negatives'),
                    "flavors"       => extractleafly($HTML, 'Flavors'),
                    "lineage"       => extractleafly($HTML, 'Lineage'),
                    "growinfo"      => extractleafly($HTML, 'Growinfo'),
                    "images"        => extractleafly($HTML, 'Photos'),
                    "reviews"       => extractleafly($HTML, 'Reviews'),
                ];
                break;

            //sections of a leafly strain
            case "Reviews":
                $HTML = getbetween($HTML, '<h2 class="heading--md heading-md--lg">Review Highlights</h2>', '</section>');
                $DATA["total"] = getbetween($HTML, 'View All (', ')</a>');
                $DATA["url"]   = 'https://www.leafly.com' . getbetween($HTML, 'href="', '">');
                $DATA["examples"] = [];
                $HTML = explode('<div class="m-review">', $HTML);
                unset($HTML[0]);
                foreach($HTML as $effect) {
                    $url = getbetween($effect, 'href="', '"');
                    $DATA["examples"][] = [
                        "user_url"   => "https://www.leafly.com" . $url,
                        "user_name"  => getbetween($effect, '<a class="no-color" href="' . $url . '">', '</a>'),
                        "timestamp"  => getbetween($effect, 'datetime="', '"'),
                        "rating"     => getbetween($effect, 'star-rating="', '"'),
                        "review_url" => "https://www.leafly.com" . getbetween(getbetween($effect, '<div class="m-review__more-details grid-1 l-grid">', '</div>'), '<a href="', '"'),
                        "review_txt" => getbetween($effect, '<p class="copy--xs copy-md--md">&#8220;', '&#8221;</p>')
                    ];
                }
                break;
            case "Photos":
                $HTML = getbetween($HTML, '<h2 class="heading--md heading-md--lg">Photos</h2>', '</section>');
                $DATA["total"] = getbetween($HTML, 'View All (', ')</a>');
                $DATA["url"]   = 'https://www.leafly.com' . getbetween($HTML, 'href="', '">');
                $DATA["examples"] = [];
                $HTML = explode('<li class="pull-left l-grid__item--space">', $HTML);
                unset($HTML[0]);
                foreach($HTML as $effect){
                    $DATA["examples"][] = getbetween($effect, 'src="', '"');
                }
                break;
            case "Growinfo":
                $HTML = getbetween($URL, '<div m-animate m-animate-default="" m-animate-play="backgroundFadeIn" class="growInfoContainer">', '<div class="strain-tile notranslate" ng-cloak>');
                $HTML = explode('<div class="growInfoRow', $HTML);
                unset($HTML[0]);
                foreach($HTML as $effect){
                    $DATA[ trim(getbetween($effect, '<div col col-sm="2" class="strain__data">', '<')) ] = trim(strip_tags(getbetween($effect, '<div col="one-third" class="selected">', '</div>')));
                }
                break;
            case "Lineage":
                $HTML = getbetween($URL, str_replace("`", "'", '<div class="strain__lineage strain__dataTab" ng-style="{`visibility`:`visible`}" ng-show="currentDataTab===`lineage`">'), '</section>');
                $HTML = explode('<li class="pull-left">', $HTML);
                unset($HTML[0]);
                foreach($HTML as $effect){
                    $DATA[] = getbetween($effect, '<tspan y="380" x="0" text-anchor="end">', '</tspan>');
                }
                break;
            case "Flavors":
                $HTML = getbetween($URL, '<section class="strain__flavors padding-listItem divider bottom">', '</section>');
                $HTML = explode('</li>', $HTML);
                foreach($HTML as $effect){
                    $DATA[] = getbetween($effect, 'title="', '"');
                }
                unset($DATA[array_key_last($DATA)]);
                break;
            case "Effects": case "Medical": case "Negatives":
                $HTML = cleanhtml($URL);
                $start = '<div class="m-histogram" ng-style="{' . "'visibility':'visible'}" . '" ng-show="currentAttributeTab===' . "'" . $type . "'" . '">';
                $HTML = getbetween($HTML, $start, '</div></div></div></div></div>');
                $HTML = explode('<div class="m-histogram-item-wrapper">', $HTML);
                unset($HTML[0]);
                foreach($HTML as $effect){
                    $DATA[ getbetween($effect, '<div class="m-attr-label copy--sm">', '</div>') ] = round(getbetween($effect, '<div class="m-attr-bar" style="width:', '%">') / 20, 2);
                }
                break;
        }
        return $DATA;
    }

    function getleaflydata($filename, $url, $type = "product"){
        if(!file_exists($filename)) {
            $DATA = extractleafly($url, $type);
            $JSON = json_encode($DATA, JSON_PRETTY_PRINT);
            file_put_contents($filename, $JSON);
            return $DATA;
        }
        return json_decode(file_get_contents($filename), true);
    }

    foreach($extradata as $strain => $data){
        if(!is_item_array($data)){
            $data = $data[0];
        }
        if(isset($data["urls"])) {
            foreach ($data["urls"] as $url) {
                $urldata = parse_url($url);
                $urldata["path"] = explode("/", trim($urldata["path"], "/"));
                parse_str($urldata["query"], $urldata["query"]);
                if (isset($urldata["query"]["cat"])) {
                    $filename = false;
                    switch ($urldata["query"]["cat"]) {
                        case "product":
                            $filename = $dir . '/' . array_value_last($urldata["path"]) . "-leafly.json";
                            break;
                        case "strain":
                            $filename = $dir . '/' . $strain . "-leaflystrain.json";
                            break;
                    }
                    if ($filename && !file_exists($filename)) {
                        purge("<BR>Downloading Leafly " . $urldata["query"]["cat"] . " data: " . $strain . " to " . $filename);
                        getleaflydata($filename, $url, $urldata["query"]["cat"]);
                    }
                }
            }
        }
    }

    function purge($text = "", $bottom = true){
        if($bottom){$text .= '<SCRIPT>bottom();</SCRIPT>';}
        if($text){echo $text;}
        flush();
        if( ob_get_level() > 0 ){ob_flush();}
    }

    function table_has_column($tablename, $column, $type = false, $null = false, $default = false, $after = false, $isprimarykey = false, $comment = false){
        $tables = describe($tablename);
        foreach($tables as $table){
            if($table["Field"] == $column){
                return true;
            }
        }
        if($type) {
            $SQL = "ALTER TABLE " . $tablename . " ADD COLUMN " . $column . " " . $type;
            if (!$null) {
                $SQL .= " NOT NULL";
            }
            if($default !== false){
                if(is_numeric($default)){
                    $SQL .= " DEFAULT " . $default;
                } else {
                    $SQL .= " DEFAULT '" . $default . "'";
                }
            }
            if ($isprimarykey) {
                $SQL .= " AUTO_INCREMENT PRIMARY KEY";
            }
            if($comment){
                $SQL .= " COMMENT '" . $comment . "'";
            }
            if ($after === true) {
                $SQL .= " FIRST";
            } else if ($after) {
                $SQL .= " AFTER " . $after;
            }
            query($SQL);
            echo "<BR>Created " . $column . " (" . $type . ") column in " . $tablename;
        }
    }

    function trimleft($Text, $Startingtext, $isStart = true){
        $start = strpos($Text, $Startingtext);
        if($start !== false) {
            if($isStart) {
                return right($Text, strlen($Text) - $start);
            }
            return left($Text, $start);
        }
        return $Text;
    }

    function file_get_cookie_contents_ocs($method = "GET", $URL, $querydata = false, $POSTdata = false, $Cookie = false, $isGZIP = true, $HEADERS = false){
        $headers = [
            'Referer' =>  			'https://ocs.ca/collections/1-gram-packs-of-cannabis?page=4&hitsPerPage=12',
            'Accept' => 			'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Encoding' => 	'gzip',
            'Accept-Language' => 	'en-US,en;q=0.9',
            'Cache-control'	=>		'max-age=0',
            'Connection' => 		'keep-alive',
            'Host' => 				'ocs.ca',
            'User-Agent' => 		'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
            'If-None-Match' =>		'cacheable:b2a12efabf26cf0744bfd308dc9e7d5d',
            'Upgrade-Insecure-Requests' => 1
        ];
        if(is_array($HEADERS)){
            foreach($HEADERS as $KEY => $VALUE){
                if($VALUE) {
                    $headers[$KEY] = $VALUE;
                } else {
                    unset($headers[$KEY]);
                }
            }
        }
        if(is_array($Cookie)){
            $header = $Cookie;
            $Cookie = "";
            foreach($header as $key => $value){
                $Cookie .= $key . "=" . $value . "; ";
            }
            $Cookie = trim($Cookie);
        }
        $header = "";
        foreach($headers as $key => $value){
            $header .= $key . ": " . $value . "\r\n";
        }
        $header .= "Cookie: " . $Cookie . "\r\n";
        $method = trim(strtoupper($method));
        if($method == "GET"){
            $opts = array('http'=>array('method'=>"GET",'header'=> $header));
        } else {
            $opts = array('http'=>array('method'=>"POST",'header'=> $header,'content' => $POSTdata));
        }
        $context = stream_context_create($opts);
        if(is_array($querydata)){
            $dilimiter = "?";
            foreach($querydata as $KEY => $VALUE){
                $URL .= $dilimiter . $KEY . "=" . urlencode($VALUE);
                $dilimiter = "&";
            }
        }
        try{
            $DATA = file_get_contents($URL, false, $context);
            if($isGZIP) {
                return gzdecode($DATA);
            }
            return $DATA;
        } catch (Exception $e){
            return $URL . " failed";
        }
    }

    function decode($HTML){
        $HTML = htmlentities($HTML);
        $HTML = str_replace("\/", "/", $HTML);
        $nextletter = 0;
        for($i = strlen($HTML) - 1; $i > -1; $i--){
            $letter = ord(mid($HTML, $i, 1));
            if($nextletter == 34 && $letter == 92){
                $HTML = left($HTML, $i-1) . right($HTML, strlen($HTML) - $i - 2);
            }
            $nextletter = $letter;
        }
        return $HTML;
    }

    function json_decode2($TEXT){
        $JSON = json_decode($TEXT, true);
        if(is_array($JSON) && $JSON){
            return $JSON;
        }
        $TEXT = decode($TEXT);
        $one = '"https://ocs.ca/collections/1-gram-packs-of-cannabi]"';
        $two = '"https://ocs.ca/collections/tous-les-produit]"';
        $TEXT = str_replace([$one, $two], ['"links": [' . $one, $two . "],"], $TEXT);
        return json_decode($TEXT, true);
    }

    function getbetween2($TEXT, $START, $END){
        return getbetween($TEXT, htmlspecialchars($START), htmlspecialchars($END));
    }

    function extractdata($productname){//https://ocs.ca/products/blue-dream-pre-roll
        global $Cookie;
        $productname = str_replace(" ", "-", strtolower($productname));
        $URL = "https://ocs.ca/products/" . $productname;
        $HTML = file_get_cookie_contents_ocs("GET", $URL, false, false, $Cookie);
        //$HTML2 = htmlspecialchars($HTML);
        $data = json_decode2(getbetween($HTML, '<script type="application/ld+json">', '</script>'));
        $data["shorttext"] 	= decode(getbetween($HTML, '<p data-full-text="', '" >'));
        $data["price"] 	= getbetween($HTML, '<h2 class="product__price">', '</h2>');
        $data["URL"] = $URL;

        $tabledata = getbetween($HTML, '<table id="product__properties-table" class="table--striped product__properties-table">', '</table>');
        $tabledata = explode('</tr>', $tabledata);
        foreach($tabledata as $INDEX => $cells){
            $cells = explode('</td>', trim($cells));
            foreach($cells as $ID => $cell){
                $cells[$ID] = trim(strip_tags($cell));
            }
            $tabledata[$INDEX] = array_filter($cells);
            if(isset($tabledata[$INDEX][0]) && $tabledata[$INDEX][0]){
                $KEY = $tabledata[$INDEX][0];
                $VALUE = $tabledata[$INDEX][1];
                switch($KEY){
                    case "GTIN#": break;
                    case "Terpenes":
                        $data["Terpenes"] = explode(",\n", str_replace("  ", "", $VALUE));
                        break;
                    default: $data[$KEY] = $VALUE;
                }
            }
        }
        $HTML2 = getbetween($HTML, 'window.theme.product_json =', ';');
        $data2 = json_decode2($HTML2);
        if(is_array($data2)){
            $data = array_merge($data, $data2);
        } else {
            $data["Missing"] = $HTML2;
        }
        $images = explode('</div>', getbetween($HTML, '<div class="product-images__carousel">', '</div></div>'));
        foreach($images as $INDEX => $HTML){
            $HTML = trim(str_replace('<div class="product-images__slide">', '', $HTML));
            $images[$INDEX] = "https:" . getbetween($HTML, '<img src="', '"');
        }
        $data["images"] = $images;
        return $data;
    }

    function renameimage($sourcedir, $image, $destdir){
        $extension = getextension2($image);
        $filename = getfilename($image, false);

        for($number = 0; $number < 9999; $number++){
            $newfilename = $destdir . "/" . $filename . $number . "." . $extension;
            if(!file_exists($newfilename)){
                @rename($sourcedir . "/" . $image, $newfilename);
                return $newfilename;
            }
        }
        return "";
    }

    function mergeslugs($first, $duplicateID){
        if($duplicateID != $first["id"]) {
            deleterow("strains", "id=" . $duplicateID);
            foreach(["activity_ratings", "colour_ratings", "doctor_strains", "effect_ratings", "flavor_ratings", "overall_activity_ratings", "overall_colour_ratings", "overall_effect_ratings", "overall_flavor_ratings", "overall_symptom_ratings", "symptom_ratings", "symptom_votes", "user_effect_ratings", "user_symptom_ratings"] as $table){
                $items = query("SELECT * FROM " . $table . " WHERE strain_id=" . $duplicateID, true);
                foreach($items as $item){
                    $item["strain_id"] = $first["id"];
                    insertdb($table, $item);
                }
            }

            $dir = getcwd() . "/images/strains/" . $duplicateID;
            $dir2 = getcwd() . "/images/strains/" . $first["id"];
            if(is_dir($dir)) {
                $images = scandir($dir);
                unset($images[0]);
                unset($images[1]);
                foreach ($images as $image) {
                    renameimage($dir, $image, $dir2);
                }
            } else {
                die($dir . " not found");
            }

            $ocs = query("SELECT * FROM ocs WHERE strain_id=" . $duplicateID);
            $ocs["strain_id"] = $first["id"];
            $ocs["slug"] = $first["slug"];
            insertdb("ocs", $ocs);
        }
    }

    deleterow("strains", "slug='sun'");
    deleterow("strains", "slug='sativa-pre-roll-pack'");
    $duplicates = query("SELECT id, slug, count(*) as count FROM strains  GROUP BY slug HAVING count > 1 ORDER BY id DESC", true);
    if($duplicates) {
        $duplicates[] = first("SELECT * FROM strains WHERE slug='sativa-pre-roll-pack'");
        $duplicates[] = first("SELECT * FROM strains WHERE slug='sativa-oil-1'");
    }

    vardump($duplicates);

    $types = query("SELECT * FROM strain_types", true);
    foreach($duplicates as $duplicate){
        if(is_array($duplicate)) {

            switch($duplicate["slug"]){
                case "sativa-oil-1": case "sativa-pre-roll-pack":
                    $duplicate["slug"] = "sativa";
                    break;
            }

            $first = first("SELECT * FROM strains WHERE slug='" . $duplicate["slug"] . "' AND id != " . $duplicate["id"]);
            if(is_array($first) && count($first)) {
                mergeslugs($first, $duplicate["id"]);
                purge('<BR>Fixing: ' . $duplicate["slug"]);
            }
        }
    }
    $needed = ["bali-kush" => "bali-kush-liiv", "galiano" => "galiano", "relief" => "relief", "san-fernando-valley" => "san-fernando-valley-1"];
    foreach($needed as $CANBIIslug => $OCSslug){
        $filename = $dir . "/" . $OCSslug . ".json";
        $URL = 'https://ocs.ca/products/' . $OCSslug;
        if(!file_exists($filename)) {
            $data = extractdata($OCSslug);
        } else if(file_exists($filename)) {
            $data = json_decode(file_get_contents($filename), true);
        }
        $data = import($CANBIIslug, $data, $me, $types, "hardcoded", $options, $extradata, $negativeeffects, $dir, $ReviewController);
        purge("FIXING: " . $CANBIIslug);
    }
    die("DONE FIXING DUPLICATES");

    function enumstrains($collection, $page = -1){
        global $Cookie;
        if($collection == "hardcoded"){
            $HTML = ["kinky-kush"];//, "delahaze"];
        } else {
            $URL = "https://ocs.ca/collections/" . $collection;
            if ($page > 0) {
                $URL .= '?page=' . $page . '&hitsPerPage=12';
            }
            $HTML = html_entity_decode(file_get_cookie_contents_ocs("GET", $URL, false, false, $Cookie));
            $products = getbetween($HTML, '<div class="collection__count hidden-mobile"><span>', '</span>');
            $itemsperpage = 12;
            $pages = ceil($products / $itemsperpage);
            $HTML = explode('<a href="/products/', $HTML);
            foreach ($HTML as $ID => $VAL) {
                $VAL = strip_tags(getbetween('<a href="' . $VAL, '<a href="', '"'));
                $VAL = trim(str_replace("\\n", "\n", $VAL));
                $HTML[$ID] = $VAL;
            }
            if ($page == -1) {//getall
                for ($page = 1; $page < $pages; $page++) {
                    $HTML = array_merge($HTML, enumstrains($collection, $page));
                }
            }
        }
        $HTML = array_values(array_unique(array_filter($HTML)));
        sort($HTML);
        return $HTML;
    }

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    function getme(){
        $me = first("SELECT * FROM users WHERE email='roy@trinoweb.com'");
        if($me) {
            $me = $me["id"];
        } else {
            $me = [
                "username"  => "tahiri",
                "email"     => "roy@trinoweb.com",
                "password"  => "511e15842eb41df50d55b710d9c9652b",
                "user_type" => 1,
                "country"   => "Canada"
            ];
            $me = insertdb("users", $me);
        }
        return $me;
    }

    function getstrain($slug){
        return first("SELECT * FROM strains WHERE slug='" . $slug . "'");
    }

    function trimend2($Text, $Trim){
        if(endswith(strtolower($Text), strtolower($Trim)) ){
            $Text = left($Text, strlen($Text) - strlen($Trim));
        }
        return trim($Text);
    }

    function cleanslug($slug = "lemon-skunk-capsules-2-5mg"){
        if(!is_array($slug)){$slug = explode("-", strtolower($slug));}
        $last = end($slug);
        if(is_numeric($last)){
            unset($slug[count($slug) - 1]);//bakerstreet-capsules-2-5mg
            $last = end($slug);
        }
        if (endswith($last, "mg") && is_numeric(left($last, strlen($last) - 2))) {
            unset($slug[count($slug) - 1]);//bakerstreet-capsules-2-5mg
            if(count($slug) > 1 && is_numeric($slug[count($slug) - 1])){
                unset($slug[count($slug) - 1]);
            }
        }
        $wordstoremove = ["oil", "oral", "spray", "mct", "thc", "peppermint", "capsules", "pre", "roll", "pack", "canaca", "sativa", "redecan", "woodstock", "symbl", "cbd"];
        $last = count($slug) - 1;
        foreach(array_reverse($slug) as $index => $word){
            $index = $last - $index;
            if(in_array(strtolower($word), $wordstoremove) || is_numeric($word)){
                unset( $slug[$index] );
            } else {
                break;
            }
        }
        $slug = implode("-", $slug);
        $vendors = ["Alta Vie", "San Rafael", "Haven St", "roll pack"];
        foreach($vendors as $vendor){
            $slug = trimend2($slug, "-" . str_replace(" ", "-", strtolower($vendor)));
        }
        return $slug;
    }

    function fromclassname($slug){
        $slug = explode("-", $slug);
        foreach($slug as $KEY => $VALUE){
            $slug[$KEY] = ucfirst($VALUE);
        }
        return trim(implode(" ", $slug));
    }

    function handleeffect($name, $negative = 0){
        $data = first("SELECT * FROM effects WHERE title='" . $name . "'");
        if (!$data) {
            $data = ["title" => $name, "imported" => 2, "negative" => $negative];
            $data["id"] = insertdb('effects', $data);
        }
        return $data;
    }

    function cleanname($name){
        return trimend(trim(trimend(trimend2($name, "pre-roll"), "(")), "Â");
    }

    function explode2($array, $delimiter = ","){
        if(!is_array($array)){
            if($array) {
                $array = explode($delimiter, $array);
                foreach ($array as $KEY => $VALUE) {
                    $array[$KEY] = trim($VALUE);
                }
            } else {
                $array = [];
            }
        }
        return $array;
    }

    function effectOp($effects, $operation){
        if($operation > 0){
            foreach($effects as $effectname => $effectrating){
                switch($operation){
                    case 1: $effects[$effectname] = $effectrating / 20; break;//100 to 5, 0 to 0
                    case 2: $effects[$effectname] = (100 - $effectrating) / 20; break;//100 to 0, 0 to 5
                }
            }
        }
        return $effects;
    }
    function makereview($ReviewController, $StrainID, $FormID, $Rate, $Text, $Date, $UserID, $MedicalEffects = [], $PositiveEffects = [], $NegativeEffects = [], $effectOp = 0, $NegativeEffectsList = [], $Flavors = []){
        $found = first("SELECT * FROM reviews WHERE strain_id=" . $StrainID . " AND form='" . $FormID . "'");
        if (!$found) {
            $MedicalEffects =  effectOp($MedicalEffects, $effectOp);
            $PositiveEffects = effectOp($PositiveEffects, $effectOp);
            $NegativeEffects = effectOp($NegativeEffects, $effectOp);
            if(!is_numeric(left($Date, 1))){
                $Date = date("Y-m-d", strtotime($Date));
            }
            if($NegativeEffectsList) {
                foreach ($PositiveEffects as $KEY => $VALUE) {
                    if (in_array(strtolower($KEY), $NegativeEffectsList)) {
                        $NegativeEffects[$KEY] = $VALUE;
                        unset($PositiveEffects[$KEY]);
                    }
                }
            }
            $ReviewID = insertdb("reviews", [
                "user_id" => $UserID,
                "form" => $FormID,
                "rate" => $Rate,
                "review" => $Text,
                "strain_id" => $StrainID,
                "activitiescount" => 0,
                "on_date" => left($Date, 10),
                "symptomscount" => count($MedicalEffects),
                "symptoms" => processeffects($ReviewController, $MedicalEffects, "symptoms"),
            ]);
            if($MedicalEffects) {processeffects($ReviewController, $MedicalEffects,  "symptoms", $ReviewID, $UserID, $StrainID);   }
            if($PositiveEffects){processeffects($ReviewController, $PositiveEffects, "effects",  $ReviewID, $UserID, $StrainID, 0);}
            if($NegativeEffects){processeffects($ReviewController, $NegativeEffects, "effects",  $ReviewID, $UserID, $StrainID, 1);}
            if($Flavors)        {processeffects($ReviewController, $Flavors,         "flavors",  $ReviewID, $UserID, $StrainID);   }
            return $ReviewID;
        }
        return 0;
    }

    function processfound(&$localstrain, $found){
        if ($found == 0) {
            $localstrain["reviewsskipped"] += 1;
        } else {
            $localstrain["reviewsadded"] += 1;
        }
        return $found;
    }
    function processeffects($ReviewController, $effects, $table, $reviewID = false, $userID = false, $strainID = false, $negative = false){
        $RET = [];
        if(!isset($GLOBALS["effects"][$table])){
            $GLOBALS["effects"][$table] = query("SELECT * FROM " . $table, true);
        }
        if(!is_array($effects)){
            $effects2 = explode(",", $effects);
            $effects = [];
            foreach($effects2 as $effect){
                $effects[trim($effect)] = 5;
            }
        }
        $lastkey = array_key_last($effects);
        foreach($effects as $effectname => $effectrating){
            $effect = getiterator($GLOBALS["effects"][$table], "title", $effectname);
            if(!$effect){
                $effect = ["title" => $effectname];
                if($table == "effects"){
                    $effect["negative"] = $negative;
                }
                $effect["id"] = insertdb($table, $effect);
            }
            $RET[] = $effect["id"];
            if($reviewID){
                $ReviewController->addrating($strainID, $table, $effectrating, $effect["id"], $reviewID, $userID, $lastkey == $effectname);
            }
        }
        return implode(",", $RET);
    }

    function import($strain, $JSONdata, $me, $types, $collection, $options, $extradata, $negativeeffects, $dir, $ReviewController) {
        global $Cookie;
        $tags = [];
        $strain2 = false;
        $originalstrain = $strain;
        if (is_array($JSONdata)) {
            $localstrain = getstrain($strain);
            $mergeprices = false;

            //add new effects
            if (isset($JSONdata["tags"])) {
                foreach ($JSONdata["tags"] as $tag) {
                    if (startswith($tag, "effect--")) {
                        $tag = right($tag, strlen($tag) - 8);
                        $tags[$tag] = handleeffect($tag);
                    }
                }
            }

            if (!$localstrain) {
                $strain2 = cleanslug($strain);
                //echo " [BEFORE: " . $strain . "][AFTER: " . $strain2 . ']';
                if ($strain2 && $strain2 != $strain) {
                    $localstrain = getstrain($strain2);
                    $mergeprices = true;
                    $strain = $strain2;
                }
            }

            //add new strain
            if ($localstrain) {//update it
                if (!isset($localstrain["hasocs"]) || $localstrain["hasocs"] == 0) {
                    insertdb("strains", ["id" => $localstrain["id"], "hasocs" => 1]);
                }
            } else if (is_array($JSONdata) && isset($JSONdata["title"]) && isset($JSONdata["content"])) {//create it
                if($options["makenewstrains"]) {
                    $plant = explode(" ", $JSONdata["Plant"]);
                    $plant = $plant[0];
                    //if(endswith($JSONdata["title"], ""))
                    $localstrain = [
                        "hasocs"        => 1,
                        "type_id"       => getiterator($types, "title", $plant)["id"],
                        "name"          => cleanname($JSONdata["title"]),
                        "description2"  => $JSONdata["content"],
                        "slug"          => $strain,
                        "imported"      => "2"//0=native, 1=leafly, 2=ocs
                    ];
                    if ($localstrain["name"] && $localstrain["description2"]) {
                        $localstrain["id"] = insertdb("strains", $localstrain);
                    } else {
                        return "Error, name or description were blank";
                    }
                } else {
                    return "Skipped, makenewstrains=false";
                }
            } else {
                return false;
            }

            if (isset($localstrain["id"]) && $localstrain["id"]) {
                $ocsdata = false;// first("SELECT * FROM ocs WHERE strain_id=" . $localstrain["id"]);
                if (!$ocsdata && isset($JSONdata["content"])) {//add to ocs table
                    if (!isset($JSONdata["Terpenes"]) || !is_array($JSONdata["Terpenes"])) {
                        $JSONdata["Terpenes"] = [];
                    }
                    foreach(["thc", "cbd"] as $column) {
                        if (!isset($JSONdata[$column]) && isset($JSONdata[ strtoupper($column) ])) {
                            $JSONdata[$column] = $JSONdata[strtoupper($column)];
                        }
                    }
                    $ocsdata = [
                        "slug"      => $originalstrain,
                        "category"  => $JSONdata["type"],
                        "strain_id" => $localstrain["id"],
                        "shorttext" => $JSONdata["shorttext"],
                        "price"     => $JSONdata["price"],
                        "plant"     => $JSONdata["Plant"],
                        "terpenes"  => implode(", ", $JSONdata["Terpenes"]),
                        "content"   => $JSONdata["content"],
                        "available" => $JSONdata["available"] == "true",
                        "ocs_id"    => $JSONdata["id"],
                        "ocs_thc"   => $JSONdata["thc"],
                        "ocs_cbd"   => $JSONdata["cbd"]
                    ];
                }

                $prices = [];
                if ($mergeprices && isset($ocsdata["prices"]) && isJSON($ocsdata["prices"])) {
                    $prices = json_decode($ocsdata["prices"], true);
                }
                if (isset($JSONdata["variants"])) {
                    foreach ($JSONdata["variants"] as $variant) {
                        $data = [//data to be included in prices JSON
                            "price" =>      $variant["price"],
                            "slug" =>       $originalstrain,
                            "title" =>      $variant["public_title"],
                            "category" =>   $collection,
                            "vendor" =>     $JSONdata["vendor"]
                        ];
                        if($data["title"] === null){
                            $data["title"] = $variant["title"];
                        }
                        if($data["title"] == "Default Title"){
                            $data["title"] = $variant["name"];
                        }
                        $prices[] = $data;
                    }
                    $ocsdata["prices"] = json_encode($prices);
                }

                $JSONdata["downloadedimages"] = 0;
                $JSONdata["skippedimages"] = 0;
                if (isset($JSONdata["images"]) && $options["downloadimages"]) {
                    foreach ($JSONdata["images"] as $INDEX => $URL) {
                        $filename = $dir . $originalstrain . "-" . $INDEX . "." . getextension2($URL);
                        $dir2 = left($dir, strlen($dir) - 4) . "/images/strains/" . $localstrain["id"];
                        if(!is_dir($dir2)){
                            mkdir($dir2);
                        }
                        $actualfilename = $dir2 . "/" . $originalstrain . "-" . $INDEX . "." . getextension2($URL);
                        if(file_exists($filename)) {
                            $JSONdata["skippedimages"] += 1;
                            rename($filename, $actualfilename);
                        } else if(file_exists($actualfilename)) {
                            $JSONdata["skippedimages"] += 1;
                        } else {
                            //$DATA = file_get_contents("GET", $URL, false, false, $Cookie);
                            $DATA = file_get_contents($URL);
                            if($DATA) {
                                file_put_contents($actualfilename, $DATA);
                                $JSONdata["downloadedimages"] += 1;
                            } else {
                                $JSONdata["error"] = $URL . " FAILED TO DOWNLOAD";
                                return $JSONdata;
                            }
                        }
                    }
                }

                $localstrain["reviewsadded"] = 0;
                $localstrain["reviewsskipped"] = 0;
                if(isset($extradata[$strain])){
                    $data = $extradata[$strain];
                    if(is_item_array($data)){$data = [$data];}
                    //wanted:       lift and leafly: link, description, thc, cbd
                    //OCS table:    lift_url (TEXT), lift_description (TEXT), lift_thc (VARCHAR 16), lift_cbd (VARCHAR 16)
                    //data:         lift_url, lift_vendor, lift_thc, lift_cbd, lift_des, lift_flavors, lift_effects (combined, use $negativeeffects to compare) OR lift_badeffects AND lift_goodeffects, urls (leafly, array)
                    $URLs = [];
                    $ocsdata["lift_des"] = "";
                    $ocsdata["lift_thc"] = "0";
                    $ocsdata["lift_cbd"] = "0";
                    foreach($data as $cell){
                        $URLs[] = ["vendor" => $cell["lift_vendor"], "url" => $cell["lift_url"]];
                        foreach(["lift_des", "lift_thc", "lift_cbd"] as $column){
                            if($ocsdata[$column] == "0" && strlen($cell[$column]) > 0){
                                $ocsdata[$column] = $cell[$column];
                            }
                        }
                        if(isset($cell["reviews"])) {
                            foreach ($cell["reviews"] as $ID => $review) {
                                $MedicalEffects = [];
                                $PositiveEffects = [];
                                $NegativeEffects = [];
                                if ($ID == 0) {
                                    if (isset($cell["left_effects"])) {
                                        $PositiveEffects = $cell["left_effects"];
                                    }
                                    if (isset($cell["left_goodeffects"])) {
                                        $PositiveEffects = $cell["left_goodeffects"];
                                    }
                                    if (isset($cell["left_badeffects"])) {
                                        $NegativeEffects = $cell["left_badeffects"];
                                    }
                                }
                                $reviewID = processfound($localstrain, makereview($ReviewController, $localstrain["id"], "lift_" . $ID, $review["rating"] / 20, $review["text"], $review["date"], $me, $MedicalEffects, $PositiveEffects, $NegativeEffects, $effectOp = 2, $negativeeffects, $cell["lift_flavors"]));
                            }
                        }
                        if(isset($cell["urls"]) && is_array($cell["urls"])) {
                            foreach ($cell["urls"] as $url) {
                                $urldata = parse_url($url);
                                $urldata["path"] = explode("/", trim($urldata["path"], "/"));
                                parse_str($urldata["query"], $urldata["query"]);
                                if (isset($urldata["query"]["cat"])){
                                    switch ($urldata["query"]["cat"]) {
                                        case "product":
                                            $filename = $dir . '/' . array_value_last($urldata["path"]) . "-leafly.json";
                                            $localstrain["reviewfile"] = $filename;
                                            $data = getleaflydata($filename, $url);
                                            foreach ($data["reviews"] as $reviewindex => $review) {
                                                $reviewID = processfound($localstrain, makereview($ReviewController, $localstrain["id"], "leafly_" . $reviewindex, $review["rate"], $review["text"], $review["time"], $me));
                                            }
                                            break;
                                        case "strain":
                                            $filename = $dir . '/' . $strain . "-leaflystrain.json";
                                            $localstrain["strainfile"] = $filename;
                                            $found = first("SELECT * FROM reviews WHERE strain_id=" . $localstrain["id"] . " AND form='leaflystrain'");
                                            if ($found) {
                                                $localstrain["reviewsskipped"] += 1;
                                            } else {
                                                $data = getleaflydata($filename, $url, "strain");
                                                if (isset($data["reviews"]["examples"][0])) {
                                                    $localstrain["reviewsadded"] += 1;
                                                    $review = $data["reviews"]["examples"][0];
                                                    $reviewdata["id"] = makereview($ReviewController, $localstrain["id"], "leaflystrain", $review["rating"], $review["review_txt"], $review["timestamp"], $me, $data["medical"], $data["effects"], $data["negatives"]);
                                                } else {
                                                    $JSONdata["error"] = "Example review not found";
                                                }
                                            }
                                            break;
                                        default:
                                            $JSONdata["error"] = "CAT '" . $urldata["query"]["cat"] . "' not handled";
                                    }
                                } else {
                                    $JSONdata["error"] = "CAT not present";
                                }
                            }
                        }
                    }
                    //handle effects, symptoms, flavors
                    $ocsdata["lift_url"] = json_encode($URLs);
                }

                insertdb("ocs", $ocsdata);
                $localstrain["ocsdata"] = $localstrain;
                if ($mergeprices) {
                    $localstrain["mergedwith"] = $strain2;
                }
                return array_merge($JSONdata, $localstrain);
            }
        }
        return false;
    }


    table_has_column("strains", "hasocs", "TINYINT(4)");
    table_has_column("reviews", "activitiescount", "INT(11)");
    table_has_column("reviews", "activities", "VARCHAR(2048)");

    $collections = ["hardcoded"];//, "dried-flower-cannabis", "pre-rolled", "oils-and-capsules"];
    purge('<BR>Downloading all: ' . implode(", ", $collections));
    if(!is_dir($dir)){
        mkdir($dir, 0777);
    }
    $dir .= "/";

    $forceupdate = $options["forcefull"];//set to true to forcefully update the JSON from the site
    $Cookie = "_shopify_y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _orig_referrer=https%3A%2F%2Fwww.google.ca%2F; secure_customer_sig=; _landing_page=%2F; cart_sig=; _y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_fs=2019-01-15T15%3A44%3A52.677Z; _shopify_sa_p=; _ga=GA1.2.49790356.1547567094; _gid=GA1.2.1293338108.1547567094; _age_validated=true; _shopify_sa_t=2019-01-15T16%3A13%3A03.593Z";
    if(!enum_tables("activities")) {
        Query("CREATE TABLE `activities` (`id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(255) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB");
        $activities = ["Hiking", "Exercise", "Music", "Video Games", "Cleaning", "Yoga", "Meditation", "Movies", "Study", "Reading", "Working"];
        sort($activities);
        foreach($activities as $activity){
            insertdb("activities", ["title" => $activity, "imported" => 2]);
        }
        purge('<BR>activities table created and filled with (' . implode(", ", $activities) . ")");
    }
    if(!enum_tables("activity_ratings")) {
        Query("CREATE TABLE `activity_ratings` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL, `review_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL, `rate` varchar(255) NOT NULL, `strain_id` int(11) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB;");
        purge('<BR>activity_ratings table created');
    }
    if(!enum_tables("overall_activity_ratings")) {
        Query("CREATE TABLE `overall_activity_ratings` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `activity_id` INT NOT NULL , `rate` INT NOT NULL , `imported` TINYINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        purge('<BR>overall_activity_ratings table created');
    }

    $types = query("SELECT * FROM strain_types", true);
    if(!enum_tables("ocs")){
        Query("CREATE TABLE `ocs` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `shorttext` TEXT NOT NULL , `price` INT NOT NULL, `category` VARCHAR(255) NOT NULL , `plant` VARCHAR(255) NOT NULL , `terpenes` VARCHAR(512) NOT NULL , `content` TEXT NOT NULL , `available` TINYINT NOT NULL , `ocs_id` INT NOT NULL, `prices` TEXT , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        purge('<BR>OCS table created');
    }
    if($forceupdate){
        purge('<BR>Full update requested. Deleting old and empty data');
        deleterow("ocs");
        deleterow("strains", 'name="" OR hasocs=2 OR slug LIKE "%-pre-roll" OR name LIKE "%Pre-Roll%" OR name LIKE "%(%THC%)" OR ((slug LIKE "%-1" OR name LIKE "%oil" OR name LIKE "%Capsules" OR name LIKE "%Softgels%") AND id > 3500)');
        Query("UPDATE strains SET hasocs = 0", false);
        Query("ALTER TABLE `ocs` DROP `prices`;");
        table_has_column("ocs", "prices", "TEXT");//$column, $type = false, $null = false, $default = false, $after = false, $isprimarykey = false, $comment
    }

    table_has_column("ocs", "slug", "VARCHAR(255)", false, false, "id");
    table_has_column("ocs", "lift_url", "TEXT");
    table_has_column("ocs", "lift_des", "TEXT");
    table_has_column("ocs", "lift_thc", "VARCHAR(16)");
    table_has_column("ocs", "lift_cbd", "VARCHAR(16)");
    table_has_column("ocs", "ocs_thc", "VARCHAR(16)");
    table_has_column("ocs", "ocs_cbd", "VARCHAR(16)");
    $allstrains = [];

    echo '</TD></TR><TR><TD>';
    //slug, vendor, status(importing, make new strains, skipped, failed), type, real name (without dash 1), our link, ocs link
    echo '<TABLE WIDTH="100%" BORDER="1" STYLE="border-collapse: collapse;"><THEAD><TR><TH>OCS Slug</TH><TH>Type</TH><TH>Progress</TH><TH>Vendor</TH><TH>Canbii Slug</TH><TH>Status</TH></TR></THEAD>';

    foreach($collections as $collection){
        $strains = enumstrains($collection);
        $allstrains = array_merge($strains);
        $data = json_encode($strains, JSON_PRETTY_PRINT);
        $filename = $dir . $collection . ".json";
        file_put_contents($filename, $data);
        $count = count($strains);
        foreach($strains as $INDEX => $strain){
            //echo '<BR><A HREF="' . $this->webroot . 'strains/' . $strain . '" TARGET="_new">' . $strain . '</A>';
            $URL = 'https://ocs.ca/products/' . $strain;
            echo '<TR><TD><A HREF="' . $URL . '">' . $strain . '</A></TD><TD>' . $collection . '</TD><TD>';
            $percent = round(($INDEX+1)/$count*100);
            echo '<DIV CLASS="parent"><DIV CLASS="progress" STYLE="width: ' . $percent . '%;"></DIV><DIV CLASS="indicator">' . ($INDEX+1) . '/' . $count . '=' . $percent . '%</DIV></DIV></TD>';
            $filename = $dir . $strain . ".json";
            $data = false;

            $DIDIT = false;
            $STATUS = ['SKIPPED'];
            if(!file_exists($filename) || $forceupdate) {
                $STATUS = ['DOWNLOADING HTML'];
                $data = extractdata($strain);
            } else if(file_exists($filename)) {
                $STATUS = ['LOADING JSON FILE'];
                $data = json_decode(file_get_contents($filename), true);
            }

            if($data) {
                $data = import($strain, $data, $me, $types, $collection, $options, $extradata, $negativeeffects, $dir, $ReviewController);
                if(is_array($data)) {
                    $DIDIT = true;
                    echo '<TD>' . $data["vendor"] . '</TD><TD><A TARGET="_new" HREF="' . $this->webroot . 'strains/';
                    if (isset($data["mergedwith"])) {
                        $STATUS[] = "Merged";
                        echo $data["mergedwith"] . '">' . fromclassname($data["mergedwith"]) . '</A></TD>';
                    } else {
                        $STATUS[] = "Imported";
                        echo $strain . '">' . fromclassname($strain) . '</A></TD>';
                    }
                    if($data["downloadedimages"] > 0){
                        $STATUS[] = "Downloaded: " . $data["downloadedimages"] . " images";
                    }
                    if($data["skippedimages"] > 0){
                        $STATUS[] = "Skipped: " . $data["skippedimages"] . " images";
                    }
                    if(isset($data["reviewsadded"]) && $data["reviewsadded"] > 0){
                        $STATUS[] = "Imported: " . $data["reviewsadded"] . " reviews (recalculating)";
                        $ReviewController->addrating($data["id"], "strains");
                    } else if($options["forceratingcalc"]) {
                        if(isset($options["ratingserror"])){
                            $STATUS[] = "Forced rating recalculation due to error";
                        } else {
                            $STATUS[] = "Forced rating recalculation";
                        }
                        $ReviewController->addrating($data["id"], "strains");
                    }
                    if(isset($data["reviewsskipped"]) && $data["reviewsskipped"] > 0){
                        $STATUS[] = "Skipped: " . $data["reviewsskipped"] . " reviews";
                    }
                    if(isset($data["error"])){
                        $STATUS[] = '<S>' . $data["error"] . '</S>';
                    }
                    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
                } else if($data) {
                    $STATUS[] = $data;
                } else {
                    $STATUS[] = '<S>***IMPORT FAILED (MISSING OR INVALID DATA)***</S>';
                }
            } else {
                $STATUS[] = 'ERROR: DATA MISSING';
            }
            if(!$DIDIT){
                echo '<TD COLSPAN="2"></TD>';
            }
            purge('<TD>[' . str_replace(['<S>', '</S>'], ['<SPAN CLASS="error">', '</SPAN>'], implode("] [", $STATUS)) . ']</TD></TR>');
        }
    }
    $data = json_encode($allstrains, JSON_PRETTY_PRINT);
    file_put_contents($dir . "allstrains.json", $data);
    die('</TABLE>Done!</TD></TR></TABLE>');
?>
