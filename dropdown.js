document.addEventListener('DOMContentLoaded', function() {
    const dropdownIcon = document.getElementById('dropdown-icon');
    const dropdownMenu = document.getElementById('dropdown-menu');

    dropdownIcon.addEventListener('click', function() {
        dropdownMenu.classList.toggle('active');
    });

    document.addEventListener('click', function(event) {
        if (!dropdownIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('active');
        }
    });
});