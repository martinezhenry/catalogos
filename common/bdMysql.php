<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
//if ($mysqli->connect_error) { return 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error; }
class coBdmysql{
    //SELECT A BD
    function select($tabla,$campo,$where,$order,$limit,$mysqli,$print = FALSE){
    //        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
            if($mysqli->connect_error) { return 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error; }
            if($tabla != ''){
                if($campo == ''){ $campo = "*"; }
                if($where != ''){ $where = "WHERE ".$where; }
                if($order != ''){ $order = "ORDER BY ".$order; }
                if($limit != ''){ $limit = "LIMIT ".$limit; }
                
                if($print){
                    $resp = "SELECT ".$campo." FROM ".$tabla." ".$where." ".$order." ".$limit;
                }else{
                    if ($resultado = $mysqli->query("SELECT ".$campo." FROM ".$tabla." ".$where." ".$order." ".$limit)) {
                            if($resultado->num_rows > 0){
                                $i = 0; 
                                while ($r = $resultado->fetch_array(MYSQLI_ASSOC)){
                                    $resp[$i] = $r;
                                    $i = $i + 1;
                                }
                            }else{ $resp = $resultado;}
                        $resultado->close();
                    }else{ $resp = $resultado;}
                }
            }else{ $resp = 'SELECT: INDIQUE TABLA'; }
        return $resp;
    }
    //NUM ROW
    function num_row($tabla,$where,$mysqli){
//        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
        if ($mysqli->connect_error) { return 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error; }
            
        if($tabla != ''){
            if($where != ''){ $where = "WHERE ".$where; }
            if ($resultado = $mysqli->query("SELECT * FROM ".$tabla." ".$where)) {
                    $resp = $resultado->num_rows;
                $resultado->close();
            }else{ $resp = $resultado;}
        }else{ $resp = 'NUM ROW: INDIQUE TABLA'; }
        return $resp;
    }
    //UPDATE A BD
    function update($tabla,$campo,$where,$mysqli,$print = FALSE){
        if($print){
            $resp = "UPDATE ".$tabla." SET ".$campo." ".$where;
        }else{
//            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
            if ($mysqli->connect_error) { return 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error; }

            if($tabla != '' AND $campo !=''){
                if($where != ''){ $where = "WHERE ".$where; }
                if ($mysqli->query("UPDATE ".$tabla." SET ".$campo." ".$where)){ $resp = 1;
                }else{ $resp = 'ERROR EN INSERT: '.$mysqli->error;}
            }else{ $resp = 'UPDATE: INDIQUE TABLA O VALORES'; }
        }
        return $resp;
    }
    //INSERT A BD
    function insert($tabla,$campo,$valor,$mysqli,$print = FALSE){
        if($print){
            $resp = "INSERT INTO ".$tabla." (".$campo.")  VALUES (".$valor.")";
        }else{
//            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
            if ($mysqli->connect_error) { return 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error; }

            if($tabla != '' AND $valor !='' AND $campo != ''){
                if ($mysqli->query("INSERT INTO ".$tabla." (".$campo.")  VALUES (".$valor.")")){ $resp = 1;
                }else{ $resp = 'ERROR EN INSERT: '.$mysqli->error;}
            }else{ $resp = 'INSERT: INDIQUE TABLA O VALORES'; }
        }
        return $resp;
    }
    //DELETE A BD
    function delete($tabla,$where,$mysqli,$print = FALSE){
        if($print){
            $resp = "DELETE FROM ".$tabla." ".$where;
        }else{
            if ($mysqli->connect_error) { return 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error; }

            if($tabla != ''){
                if($where != ''){ $where = "WHERE ".$where; }
                if ($mysqli->query("DELETE FROM ".$tabla." ".$where)){ $resp = 1;
                }else{ $resp = 'ERROR EN DELETE: '.$mysqli->error;}
            }else{ $resp = 'DELETE: INDIQUE TABLA'; }
        }
        return $resp;
    }
    
}