<?php

use App\Http\Controllers\ResPub;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
Route::get('hau_ep/research-and-publications/resubmit/{id}',[ResPub::class,  'loadResubmit'])->name('portal.respub.resubmit'); 
Route::post('hau_ep/research-and-publications/submit/{id}',[ResPub::class, 'resubmit'])-> name('portal.respub.resub'); 

}); 
?> 