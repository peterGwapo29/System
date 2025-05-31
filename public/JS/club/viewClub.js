$(document).ready(function() {
    let clubTable = $('#clubTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '/club/list',
            data: function(d) {
                d.status = $('#filterStatusClub').val();
            }
        },
        columns: [
            {
                data: 'club_id',
                name: 'club_id',
                title: 'Club ID',
                className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100'
            },
            {
                data: 'club_name',
                name: 'club_name',
                title: 'Club Name',
                className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100'
            },
            {
                data: 'club_description',
                name: 'club_description',
                title: 'Description',
                className: 'px-6 py-4 text-m text-gray-900 dark:text-gray-100',
                render: function(data) {
                    const maxLength = 50;
                    if (data.length > maxLength) {
                        return `<span title="${data}">${data.substring(0, maxLength)}...</span>`;
                    }
                    return data;
                }
            },
            {
                data: 'adviser_name',
                name: 'adviser_name',
                title: 'Adviser Name',
                className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100'
            },
            
            { 
                data: 'status',
                name: 'status',
                title: 'Status',
                className: 'px-6 py-4 whitespace-nowrap text-sm',
                render: function(data) {
                    if (data === 'Active') {
                        return '<span class="status-badge-club active-status-club"><span class="status-circle-club"></span> Active</span>';
                    } else {
                        return '<span class="status-badge-club inactive-status-club"><span class="status-circle-club"></span> Inactive</span>';
                    }
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                title: 'Actions',
                className: 'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100',
                render: function(data) {
                    if (data.status === 'Inactive') {
                        return `<span class="text-gray-400 italic">
                            <a href="javascript:void(0)"
                                class="table-action restoreClubBtn"
                                title="Restore Club"
                                data-club_id="${data.club_id}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </a>
                        </span>`;
                    }

                    return `<div id="table-action">
                        <a href="javascript:void(0)" 
                            class="table-action editClubModalBtn" 
                            title="Edit Club" 
                            data-club_id="${data.club_id}"
                            data-club_name="${data.club_name}"
                            data-club_description="${data.club_description}"
                            data-adviser_name="${data.adviser_name}"
                            data-status="${data.status}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>

                        <a href="javascript:void(0)"
                            class="table-action deleteClubBtn"
                            title="Delete Club"
                            data-club_id="${data.club_id}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>`;
                }
            }
        ],
    });

    // Handle status filter change
    $('#filterStatusClub').on('change', function() {
        clubTable.ajax.reload();
    });

    // Refresh table after operations
    window.refreshClubTable = function() {
        clubTable.ajax.reload();
    };
}); 

