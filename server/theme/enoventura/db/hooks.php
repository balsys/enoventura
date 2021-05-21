<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2021 onwards Totara Learning Solutions LTD
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Johannes Cilliers <johannes.cilliers@totaralearning.com>
 * @package theme_example
 */

use core\hook\tenant_customizable_theme_settings as tenant_customizable_theme_settings_hook;
use core\hook\theme_settings_css_categories as theme_settings_css_categories_hook;
use theme_enoventura\watcher\customizable_theme_settings_watcher;

defined('MOODLE_INTERNAL') || die;

$watchers = [
        [
            // Identify categories and properties that tenants are allowed to update.
                'hookname' => tenant_customizable_theme_settings_hook::class,
                'callback' => [customizable_theme_settings_watcher::class, 'customize_tenant_category_settings'],
        ],
        [
            // Identify categories that contains CSS variables that needs to be included in styles.
                'hookname' => theme_settings_css_categories_hook::class,
                'callback' => [customizable_theme_settings_watcher::class, 'customize_css_category_settings'],
        ]
];