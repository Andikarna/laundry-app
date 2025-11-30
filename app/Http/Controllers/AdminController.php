<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class AdminController extends Controller
{
    public function showAdmin()
    {
        $operators = User::where('role_id', 2)->get();
        $newOrders = Orders::where('status', 'menunggu')->get();
        $inProgressOrders = Orders::where('status', 'diproses')->get();
        $completedOrders = Orders::whereIn('status', ['selesai', 'pembayaran'])->orderByDesc('updated_at')->get();

        // In Progress Orders
        $inProgressOrders = $inProgressOrders->map(function ($order) {
            if ($order->service && $order->service->order_time) {
                $order->estimate_finish = \Carbon\Carbon::parse($order->created_at)
                    ->addMinutes($order->service->order_time);
            } else {
                $order->estimate_finish = null;
            }
            return $order;
        });

        // Completed Orders
        $completedOrders = $completedOrders->map(function ($order) {
            if ($order->service && $order->service->order_time) {
                $order->estimate_finish = \Carbon\Carbon::parse($order->created_at)
                    ->addMinutes($order->service->order_time);
            } else {
                $order->estimate_finish = null;
            }
            return $order;
        });


        $paymentOrders = Payments::all();
        return view('admin.admin', compact('newOrders', 'completedOrders', 'paymentOrders', 'operators', 'inProgressOrders'));
    }

    public function assign($id)
    {
        $order = Orders::find($id);
        if ($order) {
            $order->operator_id = request()->input('operator_id');
            $order->status = 'Diproses';
            $order->updated_at = now();
            $order->save();
        }
        return redirect()->route('admin');
    }

    public function payments(Request $request, $id)
    {
        $order = Orders::findOrFail($id);

        // VALIDASI
        // $request->validate([
        //     'weight' => 'required|numeric|min:1',
        //     'payment_method' => 'required|string',
        //     'pay_now' => 'required|boolean',
        // ]);

        // UPDATE BERAT ORDER
        $order->weight = $request->weight;
        $order->total_price = $request->weight * $order->service->price;

        $payments = Payments::create([
            'order_id'       => $order->id,
            'payment_method' => $request->payment_method,
            'amount'         => $order->total_price,
            'payment_date'   => Carbon::now(),
            'status'         => 'Pembayaran',
        ]);

        $payments->save();

        // update status order
        $order->status = 'Pembayaran';
        $order->save();


        return redirect()->route('admin');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Berhasil memperbarui berat dan menyimpan pembayaran'
        // ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Payments::findOrFail($id);

        if ($request->action == "lunas") {
            $order->status = "Pengambilan";
            $order->order->status = "Pembayaran";
            $order->order->save();
            $order->save();

            return back()->with('success', 'Pembayaran berhasil ditandai sebagai Lunas.');
        }

        if ($request->action == "diambil") {
            $order->status = "Selesai";
            $order->order->status = "Selesai";
            $order->order->save();
            $order->save();

            return back()->with('success', 'Pesanan berhasil ditandai sebagai Sudah Diambil.');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }

    public function deletePayment($id)
    {
        $payment = Payments::findOrFail($id);

        // Menghapus data pembayaran
        $payment->delete();

        return redirect()->back()->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048', // max 2MB
        ]);

        $payment = Payments::findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'payment_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan di disk local_c (C:/payment_proofs)
            $path = $file->storeAs('', $filename, 'local_c');

            // Simpan path di database
            $payment->document_path = $path;
            $payment->save();

            // Update juga di order
            if ($payment->order) {
                $payment->order->document_path = $path;
                $payment->order->save();
            }
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}
