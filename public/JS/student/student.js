function baseURL() {
    return location.protocol +"//" + location.host + "/";
}

new DataTable('#studentTable', {
    ajax: {
        url: baseURL() + 'student/list',
        data: function (d) {
            d.status = document.getElementById('filterStatusStudent').value;
        }
    },
    processing: true,
    serverSide: true,
    columnDefs: [
        {targets: '_all', visible: true},
        {targets: [7], width: '42px',},
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
            data: 'status',
            name: 'status',
            title: 'Status',
            render: function(data) {
                if (data === 'Active') {
                    return `
                        <span class="status-badge-student active-status-student">
                            <span class="status-circle-student"></span> Active
                        </span>
                    `;
                } else if (data === 'Inactive') {
                    return `
                        <span class="status-badge-student inactive-status-student">
                            <span class="status-circle-student"></span> Inactive
                        </span>
                    `;
                }
                return data;
            }
        },
        {
            data: null,
            title: 'Action',
            sortable: false,
            render: function(row) {
                if (row.status === 'Inactive') {
                    return `<span class="text-gray-400 italic">
                                <a href="javascript:void(0)"
                                        class="table-action restoreStudentBtn"
                                        title="Restore Student"
                                        data-student_id="${row.student_id}">
                                        <svg id="restoreIconStudent" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </a>
                            </span>`;
                }

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

document.getElementById('filterStatusStudent').addEventListener('change', function () {
    $('#studentTable').DataTable().ajax.reload();
});

document.getElementById('closeEditStudentModalBtn').addEventListener('click', function() {
    document.getElementById('editStudentModal').classList.add('hidden');
});

// Edit Student Form Submission
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
    const submitBtn = document.getElementById('updateStudentSubmit');
    const studentForm = studentModal.querySelector('form');

    const form = e.target;
    const formData = new FormData(form);
    const studentId = formData.get('student_id');


    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';

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

            const updateModal = document.getElementById('editSuccessModalStudent');
            updateModal.classList.remove('hidden');

            setTimeout(() => {
                updateModal.classList.add('hidden');
            }, 2000);

            submitBtn.disabled = false;
            submitBtn.textContent = 'Save';
            studentForm.reset();
        } else {
            alert(data.message || 'Student name already exists.');
            studentForm.reset();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save';
    });
});
