<?php
namespace App;
use Auth;

class customSecurity{

    public static function checkUserIsLoggedIn(){
        if(!Auth::user()){
            return self::returnMessage('panel-warning',
             'Sorry',
             'You must be logged in to view this page',
              1,
              route('login'),
              'Login',
              'btn-danger');
        }
    }

    public static function checkUserIsStaff(){
        $notLoggedIn = self::checkUserIsLoggedIn();
        if($notLoggedIn){
            return $notLoggedIn;
        }

        if(!Auth::user()->staff){
            return self::returnMessage('panel-danger',
             'Slow down!',
             'You must be a member of staff to view this page!!!',
              0,
              '',
              '',
              '');
        }
    }

    public static function returnMessage($panelColour, $heading, $body, $button, $buttonLink, $buttonText, $buttonColour){
        $message = array('panelColour'=>$panelColour,
        'heading'=>$heading,
        'body'=>$body,
        'button'=>$button,
        'buttonLink'=>$buttonLink,
        'buttonText'=>$buttonText,
        'buttonColour'=>$buttonColour);
        return view('message', array('message'=>$message));
    }
}

?>
