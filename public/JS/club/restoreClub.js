let clubIdToRestore = null;

document.querySelector('#clubTable').addEventListener('click', function(e) {
    if (e.target.closest('.restoreClubBtn')) {
        const el = e.target.closest('.restoreClubBtn');
        clubIdToRestore = el.dataset.club_id;

        // Show the restore confirmation modal for the student
        document.getElementById('restoreStudentModal').classList.remove('hidden');
    }
});

document.getElementById('cancelRestoreStudentBtn').addEventListener('click', function() {
    document.getElementById('restoreStudentModal').classList.add('hidden');
    clubIdToRestore = null;
});

document.getElementById('confirmRestoreStudentBtn').addEventListener('click', function() {
    if (!clubIdToRestore) return;

    const confirmBtn = this;
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Restoring...';

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'club/restore',
        data: { club_id: clubIdToRestore },
        success: function () {
            $('#clubTable').DataTable().ajax.reload();

            document.getElementById('restoreStudentModal').classList.add('hidden');
            clubIdToRestore = null;
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';

            const modal = document.getElementById('restoreSuccessModalClub');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);
        },
        error: function () {
            alert('Failed to restore club.');
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';
        }
    });
});
