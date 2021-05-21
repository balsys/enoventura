<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2020 onwards Totara Learning Solutions LTD
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Johannes Cilliers <johannes.cilliers@totaralearning.com>
 * @package theme_enoventura
 */

defined('MOODLE_INTERNAL') || die();

global $PAGE;
/*
$component = 'theme_enoventura';

// Create own category and define pages.
$ADMIN->add('themes', new admin_category($component, get_string('pluginname_settings', 'theme_enoventura')));

require ($CFG->dirroot.'/theme/enoventura/settings/general.php');

*/
$settings = new admin_externalpage(
    'enoventura_editor',
    get_string('pluginname', 'theme_enoventura'),
    $CFG->wwwroot . '/theme/enoventura/index.php',
    'totara/tui:themesettings'
);

