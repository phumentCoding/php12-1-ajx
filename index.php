<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Data Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <style>
    .student-image {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
    }
    .image-preview-container {
      width: 150px;
      height: 150px;
      border: 1px dashed #ccc;
      border-radius: 5px;
      margin-top: 10px;
      position: relative;
    }
    .image-preview {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .image-preview img {
      max-width: 100%;
      max-height: 100%;
      object-fit: cover;
    }
    .preview-placeholder {
      color: #6c757d;
      text-align: center;
    }
    .remove-image-btn {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: #dc3545;
      color: white;
      border-radius: 50%;
      width: 25px;
      height: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      display: none;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col">
        <h2>Student Data Management</h2>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
          <i class="bi bi-plus-circle me-2"></i>Add Student
        </button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>N.O</td>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="studentTableBody">
             
        </tbody>
      </table>
    </div>

    <div id="noDataMessage" class="text-center py-5 d-none">
      <i class="bi bi-exclamation-circle fs-1 text-secondary"></i>
      <p class="mt-3 text-secondary">No student records found. Click "Add Student" to create a new record.</p>
    </div>
  </div>

  <!-- Add Student Modal -->
  <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addStudentForm" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" name="name" class="form-control" id="name" required />
                </div>
                <div class="mb-3">
                  <label class="form-label">Gender</label>
                  <div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="male" value="Male" checked />
                      <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="female" value="Female" />
                      <label class="form-check-label" for="female">Female</label>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="tel" class="form-control" name="phone" id="phone" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="email" required />
                </div>
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Student Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*" />
              <div class="image-preview-container mt-2">
                <div class="image-preview" id="imagePreview">
                  <div class="preview-placeholder">Image preview will appear here</div>
                </div>
                <div class="remove-image-btn" id="removeImageBtn">
                  <i class="bi bi-x"></i>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" onclick="storeStudent()" class="btn btn-primary" id="saveStudentBtn">Save Student</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImageBtn');

    document.addEventListener('DOMContentLoaded', function () {
      imageInput.addEventListener('change', function () {
        previewImage(this);
      });
      removeImageBtn.addEventListener('click', removeImage);
    });

    function previewImage(input) {
      imagePreview.innerHTML = '';

      if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          imagePreview.appendChild(img);
          removeImageBtn.style.display = 'flex';
        };

        reader.readAsDataURL(input.files[0]);
      } else {
        imagePreview.innerHTML = '<div class="preview-placeholder">Image preview will appear here</div>';
        removeImageBtn.style.display = 'none';
      }
    }

    function removeImage() {
      imageInput.value = '';
      imagePreview.innerHTML = '<div class="preview-placeholder">Image preview will appear here</div>';
      removeImageBtn.style.display = 'none';
    }
  </script>

  <script>
        const renderStudent = () => {
            $.ajax({
                type: "GET",
                url: "controller.php?type=select",
                dataType: "json",
                success: function (response) {
                    // console.log("Students fetched:", response);

                    let students = response.students;

                    console.log(students);


                    let tr = ``;

                    $.map(students, function (student, index) {
                      tr += `
                        <tr>
                          <td>${index+1}</td>
                          <td>${student.id}</td>
                          <td>image.jpg</td>
                          <td>${student.name}</td>
                          <td>${student.gender}</td>
                          <td>${student.phone}</td>
                          <td>${student.email}</td>
                          <td>${student.address}</td>
                          <td>
                              <button class=" btn btn-primary">Edit</button>
                              <button onclick="deleteStudent(${student.id})" class=" btn btn-danger">Delete</button>
                          </td>
                        </tr>
                      `;
                    });

                    $('#studentTableBody').html(tr);


                },
                error: function (xhr, status, error) {
                    console.error("Error fetching students:", error);
                }
            });
        }

        renderStudent();


      //delete student
      const deleteStudent = (id) => {
          if(confirm('Do you want to delete this?')){
            // alert(id)

            $.ajax({
              type: "POST",
              url: "controller.php?type=delete",
              data: {
                "id" : id,
              },
              dataType: "json",
              success: function (response) {
                renderStudent();
              }
            });
          }
      }


      const storeStudent = () => {
          try{
            let data = new FormData($('#addStudentForm')[0]);
            let student = {
                name   : data.get('name'),
                gender : data.get('gender'),
                phone  : data.get('phone'),
                email  : data.get('email'),
                address: data.get('address')
            }

            console.log(student);

            $.ajax({
              type: "POST",
              url: "controller.php?type=insert",
              data: student,
              dataType: "json",
              success: function (response) {
                renderStudent();

                //close modal
                $('#addStudentModal').modal('hide');
              }
            });

          }catch(e){
            console.log("Error : "+e);
          }
      }
      

  </script>
</body>
</html>
