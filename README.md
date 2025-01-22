WP Offload Media Tweaks for Contabo Object Storage
========================

This is a WordPress plugin, meant as a starting point for developers to tweak [WP Offload Media](https://deliciousbrains.com/wp-offload-media/) and [WP Offload Media Lite](https://wordpress.org/plugins/amazon-s3-and-cloudfront/) using WordPress filters.

Installation
------------

Create a /contabo-s3-and-cloudfront-tweaks/ folder in /wp-content/plugins/ and simply drop the `contabo-s3-and-cloudfront-tweaks.php` file into it. Then go to the Plugins page in your WordPress dashboard and activate it.

Setup
-----

Open the `contabo-s3-and-cloudfront-tweaks.php` file and take a look at the `__construct()` function. You will notice that I have added the us central url of contabo object storage which is usc1.contabostorage.com at 5 functions, you have to just replace the url with your contabo object storage url which you have purchased in whichever region, and in wp-config.php you can add your api acces key and secret 

like this:
define( 'AS3CF_SETTINGS', serialize( array(
	'provider' => 'aws', 
	'access-key-id' => '***************',
	'secret-access-key' => '************',
) ) );

Replace star with your actual acces key and secret. 
You need to create rewrite rules in cloudflare to add your bucket id and name in your cdn url.
You can follow this article for detailed info.
[How to Setup Contabo Object Storage using Wp offload media plugin in wordpress](https://teklog.in/)
