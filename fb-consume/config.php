<?php
$config = array("base_url" => "YOUR_WEBSITE_OAUTH_URL", 
		"providers" => array ( 
				"Google" => array ( 
						"enabled" => true,
						"keys"    => array ( "id" => "YOUR_GOOGLE_API_KEY", "secret" => "YOUR_GOOGLE_API_SECRET" ), 

				),

				"Facebook" => array ( 
						"enabled" => true,
						"keys"    => array ( "id" => "FACEBOOK_DEVELOER_KEY", "secret" => "FACEBOOK_SECRET" ),
						"scope" => "email, user_about_me, user_birthday, user_hometown"  //optional.              
				),

				"Twitter" => array ( 
						"enabled" => true,
						"keys"    => array ( "key" => "TWITTER_DEVELOPER_KEY", "secret" => "TWITTER_SECRET" ) 
				),
		),
		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,
		"debug_file" => "debug.log",
);