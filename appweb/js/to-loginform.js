//$(document).load(function() {   
    var config = {        
        form : '#to_loginform',    
        validate : {
            'username' : {
                'validation' : 'required, alphanumeric',
                'length' : '4-20',                
                'allowing' : '-_.#!&',                
            },
            'passuser' :{
                'validation' : 'required, alphanumeric',
                'length' : '4-20',
                'allowing' : '-_.#!&',                
            }
        }
    };

    $.validate({
        modules : 'jsconf, toggleDisabled, security',
        lang : 'es',
        showErrorDialogs : false,
        disabledFormFilter : '#to_loginform',
        onModulesLoaded : function() {
            $.setupValidation(config);
        }
    });
//});

