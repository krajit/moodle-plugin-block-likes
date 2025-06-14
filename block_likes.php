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
 * The likes block
 *
 * @package    block_likes
 * @copyright 2009 Dongsheng Cai <dongsheng@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 use block_likes\output;

class block_likes extends block_base {

    function init() {
        global $CFG;

        require_once($CFG->dirroot . '/comment/lib.php');

        $this->title = get_string('pluginname', 'block_likes');
    }

    function specialization() {
        // require js for commenting
        comment::init();
    }
    function applicable_formats() {
        return array('all' => true);
    }

    function instance_allow_multiple() {
        return false;
    }

    function get_content() {
        global $CFG;
        $output = $this->page->get_renderer('block_likes');
        $html = $output->render_hello_message();



        if ($this->content !== NULL) {
            return $this->content;
        }
        $CFG->uselikes = true; // TODO: clean to automatically set this
        if (!$CFG->uselikes) {
            $this->content = new stdClass();
            $this->content->text = 'Hello';
            if ($this->page->user_is_editing()) {
                $this->content->text = 'Soeething worng'; //get_string('disabledlikes');
            }
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->footer = '';
        $this->content->text = '';
        if (empty($this->instance)) {
            return $this->content;
        }
        list($context, $course, $cm) = get_context_info_array($this->page->context->id);

        $args = new stdClass;
        $args->context   = $this->page->context;
        $args->course    = $course;
        $args->area      = 'page_likes';
        $args->itemid    = 0;
        $args->component = 'block_likes';
        $args->linktext  = get_string('showlikes');
        $args->notoggle  = true;
        $args->autostart = true;
        $args->displaycancel = false;
        $comment = new comment($args);
        $comment->set_view_permission(true);
        $comment->set_fullwidth();

        $this->content = new stdClass();
//        $this->content->text = $comment->output(true);
//        $this->content->text ='<div style="color:green !important;font-weight:bold;padding:1em;">Hello blocks!</div>';
        $this->content->text = $html;
        $this->content->footer = '';
        return $this->content;
    }

    /**
     * This block shouldn't be added to a page if the likes advanced feature is disabled.
     *
     * @param moodle_page $page
     * @return bool
     */
    public function can_block_be_added(moodle_page $page): bool {
        global $CFG;

        return true; //$CFG->uselikes; // TODO: clean this. I don't know what is the proper way
    }
}
