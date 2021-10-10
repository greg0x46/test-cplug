<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cst = new Customer();
        $cst->name = $request->name;
        $cst->save();
        $cst->addCategories(current($request->only('categories')));

        return response()->json(['customer_id' => $cst->id], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->only(['name']));
        $customer->syncCategories(current($request->only('categories')));

        return response()->json(['customer_id' => $customer->id]);
    }
}
