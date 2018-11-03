<?php

class SymptomVoteController extends AppController
{
	function sendVote($strain_id,$symp){
		$yes = $this->request->data['up'];
		$no = $this->request->data['down'];
				
		$vote_yes = 0;
		if($yes == true || $yes == 1){
			$vote_yes = 1;
		}
		elseif($no == true || $no == 1){
			$vote_yes = -1;			
		}
		elseif($no ==0 and $yes == 0){
			$vote_yes = 0;			
		}
		
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$client_http = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
		
		//die($client_http);
		$data = array(
			'client_http' => $client_http,
			'strain_id' => $strain_id,
			'symptom_id'=> $symp
		);
		if($this->SymptomVote->hasAny($data)){
			$data['vote_yes'] = $vote_yes;
			unset($data['client_http']);
			$this->SymptomVote->updateAll($data,array("SymptomVote.client_http"=>$client_http));
		}
		else{
			
			$data['vote_yes'] = $vote_yes;
			$this->SymptomVote->create();
			$this->SymptomVote->save($data);
		}
		
		die();	
	}
}