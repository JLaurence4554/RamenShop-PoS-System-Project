<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employee Attendance') }}
        </h2>
    </x-slot>

    <style>
        /* Layout and Page Structure */
            .page-header {
                font-weight: 600;
                font-size: 1.25rem;
                color: #1f2937;
            }

            .page-container {
                padding: 3rem 0;
                max-width: 1120px;
                margin: 0 auto;
            }

            /* Alert Styles */
            .alert {
                margin-bottom: 1rem;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                border: 1px solid transparent;
            }

            .alert-success {
                background-color: #d1fae5;
                border-color: #34d399;
                color: #065f46;
            }

            /* Cards */
            .card {
                background: #ffffff;
                border-radius: 0.5rem;
                box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.05), 0 2px 6px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                margin-bottom: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            /* Forms */
            .employee-form {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .employee-form input {
                border: 1px solid #d1d5db;
                padding: 0.5rem;
                border-radius: 0.375rem;
                flex: 1 1 30%;
            }

            .btn {
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 0.375rem;
                cursor: pointer;
                font-weight: 500;
            }

            .btn-primary {
                background-color: #3b82f6;
                color: white;
            }

            .btn-primary:hover {
                background-color: #2563eb;
            }

            .btn-success {
                background-color: #22c55e;
                color: white;
            }

            .btn-success:hover {
                background-color: #16a34a;
            }

            /* Table */
            .employee-table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #d1d5db;
            }

            .employee-table th,
            .employee-table td {
                border: 1px solid #d1d5db;
                padding: 0.5rem;
                text-align: left;
            }

            .employee-table tr:hover {
                background-color: #f9fafb;
            }

            /* Inner Shadow Example */
            .form-card {
                box-shadow: inset 4px 4px 10px rgba(0,0,0,0.1);
            }

    </style>

    <div class="page-container">

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <strong>Success!</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Add Employee Form -->
        <div class="card form-card">
            <form action="{{ route('employees.store') }}" method="POST" class="employee-form">
                @csrf
                <input type="text" name="name" placeholder="Employee Name" required>
                <input type="text" name="position" placeholder="Position">
                <button type="submit" class="btn btn-primary">Add Employee</button>
            </form>
        </div>

        <!-- Employee Table -->
        <div class="card">
            <div class="card-body">
                <table class="employee-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Status Today</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                <td>{{ $employee->todayAttendance->status ?? 'absent' }}</td>
                                <td>
                                    <form action="{{ route('employees.attendance', $employee) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            Mark Attendance
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
