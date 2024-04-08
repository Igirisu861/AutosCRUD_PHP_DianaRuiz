<?php

include('conn.php');

$data = json_decode(file_get_contents('php://input'),true);

//if(isset($_GET['accion'])){
  //  $accion = $_GET['accion'];

    //operación read
    if(isset($data)){
        $accion = $data["accion"];
    
    if($accion== 'consultar'){
        $id = $data["id"];

        $sql = "select autos.marca AS marca_auto, autos.modelo AS modelo_auto, autos.year AS auto_año, autos.no_serie AS no_serie_auto FROM cliente INNER JOIN autos ON cliente.id = autos.id_cliente WHERE cliente.id = '$id'";
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($fila = $result->fetch_assoc()){
                $items['marca'] = $fila['marca_auto'];
                $items['modelo'] = $fila['modelo_auto'];
                $items['year'] = $fila['auto_año'];
                $items['no_serie'] = $fila['no_serie_auto'];
                $arrJoin[]=$items;
            }
            $response["status"]="ok";
            $response["mensaje"]=$arrJoin;
        }
        else{
            $response["status"]="Error";
            $response["mensaje"]="No hay registros que cumplan";
        }
        echo json_encode($response);
    }}
//}   