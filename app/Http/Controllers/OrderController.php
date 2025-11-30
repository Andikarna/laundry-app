<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showOrder()
    {
        $user = Auth::user();
        $services = Services::with('user')->get();
        $orders = Orders::with('service.user')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'Aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeOrders = Orders::with('service.user')
            ->where('user_id', $user->id)
            ->where('status', 'Dikerjakan')
            ->first();

        return view('order.order', compact('services', 'orders', 'activeOrders'));
    }

    public function create(Request $request)
    {
        // $request->validate([
        //     'service_id' => 'required|exists:services,id',
        //     'weight' => 'nullable|numeric|min:1',
        //     'total_price' => 'required|numeric|min:0',
        // ]);

        $user = Auth::user();
        $service = Services::find($request->service_id);
        $weight = $request->weight ?? 0;
        $totalPrice = $weight * $service->price;

        $order = Orders::create([
            'invoice_code' => 'LDR-' . now()->format('YmdHis'),
            'service_id' => $request->service_id,
            'user_id' => $user->id,
            'weight' => $weight,
            'total_price' => $totalPrice,
            'status' => 'Menunggu',
        ]);

        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $user = Auth::user();
        if ($order->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus pesanan ini.');
        }

        $order->delete();

        return redirect()->route('order')->with('success', 'Pesanan berhasil dihapus!');
    }
}
