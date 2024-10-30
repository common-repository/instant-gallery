<?php
    
    global $wpdb;

    $ig_settings_updated =  false;

    if($_POST['settings'] == "1"):
        $instagram_userid= $_POST['userid'];
        $instagram_token = $_POST['token'];
        $instagram_cols = $_POST['igcolumns'];
        $instagram_border_radius = $_POST['igborder'];
        $instagram_details = $_POST['igdetails'];
        $wpdb->query("UPDATE ig_plugin_settings SET option_value='$instagram_userid' WHERE option_name='userid'");
        $wpdb->query("UPDATE ig_plugin_settings SET option_value='$instagram_token' WHERE option_name='token'");
        $wpdb->query("UPDATE ig_plugin_settings SET option_value='$instagram_cols' WHERE option_name='igcolumns'");
        $wpdb->query("UPDATE ig_plugin_settings SET option_value='$instagram_border_radius' WHERE option_name='igborder'");
        $wpdb->query("UPDATE ig_plugin_settings SET option_value='$instagram_details' WHERE option_name='details'");
        $ig_settings_updated = true;
    endif;

    $instagram_userid = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'userid';"));
    $instagram_token = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'token';"));
    $instagram_cols = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'igcolumns';"));
    $instagram_border_radius = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'igborder';"));
    $instagram_details = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM ig_plugin_settings WHERE option_name = 'details';"));

    $ig_user_page = $_SERVER["REQUEST_URI"];
?>

<div style="text-align: right; margin-right: 2%; padding: 5px; font-size: 16px; margin-top: 10px;">
    <span style="float: right;">Version 1.2</span>
</div>

<img src="<?php echo plugins_url( 'images/logo.png', __FILE__ );  ?>" width="350" alt="Built By Elbuntu" />

<?php if($ig_settings_updated): ?>
    <br />
    <div id="message" class="updated" style="margin-left: 0px; margin-right: 2%;">
        <p><strong>&#10004; Your changes have been applied.</strong></p>
    </div>
<?php endif; ?>

<table class="widefat page" cellspacing="0" style="width: 98%; margin-top: 10px; margin-bottom: 10px; margin-right: 5px;">
    <thead>  
        <tr>
            <th>
                <strong>About</strong>
            </th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td>
                <p>Insta-Gallery is a plugin that allows you to display your Instagram Photos on your website. Also uses lightbox.</p>
                <p>Useage: Place <strong>[ig-gallery]</strong> shortcode into a page and set your username below to display your photos.</p>
            </td>
        </tr>
    </tbody>
</table>

<form method="post" action="?page=instantgallery-menu">
<table class="widefat page" cellspacing="0" style="width: 98%; margin-top: 10px; margin-bottom: 10px; margin-right: 5px;">
    <thead>  
        <tr>
            <th colspan="2">
                <strong>Settings</strong>
            </th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td colspan="2" style="background: #eee;">General</td>
        </tr>
        <tr>
            <td width="150">User ID:</td>
            <td><input type="text" value="<?php echo $instagram_userid; ?>" name="userid" style="width: 300px;"></td>
        </tr>
        <tr>
            <td width="150">Token:</td>
            <td><input type="text" value="<?php echo $instagram_token; ?>" name="token" style="width: 300px;"></td>
        </tr>
	<tr>
            <td colspan="2" align="right"><input type="button" value="Authorise Instagram" onclick="window.location.href='https://instagram.com/oauth/authorize/?client_id=6931817e55da4549ad30d4f3c4e61ca8&redirect_uri=http://ashley-johnson.co.uk/instagram/auth.php&response_type=code'"></td>
        </tr>
        <tr>
            <td colspan="2" style="background: #eee;">Template</td>
        </tr>
        <tr>
            <td>Columns: </td>
            <td>
                <select name="igcolumns">
                    <option default><?php echo $instagram_cols; ?></option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Rounded Borders? </td>
            <td>
                <select name="igborder">
                    <option default><?php echo $instagram_border_radius; ?></option>
                    <option>yes</option>
                    <option>no</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Show Details? </td>
            <td>
                <select name="igdetails">
                    <option default><?php echo $instagram_details; ?></option>
                    <option>yes</option>
                    <option>no</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <input type="hidden" name="settings" value="1" />
                <input type="submit" value="Update Settings" class="button" />
            </td>
        </tr>
    </tbody>
</table>
</form>

<table class="widefat page" cellspacing="0" style="width: 98%; margin-top: 10px; margin-bottom: 10px; margin-right: 5px;">
    <thead>  
        <tr>
            <th>
                <strong>Your Donations Count!</strong>
            </th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td>
                <p>Although this plugin is free to use and distribute donations enable us
                to develop new features and fix bugs. if you like this plugin we kindly 
                ask that you donate using the form below:</p>
                <strong>Donation Form</strong>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_donations">
                    <input type="hidden" name="business" value="ashley.gary.johnson@outlook.com">
                    <input type="hidden" name="lc" value="GBP">
                    <input type="hidden" name="item_name" value="Elbuntu Plugin Donations">
                    <input type="hidden" name="item_number" value="109998">
                    Amount: &pound;<select name="amount">
                        <option value="2.50">2,50</option>
                        <option value="5.00">5</option>
                        <option value="10.00">10</option>
                        <option value="15.00">15</option>
                    </select>
                    <input type="hidden" name="currency_code" value="GBP">
                    <input type="hidden" name="no_note" value="0">
                    <input type="hidden" name="currency_code" value="GBP">
                    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
                    <input type="submit" value="Donate Via Paypal" class="button" />
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </td>
        </tr>
    </tbody>
</table>

<table class="widefat page" cellspacing="0" style="width: 98%; margin-top: 10px; margin-bottom: 10px; margin-right: 5px;">
    <thead>  
        <tr>
            <th>
                <strong>Help &amp; Support</strong>
            </th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td>
                <p>If the plugin isn't working for you or you are recieving errors then please contact me with subject "Elbuntu Pins" at ashley.gary.johnson@gmail.com</p>
            </td>
        </tr>
    </tbody>
</table>

<div style="text-align: right; margin-right: 2%;">
    <span style="float: left;">Created by Ashley Johnson</span>
    <a href="https://twitter.com/Ashley_GJohnson">Developers Twitter</a> | <a href="https://www.linkedin.com/pub/ashley-johnson/33/6a7/a98">Developers LinkedIn</a>
</div>