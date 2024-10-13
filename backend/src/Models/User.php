<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * Model for the user table
 *
 * @property string $uuid The UUID of the user.
 * @property string $email The email of the user.
 * @property string $password The password of the user.
 *
 * @package App\Models
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = "user_uuid";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

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
        "user_uuid",
        "username",
        "email",
        "password"
    ];
}
