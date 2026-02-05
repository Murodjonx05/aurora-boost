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
 * Slider management page for Aurora theme.
 *
 * @package   theme_aurora
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/theme/aurora/classes/form/slider_item_form.php');

admin_externalpage_setup('theme_aurora_slider');

$context = context_system::instance();
$baseurl = new moodle_url('/theme/aurora/slider.php');

$action = optional_param('action', '', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);

$PAGE->set_url($baseurl, ['action' => $action, 'id' => $id]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('frontpageslidermanage', 'theme_aurora'));
$PAGE->set_heading(get_string('frontpageslidermanage', 'theme_aurora'));
$PAGE->requires->css('/theme/aurora/style/slider-admin.css');

$fs = get_file_storage();

$normalise_sortorder = function() use ($DB) {
    $records = $DB->get_records('theme_aurora_slider', [], 'sortorder ASC, id ASC');
    $sortorder = 1;
    foreach ($records as $record) {
        if ((int)$record->sortorder !== $sortorder) {
            $record->sortorder = $sortorder;
            $DB->update_record('theme_aurora_slider', $record);
        }
        $sortorder++;
    }
};

if (in_array($action, ['delete', 'toggle', 'moveup', 'movedown'], true) && $id) {
    require_sesskey();
    $record = $DB->get_record('theme_aurora_slider', ['id' => $id], '*', MUST_EXIST);

    if ($action === 'delete') {
        $DB->delete_records('theme_aurora_slider', ['id' => $id]);
        $fs->delete_area_files($context->id, 'theme_aurora', 'frontpage_slider', $id);
        $normalise_sortorder();
        redirect($baseurl, get_string('frontpagesliderdeleted', 'theme_aurora'));
    }

    if ($action === 'toggle') {
        $record->enabled = $record->enabled ? 0 : 1;
        $record->timemodified = time();
        $DB->update_record('theme_aurora_slider', $record);
        redirect($baseurl, get_string('frontpagesliderupdated', 'theme_aurora'));
    }

    if ($action === 'moveup' || $action === 'movedown') {
        $normalise_sortorder();
        $records = $DB->get_records('theme_aurora_slider', [], 'sortorder ASC, id ASC');
        $ids = array_keys($records);
        $index = array_search($id, $ids, true);
        if ($index !== false) {
            $swapindex = ($action === 'moveup') ? $index - 1 : $index + 1;
            if (isset($ids[$swapindex])) {
                $current = $records[$ids[$index]];
                $swap = $records[$ids[$swapindex]];
                $tempsort = $current->sortorder;
                $current->sortorder = $swap->sortorder;
                $swap->sortorder = $tempsort;
                $current->timemodified = time();
                $swap->timemodified = time();
                $DB->update_record('theme_aurora_slider', $current);
                $DB->update_record('theme_aurora_slider', $swap);
            }
        }
        redirect($baseurl);
    }
}

$form = new \theme_aurora\form\slider_item_form(null, ['context' => $context]);
$options = $form->get_image_options();

if ($action === 'edit' && $id) {
    $record = $DB->get_record('theme_aurora_slider', ['id' => $id], '*', MUST_EXIST);
    $draftid = file_get_submitted_draft_itemid('imagefile');
    file_prepare_draft_area($draftid, $context->id, 'theme_aurora', 'frontpage_slider', $id, $options);
    $record->imagefile = $draftid;
    $form->set_data($record);
} else {
    $draftid = file_get_submitted_draft_itemid('imagefile');
    file_prepare_draft_area($draftid, $context->id, 'theme_aurora', 'frontpage_slider', 0, $options);
    $form->set_data((object)[
        'imagefile' => $draftid,
        'enabled' => 1,
    ]);
}

if ($form->is_cancelled()) {
    redirect($baseurl);
}

if ($data = $form->get_data()) {
    $now = time();
    $record = (object)[
        'title' => $data->title ?? '',
        'description' => $data->description ?? '',
        'imagealt' => $data->imagealt ?? '',
        'buttontext' => $data->buttontext ?? '',
        'buttonurl' => $data->buttonurl ?? '',
        'enabled' => !empty($data->enabled) ? 1 : 0,
        'timemodified' => $now,
    ];

    if (empty($data->id)) {
        $record->sortorder = (int)$DB->get_field_sql('SELECT COALESCE(MAX(sortorder), 0) FROM {theme_aurora_slider}') + 1;
        $record->timecreated = $now;
        $id = $DB->insert_record('theme_aurora_slider', $record, true);
    } else {
        $record->id = $data->id;
        $DB->update_record('theme_aurora_slider', $record);
        $id = $data->id;
    }

    file_save_draft_area_files($data->imagefile, $context->id, 'theme_aurora', 'frontpage_slider', $id, $options);
    redirect($baseurl, get_string('frontpagesliderupdated', 'theme_aurora'));
}

