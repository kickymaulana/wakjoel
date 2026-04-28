<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Melihat semua pesanan (Jika admin/supervisor bisa lihat semua, jika user cuma punya sendiri)
        $orders = Order::query()
            ->with(['user:id,name', 'items.menu'])
            ->latest()
            ->paginate(10);

        return Inertia::render('Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function create()
    {
        // Ambil daftar menu yang tersedia untuk dipilih di form
        $menus = Menu::where('is_available', true)->get();

        return Inertia::render('Orders/Create', [
            'menus' => $menus
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'catatan_khusus' => $request->catatan,
                'status' => 'diproses',
                'total_harga' => 0
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $menu = Menu::find($item['menu_id']);
                $subtotal = $menu->harga * $item['jumlah'];

                $order->items()->create([
                    'menu_id' => $menu->id,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total_harga' => $total]);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pesanan Wakjoel berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // app/Http/Controllers/OrderController.php

    public function updateStatus(Request $request, Order $order)
    {
        // Hanya Admin/Supervisor atau pemilik pesanan yang bisa selesaikan?
        // Biasanya Admin/Supervisor yang pegang kendali kroscek
        $order->update([
            'status' => $request->status // 'selesai' atau 'dibatalkan'
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
