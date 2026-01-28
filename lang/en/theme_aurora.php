<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language file.
 *
 * @package   theme_aurora
 * @copyright 2016 Frédéric Massart
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// A description shown in the admin theme selector.
$string['choosereadme'] = 'Theme aurora is a child theme of Boost. It adds the ability to upload background photos.';
// The name of our plugin.
$string['pluginname'] = 'aurora';
// We need to include a lang string for each block region.
$string['region-side-pre'] = 'Right';


$string['advancedsettings'] = 'Advanced settings';
$string['backgroundimage'] = 'Background image';
$string['backgroundimage_desc'] = 'The image to display as a background of the site. The background image you upload here will override the background image in your theme preset files.';
$string['brandcolor'] = 'Brand colour';
$string['brandcolor_desc'] = 'The accent colour.';
$string['configtitle'] = 'Aurora New settings';
$string['generalsettings'] = 'General settings';
$string['loginbackgroundimage'] = 'Login page background image';
$string['loginbackgroundimage_desc'] = 'The image to display as a background for the login page.';
$string['preset'] = 'Theme preset';
$string['preset_desc'] = 'Pick a preset to broadly change the look of the theme.';
$string['presetfiles'] = 'Additional theme preset files';
$string['presetfiles_desc'] = 'Preset files can be used to dramatically alter the appearance of the theme. See <a href=https://docs.moodle.org/dev/Boost_Presets>Boost presets</a> for information on creating and sharing your own preset files, and see the <a href=http://moodle.net/boost>Presets repository</a> for presets that others have shared.';
$string['rawscss'] = 'Raw SCSS';
$string['rawscss_desc'] = 'Use this field to provide SCSS or CSS code which will be injected at the end of the style sheet.';
$string['rawscsspre'] = 'Raw initial SCSS';
$string['rawscsspre_desc'] = 'In this field you can provide initialising SCSS code, it will be injected before everything else. Most of the time you will use this setting to define variables.';
$string['unaddableblocks'] = 'Unneeded blocks';
$string['unaddableblocks_desc'] = 'The blocks specified are not needed when using this theme and will not be listed in the \'Add a block\' menu.';
$string['privacy:metadata'] = 'The Aurora New theme does not store any personal data about any user.';
$string['privacy:metadata:preference:draweropenblock'] = 'The user\'s preference for hiding or showing the drawer with blocks.';
$string['privacy:metadata:preference:draweropenindex'] = 'The user\'s preference for hiding or showing the drawer with course index.';
$string['privacy:drawerindexclosed'] = 'The current preference for the index drawer is closed.';
$string['privacy:drawerindexopen'] = 'The current preference for the index drawer is open.';
$string['privacy:drawerblockclosed'] = 'The current preference for the block drawer is closed.';
$string['privacy:drawerblockopen'] = 'The current preference for the block drawer is open.';
