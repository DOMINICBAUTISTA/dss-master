$(document).ready(function() {
    $('.restore-button').click(function(event) {
        event.preventDefault();

        var studentId = $(this).data('student-id');

        $.ajax({
            url: '../functions/manage_students/restore_students.php',
            type: 'GET',
            data: {
                student_id: studentId
            },
            success: function(response) {
                if (response.status === 'success') {
                    swal({
                        type: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: 'brown'
                    }, function() {
                        setTimeout(function() {
                            location.reload();
                        }, 100);
                    });
                } else {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: 'red'
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Failed to restore student',
                    confirmButtonColor: 'red'
                });
            }
        });
    });
});
