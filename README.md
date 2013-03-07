# In Stock Notification

This class allows you to get a notification email when an item becomes available online.

___

## Example Usage:

```<?php
	include('notify.php');

	$notify = new notify('http://www.this-is.com/the-address-you-are-checking', 'Out of Stock', 'youremail@domain.com', 'Available');
	if($notify->matched == 0):
		$notify->mailer();
	endif;
?>```