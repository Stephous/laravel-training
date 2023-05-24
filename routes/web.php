<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\TempMiddleWare;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthenticationController;
use App\Models\Invoice;
use App\Models\Tool;
use App\Casts\Money;
use App\Services\RateService;
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
    return view('welcome');
});

Route::get('/request', function (Request $request) {
    return dd($request->getClientIp());
});

Route::post('/request', function (Request $request) {
    return dd($request);
})->name('request');

Route::permanentRedirect('/redirect', '/');

Route::get('/name/{name}', function (string $name) {
    return $name;
});

Route::get('/ressource/{id}', function (int $id) {
    return $id;
})->where('id', '[0-9]+');

Route::get('/test', function () {
    return view('test');
});

Route::get('/ddMiddleWare', function (Request $request) {
    return dd($request);
})->middleware(TempMiddleWare::class);

Route::resource('tools', ToolController::class)->only(['index','show']);

Route::get('/invoices/createfifty', function () {
    for ($i=0; $i < 50; $i++) { 
        $invoice = new Invoice();
        $invoice->total_amount = $i*1.20;
        $invoice->amount_before_tax = $i;
        $invoice->client_id = rand(1, 2);
        $invoice->purchase_order_id = $i;
        $invoice->tax = 20.0;
        $invoice->send_at = date_create("now");
        $invoice->acquitted_at = date_create("now");
        $invoice->save();
    }
});

Route::get('/invoices/{order?}', function (Request $request) {
    $order = $request->input('order');
    if($order == "desc" || $order == "asc") {
        $invoices = Invoice::query()->orderBy('total_amount', $order)->paginate(10);
    }else {
        $invoices = Invoice::query()->paginate(10);
    }
    return view('invoices.index', ['invoices' => $invoices]);
});

Route::get('search', function (Request $request) {
    $email = $request->input('email');
    $priceHigherThan = $request->input('price_higher_than');
    $priceLowerThan = $request->input('price_lower_than');
    $invoices = Invoice::when($email, function ($query, $email) {
            return $query->whereEmail($email);
        })
        ->when($priceHigherThan, function ($query, $priceHigherThan) {
            return $query->where('total_amount', '>=', $priceHigherThan);
        })
        ->when($priceLowerThan, function ($query, $priceLowerThan) {
            return $query->where('total_amount', '<=', $priceLowerThan);
        })
        ->get();
    return view('search', ['invoices' => $invoices]);
})->name('search');

Route::get('/toolsedit', function () {
    $tools = \App\Models\Tool::all();

    foreach ($tools as $tool) {
        $tool->update(['price' => json_encode([
            'price' => $tool->price,
            'currency' => 'EUR',
            'currency_rate' => rand(0, 100) / 100,
        ])]);
    }
});
Route::get('/toolshow', function () {
    $tools = Tool::all();
    return $tools;
});

Route::get('/toolsprice', function () {
    $tools = Tool::wherePriceGreaterThan(6)->get();
    return $tools;
});

Route::get('/rateService', function () {
    $rateService = app(RateService::class);
    $currency = 'EUR';
    $rate = $rateService->getRateFromCurrency($currency);
    return "Le taux de change pour $currency est de : $rate";
});

Route::get('/auth/login', [AuthenticationController::class, 'showForm'])->name('login');
Route::post('/auth/login', [AuthenticationController::class, 'login']);
Route::get('/auth/callback', [AuthenticationController::class, 'callback'])->name('authentication.callback');
Route::get('/auth/logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, '__invoke'])->name('home')->middleware(['auth']);

Route::resource('invoices', InvoiceController::class)->except(['edit','update']);
