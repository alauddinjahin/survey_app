<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::orderBy('created_at','desc')->get();
        return view('backend.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),[
                'title' => 'required|unique:payments',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }    

            $data = $request->all();
            $data['created_by'] = auth()->user()->id??null;

            Payment::create($data);

            return redirect(route('payments.index'))->withSuccess('Payment Added Successfully!');

        } catch (Exception $e) {
            return redirect()->back()->withDanger($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Payment $payment)
    {
        try {

            $validator = Validator::make(request()->all(),[
                'title' => "required|unique:payments,title,{$payment->id}",
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }    

            $data = request()->all();

            $data['updated_by'] = auth()->user()->id??null;

            $payment->update($data);

            return redirect(route('payments.index'))->withSuccess('Payment Updated Successfully!');

        } catch (Exception $e) {
            return redirect()->back()->withDanger($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
    }
}
