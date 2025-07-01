<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'status',
        'total_weight',
        'total_amount',
        'notes',
        'pickup_date',
        'estimated_completion_date',
        'actual_completion_date',
    ];

    protected $casts = [
        'total_weight' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'pickup_date' => 'date',
        'estimated_completion_date' => 'date',
        'actual_completion_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'received' => 'Diterima',
            'washing' => 'Sedang Dicuci',
            'ironing' => 'Sedang Disetrika',
            'completed' => 'Selesai',
            'ready_for_pickup' => 'Siap Diambil',
            'picked_up' => 'Sudah Diambil',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'received' => 'info',
            'washing' => 'primary',
            'ironing' => 'info',
            'completed' => 'success',
            'ready_for_pickup' => 'success',
            'picked_up' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
