<?php
class CallController extends AppController {
	public function index() {
		if(!isset($_GET["message"]) && isset($_POST["message"])){
            $message = $_POST["message"];
        } else {
            $message = $_GET["message"];
        }
        $say = '<Say voice="woman" language="en">';
        $url = "https://canbii.com/shop";
        if(isset($_GET["gather"])){// https://www.twilio.com/docs/voice/twiml/gather
            $message = '<Gather numDigits="1" action="' . $url . '/gather.php?gather=' . $_GET["gather"] . "&amp;message=" . urlencode($message) . '" method="GET" timeout="10">
                        ' . $say . $message . '</Say>
                   </Gather>
                   ' . $say . 'We did not receive any input. Goodbye!</Say>';
        } else {
            $message = '<Gather numDigits="1" action="' . $url . '/gather.php?message=' . urlencode($message) . '" method="GET" timeout="10">
                        ' . $say . $message . '</Say>
                   </Gather>';
        }
        die('<?xml version="1.0" encoding="UTF-8"?><Response>' . $message . '</Response>');
	}

    public function images(){
        $images_moved = 0;
        $images_deleted = 0;
        $images_errored = 0;
        $dir = $_POST["root"] . "/" . $_POST["directory"] . "/";
        foreach($_POST["images"] as $image => $action){
            if($action){
                echo PHP_EOL . $image . " - ";
                $source = $image;
                $image = $dir . $image;
                if(!file_exists($image)) {
                    echo "NOT FOUND";
                    $images_errored +=1;
                } else if($action == "Delete"){
                    echo "DELETED";
                    unlink($image);
                    $images_deleted += 1;
                } else {
                    echo "MOVE TO: " . $action;
                    $images_moved += 1;
                    $this->renameimage($dir, $source, $action);
                }
            }
        }
        die(PHP_EOL . "-------------------------------" . PHP_EOL . $images_moved . " image(s) moved" . PHP_EOL .$images_deleted . " image(s) deleted" . PHP_EOL . $images_errored . " error(s)");
    }

    public function renameimage($sourcedir, $image, $section){
        $extension = getextension2($image);
        for($number = 0; $number < 9999; $number++){
            $newfilename = $sourcedir . $section . "-" . $number . "." . $extension;
            if(!file_exists($newfilename)){
                rename($sourcedir . $image, $newfilename);
                return $newfilename;
            }
        }
    }
}