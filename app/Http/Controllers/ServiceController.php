<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Review;

class ServiceController extends Controller
{
    // Browse services with search/filter
    public function browse(Request $request)
    {
        $query = Service::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->has('min_rating') && $request->min_rating != '') {
            $query->whereHas('reviews', function($q) use ($request) {
                $q->groupBy('service_id')
                  ->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }

        $services = $query->get();

        // Get distinct categories and locations for filters
        $categories = Service::distinct()->pluck('category');
        $locations = Service::distinct()->pluck('location');

        return view('buyer.browse_services', compact('services', 'categories', 'locations'));
    }
}
