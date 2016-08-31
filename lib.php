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
 * Libraries of the test report.
 *
 * @package    report_test
 * @copyright  2016 Jean-Philippe Gaudreau <jp.gaudreau@umontreal.ca>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * This function extends the navigation with the report items
 *
 * @param navigation_node $navigation The navigation node to extend
 * @param context $coursecategorycontext The context of the course category
 */
function report_test_extend_navigation_category($navigation, $coursecategorycontext) {
    if (!has_capability('report/test:view', $coursecategorycontext)) {
        return;
    }
    $url = new moodle_url('/report/test/index.php', array('pagecontextid' => $coursecategorycontext->id));
    $name = get_string('pluginname', 'report_test');
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
