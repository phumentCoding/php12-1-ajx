<?php 
   include "config.php";

   header('Content-Type:application/json');


   $type = $_GET['type'];

   switch($type){

      case 'select' : {


        //response to index.php
        echo json_encode([
            'status' => true,
            'message' => 'select all student'
        ]);

        /*
        {
           "status" : true,
           "message" : "select all student"
        }
        */

        break;
      }
   }
?>