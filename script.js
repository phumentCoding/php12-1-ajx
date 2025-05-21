
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
                              <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStudentModal">Edit</button>
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

