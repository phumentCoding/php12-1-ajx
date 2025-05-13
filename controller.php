<?php 
   include "config.php";

   header('Content-Type:application/json');


   $type = $_GET['type'];

   switch($type){

      case 'select' : {

         try{
            $sql = "SELECT * FROM students";
            $result = mysqli_query($conn,$sql);

            if($result){
               $students = mysqli_fetch_all($result,MYSQLI_ASSOC);
            }else{
               $students = [];
            }


            http_response_code(200);

            //response to index.php
            echo json_encode([
               'status' => true,
               'message' => 'select all student',
               'students' => $students
            ]);


         }catch(Exception $e){

            http_response_code(500);

            echo json_encode([
               'status' => false,
               'errors' => $e->getMessage()
            ]);
         }

        break;
      }
   }
?>