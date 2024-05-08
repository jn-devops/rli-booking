<?php

namespace RLI\Booking\Http\Controllers;

use RLI\Booking\Data\{ContactData, ProductData};
use RLI\Booking\Models\{Contact, Product};
use Spatie\LaravelData\DataCollection;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $contacts = new DataCollection(ContactData::class, Contact::all());

        return inertia()->render('Contacts/Index',['xxx' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): \Inertia\Response
    {
        $products = new DataCollection(ProductData::class, Product::all());

        return inertia()->render('Contacts/Show',[
            'contact' => $contact->toData(),
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return inertia()->render('Contacts/Edit',['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $contact->update($request->all());
        return back()->with(["message"=>'Contact has been successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
