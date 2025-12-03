<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Precio;
use App\Models\Tipodeprecio;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product = Producto::with(['marca', 'precios.tipodeprecio'])->get();
        //dd($product);
        return view('productos.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = producto::all();
        $brands = marca::all();
        return view('productos.create', compact('products', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'cantidad' => 'nullable|integer',
            'marca_id' => 'nullable|exists:marcas,id',

            'preciodecompra' => 'nullable|numeric',
            'precioventamayor' => 'nullable|numeric',
            'preciotecnico' => 'nullable|numeric',
            'psf' => 'nullable|numeric',
            'ps' => 'nullable|numeric',
        ]);

        // 1. Crear el producto
        $producto = Producto::create([
            'descripcion' => $request->descripcion,
            'modelo' => $request->modelo ?? '',
            'cantidad' => $request->cantidad ?? 0,
            'marca_id' => $request->marca_id, // corregido aquí
        ]);

    /*
        // 2. Crear el precio (como es solo clave foránea, se crea vacío)
        $precio = $producto->precios()->create([
        'producto_id' => $producto->id
        ]);


        // 3. Crear el tipo de precio asociado
        $precio->tipodeprecio()->create([
            'preciodecompra' => $request->preciodecompra,
            'precioventamayor' => $request->precioventamayor,
            'preciotecnico' => $request->preciotecnico,
            'psf' => $request->psf,
            'ps' => $request->ps,
        ]);
    */
        $precio = $producto->precios()->create([]);

        if ($request->preciodecompra || $request->precioventamayor || $request->preciotecnico || $request->psf || $request->ps) {
            $precio->tipodeprecio()->create([
                'preciodecompra' => $request->preciodecompra ?? 0,
                'precioventamayor' => $request->precioventamayor ?? 0,
                'preciotecnico' => $request->preciotecnico ?? 0,
                'psf' => $request->psf ?? 0,
                'ps' => $request->ps ?? 0,
            ]);
        }

        return redirect()->route('producto.index')->with('success', 'Producto creado correctamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $producto = Producto::with(['marca', 'precios.tipodeprecio'])->findOrFail($id);
        $brands = marca::all(); // Para el select de marcas

        return view('productos.edit', compact('producto', 'brands'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'cantidad' => 'nullable|integer',
            'marca_id' => 'nullable|exists:marcas,id',

            'preciodecompra' => 'nullable|numeric',
            'precioventamayor' => 'nullable|numeric',
            'preciotecnico' => 'nullable|numeric',
            'psf' => 'nullable|numeric',
            'ps' => 'nullable|numeric',
        ]);

        // Actualizar producto
        $producto = Producto::with(['precios.tipodeprecio'])->findOrFail($id);
        $producto->update([
            'descripcion' => $request->descripcion,
            'modelo' => $request->modelo,
            'cantidad' => $request->cantidad,
            'marca_id' => $request->marca_id,
        ]);

        // Obtener o crear precio
        $precio = $producto->precios()->first();
        if (!$precio) {
            $precio = $producto->precios()->create([]);
        }

        // Actualizar o crear tipodeprecio
        if ($request->preciodecompra || $request->precioventamayor || $request->preciotecnico || $request->psf || $request->ps) {
            $tipo = $precio->tipodeprecio()->first();
            if ($tipo) {
                $tipo->update([
                    'preciodecompra' => $request->preciodecompra ?? 0,
                    'precioventamayor' => $request->precioventamayor ?? 0,
                    'preciotecnico' => $request->preciotecnico ?? 0,
                    'psf' => $request->psf ?? 0,
                    'ps' => $request->ps ?? 0,
                ]);
            } else {
                $precio->tipodeprecio()->create([
                    'preciodecompra' => $request->preciodecompra ?? 0,
                    'precioventamayor' => $request->precioventamayor ?? 0,
                    'preciotecnico' => $request->preciotecnico ?? 0,
                    'psf' => $request->psf ?? 0,
                    'ps' => $request->ps ?? 0,
                ]);
            }
        }

        return redirect()->route('producto.index')->with('success', 'Producto actualizado correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $producto = producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('producto.index')->with('success', 'Producto eliminado correctamente');
    }
}
