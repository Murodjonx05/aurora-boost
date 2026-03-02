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

    // Additional link color variables.
    $linkcolor = !empty($theme->settings->linkcolor) ? $theme->settings->linkcolor : '#2561f0';
    $linkvisitedcolor = !empty($theme->settings->linkvisitedcolor) ? $theme->settings->linkvisitedcolor : '#690daf';
    $linkhovercolor = !empty($theme->settings->linkhovercolor) ? $theme->settings->linkhovercolor : '#1c3498';
    $linkactivecolor = !empty($theme->settings->linkactivecolor) ? $theme->settings->linkactivecolor : '#1c3498';
    $courseblockcolorstart = !empty($theme->settings->courseblockcolorstart) ? $theme->settings->courseblockcolorstart : '#f3f6fb';
    $courseblockcolorend = !empty($theme->settings->courseblockcolorend) ? $theme->settings->courseblockcolorend : '#e5ebf3';
    $scss .= "  --aurora_link_color: " . $linkcolor . ";\n";
    $scss .= "  --aurora_link_visited_color: " . $linkvisitedcolor . ";\n";
    $scss .= "  --aurora_link_hover_color: " . $linkhovercolor . ";\n";
    $scss .= "  --aurora_link_active_color: " . $linkactivecolor . ";\n";
    $scss .= "  --aurora_course_block_color_start: " . $courseblockcolorstart . ";\n";
    $scss .= "  --aurora_course_block_color_end: " . $courseblockcolorend . ";\n";
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

/**
 * Parse "Text|URL" lines into mustache-friendly links.
 *
 * @param string|null $raw
 * @return array
 */
function theme_aurora_parse_link_lines(?string $raw): array
{
    $links = [];
    if (empty($raw)) {
        return $links;
    }

    $context = context_system::instance();
    $lines = preg_split('/\r\n|\r|\n/', $raw);
    foreach ($lines as $line) {
        $line = trim((string)$line);
        if ($line === '' || strpos($line, '|') === false) {
            continue;
        }

        [$textraw, $urlraw] = array_map('trim', explode('|', $line, 2));
        if ($textraw === '' || $urlraw === '') {
            continue;
        }

        $url = clean_param($urlraw, PARAM_URL);
        if ($url === '') {
            $url = clean_param($urlraw, PARAM_LOCALURL);
        }
        if ($url === '') {
            continue;
        }

        $text = format_text($textraw, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false]);
        $links[] = [
            'text' => $text,
            'url' => $url,
        ];
    }

    return $links;
}

/**
 * Build custom template context from theme settings.
 *
 * @return array
 */
