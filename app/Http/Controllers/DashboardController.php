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
                // Don't add orderBy here - children() relationship already has it
            }])
            ->get()
            ->filter(function($menu) use ($user) {
                return $user->hasMenuPermission($menu->id, 'can_view');
            });

        // Group menus by menu_group for TailAdmin sidebar
        $userMenus = $menus->groupBy('menu_group')->map(function($groupMenus) use ($user) {
            return $groupMenus->map(function($menu) use ($user) {
                $menuArray = [
                    'id' => $menu->id,
                    'key' => $menu->key,
                    'label' => $menu->label,
                    'icon' => $menu->icon,
                    'route' => $menu->route,
                    'url' => $menu->url,
                    'children' => []
                ];

                // Add children if they exist and user has permission
                if ($menu->children->isNotEmpty()) {
                    $menuArray['children'] = $menu->children
                        ->filter(function($child) use ($user) {
                            return $user->hasMenuPermission($child->id, 'can_view');
                        })
                        ->map(function($child) {
                            return [
                                'id' => $child->id,
                                'key' => $child->key,
                                'label' => $child->label,
                                'icon' => $child->icon,
                                'route' => $child->route,
                                'url' => $child->url,
                            ];
                        })
                        ->values()
                        ->toArray();
                }

                return $menuArray;
            })->values()->toArray();
        })->toArray();

        // Provide basic stats data
        $stats = [
            'users_total' => \App\Models\User::count(),
            'users_active' => \App\Models\User::where('is_active', true)->count(),
            'departments' => \App\Models\Department::count(),
            'menus' => \App\Models\Menu::count(),
        ];

        $activities = []; // Will be implemented later

        return view('tailadmin.pages.dashboard', compact('menus', 'userMenus', 'stats', 'activities'));
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        return view('tailadmin.pages.profile');
    }
}
