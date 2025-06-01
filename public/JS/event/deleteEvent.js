// Deletion confirmation modal
let eventIdToDelete = null;

document.querySelector('#eventTable').addEventListener('click', function(e) {
    if (e.target.closest('.deleteEventBtn')) {
        const el = e.target.closest('.deleteEventBtn');
        eventIdToDelete = el.dataset.event_id;

        // Show the deletion confirmation modal
        document.getElementById('eventDLTConfirmModal').classList.remove('hidden');
    }
});

// Cancel deletion
document.getElementById('eventDLTCancelBtn').addEventListener('click', function() {
    document.getElementById('eventDLTConfirmModal').classList.add('hidden');
    eventIdToDelete = null;
});

// Confirm deletion
document.getElementById('eventDLTConfirmBtn').addEventListener('click', function() {
    if (!eventIdToDelete) return;

    const confirmBtn = this;
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Deleting...';

    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'event/delete',
        data: { event_id: eventIdToDelete },
        success: function () {
            $('#eventTable').DataTable().ajax.reload();

            document.getElementById('eventDLTConfirmModal').classList.add('hidden');
            eventIdToDelete = null;

            const modal = document.getElementById('deleteSuccessModalEvent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);

            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Delete';
        },
        error: function () {
            alert('Failed to delete event.');

            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Delete';
        }
    });
}); 