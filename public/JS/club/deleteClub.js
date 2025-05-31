let clubIdToDelete = null;

document.querySelector('#clubTable').addEventListener('click', function(e) {
    if (e.target.closest('.deleteClubBtn')) {
        const el = e.target.closest('.deleteClubBtn');
        clubIdToDelete = el.dataset.club_id;

        document.getElementById('clubDLTConfirmModal').classList.remove('hidden');
    }
});

document.getElementById('clubDLTCancelBtn').addEventListener('click', function() {
    document.getElementById('clubDLTConfirmModal').classList.add('hidden');
    clubIdToDelete = null;
});

document.getElementById('clubDLTConfirmBtn').addEventListener('click', function() {
    if (!clubIdToDelete) return;

        const confirmBtn = this;
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Deleting...';

        $.ajax({
            type: 'post',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: baseURL() + 'club/delete',
            data: { club_id: clubIdToDelete }, // ✅ CHANGED TO match Laravel
            success: function () {
                $('#clubTable').DataTable().ajax.reload();
        
                document.getElementById('clubDLTConfirmModal').classList.add('hidden');
                clubIdToDelete = null;
        
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Delete';
        
                const modal = document.getElementById('deleteSuccessModalClub');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 2500);
            },
            error: function () {
                alert('Failed to deactivate account.');
        
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Delete';
            }
        });
        
});