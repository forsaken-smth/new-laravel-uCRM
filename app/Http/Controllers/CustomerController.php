<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        // $getTest = Customer::select('id', 'name', 'kana', 'tel')->get();
        // $getPageNate = Customer::select('id', 'name', 'kana', 'tel')->paginate(50);

        // dd($getTest, $getPageNate);

        $customers = Customer::searchCustomers($request->search)
        ->select('id', 'name', 'kana', 'tel')->paginate(50)->withQueryString();

        // dd($customers);

        return Inertia::render("Customers/Index", [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        Customer::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'tel' => $request->tel,
            'email' => $request->email,
            'postcode' => $request->postcode,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'memo' => $request->memo,
            ]);

            return to_route('customers.index')
            ->with([
            'message' => '登録しました。',
            'status' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return Inertia::render('Customers/Show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Customers/Edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->name = $request->name;
        $customer->kana = $request->kana;
        $customer->tel = $request->tel;
        $customer->email = $request->email;
        $customer->postcode = $request->postcode;
        $customer->address = $request->address;
        $customer->birthday = $request->birthday;
        $customer->gender = $request->gender;
        $customer->memo = $request->memo;

        $customer->save();

        return to_route('customers.index')
        ->with([
            'message'=> '更新しました。',
            'status'=> 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}