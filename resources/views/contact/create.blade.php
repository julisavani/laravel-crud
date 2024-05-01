@extends('auth.layouts')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><strong>content</strong></div>
            <div class="card-body">
                <form id="create_content" enctype="multipart/form-data" autocomplete="off">
                    <input name="id" type="hidden" value="{{@$contact['id']}}" />
                    <div class="form-group row">
                        <div class="col-md-6 elem">
                            <label for="name"> Name</label>
                            <input type="text" name="name" class="form-control"
                                id="university_name" placeholder="Enter  Name">
                        </div>
                        <div class="col-md-6 elem">
                            <label for="email"> E-mail</label>
                            <input type="text" name="email" id="email" class="form-control"
                                placeholder="Enter  Email">
                        </div>
                        <div class="col-md-6 elem mt-3">
                            <label for="message"> message</label>
                            <input type="text" name="message" id="message" class="form-control"
                                placeholder="Enter  message">
                        </div>
                    </div>
                    <button type="submit" id="submit_btn" class="btn btn-primary mt-5">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
      
        $("#create_content").validate({
            rules: {
                name: { required: true },
                email: { required: true, email: true },
                {{-- password: { required: true, minlength: 8 },
                confirm_password: { required: true, minlength: 8, equalTo: "#password" }, --}}
            },
            messages: {
                name: { required: "The name field is required." },
                email: { required: "The email field is required." },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.elem').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var form = $('#create_content')[0];
                var data = new FormData(form);
                $.ajax({
                    url: url + '/contact-us/store',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    statusCode: {
                        200: function(xhr) {
                            $.toast({
                                    heading: "success",
                                    text: xhr.data.message,
                                    position: "top-right",
                                    icon: "success",
                                    position: {
                                        right: 10,
                                        top: 90,
                                },
                            });
                            window.location.href = url + "/contact-us"; 
                            $("#submit_btn").attr("disabled", false);
                        },
                        422: function(xhr) {
                            var result = xhr.responseJSON.error.filter(obj => {
                                    // if( $(`input[name="${obj.name}"]`).val() == "" || ){
                                    $.each(xhr.responseJSON.error, function (indexInArray, valueOfElement) { 
                                        $.toast({
                                                heading: "success",
                                                text: valueOfElement.message,
                                                position: "top-right",
                                                icon: "success",
                                                position: {
                                                    right: 10,
                                                    top: 90,
                                            },
                                        });
                                    });
                                // }
                            })
                        }
                    }
                });
            }
        });
</script>
@endsection