function theme_aurora_get_template_context(): array
{
    global $SITE;

    $theme = theme_config::load('aurora');
    $context = context_system::instance();
    $footerlogo = $theme->setting_file_url('footerlogo', 'footerlogo');
    $navbarlogo = $theme->setting_file_url('navbarlogo', 'navbarlogo');

    $footerbrandtitle = !empty($theme->settings->footerbrandtitle)
        ? format_text($theme->settings->footerbrandtitle, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false])
        : format_string($SITE->shortname, true, ['context' => $context, 'escape' => false]);
    $footerdescription = !empty($theme->settings->footerdescription)
        ? format_text($theme->settings->footerdescription, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false])
        : '';
    $footercontacttitle = !empty($theme->settings->footercontacttitle)
        ? format_text($theme->settings->footercontacttitle, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false])
        : get_string('footercontacttitle_default', 'theme_aurora');
    $footernavtitle = !empty($theme->settings->footernavtitle)
        ? format_text($theme->settings->footernavtitle, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false])
        : get_string('footernavtitle_default', 'theme_aurora');
    $footercopyright = !empty($theme->settings->footercopyright)
        ? format_text($theme->settings->footercopyright, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false])
        : '&copy; ' . date('Y') . ' ' . format_string($SITE->shortname, true, ['context' => $context, 'escape' => false]);
    $footerbottomright = !empty($theme->settings->footerbottomright)
        ? format_text($theme->settings->footerbottomright, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false])
        : '';

    $contactitems = [];
    $address = trim((string)($theme->settings->footercontactaddress ?? ''));
    $phone = trim((string)($theme->settings->footercontactphone ?? ''));
    $email = trim((string)($theme->settings->footercontactemail ?? ''));
    $extra = trim((string)($theme->settings->footercontactextra ?? ''));

    if ($address !== '') {
        $contactitems[] = [
            'label' => format_text($address, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false]),
            'icon' => 'location',
        ];
    }
    if ($phone !== '') {
        $phonelink = preg_replace('/[^0-9+]/', '', $phone);
        $contactitems[] = [
            'label' => format_text($phone, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false]),
            'icon' => 'phone',
            'url' => $phonelink !== '' ? 'tel:' . $phonelink : null,
            'hasurl' => $phonelink !== '',
        ];
    }
    if ($email !== '') {
        $emailclean = clean_param($email, PARAM_EMAIL);
        $contactitems[] = [
            'label' => format_text($email, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false]),
            'icon' => 'email',
            'url' => $emailclean !== '' ? 'mailto:' . $emailclean : null,
            'hasurl' => $emailclean !== '',
        ];
    }
    if ($extra !== '') {
        $contactitems[] = [
            'label' => format_text($extra, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false]),
            'icon' => 'info',
        ];
    }

    // Backward compatibility with the old textarea format.
    if (empty($contactitems) && !empty($theme->settings->footercontacts)) {
        foreach (preg_split('/\r\n|\r|\n/', (string)$theme->settings->footercontacts) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $contactitems[] = [
                'label' => format_text($line, FORMAT_HTML, ['context' => $context, 'filter' => true, 'para' => false]),
                'icon' => 'info',
            ];
        }
    }

    $navbarlinks = theme_aurora_parse_link_lines($theme->settings->navbarcustomlinks ?? '');
    $navbarlinks = theme_aurora_ensure_courses_nav_link($navbarlinks);
    $footernavlinks = theme_aurora_parse_link_lines($theme->settings->footernavlinks ?? '');

    $footerenabled = !isset($theme->settings->footerenabled) || (int)$theme->settings->footerenabled === 1;

    return [
        'auroranavbar' => [
            'customlogo' => !empty($navbarlogo) ? $navbarlogo : null,
            'customlinks' => $navbarlinks,
            'hascustomlinks' => !empty($navbarlinks),
        ],
        'aurorafooter' => [
            'enabled' => $footerenabled,
            'logo' => !empty($footerlogo) ? $footerlogo : null,
            'brandtitle' => $footerbrandtitle,
            'description' => $footerdescription,
            'contacttitle' => $footercontacttitle,
            'contactitems' => $contactitems,
            'hascontactitems' => !empty($contactitems),
            'navtitle' => $footernavtitle,
            'navlinks' => $footernavlinks,
            'hasnavlinks' => !empty($footernavlinks),
            'copyright' => $footercopyright,
            'bottomright' => $footerbottomright,
        ],
    ];
}

/**
 * Ensure the "All courses" link is present in the navbar custom links.
 *
 * @param array $links
 * @return array
 */
function theme_aurora_ensure_courses_nav_link(array $links): array
{
    $coursesurl = (new moodle_url('/course/'))->out(false);
    $normalize = static function(string $url): string {
        return rtrim($url, '/');
    };

    foreach ($links as $link) {
        if ($normalize((string)($link['url'] ?? '')) === $normalize($coursesurl)) {
            return $links;
        }
    }

    $courseslink = [
        'text' => format_string(get_string('courses')),
        'url' => $coursesurl,
    ];

    $inserted = false;
    foreach ($links as $index => $link) {
        if ($normalize((string)($link['url'] ?? '')) === $normalize((new moodle_url('/my/courses.php'))->out(false))) {
            array_splice($links, $index + 1, 0, [$courseslink]);
            $inserted = true;
            break;
        }
    }

    if (!$inserted) {
        $links[] = $courseslink;
    }

    return $links;
}

/**
 * Remove the dashboard link from primary navigation and move it into the user menu.
 *
 * @param array $primarymenu
 * @return array
 */
function theme_aurora_relocate_dashboard_link(array $primarymenu): array
{
    theme_aurora_remove_primary_nav_item($primarymenu['moremenu'], 'home');
    theme_aurora_remove_mobile_primary_nav_item($primarymenu['mobileprimarynav'], 'home');

    $dashboarditem = theme_aurora_extract_dashboard_from_moremenu($primarymenu['moremenu']);
    $dashboarditem = theme_aurora_extract_dashboard_from_mobileprimarynav(
        $primarymenu['mobileprimarynav'],
        $dashboarditem
    );
    theme_aurora_insert_dashboard_into_usermenu($primarymenu['user'], $dashboarditem);

    return $primarymenu;
}

