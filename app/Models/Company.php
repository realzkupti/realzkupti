<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'label',
        'logo',
        'driver',
        'host',
        'port',
        'database',
        'username',
        'password',
        'charset',
        'collation',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'port' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relationships
     */

    /**
     * Get the users that have access to this company.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'sys_user_company_access', 'company_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the branches for this company.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class, 'company_id')->orderBy('sort_order');
    }

    /**
     * Get the sticky notes for this company.
     */
    public function stickyNotes()
    {
        return $this->hasMany(StickyNote::class, 'company_id');
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
