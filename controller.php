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

      case 'edit'   : {
         try{
            $id = $_GET['id'];
            $sql = "SELECT * FROM students WHERE id = $id";

            $result = mysqli_query($conn,$sql);

            $student = mysqli_fetch_assoc($result);

            http_response_code(200);

            echo json_encode([
               'status' => true,
               'student' => $student
            ]);

         }catch(Exception $e){
            http_response_code(500);

            echo json_encode([
               'status' => false,
               'message' => $e->getMessage()
            ]);
         }
         break;
      }

      case 'insert' : {
         try{

            http_response_code(201);

            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $phone  = $_POST['phone'];
            $email  = $_POST['email'];
            $address = $_POST['address'];

            $sql = "INSERT INTO `students`(`name`, `gender`, `phone`, `address`, `email`) VALUES ('$name','$gender','$phone','$address','$email')";

            mysqli_query($conn,$sql);

            echo json_encode([
               'status' => true,
               'message' => 'created student successfully'
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

      case 'delete' : {

         try{

            
            $id = $_POST['id'];

            $sql = "DELETE FROM students WHERE id = $id";

            mysqli_query($conn,$sql);
            

            http_response_code(200);

            echo json_encode([
               'status' => true,
               'message' => 'Delete success',
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