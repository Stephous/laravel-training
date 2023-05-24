<?php

namespace App\Helpers;

use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Support\Arrayable;

class Money implements Arrayable
{
    private readonly float $currency_rate;

    public function __construct(
        private readonly string $currency,
        private readonly float $price,
        float $currency_rate = null,
    )
    {
        if (! $this->currencyExists($currency)) {
            throw new InvalidArgumentException('The currency doesn\'t exist');
        }

        $this->currency_rate = $currency_rate ?? $this->getCurrencyRate($this->currency);
    }

    private static function currencyExists($currency)
    {
        return str($currency)->length() === 3;
    }

    /*private static function getCurrencyRate($currency)
    {
        return crc32($currency) / 10_000_000_000;
    }*/
    private static function getCurrencyRate($currency)
    {
        return app(RateService::class)->getRateFromCurrency($currency);
    }

    public static function fromEuros(float $price)
    {
        return new self('EUR', $price);
    }

    public function toArray()
    {
        return [
            'price' => $this->price,
            'currency' => $this->currency,
            'currency_rate' => $this->currency_rate,
        ];
    }
}
