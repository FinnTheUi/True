<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .phone-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .phone-prefix {
            background: #f1f1f1;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #555;
        }

        input {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex: 1;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            padding: 10px;
            font-size: 1rem;
            color: #fff;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        .back-btn {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            text-align: center;
            transition: color 0.3s ease;
        }

        .back-btn:hover {
            color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: -10px;
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
    <div class="form-container">
        <h1><i class="bi bi-person-plus"></i> Create a New Contact</h1>
        <form method="POST" action="<?php echo e(route('contacts.store')); ?>" id="createContactForm">
            <?php echo csrf_field(); ?>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter name" required>
            <div class="error-message" id="nameError"></div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
            <div class="error-message" id="emailError"></div>

            <label for="phone">Phone:</label>
            <div class="phone-group">
                <span class="phone-prefix">+63</span>
                <input type="text" id="phone" name="phone" placeholder="Enter 9-digit number" maxlength="9" required>
            </div>
            <div class="error-message" id="phoneError"></div>

            <button type="submit"><i class="bi bi-save"></i> Save Contact</button>
        </form>
        <a href="<?php echo e(route('dashboard')); ?>" class="back-btn"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    </div>

    <script>
        document.getElementById('createContactForm').addEventListener('submit', function (e) {
            let isValid = true;

            // Name validation: Only letters and numbers
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            const nameRegex = /^[A-Za-z0-9 ]+$/;
            if (!nameRegex.test(nameInput.value)) {
                nameError.textContent = "Name can only contain letters and numbers.";
                isValid = false;
            } else {
                nameError.textContent = "";
            }

            // Email validation: Must end with @gmail.com
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailRegex = /^[A-Za-z0-9._%+-]+@gmail\.com$/;
            if (!emailRegex.test(emailInput.value)) {
                emailError.textContent = "Email must end with @gmail.com.";
                isValid = false;
            } else {
                emailError.textContent = "";
            }

            // Phone validation: Must have exactly 9 digits
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phoneError');
            const phoneRegex = /^\d{9}$/; // Only 9 digits allowed
            if (!phoneRegex.test(phoneInput.value)) {
                phoneError.textContent = "Phone must contain exactly 9 digits.";
                isValid = false;
            } else {
                phoneError.textContent = "";
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html><?php /**PATH /var/www/resources/views/contacts/create.blade.php ENDPATH**/ ?>