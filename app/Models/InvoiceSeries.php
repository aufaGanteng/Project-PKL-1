<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_start', 'period_end', 'sequence', 'prefix',
        'tax_period', 'tax_year', 'tax_code', 'last_number',
        'ppn_percentage', 'dpp_percentage'
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'sequence' => 'integer',
    ];

    public function getNextNumber()
    {
        $this->increment('sequence');
        $this->last_number = $this->prefix . str_pad($this->sequence, 3, '0', STR_PAD_LEFT);
        $this->save();

        return $this->last_number;
    }
}
