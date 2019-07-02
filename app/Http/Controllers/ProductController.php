<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProductController extends Controller {

    /**
     * check_create()
     * criterios de validación para la función create()
     * @param Request $request
     */
    public function check_create(Request $request) {
        $alphabetic = "/^[a-z ]*$/i";
        $float = "/^\d{1,6}(\.\d{1,2})?$/";
        //"/^\d{1,6}(\.\d{1,2})?$/"o"/^[0-9]+(\.[0-9]{1,2})?/"
        $numeric = "/^[0-9]*$/";
        //$postcode= "/^[0-9]{5}$/";

        $request->validate([
            'name' => "required|regex:$alphabetic|min:1|max:50",
            'price' => "required|regex:$float|min:0|max:99999",
            'description' => "nullable|string|max:100",
        ]);
    }

    /**
     * listAll()
     * lista todos los productos
     * @return type
     */
    public function listAll() {
        //echo 'listAll';        
        $arrProd = Product::all();
        //dd($arrProd);//para ver q da. Seria como un var_dump
        $message = count($arrProd) . " products found";

        return view('product.list', array('arrProd' => $arrProd, 'message' => $message)); //pasamos a un array los valores q queremos mostrar            
    }

    /**
     * create()
     * crea un nuevo producto
     * @param Request $request
     * @return type
     */
    public function create(Request $request) { //Request $request: para coger los datos del formulario
        $this->check_create($request);

        try {
            //para todos los campos
            Product::create($request->all()); //para crear los campos de producto
            $message = "Data created successfully";
            
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $message = "Name already exists";
            } else {
                $message = 'No data created' . $e->getCode();
            }
        }
        return view('product.create', ['message' => $message]);
    }

    /**
     * check_find()
     * criterios de validación para la función find()
     * @param Request $request
     */
    public function check_find(Request $request) {
        $alphabetic = "/^[a-z ]*$/i";
        
        $request->validate([
            'id' => "nullable|numeric",
            'name' => "nullable|regex:$alphabetic",
        ]);
    }

    /**
     * find()
     * busca un producto por nombre o por id
     * @param Request $request
     * @return type
     */
    public function find(Request $request) {
        //$message=NULL;
        $this->check_find($request);
        try {
            if (!empty($request->id)) {
               
                $objProd = Product::findOrFail($request->id);
                //vamos a edit
                //return redirect()->to('/product/edit/' . $request->id);
                return view('product.edit')->with('objProd', $objProd);
            } else {
                
                $column = 'name';
                $objProd = Product::where($column, "=", $request->name)->first();
                if ($objProd != null) {
                    return view('product.edit')->with('objProd', $objProd);
                    //return redirect()->to('/product/edit/' . $request->id);
                } else {
                    $message = "No data found";
                }
            }
        } catch (\Exception $e) {
            $message = 'No data found' . $e->getMessage();
        }
        return view('product.find', ['id' => $request->id, 'message' => $message]);
    }

    /**
     * edit()
     * llevará al formulario de editar según id
     * @param type $id
     * @return type
     */
    public function edit($id) {

        try {
            $objProd = Product::findOrFail($id); //buscamos objeto

            $message = Session::get('message_update');

            return view('product.edit', ['objProd' => $objProd, 'message' => $message]); //retornamos vista
        } catch (\Exception $e) {
            $message = 'No data found' . $e->getMessage();
        }
        return redirect()->to('fallback');
    }

    /**
     * modify()
     * según la acción que reciba, irá a la función update() o delete()
     * @param Request $request
     * @return type
     */
    public function modify(Request $request) {
        switch ($request->action) {
            case "update":
                return $this->update($request);
            case "delete":
                return $this->delete($request);
        }
    }

    /**
     * check_update()
     * criterios de validación para la función update()
     * @param Request $request
     */
    public function check_update(Request $request) {
        $alphabetic = "/^[a-z ]*$/i";
        $float = "/^[0-9]+(\.[0-9]{1,2})?/";
        //$numeric= "/^[0-9]*$/";
        //$postcode= "/^[0-9]{5}$/";

        $request->validate([
            'name' => "required|regex:$alphabetic|min:1|max:50",
            'price' => "required|regex:$float|min:0|max:99999",
            'description' => "nullable|string|max:100",
        ]);
    }

    /**
     * update()
     * modifica el producto seleccionado
     * @param type $request
     * @return type
     */
    public function update($request) {

        $this->check_update($request);

        try {
            
            $objProd = Product::findOrFail($request->id);

            $objProd->update($request->all()); //hace un update de todos los datos del objeto

            $message = "Data updated successfully";

            //para volver a atrás
            //return redirect()->back()->with(['message_update' => $message]);
            return view('product.edit', ['objProd' => $objProd, 'message' => $message]);
        } catch (\Exception $e) {
            $message = 'No data updated - ' . $e->getMessage();
        }
        return view('product.edit', ['objProd' => $objProd, 'message' => $message]);
    }

    /**
     * delete()
     * elimina el producto seleccionado
     * @param type $request
     * @return type
     */
    public function delete($request) {
        try {
            $objProd = Product::findOrFail($request->id);

            $objProd->delete(); //hace un update de todos los datos del objeto

            $message = "Data deleted successfully";

            //para volver a atrás
            return view('product.find', ['message' => $message]);
            //return redirect()->to('/product/list'); Si quieres que vuelva al list all
        } catch (\Exception $e) {
            $message = 'No data deleted - ' . $e->getMessage();
        }
        return view('product.edit', ['objProd' => $objProd, 'message' => $message]);
    }

}
