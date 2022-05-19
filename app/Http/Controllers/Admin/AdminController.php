<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Экшен для главной стр. админки
     */
    public function home(Request $request)
    {
        $user = Auth::user();

        $recentOps = $user->operations()->orderBy('date', 'desc')->limit(5)->get();

        return view('admin.home', [
            'recentOps' => $recentOps,
        ]);
    }

    /**
     * Экшен для загрузки данных на страницу "история операций"
     */
    public function historyAjax(Request $request)
    {
        return Laratables::recordsOf(Operation::class, function($query)
        {
            return $query->where('user_id', Auth::user()->id);
        });
    }

    /**
     * Экшен для загрузки на страницу home 5 последних операций аяксом
     */
    public function recentOpsAjax(Request $request)
    {
        $user = Auth::user();

        $recentOps = $user->operations()->orderBy('date', 'desc')->limit(5)->get();

        $view = view('admin.recent-ops', [
            'recentOps' => $recentOps
        ]);

        return $view->render();
    }
}
