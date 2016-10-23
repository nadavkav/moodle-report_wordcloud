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
        $renderable = $this->renderable;

        //echo \html_writer::div('', 'wordcloudcanvas', array('id'=>'wordcloudid'));
        //echo \html_writer::start_div('canvas-wrapper', array('style' => 'width:800px;height:600px;'));
        echo \html_writer::start_div('canvas-wrapper');
            //echo \html_writer::start_tag('canvas', array('id'=>'wordcloud_canvas', 'style' => 'width:100%;height:100%;'));
            echo \html_writer::start_tag('canvas', array('id'=>'wordcloud_canvas', 'width' => '800', 'height'=>'600'));
            echo \html_writer::end_tag('canvas');
        echo \html_writer::end_div();
    }
}
