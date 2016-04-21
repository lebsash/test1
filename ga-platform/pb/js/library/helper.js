define(['jquery'],function($){

    'use strict';

    var h = {
        platformUrl: '/ga',
        pageElement: $('.page-content:first'),
        _redirect: function (a) {
            document.location.href = a
        },
    }

    return h;
});
