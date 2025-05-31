function baseURL() {
    return location.protocol + '//' + location.host + '/';
}

document.getElementById('addMembershipButton').addEventListener('click', () => {
    document.getElementById('membershipModal').classList.remove('hidden');
});

document.getElementById('closeModalMembership').addEventListener('click', () => {
    document.getElementById('membershipModal').classList.add('hidden');
});

document.getElementById('addMembershipForm').addEventListener('submit', function (e) {
e.preventDefault();
const errorBox = document.getElementById('membershipErrorBox');
const submitBtn = document.getElementById('submitMembershipBtn');
errorBox.classList.add('hidden');
const formData = {
    student_id: document.getElementById('membership_student_id').value,
    membership_type: document.getElementById('membership_type').value,
    club_name: document.getElementById('membership_clubName').value,
};

    submitBtn.disabled = true;
    submitBtn.textContent = 'Adding Membership...';
    fetch(baseURL() + 'insertMembership', {
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
        submitBtn.textContent = 'Add Membership';
        if (data.success) {
            document.getElementById('membershipModal').classList.add('hidden');
            const successModal = document.getElementById('addSuccessModalMship');
            successModal.classList.remove('hidden');
            addMembershipForm.reset();
            $('#membershipTable').DataTable().ajax.reload();
            setTimeout(() => {
                successModal.classList.add('hidden');
            }, 2000);
        } else {
            errorBox.textContent = data.message || 'Failed to add membership.';
            errorBox.classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorBox.textContent = 'Something went wrong. Please try again.';
        errorBox.classList.remove('hidden');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Add Membership';
    });
});

