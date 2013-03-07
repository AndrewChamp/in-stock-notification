<?php

class notify{
  
		public $url;
		public $match;
		public $email;
		public $subject;
		public $matched;
		
		private $result;
	
		
		public function __construct($_url, $_match, $_email, $_subject){
			$this->url = $_url;
			$this->match = $_match;
			$this->email = $_email;
			$this->subject = $_subject;
			$this->scrape();
			$this->search();
		}
		
		
		public function scrape(){
			$ch = curl_init($this->url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			$this->result = $this->clean($result);
			curl_close($ch);
		}
		
		
		public function search(){
			$getit = preg_match("/".$this->match."/i", $this->result, $matches);
			$this->matched = $getit;
		}
		
		
		public function mailer(){
			$e_body = $this->url." \r\n\n";
			$e_content = "\r\n\n";    
			$e_reply = "";
			$headers = "From: ".$this->email." \r\nReply-To: ".$this->email." \r\nReturn-Path: ".$this->email." \r\n";
			$msg = $e_body . $e_content . $e_reply;
			if(mail($this->email, $this->subject, $msg, $headers)):	
				 return true;
			else:
				return false;
			endif;
		}
		
		
		private function clean($str){
			return strip_tags($str);
		}
	
}

?>
