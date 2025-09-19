<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Services</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Barangay Services</h2>
            <ul>
                <li><a href="{{ route('buyer.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('buyer.services') }}">Browse Services</a></li>
                <li><a href="{{ route('buyer.bookings') }}">My Bookings</a></li>
                <li><a href="{{ route('messages') }}">Messages</a></li>
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
                <h1>Available Services</h1>
            </header>

            <!-- Filter Form -->
            <section class="filter-section">
                <form action="{{ route('buyer.services') }}" method="GET" class="filter-form">
                    <input type="text" name="search" placeholder="Search services..." value="{{ request('search') }}">
                    
                    <select name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>

                    <select name="location">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                        @endforeach
                    </select>

                    <input type="number" name="min_rating" placeholder="Minimum Rating" min="1" max="5" value="{{ request('min_rating') }}">
                    <button type="submit">Filter</button>
                </form>
            </section>

            <!-- Services List -->
            <section class="services-list">
                @forelse($services as $service)
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

                            <!-- Average Rating -->
                            @php
                                $avgRating = $service->averageRating() ?? 0;
                            @endphp
                            <p><strong>Rating:</strong>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($avgRating))
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                ({{ number_format($avgRating, 1) }})
                            </p>

                            <form action="{{ route('service.request', $service->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-book">Request Service</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No services found.</p>
                @endforelse
            </section>
        </main>
    </div>
</body>
</html>
