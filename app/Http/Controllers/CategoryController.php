<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-category');

        $categories = Category::withCount('products')->get();

        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-category');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        try {
            Category::create($validated);

            return redirect()
                ->route('category.index')
                ->with('success', 'Category created successfully.');
        } catch (QueryException $e) {
            Log::error('Category store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating category.');
        }
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name,' . $category->id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        try {
            $category->update($validated);

            return redirect()
                ->route('category.index')
                ->with('success', 'Category updated successfully.');
        } catch (QueryException $e) {
            Log::error('Category update database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while updating category.');
        }
    }

    public function delete($id)
    {
        Gate::authorize('manage-category');

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category berhasil dihapus.');
    }
}
