<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with the user's contacts.
     */
    public function index()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to access the dashboard.');
        }

        // Retrieve the authenticated user's contacts (all contacts)
        $contacts = Contact::where('user_id', Auth::id())->get();

        // Pass the contacts to the dashboard view
        return view('dashboard', compact('contacts'));
    }

    /**
     * Display the most recent 5 contacts.
     */
    public function recentContacts()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to access recent contacts.');
        }

        // Retrieve the most recent 5 contacts for the authenticated user
        $recentContacts = Contact::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc') // Order by creation date
            ->take(5) // Limit to the 5 most recent
            ->get();

        // Pass the recentContacts to the view
        return view('recent-contacts', compact('recentContacts'));
    }
}