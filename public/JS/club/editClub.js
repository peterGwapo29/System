function baseURL() {
    return location.protocol + '//' + location.host + '/';
}

$(document).ready(function () {
    let originalEditData = {};

    // Event delegation for opening the edit modal
    document.querySelector('#clubTable').addEventListener('click', function (e) {
        if (e.target.closest('.editClubModalBtn')) {
            const el = e.target.closest('.editClubModalBtn');

            // Store original values
            originalEditData = {
                club_id: el.dataset.club_id,
                club_name: el.dataset.club_name,
                description: el.dataset.club_description,
                adviser_name: el.dataset.adviser_name
            };

            // Populate form fields
            document.getElementById('editClubID').value = originalEditData.club_id;
            document.getElementById('editClubName').value = originalEditData.club_name;
            document.getElementById('editClubDescription').value = originalEditData.description;
            document.getElementById('editClubAdviser').value = originalEditData.adviser_name;
            document.getElementById('club_name_display').textContent = originalEditData.club_name;

            // Show modal
            document.getElementById('editClubModal').classList.remove('hidden');
        }
    });

    // Close modal on cancel or outside click
    document.getElementById('closeEditClubModalBtn').addEventListener('click', closeEditModal);
    document.getElementById('editClubModal').addEventListener('click', function (e) {
        if (e.target.id === 'editClubModal') closeEditModal();
    });

    function closeEditModal() {
        document.getElementById('editClubModal').classList.add('hidden');
        document.getElementById('editClubForm').reset();
    }

    // Handle form submission
    document.getElementById('editClubForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const submitBtn = document.getElementById('updateClubSubmit');

        const currentData = {
            club_id: document.getElementById('editClubID').value,
            club_name: document.getElementById('editClubName').value.trim(),
            description: document.getElementById('editClubDescription').value.trim(),
            adviser_name: document.getElementById('editClubAdviser').value.trim()
        };

        const changed = Object.keys(currentData).some(key => currentData[key] !== originalEditData[key]);

        if (!changed) {
            closeEditModal();
            return;
        }

        if (!currentData.club_name || !currentData.description || !currentData.adviser_name) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'All fields are required. Please fill them out.'
            });
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';

        $.ajax({
            url: baseURL() + 'club/update',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: currentData,
            success: function (response) {
                if (response.status === 'success') {
                    closeEditModal();
                    $('#clubTable').DataTable().ajax.reload();
                    const successModal = document.getElementById('clubUpdateModal');
                    successModal.classList.remove('hidden');
                    setTimeout(() => successModal.classList.add('hidden'), 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update club.'
                    });
                }
            },
            error: function (xhr) {
                let msg = 'Failed to update club.';
                if (xhr.responseJSON?.errors) {
                    msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            },
            complete: function () {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Saved';
            }
        });
    });

    // Optional: Add input event listeners to clear errors
    ['editClubName', 'editClubDescription', 'editClubAdviser'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
            // Implement logic here if needed
        });
    });
});