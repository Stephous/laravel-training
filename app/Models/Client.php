<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Invoice;

class Client extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'address'];
    protected $table = 'clients';
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
