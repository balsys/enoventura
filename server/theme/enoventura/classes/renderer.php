<?php

defined('MOODLE_INTERNAL' || die());

use theme_enoventura\output\masthead_menu;


class theme_enoventura_renderer extends theme_legacy_renderer {

    public function render_side_drawer() {

        $mastheaddata = new stdClass();

        $mastheadlogo = new totara_core\output\masthead_logo();
        $mastheaddata->masthead_logo = $mastheadlogo->export_for_template($this->output);

        $menudata = totara_build_menu();
        $mastheadmenu = new masthead_menu($menudata);

        $mastheaddata->masthead_menu = $mastheadmenu->export_for_template($this->output);
        $mastheaddata->masthead_toggle = $this->output->navbar_button();

        return $this->render_from_template("theme_enoventura/side_drawer", $mastheaddata);

    }

    public function render_site_header(bool $hasguestlangmenu = true) {

        global $USER;

        $mastheaddata = new stdClass();
        $mastheaddata->masthead_lang = $hasguestlangmenu && (!isloggedin() || isguestuser()) ? $this->output->lang_menu() : '';
        $mastheaddata->masthead_plugins = $this->output->navbar_plugin_output();
        $mastheaddata->masthead_search = $this->output->search_box();
        $mastheaddata->masthead_usermenu = $this->output->user_menu();

        if (totara_core\quickaccessmenu\factory::can_current_user_have_quickaccessmenu()) {
            $menuinstance = totara_core\quickaccessmenu\factory::instance($USER->id);

            if (!empty($menuinstance->get_possible_items())) {
                $adminmenu = $menuinstance->get_menu();
                $quickaccessmenu = totara_core\output\quickaccessmenu::create_from_menu($adminmenu);
                $mastheaddata->masthead_quickaccessmenu = $quickaccessmenu->get_template_data();
            }
        }

        return $this->render_from_template('theme_enoventura/site_header', $mastheaddata);

    }

    /**
     * Render the masthead.
     *
     * @return string the html output
     */
    public function masthead(bool $hasguestlangmenu = true, bool $nocustommenu = false) {
        global $USER;

        $mastheadmenudata = new stdClass;

        $mastheadlogo = new totara_core\output\masthead_logo();

        $mastheaddata = new stdClass();
        $mastheaddata->masthead_lang = $hasguestlangmenu && (!isloggedin() || isguestuser()) ? $this->output->lang_menu() : '';
        $mastheaddata->masthead_logo = $mastheadlogo->export_for_template($this->output);
        $mastheaddata->masthead_menu = $mastheadmenudata;
        $mastheaddata->masthead_plugins = $this->output->navbar_plugin_output();
        $mastheaddata->masthead_search = $this->output->search_box();
        // Even if we don't have a "navbar" we need this option, due to the poor design of the nonavbar option in the past.
        $mastheaddata->masthead_toggle = $this->output->navbar_button();
        $mastheaddata->masthead_usermenu = $this->output->user_menu();

        if (totara_core\quickaccessmenu\factory::can_current_user_have_quickaccessmenu()) {
            $menuinstance = totara_core\quickaccessmenu\factory::instance($USER->id);

            if (!empty($menuinstance->get_possible_items())) {
                $adminmenu = $menuinstance->get_menu();
                $quickaccessmenu = totara_core\output\quickaccessmenu::create_from_menu($adminmenu);
                $mastheaddata->masthead_quickaccessmenu = $quickaccessmenu->get_template_data();
            }
        }

        return $this->render_from_template('totara_core/masthead', $mastheaddata);
    }


}