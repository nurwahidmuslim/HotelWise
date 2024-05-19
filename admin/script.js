// Add this to your script.js
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
        updateBookingStatus('terima');
    });

    pendingBtn.addEventListener('click', function () {
        updateBookingStatus('pending');
    });

    rejectBtn.addEventListener('click', function () {
        updateBookingStatus('tolak');
    });

    function fetchBookingDetails(id) {
        fetch(`fetch_booking_details.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                modalContent.innerHTML = data;
                overlay.style.display = 'flex';
            })
            .catch(error => console.error('Error:', error));
    }

    function updateBookingStatus(status) {
        const bookingId = document.querySelector('.modal-content').dataset.id;
        fetch(`update_booking_status.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: bookingId, status: status })
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                alert('Status updated successfully');
                overlay.style.display = 'none';
                location.reload(); // Reload the page to see the changes
            } else {
                alert('Failed to update status');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
