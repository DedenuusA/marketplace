<?php

namespace App\Http\Controllers;

use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class ReviewController extends Controller
{
  public function store(Request $request)
{
    $validatedData = $request->validate([
        'order_item_id' => 'required',
        'product_id' => 'required',
        'order_id' => 'required',
        'user_id' => 'required',
        'customer_id' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string',
    ]);

    $existingReview = Review::where('order_item_id', $request->order_item_id)->first();

    if ($existingReview) {
        // Jika review sudah ada, lakukan update
        $existingReview->update($validatedData);
        return response()->json([
            'message' => 'Review successfully updated.',
            'rating' => $request->rating,
        ]);
    } else {
        // Jika tidak ada review, tambahkan review baru
        Review::create($validatedData);
        return response()->json([
            'message' => 'Review successfully saved.',
            'rating' => $request->rating,
        ]);
    }
}


public function edit($order_item_id)
{
    $review = Review::where('order_item_id', $order_item_id)->first();
    
    if ($review) {
        return response()->json($review);
    }

    return response()->json(['message' => 'Review not found.'], 404);
}

public function update(Request $request)
{
    $validatedData = $request->validate([
        'order_item_id' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string',
    ]);

    $review = Review::where('order_item_id', $request->order_item_id)->first();
    if ($review) {
        $review->update($validatedData);
        return response()->json(['message' => 'Review successfully updated.', 'rating' => $request->rating,]);
    }

    return response()->json(['message' => 'Review not found.'], 404);
}

public function getRating($order_item_id)
{
    // Mengambil review untuk order item tertentu
    $review = Review::where('order_item_id', $order_item_id)->first();

    if ($review) {
        return response()->json([
            'rating' => $review->rating, // Mengembalikan rating
        ]);
    }

    return response()->json([
        'rating' => 0, // Jika tidak ada review, kembalikan rating 0
    ]);
}


}
