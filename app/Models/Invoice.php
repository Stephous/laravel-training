<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Client;

class Invoice extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['client_id','purchase_order_id', 'total_amount', 'amount_before_tax', 'tax', 'send_at', 'acquitted_at'];
    protected $table = 'invoices';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'invoice_tool');
    }

    public function scopeWhereEmail($query, $email) {
        return $query->whereHas('client', function ($query) use ($email) {
            $query->where('email', 'like', '%'.$email.'%');
        });
    }
}
