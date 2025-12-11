<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number', 'date', 'date_install', 'start_license', 'client_id',
        'product_id', 'item_id', 'status', 'amount', 'description',
        'item_count', 'per_unit', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'date_install' => 'date',
        'start_license' => 'date',
        'amount' => 'decimal:2',
        'item_count' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function teamMembers()
    {
        return $this->belongsToMany(TeamMember::class, 'work_order_teams')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function stopLicense()
    {
        return $this->hasOne(StopLicense::class);
    }

    public function isActive()
    {
        return $this->status === 'AKTIF';
    }

    public function isStopped()
    {
        return $this->status === 'STOP';
    }
}
