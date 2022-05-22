@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

@section('js')
{{--    <script src="https://rawgit.com/abdennour/hijri-date/master/cdn/hijri-date-latest.js"--}}
{{--            type="text/javascript"></script>--}}
    <script src="{{asset('admin/js/hijri-date-latest.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin')}}/js/jdate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>

        $(document).ready(function () {


                $('#DataTables_Table_0_wrapper').hide();
                $('.dataTables_paginate').hide();
                $('#DataTables_Table_0_info').hide();

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

            $('#pansion').change(function (ev) {
                let userId = $(this).val();
                $.ajax(
                    {
                        url: "{{asset('admin/getfulltakhtbypansion')}}/" + userId,
                        success: function (data) {

                            $('tbody').empty()
                            if (data != 'notfound') {
                                $('#DataTables_Table_0_wrapper').show();
                                data.forEach(function (item, index) {
                                    $('tbody').append(`<tr data-id="${item.id}">
<td>${index + 1}</td>
<td>${item.pansion}</td>
<td>${item.fullname}</td>
<td>${item.roomnumber}</td>
<td>${item.takhtnumber}</td>
<td>${item.order_number}</td>
<td>${item.jalaliRaft}</td>
<td>${item.jalaliBargasht}</td>
<!--<td></td>-->
</tr>


`);
                                })  ;
                            } else {
                                $('table').hide();
                                $('.container.card.px-5').append(`<p style="padding: 20px" class="alert-danger">رزروی برای مشترک وجود ندارد.</p>`)
                            }


                        }
                    }
                );


            });
            // $('#urlVideo').change(function (e) {
            //     let video = $('#video');
            //     let urlVal = $(this).val();
            //     video.empty();
            //     video.append(`<source src="${urlVal}" type="video/mp4">`)
            //     // video.onload = function() {
            //     // show video element
            //     video.removeClass('d-none');
            //     // }
            //
            //     // video.onerror = function() {
            //     //     alert('error, couldn\'t load');
            //     //     // don't show video element
            //     // }
            // });
            ///setProductsForm
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
//
// // Read in the image file as a data URL.

//             });


            $("#submit").submit(function (e) {

                if ($('#paytype').val()=='q'){

                    if ($('.jalal').length==0){
                        e.preventDefault();
                        toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');
                    }
                    else {
                        $('.jalal').each(function (index) {

                            if ($(this).val()==""){

                                e.preventDefault();
                                toastr.error('باید تعداد نوبت و تاریخ ماه ها مشخص شود.');

                            }
                            else {

                                // let clicktarikh = $(this).val().split('/');
                                // clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                                // let miladi = clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                                // $(this).val(miladi);

                            }


                        });


                    }
                    let clicktarikh=$(this).attr('tarikh').split('/');
                    clickDate = JalaliDate.jalaliToGregorian(clicktarikh[0], clicktarikh[1], clicktarikh[2]);
                    let miladi=clickDate[0] + "-" + clickDate[1] + "-" + clickDate[2];
                }


            });

        })
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
        .taheHeight {
            height: 565px;
        }
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
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">لیست تخت های پر </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="container card px-5" style="margin-top: 330px;background-color: gainsboro;">
        <div class="row">
            <div class="col-12 col-lg-3 mb-5 mt-5 row">
                <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                      <span class="position-relative" style="top: 24%">
                            خوابگاه
                        </span>

                </div>
                <div class="col-9 p-0 ">
                    <select name="user_id" class="select2 form-control" id="pansion">
                        <option value="">خوابگاه را انتخاب کنبد.</option>
                        @if($pansions!='notfound')
                            @foreach($pansions as $pansion)
                                <option value="{{$pansion->id}}">{{$pansion->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>



    <!-- reserves table-->

        <h2 class="mb-3 pt-2">جدول رزرو ها</h2>
        <div class="table-responsive-md">
        <table class="align-right table table-hover table-dark table-striped mytable w-100 px-5">
            <thead>
            <tr>

                <th>شماره لیست</th>
                <th>نام پانسیون</th>
                <th>نام ساکن</th>
                <th>شماره اتاق</th>
                <th>شماره تخت</th>
                <th>شماره رزرو</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
{{--                <th>مشاهدات</th>--}}

            </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
        </div>
    </div>

@endsection
