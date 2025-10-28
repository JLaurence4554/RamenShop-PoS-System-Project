<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <style>
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
            width: 400px;
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #111827;
            text-align: center;
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
    </style>

    <div class="container">
        <div class="header-line"></div>

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
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <button 
                                    class="button" 
                                    style="background-color: #28a745;"
                                    onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->description) }}', {{ $product->price }})">
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
            <form method="POST" action="{{ route('product.store') }}">
                @csrf
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div>
                    <label for="price">Price:</label>
                    <input type="number" step="0.01" id="price" name="price" required>
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
            <form method="POST" id="editForm">
                @csrf
                @method('put')
                <div>
                    <label for="editName">Name:</label>
                    <input type="text" id="editName" name="name" required>
                </div>
                <div>
                    <label for="editDescription">Description:</label>
                    <textarea id="editDescription" name="description" required></textarea>
                </div>
                <div>
                    <label for="editPrice">Price:</label>
                    <input type="number" step="0.01" id="editPrice" name="price" required>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-success">Update</button>
                    <button type="button" class="btn-cancel" id="closeEditModalBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // CREATE MODAL
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalOverlay = document.getElementById('modalOverlay');

        openModalBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'none';
        });

        modalOverlay.addEventListener('click', (event) => {
            if (event.target === modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        });

        // EDIT MODAL
        const editModal = document.getElementById('editModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editForm = document.getElementById('editForm');
        const editName = document.getElementById('editName');
        const editDescription = document.getElementById('editDescription');
        const editPrice = document.getElementById('editPrice');

        function openEditModal(id, name, description, price) {
            editForm.action = `/product/${id}/update`;
            editName.value = name;
            editDescription.value = description;
            editPrice.value = price;
            editModal.style.display = 'flex';
        }

        closeEditModalBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });

        editModal.addEventListener('click', (event) => {
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        });
    </script>
</x-app-layout>

