<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">Circular Title</label>
            <textarea name="loan_circular_title" class="form-control loan_circular_title"></textarea>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">Circular Details</label>
            <textarea name="loan_circular_details" class="form-control loan_circular_details"></textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputFile">Circular file attachment (Allow PDF only)</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input circular_doc" name="circular_doc " accept="application/pdf" id="circular_doc">
                    <label class="custom-file-label label_circular_doc" for="exampleInputFile">Choose file</label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="text-align: right;">
        <button type="button" class="btn btn-primary store_loan_circular"> <span class="spinner-icon"></span> Save circular </button>
    </div>
</div>

<script>

    $(document).ready(function() {

        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });

        $(document).on('click', '.store_loan_circular', function () {

            $('.add_response_msg_area').empty();
            var loan_circular_title = $('.loan_circular_title').val();
            var loan_circular_details = $('.loan_circular_details').val();
            var file_for_circular_doc = document.getElementById("circular_doc");
            var has_input_error = false;

            $('.add_response_msg_area').html('');
            $('.loan_circular_title').removeClass('input_error_mark');
            $('.label_circular_doc').removeClass('input_error_mark');

            if (loan_circular_title == '') {
                $('.loan_circular_title').addClass('input_error_mark');
                has_input_error = true;
            }
            if (loan_circular_details == '') {
                $('.loan_circular_details').addClass('input_error_mark');
                has_input_error = true;
            }
            if( file_for_circular_doc.files.length == 0 ){
                $('.label_circular_doc').addClass('input_error_mark');
                has_input_error = true;
            }
            if (has_input_error){
                $('.add_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                $('#add-modal-lg').animate({ scrollTop: 0 }, 'slow');
                return false;
            }

            let formData = new FormData();
            formData.append('circular_doc', $('.circular_doc')[0].files[0]);
            formData.append('circular_title', loan_circular_title);
            formData.append('circular_details', loan_circular_details);
            formData.append('circular_type', 'loan');

            var btn = $(this);
            btn.prop('disabled', true);
            $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

            $.ajax({
                url: '{{ url('/circular/add-new-circular') }}',
                type: "POST",
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: formData,
                success: function (response) {
                    btn.prop('disabled', false);
                    $('.spinner-icon').empty();
                    $('#add-modal-lg').animate({ scrollTop: 0 }, 'slow');

                    if (response.responseCode == 1) {
                        $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                            '                                <strong>Success!</strong> ' + response.message + '\n' +
                            '                            </div>');

                        $('.loan_circular_title').val("");
                        $('.loan_circular_details').val("");
                        $('.circular_doc').val("");

                        $('.alert-success').fadeOut(3000);

                        setTimeout(function () {
                            $('#add-modal-lg').modal('hide');
                        }, 3200);

                    } else {
                        $('.add_response_msg_area').html('<div class="alert alert-danger">\n' +
                            '                                <strong>Error!</strong> ' + response.message + '\n' +
                            '                            </div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        });

    })
</script>
