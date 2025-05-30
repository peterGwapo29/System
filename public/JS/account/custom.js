function baseURL() {
    return location.protocol +"//" + location.host + "/";
}

new DataTable('#accountTable', {
    ajax: {
        url: baseURL() + 'studentAccount/list',
        data: function (d) {
            d.status = document.getElementById('filterStatus').value;
        }
    },
    processing: true,
    serverSide: true,
    columnDefs: [
        {targets: '_all', visible: true},
        {targets: [6], width: '42px',},
    ],
    columns: [
        {
            data: 'account_id',
            name: 'account_id',
            title: 'Account ID',
        },
        {
            data: 'student_id',
            name: 'student_id',
            title: 'Student ID',
        },
        {
            data: 'username',
            name: 'username',
            title: 'Username',
        },
        {
            data: 'password',
            name: 'password',
            title: 'Password',
            render: function (data, type, row) {
                const shortPassword = data.length > 10 ? data.substring(0, 10) + '...' : data;
                return `<span class="cursor-pointer dataPassword" onclick="showPasswordModal('${data}')">${shortPassword}</span>`;
            }
        },
        {
            data: 'email',
            name: 'email',
            title: 'Email',
        },
        {
            data: 'account_status',
            name: 'account_status',
            title: 'Status',
            render: function(data, type, row) {
                if (data === 'Active') {
                    return `
                        <span class="status-badge active-status">
                            <span class="status-circle"></span> Active
                        </span>
                    `;
                } else if (data === 'Inactive') {
                    return `
                        <span class="status-badge inactive-status">
                            <span class="status-circle"></span> Inactive
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
            render: function(data, type, row) {
                if (row.account_status === 'Inactive') {
                    return `<span class="text-gray-400 italic">
                                <a href="javascript:void(0)"
                                        class="table-action restoreAccountBtn"
                                        title="Restore Account"
                                        data-account_id="${row.account_id}">
                                        <svg id="restoreIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </a>
                            </span>`;
                }

                return `
                    <div id="table-action">
                        <a href="javascript:void(0)" 
                            class="table-action editAccountModal" 
                            title="Edit Account" 
                            data-account_id="${row.account_id}"
                            data-student_id="${row.student_id}"
                            data-username="${row.username}"
                            data-email="${row.email}"
                            data-account_status="${row.account_status}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>

                        <a href="javascript:void(0)"
                            class="table-action deleteAccountBtn"
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

document.getElementById('filterStatus').addEventListener('change', function () {
    $('#accountTable').DataTable().ajax.reload();
});

function showPasswordModal(password) {
    document.getElementById('passwordContent').textContent = password;
    document.getElementById('passwordModal').classList.remove('hidden');
}

document.getElementById('closeModalBtn').addEventListener('click', function () {
    document.getElementById('passwordModal').classList.add('hidden');
});

document.querySelector('#accountTable').addEventListener('click', function(e) {
    if (e.target.closest('.editAccountModal')) {
        const el = e.target.closest('.editAccountModal');

        document.getElementById('editAccountId').value = el.dataset.account_id || '';
        document.getElementById('editStudentId').value = el.dataset.student_id || '';
        document.getElementById('editUsername').value = el.dataset.username || '';
        document.getElementById('editPassword').value = '';
        document.getElementById('editEmail').value = el.dataset.email || '';
        document.getElementById('editStatus').value = el.dataset.account_status || 'Active';

        document.getElementById('editAccountModal').classList.remove('hidden');
        document.getElementById('account_username').textContent = el.dataset.username || '';
        
    }
});

document.getElementById('closeEditModalBtn').addEventListener('click', function() {
    document.getElementById('editAccountModal').classList.add('hidden');
});

let originalEditData = {};

document.querySelector('#accountTable').addEventListener('click', function(e) {
    if (e.target.closest('.editAccountModal')) {
        const el = e.target.closest('.editAccountModal');

        // Store original values
        originalEditData = {
            accountId: el.dataset.account_id,
            studentId: el.dataset.student_id,
            username: el.dataset.username,
            password: '', // We do not compare password as it's always blank by default
            email: el.dataset.email,
            status: el.dataset.account_status
        };

        // Populate form fields
        document.getElementById('editAccountId').value = el.dataset.account_id || '';
        document.getElementById('editStudentId').value = el.dataset.student_id || '';
        document.getElementById('editUsername').value = el.dataset.username || '';
        document.getElementById('editPassword').value = '';
        document.getElementById('editEmail').value = el.dataset.email || '';
        document.getElementById('editStatus').value = el.dataset.account_status || 'Active';

        // Show modal
        document.getElementById('editAccountModal').classList.remove('hidden');
        document.getElementById('account_username').textContent = el.dataset.username || '';
    }
});


$("#editAccountForm").submit(function (e) {
    e.preventDefault();
    const submitBtn = document.getElementById('updateAccountSubmit');

     const currentData = {
        accountId: $('#editAccountId').val(),
        studentId: $('#editStudentId').val(),
        username: $('#editUsername').val(),
        password: $('#editPassword').val(),
        email: $('#editEmail').val(),
        status: $('#editStatus').val()
    };

    // Check for changes (excluding password if empty)
    const changed = (
        currentData.studentId !== originalEditData.studentId ||
        currentData.username !== originalEditData.username ||
        currentData.email !== originalEditData.email ||
        currentData.status !== originalEditData.status ||
        currentData.password !== '' // user typed a new password
    );

    if (!changed) {
        // No changes, close modal and skip AJAX call
        document.getElementById('editAccountModal').classList.add('hidden');
        return;
    }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';


    $.ajax({
    type: 'post',
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    url: baseURL() + 'account/update',
    data: {
        editAccountId: $('#editAccountId').val(),
        editStudentId: $('#editStudentId').val(),
        editUsername: $('#editUsername').val(),
        editPassword: $('#editPassword').val(),
        editEmail: $('#editEmail').val(),
        editStatus: $('#editStatus').val(),
    },
    success: function (response) {
        $('#editUsernameError').addClass('hidden').text(''); // clear any previous error

        if (response.status === 'success') {
            $('#accountTable').DataTable().ajax.reload();
            document.getElementById('editAccountModal').classList.add('hidden');

            const modal = document.getElementById('editSuccessModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('hidden'), 2000);
        }
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save';
    },
    error: function (err) {
        // Clear any existing error
        $('#editUsernameError').addClass('hidden').text('');

        if (err.status === 422 && err.responseJSON.field === 'username') {
            $('#editUsernameError').removeClass('hidden').text(err.responseJSON.message);
        } else {
            console.log(err);
        }
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save';
    }
});

});