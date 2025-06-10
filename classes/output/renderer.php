<?php

namespace block_likes\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

class renderer extends plugin_renderer_base {
    public function render_hello_message(): string {
        global $USER, $COURSE, $PAGE;

        $data = [
            'likeurl' => new \moodle_url('/blocks/likes/like.php'),
            'userid' => $USER->id,
            'courseid' => $COURSE->id ?? 1,
            'pageurl' => $PAGE->url->out(),
            'sesskey' => sesskey()
        ];
        return $this->render_from_template('block_likes/hello_message', $data);
    }
}
