<?php

/**
 * The MIT License (MIT)
 * Copyright (c) 2013 Andrew Champ
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial 
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
 

/**
 * EXAMPLE USAGE:
 * $notify = new notify('http://www.this-is.com/the-address-you-are-checking', 'Out of Stock', 'youremail@domain.com', 'Available');
 * if($notify->matched == 0):
 * 		$notify->mailer();
 * endif;
 */

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
