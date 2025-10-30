<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StickyNote extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_sticky_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'menu_id',
        'company_id',
        'content',
        'color',
        'position_x',
        'position_y',
        'width',
        'height',
        'z_index',
        'is_minimized',
        'is_pinned',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'position_x' => 'integer',
        'position_y' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'z_index' => 'integer',
        'is_minimized' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    /**
     * Relationships
     */

    /**
     * Get the user that owns the sticky note.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the menu that the sticky note is attached to.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Get the company that the sticky note is attached to.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
