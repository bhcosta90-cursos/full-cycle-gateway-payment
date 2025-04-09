<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;

final class InvoiceController
{
    public function index()
    {
        return InvoiceResource::collection(Invoice::all());
    }

    public function store(InvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->validated()));
    }

    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return new InvoiceResource($invoice);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json();
    }
}
