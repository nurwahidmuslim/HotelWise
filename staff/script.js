document.addEventListener('DOMContentLoaded', function () {
    const detailLinks = document.querySelectorAll('.detail-link');
    const overlay = document.getElementById('overlay');
    const modalContent = document.getElementById('modal-content');
    const acceptBtn = document.getElementById('accept-btn');
    const pendingBtn = document.getElementById('pending-btn');
    const rejectBtn = document.getElementById('reject-btn');

    detailLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const bookingId = this.dataset.id;
            fetchBookingDetails(bookingId);
        });
    });

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            overlay.style.display = 'none';
        }
    });

    acceptBtn.addEventListener('click', function () {
        updateBookingStatus('Diterima');
    });

    pendingBtn.addEventListener('click', function () {
        updateBookingStatus('Pending');
    });

    rejectBtn.addEventListener('click', function () {
        updateBookingStatus('Ditolak');
    });

    function fetchBookingDetails(id) {
        fetch(`fetch_booking_details.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
                modalContent.setAttribute('data-id', id); // Set ID pemesanan pada modal content
                overlay.style.display = 'flex';
            })
            .catch(error => console.error('Error:', error));
    }

    function updateBookingStatus(status) {
        const bookingId = modalContent.getAttribute('data-id'); // Ambil ID pemesanan dari atribut data-id
        console.log(`Updating status for booking ID ${bookingId} to ${status}`); // Debug log

        fetch(`update_booking_status.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: bookingId, status: status })
        })
        .then(response => response.text())
        .then(data => {
            console.log(`Response from server: ${data}`); // Debug log
            if (data === 'success') {
                alert('Status updated successfully');
                overlay.style.display = 'none';
                location.reload(); // Reload the page to see the changes
            } else {
                alert('Failed to update status: ' + data);
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
