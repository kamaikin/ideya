var sourcePath = "/public/base/";

function hasClass(elem, className) {
    return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
}

if (head.browser.ie && head.browser.version < 9) {
    location.replace(sourcePath+"ie7/ie7.html");
}

head.js(
    sourcePath+"js/jquery.min.js",
    sourcePath+"js/jquery.actual.min.js",
    sourcePath+"js/tip.js",
    sourcePath+"js/modal.min.js",
    sourcePath+"js/lightbox.min.js",
    sourcePath+"js/scripts.js",
    function() {
        $('.tip-js').tooltip({
            side: "top"
        });
        $('.sponsors-tip-js').tooltip({
            side: "bottom"
        });
        /*modal*/
        $('.popup-link-js').modal({
            center: false,
            pos: 117
        });
    }
);

if (head.browser.ie && head.browser.version < 10 || head.browser.opera) {
    head.js( sourcePath+"js/placeholder.js" );
}

// if (hasClass(document.documentElement, 'body_class')) {
//     head.js(
//         sourcePath+"js/.js",
//         function() {}
//     );
// }
