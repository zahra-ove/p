@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

@section('js')
    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js"
            type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>

        $(document).ready(function () {
            let ezaaf = 1;
            $('.hrefbtn').attr('href', "{{route('order.create')}}");
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

            $('#user').change(function (ev) {
                let userId = $(this).val();
                $.ajax(
                    {
                        url: "{{asset('admin/getactivestatusorderbyuser')}}/" + userId,
                        success: function (data) {
                            $.ajax({
                                url: "{{asset('admin/ajaxekhraaj')}}/" + data.id,
                                success: function (datas) {
                                    function separateNum(value, input) {
                                        /* seprate number input 3 number */
                                        var nStr = value + '';
                                        nStr = nStr.replace(/\,/g, "");
                                        x = nStr.split('.');
                                        x1 = x[0];
                                        x2 = x.length > 1 ? '.' + x[1] : '';
                                        var rgx = /(\d+)(\d{3})/;
                                        while (rgx.test(x1)) {
                                            x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                        }
                                        if (input !== undefined) {
                                            input.value = x1 + x2;
                                        } else {
                                            return x1 + x2;
                                        }
                                    }
                                    $('.cancely').html(datas);
                                    $('.justnumber').on("keypress",function(e)
                                    {

                                        if (isNaN(e.key))
                                        {
                                            e.preventDefault()
                                        }

                                        if (e.key==" "){
                                            e.preventDefault()
                                        }

                                    });
                                    $('.seprator').keyup(function (e){
                                        let value = $(this).val();
                                        separateNum(value,$(this)[0])

                                    });


                                }
                            })
                        }
                    }
                );

            });
            $('#product-attach').change(function (e) {
                let files = e.target.files;
                // console.log(files)
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.single-show-img').remove();
                    $('#noneImg').remove();
                    var imgSrc = theFile.target.result;
                    $('.singleShow').append("<img class='single-show-img' style='width: 400px;height: 400px' src='" + imgSrc + "'> ")
                });
                reader.readAsDataURL(this.files[0]);
            });
            });

    </script>

@endsection
<style>

    #timeTable {
        height: 448.719px;
    }

    .select2 {
        width: 100% !important;
    }

    @media (min-width: 992px) {
        .container {
            max-width: 992px !important;
        }

        .mr-140 {
            margin-right: 140px !important;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1200px !important;
        }
    }


    @media (min-width: 1500px) {
        .container {
            max-width: 1500px !important;
        }
    }


    @media (max-width: 576px) {
        .mr-140 {
            margin-right: 60px !important;
        }
    }

    .breadcrumb {
        background-color: white !important;
    }
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded"
                 style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a>
                        </li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">اخراج افراد
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="container card mb-5 " style="margin-top: 330px;background-color: gainsboro;">
        <div class="row">
            <div class="col-12 col-lg-3 ml-5 mb-5 mt-5 row">
                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                            مشترک
                        </span>

                </div>
                <div class="col-9 p-0 ">
                    <select name="user_id" class="select2 form-control" id="user">
                        <option value="">مشترک را انتخاب کنبد.</option>
                        @if($users!='notfound')
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>



    <!-- reserves table-->
    <div class="container border-top row m-auto cancely">
    </div>
    </div>
@endsection
