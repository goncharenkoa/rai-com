<?php
/*
Plugin Name: VelocityPage
Description: Allows you to visually customize and control your page layouts right on the front of your site
Version: 1.2.0
License: GPL version 2 or any later version
Plugin URI: http://velocitypage.com/
Author: Ad Labs Inc
Author URI: http://adlabsinc.com/
Text Domain: velocitypage

==========================================================================

Copyright 2013-2014 Ad Labs Inc

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
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

defined( 'WPINC' ) or die;

// Grab this directory
$_dir = dirname( __FILE__ ) . '/';

// Pull in libraries
include( $_dir . 'lib/wp-stack.php'         );

// Define our core types
include( $_dir . 'classes/renderable.php'   );
include( $_dir . 'classes/page.php'         );
include( $_dir . 'classes/row.php'      );
include( $_dir . 'classes/row-area.php' );
include( $_dir . 'classes/item-area.php'    );
include( $_dir . 'classes/item.php'         );
include( $_dir . 'classes/field.php'        );
include( $_dir . 'classes/theme.php'        );
include( $_dir . 'classes/plugin.php'       );

// Clean up
unset( $_dir );

// Handy function for grabbing the plugin instance
function VelocityPage() {
	return AdLabs_VP_Plugin::$instance;
}

// For typos and back-compat
function velocity_page() {
	return VelocityPage();
}

// Initialize the plugin
new AdLabs_VP_Plugin( __FILE__ );
