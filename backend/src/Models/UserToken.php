<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserToken
 *
 * Model for the user_token table
 *
 * @property string $token The token of the user.
 * @property string $user_uuid The UUID of the user.
 * @property string $device The device of the user.
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @package App\Models
 */
class UserToken extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_token";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = "token";

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
        "token",
        "user_uuid"
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
