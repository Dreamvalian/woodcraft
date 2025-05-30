<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow h-screen p-6">
            <div class="font-bold text-lg mb-8">Windmill</div>
            <nav class="space-y-4">
                <a href="/admin/dashboard" class="block text-gray-700 hover:underline">Dashboard</a>
                <a href="/admin/products" class="block text-gray-700 hover:underline">Tables</a>
                <a href="/admin/products/create" class="block text-purple-700 font-semibold">Create Product</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-6">Upload Product</h2>
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input type="text" id="name" name="name" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium">Price</label>
                        <input type="number" id="price" name="price" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium">Stok</label>
                        <input type="number" id="stock" name="stock" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium">Description</label>
                        <textarea id="description" name="description" class="w-full border rounded p-2" rows="3"></textarea>
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium">Image</label>
                        <input type="file" id="image" name="image" class="block w-full">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="reset" class="bg-red-500 text-white px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
