<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category = Category::create($validated);

            return response()->json([
                'message' => 'Kategori berhasil ditambahkan!!',
                'data' => $category,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah kategori', [
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    public function show(int $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Category retrieved successfully',
            'data' => $category
        ], 200);
    }

    public function update(Request $request, int $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category->update($validated);

            return response()->json([
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat update category', [
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $category->delete();

            return response()->json([
                'message' => 'Kategori berhasil dihapus!!',
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus category', [
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
}
