<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourierRequest;
use App\Http\Requests\UpdateCourierRequest;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Courier::query();

        // Filter by level (comma-separated)
        $query->when($request->filled('level'), function ($q) use ($request) {
            $levels = explode(',', $request->query('level'));
            $q->whereIn('level', $levels);
        });

        // Search by multi-word name match
        $query->when($request->filled('search'), function ($q) use ($request) {
            $words = array_filter(explode(' ', $request->query('search')));
            foreach ($words as $word) {
                $q->where('name', 'like', "%{$word}%");
            }
        });

        // Sorting
        if ($request->filled('sort_by') && $request->query('sort_by') === 'created_at') {
            $query->orderBy('created_at', $request->query('order', 'desc'));
        } else {
            $query->orderBy('name', 'asc');
        }

        // Pagination
        return $query->paginate($request->query('per_page', 15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourierRequest $request)
    {
        $courier = Courier::create($request->validated());

        return response()->json($courier, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        return response()->json($courier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourierRequest $request, Courier $courier)
    {
        $courier->update($request->validated());

        return response()->json($courier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        $courier->delete();

        return response()->json(null, 204);
    }
}
