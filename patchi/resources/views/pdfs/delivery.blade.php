<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Note</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<div class="container mx-auto p-8 mt-8 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Delivery Note</h1>

    <div class="flex justify-between mb-4">
        <div>
            <p class="font-semibold">From:</p>
            <p>Your Company Name</p>
            <p>123 Main Street</p>
            <p>City, State, ZIP</p>
            <p>Email: your@email.com</p>
        </div>

        <div>
            <p class="font-semibold">To:</p>
            <p>Customer Name</p>
            <p>Address Line 1</p>
            <p>City, State, ZIP</p>
            <p>Email: customer@email.com</p>
        </div>
    </div>

    <table class="w-full mb-4">
        <thead>
        <tr>
            <th class="py-2">#</th>
            <th class="py-2">Product</th>
            <th class="py-2">Quantity</th>
            <th class="py-2">Unit Price</th>
            <th class="py-2">Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border py-2">1</td>
            <td class="border py-2">Product A</td>
            <td class="border py-2">2</td>
            <td class="border py-2">$25.00</td>
            <td class="border py-2">$50.00</td>
        </tr>
        <!-- Add more rows as needed -->
        </tbody>
    </table>

    <div class="flex justify-end">
        <div class="text-lg font-semibold">
            <p>Total: $50.00</p>
        </div>
    </div>

    <div class="mt-8">
        <p class="text-sm">Thank you for your business!</p>
    </div>
</div>

</body>

</html>
