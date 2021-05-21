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
 * @author Tatsuhiro Kirihara <tatsuhiro.kirihara@totaralearning.com>
 * @package theme_msteams
 */

namespace theme_enoventura\output;

defined('MOODLE_INTERNAL') || die();

/** @global $CFG */
require_once($CFG->dirroot . '/theme/enoventura/locallib.php');

/**
 *
 */
class masthead_menu extends \totara_core\output\masthead_menu {


    public function __construct($menudata, $parent=null) {

        $currentlevel = array();
        foreach ($menudata as $menuitem) {
            if ($menuitem->parent == $parent) {
                $currentlevel[] = $menuitem;
            }
        }

        $numitems = count($currentlevel);

        $count = 0;
        if ($numitems > 0) {
            // Create Structure.
            foreach ($currentlevel as $menuitem) {
                $class_isfirst = ($count == 0 ? true : false);
                $class_islast  = ($count == $numitems - 1 ? true : false);

                $children = new self($menudata, $menuitem->name);
                $haschildren = ($children->has_children() ? true : false);
                $externallink = ($menuitem->target == '_blank' ? true : false);
                $url = new \moodle_url($menuitem->url);
                $this->menuitems[] = array(
                        'class_name' => $menuitem->name,
                        'class_isfirst' => $class_isfirst,
                        'class_islast' => $class_islast,
                        'class_isselected' => $menuitem->is_selected,
                        'external_link' => $externallink,
                        'linktext' => $menuitem->linktext,
                        'url' => $url->out(false),
                        'target' => $menuitem->target,
                        'icon' => $this->get_icon_for_label($menuitem->linktext),
                        'haschildren' => $haschildren,
                        'children' => $children->get_items()
                );
                $count++;
            }
        }
    }

    /**
     * Has this menu item got children
     *
     * @return bool Returns true if the item has children
     */
    private function has_children() {
        return !empty($this->menuitems);
    }

    /**
     * Returns the menu item for this level of menu
     *
     * @return array Array of menu items
     *
     */
    private function get_items() {
        return $this->menuitems;
    }

    /**
     * Returns corresponding icons class for given label
     * @param string $label
     * @return string
     */
    public function get_icon_for_label($label) {
        $retval = 'fa fa-sun-o'; // default

        $settings = theme_enoventura_get_settings();
        $formenoventura_field_customicons = $settings->get_property('enoventura', 'formenoventura_field_customicons');
        if (!empty ($formenoventura_field_customicons['value'])) {
            $customicons = explode("\n", $formenoventura_field_customicons['value']);
            foreach ($customicons as $customicon) {
                $icon = explode('|', $customicon);
                if ($label == trim($icon[0])) {
                    $retval = $icon[1];
                }
            }
        }

        return $retval;
    }

}