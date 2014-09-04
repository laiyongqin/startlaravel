<?php
class Breed extends Eloquent {
public $timestamps = false;
public function cat(){
return $this->hasMany('Cat');
}
}
?>