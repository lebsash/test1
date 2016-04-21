require.config({ baseUrl:'/ga/js',
    paths: {
        jquery: ['vendor/jquery.min'],
        bootstrap: ['vendor/bootstrap.min'],
    },
    shim: {
        'bootstrap': {
            deps: ['jquery'],
        }
    },
});
require(['modules/init'], function(m){

    return m.init();
});
