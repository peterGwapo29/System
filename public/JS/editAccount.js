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
    document.getElementById('editAccountModal').classList.add('hidden');

    $('#accountTable').DataTable().ajax.reload();
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