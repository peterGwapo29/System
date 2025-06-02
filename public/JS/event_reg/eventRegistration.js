$(document).ready(function() {
    // Initialize DataTable
    new DataTable('#event_regTable', {
        ajax: {
            url: baseURL() + 'event_registration/list',
            data: function (d) {
                d.status = document.getElementById('filterStatus').value;
            }
        },
        processing: true,
        serverSide: true,
        columnDefs: [
            {targets: '_all', visible: true},
            {targets: [4], width: '150px', className: 'text-center'},
            {targets: [5], width: '42px'},
        ],
        columns: [
            {
                data: 'registration_id',
                name: 'registration_id',
                title: 'Registration ID',
                className: 'text-left'
            },
            {
                data: 'student_id',
                name: 'student_id',
                title: 'Student ID',
                className: 'text-left'
            },
            {
                data: 'event_id',
                name: 'event_id',
                title: 'Event ID',
                className: 'text-left'
            },
            {
                data: 'event_name',
                name: 'event_name',
                title: 'Event Name',
                className: 'text-left'
            },
            {
                data: 'status',
                name: 'status',
                title: 'Status',
                className: 'text-left',
                render: function(data) {
                    if (data === 'Pending') {
                        return `
                            <span class="status-badge-event pending-status-event">
                                <span class="status-circle-event"></span> Pending
                            </span>
                        `;
                    } else if (data === 'Approved') {
                        return `
                            <span class="status-badge-event approved-status-event">
                                <span class="status-circle-event"></span> Approved
                            </span>
                        `;
                    } else if (data === 'Rejected') {
                        return `
                            <span class="status-badge-event rejected-status-event">
                                <span class="status-circle-event"></span> Rejected
                            </span>
                        `;
                    } else if (data === 'Cancelled') {
                        return `
                            <span class="status-badge-event cancelled-status-event">
                                <span class="status-circle-event"></span> Cancelled
                            </span>
                        `;
                    } else if (data === 'Completed') {
                        return `
                            <span class="status-badge-event completed-status-event">
                                <span class="status-circle-event"></span> Completed
                            </span>
                        `;
                    }
                    return data;
                }
            },
            {
                data: null,
                title: 'Actions',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (row) {
                    return `
                        <div class="relative inline-block text-left">
                            <button class="action-dropdown-toggle p-2 rounded-full hover:bg-gray-200 focus:outline-none" data-id="${row.registration_id}">
                                <svg style="color:rgb(39, 155, 7);" class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm5 0a2 2 0 114 0 2 2 0 01-4 0zm5 0a2 2 0 114 0 2 2 0 01-4 0z"/>
                                </svg>
                            </button>
                            <div class="action-dropdown hidden absolute right-0 z-20 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-md">
                                <ul class="py-1 text-sm text-gray-700">
                                    <li><button class="status-action w-full text-left px-4 py-2 hover:bg-gray-100" data-id="${row.registration_id}" data-status="Pending">Mark as Pending</button></li>
                                    <li><button class="status-action w-full text-left px-4 py-2 hover:bg-gray-100" data-id="${row.registration_id}" data-status="Approved">Mark as Approved</button></li>
                                    <li><button class="status-action w-full text-left px-4 py-2 hover:bg-gray-100" data-id="${row.registration_id}" data-status="Rejected">Mark as Rejected</button></li>
                                    <li><button class="status-action w-full text-left px-4 py-2 hover:bg-gray-100" data-id="${row.registration_id}" data-status="Cancelled">Mark as Cancelled</button></li>
                                    <li><button class="status-action w-full text-left px-4 py-2 hover:bg-gray-100" data-id="${row.registration_id}" data-status="Completed">Mark as Completed</button></li>
                                </ul>
                            </div>
                        </div>
                    `;
                }
            }            
        ]
    });

    // Toggle action dropdown menu
    $(document).on('click', '.action-dropdown-toggle', function (e) {
        e.stopPropagation();
        $('.action-dropdown').not($(this).next()).hide(); // Close others
        $(this).next('.action-dropdown').toggle();        // Toggle this one
    });

    // Close dropdown when clicking outside
    $(document).on('click', function () {
        $('.action-dropdown').hide();
    });

    // Handle status action button clicks
    $(document).on('click', '.status-action', function () {
        const registrationId = $(this).data('id');
        const status = $(this).data('status');
        
        // Show status change confirmation modal
        $('#newStatus').text(status);
        $('#statusChangeModal').removeClass('hidden');
        
        // Store the data for later use
        $('#confirmStatusBtn').data({
            'registration_id': registrationId,
            'status': status
        });
    });

    // Handle confirm status change
    $('#confirmStatusBtn').on('click', function() {
        const $btn = $(this);
        const originalText = $btn.text();
    
        const registrationId = $btn.data('registration_id');
        const newStatus = $btn.data('status').toLowerCase();
    
        // Get the current status from the row in the table
        const rowData = $('#event_regTable').DataTable().row($(`button[data-id="${registrationId}"]`).parents('tr')).data();
        const currentStatus = rowData.status?.toLowerCase();
    
        // If no change, just close the modal
        if (newStatus === currentStatus) {
            $('#statusChangeModal').addClass('hidden');
            return;
        }
    
        $btn.prop('disabled', true).text('Confirming...');
    
        $.ajax({
            url: '/update-registration-status',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                registration_id: registrationId,
                status: newStatus,
            },
            success: function(response) {
                $('#statusChangeModal').addClass('hidden');
                $('#statusSuccessModal').removeClass('hidden');
                $('#event_regTable').DataTable().ajax.reload();
    
                setTimeout(function() {
                    $('#statusSuccessModal').addClass('hidden');
                }, 2000);
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Failed to update status.');
            },
            complete: function() {
                $btn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    
    // Handle cancel status change
    $('#cancelStatusBtn').on('click', function() {
        $('#statusChangeModal').addClass('hidden');
    });

    // Close modal when clicking outside
    $(document).on('click', function(e) {
        if ($(e.target).is('#statusChangeModal')) {
            $('#statusChangeModal').addClass('hidden');
        }
    });

    // Load students for the dropdown
    $.ajax({
        url: '/available-students',
        method: 'GET',
        success: function(students) {
            const studentSelect = $('#student_id');
            students.forEach(student => {
                studentSelect.append(`<option style="color: black;" value="${student.student_id}">${student.name}</option>`);
            });
        },
        error: function(xhr) {
            console.error('Failed to load students:', xhr.responseJSON?.message);
        }
    });

    // Load events for the dropdown
    $.ajax({
        url: '/active-events',
        method: 'GET',
        success: function(events) {
            const eventSelect = $('#event_id');
            events.forEach(event => {
                eventSelect.append(`<option style="color: black;" value="${event.event_id}">${event.event_name}</option>`);
            });
        },
        error: function(xhr) {
            console.error('Failed to load events:', xhr.responseJSON?.message);
        }
    });

    // Show registration modal
    $('#addRegbutton').on('click', function() {
        $('#registerEventModal').removeClass('hidden');
        $('body').addClass('overflow-hidden'); // Prevent background scrolling
    });

    // Hide registration modal
    $('#cancelRegisterBtn, #closeRegisterBtn').on('click', function() {
        closeRegisterModal();
    });

    // Close modal when clicking outside
    $('#registerEventModal').on('click', function(e) {
        if (e.target === this) {
            closeRegisterModal();
        }
    });

    // Function to close registration modal
    function closeRegisterModal() {
        $('#registerEventModal').addClass('hidden');
        $('#registerEventForm')[0].reset();
        $('#registerEventErrorBox').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    }

    // Handle registration form submission
    $('#registerEventForm').on('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button and show loading state
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html(`
            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Registering...
        `);

        const formData = $(this).serialize();

        $.ajax({
            url: '/register-event',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                closeRegisterModal();
                $('#successModal').removeClass('hidden');
                $('#event_regTable').DataTable().ajax.reload();

                setTimeout(function() {
                    $('#successModal').addClass('hidden');
                }, 2000);
            },
            error: function(xhr) {
                const errorBox = $('#registerEventErrorBox');
                errorBox.removeClass('hidden')
                    .text(xhr.responseJSON?.message || 'Failed to register for event.');
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
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

    // Update Status Modal
    $('#closeUpdateStatusModal, #cancelUpdateStatusBtn').on('click', function() {
        $('#updateStatusModal').addClass('hidden');
        $('#updateStatusForm')[0].reset();
        $('#updateStatusErrorBox').addClass('hidden');
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

    // Filter status change event
    document.getElementById('filterStatus').addEventListener('change', function () {
        $('#event_regTable').DataTable().ajax.reload();
    });
});

// Open Update Status Modal
function openUpdateStatus(registrationId, currentStatus) {
    $('#update_registration_id').val(registrationId);
    $('#status').val(currentStatus.toLowerCase());
    $('#updateStatusModal').removeClass('hidden');
} 