$records = $DB->get_records('theme_aurora_slider', [], 'sortorder ASC, id ASC');

$addurl = new moodle_url($baseurl, ['action' => 'add']);
$PAGE->navbar->add(get_string('frontpageslidermanage', 'theme_aurora'));

$header = get_string('frontpageslidermanage', 'theme_aurora');
$formtitle = ($action === 'edit') ? get_string('frontpageslideredit', 'theme_aurora') : get_string('frontpageslideradd', 'theme_aurora');

echo $OUTPUT->header();

echo $OUTPUT->heading($header);

echo html_writer::tag('div',
    html_writer::tag('h3', $formtitle, ['class' => 'aurora-slider-form-title']) .
    ($action === 'edit' ? html_writer::link($baseurl, get_string('frontpageslidercancel', 'theme_aurora'), ['class' => 'btn btn-secondary ms-2']) : ''),
    ['class' => 'd-flex align-items-center mb-3']
);

$form->display();

echo html_writer::tag('h3', get_string('frontpagesliderlist', 'theme_aurora'), ['class' => 'mt-4']);

if (empty($records)) {
    echo html_writer::div(get_string('frontpagesliderempty', 'theme_aurora'), 'alert alert-info');
} else {
    $table = new html_table();
    $table->head = [
        get_string('frontpagesliderpreview', 'theme_aurora'),
        get_string('frontpageslideritemtitle', 'theme_aurora'),
        get_string('frontpagesliderenabledlabel', 'theme_aurora'),
        get_string('actions'),
    ];
    $table->attributes['class'] = 'generaltable aurora-slider-table';

    $total = count($records);
    $position = 0;
    foreach ($records as $record) {
        $imageurl = null;
        $files = $fs->get_area_files(
            $context->id,
            'theme_aurora',
            'frontpage_slider',
            $record->id,
            'itemid, filepath, filename',
            false
        );
        if (!empty($files)) {
            $file = reset($files);
            $imageurl = moodle_url::make_pluginfile_url(
                $context->id,
                'theme_aurora',
                'frontpage_slider',
                $record->id,
                '/',
                $file->get_filename()
            );
        }

        $preview = $imageurl ?
            html_writer::empty_tag('img', [
                'src' => $imageurl->out(false),
                'alt' => s($record->title),
                'class' => 'aurora-slider-preview',
            ]) :
            html_writer::div(get_string('none'), 'text-muted');

        $enabled = $record->enabled ? get_string('yes') : get_string('no');

        $actions = [];
        $actions[] = html_writer::link(
            new moodle_url($baseurl, ['action' => 'edit', 'id' => $record->id]),
            get_string('edit')
        );
        $actions[] = html_writer::link(
            new moodle_url($baseurl, ['action' => 'toggle', 'id' => $record->id, 'sesskey' => sesskey()]),
            $record->enabled ? get_string('disable') : get_string('enable')
        );
        if ($position > 0) {
            $actions[] = html_writer::link(
                new moodle_url($baseurl, ['action' => 'moveup', 'id' => $record->id, 'sesskey' => sesskey()]),
                get_string('moveup')
            );
        }
        if ($position < $total - 1) {
            $actions[] = html_writer::link(
                new moodle_url($baseurl, ['action' => 'movedown', 'id' => $record->id, 'sesskey' => sesskey()]),
                get_string('movedown')
            );
        }
        $actions[] = html_writer::link(
            new moodle_url($baseurl, ['action' => 'delete', 'id' => $record->id, 'sesskey' => sesskey()]),
            get_string('delete')
        );

        $table->data[] = [
            $preview,
            format_string($record->title ?? ''),
            $enabled,
            implode(' | ', $actions),
        ];
        $position++;
    }

    echo html_writer::table($table);
}

echo $OUTPUT->footer();
