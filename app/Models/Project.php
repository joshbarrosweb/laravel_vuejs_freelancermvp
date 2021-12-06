<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'details',
    	'skills',
    	'company_id',
    	'status'
    ];

    public function messages()
    {
    	return $this->hasMany(Message::class);
    }

    public function negotiations()
    {
    	return $this->hasMany(Negotiation::class);
    }
}
