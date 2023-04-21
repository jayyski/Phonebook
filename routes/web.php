<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
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
    $users = User::all();

    return view('index')->with('users', $users);
});

Route::get('/message/{id}', function ($id) {

    if (User::where('id', $id)->exists()) {
        $user = User::find($id);
        return view('message', ['user' => $user]);
    };

});

Route::post('/message/{id}', function (Request $request, $id) {
    
    $validated = $request->validate([
        'message' => 'required'
    ]);

    if (User::where('id', $id)->exists()) {
        $user = User::find($id);
        $user->notify(new EmailUser($validated['message']));
        return redirect('/')->with('message', 'success');
    };

});

Route::post('/create', function (Request $request) {
    
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|numeric|digits_between:8,11|unique:users,phone'
    ]);

    $validated['phone'] = substr_replace(substr_replace($validated['phone'], '-', 3, 0), '-', 7, 0);

    User::create($validated);

    return redirect('/')->with('message', 'created');
    
});

Route::delete('/delete/{id}', function ($id) {
    
    if (User::where('id', $id)->exists()) {
        $user = User::find($id);
        $user->delete();

        return redirect('/')->with('message', 'deleted');

    };

    abort(404);
});