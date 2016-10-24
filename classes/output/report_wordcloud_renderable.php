<?php

namespace report_wordcloud\output;

defined('MOODLE_INTERNAL') || die;

use renderable;

class report_wordcloud_renderable implements renderable {

    /**
     * @var stdClass the course object.
     */
    public $course;

    /**
     * @var stdClass the forum object.
     */
    public $forum;

    /**
     * @var string the forum full raw content.
     */
    private $forumcontent;

    /**
     * Constructor.
     *
     * @param stdClass|int $forum (optional) forum object or id.
     */
    public function __construct($forum = null) {
        global $DB;

        if (!empty($forum)) {
            if (is_int($forum)) {
                //$forum = forum_get_course_forum();
                $forum = $DB->get_record('forum', array('id' => $forum));
            }
            $this->forum = $forum;
        }

        $this->read_forum_posts($this->forum->id);
    }

    /**
     * Read all forum posts in a given forum id.
     *
     * @param $forumid
     */
    private function read_forum_posts($forumid) {
        global $DB;

        $params['forumid'] = $forumid;
        $sql = "SELECT p.id as pid, p.userid as userid ,p.message as message
                FROM {forum_posts} p 
                JOIN {forum_discussions} d ON d.id = p.discussion
                JOIN {forum} f ON f.id = d.forum 
                WHERE f.id = :forumid";
        $results = $DB->get_records_sql($sql, $params);
        $this->forumcontent = '';
        foreach ($results as $post) {
            $this->forumcontent .= $this->better_strip_tags($post->message);
        }
        $this->forumcontent = $this->clean($this->forumcontent);
    }

    private function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^א-תA-Za-z\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
    /**
     * Returns an array of all the unique occurance and count of each word.
     *
     * @return mixed
     */
    public function get_wordcount_array() {
        //$wordcount = array();
        $wordcount_array = explode('-', $this->forumcontent);
        $wordcount = array_count_values($wordcount_array);
        return $wordcount;
    }

    private function better_strip_tags($str, $allowable_tags = '', $strip_attrs = false, $preserve_comments = false, callable $callback = null)
    {
        $allowable_tags = array_map('strtolower', array_filter( // lowercase
            preg_split('/(?:>|^)\\s*(?:<|$)/', $allowable_tags, -1, PREG_SPLIT_NO_EMPTY), // get tag names
            function ($tag) {
                return preg_match('/^[a-z][a-z0-9_]*$/i', $tag);
            } // filter broken
        ));
        $comments_and_stuff = preg_split('/(<!--.*?(?:-->|$))/', $str, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($comments_and_stuff as $i => $comment_or_stuff) {
            if ($i % 2) { // html comment
                if (!($preserve_comments && preg_match('/<!--.*?-->/', $comment_or_stuff))) {
                    $comments_and_stuff[$i] = '';
                }
            } else { // stuff between comments
                $tags_and_text = preg_split("/(<(?:[^>\"']++|\"[^\"]*+(?:\"|$)|'[^']*+(?:'|$))*(?:>|$))/", $comment_or_stuff, -1, PREG_SPLIT_DELIM_CAPTURE);
                foreach ($tags_and_text as $j => $tag_or_text) {
                    $is_broken = false;
                    $is_allowable = true;
                    $result = $tag_or_text;
                    if ($j % 2) { // tag
                        if (preg_match("%^(</?)([a-z][a-z0-9_]*)\\b(?:[^>\"'/]++|/+?|\"[^\"]*\"|'[^']*')*?(/?>)%i", $tag_or_text, $matches)) {
                            $tag = strtolower($matches[2]);
                            if (in_array($tag, $allowable_tags)) {
                                if ($strip_attrs) {
                                    $opening = $matches[1];
                                    $closing = ($opening === '</') ? '>' : $closing;
                                    $result = $opening . $tag . $closing;
                                }
                            } else {
                                $is_allowable = false;
                                $result = '';
                            }
                        } else {
                            $is_broken = true;
                            $result = '';
                        }
                    } else { // text
                        $tag = false;
                    }
                    if (!$is_broken && isset($callback)) {
                        // allow result modification
                        call_user_func_array($callback, array(&$result, $tag_or_text, $tag, $is_allowable));
                    }
                    $tags_and_text[$j] = $result;
                }
                $comments_and_stuff[$i] = implode('', $tags_and_text);
            }
        }
        $str = implode('', $comments_and_stuff);
        return $str;
    }

}