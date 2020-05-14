$(function(){

   'use strict';

   //Switch between Login & Signup


   $('.login-page h1 span').click(function() {

      $(this).addClass('selected').siblings().removeClass('selected');
      $('.login-page form').hide();

      $('.' + $(this).attr('data-class')).fadeIn(100);
   });


   //Hide placeholder on From Foucs
   $('[placeholder]').focusin(function(){


       $(this).attr('data-text', $(this).attr('placeholder'));
       $(this).attr('placeholder', '');


   }).focusout(function (){

       $(this).attr('placeholder', $(this).attr('data-text'));
   });


});
