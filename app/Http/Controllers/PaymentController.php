<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $items = Payment::paginate(20);
        return view('payments.index', compact('items'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return redirect()->route('payments.show', $payment)->with('success', __('messages.saved'));
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return redirect()->route('payments.show', $payment)->with('success', __('messages.updated'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', __('messages.deleted'));
    }
}
