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

  <?php include "modal-add.php" ?>


  <?php include "modal-update.php" ?>

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
  <script src="script.js"></script>

  
</body>
</html>
