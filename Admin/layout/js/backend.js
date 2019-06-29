$(document).ready(function(){
    
   'use strict';
    
    $('[placeholder]').focusin(function(){
        
       
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
        
        
    }).focusout(function (){
        
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    
});