<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'content', 'created_at', 'updated_at', 'project_id', 'negotiation_id'];

    public function negotiation()
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
