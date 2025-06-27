<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        // $listProducts = Product::orderBy('name', 'asc')->where('stock', '>', 0)->get();
        // return view('products.index', [
        //     'listProducts' => $listProducts,
        // ]);
    }
    public function newProduct()
    {
        $lastProducts = Product::orderBy('id', 'asc')->take(5)->get();
        $bestSelling = $this->bestSellingProducts();
        return view('products.index', [
            'lastProducts' => $lastProducts,
            'bestSelling' => $bestSelling,
        ]);
    }
    public function bestSellingProducts()
    {
        $bestSelling = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return $bestSelling;
    }
    public function create()
    {
        //
        return view('products.form', ['mode' => 'add']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images/products', 'public')
            : 'images/products/dummy.png';

        $adminId = Auth::user()->id;
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'admin_id' => $adminId,
        ]);

        return redirect()->route('home')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
        return view('products.form', [
            'product' => $product,
            'mode' => 'edit',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        Product::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->hasFile('image')
                ? $request->file('image')->store('images/products', 'public')
                : Product::find($id)->image,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        return redirect()->route('home');
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }
        $product->delete();
        return redirect()->route('products.manage');
    }


    public function ajaxList(Request $request)
    {
        $filter = $request->query('filter');

        if ($filter === 'low') {
            $query = Product::query()->orderBy('price', 'asc')->where('stock', '>', 0);
        } else if ($filter === 'high') {
            $query = Product::query()->orderBy('price', 'desc')->where('stock', '>', 0);
        } else if ($filter === 'asc') {
            $query = Product::query()->orderBy('name', 'asc')->where('stock', '>', 0);
        } else if ($filter === 'desc') {
            $query = Product::query()->orderBy('name', 'desc')->where('stock', '>', 0);
        } else {
            $query = Product::query()->orderBy('id', 'asc')->where('stock', '>', 0);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower($request->search);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
        }

        $products = $query->paginate(15);

        $products->getCollection()->transform(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'stock' => $product->stock,
                'price' => number_format($product->price, 0, ',', '.'),
                'image_url' => asset('storage/' . $product->image),
            ];
        });

        return response()->json([
            'products' => $products->items(),
            'pagination' => (string) $products->appends([
                'search' => $request->search,
                'filter' => $filter
            ])->links(),
        ]);
    }

    public function apiShow($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }
    public function manage(Request $request) {
    $query = Product::query();
    if ($request->filled('search')) {
        $query->where('name', 'ILIKE', '%' . $request->search . '%'); // ILIKE untuk PostgreSQL case-insensitive
    }

    $sort = $request->get('sort', 'name');
    $order = $request->get('order', 'asc');
    if (in_array($sort, ['name', 'price', 'stock']) && in_array($order, ['asc', 'desc'])) {
        $query->orderBy($sort, $order);
    }

    $products = $query->paginate(10)->withQueryString();

    return view('admin.manageproduct', compact('products'));
    }
}
