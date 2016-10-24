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
 * Renderer class for report wordcloud.
 *
 * @package    report_wordcloud
 * @copyright  2016 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_wordcloud\output;

defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;
use renderable;

/**
 * Renderer class for report wordcloud.
 *
 * @package    report_wordcloud
 * @copyright  2016 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /** @var report_wordcloud_renderable instance of report wordcloud renderable. */
    protected $renderable;

    /**
     * Renderer constructor.
     *
     * @param report_wordcloud_renderable $renderable graphic report renderable instance.
     */
    protected function render_report_wordcloud(report_wordcloud_renderable $renderable) {
        $this->renderable = $renderable;
        $this->report_wordcloud_canvas();
    }

    /**
     * This function is used to generate and display course filter.
     *
     */
    public function report_wordcloud_canvas() {
        //$renderable = $this->renderable;

        echo \html_writer::start_div('canvas-wrapper');
            echo \html_writer::empty_tag('canvas', array('id'=>'wordcloud_canvas', 'width' => '800', 'height'=>'600'));
        echo \html_writer::end_div();
    }

    /**
     * This function is used to generate and display wordcloud options form.
     *
     */
    public function report_selector_form($params = array()) {
        //$renderable = $this->renderable;

        $courseid = required_param('courseid', PARAM_INT);
        $forumid = required_param('forumid', PARAM_INT);
        $minwc = optional_param('minwc', 3, PARAM_INT);
        $maxwc = optional_param('maxwc', 10000, PARAM_INT);

        echo \html_writer::start_tag('form', array('class' => 'form', 'action' => 'index.php', 'method' => 'get'));
            echo \html_writer::label(get_string('minwc', 'report_wordcloud'), 'minwc', false);
            echo \html_writer::empty_tag('input', array('name' => 'minwc', 'type'=>'text', 'value' => $minwc));
            echo \html_writer::label(get_string('maxwc', 'report_wordcloud'), 'maxwc', false);
            echo \html_writer::empty_tag('input', array('name' => 'maxwc', 'type'=>'text', 'value' => $maxwc));

            echo \html_writer::empty_tag('input', array('name' => 'courseid', 'type'=>'hidden', 'value' => $courseid));
            echo \html_writer::empty_tag('input', array('name' => 'forumid', 'type'=>'hidden', 'value' => $forumid));
            echo \html_writer::empty_tag('br');
            echo \html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('regenerate', 'report_wordcloud')));
        echo \html_writer::end_tag('form');
    }
}
