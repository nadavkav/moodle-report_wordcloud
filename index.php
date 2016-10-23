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
 * WordCloud report page.
 *
 * @package    report_wordcloud
 * @copyright  2016 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

//$pagecontextid = optional_param('pagecontextid', PARAM_INT);
//$context = context::instance_by_id($pagecontextid);

$courseid = required_param('courseid', PARAM_INT);
$forumid = required_param('forumid', PARAM_INT);
$context = context_course::instance($courseid);

require_login();
//$urlparams = array('pagecontextid' => $pagecontextid);
$urlparams = array('courseid' => $courseid, 'forumid' => $forumid);

$url = new moodle_url('/report/wordcloud/index.php', $urlparams);
$title = get_string('pluginname', 'report_wordcloud');

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading('Wordcloud report');
$PAGE->set_pagelayout('admin');

$renderable = new \report_wordcloud\output\report_wordcloud_renderable($forumid);
$wordcount_array = $renderable->get_wordcount_array();
foreach ($wordcount_array as $key_word => $count) {
    if ($count > 3) {
        $wordcount_arrayofarrays[] = array($key_word , $count);
    }
}
$output = $PAGE->get_renderer('report_wordcloud');
//$params = array('courseid' => $courseid , 'wordlist' => array(array('foo',12), array('bar',6), array('fooz',12), array('barz', 6)));
$params = array('courseid' => $courseid , 'wordlist' => $wordcount_arrayofarrays);
$PAGE->requires->js_call_amd('report_wordcloud/init', 'initialise', $params);

echo $output->header();
echo $output->heading($title);
echo $output->render($renderable);
echo $output->footer();
