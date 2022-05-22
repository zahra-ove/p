@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {
            $('#gallery').hide();
            let addpubcheck = [];
//////ckeditor
//             CKEDITOR.replace('editor', {
//                 language: "fa",
//
//             });
            $('#showItem').change(function (e) {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });

            $('#pansionPick').change(function (ev) {
                let pansionId = $(this).val();
                $.ajax(
                    {
                        url: "{{asset('admin/getroombypansion')}}/" + pansionId,
                        success: function (data) {
                            $('#roomId').empty()
                            $('#roomId').append(`<option value="">اتاق راانتخاب کنید.</option>`);
                            data.forEach(function (item, index) {
                                $('#roomId').append(`<option value="${item.id}"> طبقه ${item.floor} اتاق ${item.roomnumber}  </option> `)
                            })

                        }
                    }
                )


            });
$('#roomId').change(function (ev) {
    let id =$(this).val();
    $('#gallery').show();
    $.ajax(
        {
            url:"{{asset('admin/getroombyid')}}/" + id,
            success: function (data) {
                data.photos.forEach(function (item,index){
                    $('#gallery').append(`<div class="col-12 col-lg-3 row">
                    <div class="col-12">
                       <img class="w-100" src="{{asset('')}}/${item.path}">
                    </div>
                    <div class="col-12 text-center my-3">
                      <input name="path" type="radio" value="${item.path}">
                    </div>

                    <br>

                     </div>`);
                });
            }

        }
    );
});

//
// // Read in the image file as a data URL.

//             });


            $("#submit").submit(function (e) {


                // let description = CKEDITOR.instances.editor.getData();
                // let url = $("#urlVideo").val();
                let show = 0;
                $('#price').val($('#price').val().replaceAll(',', ""));
                if ($('#showItem').is(':checked')) {
                    $('#show').val('2');


                } else {
                    $('#show').val('1');
                }

            });

        });
    </script>
@endsection
<style>
    @media (min-width: 1400px){
        .container {
            max-width: 1350px!important;
        }
    }

    @media (min-width: 992px){
        .mr-140{
            margin-right: 140px!important;
        }
    }
    @media (max-width: 576px){
        .mr-140{
            margin-right:60px!important;
        }
    }
    .breadcrumb{
        background-color: white!important;
    }
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">اتاق منتخب</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('roompickstore')}}" enctype="multipart/form-data" id="submit">
        @csrf
        <div class="container card" style="margin-top: 330px;background-color: gainsboro">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row justify-content-between px-4">
                        <div class="col-lg-6 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">انتخاب پانسیون</span>
                            </div>
                            <div class="col-9 p-0 ">
                            <select name="pansionId" class="form-control select2" id="pansionPick">
                                <option value="">پانسیون را انتخاب کنید.</option>
                                @if($pansions!="notfound")
                                    @foreach($pansions as $pansion)
                                        <option value="{{$pansion->id}}">{{$pansion->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">انتخاب اتاق</span>
                            </div>
                            <div class="col-9 p-0 ">
                            <select name="roomId" class="form-control select2" id="roomId">
                                <option value="">اتاق را انتخاب کنید.</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-lg-6 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">نوبت</span>
                            </div>
                            <div class="col-9 p-0 ">
                            <input min="1" type="number" class="form-control" name="order" id="order" autocomplete="off">
                        </div>
                        </div>
<div class="col-12 row" id="gallery">
    <div class="col-12">
        <h2>عکس های اتاق</h2>
    </div>

</div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5 mt-5 row pl-5">
                    <div class="col-12 text-center">
                        <div class="col-12 mb-3">
                            <button class="w-50 btn btn-success pt-2 pb-2" id="ostansubmit">ثبت</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </form>
    </div>

@endsection
