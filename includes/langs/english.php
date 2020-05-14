<?php 


    function lang($pharse) {
        
        static $lang = array(
        
        'Message' => 'Welcome',
        
        );
        
        return $lang($pharse);
    }