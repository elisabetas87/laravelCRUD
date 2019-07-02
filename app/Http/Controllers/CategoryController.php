<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CategoryController extends Controller {

    /**
     * check_create()
     * criterios de validación para la función create()
     * @param Request $request
     */
    public function check_create(Request $request) {
        $alphabetic = "/^[a-z ]*$/i";
        //$numeric= "/^[0-9]*$/";
        //$postcode= "/^[0-9]{5}$/";

        $request->validate([
            'name' => "required|unique:categories|regex:$alphabetic|min:1|max:50",
            'description' => "nullable|string|max:100",
        ]);
    }

    /**
     * listAll()
     * lista todas las categorías
     * @return type
     */
    public function listAll() {
        //echo 'listAll';        
        $arrCat = Category::all();

        //$arrCat = Category::where("id",">","3")->get();
        //$arrCat = Category::where("id",">","3")->orderBy('name')->get();         
        //$arrCat = Category::take("5")->get();     
        //$arrCat = Category::where("name","like","%name%")->get();
        //dd($arrCat);//para ver qué da. Seria como un var_dump
        $message = count($arrCat) . " categories found";

        return view('category.list', array('arrCategory' => $arrCat, 'message' => $message)); //pasamos a un array los valores q queremos mostrar            
    }

    /**
     * create()
     * crea una nueva categoría
     * @param Request $request
     * @return type
     */
    public function create(Request $request) { //Request $request: para coger los datos del formulario
        $this->check_create($request);

        try {
            //para todos los campos
            Category::create($request->all()); //para crear los campos de categoría

            $message = trans("messages.create_ok");
            //para algunos campos
            /* $cat = new Category();
              $cat->name = $request->name;
              $cat->description = $request->description;

              $cat->save();
              //obtener id nuevo
              $idNew=$cat->id; */
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                $message = "Name already exists";
            } else {
                $message = 'No data created' . $e->getCode();
            }
        }
        return view('category.create', ['message' => $message]);
    }

    /**
     * check_find()
     * criterios de validación para la función find()
     * @param Request $request
     */
    public function check_find(Request $request) {

        $request->validate([
            'id' => "required|numeric",
        ]);
    }

    /**
     * find()
     * busca una categoría por id
     * @param Request $request
     * @return type
     */
    public function find(Request $request) {
        //$message=NULL;
        $this->check_find($request);
        try {
            $objCat = Category::findOrFail($request->id);

            //vamos a edit
            return redirect()->to('/category/edit/' . $request->id);
            /* if(isset($objCat)){

              }else{
              $message = "No data found";
              } */
        } catch (\Exception $e) {
            $message = 'No data found' . $e->getMessage();
        }
        return view('category.find', ['id' => $request->id, 'message' => $message]);
    }

    /**
     * edit()
     * llevará al formulario de editar según id
     * @param type $id
     * @return type
     */
    public function edit($id) {

        try {
            $objCat = Category::findOrFail($id); //buscamos objeto

            $message = Session::get('message_update');

            return view('category.edit', ['objCat' => $objCat, 'message' => $message]); //retornamos vista
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
        //$numeric= "/^[0-9]*$/";
        //$postcode= "/^[0-9]{5}$/";

        $request->validate([
            'name' => "required|regex:$alphabetic|min:1|max:50",
            'description' => "nullable|string|max:100",
        ]);
    }

    /**
     * update()
     * modifica la categoría seleccionada
     * @param type $request
     * @return type
     */
    public function update($request) {

        $this->check_update($request);

        try {
            //Category::where("name",$request->name)->firstOrFail();
            $objCat = Category::findOrFail($request->id);

            $objCat->update($request->all()); //hace un update de todos los datos del objeto

            $message = "Data updated successfully";

            //para volver a atrás
            return redirect()->back()->with(['message_update' => $message]);
            //return redirect() ->back()->with('message',$message);
        } catch (\Exception $e) {
            $message = 'No data updated - ' . $e->getMessage();
        }
        return view('category.edit', ['objCat' => $objCat, 'message' => $message]);
    }

    /**
     * delete()
     * elimina la categoría seleccionada
     * @param type $request
     * @return type
     */
    public function delete($request) {
        try {
            $objCat = Category::findOrFail($request->id);

            $objCat->delete(); //hace un update de todos los datos del objeto

            $message = "Data deleted successfully";

            //para volver a atrás
            return view('category.find', ['message' => $message]);
            //return redirect()->to('/category/list'); Si quieres que vuelva al list all
        } catch (\Exception $e) {
            $message = 'No data deleted - ' . $e->getMessage();
        }
        return view('category.edit', ['objCat' => $objCat, 'message' => $message]);
    }

}
