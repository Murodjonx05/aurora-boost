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

namespace theme_aurora\output;

defined('MOODLE_INTERNAL') || die;

// Custom renderer for the My Overview block.
class block_myoverview_renderer extends \plugin_renderer_base {
    // We rely on the parent (core) renderer to handle the main logic.
    // This ensures that the JavaScript required to fetch courses is correctly initialized.
    // Our custom 'templates/block_myoverview/view-cards.mustache' will automatically
    // be used by the core logic when rendering the cards.
}