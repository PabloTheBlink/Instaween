<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cron
 *
 * Model for the crons table. It represents a cron job.
 *
 * @property string $name
 * @property bool $active
 * @property string $last_execution_time
 * @property int $repeat_after_seconds
 *
 * @package App\Models
 */
class Cron extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cron';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'name';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
        'last_execution_time',
        'repeat_after_seconds'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];
}
