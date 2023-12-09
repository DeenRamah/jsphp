$(document).ready(function () {
    // Fetch emails on page load
    fetchEmails();

    // Set interval to fetch emails every 5 minutes (adjust as needed)
    setInterval(fetchEmails, 300000); // 300000 milliseconds = 5 minutes

    function fetchEmails() {
        $.ajax({
            url: 'm.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                displayEmails(data);
            },
            error: function () {
                console.error('Error fetching emails');
            }
        });
    }

    function displayEmails(emails) {
        var emailList = $('#emailList');
        emailList.empty();

        if (emails.length === 0) {
            emailList.append('<p>No recent emails.</p>');
        } else {
            for (var i = 0; i < emails.length; i++) {
                var emailHtml = '<div class="email">' +
                    '<p><strong>Subject:</strong> ' + emails[i].subject + '</p>' +
                    '<p><strong>From:</strong> ' + emails[i].from + '</p>' +
                    '</div>';
                emailList.append(emailHtml);
            }

            // Simulate WhatsApp alert (replace with actual WhatsApp integration)
            alert('You have new emails!');
        }
    }
});
