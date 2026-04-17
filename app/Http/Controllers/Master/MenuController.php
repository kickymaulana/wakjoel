<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_item', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Master/Menus/Index', [
            'menus' => $menus,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Master/Menus/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        Menu::create($request->all());

        return redirect()->route('menus.index')->with('success', 'Lauk baru berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return Inertia::render('Master/Menus/Edit', [
            'menu' => $menu
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $menu->update($request->all());

        return redirect()->route('menus.index')->with('success', 'Harga lauk berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Lauk berhasil dihapus.');
    }
}
