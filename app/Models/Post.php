<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];


    //eloquent relationship 
    //tell Post model that its related to User model
    public function user(){ //user function naming convention helps me in shorting alot of code
        return $this->belongsTo(User::class);
        //return $this->belongsTo(User::class, 'user_id'); 
        //if we didnot put user name convention on the function we should have put the user_id foreign key
    }
}