/**
 * Remove a specific item from the desktop primary menu export.
 *
 * @param array $moremenu
 * @param string $itemkey
 * @return void
 */
function theme_aurora_remove_primary_nav_item(array &$moremenu, string $itemkey): void
{
    if (empty($moremenu['nodearray']) || !is_array($moremenu['nodearray'])) {
        return;
    }

    foreach ($moremenu['nodearray'] as $index => $item) {
        if (($item['key'] ?? null) !== $itemkey) {
            continue;
        }

        array_splice($moremenu['nodearray'], $index, 1);
        return;
    }
}

/**
 * Remove the dashboard item from the desktop primary menu export.
 *
 * @param array $moremenu
 * @return array|null
 */
function theme_aurora_extract_dashboard_from_moremenu(array &$moremenu): ?array
{
    if (empty($moremenu['nodearray']) || !is_array($moremenu['nodearray'])) {
        return null;
    }

    foreach ($moremenu['nodearray'] as $index => $item) {
        if (($item['key'] ?? null) !== 'myhome') {
            continue;
        }

        $dashboarditem = [
            'text' => $item['text'] ?? get_string('myhome'),
            'url' => ($item['url'] ?? '') . ($item['action'] ?? ''),
        ];
        array_splice($moremenu['nodearray'], $index, 1);
        return $dashboarditem;
    }

    return null;
}

/**
 * Remove the dashboard item from the mobile primary nav export.
 *
 * @param array $mobileprimarynav
 * @param array|null $dashboarditem
 * @return array|null
 */
function theme_aurora_extract_dashboard_from_mobileprimarynav(array &$mobileprimarynav, ?array $dashboarditem = null): ?array
{
    foreach ($mobileprimarynav as $index => $item) {
        if (($item['key'] ?? null) !== 'myhome') {
            continue;
        }

        if ($dashboarditem === null) {
            $dashboarditem = [
                'text' => $item['text'] ?? get_string('myhome'),
                'url' => $item['url'] ?? '',
            ];
        }

        array_splice($mobileprimarynav, $index, 1);
        break;
    }

    return $dashboarditem;
}

/**
 * Remove a specific item from the mobile primary nav export.
 *
 * @param array $mobileprimarynav
 * @param string $itemkey
 * @return void
 */
function theme_aurora_remove_mobile_primary_nav_item(array &$mobileprimarynav, string $itemkey): void
{
    foreach ($mobileprimarynav as $index => $item) {
        if (($item['key'] ?? null) !== $itemkey) {
            continue;
        }

        array_splice($mobileprimarynav, $index, 1);
        return;
    }
}

/**
 * Insert the dashboard item into the user menu, right after Private files when available.
 *
 * @param array $usermenu
 * @param array|null $dashboarditem
 * @return void
 */
function theme_aurora_insert_dashboard_into_usermenu(array &$usermenu, ?array $dashboarditem): void
{
    if ($dashboarditem === null || empty($dashboarditem['url']) || empty($usermenu['items']) || !is_array($usermenu['items'])) {
        return;
    }

    foreach ($usermenu['items'] as $item) {
        if (($item->url ?? null) === $dashboarditem['url']) {
            return;
        }
    }

    $newitem = (object) [
        'itemtype' => 'link',
        'link' => true,
        'divider' => false,
        'title' => $dashboarditem['text'],
        'url' => $dashboarditem['url'],
    ];

    $insertindex = null;
    foreach ($usermenu['items'] as $index => $item) {
        if (strpos((string)($item->url ?? ''), '/user/files.php') !== false) {
            $insertindex = $index + 1;
            break;
        }
    }

    if ($insertindex === null) {
        foreach ($usermenu['items'] as $index => $item) {
            if (!empty($item->divider)) {
                $insertindex = $index;
                break;
            }
        }
    }

    if ($insertindex === null) {
        $usermenu['items'][] = $newitem;
        return;
    }

    array_splice($usermenu['items'], $insertindex, 0, [$newitem]);
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
    $filearea === 'navbarlogo' || $filearea === 'footerlogo' ||
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
