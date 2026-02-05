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

// Navbar settings.
$string['navbarsettings'] = 'Navbar settings';
$string['auroranavprimary'] = 'Navbar primary color';
$string['auroranavprimarydesc'] = 'Set the primary color for the navigation bar.';
$string['auroranavsecondary'] = 'Navbar secondary color';
$string['auroranavsecondarydesc'] = 'Set the secondary color for the navigation bar.';
$string['auroranavtext'] = 'Navbar text color';
$string['auroranavtextdesc'] = 'Set the text color for the navigation bar.';
$string['auroranavtexthover'] = 'Navbar text hover color';
$string['auroranavtexthoverdesc'] = 'Set the text hover color for the navigation bar.';
$string['auroranavborderradius'] = 'Navbar border radius';
$string['auroranavborderradiusdesc'] = 'Set the border radius for the navigation bar elements.';

$string['auroranavbortextweight'] = 'Navbar text weight';
$string['auroranavbortextweightdesc'] = 'Set the font weight for the navigation bar text.';
$string['auroranavlinksposition'] = 'Navbar links position';
$string['auroranavlinkspositiondesc'] = 'Choose where the main navigation links are aligned: left, center, or right.';
$string['auroranavlinkspositionleft'] = 'Left';
$string['auroranavlinkspositioncenter'] = 'Center';
$string['auroranavlinkspositionright'] = 'Right';
$string['nocourses'] = 'No courses';

// Front page slider settings.
$string['frontpagesettings'] = 'Front page slider';
$string['frontpagesliderenabled'] = 'Enable front page slider';
$string['frontpagesliderenabled_desc'] = 'Show the custom slider block under the navbar on the front page.';
$string['frontpagesliderenabledlabel'] = 'Enabled';
$string['frontpageslidermanage'] = 'Manage front page slider';
$string['frontpageslidermanagelink'] = 'Open slider manager';
$string['frontpageslidermanagedesc'] = 'Manage slider items here: {$a}';
$string['frontpagesliderlist'] = 'Slider items';
$string['frontpagesliderpreview'] = 'Preview';
$string['frontpagesliderupdated'] = 'Slider item saved.';
$string['frontpagesliderdeleted'] = 'Slider item deleted.';
$string['frontpageslideritems'] = 'Slider items';
$string['frontpageslideritems_desc'] = 'Add, edit, and remove unlimited slides. If this list is empty, the single-slide fields below are used.';
$string['frontpagesliderempty'] = 'No slides yet. Add the first one.';
$string['frontpageslidernotitle'] = 'Untitled slide';
$string['frontpagesliderdeleteconfirm'] = 'Delete this slide?';
$string['frontpageslideradd'] = 'Add to list';
$string['frontpagesliderupdate'] = 'Update slide';
$string['frontpageslidercancel'] = 'Cancel edit';
$string['frontpageslideredit'] = 'Edit';
$string['frontpagesliderdelete'] = 'Delete';
$string['frontpageslideritemtitle'] = 'Title';
$string['frontpageslideritemdescription'] = 'Description';
$string['frontpageslideritemimage'] = 'Image URL';
$string['frontpageslideritemimagealt'] = 'Image alt text';
$string['frontpageslideritembuttontext'] = 'Button text';
$string['frontpageslideritembuttonurl'] = 'Button URL';
$string['frontpageslideremptyitem'] = 'Fill at least one field to add a slide.';
$string['frontpagesliderinvalidjson'] = 'Invalid slider list data. It will be replaced when you add a new slide.';
$string['frontpagesliderregion'] = 'Front page slider';
$string['frontpagesliderindicator'] = 'Slide {$a}';
$string['frontpagesliderimage'] = 'Slider image';
$string['frontpagesliderimage_desc'] = 'Upload an image for the front page slider.';
$string['frontpageslidertitle'] = 'Slider title';
$string['frontpageslidertitle_desc'] = 'Main title for the front page slider.';
$string['frontpagesliderdescription'] = 'Slider description';
$string['frontpagesliderdescription_desc'] = 'Short description text for the front page slider.';
$string['frontpagesliderbuttontext'] = 'Button text';
$string['frontpagesliderbuttontext_desc'] = 'Label for the slider button (e.g. Hire us).';
$string['frontpagesliderbuttonurl'] = 'Button link';
$string['frontpagesliderbuttonurl_desc'] = 'URL for the slider button.';
$string['frontpagesliderbuttondefault'] = 'Hire us';
