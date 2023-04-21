<?php

use App\Models\Contact;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Notifications\EmailUser;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $users = Contact::all();

    return view('index')->with('users', $users);
});

Route::get('/message/{id}', function ($id) {

    if (Contact::where('id', $id)->exists()) {
        $user = Contact::find($id);
        return view('message', ['user' => $user]);
    };

});

Route::get('/edit/{id}', function ($id) {

    if (Contact::where('id', $id)->exists()) {
        
        $user = Contact::find($id);

        $user['phone'] = str_replace("-", "", $user->phone);

        return view('profile', ['user' => $user]);
    };

});

Route::post('/message/{id}', function (Request $request, $id) {
    
    $validated = $request->validate([
        'message' => 'required'
    ]);

    if (Contact::where('id', $id)->exists()) {
        $user = Contact::find($id);
        $user->notify(new EmailUser($validated['message']));
        return redirect('/')->with('message', 'success');
    };

});

Route::post('/create', function (Request $request) {
    
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:contacts,email',
        'phone' => 'required|numeric|digits_between:8,11|unique:contacts,phone'
    ]);

    $validated['phone'] = substr_replace(substr_replace($validated['phone'], '-', 3, 0), '-', 7, 0);

    Contact::create($validated);

    return redirect('/')->with('message', 'created');
    
});

Route::post('edit/{id}', function (Request $request, $id) {
    
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:contacts,email,'.$id,
        'phone' => 'required|numeric|digits_between:8,11|unique:contacts,phone,'.$id
    ]);

    $validated['phone'] = substr_replace(substr_replace($validated['phone'], '-', 3, 0), '-', 7, 0);

    if (Contact::where('id', $id)->exists()) {
        $user = Contact::find($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->save();

        return redirect('/')->with('message', 'updated');

    };

    abort(404);
    
});

Route::delete('/delete/{id}', function ($id) {
    
    if (Contact::where('id', $id)->exists()) {
        $user = Contact::find($id);
        $user->delete();

        return redirect('/')->with('message', 'deleted');

    };

    abort(404);
});