<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    use HasFactory;

    protected $fillable = [
    	'project_id',
    	'status'
    ];

    public function project()
    {
    	return $this->belongsTo(Project::class);
    }

    public function messages()
    {
    	return $this->hasMany(Message::class);
    }

    public function users()
    {
    	return $this->belongsToMany(User::class)
            ->withTimestamps()->withPivot('project_id');
    }

    public function getProjectAttribute(){
        return $this->project()->get();
    }

    public function getUserAttribute(){
        return $this->users()->get();
    }
}
