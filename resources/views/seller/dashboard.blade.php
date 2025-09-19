<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
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
                <h1>Good Morning, {{ Auth::user()->name }}!</h1>
                <p>{{ \Carbon\Carbon::now()->format('l, F j, Y H:i') }}</p>
            </header>

            <section class="stats">
                <div class="card">
                    <h3>Total Services</h3>
                    <p>{{ Auth::user()->services()->count() }}</p>
                </div>
                <div class="card">
                    <h3>Pending Bookings</h3>
                    <p>{{ \App\Models\Booking::whereHas('service', function($q){
                        $q->where('seller_id', Auth::id());
                    })->where('status', 'pending')->count() }}</p>
                </div>
            </section>

            <section class="quick-links">
                <h2>Quick Actions</h2>
                <div class="links">
                    <a href="{{ route('seller.services') }}">Manage Services</a>
                    <a href="{{ route('seller.bookings') }}">View Bookings</a>
                    <a href="{{ route('seller.messages') }}">Messages</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
