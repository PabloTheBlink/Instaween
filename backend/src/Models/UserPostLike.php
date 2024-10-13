<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserPostLike extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_post_like";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ["user_post_uuid", "user_uuid"];

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
        'user_post_uuid',
        'user_uuid',
        'opt'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
