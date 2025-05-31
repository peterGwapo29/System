function baseURL() {
    return location.protocol + "//" + location.host + "/";
}

document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editMShipModal');
    const closeModalBtn = document.getElementById('mShip_closeModalBtn');
    const editForm = document.getElementById('editMShipForm');
    const membershipTable = document.getElementById('membershipTable');

    // Open and populate modal with data from button
    function openEditModal(data) {
        document.getElementById('mShip_membershipId').textContent = data.membership_id || '';
        document.getElementById('mShip_membershipIdInput').value = data.membership_id || '';
        document.getElementById('mShip_studentId').value = data.student_id || '';
        document.getElementById('mShip_membershipType').value = data.membership_type || '';
        document.getElementById('mShip_clubName').value = data.club_name || '';
        editModal.classList.remove('hidden');
    }

    // Close modal
    function closeEditModal() {
        editModal.classList.add('hidden');
    }

    // Click on edit button inside table
    membershipTable.addEventListener('click', (e) => {
        const btn = e.target.closest('.editMshipModal');
        if (btn) {
            const data = {
                membership_id: btn.getAttribute('data-membership_id'),
                student_id: btn.getAttribute('data-student_id'),
                membership_type: btn.getAttribute('data-membership_type'),
                club_name: btn.getAttribute('data-club_name'),
            };
            openEditModal(data);
        }
    });

    // Cancel / close modal button
    closeModalBtn.addEventListener('click', closeEditModal);

    // Close modal on backdrop click
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Submit updated membership
    editForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const submitBtn = document.getElementById('mShip_updateSubmit');
    const errorBox = document.getElementById('mShip_errorBox');

    // Clear previous error messages
    errorBox.textContent = '';
    errorBox.classList.add('hidden');

    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';

    const payload = {
        membership_id: document.getElementById('mShip_membershipIdInput').value,
        student_id: document.getElementById('mShip_studentId').value,
        membership_type: document.getElementById('mShip_membershipType').value,
        club_name: document.getElementById('mShip_clubName').value,
    };

    fetch(baseURL() + 'membership/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(payload),
    })
    .then(response => response.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save';

        if (data.success) {

            // Show success modal
            const successModal = document.getElementById('editSuccessModalMship');
            if (successModal) {
                successModal.classList.remove('hidden');
                setTimeout(() => {
                    closeEditModal();
                    successModal.classList.add('hidden');
                }, 2000);
            }

            // Reload DataTable
            if ($.fn.DataTable.isDataTable('#membershipTable')) {
                $('#membershipTable').DataTable().ajax.reload();
            }
        } else {
            // Show error message inside modal error box
            if (data.message) {
                errorBox.textContent = data.message;
                errorBox.classList.remove('hidden');
            } else {
                alert('Update failed.');
            }
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while updating membership.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Save';
    });
});

});
