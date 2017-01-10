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
 * Helper functions for name processing. From local_course_merge.
 *
 * @package   local_part_term
 * @copyright 2016 Lafayette College ITS
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/part_term/locallib.php');

class local_part_term_extract_names {

    public static function get_default_fullname($course, $fullname) {
        return self::replace_tokens($fullname, $course);
    }

    public static function get_default_idnumber($course, $idnumber) {
        return self::replace_tokens($idnumber, $course);
    }

    public static function get_default_shortname($course, $shortname) {
        return self::replace_tokens($shortname, $course);
    }

    public static function post_process($data, $courseids) {
        global $DB;

        $fields = array('fullname', 'shortname', 'idnumber');
        $courses = $DB->get_records_list('course', 'id', $courseids, '', 'fullname');
        $sections = array();
        foreach ($courses as $course) {
            $sections[] = ltrim(self::replace_token('[SECTION]', $course), '0');
        }
        sort($sections);
        $sectionlist = implode('', $sections);
        foreach ($fields as $field) {
            $data->{$field} = str_replace('[SECTIONS]', $sectionlist, $data->{$field});
        }
        return $data;
    }

    private static function replace_tokens($pattern, $course) {
        preg_match_all('(\[[A-Z]+\])', $pattern, $matches);
        foreach ($matches[0] as $match) {
            $pattern = str_replace($match, self::replace_token($match, $course), $pattern);
        }
        return $pattern;
    }

    private static function replace_token($key, $course) {
        switch($key) {
            case '[DEPT]':
                $pattern = get_config('local_part_term', 'extractnamedept');
                $source  = get_config('local_part_term', 'extractnamedepttarget');
                break;
            case '[NUM]':
                $pattern = get_config('local_part_term', 'extractnamenum');
                $source  = get_config('local_part_term', 'extractnamenumtarget');
                break;
            case '[SECTION]':
                $pattern = get_config('local_part_term', 'extractnamesection');
                $source  = get_config('local_part_term', 'extractnamesectiontarget');
                break;
            case '[SECTIONS]':
                return $key;
                break;
            case '[TERM]':
                $pattern = get_config('local_part_term', 'extractnameterm');
                $source  = get_config('local_part_term', 'extractnametermtarget');
                break;
            case '[TERMCODE]':
                $pattern = get_config('local_part_term', 'extractnametermcode');
                $source  = get_config('local_part_term', 'extractnametermcodetarget');
                break;
            case '[TITLE]':
                $pattern = get_config('local_part_term', 'extractnametitle');
                $source  = get_config('local_part_term', 'extractnametitletarget');
                break;
            default:
                return '';
                break;
        }

        // Identify source.
        switch($source) {
            case PART_TERM_FULLNAME:
                $subject = $course->fullname;
                break;
            case PART_TERM_SHORTNAME:
                $subject = $course->shortname;
                break;
            case PART_TERM_IDNUMBER:
                $subject = $course->idnumber;
                break;
        }

        preg_match($pattern, $subject, $matches);
        if (!empty($matches) && count($matches) >= 2) {
            return $matches[1];
        } else {
            return '';
        }
    }
}
