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
require(['intranet/init'], function(m){

    return m.init();
});
