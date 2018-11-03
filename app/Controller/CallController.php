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
}