<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id', 'team_member_id', 'role'
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }
}
