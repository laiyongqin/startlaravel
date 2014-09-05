<?php
/**
 * Breed
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cat[] $cat
 */
/**
 * Breed
 *
 */
class Breed extends Eloquent {
public $timestamps = false;
public function cat(){
return $this->hasMany('Cat');
}
}
?>