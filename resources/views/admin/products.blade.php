<!-- resources/views/admin/products.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Products - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow h-screen">
        <div class="p-6 text-xl font-bold text-[#4B2E1F]">Wood Craft</div>
        <nav class="space-y-2 mt-6">
            <a href="/admin/dashboard" class="block px-6 py-2 hover:bg-gray-200">Dashboard</a>
            <a href="/admin/products" class="block px-6 py-2 bg-gray-200">Tables Products</a>
            <a href="/admin/products/create" class="block px-6 py-2 hover:bg-gray-200">Create Product</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-semibold mb-6">Products</h1>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" placeholder="Search for products" class="w-full px-4 py-2 border rounded">
        </div>

        <!-- Product Table -->
        <div class="bg-white shadow rounded-lg p-4 mb-10">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-700 border-b">
                        <th class="py-2 px-4">WOOD</th>
                        <th class="py-2 px-4">PRICE</th>
                        <th class="py-2 px-4">DESCRIPTION</th>
                        <th class="py-2 px-4">STOK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-2 px-4 flex items-center gap-2">
                            <img src="/image/wood-1.png" alt="" class="w-10 h-10 rounded">
                            Joseph
                        </td>
                        <td class="py-2 px-4">30000000</td>
                        <td class="py-2 px-4"><span class="bg-green-100 text-green-700 px-2 rounded">BURUUU</span></td>
                        <td class="py-2 px-4">23</td>
                    </tr>
                    <!-- Tambah baris lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>

        <!-- Edit Products Section -->
        <h2 class="text-xl font-semibold mb-4">Edit Products</h2>
        <div class="bg-white shadow rounded-lg p-4">
            <table class="min-w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-700 border-b">
                        <th class="py-2 px-4">WOOD</th>
                        <th class="py-2 px-4">PRICE</th>
                        <th class="py-2 px-4">DESCRIPTION</th>
                        <th class="py-2 px-4">STOK</th>
                        <th class="py-2 px-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-2 px-4 flex items-center gap-2">
                            <img src="/image/wood-1.png" alt="" class="w-10 h-10 rounded">
                            Joseph
                        </td>
                        <td class="py-2 px-4">30000000</td>
                        <td class="py-2 px-4"><span class="bg-green-100 text-green-700 px-2 rounded">BURUUU</span></td>
                        <td class="py-2 px-4">23</td>
                        <td class="py-2 px-4 flex space-x-2">
                            <a href="#" class="text-blue-500 hover:underline">✏️</a>
                            <button onclick="confirm('Are you sure you want to delete this product?')" class="text-red-500 hover:underline">🗑️</button>
                        </td>
                    </tr>
                    <!-- Tambah baris lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
