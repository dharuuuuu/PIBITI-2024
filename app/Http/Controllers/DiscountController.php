<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Discount::query();

        if ($request->search) {
            $query->where('nama_discount', 'like', "%{$request->search}%");
        }

        $discounts = $query->get();

        return view('discounts.index', [
            'discounts' => $discounts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_discount' => 'required',
            'total_discount' => 'required|numeric',
        ]);

        $discount = new Discount();
        $discount->nama_discount = $request->nama_discount;
        $discount->total_discount = $request->total_discount;
        $discount->active = $request->active == 'on';
        $discount->save();

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        return view('discounts.edit', [
            'discount' => $discount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'nama_discount' => 'required',
            'total_discount' => 'required|numeric',
        ]);

        $discount->nama_discount = $request->nama_discount;
        $discount->total_discount = $request->total_discount;
        $discount->active = $request->active == 'on';
        $discount->save();

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount berhasil dihapus!');
    }
}
