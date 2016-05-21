<?php
/*
Plugin Name:Downgrade
Plugin URI: 
Description: Downgrade WordPress
Version: 1.0.0
Author: GraphicEdit
Author URI: http://graphicedit.com/

	

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/




if ( ! defined( 'ABSPATH' ) )
	exit;
  
// create custom plugin settings menu
add_action('admin_menu', 'downgrade_create_menu');

function downgrade_create_menu() {

	//create new sub-menu
	add_submenu_page('options-general.php', 'Downgrade', 'Downgrade', 'administrator', 'downgrade', 'downgrade_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_downgrade_settings' );
}

function register_downgrade_settings() {
	//register our settings
	register_setting( 'dg-settings-group', 'dg_specific_version_name' );
	
}

function downgrade_settings_page() {
?>
<div class="wrap">
<h2>Downgrade </h2>
   <p>Caution! Use of the plug-in is on your own risk. You should back up your files and the database!</p>
	<h3>Are You Sure!!!!</h3>

<form method="post" action="options.php">
    <?php settings_fields( 'dg-settings-group' ); ?>
    <?php do_settings_sections( __FILE__ ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Target version :</th>
        <td><input type="text"  name="dg_specific_version_name"  value="<?php echo esc_attr( get_option('dg_specific_version_name') ); ?>"  size="40"/> Full Url i.e: https://wordpress.org/wordpress-4.4.zip</td>
        </tr>
     </table>
     <?php submit_button(); ?>
     </form>
    
<?php if (get_option('dg_specific_version_name')) { ?>
   <p>NOW please go to  <a class="button" href="<?php echo get_admin_url( null, '/update-core.php' ) ;?>">WordPress Updates</a>  and click to "UpdateNow" Button</p>
<?php }; ?>

</div>
<?php } 

add_filter('pre_site_option_update_core','dg_specific_version' );
add_filter('site_transient_update_core','dg_specific_version' );
function dg_specific_version($updates){
	
 $dg_version = get_option('dg_specific_version_name');    
  
	$updates->updates[0]->packages->full = $dg_version;
    $updates->updates[0]->packages->no_content = '';
    $updates->updates[0]->packages->new_bundled = '';
    //$updates->updates[0]->current = $dg_version;

    return $updates;
}
?>