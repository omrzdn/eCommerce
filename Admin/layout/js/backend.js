$(function(){

   'use strict';

   //Dashborad

   $('.toggle-info').click(function(){

      $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);

      if ($(this).hasClass('selected')){

          $(this).html('<i class="fa fa-minus fa-lg"></i>');

      }else {

          $(this).html('<i class="fa fa-plus fa-lg"></i>');
      }

   });


    //Hide placeholder on From Foucs
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
