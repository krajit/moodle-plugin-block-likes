<?php

namespace block_likes\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

class renderer extends plugin_renderer_base {
    public function render_hello_message(): string {
        $data = [
            'message' => get_string('hellomessage', 'block_likes')
        ];
        return $this->render_from_template('block_likes/hello_message', $data);
    }
}
