<?php

use App\Livewire\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get("/register", Register::class)->name("livewire.register");