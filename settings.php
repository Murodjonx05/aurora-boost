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
 * @package   theme_aurora
 * @copyright 2016 Ryan Wyllie
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $title = get_string('frontpageslidermanage', 'theme_aurora');
    $url = new moodle_url('/theme/aurora/slider.php');
    $ADMIN->add('themes', new admin_externalpage('theme_aurora_slider', $title, $url));
}

if ($ADMIN->fulltree) {
    $settings = new theme_aurora_admin_settingspage_tabs('themesettingaurora', get_string('configtitle', 'theme_aurora'));
    $page = new admin_settingpage('theme_aurora_general', get_string('generalsettings', 'theme_aurora'));

    // Unaddable blocks.
    // Blocks to be excluded when this theme is enabled in the "Add a block" list: Administration, Navigation and Courses.
    $default = 'navigation,settings,course_list';
    $setting = new admin_setting_configtext('theme_aurora/unaddableblocks',
        get_string('unaddableblocks', 'theme_aurora'), get_string('unaddableblocks_desc', 'theme_aurora'), $default, PARAM_TEXT);
    $page->add($setting);

    // Preset.
    $name = 'theme_aurora/preset';
    $title = get_string('preset', 'theme_aurora');
    $description = get_string('preset_desc', 'theme_aurora');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_aurora', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configthemepreset($name, $title, $description, $default, $choices, 'aurora');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_aurora/presetfiles';
    $title = get_string('presetfiles', 'theme_aurora');
    $description = get_string('presetfiles_desc', 'theme_aurora');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Background image setting.
    $name = 'theme_aurora/backgroundimage';
    $title = get_string('backgroundimage', 'theme_aurora');
    $description = get_string('backgroundimage_desc', 'theme_aurora');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'backgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login Background image setting.
    $name = 'theme_aurora/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_aurora');
    $description = get_string('loginbackgroundimage_desc', 'theme_aurora');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_aurora/brandcolor';
    $title = get_string('brandcolor', 'theme_aurora');
    $description = get_string('brandcolor_desc', 'theme_aurora');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    // Navbar settings.
    $page = new admin_settingpage('theme_aurora_navbar', get_string('navbarsettings', 'theme_aurora'));

    // Navbar primary color.
    $name = 'theme_aurora/aurora_nav_primary';
    $title = get_string('auroranavprimary', 'theme_aurora');
    $description = get_string('auroranavprimarydesc', 'theme_aurora');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#007bff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Navbar secondary color.
    $name = 'theme_aurora/aurora_nav_secondary';
    $title = get_string('auroranavsecondary', 'theme_aurora');
    $description = get_string('auroranavsecondarydesc', 'theme_aurora');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#6c757d');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Navbar text color.
    $name = 'theme_aurora/aurora_nav_text';
    $title = get_string('auroranavtext', 'theme_aurora');
    $description = get_string('auroranavtextdesc', 'theme_aurora');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#ffffff');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Navbar text hover color.
    $name = 'theme_aurora/aurora_nav_text_hover';
    $title = get_string('auroranavtexthover', 'theme_aurora');
    $description = get_string('auroranavtexthoverdesc', 'theme_aurora');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '#e9ecef');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Navbar border radius.
    $name = 'theme_aurora/aurora_nav_text_weight';
    $title = get_string('auroranavbortextweight', 'theme_aurora');
    $description = get_string('auroranavbortextweightdesc', 'theme_aurora');
    $default = '400';
    $choices = [
        '100' => '100',
        '200' => '200',
        '300' => '300',
        '400' => '400',
        '500' => '500',
        '600' => '600',
        '700' => '700',
        '800' => '800',
        '900' => '900',
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Navbar links position.
    $name = 'theme_aurora/aurora_nav_links_position';
    $title = get_string('auroranavlinksposition', 'theme_aurora');
    $description = get_string('auroranavlinkspositiondesc', 'theme_aurora');
    $default = 'left';
    $choices = [
        'left' => get_string('auroranavlinkspositionleft', 'theme_aurora'),
        'center' => get_string('auroranavlinkspositioncenter', 'theme_aurora'),
        'right' => get_string('auroranavlinkspositionright', 'theme_aurora'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    // Navbar border radius.
    $name = 'theme_aurora/aurora_nav_border_radius';
    $title = get_string('auroranavborderradius', 'theme_aurora');
    $description = get_string('auroranavborderradiusdesc', 'theme_aurora');
    $default = '4px';
    $choices = [
        '0px' => '0px',
        '4px' => '4px',
        '8px' => '8px',
        '12px' => '12px',
        '16px' => '16px',
        '24px' => '24px',
        '32px' => '32px',
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // Front page slider settings.
    $page = new admin_settingpage('theme_aurora_frontpage', get_string('frontpagesettings', 'theme_aurora'));

    $name = 'theme_aurora/frontpage_slider_enabled';
    $title = get_string('frontpagesliderenabled', 'theme_aurora');
    $description = get_string('frontpagesliderenabled_desc', 'theme_aurora');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $managelink = html_writer::link(new moodle_url('/theme/aurora/slider.php'),
        get_string('frontpageslidermanagelink', 'theme_aurora'));
    $setting = new admin_setting_heading('theme_aurora/frontpage_slider_manage', '',
        get_string('frontpageslidermanagedesc', 'theme_aurora', $managelink));
    $page->add($setting);

    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_aurora_advanced', get_string('advancedsettings', 'theme_aurora'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_aurora/scsspre',
        get_string('rawscsspre', 'theme_aurora'), get_string('rawscsspre_desc', 'theme_aurora'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_aurora/scss', get_string('rawscss', 'theme_aurora'),
        get_string('rawscss_desc', 'theme_aurora'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}