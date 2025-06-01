document.getElementById('addAccountButton').addEventListener('click', () => {
    document.getElementById('addAccountModal').classList.remove('hidden');
});

document.getElementById('cancelAddBtn').addEventListener('click', () => {
    document.getElementById('addAccountModal').classList.add('hidden');
});

function baseURL() {
    return location.protocol +"//" + location.host + "/";
}

document.getElementById('addAccountButton')?.addEventListener('click', () => {
    document.getElementById('addAccountModal').classList.remove('hidden');
});

document.getElementById('cancelAddBtn').addEventListener('click', () => {
    document.getElementById('addAccountModal').classList.add('hidden');
});

function baseURL() {
    return location.protocol + '//' + location.host + '/';
}

document.getElementById('addAccountForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const errorBox = document.getElementById('addAccountError');
    const submitBtn = document.getElementById('submitAddBtn');
    errorBox.classList.add('hidden');

    const formData = {
        student_id: document.getElementById('student_id').value,
        username: document.getElementById('username').value,
        password: document.getElementById('password').value,
        email: document.getElementById('email').value,
    };

    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding Account...';

    fetch(baseURL() + 'accounts/insert', {
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
        submitBtn.textContent = 'Add';

        if (data.success) {
            document.getElementById('addAccountModal').classList.add('hidden');

            const successModal = document.getElementById('successModal');
            successModal.classList.remove('hidden');

            setTimeout(() => {
                successModal.classList.add('hidden');
                $('#accountTable').DataTable().ajax.reload();
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
        submitBtn.textContent = 'Add';
    });
});
