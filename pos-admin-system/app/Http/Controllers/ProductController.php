<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\Project;
use App\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Project $project)
    {
        $products = Product::getProducts($project->id, $request->search ?? '');

        return view('projects.products.index', compact('project', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('projects.products.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        dd($request->menus);

        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|max:1000',
            'content' => 'nullable|max:2000',
            'code' => 'nullable|string|max:30',
            'priority' => 'required|integer|gt:0|lt:1000',
            'price' => 'nullable|decimal:0,2|gte:0',
            'sale_price' => 'nullable|decimal:0,2|gte:0|lte:price',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|boolean',
            'categories' => 'required|array',
            'categories.*' => 'required|string|exists:product_categories,id',
            'variations' => 'nullable|array',
            'variations.*' => 'required|string|exists:product_attributes,id',
        ]);

        foreach ($request->categories as $categoryId) {
            if (!ProductCategory::getCategoryWithProject($categoryId, $project->id)) {
                return back()->withInput()->withErrors(['categories' => __('validation.exists', ['attribute' => __('validation.attributes.product_category')])]);
            }
        }

        if ($request->variations) {
            foreach ($request->variations as $attributeId) {
                if (!ProductAttribute::getAttributeWithProject($attributeId, $project->id)) {
                    return back()->withInput()->withErrors(['variations' => __('validation.exists', ['attribute' => __('validation.attributes.product_attribute')])]);
                }
            }
        }

        $product = $project->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'content' => $request->content,
            'code' => $request->code,
            'priority' => $request->priority,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'status' => $request->status,
        ]);

        if ($request->has('image')) {
            $imageUrl = $this->uploadImage($request->file('image'), $project);
            $product->image = $imageUrl;
        }

        $product->categories()->sync($request->categories);
        if ($request->variations) {
            $product->withAttributeSets()->sync(ProductAttribute::getAttributeSetIdsFromAttributes($request->variations));

            $combinations = ProductAttribute::getCombinations($request->variations);
            foreach ($combinations as $attributeIds) {
                $variation = $product->replicate();
                $variation->variation_flg = true;
                $variation->parent_product_id = $product->id;
                $variation->save();

                $variation->withAttributes()->sync($attributeIds);
                $variation->save();
            }
        }

        $product->save();

        return redirect()->route('projects.products.edit', [$project, $product])
            ->with('success', 'Product is created successfully.');;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Product $product)
    {
        return view('projects.products.edit', compact('project', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|max:1000',
            'content' => 'nullable|max:2000',
            'code' => 'nullable|string|max:30',
            'priority' => 'required|integer|gt:0|lt:1000',
            'price' => 'nullable|decimal:0,2|gte:0',
            'sale_price' => 'nullable|decimal:0,2|gte:0|lte:price',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|boolean',
            'categories' => 'required|array',
            'categories.*' => 'required|string|exists:product_categories,id',
            'variations' => 'nullable|array',
            'variations.*' => 'required|string|exists:product_attributes,id',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uploadImage($file, Project $project)
    {
        // Create a folder using the project ID
        $folderPath = storage_path('app/public/projects/' . $project->id);

        // Check if the folder exists, create it if not
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true); // Recursive creation with permissions
        }

        // Ensure the folder permissions are set correctly
        chmod($folderPath, 0755);

        // Generate a unique name for the image
        $imageName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Store the file
        $filePath = $file->storeAs('projects/' . $project->id, $imageName, 'public');

        // Return the URL for saving in the database
        $fileUrl = Storage::url($filePath);
        return $fileUrl;
    }
}
