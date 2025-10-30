<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'department_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */

    /**
     * Get the department that the user belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the user menu permissions for the user.
     */
    public function menuPermissions()
    {
        return $this->hasMany(UserMenuPermission::class);
    }

    /**
     * Get the companies that the user has access to.
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'sys_user_company_access', 'user_id', 'company_id')
                    ->withTimestamps();
    }

    /**
     * Get the sticky notes for the user.
     */
    public function stickyNotes()
    {
        return $this->hasMany(StickyNote::class);
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

    /**
     * Check if user has permission for a menu action.
     *
     * @param int|string $menuIdOrKey
     * @param string $action
     * @return bool
     */
    public function hasMenuPermission($menuIdOrKey, $action = 'can_view')
    {
        // Admin always has access
        if ($this->email === 'admin@local') {
            return true;
        }

        // Get menu
        $menu = is_numeric($menuIdOrKey)
            ? Menu::find($menuIdOrKey)
            : Menu::where('key', $menuIdOrKey)->first();

        if (!$menu) {
            return false;
        }

        // Check user-specific permission first (highest priority)
        $userPermission = $this->menuPermissions()
            ->where('menu_id', $menu->id)
            ->first();

        if ($userPermission) {
            return $userPermission->$action ?? false;
        }

        // Check department permission
        if ($this->department_id) {
            $deptPermission = DepartmentMenuPermission::where('department_id', $this->department_id)
                ->where('menu_id', $menu->id)
                ->first();

            if ($deptPermission) {
                return $deptPermission->$action ?? false;
            }
        }

        // Deny by default
        return false;
    }
}
