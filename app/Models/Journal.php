<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_number', 'date', 'sequence', 'acc_code', 'description',
        'debit', 'credit', 'document_type', 'reference_id'
    ];

    protected $casts = [
        'date' => 'date',
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'acc_code', 'code');
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
