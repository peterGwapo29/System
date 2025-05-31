$(document).ready(function() {
    let membershipIdToRestore = null;

    // Debug log to confirm script is loaded
    console.log('Restore membership script initialized');

    // Handle restore membership button click
    $(document).on('click', '.restoreMembershipBtn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        membershipIdToRestore = $(this).data('membership_id');
        console.log('Restore button clicked for membership:', membershipIdToRestore);
        
        // Show the confirmation modal
        const confirmModal = $('#restoreConfirmModal');
        confirmModal.removeClass('hidden');
        confirmModal.css('display', 'flex');
    });

    // Handle cancel button in confirmation modal
    $('#cancelRestoreBtn').on('click', function(e) {
        e.preventDefault();
        const confirmModal = $('#restoreConfirmModal');
        confirmModal.addClass('hidden');
        confirmModal.css('display', 'none');
        membershipIdToRestore = null;
    });
    const restoreButtonChange = document.getElementById('confirmRestoreBtn');
    // Handle confirm button in confirmation modal
    $('#confirmRestoreBtn').on('click', function(e) {
        e.preventDefault();
        console.log('Confirm restore clicked for membership:', membershipIdToRestore);
        
        restoreButtonChange.textContent = 'Restoring...';

        
        if (membershipIdToRestore) {
            // Send AJAX request to update status
            $.ajax({
                url: baseURL() + 'membership/restore/' + membershipIdToRestore,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Restore response:', response);
                    if (response.success) {
                        // Hide confirmation modal
                        const confirmModal = $('#restoreConfirmModal');
                        confirmModal.addClass('hidden');
                        confirmModal.css('display', 'none');
                        
                        // Show success modal
                        const successModal = $('#restoreSuccessModal');
                        successModal.removeClass('hidden');
                        successModal.css('display', 'flex');
                        
                        // Hide success modal after 2 seconds
                        setTimeout(function() {
                            successModal.addClass('hidden');
                            successModal.css('display', 'none');
                            restoreButtonChange.textContent = 'Restore';
                        }, 2000);
                        
                        // Refresh the membership table
                        $('#membershipTable').DataTable().ajax.reload();
                    } else {
                        alert('Failed to restore membership: ' + response.message);
                        restoreButtonChange.textContent = 'Restore';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Restore request failed:', error);
                    alert('Something went wrong while processing your request.');
                    restoreButtonChange.textContent = 'Restore';
                }
            });
        }
    });

    // Close modals if clicked outside
    $('.modal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
            $(this).css('display', 'none');
            membershipIdToRestore = null;
        }
    });
});
