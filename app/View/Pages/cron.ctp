<?php
    $options = [
        "makenewstrains" => false,//disable to prevent new strains from being created
    ];

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

    function file_get_cookie_contents_ocs($method = "GET", $URL, $querydata = false, $POSTdata = false, $Cookie = false){
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
            return gzdecode(file_get_contents($URL, false, $context));
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
        global  $Cookie;
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
        return $data;
    }

    function enumstrains($collection, $page = -1){
        global $Cookie;
        if($collection == "hardcoded"){
            $HTML = ["kinky-kush", "delahaze"];
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

    function trimend($Text, $Trim){
        if( endswith(strtolower($Text), strtolower($Trim)) ){
            $Text = left($Text, strlen($Text) - strlen($Trim));
        }
        return trim($Text);
    }

    function cleanslug($slug = "lemon-skunk-capsules-2-5mg"){
        if(!is_array($slug)){$slug = explode("-", $slug);}
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
        $wordstoremove = ["oil", "oral", "spray", "mct", "thc", "peppermint", "capsules", "pre", "roll", "pack"];
        $last = count($slug) - 1;
        foreach(array_reverse($slug) as $index => $word){
            $index = $last - $index;
            if(in_array( $word, $wordstoremove )){
                unset( $slug[$index] );
            } else {
                break;
            }
        }
        return implode("-", $slug);
    }
    //vardump(cleanslug());die();

    function import($strain, $JSONdata, $me, $types, $collection, $options) {
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
                        $data = first("SELECT * FROM effects WHERE title='" . $tag . "'");
                        if (!$data) {
                            $data = ["title" => $tag, "imported" => 1, "negative" => 0];
                            $data["id"] = insertdb('effects', $data);
                        }
                        $tags[$tag] = $data;
                    }
                }
            }

            if (!$localstrain) {
                $strain2 = cleanslug($strain);
                echo " [BEFORE: " . $strain . "][AFTER: " . $strain2 . ']';
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
                        "hasocs" => 1,
                        "type_id" => getiterator($types, "title", $plant)["id"],
                        "name" => trimend($JSONdata["title"], "pre-roll"),
                        "description2" => $JSONdata["content"],
                        "slug" => $strain,
                        "imported" => "2"//0=native, 1=leafly, 2=ocs
                    ];
                    if ($localstrain["name"] && $localstrain["description2"]) {
                        $localstrain["id"] = insertdb("strains", $localstrain);
                    }
                } else {
                    return "Skipped, makenewstrains=false";
                }
            } else {
                return false;
            }

            if (isset($localstrain["id"]) && $localstrain["id"]) {
                $ocsdata = first("SELECT * FROM ocs WHERE strain_id=" . $localstrain["id"]);
                if (!$ocsdata && isset($JSONdata["content"])) {//add to ocs table
                    if (!isset($JSONdata["Terpenes"]) || !is_array($JSONdata["Terpenes"])) {
                        $JSONdata["Terpenes"] = [];
                    }
                    $ocsdata = [
                        "category" => $JSONdata["vendor"],
                        "strain_id" => $localstrain["id"],
                        "shorttext" => $JSONdata["shorttext"],
                        "price" => $JSONdata["price"],
                        "plant" => $JSONdata["Plant"],
                        "terpenes" => implode(", ", $JSONdata["Terpenes"]),
                        "content" => $JSONdata["content"],
                        "available" => $JSONdata["available"] == "true",
                        "ocs_id" => $JSONdata["id"]
                    ];
                }

                $prices = [];
                if ($mergeprices && isset($ocsdata["prices"]) && $ocsdata["prices"]) {
                    $prices = json_decode($ocsdata["prices"], true);
                }
                if (isset($JSONdata["variants"])) {
                    foreach ($JSONdata["variants"] as $variant) {
                        $prices[] = ["price" => $variant["price"], "slug" => $originalstrain, "title" => $variant["public_title"], "category" => $collection];
                    }
                    $ocsdata["prices"] = json_encode($prices);
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

    set_time_limit(0);
    $collections = ["hardcoded", "dried-flower-cannabis", "pre-rolled", "oils-and-capsules"];
    echo '<BR>Downloading all: ' . implode(", ", $collections);
    $dir = getcwd() . "/ocs";
    if(!is_dir($dir)){
        mkdir($dir, 0777);
    }
    $dir .= "/";

    $forceupdate = true;//set to true to forcefully update the JSON from the site
    $Cookie = "_shopify_y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _orig_referrer=https%3A%2F%2Fwww.google.ca%2F; secure_customer_sig=; _landing_page=%2F; cart_sig=; _y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_fs=2019-01-15T15%3A44%3A52.677Z; _shopify_sa_p=; _ga=GA1.2.49790356.1547567094; _gid=GA1.2.1293338108.1547567094; _age_validated=true; _shopify_sa_t=2019-01-15T16%3A13%3A03.593Z";
    $me = getme();
    if(!enum_tables("activities")) {
        Query("CREATE TABLE `activities` (`id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(255) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB");
        $activities = ["Hiking", "Exercise", "Music", "Video Games", "Cleaning", "Yoga", "Meditation", "Movies", "Study", "Reading", "Working"];
        sort($activities);
        foreach($activities as $activity){
            insertdb("activities", ["title" => $activity, "imported" => 2]);
        }
        echo '<BR>activities table created and filled with (' . implode(", ", $activities) . ")";
    }
    if(!enum_tables("activity_ratings")) {
        Query("CREATE TABLE `activity_ratings` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL, `review_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL, `rate` varchar(255) NOT NULL, `strain_id` int(11) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB;");
        echo '<BR>activity_ratings table created';
    }

    $types = query("SELECT * FROM strain_types", true);
    if(!enum_tables("ocs")){
        Query("CREATE TABLE `ocs` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `shorttext` TEXT NOT NULL , `price` INT NOT NULL, `category` VARCHAR(255) NOT NULL , `plant` VARCHAR(255) NOT NULL , `terpenes` VARCHAR(512) NOT NULL , `content` TEXT NOT NULL , `available` TINYINT NOT NULL , `ocs_id` INT NOT NULL, `prices` TEXT , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        echo '<BR>OCS table created';
    }
    if($forceupdate){
        echo '<BR>Full update requested. Deleting old and empty data';
        deleterow("ocs");
        deleterow("strains", 'name="" OR hasocs=2 OR slug LIKE "%-pre-roll"');
        Query("UPDATE strains SET hasocs = 0", false);
        Query("ALTER TABLE `ocs` DROP `prices`;");
        table_has_column("ocs", "prices", "TEXT");//$column, $type = false, $null = false, $default = false, $after = false, $isprimarykey = false, $comment
    }
    $allstrains = [];
    foreach($collections as $collection){
        echo '<H2>' . $collection . '</H2>';
        $strains = enumstrains($collection);
        $allstrains = array_merge($strains);
        $data = json_encode($strains, JSON_PRETTY_PRINT);
        $filename = $dir . $collection . ".json";
        file_put_contents($filename, $data);
        foreach($strains as $strain){
            //echo '<BR><A HREF="' . $this->webroot . 'strains/' . $strain . '" TARGET="_new">' . $strain . '</A>';
            echo '<BR>' . $strain;
            $filename = $dir . $strain . ".json";
            $data = false;
            if(!file_exists($filename) || $forceupdate) {
                echo ' [DOWNLOADING HTML]';
                $data = extractdata($strain);
            } else if(file_exists($filename)) {
                echo ' [LOADING JSON FILE]';
                $data = json_decode(file_get_contents($filename), true);
            }
            if($data) {
                $data = import($strain, $data, $me, $types, $collection, $options);
                if(is_array($data)) {
                    echo ' [VENDOR: ' . $data["vendor"] . "]";
                    if (isset($data["mergedwith"])) {
                        echo ' <A HREF="' . $this->webroot . 'strains/' . $data["mergedwith"] . '" TARGET="_new">[MERGING WITH ' . $data["mergedwith"] . ']</A>';
                    } else {
                        echo ' <A HREF="' . $this->webroot . 'strains/' . $strain . '" TARGET="_new">[IMPORTING]</A>';
                    }
                    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
                } else if($data) {
                    echo ' <B>[' . $data. ']</B>';
                } else {
                    echo ' ***IMPORT FAILED (MISSING OR INVALID DATA)***';
                }
            } else {
                echo ' [ERROR: DATA MISSING]';
            }
        }
    }
    $data = json_encode($allstrains, JSON_PRETTY_PRINT);
    file_put_contents($dir . "allstrains.json", $data);
?>