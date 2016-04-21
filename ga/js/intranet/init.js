define(['library/helper', 'bootstrap'], function(h,b){

    'use strict';

    return {
        init: function(){
            require(['intranet/events'], function(m){});
        }
    }
});
