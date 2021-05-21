<?php
/*
 * This file is part of Totara LMS
 *
 * Copyright (C) 2015 onwards Totara Learning Solutions LTD
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
 * @author Brian Barnes <brian.barnes@totaralearning.com>
 * @author Joby Harding <joby.harding@totaralearning.com>
 * @package theme_enovation
 */

defined('MOODLE_INTERNAL') || die;

/** @global $component */

$temp = new admin_settingpage($component . '_settings_general', get_string('general', $component . ''));

// Enable / disable style overrides.
// As settings-based style overrides are not Less processed
// and colour variants are automatically generated by PHP
// there is a small reduction in quality.
$name        = "{$component}/enablestyleoverrides";
$title       = new lang_string('general_enablestyleoverrides', $component);
$description = new lang_string('general_enablestyleoverrides_desc', $component);
$default     = '1';
$setting     = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$ADMIN->add($component, $temp);

