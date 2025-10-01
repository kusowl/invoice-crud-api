<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function () {
    $credentilas['email'] = env('SETUP_USER_EMAIL');
    $credentilas['password'] = env('SETUP_USER_PASSWORD');

    // If user is not found then create it, else generate token based on the user
    if (! Auth::attempt($credentilas)) {
        $user = new User();
        $user->name = env('SETUP_USER_NAME');
        $user->email = $credentilas['email'];
        $user->password = $credentilas['password'];
        $user->save();
    }

    if (Auth::attempt($credentilas)) {
        $user = Auth::user();

        return [
            'Level-3' => $user->createToken('admin-token', ['create', 'update', 'delete'])->plainTextToken,
            'Level-2' => $user->createToken('update-token', ['create', 'update'])->plainTextToken,
            'Level-1' => $user->createToken('basic-token', ['none'])->plainTextToken,
        ];
    }
});
