function baseURL() {
    return location.protocol +"//" + location.host + "/";
}

new DataTable('#studentTable', {
    ajax: baseURL()+'student/list',
    processing: true,
    serverSide: true,
    columnDefs: [
        {targets: '_all', visible: true},
        {targets: [6], width: '42px',},
    ],
    columns: [
        {
            data: 'student_id',
            name: 'student_id',
            title: 'Student ID',
        },
        {
            data: 'first_name',
            name: 'first_name',
            title: 'First Name',
        },
        {
            data: 'last_name',
            name: 'last_name',
            title: 'Last Name',
        },
        {
            data: 'middle_name',
            name: 'middle_name',
            title: 'Middle Name',
        },
        {
            data: 'course',
            name: 'course',
            title: 'Course',
        },
        {
            data: 'year_level',
            name: 'year_level',
            title: 'Year Level',
        },
        {
            data: null,
            title: 'Action',
            sortable: false,
            render: function(data, type, row) {
                return `
                <div id="table-action">
                    <a href="javascript:void(0)" 
                    class="table-action editStudentModal" 
                    title="Edit Account" 
                    data-first_name="${row.first_name}"
                    data-last_name="${row.last_name}"
                    data-middle_name="${row.middle_name}"
                    data-course="${row.course}"
                    data-year_level="${row.year_level}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </a>

                    <a href="javascript:void(0)"
                        class="table-action deleteStudentBtn"
                        title="Delete Account"
                        data-student_id="${row.student_id}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </a>
                </div>
                `;
            }
        }
    ]
});

document.getElementById('closeEditStudentModalBtn').addEventListener('click', function() {
    document.getElementById('editStudentModal').classList.add('hidden');
});

document.addEventListener('DOMContentLoaded', function () {
    const addStudentButton = document.getElementById('addStudentButton');
    const studentModal = document.getElementById('studentModal');
    const closeModalStudent = document.getElementById('closeModalStudent');

    addStudentButton.addEventListener('click', function () {
        studentModal.classList.remove('hidden');
    });

    closeModalStudent.addEventListener('click', function () {
        studentModal.classList.add('hidden');
    });

    window.addEventListener('click', function (event) {
        if (event.target === studentModal) {
            studentModal.classList.add('hidden');
        }
    });
});

document.addEventListener('click', function (event) {
    if (event.target.closest('.editStudentModal')) {
        const button = event.target.closest('.editStudentModal');
        
        const studentRow = button.closest('tr');
        const rowData = $('#studentTable').DataTable().row(studentRow).data();

        document.getElementById('editStudentID').value = rowData.student_id;
        document.getElementById('editFirstName').value = rowData.first_name;
        document.getElementById('editLastName').value = rowData.last_name;
        document.getElementById('editMiddleName').value = rowData.middle_name;
        document.getElementById('editCourse').value = rowData.course;
        document.getElementById('editYearLevel').value = rowData.year_level;

        document.getElementById('student_fullname').textContent = `${rowData.first_name} ${rowData.middle_name} ${rowData.last_name}`;

        document.getElementById('editStudentModal').classList.remove('hidden');
    }
});


document.getElementById('editStudentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const studentId = formData.get('student_id');

    fetch(baseURL() + 'student/update/' + studentId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('editStudentModal').classList.add('hidden');
            $('#studentTable').DataTable().ajax.reload();

            const updateModal = document.getElementById('studentUpdateModal');
            updateModal.classList.remove('hidden');

            // Auto-hide after 3 seconds
            setTimeout(() => {
                updateModal.classList.add('hidden');
            }, 3000);
        } else {
            alert(data.message || 'Student name already exists.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
});



let studentIdToDelete = null; // Track which student to delete

// Trigger delete modal when delete button is clicked
document.querySelector('#studentTable').addEventListener('click', function(e) {
    if (e.target.closest('.deleteStudentBtn')) {
        const el = e.target.closest('.deleteStudentBtn');
        studentIdToDelete = el.dataset.account_id;

        // Show the deletion confirmation modal
        document.getElementById('studentDLTConfirmModal').classList.remove('hidden');
    }
});

// Cancel deletion
document.getElementById('studentDLTCancelBtn').addEventListener('click', function() {
    document.getElementById('studentDLTConfirmModal').classList.add('hidden');
    studentIdToDelete = null;
});

// Confirm deletion
document.getElementById('studentDLTConfirmBtn').addEventListener('click', function() {
    if (!studentIdToDelete) return;

    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'student/delete',
        data: { account_id: studentIdToDelete },
        success: function (response) {
            $('#studentTable').DataTable().ajax.reload();

            // Hide confirmation modal
            document.getElementById('studentDLTConfirmModal').classList.add('hidden');
            studentIdToDelete = null;

            // Show success modal
            const modal = document.getElementById('studentUpdateModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);
        },
        error: function (err) {
            alert('Failed to delete student.');
        }
    });
});
