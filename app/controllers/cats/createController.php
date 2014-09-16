<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class createController extends BaseController {
    public function showerror(){
        if($message->has('name')){
        foreach ($message->get('name') as $messageone){
        echo $messageone;
     }
    }
    }
}
