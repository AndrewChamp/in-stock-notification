# In Stock Notification

This class allows you to get a notification email when an item becomes available online.  Just set a Cron-Job on the file to check every hour.


## Setting the variables

1. URL
2. Word(s) you're looking for
3. Email address to be notified
4. Subject line in the email


## Example Usage:

```php
$notify = new notify('http://www.this-is.com/the-address-you-are-checking', 'Out of Stock', 'youremail@domain.com', 'Available');
if($notify->matched != 0):
	$notify->mailer();
endif;
```
