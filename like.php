<?php
require_once('../../config.php');
require_login();

$vote = required_param('vote', PARAM_ALPHA);
$userid = required_param('userid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$pageurl = required_param('pageurl', PARAM_LOCALURL);

require_sesskey();

// echo $OUTPUT->header();
// echo $OUTPUT->heading("You voted: " . s($vote));

// echo html_writer::alist([
//     "User ID: $userid",
//     "Course ID: $courseid",
//     "Page URL: $pageurl"
// ]);

// echo $OUTPUT->footer();


// Check for existing vote
$existing = $DB->get_record('block_likes_votes', ['userid' => $userid, 'pageurl' => $pageurl]);

if (!$existing) {
    $record = new stdClass();
    $record->userid = $userid;
    $record->courseid = $courseid;
    $record->pageurl = $pageurl;
    $record->vote = $vote;
    $record->timecreated = time();
    $DB->insert_record('block_likes_votes', $record);
}

// FIX: Ensure $pageurl is a valid moodle_url
//$redirecturl = new moodle_url($pageurl);
$redirecturl = new moodle_url($CFG->wwwroot . $pageurl);
redirect($redirecturl);