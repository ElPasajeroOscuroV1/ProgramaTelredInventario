<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('cliente', 'user')->get();
        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::with('precios.tipodeprecio')->get();
        return view('cotizaciones.create', compact('productos', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'nuevo_cliente.nombre' => 'nullable|string|required_without:cliente_id',
            'nuevo_cliente.tipo' => 'nullable|string|in:tecnico,normal|required_with:nuevo_cliente.nombre',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            $clienteId = $request->cliente_id;

            // Si se está creando un nuevo cliente
            if (!empty($request->input('nuevo_cliente.nombre'))) {
                $tipoCliente = $request->input('nuevo_cliente.tipo');
                $codigo = $this->generarCodigoUnico($tipoCliente === 'tecnico' ? 5 : 7);

                $nuevoCliente = Cliente::create([
                    'nombre' => $request->input('nuevo_cliente.nombre'),
                    'direccion' => $request->input('nuevo_cliente.direccion') ?? '',
                    'telefono' => $request->input('nuevo_cliente.telefono') ?? '',
                    'tipo' => $tipoCliente,
                    'codigo' => $codigo,
                ]);

                $clienteId = $nuevoCliente->id;
            }

            // Crear cotización
            $cotizacion = Cotizacion::create([
                'cliente_id' => $clienteId,
                'user_id' => auth()->id(),
                'fecha' => now(),
                'estado' => 'pendiente',
                'total' => 0,
            ]);

            foreach ($request->productos as $data) {
                $productoId = $data['producto_id'];
                $subtotal = $data['precio'] * $data['cantidad'];
                $total += $subtotal;

                $cotizacion->productos()->attach($productoId, [
                    'cantidad' => $data['cantidad'],
                    'precio_unitario' => $data['precio'],
                ]);
            }

            $cotizacion->update(['total' => $total]);

            DB::commit();
            return redirect()->route('cotizaciones.index')->with('success', 'Cotización guardada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al guardar: ' . $e->getMessage());
        }
    }

    private function generarCodigoUnico(int $length): string
    {
        do {
            $codigo = '';
            for ($i = 0; $i < $length; $i++) {
                $codigo .= mt_rand(0, 9);
            }
        } while (Cliente::where('codigo', $codigo)->exists());

        return $codigo;
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['cliente', 'user', 'productos.precios.tipodeprecio']);
        return view('cotizaciones.show', compact('cotizacion'));
    }

    public function edit(Cotizacion $cotizacion)
    {
        $clientes = Cliente::all();
        return view('cotizaciones.edit', compact('cotizacion', 'clientes'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'estado' => 'required|string',
        ]);

        $cotizacion->update([
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
        ]);

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización actualizada correctamente.');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->productos()->detach();
        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada.');
    }

    public function aplicarDescuento(Request $request, $id)
    {
        $request->validate([
            'total_con_descuento' => 'required|numeric|min:0',
            'porcentaje' => 'nullable|numeric|min:0|max:100',
        ]);

        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->update([
            'total_con_descuento' => $request->input('total_con_descuento'),
            'porcentaje_descuento' => $request->input('porcentaje'),
        ]);

        return redirect()->route('cotizaciones.show', $cotizacion->id)
            ->with('success', 'Descuento aplicado y guardado correctamente.');
    }


}
