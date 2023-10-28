<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    // protected $fillable = ['title', 'company', 'location', 'email', 'website', 'tags', 'description'];

    public function scopeFilter($query, array $filters) {
        if(isset($filters['tag'])) { // Check if 'tag' key is present in $filters
            $query->where('tags', 'like', '%' . $filters['tag'] . '%'); // Use $filters['tag'] instead of request('tags')
        }

        if(isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%') 
                  ->orWhere('tags', 'like', '%' . $filters['search'] . '%'); 
    }
}

//Relationship to user
public function user() {
    return $this->belongsTo(User::class, 'user_id');

}

}