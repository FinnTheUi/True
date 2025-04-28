<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Contact Manager</title>
    <!-- Include a free icons library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-/aUvZ1G..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .dashboard-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1100px;
            animation: fadeIn 1.5s ease-in-out;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #007bff;
            text-align: center;
        }

        .flash-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .search-bar, .category-filter {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input, .category-filter select {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 70%;
        }

        .search-bar button, .category-filter button {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .search-bar button:hover, .category-filter button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .contacts-table, .recent-contacts-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .contacts-table th, .contacts-table td,
        .recent-contacts-table th, .recent-contacts-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .contacts-table th, .recent-contacts-table th {
            background: #007bff;
            color: #fff;
        }

        .contacts-table tr:nth-child(even), 
        .recent-contacts-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .contacts-table tr:hover,
        .recent-contacts-table tr:hover {
            background: #f1f1f1;
        }

        .add-contact-btn, .logout-btn, .recent-contacts-btn {
            display: inline-block;
            margin-top: 20px;
            margin-right: 10px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .add-contact-btn {
            background: #28a745;
        }

        .add-contact-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .logout-btn {
            background: #dc3545;
        }

        .logout-btn:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .recent-contacts-btn {
            background: #17a2b8;
        }

        .recent-contacts-btn:hover {
            background: #138496;
            transform: scale(1.05);
        }

        .edit-btn, .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #007bff;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .edit-btn:hover {
            color: #0056b3;
        }

        .delete-btn:hover {
            color: #c82333;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, {{ Auth::user()->name }}</h2>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="flash-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Bar -->
        <form method="GET" action="{{ route('contacts.index') }}" class="search-bar">
            <input type="text" name="search" placeholder="Search contacts..." value="{{ request('search') }}">
            <button type="submit"><i class="fas fa-search"></i> Search</button>
        </form>

        <!-- Category Filter -->
        <form method="GET" action="{{ route('contacts.index') }}" class="category-filter">
            <select name="category">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit"><i class="fas fa-filter"></i> Filter</button>
        </form>

        <!-- Contacts Table -->
        <table class="contacts-table">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-phone"></i> Phone</th>
                    <th><i class="fas fa-cogs"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No contacts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Add Contact and Recent Contacts Buttons -->
        <div style="margin-top: 20px;">
            <a href="{{ route('contacts.create') }}" class="add-contact-btn"><i class="fas fa-plus"></i> Add Contact</a>
            <a href="{{ route('recent.contacts') }}" class="recent-contacts-btn"><i class="fas fa-clock"></i> Recent Contacts</a>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</body>
</html>
