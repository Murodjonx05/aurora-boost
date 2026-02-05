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
 * Aurora theme upgrade script.
 *
 * @package   theme_aurora
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute Aurora theme upgrade steps.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_theme_aurora_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2025100601) {
        $table = new xmldb_table('theme_aurora_slider');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('sortorder', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('enabled', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('title', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('imagealt', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('buttontext', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('buttonurl', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_index('sortorder_idx', XMLDB_INDEX_NOTUNIQUE, ['sortorder']);
        $table->add_index('enabled_idx', XMLDB_INDEX_NOTUNIQUE, ['enabled']);

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Migrate existing slider settings if no records exist yet.
        if (!$DB->record_exists('theme_aurora_slider', [])) {
            $items = [];
            $rawitems = get_config('theme_aurora', 'frontpage_slider_items');
            if (!empty($rawitems)) {
                $decoded = json_decode($rawitems, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $item) {
                        if (!is_array($item)) {
                            continue;
                        }
                        $items[] = [
                            'title' => trim((string)($item['title'] ?? '')),
                            'description' => trim((string)($item['description'] ?? '')),
                            'imagealt' => trim((string)($item['imagealt'] ?? '')),
                            'buttontext' => trim((string)($item['buttontext'] ?? '')),
                            'buttonurl' => trim((string)($item['buttonurl'] ?? '')),
                        ];
                    }
                }
            }

            if (empty($items)) {
                $title = (string)get_config('theme_aurora', 'frontpage_slider_title');
                $description = (string)get_config('theme_aurora', 'frontpage_slider_description');
                $buttontext = (string)get_config('theme_aurora', 'frontpage_slider_button_text');
                $buttonurl = (string)get_config('theme_aurora', 'frontpage_slider_button_url');

                if ($title !== '' || $description !== '' || $buttonurl !== '') {
                    $items[] = [
                        'title' => trim($title),
                        'description' => trim($description),
                        'imagealt' => '',
                        'buttontext' => trim($buttontext),
                        'buttonurl' => trim($buttonurl),
                    ];
                }
            }

            $firstid = null;
            $sortorder = 1;
            $now = time();
            foreach ($items as $item) {
                $record = (object)[
                    'sortorder' => $sortorder,
                    'enabled' => 1,
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'imagealt' => $item['imagealt'],
                    'buttontext' => $item['buttontext'],
                    'buttonurl' => $item['buttonurl'],
                    'timecreated' => $now,
                    'timemodified' => $now,
                ];
                $id = $DB->insert_record('theme_aurora_slider', $record, true);
                if ($firstid === null) {
                    $firstid = $id;
                }
                $sortorder++;
            }

            // Migrate old slider image into the first slide.
            if (!empty($firstid)) {
                $context = context_system::instance();
                $fs = get_file_storage();
                $files = $fs->get_area_files(
                    $context->id,
                    'theme_aurora',
                    'frontpage_slider_image',
                    0,
                    'itemid, filepath, filename',
                    false
                );
                if (!empty($files)) {
                    $file = reset($files);
                    $newfile = [
                        'contextid' => $context->id,
                        'component' => 'theme_aurora',
                        'filearea' => 'frontpage_slider',
                        'itemid' => $firstid,
                        'filepath' => '/',
                        'filename' => $file->get_filename(),
                    ];
                    $fs->create_file_from_storedfile($newfile, $file);
                }
                $fs->delete_area_files($context->id, 'theme_aurora', 'frontpage_slider_image', 0);
            }
        }

        // Remove legacy slider settings.
        set_config('frontpage_slider_items', null, 'theme_aurora');
        set_config('frontpage_slider_title', null, 'theme_aurora');
        set_config('frontpage_slider_description', null, 'theme_aurora');
        set_config('frontpage_slider_button_text', null, 'theme_aurora');
        set_config('frontpage_slider_button_url', null, 'theme_aurora');

        upgrade_plugin_savepoint(true, 2025100601, 'theme', 'aurora');
    }

    return true;
}
