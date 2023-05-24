<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Invoice;
use App\Casts\Money;

class tool extends Model {
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'price'];
    protected $table = 'tools';
    protected $casts = [
        'price' => Money::class,
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_tool');
    }
    public function scopeWherePriceGreaterThan(Builder $query, $price) {
        return $query->where('price->price', '>', $price);
    }
}
