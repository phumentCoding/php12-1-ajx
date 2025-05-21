
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
                          <td>${index + 1}</td>
                          <td>${student.id}</td>
                          <td>image.jpg</td>
                          <td>${student.name}</td>
                          <td>${student.gender}</td>
                          <td>${student.phone}</td>
                          <td>${student.email}</td>
                          <td>${student.address}</td>
                          <td>
                              <button onclick="editStudent(${student.id})" class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStudentModal">Edit</button>
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
    if (confirm('Do you want to delete this?')) {
        // alert(id)

        $.ajax({
            type: "POST",
            url: "controller.php?type=delete",
            data: {
                "id": id,
            },
            dataType: "json",
            success: function (response) {
                renderStudent();
            }
        });
    }
}


const storeStudent = () => {
    try {
        let data = new FormData($('#addStudentForm')[0]);
        let student = {
            name: data.get('name'),
            gender: data.get('gender'),
            phone: data.get('phone'),
            email: data.get('email'),
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

    } catch (e) {
        console.log("Error : " + e);
    }
}


const editStudent = (id) => {
    try{
    //    alert(id)
       $.ajax({
        type: "GET",
        url: "controller.php?type=edit",
        data: {
            "id" : id
        },
        dataType: "json",
        success: function (response) {
            let student = response.student;

            $('#show-student-edit').html(`
                <form id="updateStudentForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="${student.name}" class="form-control" id="name" required />
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
                                <input type="tel" class="form-control" value="${student.phone}" name="phone" id="phone" required />
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
            `);
        }
       });
    }catch(e){
        console.error(e);
    }
}

