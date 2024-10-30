<?php

function ig_enqueue_scripts() {
    wp_enqueue_script( 'lightbox-js', plugins_url( 'js/jquery.fancybox-1.3.4.pack.js', __FILE__ ), array(), '1.0.0', true );
    wp_enqueue_script( 'masonry-js', plugins_url( 'js/masonry.pkgd.min.js', __FILE__ ), array(), '1.0.0', true );
    wp_enqueue_script( 'igloader-js', plugins_url( 'js/loader.js', __FILE__ ), array(), '1.0.0', true );
    wp_enqueue_style( 'ig-fancybox', plugins_url('css/jquery.fancybox-1.3.4.css', __FILE__));
}

function ig_inject_photos() { 

	// Create the pin board 
    function ig_create_photo() 
    {

        //Reference Wordpress database string.
    	global $wpdb;

        //Retrieve Values Needed

        //For CSS
        $ig_cols = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'igcolumns';"));
        $ig_border_radius = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'igborder';"));

        $ig_cols_val = "";
        $ig_border_val = "";

         switch($ig_border_radius) {
            case 'yes':
                $ig_border_val = "5";
            break;
            case 'no':
                $ig_border_val = "0";
            break;
            default:
                $ig_border_val = "5";
            break;
        }

        switch($ig_cols) {
            case '3':
                $ig_cols_val = "30";
            break;
            case '4':
                $ig_cols_val = "22";
            break;
            case '5':
                $ig_cols_val = "17";
            break;
            default:
                $ig_cols_val = "30";
            break;
        }

        //For Displaying Pins

        //Retrieve the user from the database
        $instagram_userid =$wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'userid';"));
        $instagram_token =$wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'token';"));
        $instagram_details =$wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'details';"));

        //Set the URL to send to the REST API
        $url ="https://api.instagram.com/v1/users/{$instagram_userid}/media/recent/?access_token={$instagram_token}"; // Just for testing purposes replace soon.

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Instagram Request',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        // Send the request & save response to $resp
        $ig_response = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $ig_array = json_decode($ig_response, false);

?>
<style type="text/css">
#instagram-photos {
width: 100%;
display: block;
margin-bottom: 10px;
overflow: hidden;
}

.instagram-photo {
width: <?php echo $ig_cols_val; ?>%;
float: left;                
border: 1px solid #cccccc;
border-radius: <?php echo $ig_border_val; ?>px;
margin: 1.4%;
overflow: hidden;
position: relative;
}

.instagram-image img {
width: 100%;
border-bottom: 1px solid #cccccc;
}

</style>
        <div id='instagram-photos'>
<?php foreach ($ig_array->data as $post): ?>
		<!-- Renders images. @Options (thumbnail,low_resoulution, high_resolution) -->
<div class='instagram-photo'> 
<div class='instagram-image'>
		<a class="group" rel="group1" href="<?= $post->images->standard_resolution->url ?>"><img src="<?= $post->images->thumbnail->url ?>"></a>

</div>

<?php if($instagram_details == "yes") { ?>
<div style=" padding: 5px; border-bottom: 1px solid #dddddd; font-size: 12px; font-color: #bbbbbb;"><p style="float: right;">&#10084; <?= $post->likes->count ?></p> &#9998; <?= gmdate("d-m-y", $post->created_time) ?></div>
<div style=" padding: 5px; border-bottom: 1px solid #dddddd; font-size: 14px; font-color: #bbbbbb; text-align: center;"><a href="<?= $post->link ?>">&#x1f441; View on Instagram</a></div>
<?php } ?>

</div>
	<?php endforeach ?>

        </div>
    <?php }

    add_shortcode( 'ig-gallery', 'ig_create_photo' );
}

add_action( 'wp_head', 'ig_inject_photos');
add_action( 'wp_enqueue_scripts', 'ig_enqueue_scripts' );


?>