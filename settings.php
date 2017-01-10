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
 * Local course merge settings definitions.
 *
 * @package   local_part_term
 * @copyright 2016 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/part_term/locallib.php');

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_part_term', get_string('pluginname', 'local_part_term'));
    $ADMIN->add('localplugins', $settings);

    $selectors = array(
        PART_TERM_FULLNAME => get_string('fullname'),
        PART_TERM_SHORTNAME => get_string('shortname'),
        PART_TERM_IDNUMBER => get_string('idnumber'),
    );

    $settings->add(new admin_setting_configtext('local_part_term/extractnametitle',
        new lang_string('extractnametitle', 'local_part_term'),
        new lang_string('extractnametitle_desc', 'local_part_term'), '', PARAM_NOTAGS));

    $settings->add(new admin_setting_configselect(
        'local_part_term/extractnametitletarget',
        new lang_string('extractnametitletarget', 'local_part_term'),
        new lang_string('extractnametitletarget_desc', 'local_part_term'),
        PART_TERM_FULLNAME,
        $selectors
    ));

    $settings->add(new admin_setting_configtext('local_part_term/extractnamedept',
        new lang_string('extractnamedept', 'local_part_term'),
        new lang_string('extractnamedept_desc', 'local_part_term'), '', PARAM_NOTAGS));

    $settings->add(new admin_setting_configselect(
        'local_part_term/extractnamedepttarget',
        new lang_string('extractnamedepttarget', 'local_part_term'),
        new lang_string('extractnamedepttarget_desc', 'local_part_term'),
        PART_TERM_FULLNAME,
        $selectors
    ));

    $settings->add(new admin_setting_configtext('local_part_term/extractnamenum',
        new lang_string('extractnamenum', 'local_part_term'),
        new lang_string('extractnamenum_desc', 'local_part_term'), '', PARAM_NOTAGS));

    $settings->add(new admin_setting_configselect(
        'local_part_term/extractnamenumtarget',
        new lang_string('extractnamenumtarget', 'local_part_term'),
        new lang_string('extractnamenumtarget_desc', 'local_part_term'),
        PART_TERM_FULLNAME,
        $selectors
    ));

    $settings->add(new admin_setting_configtext('local_part_term/extractnameterm',
        new lang_string('extractnameterm', 'local_part_term'),
        new lang_string('extractnameterm_desc', 'local_part_term'), '', PARAM_NOTAGS));

    $settings->add(new admin_setting_configselect(
        'local_part_term/extractnametermtarget',
        new lang_string('extractnametermtarget', 'local_part_term'),
        new lang_string('extractnametermtarget_desc', 'local_part_term'),
        PART_TERM_FULLNAME,
        $selectors
    ));

    $settings->add(new admin_setting_configtext('local_part_term/extractnamesection',
        new lang_string('extractnamesection', 'local_part_term'),
        new lang_string('extractnamesection_desc', 'local_part_term'), '', PARAM_NOTAGS));

    $settings->add(new admin_setting_configselect(
        'local_part_term/extractnamesectiontarget',
        new lang_string('extractnamesectiontarget', 'local_part_term'),
        new lang_string('extractnamesectiontarget_desc', 'local_part_term'),
        PART_TERM_FULLNAME,
        $selectors
    ));

    $settings->add(new admin_setting_configtext('local_part_term/extracttermcode',
        new lang_string('extracttermcode', 'local_part_term'),
        new lang_string('extracttermcode_desc', 'local_part_term'), '', PARAM_NOTAGS));

    $settings->add(new admin_setting_configselect(
        'local_part_term/extractnametermcodetarget',
        new lang_string('extractnametermcodetarget', 'local_part_term'),
        new lang_string('extractnametermcodetarget_desc', 'local_part_term'),
        PART_TERM_IDNUMBER,
        $selectors
    ));
}
