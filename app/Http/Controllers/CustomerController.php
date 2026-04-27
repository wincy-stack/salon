<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    public function index() {
        $customers = Customer::latest()->get();
        return view('salon.customers.index', compact('customers'));
    }
    public function create() {
        return view('salon.customers.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);
        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer added!');
    }
    public function edit(Customer $customer) {
        return view('salon.customers.edit', compact('customer'));
    }
    public function update(Request $request, Customer $customer) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);
        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer updated!');
    }
    public function destroy(Customer $customer) {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted!');
    }
}