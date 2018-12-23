<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model {

    protected $table = "images";
    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
