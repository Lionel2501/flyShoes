<?php
    require_once './View/VistaItems.php';
    require_once './Model/ModelItems.php';
    require_once './Model/ModelMarca.php';
    require_once './Controller/Helper.php';
    

    class ControllerItems{
        private $vista;
        private $model;
        private $modelM;
        private $helper;

        function __construct(){
             $this->vista = new VistaItems();
             $this->model = new ModelItems();
             $this->modelM = new ModelMarcas();
             $this->helper = new Helper();
        }

        function ShowItems(){
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $usuario = $this->helper->logedUser();
            $n = $this->helper->checkLoggedIn();
            if($n == true){
                $this->vista->ShowItemsLogged($items, $marcas);
            }else{
              /*  var_dump($usuario);
                die;*/
               $this->vista->ShowItems($items);
            }
        }
        function Insert(){
            $this->model->InsertItems($_POST['modelo_input'],$_POST['talle_input'],$_POST['precio_input'], $_POST['stock_input'], $_POST['marca_input']);
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowItemsLogged($items, $marcas);
        }
        function Borrar($params = null){
            $id_zapatilla = $params[':ID'];
            $this->model->BorrarItem($id_zapatilla);
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowItemsLogged($items, $marcas);
        }
        function DetalleProducto($params = null){
            $id_zapatilla = $params[':ID'];
            $item = $this->model->GetInfo($id_zapatilla);
            $this->vista->DetalleProduct($item);
        }
        function ShowEditForm($params = null){
            $id_item = $params[":ID"];
            $item = $this->model->GetItem($id_item);
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowFormEdit($item, $marcas);
        }
        function Edit($params = null){
            $modelo = $_POST["modelo_input"];
            $talle = $_POST["talle_input"];
            $precio = $_POST["precio_input"];
            $stock = $_POST["stock_input"];
            $marca = $_POST["marca_input"];
            $id_item = $params[":ID"];
            $this->model->EditItem($modelo, $talle, $precio, $stock, $marca, $id_item);
            $items = $this->model->GetItems();
            $marcas = $this->modelM->GetMarcas();
            $this->vista->ShowItemsLogged($items, $marcas);
        }
    }
?>