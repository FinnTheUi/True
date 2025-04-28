<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller; // Import the correct base Controller class

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure all actions require login
    }

    /**
     * Display a listing of the contacts.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $contacts = Contact::query()
            ->where('user_id', Auth::id()) // Only current user's contacts
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created contact.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[A-Za-z0-9 ]+$/', 'max:255'], // Only letters, numbers, and spaces
            'email' => ['required', 'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/'], // Must end with @gmail.com
            'phone' => ['required', 'regex:/^\+63\d{9}$/'], // Must start with +63 and have 9 digits after
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    /**
     * Display a specific contact.
     */
    public function show(Contact $contact)
    {
        $this->authorizeContact($contact); // Ensure the user owns the contact

        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing a contact.
     */
    public function edit(Contact $contact)
    {
        $this->authorizeContact($contact); // Ensure the user owns the contact

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update an existing contact.
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorizeContact($contact); // Ensure the user owns the contact

        $request->validate([
            'name' => ['required', 'regex:/^[A-Za-z0-9 ]+$/', 'max:255'], // Only letters, numbers, and spaces
            'email' => ['required', 'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/'], // Must end with @gmail.com
            'phone' => ['required', 'regex:/^\+63\d{9}$/'], // Must start with +63 and have 9 digits after
        ]);

        $contact->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Delete a contact.
     */
    public function destroy(Contact $contact)
    {
        $this->authorizeContact($contact); // Ensure the user owns the contact

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }

    /**
     * Export contacts to CSV.
     */
    public function export()
    {
        $contacts = Contact::where('user_id', Auth::id())->get();

        $csvFileName = 'contacts_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        return response()->stream(function () use ($contacts) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Phone']);

            foreach ($contacts as $contact) {
                fputcsv($handle, [$contact->name, $contact->email, $contact->phone]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Authorize the contact to make sure it belongs to the user.
     */
    private function authorizeContact(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action. You do not own this contact.');
        }
    }
}