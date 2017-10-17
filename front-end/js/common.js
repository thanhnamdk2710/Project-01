$_DOMAIN = 'http://localhost:7000/Project/Project-01/';

$(document).ready(function() {
	$('#imageCarousel').carousel();
});

$('#formFeedback button').on('click', function() {
	$this = $('#formFeedback button');
	$this.html('Đang gửi...');

	// Gán giá trị vào biến
	$name_feedback = $('#formFeedback #name').val();
	$email_feedback = $('#formFeedback #email').val();
	$phone_feedback = $('#formFeedback #phone').val();
	$body_feedback = $('#formFeedback #body').val();

	// Nếu các giá trị rỗng
	if ($name_feedback == '' || $email_feedback == '' || $phone_feedback == '' || $body_feedback == '') {
		$('#formFeedback .alert').removeClass('hidden');
        $('#formFeedback .alert').html('Vui lòng điền đầy đủ thông tin.');
        $(this).html('Góp ý');
	} else {
		$.ajax({
			url: $_DOMAIN + 'contact.php',
			type: 'POST',
			data: {
				name_feedback: $name_feedback,
				email_feedback: $email_feedback,
				phone_feedback: $phone_feedback,
				body_feedback: $body_feedback,
				action: 'feedback'
			}, success : function(data) {
                $('#formFeedback .alert').removeClass('hidden');
                $('#formFeedback .alert').html(data);
                $this.html('Góp ý');
            }, error : function() {
                $('#formFeedback .alert').removeClass('hidden');
                $('#formFeedback .alert').html('Không thể góp ý vào lúc này, hãy thử lại sau.');
                $this.html('Góp ý');
            }
		});
	}
});