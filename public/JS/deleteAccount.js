let accountIdToDelete = null;

document.querySelector('#accountTable').addEventListener('click', function(e) {
    if (e.target.closest('.deleteAccountBtn')) {
        const el = e.target.closest('.deleteAccountBtn');
        accountIdToDelete = el.dataset.account_id;

        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
});

document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
    document.getElementById('deleteConfirmModal').classList.add('hidden');
    accountIdToDelete = null;
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (!accountIdToDelete) return;

        const confirmBtn = this;
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Deleting...';

    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'account/delete',
        data: { account_id: accountIdToDelete },
        success: function () {
            $('#accountTable').DataTable().ajax.reload();

            document.getElementById('deleteConfirmModal').classList.add('hidden');
            accountIdToDelete = null;

            const modal = document.getElementById('deleteSuccessModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);
        },
        error: function () {
            alert('Failed to delete account.');
        }
    });
});
