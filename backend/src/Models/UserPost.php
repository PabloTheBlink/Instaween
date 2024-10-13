<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPost
 * 
 * Model for the user_post table
 */
class UserPost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_post";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = "user_post_uuid";

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_post_uuid",
        "caption",
        "image",
        "user_uuid"
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
