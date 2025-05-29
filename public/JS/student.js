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
                        class="table-action deleteStudentModal"
                        title="Delete Account"
                        data-account_id="${row.account_id}">
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

document.querySelector('#studentTable').addEventListener('click', function (e) {
    if (e.target.closest('.editStudentModal')) {
        const el = e.target.closest('.editStudentModal');

        document.getElementById('editStudentRecordId').value = el.dataset.student_id || '';
        document.getElementById('editFirstName').value = el.dataset.first_name || '';
        document.getElementById('editLastName').value = el.dataset.last_name || '';
        document.getElementById('editMiddleName').value = el.dataset.middle_name || '';
        document.getElementById('editCourse').value = el.dataset.course || '';
        document.getElementById('editYearLevel').value = el.dataset.year_level || '';

        document.getElementById('editStudentModal').classList.remove('hidden');
    }
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

    // Optional: close modal when clicking outside it
    window.addEventListener('click', function (event) {
        if (event.target === studentModal) {
            studentModal.classList.add('hidden');
        }
    });
});

document.getElementById('editStudentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    document.getElementById('editStudentModal').classList.add('hidden');

    $('#studentTable').DataTable().ajax.reload();
});

$("#editStudentForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'student/update',
        data: {
            editStudentRecordId: $('#editStudentRecordId').val(),
            editFirstName: $('#editFirstName').val(),
            editLastName: $('#editLastName').val(),
            editMiddleName: $('#editMiddleName').val(),
            editCourse: $('#editCourse').val(),
            editYearLevel: $('#editYearLevel').val(),
        },
        success: function (response) {
            if (response.status === 'success') {
                alert(response.message);
                $('#studentTable').DataTable().ajax.reload();
                document.getElementById('editStudentModal').classList.add('hidden');
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
});
