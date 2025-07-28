<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Dictionary::getCategories();
        $selectedCategory = $request->get('category', array_key_first($categories));
        
        $query = Dictionary::byCategory($selectedCategory)->orderBy('sort_order')->orderBy('value');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $dictionaries = $query->paginate(20)->appends($request->query());
        
        return view('admin.dictionaries.index', compact('dictionaries', 'categories', 'selectedCategory'));
    }

    public function create(Request $request)
    {
        $categories = Dictionary::getCategories();
        $selectedCategory = $request->get('category', array_key_first($categories));
        
        return view('admin.dictionaries.create', compact('categories', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'category.required' => 'Kategoria jest wymagana',
            'key.required' => 'Klucz jest wymagany',
            'value.required' => 'Wartość jest wymagana',
        ]);

        // Check for uniqueness
        $exists = Dictionary::where('category', $request->category)
                           ->where('key', $request->key)
                           ->exists();
        
        if ($exists) {
            return back()->withErrors(['key' => 'Taki klucz już istnieje w tej kategorii'])->withInput();
        }

        Dictionary::create([
            'category' => $request->category,
            'key' => $request->key,
            'value' => $request->value,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'is_system' => false,
        ]);

        return redirect()->route('admin.dictionaries.index', ['category' => $request->category])
                         ->with('success', 'Element słownika został dodany pomyślnie.');
    }

    public function show(Dictionary $dictionary)
    {
        return view('admin.dictionaries.show', compact('dictionary'));
    }

    public function edit(Dictionary $dictionary)
    {
        $categories = Dictionary::getCategories();
        
        return view('admin.dictionaries.edit', compact('dictionary', 'categories'));
    }

    public function update(Request $request, Dictionary $dictionary)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'category.required' => 'Kategoria jest wymagana',
            'key.required' => 'Klucz jest wymagany',
            'value.required' => 'Wartość jest wymagana',
        ]);

        // Check for uniqueness (excluding current record)
        $exists = Dictionary::where('category', $request->category)
                           ->where('key', $request->key)
                           ->where('id', '!=', $dictionary->id)
                           ->exists();
        
        if ($exists) {
            return back()->withErrors(['key' => 'Taki klucz już istnieje w tej kategorii'])->withInput();
        }

        $dictionary->update([
            'category' => $request->category,
            'key' => $request->key,
            'value' => $request->value,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.dictionaries.index', ['category' => $dictionary->category])
                         ->with('success', 'Element słownika został zaktualizowany pomyślnie.');
    }

    public function destroy(Dictionary $dictionary)
    {
        if ($dictionary->is_system) {
            return back()->with('error', 'Nie można usunąć systemowego elementu słownika.');
        }

        $category = $dictionary->category;
        $dictionary->delete();

        return redirect()->route('admin.dictionaries.index', ['category' => $category])
                         ->with('success', 'Element słownika został usunięty pomyślnie.');
    }

    public function updateSort(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:dictionaries,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            Dictionary::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}