$(document).ready(function() {
    // Initialize DataTable
    const registrationTable = $('#registrationTable').DataTable({
        ajax: {
            url: '/event-registrations',
            dataSrc: ''
        },
        columns: [
            { data: 'registration_id', title: 'Registration ID' },
            { data: 'student_id', title: 'Student ID' },
            { data: 'event_name', title: 'Event' },
            { 
                data: 'status',
                title: 'Status',
                render: function(data) {
                    return `<span class="status-badge ${data.toLowerCase()}">${data}</span>`;
                }
            },
            {
                data: null,
                title: 'Actions',
                render: function(data) {
                    return `
                        <button class="action-btn edit" onclick="openUpdateStatus(${data.registration_id}, '${data.status}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']]
    });

    // Load events for the dropdown
    $.ajax({
        url: '/active-events',
        method: 'GET',
        success: function(events) {
            const eventSelect = $('#event_id');
            events.forEach(event => {
                eventSelect.append(`<option value="${event.event_id}">${event.event_name}</option>`);
            });
        }
    });

    // Filter handling
    $('#filterRegistrationStatus').on('change', function() {
        const status = $(this).val();
        registrationTable.column(3).search(status).draw();
    });

    // Register Event Modal
    $('#registerEventButton').on('click', function() {
        $('#registerEventModal').removeClass('hidden');
    });

    $('#closeRegisterModal, #cancelRegisterBtn').on('click', function() {
        $('#registerEventModal').addClass('hidden');
        $('#registerEventForm')[0].reset();
        $('#registerEventErrorBox').addClass('hidden');
    });

    // Update Status Modal
    $('#closeUpdateStatusModal, #cancelUpdateStatusBtn').on('click', function() {
        $('#updateStatusModal').addClass('hidden');
        $('#updateStatusForm')[0].reset();
        $('#updateStatusErrorBox').addClass('hidden');
    });

    // Register Event Form Submit
    $('#registerEventForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '/register-event',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#registerEventModal').addClass('hidden');
                $('#successModal').removeClass('hidden');
                registrationTable.ajax.reload();

                setTimeout(function() {
                    $('#successModal').addClass('hidden');
                }, 2000);
            },
            error: function(xhr) {
                const errorBox = $('#registerEventErrorBox');
                errorBox.removeClass('hidden').text(xhr.responseJSON.message);
            }
        });
    });

    // Update Status Form Submit
    $('#updateStatusForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '/update-registration-status',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#updateStatusModal').addClass('hidden');
                $('#successModal').removeClass('hidden');
                registrationTable.ajax.reload();

                setTimeout(function() {
                    $('#successModal').addClass('hidden');
                }, 2000);
            },
            error: function(xhr) {
                const errorBox = $('#updateStatusErrorBox');
                errorBox.removeClass('hidden').text(xhr.responseJSON.message);
            }
        });
    });
});

// Open Update Status Modal
function openUpdateStatus(registrationId, currentStatus) {
    $('#update_registration_id').val(registrationId);
    $('#status').val(currentStatus.toLowerCase());
    $('#updateStatusModal').removeClass('hidden');
} 