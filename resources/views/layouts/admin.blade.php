<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - WoodCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-[#4B2E1F] text-white py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">WoodCraft Admin</h1>
        <form method="POST" action="/logout">
            <button type="submit" class="text-white hover:underline">Logout</button>
        </form>
    </header>
    <div class="flex">
        <aside class="w-64 bg-white shadow h-screen">
            <nav class="flex flex-col p-4 space-y-2">
                <a href="/admin/dashboard" class="hover:bg-gray-200 p-2 rounded">Dashboard</a>
                <a href="/admin/products" class="hover:bg-gray-200 p-2 rounded">Products</a>
                <a href="/admin/products/create" class="hover:bg-gray-200 p-2 rounded">Upload Product</a>
            </nav>
        </aside>
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
