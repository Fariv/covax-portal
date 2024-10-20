<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'centers_id', 'users_id');
    }
}
