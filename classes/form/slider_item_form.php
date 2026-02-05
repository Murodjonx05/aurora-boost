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

namespace theme_aurora\form;

defined('MOODLE_INTERNAL') || die();

require_once($GLOBALS['CFG']->libdir . '/formslib.php');

/**
 * Slider item form for Aurora theme.
 *
 * @package   theme_aurora
 */
class slider_item_form extends \moodleform {
    /**
     * Define the form fields.
     */
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'title', get_string('frontpageslideritemtitle', 'theme_aurora'), ['size' => 60]);
        $mform->setType('title', PARAM_TEXT);

        $mform->addElement('textarea', 'description', get_string('frontpageslideritemdescription', 'theme_aurora'),
            'wrap="virtual" rows="4" cols="60"');
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('filemanager', 'imagefile', get_string('frontpageslideritemimage', 'theme_aurora'),
            null, $this->get_image_options());

        $mform->addElement('text', 'imagealt', get_string('frontpageslideritemimagealt', 'theme_aurora'), ['size' => 60]);
        $mform->setType('imagealt', PARAM_TEXT);

        $mform->addElement('text', 'buttontext', get_string('frontpageslideritembuttontext', 'theme_aurora'), ['size' => 40]);
        $mform->setType('buttontext', PARAM_TEXT);

        $mform->addElement('text', 'buttonurl', get_string('frontpageslideritembuttonurl', 'theme_aurora'), ['size' => 60]);
        $mform->setType('buttonurl', PARAM_RAW_TRIMMED);

        $mform->addElement('advcheckbox', 'enabled', get_string('frontpagesliderenabledlabel', 'theme_aurora'));
        $mform->setDefault('enabled', 1);
        $mform->setType('enabled', PARAM_BOOL);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons(true, get_string('savechanges'));
    }

    /**
     * File manager options for slider images.
     *
     * @return array
     */
    public function get_image_options(): array {
        return [
            'maxbytes' => 0,
            'subdirs' => 0,
            'maxfiles' => 1,
            'accepted_types' => ['.png', '.jpg', '.jpeg', '.webp', '.svg'],
        ];
    }
}
