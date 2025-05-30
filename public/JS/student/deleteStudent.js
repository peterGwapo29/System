
// Deletion confirmation modal
let studentIdToDelete = null;

document.querySelector('#studentTable').addEventListener('click', function(e) {
    if (e.target.closest('.deleteStudentBtn')) {
        const el = e.target.closest('.deleteStudentBtn');
        studentIdToDelete = el.dataset.student_id;

        // Show the deletion confirmation modal
        document.getElementById('studentDLTConfirmModal').classList.remove('hidden');
    }
});

// Cancel deletion
document.getElementById('studentDLTCancelBtn').addEventListener('click', function() {
    document.getElementById('studentDLTConfirmModal').classList.add('hidden');
    studentIdToDelete = null;
});

// Confirm deletion
document.getElementById('studentDLTConfirmBtn').addEventListener('click', function() {
    if (!studentIdToDelete) return;

        const confirmBtn = this;
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Deleting...';

    $.ajax({
        type: 'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        url: baseURL() + 'student/delete',
        data: { student_id: studentIdToDelete },
        success: function () {
            $('#studentTable').DataTable().ajax.reload();

            document.getElementById('studentDLTConfirmModal').classList.add('hidden');
            studentIdToDelete = null;

            const modal = document.getElementById('deleteSuccessModalStudent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 2500);

            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Delete';
        },
        error: function () {
            alert('Failed to delete student.');

            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Delete';
        }
    });
});