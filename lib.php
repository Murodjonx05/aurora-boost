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
 * Theme functions.
 *
 * @package    theme_aurora
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_aurora_get_main_scss_content($theme)
{
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }
    else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    }
    else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_aurora', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    }
    else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    return $scss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_aurora_get_extra_scss($theme)
{
    $content = '';
    $imageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');

    // Sets the background image, and its settings.
    if (!empty($imageurl)) {
        $content .= '@media (min-width: 768px) {';
        $content .= 'body { ';
        $content .= "background-image: url('$imageurl'); background-size: cover;";
        $content .= ' } }';
    }

    // Sets the login background image.
    $loginbackgroundimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    if (!empty($loginbackgroundimageurl)) {
        $content .= 'body.pagelayout-login #page { ';
        $content .= "background-image: url('$loginbackgroundimageurl'); background-size: cover;";
        $content .= ' }';
    }

    // Always return the background image with the scss when we have it.
    return !empty($theme->settings->scss) ? "{$theme->settings->scss}  \n  {$content}" : $content;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_aurora_get_pre_scss($theme)
{
    global $CFG;

    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandcolor' => ['primary'],
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{ $configkey}) ? $theme->settings->{ $configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function ($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array)$targets);
    }

    // Add navbar variables.
    $navprimary = !empty($theme->settings->aurora_nav_primary) ? $theme->settings->aurora_nav_primary : '#007bff';
    $navsecondary = !empty($theme->settings->aurora_nav_secondary) ? $theme->settings->aurora_nav_secondary : '#6c757d';
    $navtext = !empty($theme->settings->aurora_nav_text) ? $theme->settings->aurora_nav_text : '#ffffff';
    $navtexthover = !empty($theme->settings->aurora_nav_text_hover) ? $theme->settings->aurora_nav_text_hover : '#e9ecef';
    $navborderradius = !empty($theme->settings->aurora_nav_border_radius) ? $theme->settings->aurora_nav_border_radius : '4px';
    $navtextweight = !empty($theme->settings->aurora_nav_text_weight) ? $theme->settings->aurora_nav_text_weight : 'normal';
    $navlinksposition = !empty($theme->settings->aurora_nav_links_position) ? $theme->settings->aurora_nav_links_position : 'left';
    $navlinksalign = 'flex-start';
    if ($navlinksposition === 'center') {
        $navlinksalign = 'center';
    }
    else if ($navlinksposition === 'right') {
        $navlinksalign = 'flex-end';
    }

    $scss .= "/* Navbar variables */\n";
    $scss .= ":root {\n";
    $scss .= "  --aurora_nav_primary: " . $navprimary . ";\n";
    $scss .= "  --aurora_nav_secondary: " . $navsecondary . ";\n";
    $scss .= "  --aurora_nav_text: " . $navtext . ";\n";
    $scss .= "  --aurora_nav_text_hover: " . $navtexthover . ";\n";
    $scss .= "  --aurora_nav_border_radius: " . $navborderradius . ";\n";
    $scss .= "  --aurora_nav_text_weight: " . $navtextweight . ";\n";
    $scss .= "  --aurora_nav_links_align: " . $navlinksalign . ";\n";
    $scss .= "}\n";

    // Add a new variable to indicate that we are running behat.
    if (defined('BEHAT_SITE_RUNNING')) {
        $scss .= "\$behatsite: true;\n";
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    return $scss;
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_aurora_get_precompiled_css()
{
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/boost/style/moodle.css');
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
/**
 * Override or extend methods of the core renderer and other core renderers.
 *
 * @param string $classname Name of the renderer to be adapted
 * @return string Name of the rendering class to be used
 */
function theme_aurora_get_renderer($classname)
{
    // Override the myoverview block renderer
    if ($classname === 'block_myoverview\output\renderer') {
        return 'theme_aurora\output\block_myoverview_renderer';
    }

    // For all other renderers, use the parent theme's renderer
    return null;
}

function theme_aurora_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }

    if ($filearea === 'frontpage_slider') {
        $itemid = (int)array_shift($args);
        $filename = array_pop($args);
        $filepath = $args ? '/' . implode('/', $args) . '/' : '/';

        $fs = get_file_storage();
        $file = $fs->get_file($context->id, 'theme_aurora', 'frontpage_slider', $itemid, $filepath, $filename);
        if (!$file) {
            send_file_not_found();
        }

        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }

        send_stored_file($file, 60 * 60 * 24 * 60, 0, $forcedownload, $options);
        return true;
    }

    if ($filearea === 'logo' || $filearea === 'backgroundimage' || $filearea === 'loginbackgroundimage' ||
    $filearea === 'frontpage_slider_image') {
        $theme = theme_config::load('aurora');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    send_file_not_found();
}