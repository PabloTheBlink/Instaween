<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Migration
 *
 * Represents a migration in the database.
 *
 * @property string $migration
 * @property int $batch
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @package App\Models
 */
class Migration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'migration';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'migration',
        'batch'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Directory where the migration files are stored.
     *
     * @var string
     */
    protected static $migrationDir = __DIR__ . '/../Models/migrations/';

    /**
     * Apply all pending migrations.
     *
     * @return array An array with the migrations that were applied and the ones that were not.
     */
    public static function applyMigrations()
    {
        $migrationFiles = glob(Migration::$migrationDir . '*.php');

        // Get the already applied migrations
        $appliedMigrations = [];
        try {
            $appliedMigrations = Migration::all()->pluck('migration')->toArray();
        } catch (\Exception $e) {
        }

        // Get the last batch
        $lastBatch = !empty($appliedMigrations) ? Migration::max('batch') + 1 : 1;

        // Apply the migrations
        $doneMigrations = [];
        $undoneMigrations = [];
        foreach ($migrationFiles as $migrationFile) {
            $migrationName = pathinfo($migrationFile, PATHINFO_FILENAME);

            // If the migration has not been applied, we apply it
            if (!in_array($migrationName, $appliedMigrations)) {
                // Save the classes declared before loading the file
                $classesBefore = get_declared_classes();

                require_once $migrationFile;

                // Get the new classes declared after loading the file
                $classesAfter = get_declared_classes();
                $newClasses = array_diff($classesAfter, $classesBefore);

                // Find the class that matches the file name or the first new class
                $migrationClass = null;
                foreach ($newClasses as $class) {
                    if (stripos($class, $migrationName) !== false) {
                        $migrationClass = $class;
                        break;
                    }
                }

                if ($migrationClass === null) {
                    // If we don't find an exact match, we use the first new class
                    $migrationClass = reset($newClasses);
                }

                // Create an instance of the migration class and execute the `up` method
                $migration = new $migrationClass();
                $migration->up();

                // Register the migration as applied
                Migration::create([
                    'migration' => $migrationName,
                    'batch' => $lastBatch
                ]);

                // Check if the migration was applied
                if (!Migration::where('migration', $migrationName)->exists()) {
                    $undoneMigrations[] = $migrationName;
                } else {
                    $doneMigrations[] = $migrationName;
                }
            }
        }
        return ['done' => $doneMigrations, 'undone' => $undoneMigrations];
    }

    /**
     * Undo a migration.
     *
     * @param string $migrationName The name of the migration to undo.
     *
     * @return bool True if the migration was undone, false otherwise.
     */
    private static function undoMigration($migrationName)
    {
        // Get the already applied migrations
        $appliedMigrations = [];
        try {
            $appliedMigrations = Migration::all()->pluck('migration')->toArray();
        } catch (\Exception $e) {
        }

        // If the migration has not been applied, we can't undo it
        if (!in_array($migrationName, $appliedMigrations)) {
            return false;
        }

        // Save the classes declared before loading the file
        $classesBefore = get_declared_classes();

        require_once Migration::$migrationDir . $migrationName . '.php';

        // Get the new classes declared after loading the file
        $classesAfter = get_declared_classes();
        $newClasses = array_diff(
            $classesAfter,
            $classesBefore
        );

        // Find the class that matches the file name or the first new class
        $migrationClass = null;
        foreach ($newClasses as $class) {
            if (
                stripos($class, $migrationName) !== false
            ) {
                $migrationClass = $class;
                break;
            }
        }

        if (
            $migrationClass === null
        ) {
            // If we don't find an exact match, we use the first new class
            $migrationClass = reset($newClasses);
        }

        // Create an instance of the migration class and execute the `down` method
        $migration = new $migrationClass();
        $migration->down();

        // Check if we removed the migration from the migrations table
        if ($migrationName === '000_create_migration_table') {
            return true;
        }

        // Check if the migration was undone
        if (Migration::where('migration', $migrationName)->exists()) {
            // Register that the migration was undone
            Migration::where('migration', $migrationName)->delete();
            return true;
        }
        return false;
    }

    /**
     * Undo all migrations.
     */
    public static function undoMigrations()
    {
        $appliedMigrations = Migration::all()->pluck('migration')->toArray();
        $appliedMigrations = array_reverse($appliedMigrations);
        foreach ($appliedMigrations as $migrationName) {
            Migration::undoMigration($migrationName);
        }
    }
}
