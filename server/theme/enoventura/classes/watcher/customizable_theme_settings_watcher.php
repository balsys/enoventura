<?php
/**
 * This file is part of Totara LMS
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author  Johannes Cilliers <johannes.cilliers@totaralearning.com>
 * @package theme_example
 */

namespace theme_enoventura\watcher;

use core\hook\tenant_customizable_theme_settings as tenant_customizable_theme_settings_hook;
use core\hook\theme_settings_css_categories as theme_settings_css_categories_hook;

/**
 * Class to handle customizable theme settings.
 */
final class customizable_theme_settings_watcher {

    /**
     * Handles the tenant_customizable_theme_settings hook call.
     *
     * This method will allow theme settings to be updatable for tenants.
     *
     * @param tenant_customizable_theme_settings_hook $hook
     */
    public static function customize_tenant_category_settings(tenant_customizable_theme_settings_hook $hook) {
        $settings = $hook->get_customizable_settings();

        // Add our example file tab.
        $settings['formenoventura_field_customicons'] = '*';
        $settings['formenoventura_field_mysetting'] = '*';

        $hook->set_customizable_settings($settings);
    }

    /**
     * Handles the tenant_customizable_theme_settings hook call.
     *
     * This method will identify theme setting categories where CSS variables are located.
     *
     * @param theme_settings_css_categories_hook $hook
     */
    public static function customize_css_category_settings(theme_settings_css_categories_hook $hook) {

        // If you have a category that specifies CSS variables that you want to be included in the
        // styles then you can specify your custom category properties here.

        $hook->add_category('category_name', ['property_name' => ['transform' => false]]);
    }

}