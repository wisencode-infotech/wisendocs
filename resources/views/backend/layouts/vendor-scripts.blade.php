<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/backend/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/js/pages/toastr.min.js')}}"></script>
<script src="{{ URL::asset('assets/backend/js/pages/toastr.init.js')}}"></script>
<script src="{{ URL::asset('assets/backend/js/pages/chart.js')}}"></script>
<script>

    function execPostAjax(URL, data, callback = null, errorcallback = null) {
        $.ajax({
            type: 'POST',
            url: URL,
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name='csrf-token']").content,
                'X-Initiator': 'backend'
            },
            data: data,
            dataType: 'json',
            beforeSend: function() {
                
            },
            success: function(response) {
                callback(response);
            },
            error: function(xhr, status, error) {
                if(errorcallback) {
                    errorcallback(xhr);
                }
            }
        });
    }

    function toastAcknowledgements(xhr)
    {
        if (xhr.status === 200) {
            toastSuccessMsgs(xhr);
        } else {
            toastValidationErrors(xhr);
        }
    }

    function toastSuccessMsgs(response)
    {
        if (response.hasOwnProperty('message')) {
            if (response.hasOwnProperty('status') && response.status)
                toastr.success(response.message);
            else
                toastr.error(response.message);
        }
    }

    function toastValidationErrors(xhr)
    {
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, message) {
                toastr.error(message);
            });
        } else {
            toastr.error(SOMETHING_WENT_WRONG_TEXT);
        }
    }

    $('#change-password').on('submit',function(event){
        event.preventDefault();
        var Id = $('#data_id').val();
        var current_password = $('#current-password').val();
        var password = $('#password').val();
        var password_confirm = $('#password-confirm').val();
        $('#current_passwordError').text('');
        $('#passwordError').text('');
        $('#password_confirmError').text('');
        $.ajax({
            url: "{{ url('update-password') }}" + "/" + Id,
            type:"POST",
            data:{
                "current_password": current_password,
                "password": password,
                "password_confirmation": password_confirm,
                "_token": "{{ csrf_token() }}",
            },
            success:function(response){
                $('#current_passwordError').text('');
                $('#passwordError').text('');
                $('#password_confirmError').text('');
                if(response.isSuccess == false){ 
                    $('#current_passwordError').text(response.Message);
                }else if(response.isSuccess == true){
                    setTimeout(function () {   
                        window.location.href = "{{ route('backend.home') }}"; 
                    }, 1000);
                }
            },
            error: function(response) {
                $('#current_passwordError').text(response.responseJSON.errors.current_password);
                $('#passwordError').text(response.responseJSON.errors.password);
                $('#password_confirmError').text(response.responseJSON.errors.password_confirmation);
            }
        });
    });
</script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/backend/js/app.min.js')}}"></script>

@yield('script-bottom')