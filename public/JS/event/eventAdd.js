    // Show modal
    document.getElementById('addEventButton').addEventListener('click', function () {
        document.getElementById('eventModal').classList.remove('hidden');
    });

    // Hide modal
    document.getElementById('closeEventModal').addEventListener('click', function () {
        document.getElementById('eventModal').classList.add('hidden');
    });

    // Submit form with AJAX
    document.getElementById('addEventForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const errorBox = document.getElementById('eventErrorBox');

        fetch('insertEvent', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('eventModal').classList.add('hidden');
                document.getElementById('addEventForm').reset();
        
                // Show success modal
                const successModal = document.getElementById('successModal');
                successModal.classList.remove('hidden');
        
                // Hide success modal after 2 seconds
                setTimeout(() => {
                    $('#eventTable').DataTable().ajax.reload();
                    successModal.classList.add('hidden');
                }, 2000);
        
            } else {
                errorBox.classList.remove('hidden');
                errorBox.innerText = data.message;
            }
        })
        
        .catch(error => {
            errorBox.classList.remove('hidden');
            errorBox.innerText = "An error occurred. Please try again.";
            console.error(error);
        });
    });
