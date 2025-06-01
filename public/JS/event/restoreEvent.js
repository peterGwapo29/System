let eventIdToRestore = null;

document.querySelector('#eventTable').addEventListener('click', function(e) {
    if (e.target.closest('.restoreEventBtn')) {
        const el = e.target.closest('.restoreEventBtn');
        eventIdToRestore = el.dataset.event_id;

        // Show the restore confirmation modal
        document.getElementById('restoreEventModal').classList.remove('hidden');
    }
});

// Cancel restore
document.getElementById('closeRestoreEventModal').addEventListener('click', function() {
    document.getElementById('restoreEventModal').classList.add('hidden');
    eventIdToRestore = null;
});

// Confirm restore
document.getElementById('confirmRestoreBtn').addEventListener('click', function() {
    if (!eventIdToRestore) return;

    const confirmBtn = this;
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Restoring...';

    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'event/restore',
        data: { event_id: eventIdToRestore },
        success: function () {
            $('#eventTable').DataTable().ajax.reload();

            document.getElementById('restoreEventModal').classList.add('hidden');
            eventIdToRestore = null;

            const modal = document.getElementById('restoreSuccessModalEvent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);

            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';
        },
        error: function () {
            alert('Failed to restore event.');

            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';
        }
    });
}); 