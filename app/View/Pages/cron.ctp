<?php
    function get_string_between($string, $start, $end){
        return getbetween($string, $start, $end);
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

    function getdirectory($path){
        return pathinfo(str_replace("\\", "/", $path), PATHINFO_DIRNAME);
    }

    function getfilename($path, $WithExtension = false){
        if ($WithExtension) {
            return pathinfo($path, PATHINFO_BASENAME); //filename only, with extension
        } else {
            return pathinfo($path, PATHINFO_FILENAME); //filename only, no extension
        }
    }

    //get the lower-cased extension of a file path
    //HOME/WINDOWS/TEST.JPG returns jpg
    function getextension($path){
        return strtolower(pathinfo($path, PATHINFO_EXTENSION)); // extension only, no period
    }

    function file_size($path){
        if (file_exists($path)) {
            return filesize($path);
        }
        return 0;
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
        $TEXT = decode($TEXT);
        $one = '"https://ocs.ca/collections/1-gram-packs-of-cannabi]"';
        $two = '"https://ocs.ca/collections/tous-les-produit]"';
        $TEXT = str_replace([$one, $two], ['"links": [' . $one, $two . "],"], $TEXT);
        return json_decode($TEXT, true);
    }

    function get_string_between2($TEXT, $START, $END){
        return get_string_between($TEXT, htmlspecialchars($START), htmlspecialchars($END));
    }

    function extractdata($productname = "blue-dream-pre-roll"){//https://ocs.ca/products/blue-dream-pre-roll
        global  $Cookie;
        $productname = str_replace(" ", "-", strtolower($productname));
        $HTML = file_get_cookie_contents_ocs("GET", "https://ocs.ca/products/" . $productname, false, false, $Cookie);
        $HTML2 = htmlspecialchars($HTML);
        $data = json_decode2(get_string_between($HTML, '<script type="application/ld+json">', '</script>'));
        $data["shorttext"] 	= decode(get_string_between($HTML, '<p data-full-text="', '" >'));
        $data["price"] 	= get_string_between($HTML, '<h2 class="product__price">', '</h2>');

        $tabledata = get_string_between($HTML, '<table id="product__properties-table" class="table--striped product__properties-table">', '</table>');
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
        $HTML2 = get_string_between($HTML, 'window.theme.product_json =', ';');
        $data2 = json_decode2($HTML2);
        if(is_array($data2)){
            $data = array_merge($data, $data2);
        }
        return $data;
    }

    function enumstrains($collection, $page = -1){
        global $Cookie;
        $URL = "https://ocs.ca/collections/" . $collection;
        if($page > 0){
            $URL .= '?page=' . $page . '&hitsPerPage=12';
        }
        $HTML = html_entity_decode(file_get_cookie_contents_ocs("GET", $URL, false, false, $Cookie));
        $products = get_string_between($HTML, '<div class="collection__count hidden-mobile"><span>', '</span>');
        $itemsperpage = 12;
        $pages = ceil($products / $itemsperpage);
        $HTML = explode('<a href="/products/', $HTML);
        foreach($HTML as $ID => $VAL){
            $VAL = strip_tags(get_string_between('<a href="' . $VAL, '<a href="', '"'));
            $VAL = trim(str_replace("\\n","\n",$VAL));
            $HTML[$ID] = $VAL;
        }
        if($page == -1){//getall
            for($page = 1; $page < $pages; $page++){
                $HTML = array_merge($HTML, enumstrains($collection, $page));
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
                "password"  => "548bc6761353d6a65704e2625c6e4fda",
                "user_type" => 1,
                "country"   => "Canada"
            ];
            $me = insertdb("users", $me);
        }
        return $me;
    }

    function import($strain, $JSONdata, $me, $types, $collection){
        $localstrain = first("SELECT * FROM strains WHERE slug='" . $strain . "'");
        $tags = [];
        if(!is_array($JSONdata)){
            die($strain . " data is invalid");
        }

        //add new effects
        if(isset($JSONdata["tags"])) {
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

        //add new strain
        if(!$localstrain){//create it
            $plant = explode(" ", $JSONdata["Plant"]);
            $plant = $plant[0];
            $localstrain = [
                "type_id"       => getiterator($types, "title", $plant)["id"],
                "name"          => $JSONdata["title"],
                "description2"  => $JSONdata["content"],
                "slug"          => $strain,
                "imported"      => 2//0=native, 1=leafly, 2=ocs
            ];
            if($localstrain["name"] && $localstrain["description2"]) {
                $localstrain["id"] = insertdb("strains", $localstrain);
            }
        }

        if(isset($localstrain["id"]) && $localstrain["id"]) {
            $ocsdata = first("SELECT * FROM ocs WHERE strain_id=" . $localstrain["id"]);
            if (!$ocsdata && isset($JSONdata["content"])) {//add to ocs table
                if (!isset($JSONdata["Terpenes"]) || !is_array($JSONdata["Terpenes"])) {
                    $JSONdata["Terpenes"] = "";
                }
                $ocsdata = [
                    "category" => $collection,
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

            insertdb("ocs", $ocsdata);
            $localstrain["ocsdata"] = $localstrain;
            return $localstrain;
        }
        return false;
    }

    set_time_limit(0);
    $collections = ["dried-flower-cannabis", "pre-rolled", "oils-and-capsules"];
    $dir = getcwd() . "/ocs/";
    $forceupdate = false;//set to true to forcefully update the JSON from the site
    $Cookie = "_shopify_y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _orig_referrer=https%3A%2F%2Fwww.google.ca%2F; secure_customer_sig=; _landing_page=%2F; cart_sig=; _y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_fs=2019-01-15T15%3A44%3A52.677Z; _shopify_sa_p=; _ga=GA1.2.49790356.1547567094; _gid=GA1.2.1293338108.1547567094; _age_validated=true; _shopify_sa_t=2019-01-15T16%3A13%3A03.593Z";
    $me = getme();
    $types = query("SELECT * FROM strain_types", true);
    $tables = enum_tables("ocs");
    if(!$tables){
        Query("CREATE TABLE `canbii_db`.`ocs` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `shorttext` TEXT NOT NULL , `price` INT NOT NULL, `category` VARCHAR(255) NOT NULL , `plant` VARCHAR(255) NOT NULL , `terpenes` VARCHAR(512) NOT NULL , `content` TEXT NOT NULL , `available` TINYINT NOT NULL , `ocs_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
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
                echo ' [IMPORTING]';
                if(import($strain, $data, $me, $types, $collection)) {
                    $data = json_encode($data, JSON_PRETTY_PRINT);
                    file_put_contents($filename, $data);
                } else {
                    echo ' ***FAILED***';
                }
            } else {
                echo ' [ERROR: DATA MISSING]';
            }
        }
    }
    $data = json_encode($allstrains, JSON_PRETTY_PRINT);
    file_put_contents($dir . "allstrains.json", $data);
?>