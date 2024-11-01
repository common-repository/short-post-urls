<?php
/*
Plugin Name: Short Post URLS
Plugin URI: http://redmine.sproutventure.com/short-post-urls
Description: Shortened Post URLs for twitter or any other social network that may need a short url. Default short URL is http://siteurl.com/p/175 ( where 175 is the post id ) but can easily be changed to whatever you'd like ( maybe http://siteurl.com/175 ). Example template modifications would be "<a class="share-via-twitter" href="http://twitter.com/home?status=Reading: <?php the_title(); ?> <?php echo get_option('home'); ?>/s/<?php the_ID(); ?>" title="Tweet this post">Tweet This</a>" 
Inspiration from 5thirtyone.com ( http://5thirtyone.com/archives/2075 )
Version: 1
Author: Dan Cameron of Sprout Venture
Author URI: http://sproutventure.com
License: GNU General Public License

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	This Wordpress plugin is released under a GNU General Public License. A complete version of this license
	can be found here: http://www.gnu.org/licenses/gpl.txt

	This Wordpress plugin is released "as is". Without any warranty. The authors cannot
	be held responsible for any damage that this script might cause.
	
*/

class Short_Post_URLS {
	
	
	function Short_Post_URLS() 
		{
			register_activation_hook( __FILE__, array (&$this, 'flush_rewrite_rules' ) );
			add_action( 'generate_rewrite_rules', array (&$this, 'custom_rewrite_rules' ) );
			//add_shortcode ( 'short-url', array (&$this, 'short_open_call' ) ); # maybe in a future version
		}
		
		// Array of custom URLs with some examples for customization
	function custom_rewrite_rules( $wp_rewrite ) 
		{
			$newRules = array();
		
				// Defualt http://siteurl.com/s/1 ( '1' being the post id )
				$newRules[ 'p/([0-9]+)$' ] = 'index.php?p=' . $wp_rewrite->preg_index( 1 );
				
				// Another example below http://siteurl.com/1
				# $newRules[ '([0-9]+)$' ] = 'index.php?p=' . $wp_rewrite->preg_index( 1 );
		
			$wp_rewrite->rules = $newRules + $wp_rewrite->rules;
			return $wp_rewrite;
		}

	// Flush the current rewrite rules so the above array is added.
	function flush_rewrite_rules() 
		{
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}

}

$spurl = new Short_Post_URLS();

?>