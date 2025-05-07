<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    $products = Product::with('category')->latest()->get();
    $categories = \App\Models\Category::all();
    return view('welcome', compact('products', 'categories'));
});
Route::get('/contact/{sellerId}', function ($sellerId) {
    // If not authenticated, store the redirect and send to login
    if (!Auth::check()) {
        Session::put('redirect_after_login', route('contact.seller', ['sellerId' => $sellerId]));
        return redirect()->route('filament.admin.auth.login');
    }

    // Check if the target user exists and has the 'seller' role
    $seller = User::where('id', $sellerId)->role('seller')->first();

    if (! $seller) {
        abort(404, 'Seller not found');
    }

    // Redirect directly to Chatify with seller ID
    return redirect("/chatify/{$seller->id}");
})->name('contact.seller');