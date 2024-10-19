<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    use HasFactory;
    
    // Define the table if it doesn't follow Laravel's conventions
    protected $table = 'vaccine_centers';

    // Define the fillable fields
    protected $fillable = [
        'name',
        'sort',
        'maximum_limit',
    ];

    // Define any relationships, for example, if a center can have many users
    public function users()
    {
        return $this->hasMany(User::class, 'centers_id');
    }
}
