<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Services</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Barangay Services</h2>
            <ul>
                <li><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('seller.services') }}">My Services</a></li>
                <li><a href="{{ route('seller.bookings') }}">Bookings</a></li>
                <li><a href="{{ route('seller.messages') }}">Messages</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main content -->
        <main class="main-content">
            <header>
                <h1>My Services</h1>
            </header>

            <!-- Add Service Form -->
            <section class="add-service">
                <h2>Add New Service</h2>
                <form action="{{ route('service.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="name" placeholder="Service Name" required>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <input type="text" name="location" placeholder="Location" required>
                    <input type="number" name="price" placeholder="Price (optional)">
                    <input type="text" name="category" placeholder="Category" required>
                    <input type="file" name="image" accept="image/*">
                    <button type="submit">Add Service</button>
                </form>
            </section>

            <!-- List of Services -->
            <section class="services-list">
                <h2>My Services</h2>
                @foreach($services as $service)
                <div class="service-card">
                    <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->name }}">
                    <div class="service-info">
                        <h3>{{ $service->name }}</h3>
                        <p>{{ $service->description }}</p>
                        <p><strong>Location:</strong> {{ $service->location }}</p>
                        @if($service->price)
                        <p><strong>Price:</strong> ₱{{ number_format($service->price, 2) }}</p>
                        @endif
                        <p><strong>Category:</strong> {{ $service->category }}</p>

                        <form action="{{ route('service.update', $service->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 10px;">
                            @csrf
                            <input type="text" name="name" value="{{ $service->name }}" required>
                            <input type="text" name="location" value="{{ $service->location }}" required>
                            <input type="number" name="price" value="{{ $service->price }}">
                            <input type="text" name="category" value="{{ $service->category }}" required>
                            <input type="file" name="image" accept="image/*">
                            <button type="submit">Update</button>
                        </form>

                        <form action="{{ route('service.delete', $service->id) }}" method="POST" style="margin-top: 5px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </section>
        </main>
    </div>
</body>
</html>
