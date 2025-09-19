<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Reviews - Barangay Services</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
        }

        h2 {
            margin-bottom: 20px;
            color: #1f2937;
        }

        .review-card {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }

        .review-card h4 {
            margin-bottom: 5px;
            font-size: 16px;
            color: #1f2937;
        }

        .review-card .rating {
            color: #fbbf24; /* gold stars */
            font-weight: bold;
        }

        .review-card p {
            font-size: 14px;
            color: #4b5563;
        }

        .review-form {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .review-form textarea,
        .review-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .review-form button {
            padding: 10px 20px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .review-form button:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reviews for {{ $service->name }}</h2>

        @if($reviews->isEmpty())
            <p>No reviews yet.</p>
        @else
            @foreach($reviews as $review)
                <div class="review-card">
                    <h4>{{ $review->buyer->name }} 
                        <span class="rating">
                            @for($i=0; $i < $review->rating; $i++) ★ @endfor
                        </span>
                    </h4>
                    @if($review->comment)
                        <p>{{ $review->comment }}</p>
                    @endif
                    <div class="timestamp">{{ $review->created_at->format('M d, Y H:i') }}</div>
                </div>
            @endforeach
        @endif

        @if(Auth::user()->role == 'buyer')
        <div class="review-form">
            <h3>Leave a Review</h3>
            <form action="{{ route('review.store', $booking->id ?? 0) }}" method="POST">
                @csrf
                <label for="rating">Rating:</label>
                <select name="rating" required>
                    <option value="">Select Rating</option>
                    <option value="1">1 ★</option>
                    <option value="2">2 ★★</option>
                    <option value="3">3 ★★★</option>
                    <option value="4">4 ★★★★</option>
                    <option value="5">5 ★★★★★</option>
                </select>

                <label for="comment">Comment (optional):</label>
                <textarea name="comment" rows="3" placeholder="Write your feedback..."></textarea>

                <button type="submit">Submit Review</button>
            </form>
        </div>
        @endif
    </div>
</body>
</html>
