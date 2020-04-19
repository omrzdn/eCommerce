$(document).ready(function(){

   'use strict';
    $('[placeholder]').focusin(function(){


        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');


    }).focusout(function (){

        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // convert Password field to text field on hover

    var passField = $('.password');

    $('.show-pass').hover(function(){

      passField.attr('type', 'text');

    },function () {

      passField.attr('type', 'password');

    });

    $('.hellozidan').hover(function() {


    });

    //confirm delete member

    $('.confirm').click(function(){

      return confirm('Are You Sure ?')
    });

});
