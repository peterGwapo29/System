let accountIdToDelete = null; // Track which account to delete

document.querySelector('#accountTable').addEventListener('click', function(e) {
    if (e.target.closest('.deleteAccountBtn')) {
        const el = e.target.closest('.deleteAccountBtn');
        accountIdToDelete = el.dataset.account_id;

        // Show confirmation modal
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }
});

// Cancel button
document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
    document.getElementById('deleteConfirmModal').classList.add('hidden');
    accountIdToDelete = null;
});

// Confirm button
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

            // Hide confirmation modal
            document.getElementById('deleteConfirmModal').classList.add('hidden');
            accountIdToDelete = null;

            // Show success modal
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
