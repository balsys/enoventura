/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('Side drawer AMD initialised');

    $(".side-toggle").on("click", function(e) {
        $("body").toggleClass("side-drawer-open");
    });

});