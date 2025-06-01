$(document).ready(function() {
    // Show edit modal
    $(document).on('click', '.editEventModalBtn', function() {
        const modal = document.getElementById('editEventModal');

        // Fill form fields using data-* attributes
        $('#edit_event_id').val($(this).data('event_id'));
        $('#edit_club_id').val($(this).data('club_id'));
        $('#edit_event_name').val($(this).data('event_name'));
        $('#edit_event_date').val($(this).data('event_date'));
        $('#edit_venue').val($(this).data('venue'));
        $('#edit_event_description').val($(this).data('event_description'));
    
        modal.classList.remove('hidden');

        // Show modal
        modal.classList.remove('hidden');
    });

    // Hide edit modal
    document.getElementById('closeEditEventModal').addEventListener('click', function() {
        document.getElementById('editEventModal').classList.add('hidden');
        document.getElementById('editEventErrorBox').classList.add('hidden');
    });

    // Handle edit form submission
    document.getElementById('editEventForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const errorBox = document.getElementById('editEventErrorBox');

        fetch('event/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide modal and reset form
                document.getElementById('editEventModal').classList.add('hidden');
                document.getElementById('editEventForm').reset();

                // Show success modal
                const successModal = document.getElementById('successModal');
                successModal.classList.remove('hidden');

                // Hide success modal after 2 seconds and reload table
                setTimeout(() => {
                    $('#eventTable').DataTable().ajax.reload();
                    successModal.classList.add('hidden');
                }, 2000);
            } else {
                errorBox.classList.remove('hidden');
                errorBox.innerText = data.message;
            }
        })
        .catch(error => {
            errorBox.classList.remove('hidden');
            errorBox.innerText = "An error occurred while updating the event.";
            console.error('Error:', error);
        });
    });

    // Delete event
    $(document).on('click', '.deleteEventBtn', function() {
        const event_id = $(this).data('id');
        const deleteModal = document.getElementById('deleteEventModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Set event_id for delete confirmation
        confirmDeleteBtn.setAttribute('data-id', event_id);
        deleteModal.classList.remove('hidden');
    });

    // Hide delete modal
    document.getElementById('closeDeleteEventModal').addEventListener('click', function() {
        document.getElementById('deleteEventModal').classList.add('hidden');
    });

    // Confirm delete
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        const event_id = this.getAttribute('data-id');
        const formData = new FormData();
        formData.append('event_id', event_id);

        fetch('event/delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide delete modal
                document.getElementById('deleteEventModal').classList.add('hidden');

                // Show success modal
                const successModal = document.getElementById('successModal');
                successModal.classList.remove('hidden');

                // Hide success modal after 2 seconds and reload table
                setTimeout(() => {
                    $('#eventTable').DataTable().ajax.reload();
                    successModal.classList.add('hidden');
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the event.');
        });
    });

    // Restore event
    $(document).on('click', '.restoreEventBtn', function() {
        const event_id = $(this).data('id');
        const restoreModal = document.getElementById('restoreEventModal');
        const confirmRestoreBtn = document.getElementById('confirmRestoreBtn');

        // Set event_id for restore confirmation
        confirmRestoreBtn.setAttribute('data-id', event_id);
        restoreModal.classList.remove('hidden');
    });

    // Hide restore modal
    document.getElementById('closeRestoreEventModal').addEventListener('click', function() {
        document.getElementById('restoreEventModal').classList.add('hidden');
    });

    // Confirm restore
    document.getElementById('confirmRestoreBtn').addEventListener('click', function() {
        const event_id = this.getAttribute('data-id');
        const formData = new FormData();
        formData.append('event_id', event_id);

        fetch('event/restore', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide restore modal
                document.getElementById('restoreEventModal').classList.add('hidden');

                // Show success modal
                const successModal = document.getElementById('successModal');
                successModal.classList.remove('hidden');

                // Hide success modal after 2 seconds and reload table
                setTimeout(() => {
                    $('#eventTable').DataTable().ajax.reload();
                    successModal.classList.add('hidden');
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while restoring the event.');
        });
    });
});
