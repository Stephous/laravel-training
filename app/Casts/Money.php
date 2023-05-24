<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Money as MoneyHelper;
use InvalidArgumentException;

class Money implements CastsAttributes
{

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $value_json = json_decode($value, true);
        return new MoneyHelper($value_json['currency'], $value_json['price'], $value_json['currency_rate']);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof MoneyHelper) {
            throw new InvalidArgumentException('La valeur doit être une instance de Money.');
        }
        return json_encode($value->toArray());
    }
}
