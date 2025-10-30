<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show dashboard page
     */
    public function index()
    {
        $user = Auth::user();

        // Get menus that user has permission to view
        $menus = Menu::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->get()
            ->filter(function($menu) use ($user) {
                return $user->hasMenuPermission($menu->id, 'can_view');
            });

        return view('dashboard', compact('menus'));
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        return view('profile');
    }
}
