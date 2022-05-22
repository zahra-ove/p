{{--<form action="{{route("testy")}}" method="post">--}}
{{--    @csrf--}}
    <input name="name" id="ss">
    <input type="submit" value="ok" id="sub">
{{--</form>--}}
<!--jquery min js-->
<script src="{{asset("js")}}/jquery.min.js"></script>
<script src="{{asset("js")}}/toastr.min.js"></script>
<link rel="stylesheet" href="{{ asset('css') }}/toastr.min.css">
<script>
    $("#sub").click(function () {
        $.ajax(
            {
                url:"{{asset("testy")}}",
                type:"post",
                data:{"_token":"{{csrf_token()}}",
                    "name":$('#ss').val()},
                success: function (data){
                    console.log(data)
                    if (data=="ok"){
                        location.href="{{asset("admin/s")}}";
                    }
                }
            }
        )
    });

</script>
@toastr_render
