<?php

namespace block_likes\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

class renderer extends plugin_renderer_base {
    public function render_hello_message(): string {
        global $DB, $USER, $COURSE, $PAGE;

        $pageurl = $PAGE->url->out();
        // Count votes for this page
        $likes = $DB->count_records('block_likes_votes', ['pageurl' => $pageurl, 'vote' => 'like']);
        $dislikes = $DB->count_records('block_likes_votes', ['pageurl' => $pageurl, 'vote' => 'dislike']);

        $data = [
            'likeurl' => new \moodle_url('/blocks/likes/like.php'),
            'userid' => $USER->id,
            'courseid' => $COURSE->id ?? 1,
            'pageurl' => $pageurl,
            'sesskey' => sesskey(),
             'likecount' => $likes,
            'dislikecount' => $dislikes
        ];
        return $this->render_from_template('block_likes/hello_message', $data);
    }
}
