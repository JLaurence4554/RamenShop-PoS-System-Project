<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <style>

        body {
            background-color: #111827; 
            margin: 0;
            height: 100vh;
            overflow: hidden; 
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background: #f9fafb;
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #374151;
            color: white;
        }

        .button {
            background-color: #2563eb;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        .success-message {
            background-color: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Modal styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 650px; /* increased */
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #111827;
            text-align: center;
        }

        .form-flex {
            display: flex;
            gap: 25px; /* a bit wider gap */
            align-items: flex-start;
        }

        .image-upload {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-preview {
            width: 220px; /* enlarged */
            height: 220px; /* enlarged */
            border: 2px dashed #ccc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-inputs {
            flex: 1.3; 
        }

        .modal-content input,
        .modal-content textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            border: none;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-cancel {
            background-color: #6b7280;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            border: none;
        }

        .btn-cancel:hover {
            background-color: #4b5563;
        }

        .table-wrapper {
            max-height: 500px; /* adjust height to your preference */
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
        }

        /* Optional: sticky table headers while scrolling */
        .table-wrapper table thead th {
            position: sticky;
            top: 0;
            background-color: #374151;
            color: white;
            z-index: 5;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 8px;
        }
        .table-wrapper::-webkit-scrollbar-thumb {
            background-color: #9ca3af;
            border-radius: 4px;
        }
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: #6b7280;
        }

    </style>

    <div class="container">
        <h1>Products List</h1>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-bottom: 15px;">
            <button class="button" id="openModalBtn">Create New Product</button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                            @else
                                <span>No Image</span>
                            @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <button 
                                    class="button" 
                                    style="background-color: #28a745;"
                                    onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description) }}', {{ $product->price }}, '{{ $product->image }}')">
                                    Edit
                                </button>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('product.delete', ['product' => $product]) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-content">
            <h3>Create Product</h3>
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-flex">
                    <div class="image-upload">
                        <div class="image-preview" id="createPreview">
                            <span>No image</span>
                        </div>
                        <input type="file" name="image" accept="image/*" onchange="previewSelectedImage(event, 'createPreview')">
                    </div>
                    <div class="form-inputs">
                        <input type="text" name="name" placeholder="Name" required>
                        <textarea name="description" placeholder="Description" required></textarea>
                        <input type="number" step="0.01" name="price" placeholder="Price" required>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-success">Create</button>
                    <button type="button" class="btn-cancel" id="closeModalBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-content">
            <h3>Edit Product</h3>
            <form method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-flex">
                    <div class="image-upload">
                        <div class="image-preview" id="editPreview">
                            <span>No image</span>
                        </div>
                        <input type="file" name="image" accept="image/*" onchange="previewSelectedImage(event, 'editPreview')">
                    </div>
                    <div class="form-inputs">
                        <input type="text" id="editName" name="name" required>
                        <textarea id="editDescription" name="description" required></textarea>
                        <input type="number" step="0.01" id="editPrice" name="price" required>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-success">Update</button>
                    <button type="button" class="btn-cancel" id="closeEditModalBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview selected image
        function previewSelectedImage(event, previewId) {
            const previewBox = document.getElementById(previewId);
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    previewBox.innerHTML = `<img src="${reader.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                previewBox.innerHTML = '<span>No image</span>';
            }
        }

        // CREATE MODAL
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalOverlay = document.getElementById('modalOverlay');

        openModalBtn.addEventListener('click', () => modalOverlay.style.display = 'flex');
        closeModalBtn.addEventListener('click', () => modalOverlay.style.display = 'none');
        modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) modalOverlay.style.display = 'none'; });

        // EDIT MODAL
        const editModal = document.getElementById('editModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editForm = document.getElementById('editForm');
        const editName = document.getElementById('editName');
        const editDescription = document.getElementById('editDescription');
        const editPrice = document.getElementById('editPrice');
        const editPreview = document.getElementById('editPreview');

        function openEditModal(id, name, description, price, imagePath) {
            editForm.action = `/product/${id}/update`;
            editName.value = name;
            editDescription.value = description;
            editPrice.value = price;
            editPreview.innerHTML = imagePath ? `<img src="/storage/${imagePath}" alt="Product">` : '<span>No image</span>';
            editModal.style.display = 'flex';
        }

        closeEditModalBtn.addEventListener('click', () => editModal.style.display = 'none');
        editModal.addEventListener('click', (e) => { if (e.target === editModal) editModal.style.display = 'none'; });
    </script>
</x-app-layout>
