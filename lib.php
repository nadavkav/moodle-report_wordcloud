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
 * Libraries of the wordcloud report.
 *
 * @package    report_wordcloud
 * @copyright  2016 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * This function extends the module navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $cm
 */
function report_wordcloud_extend_navigation_module($navigation, $cm) {
    if ($cm->modname == 'forum' && has_capability('report/wordcloud:view', context_course::instance($cm->course))) {
        $url = new moodle_url('/report/wordcloud/index.php', array('courseid' => $cm->course, 'forumid' => $cm->instance));
        $navigation->add(get_string('pluginname', 'report_wordcloud'), $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param stdClass $course The course to object for the report
 * @param stdClass $context The context of the course
 */
function report_wordcloud_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('report/wordcloud:view', $context)) {
        $url = new moodle_url('/report/wordcloud/index.php', array('courseid'=>$course->id));
        $navigation->add(get_string('pluginname', 'report_wordcloud'), $url, navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));
    }
}

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param context $coursecategorycontext The context of the course category
 */
function report_wordcloud_extend_navigation_category($navigation, $coursecategorycontext) {
    if (!has_capability('report/wordcloud:view', $coursecategorycontext)) {
        return;
    }
    $url = new moodle_url('/report/wordcloud/index.php', array('pagecontextid' => $coursecategorycontext->id));
    $name = get_string('pluginname', 'report_wordcloud');
    $settingsnode = navigation_node::create($name,
                                            $url,
                                            navigation_node::TYPE_SETTING,
                                            null,
                                            null,
                                            new pix_icon('i/report', ''));
    if (isset($settingsnode)) {
        $navigation->add_node($settingsnode);
    }
}
