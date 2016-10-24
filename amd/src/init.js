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
                        gridSize: Math.round(16 * $('#wordcloud_canvas').width() / 800),
                        weightFactor: function (size) {
                            return Math.pow(size, 2.3) * $('#wordcloud_canvas').width() / 800;
                        },
                        fontFamily: 'Alef, serif',
                        //minSize: 3,
                        //shape: 'square',
                        //rotateRatio: 0.5,
                        //weightFactor: 2
                    });
                }
            });
            log.debug('Wordcloud2js AMD init finished');
        }
    }
});
/* jshint ignore:end */
