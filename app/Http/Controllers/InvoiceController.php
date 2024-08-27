<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceObat;

class InvoiceController extends Controller
{
    public function storeInvoice(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'total_tagihan' => 'required|numeric|min:0',
            'obat' => 'required|array',
            'obat.*.nama' => 'required|string|max:255',
            'obat.*.quantity' => 'required|integer|min:1',
            'obat.*.harga_obat' => 'required|numeric|min:0',
        ]);

        // Simpan data invoice
        $invoice = Invoice::create([
            'nama_pasien' => $validatedData['nama_pasien'],
            'total_tagihan' => $validatedData['total_tagihan'],
        ]);

        // Simpan data obat di invoice
        foreach ($validatedData['medicines'] as $medicine) {
            InvoiceObat::create([
                'invoice_id' => $invoice->id,
                'nama_obat' => $medicine['name'],
                'quantity' => $medicine['quantity'],
                'price' => $medicine['price'],
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }
}
