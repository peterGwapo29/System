$(document).ready(function() {
    let membershipIdToDelete = null;

    // Debug log to confirm script is loaded
    console.log('Delete membership script initialized');

    // Handle delete membership button click with improved event delegation
    $(document).on('click', '.deleteMshipBtn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        membershipIdToDelete = $(this).data('membership_id');
        console.log('Delete button clicked for membership:', membershipIdToDelete);
        
        // Show the confirmation modal
        const confirmModal = $('#membershipDLTConfirmModal');
        confirmModal.removeClass('hidden');
        confirmModal.css('display', 'flex');
    });

    // Handle cancel button in confirmation modal
    $('#membershipDLTCancelBtn').on('click', function(e) {
        e.preventDefault();
        const confirmModal = $('#membershipDLTConfirmModal');
        confirmModal.addClass('hidden');
        confirmModal.css('display', 'none');
        membershipIdToDelete = null;
    });

    const deleteBtnMship =document.getElementById('membershipDLTConfirmBtn');
    // Handle confirm button in confirmation modal
    $('#membershipDLTConfirmBtn').on('click', function(e) {
        e.preventDefault();
        console.log('Confirm delete clicked for membership:', membershipIdToDelete);
        deleteBtnMship.textContent = 'Deleting...';
        
        if (membershipIdToDelete) {
            // Send AJAX request to update status
            $.ajax({
                url: baseURL() + 'membership/delete/' + membershipIdToDelete,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Delete response:', response);
                    if (response.success) {
                        // Hide confirmation modal
                        const confirmModal = $('#membershipDLTConfirmModal');
                        confirmModal.addClass('hidden');
                        confirmModal.css('display', 'none');
                        
                        // Show success modal
                        const successModal = $('#membershipDeleteModal');
                        successModal.removeClass('hidden');
                        successModal.css('display', 'flex');
                        
                        // Hide success modal after 2 seconds
                        setTimeout(function() {
                            successModal.addClass('hidden');
                            successModal.css('display', 'none');
                            deleteBtnMship.textContent = 'Delete';
                        }, 2000);
                        
                        // Refresh the membership table
                        $('#membershipTable').DataTable().ajax.reload();
                    } else {
                        alert('Failed to deactivate membership: ' + response.message);
                        deleteBtnMship.textContent = 'Delete';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Delete request failed:', error);
                    alert('Something went wrong while processing your request.');
                    deleteBtnMship.textContent = 'Delete';
                }
            });
        }
    });

    // Close modals if clicked outside
    $('.modal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
            $(this).css('display', 'none');
            membershipIdToDelete = null;
        }
    });
});
