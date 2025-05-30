let studentIdToRestore = null;

document.querySelector('#studentTable').addEventListener('click', function(e) {
    if (e.target.closest('.restoreStudentBtn')) {
        const el = e.target.closest('.restoreStudentBtn');
        studentIdToRestore = el.dataset.student_id;

        document.getElementById('restoreStudentModal').classList.remove('hidden');
    }
});

document.getElementById('cancelRestoreStudentBtn').addEventListener('click', function() {
    document.getElementById('restoreStudentModal').classList.add('hidden');
    studentIdToRestore = null;
});

document.getElementById('confirmRestoreStudentBtn').addEventListener('click', function() {
    if (!studentIdToRestore) return;

    const confirmBtn = this;
    confirmBtn.disabled = true;
    confirmBtn.textContent = 'Restoring...';

    $.ajax({
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'student/restore', // You can keep this as 'account/restore' if it routes to students.
        data: { student_id: studentIdToRestore },
        success: function () {
            $('#studentTable').DataTable().ajax.reload();

            document.getElementById('restoreStudentModal').classList.add('hidden');
            studentIdToRestore = null;
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';

            const modal = document.getElementById('storeSuccessModalStudent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);
        },
        error: function () {
            alert('Failed to restore student.');
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Restore';
        }
    });
});
