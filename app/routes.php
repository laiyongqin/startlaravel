<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//Route::get('/', function()
//{
//	return View::make('hello');
//});

Route::get('/', function() {
    return Redirect::to("cats");
});
// Route::get('cats/{id}', function($id){
//			return "Cat #$id";
// })->where('id', '[0-9]+');

Route::get('about', function() {
    return View::make('about')->with('number_of_cats', 9000);
});

Route::get('cats', function() {
    $cats = Cat::all();
    return View::make('cats.index')
                    ->with('cats', $cats);
});
Route::get('cats/breeds/{name}', function($name) {
//   echo $name;
    $breed = Breed::whereName($name)->with('cat')->first();
//$juti=$breed->cat->items;
// dd($juti[0]->fillable());
//dd($breed->cat);
    return View::make('cats.index')
                    ->with('breed', $breed)
                    ->with('cats', $breed->cat);
});
Route::model('cat', 'Cat');

Route::get('cats/{cat}', function(Cat $cat) {
//$cat = Cat::find($id);
    return View::make('cats.single')
                    ->with('cat', $cat);
})->where('cat', '[0-9]+');

Route::group(array('before'=>'auth'), function(){
Route::get('cats/create', function() {
    $zongprint="";
if(Session::has('message')){
    $messageobj=Session::get('message');
    $message=$messageobj->getMessages();
//dd($message);
 
foreach ($message as $key => $messageone){
//echo $key;
//echo "  : ";
    
  foreach ($messageone as $messageonevalue)
  {   $printstring="<script type=".'"'."text/javascript".'"'.">var userobj=document.getElementById(".'"'.$key.'"'.");userobj.innerHTML="."'".$messageonevalue."'".";</script>";
      $zongprint=$zongprint.$printstring;
  // dd($printstring);  
    //echo $printstring;
      //echo $messageonevalue;
  }
echo "<br>";

}

}
    $cat = new Cat;
    return View::make('cats.edit')
                    ->with('cat', $cat)
                    ->with('method', 'post')
                    ->with('jsprinterror',$zongprint);
});

Route::get('cats/{cat}/edit', function(Cat $cat) {
//$cat=Cat::find($id);
    return View::make('cats.edit')
                    ->with('cat', $cat)
                    ->with('method', 'put');
});
Route::get('cats/{cat}/delete', function(Cat $cat) {
//$cat=Cat::find($id);
    return View::make('cats.edit')
                    ->with('cat', $cat)
                    ->with('method', 'delete');
});
});
//Route::post('cats', function(){
//$cat = Cat::create(Input::all());
//return Redirect::to('cats/' . $cat->id)
//->with('message', 'Successfully created page!');
//});
Route::post('cats', function() {
    
    $rules = array(
        'name' => 'required|min:3', // Required, > 3 characters
        'date_of_birth' => array('required', 'date') // Must be a date
    );
    $formresult=Input::all();
    
    $validation_result = Validator::make($formresult,$rules);
    
    if($validation_result->fails()){
        return Redirect::back()->with('message', $validation_result->messages());
        //$message = $validation_result->messages();
        //return Redirect::back()->with('message',$message);
    }else{
    
    $cat = Cat::create($formresult);
    $cat->user_id = Auth::user()->id;
    if ($cat->save()) {
        return Redirect::to('cats/' . $cat->id)
                        ->with('message', 'Successfully created profile!');
    } else {
        return Redirect::back()
                        ->with('error', 'Could not create profile');
    }
    }
});
//Route::put('cats/{cat}', function(Cat $cat) {
//$cat->update(Input::all());
//return Redirect::to('cats/' . $cat->id)
//->with('message', 'Successfully updated page!');
//});

Route::put('cats/{cat}', function(Cat $cat) {
    if (Auth::user()->canEdit($cat)) {
        $cat->update(Input::all());
        return Redirect::to('cats/' . $cat->id)
                        ->with('message', 'Successfully updated profile!');
    } else {
        return Redirect::to('cats/' . $cat->id)
                        ->with('error', "Unauthorized operation");
    }
});
Route::delete('cats/{cat}', function(Cat $cat) {
    $cat->delete();
    return Redirect::to('cats')
                    ->with('message', 'Successfully deleted page!');
});


View::composer('cats.edit', function($view) {
    $breeds = Breed::all();
    if (count($breeds) > 0) {
        $breed_options = array_combine($breeds->lists('id'), $breeds->lists('name'));
    } else {
        $breed_options = array(null, 'Unspecified');
    }
    $view->with('breed_options', $breed_options);
});


Route::get('login', function() {
    return View::make('login');
});


Route::post('login', function() {
    if (Auth::attempt(Input::only('username', 'password'))) {
        return Redirect::intended('/');
    } else {
        return Redirect::back()
                        ->withInput()
                        ->with('error', "Invalid credentials");
    }
});

Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/')
                    ->with('message', 'You are now logged out');
});

