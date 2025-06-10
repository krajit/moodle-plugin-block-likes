<?php

namespace block_likes\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

class renderer extends plugin_renderer_base {
    public function render_hello_message(): string {
        global $DB, $USER, $COURSE, $PAGE;

        //$pageurl = $PAGE->url->out();

        $pageurl = $PAGE->url->get_path(true);  // true = leading slash
        if ($PAGE->url->get_query_string()) {
            $pageurl .= '?' . $PAGE->url->get_query_string();
        }


        // Count votes for this page
        $likecount = $DB->count_records('block_likes_votes', ['pageurl' => $pageurl, 'vote' => 'like']);
        $dislikecount = $DB->count_records('block_likes_votes', ['pageurl' => $pageurl, 'vote' => 'dislike']);

        $userlikes = $DB->get_records('block_likes_votes', ['vote' => 'like', 'userid'=>$USER->id]);

        $data = [
            'likeurl' => new \moodle_url('/blocks/likes/like.php'),
            'userid' => $USER->id,
            'courseid' => $COURSE->id ?? 1,
            'pageurl' => $pageurl,
            'sesskey' => sesskey(),
             'likecount' => $likecount,
            'dislikecount' => $dislikecount,
            'userlikes' => array_values($userlikes),
        ];
        return $this->render_from_template('block_likes/hello_message', $data);
    }
}
