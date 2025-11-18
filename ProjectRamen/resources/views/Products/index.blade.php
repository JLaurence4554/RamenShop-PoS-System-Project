<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Lists') }}
        </h2>
    </x-slot>

    <style>
        body {
            background-color: #0f172a; 
            margin: 0;
            height: 100vh;
            overflow: hidden; 
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 700;
        }

        .table-wrapper {
            max-height: 550px;
            overflow-y: auto;
            border-radius: 12px;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: linear-gradient(135deg, #052250ff 0%, #052e86ff 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .table-wrapper table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 10px;
        }
        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        .table-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #94a3b8, #64748b);
            border-radius: 10px;
        }
        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #64748b, #475569);
        }

        .button {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
        }

        .button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.4);
            transform: translateY(-2px);
        }

        .btn-edit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }

        .success-message {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            border-left: 4px solid #10b981;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.1);
        }

        .price-cell {
            font-weight: 700;
            color: #059669;
            font-size: 1.1rem;
        }

        /* Modal styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 50;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 16px;
            width: 700px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content h3 {
            margin-bottom: 25px;
            color: #1e293b;
            text-align: center;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .form-flex {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .image-upload {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-preview {
            width: 240px;
            height: 240px;
            border: 3px dashed #cbd5e1;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            margin-bottom: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview span {
            color: #94a3b8;
            font-weight: 500;
        }

        input[type="file"] {
            padding: 8px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            border-color: #3b82f6;
        }

        .form-inputs {
            flex: 1.3; 
        }

        .modal-content input[type="text"],
        .modal-content input[type="number"],
        .modal-content textarea {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .modal-content input:focus,
        .modal-content textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .modal-content textarea {
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 15px;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3);
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.4);
            transform: translateY(-2px);
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .no-image-placeholder {
            color: #94a3b8;
            font-style: italic;
            font-size: 0.9rem;
        }
    </style>

    <div class="container">
        <h1>🍜 Ramen List</h1>

        @if (session('success'))
            <div class="success-message">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="header-actions">
            <button class="button" id="openModalBtn">+ Create New Product</button>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><strong>{{ $product->id }}</strong></td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                                @else
                                    <span class="no-image-placeholder">No Image</span>
                                @endif
                            </td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->description }}</td>
                            <td class="price-cell">₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                <button 
                                    class="btn-edit" 
                                    onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description) }}', {{ $product->price }}, '{{ $product->image }}')">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('product.delete', ['product' => $product]) }}" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
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
            <h3>Create New Product</h3>
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-flex">
                    <div class="image-upload">
                        <div class="image-preview" id="createPreview">
                            <span>📷 Upload Image</span>
                        </div>
                        <input type="file" name="image" accept="image/*" onchange="previewSelectedImage(event, 'createPreview')">
                    </div>
                    <div class="form-inputs">
                        <input type="text" name="name" placeholder="Product Name" required>
                        <textarea name="description" placeholder="Product Description" required></textarea>
                        <input type="number" step="0.01" name="price" placeholder="Price (₱)" required>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-success">Create Product</button>
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
                            <span>📷 Upload Image</span>
                        </div>
                        <input type="file" name="image" accept="image/*" onchange="previewSelectedImage(event, 'editPreview')">
                    </div>
                    <div class="form-inputs">
                        <input type="text" id="editName" name="name" placeholder="Product Name" required>
                        <textarea id="editDescription" name="description" placeholder="Product Description" required></textarea>
                        <input type="number" step="0.01" id="editPrice" name="price" placeholder="Price (₱)" required>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-success">Update Product</button>
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
                previewBox.innerHTML = '<span>📷 Upload Image</span>';
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
            editPreview.innerHTML = imagePath ? `<img src="/storage/${imagePath}" alt="Product">` : '<span>📷 Upload Image</span>';
            editModal.style.display = 'flex';
        }

        closeEditModalBtn.addEventListener('click', () => editModal.style.display = 'none');
        editModal.addEventListener('click', (e) => { if (e.target === editModal) editModal.style.display = 'none'; });
    </script>
</x-app-layout>