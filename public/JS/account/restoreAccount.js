let accountIdToRestore = null;

document.querySelector('#accountTable').addEventListener('click', function(e) {
    if (e.target.closest('.restoreAccountBtn')) {
        const el = e.target.closest('.restoreAccountBtn');
        accountIdToRestore = el.dataset.account_id;

        document.getElementById('restoreConfirmModal').classList.remove('hidden');
    }
});

document.getElementById('cancelRestoreBtn').addEventListener('click', function() {
    document.getElementById('restoreConfirmModal').classList.add('hidden');
    accountIdToRestore = null;
});

document.getElementById('confirmRestoreBtn').addEventListener('click', function() {
    if (!accountIdToRestore) return;

    const confirmBtn = this;
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Restoring...';

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'account/restore',
        data: { account_id: accountIdToRestore },
        success: function () {
            $('#accountTable').DataTable().ajax.reload();

            document.getElementById('restoreConfirmModal').classList.add('hidden');
            accountIdToRestore = null;
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';

            const modal = document.getElementById('restoreSuccessModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);
        },
        error: function () {
            alert('Failed to restore account.');
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';
        }
    });
});
