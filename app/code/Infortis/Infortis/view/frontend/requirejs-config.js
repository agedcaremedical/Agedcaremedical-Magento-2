var config = {
    paths: {
        'owlcarousel': 'Infortis_Infortis/js/jquery/jquery.owlcarousel.min',
        'colorbox': 'Infortis_Infortis/js/jquery/jquery.colorbox.min',
        'uaccordion': 'Infortis_Infortis/js/jquery/jquery.uaccordion.min',
        'enquire': 'Infortis_Infortis/js/enquire',
        'magnific': 'Infortis_Infortis/js/jquery/jquery.magnific-popup'
    },
    shim: {
        'colorbox': {
            deps: ['jquery']
        },
        'owlcarousel': {
            'deps': ['jquery']
        },
        'uaccordion': {
            'deps': ['jquery']
        },
        'magnific':{
            'deps': ['jquery']
        }
    }
};
