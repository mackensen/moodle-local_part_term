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
 * @package   local_part_term
 * @copyright 2017 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


class local_part_term_part_term_testcase extends advanced_testcase {
    public function test_course_name_extraction() {
        global $CFG;

        require_once($CFG->dirroot . '/local/part_term/locallib.php');

        $this->resetAfterTest(true);

        // Configure the plugin.
        set_config('extractnametitle', '/[A-Z]+\s[0-9]+\.[0-9]+-[A-Za-z]+\s[0-9]{4,}\s(.*)/', 'local_part_term');
        set_config('extractnamedept', '/([A-Z]+)\s[0-9]+\.[0-9]+-[A-Za-z]+\s[0-9]{4,}\s.*/', 'local_part_term');
        set_config('extractnamenum', '/[A-Z]+\s([0-9]+)\.[0-9]+-[A-Za-z]+\s[0-9]{4,}\s.*/', 'local_part_term');
        set_config('extractnameterm', '/[A-Z]+\s[0-9]+\.[0-9]+-([A-Za-z]+\s[0-9]{4,})\s.*/', 'local_part_term');
        set_config('extractnamesection', '/[A-Z]+\s[0-9]+\.([0-9]+)-[A-Za-z]+\s[0-9]{4,}\s.*/', 'local_part_term');
        set_config('extractnametermcode', '/[0-9]+\.([0-9]+)/', 'local_part_term');
        set_config('extractnametermcodetarget', PART_TERM_IDNUMBER, 'local_part_term');

        // Create a test course.
        $c1 = $this->getDataGenerator()->create_course(
            array(
                'fullname' => 'HIST 215.01-Spring 2017 History of Technology',
                'shortname' => 'HIST 215.01-Spring 2017',
                'idnumber' => '30425.201630'
            )
        );

        // Test names.
        $fullnameformat  = '[DEPT] [NUM]-[TERM] [TITLE]';
        $shortnameformat = '[DEPT] [NUM].[SECTION]-[TERM]';
        $idnumberformat  = '[DEPT][NUM].[TERMCODE]';

        // Assertions.
        $fullname = local_part_term_extract_names::get_default_fullname($c1, $fullnameformat);
        $this->assertEquals('HIST 215-Spring 2017 History of Technology', $fullname);
        $shortname = local_part_term_extract_names::get_default_shortname($c1, $shortnameformat);
        $this->assertEquals('HIST 215.01-Spring 2017', $shortname);
        $idnumber = local_part_term_extract_names::get_default_idnumber($c1, $idnumberformat);
        $this->assertEquals('HIST215.201630', $idnumber);
    }
}
