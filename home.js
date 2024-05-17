$(function() {
    var today = new Date();
    var tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);
    
    function formatDateWithDay(date) {
        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var dayName = days[date.getDay()];
        var day = ('0' + date.getDate()).slice(-2);
        var monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        var month = monthNames[date.getMonth()];
        var year = date.getFullYear();
        return dayName + ', ' + day + ' ' + month + ' ' + year;
    }
    
    $("#checkin_box").click(function() {
        $("#checkin_date").datepicker("show");
    });

    $("#checkout_box").click(function() {
        $("#checkout_date").datepicker("show");
    });

    $("#checkin_date").datepicker({
        dateFormat: 'DD, dd MM yy',
        minDate: 0,
        onSelect: function(dateText, inst) {
            var selectedDate = new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay);
            var endDate = new Date(selectedDate);
            endDate.setDate(selectedDate.getDate() + 1);
            $("#checkout_date").datepicker("option", "minDate", endDate);
            $("#checkin_date").val(formatDateWithDay(selectedDate));
            $("#checkout_date").val(formatDateWithDay(endDate));
        }
    });

    $("#checkout_date").datepicker({
        dateFormat: 'DD, dd MM yy',
        minDate: 1,
        onSelect: function(dateText, inst) {
            var selectedDate = new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay);
            $("#checkout_date").val(formatDateWithDay(selectedDate));
        }
    });

    $("#checkin_date").datepicker("setDate", today);
    $("#checkout_date").datepicker("setDate", tomorrow);
    $("#checkin_date").val(formatDateWithDay(today));
    $("#checkout_date").val(formatDateWithDay(tomorrow));
});

let selectedOption = document.getElementById('selectedOption');
selectedOption.innerText = "1 Room, 2 Guests";

function toggleOptions() {
    let options = document.getElementById('options');
    if (options.style.display === 'block') {
        options.style.display = 'none';
    } else {
        options.style.display = 'block';
    }
}

document.addEventListener('click', function(event) {
    let options = document.getElementById('options');
    let boxBottom = document.querySelector('.box-bottom');
    if (!options.contains(event.target) && !boxBottom.contains(event.target)) {
        options.style.display = 'none';
    }
});
function selectRoomOption(option) {
    selectedOption.innerText = option + selectedOption.innerText.split(',')[1];
    toggleOptions();
}

function selectGuestOption(option) {
    selectedOption.innerText = selectedOption.innerText.split(',')[0] + ', ' + option;
    toggleOptions();
}