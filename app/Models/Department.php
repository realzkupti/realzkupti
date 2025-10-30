<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'label',
        'sort_order',
        'is_active',
        'is_default',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationships
     */

    /**
     * Get the menus for the department.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'department_id');
    }

    /**
     * Get the users for the department.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    /**
     * Get the menu permissions for the department.
     */
    public function menuPermissions()
    {
        return $this->hasMany(DepartmentMenuPermission::class, 'department_id');
    }

    /**
     * Get the user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this record.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
