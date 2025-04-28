<!-- filepath: c:\SIRKIM\ContactDaw\src\resources\views\contacts\index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
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

        .contacts-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 800px;
            animation: fadeIn 1.5s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .contacts-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contacts-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background: #f9f9f9;
            transition: background 0.3s ease;
        }

        .contacts-list li:hover {
            background: #f1f1f1;
        }

        .contact-actions a, .contact-actions form button {
            margin-left: 10px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .contact-actions a:hover, .contact-actions form button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .contact-actions form {
            display: inline;
        }

        .add-contact-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background: #28a745;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .add-contact-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background: #dc3545;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .back-btn:hover {
            background: #c82333;
            transform: scale(1.05);
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
    <div class="contacts-container">
        <h2>Contacts</h2>
        <a href="{{ route('contacts.create') }}" class="add-contact-btn">+ Add New Contact</a>

        <ul class="contacts-list">
            @foreach ($contacts as $contact)
                <li>
                    <div>
                        <strong>{{ $contact->name }}</strong> - {{ $contact->email }}
                    </div>
                    <div class="contact-actions">
                        <a href="{{ route('contacts.show', $contact) }}">View</a>
                        <a href="{{ route('contacts.edit', $contact) }}">Edit</a>
                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>

        <a href="/dashboard" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>