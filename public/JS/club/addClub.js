// Base URL Function
function baseURL() {
    return location.protocol + '//' + location.host + '/';
}

// Open Club Modal
document.getElementById('addClubButton')?.addEventListener('click', () => {
    document.getElementById('clubModal').classList.remove('hidden');
});

// Close Club Modal
document.getElementById('closeModalClub')?.addEventListener('click', () => {
    document.getElementById('clubModal').classList.add('hidden');
});
document.getElementById('addClubForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const errorBox = document.getElementById('clubErrorBox');
    const submitBtn = document.getElementById('insertClub');
    const clubModal = document.getElementById('clubModal');
    const successModal = document.getElementById('addSuccessModalClub');

    errorBox.classList.add('hidden');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding Club...';

    const formData = {
        club_name: document.getElementById('club_name').value.trim(),
        club_description: document.getElementById('club_description').value.trim(),
        adviser_name: document.getElementById('adviser_name').value.trim(),
    };

    fetch(baseURL() + 'club/insert', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Add Club';

        if (data.status === 'success') {
            // Close form modal
            clubModal.classList.add('hidden');

            // Clear form inputs
            document.getElementById('addClubForm').reset();

            // Show success modal
            successModal.classList.remove('hidden');

            // Optional: Auto-hide success modal after 2 seconds
            setTimeout(() => {
                successModal.classList.add('hidden');
                // Reload DataTable
                $('#clubTable').DataTable().ajax.reload();
            }, 2000);
        } else {
            errorBox.textContent = data.message || 'Failed to add club.';
            errorBox.classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorBox.textContent = 'Something went wrong. Please try again.';
        errorBox.classList.remove('hidden');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Add Club';
    });
});

document.getElementById('closeSuccessModalClub')?.addEventListener('click', () => {
    document.getElementById('addSuccessModalClub').classList.add('hidden');
});