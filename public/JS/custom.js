function baseURL() {
    return location.protocol +"//" + location.host + "/";
}

new DataTable('#accountTable', {
    ajax: baseURL()+'studentAccount/list',
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
            title: 'ID',
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
        },
        {
            data: null,
            title: 'Action',
            sortable: false,
            render: function(data, type, row) {
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
    </div>
    `;
}
        }
    ]
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

document.getElementById('editAccountForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    document.getElementById('editAccountModal').classList.add('hidden');

    $('#accountTable').DataTable().ajax.reload();
});


$("#updateAccountSubmit").click(function() {
    $("#editAccountForm").submit();
});

$("#editAccountForm").submit(function (e) {
    e.preventDefault();
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
            if (response.status === 'success') {
                alert(response.message);
                $('#accountTable').DataTable().ajax.reload();
                document.getElementById('editAccountModal').classList.add('hidden');
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
});
