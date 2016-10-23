/**
 * Wordcloud report init wordcloud2js.
 *
 * @package     report_wordcloud
 * @copyright   2016 Nadav Kavalerchik <nadavkav@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* jshint ignore:start */
define(['jquery', 'core/log', 'report_wordcloud/wordcloud2'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('Wordcloud2js AMD');

    return {
        initialise: function(courseid, wordlist) {
            $(document).ready(function($) {
                if ($('#wordcloud_canvas').length) {
                    var wordcloud = $('#wordcloud_canvas');
                    WordCloud(document.getElementById('wordcloud_canvas'), {
                        list: wordlist,
                        drawOutOfBound: false,
                        minSize: 3,
                        shape: 'square',
                        weightFactor: 2
                    });
                    //WordCloud(wordcloud, { list: [['foo', 12], ['bar', 6]] } );
                }
            });
            log.debug('Wordcloud2js AMD init finished');
        }
    }
});
/* jshint ignore:end */
