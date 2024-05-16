document.addEventListener('DOMContentLoaded', function() {
    var alerts = document.querySelectorAll('[id^="x-alert"]');

    alerts = Array.from(alerts);

    alerts.forEach(function(alert) {
        setTimeout(function () {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(function () {
                alert.remove();
            }, 500); 
        }, 5000); 
    });
});