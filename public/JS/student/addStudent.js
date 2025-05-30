function baseURL() {
    return location.protocol + '//' + location.host + '/';
}

// Open modal
document.getElementById('addStudentButton')?.addEventListener('click', () => {
    document.getElementById('studentModal').classList.remove('hidden');
});

// Close modal
document.getElementById('closeModalStudent').addEventListener('click', () => {
    document.getElementById('studentModal').classList.add('hidden');
    document.getElementById('addStudentForm').reset();
    document.getElementById('studentErrorBox').classList.add('hidden');
});

// Submit form
document.getElementById('addStudentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const errorBox = document.getElementById('studentErrorBox');
    const submitBtn = document.getElementById('insertData');
    errorBox.classList.add('hidden');

    const formData = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        middle_name: document.getElementById('middle_name').value,
        course: document.getElementById('course').value,
        year_level: document.getElementById('editYearLevel').value,
    };

    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding Student...';

    fetch(baseURL() + 'insertStudent', {
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
        submitBtn.textContent = 'Add Student';

        if (data.success) {
            document.getElementById('studentModal').classList.add('hidden');
            document.getElementById('addStudentForm').reset();

            const successModal = document.getElementById('addSuccessModalStudent');
            successModal.classList.remove('hidden');

            setTimeout(() => {
                successModal.classList.add('hidden');
                if ($('#studentTable').length) {
                    $('#studentTable').DataTable().ajax.reload();
                }
            }, 2000);
        } else {
            errorBox.textContent = data.message;
            errorBox.classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorBox.textContent = 'Something went wrong. Please try again.';
        errorBox.classList.remove('hidden');

        submitBtn.disabled = false;
        submitBtn.textContent = 'Add Student';
    });
});