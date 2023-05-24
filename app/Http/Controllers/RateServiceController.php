<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RateService;

class RateServiceController extends Controller
{
    $rate = $this->rateService->getRateFromCurrency('EUR');
}
