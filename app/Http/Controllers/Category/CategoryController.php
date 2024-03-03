<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //VALIDAR LOS DATOS
        $category = $request->validated();
        $category['slug'] = $this->createSlug($category['name']);
        //GUARDAR EL REQUEST VALIDADO
        Category::create($category);
        //RETORNAR MENSAJE DE GUARDADO
        return response()->json([
            'message' => 'La categoría fue registrada exitosamente...!!!',
            'category' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        $category = Category::where('id', $term)
            ->orWhere('slug', $term)
            ->get();

        // VALIDAD DE QUE EXISTA LA CATEGORIA
        if (count($category) == 0) {
            return response()->json([
                'message' => 'No se encontró la categoría',
            ], 404);
        }

        return response()->json([
            "category" => $category[0]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //BUSCANDO LA CATEGORIA
        $category = Category::find($id);
        //VALIDADNO LA CATEGORIA
        if(!$category){
            return response()->json([
                'message' => 'No se encontró la categoría',
            ], 404);
        }
        //SI HAY NUEVO NOMBRE, ACTUALIZAR EL SLUG
        if ($request['name']) {
            $request['slug'] = $this->createSlug($request['name']);
        }
        //GUARDANDO EL REGISTRO
        $category->update($request->all());
        //RETORNANDO RESPUESTA
        return response()->json([
            'message' => 'La categoría fue actualizada exitosamente...!!!',
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //BUSCANDO LA CATEGORIA
        $category = Category::find($id);
        //VALIDADNO LA CATEGORIA
        if(!$category){
            return response()->json([
                'message' => 'No se encontró la categoría',
            ], 404);
        }

        $category->delete();
        //RETORNANDO RESPUESTA
        return response()->json([
            'message' => 'La categoría fue eliminada..!!!',
            'category' => $category
        ], 200);

    }

    /* FUNCION PRIVADA PARA aslug*/
    private function createSlug(string $text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        $text = preg_replace('/-+/', '-', $text);

        return $text;
    }
}
