@extends('admin.master.home')

@section('js')
    <script>

        $(document).ready(function () {
            $(".datePick").persianDatepicker({

            });

            let birthday = "";
            let ncodetype = [];
            $('.file-attach').change(function (e) {

                if ($(this).siblings('.ncodetype').val() == 'no') {
                    $(this).val(null)
                    toastr.warning('شرمنده');
                    e.preventDefault();

                }
            })
            $('.ncodetype').on('click', function () {
                // Store the current value on focus and on change
                previous = this.value;
            }).change(function (e) {
                if (previous != 'no') {
                    let previousIndex = ncodetype.indexOf(previous);
                    ncodetype.splice(previousIndex, 1);
                }

                $('.file-attach').change(function (e) {

                    let files = e.target.files;
                    let $this = $(this);
                    let reader = new FileReader();
                    reader.onload = (function (theFile) {
                        var imgSrc = theFile.target.result;
                        $this.parents('.col-6').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ")
                    });
                    reader.readAsDataURL(this.files[0]);
                });
                if (ncodetype.includes($(this).val())) {

                    $(this).children('option[value="no"]').prop('selected', true);
                    toastr.warning('هر کارت شناسایی را فقط یکدفعه می توان انتخاب نمود.');
                } else {
                    if ($(this).val() != 'no') {
                        $(this).siblings('').prop('disabled', false);
                    } else {

                        $(this).siblings('input').prop('disabled', true);
                        $(this).siblings('input').val(null);
                        $(this).parents('.col-6').siblings('.ncodePic').empty();
                    }

                    if ($(this).val() != 'no') {
                        ncodetype.push($(this).val())
                    }


                }


            });
            $('.file-attach').siblings('label').click(function (e) {

                if ($(this).siblings('input').prop('disabled')) {
                    toastr.warning('نوع کارت شناسایی خود را انتخاب کنید.');
                }
            });
            $('#personalOstan').change(function (e) {
                let id = $(this).val();
                $.ajax(
                    {
                        url: "{{asset('admin/getcitybyostan')}}/" + id,
                        success: function (data) {
                            $('#personalCity').empty();
                            $('#personalCity').append(`<option value="">شهر خود را انتخاب کنید.</option>`);
                            data.forEach(function (item, index) {
                                $('#personalCity').append(`<option value="${item.id}">${item.name}</option>`);
                            })
                        }
                    }
                );
            });
            let index = 0;

            $('#plusMobile').click(function (e) {

                $('.removeMobile').parents('span').first().remove();
                $('#mobileList').append(`   <li class="row mobileList"  style="border-bottom: 1px solid #aaaaaa">
                                        <div class="col-12 mt-3 mb-3 row" >
                                            <span class="col-2" style="font-size: 18px;text-align: left">${index + 1}.</span>
                                           <span class="col-9 p-0"> <input name="mobiles[]" class="form-control justnumber mobileInput"></span>
                                        </div>

                                    </li>`);
                $('.mobileList').last().append(`   <span class="col-1 text-center mt-3">
                                                <span class="btn mt-1 p-0 removeMobile" data-id="" style="cursor: pointer"><i class="fa fa-minus fa-2x"></i> </span>
                                             </span>`);

                $('.justnumber').on("keypress", function (e) {

                    if (isNaN(e.key)) {
                        e.preventDefault()
                    }

                    if (e.key == " ") {
                        e.preventDefault()
                    }

                });
                $(".mobileInput").keyup(function (event) {
                    if ($(this).val()[0] != 0 && event.key != 'Backspace' && isNaN(event.key) == false) {
                        $(this).val($(this).val().slice(0, -1));
                        toastr.error('حتما باید با صفر شروع شود.')
                    }
                    if ($(this).val()[1] != 9 && event.key != "Backspace" && isNaN(event.key) == false) {
                        if ($(this).val()[1] != undefined) {
                            $(this).val($(this).val().slice(0, -1));
                            toastr.error('عدد دوم باید عدد 9 باشد.')
                        }
                    }

                });
                $('.mobileInput').on("keypress", function (e) {
                    if ($(this).val().length > 10) {
                        e.preventDefault();
                    }
                });

                index = index + 1;
            });
            $(document).on('click','.removeMobile',function (es){
                index=index-1;
                $('.mobileList').last().remove();
                $('.mobileList').last().append(`   <span class="col-1 text-center mt-3">
                                         <span class="btn mt-1 p-0 removeMobile"  data-id="" style="cursor: pointer"><i class="fa fa-minus fa-2x"></i> </span>
                                      </span>`);
            });
            $('.mobileInput').change(function (e) {
                $('#mobileList').append(`<li class="p-1">${$(this).val()}</li>`)
            });
            $("#submit").submit(function (e) {
                $('.cardnumber').val($('.cardnumber').val().replaceAll('-', ""));
                $('.totalncode').val(ncodetype);
                if (ncodetype.length != $('.single-show-img').length) {
                    e.preventDefault();
                    toastr.error('کارت شناسایی ها درست ثبت نشده اند.');
                }
                let personalName = $('#personalName').val();
                let personalFamily = $('#personalFamily').val();
                let personalNcode = $('#personalNcode').val();
                let birth = $('#personalBirthday').val();

                let personalMobilecode = $('#personalMobilecode').val();
                let personalPhone = $('#personalPhone').val();
                if ($("#personalGenderMale").is(":checked")) {
                    var personalGender = $('#personalGenderMale').val();
                } else if ($("#personalGenderFemale").is(":checked")) {
                    var personalGender = $('#personalGenderFemale').val();
                }
                let personalEmail = $('#personalEmail').val();
                let personalCity = $('#personalCity').val();
                let personalCardnumber = $('#personalCardnumber').val();
                let addrTitle = $('#addrtitle').val();
                let addr = $('#addr').val();
                if (birthday != $('#personalBirthday').val()) {
                    dateSplittedBirth = birth.split("/"),
                        jDBirth = JalaliDate.jalaliToGregorian(dateSplittedBirth[0], dateSplittedBirth[1], dateSplittedBirth[2]);
                    birthday = jDBirth[0] + "-" + jDBirth[1] + "-" + jDBirth[2];
                }


                if (personalName == "") {
                    e.preventDefault();
                    $('#personalName').addClass('border-red');
                } else {
                    $('#personalName').removeClass('border-red');
                }
                if (personalFamily == "") {
                    e.preventDefault();
                    $('#personalFamily').addClass('border-red');
                } else {
                    $('#personalFamily').removeClass('border-red');
                }
                if (personalCity == "") {
                    e.preventDefault();
                    $('.select2-selection').addClass('border-red');
                } else {
                    $('.select2-selection').removeClass('border-red');
                }
                if (personalNcode.length < 10) {
                    e.preventDefault();
                    $('#personalNcode').addClass('border-red');
                } else {
                    $('#personalNcode').removeClass('border-red');
                }
                if (personalMobilecode.length < 11) {
                    e.preventDefault();
                    $('#personalMobilecode').addClass('border-red');
                } else {
                    $('#personalMobilecode').removeClass('border-red');
                }
                if (personalPhone.length < 8) {
                    e.preventDefault();
                    $('#personalPhone').addClass('border-red');
                } else {
                    $('#personalPhone').removeClass('border-red');
                }
                if (personalCardnumber.length < 16) {
                    e.preventDefault();
                    $('#personalCardnumber').addClass('border-red');
                } else {
                    $('#personalCardnumber').removeClass('border-red');
                }
                if (birth.length < 8) {
                    e.preventDefault();
                    $('#personalBirthday').addClass('border-red');
                } else {
                    $('#personalBirthday').removeClass('border-red');
                }


                $('#personalBirthday').val(birthday);
                if ( $('#personalBirthday').val().split('-').includes('NaN')){
                    $('#personalBirthday').val('');
                    e.preventDefault();
                    $('#personalBirthday').addClass('border-red');
                    toastr.error('تاریخ درج شده نا معتبر است.');
                }
                if (ncodetype.includes("1") == false || ncodetype.includes("2") == false) {
                    e.preventDefault();
                    toastr.error('شناسنامه و کارت ملی باید حتماٌ ثبت شوند.')
                }
                if ($('.border-red').length != 0) {
                    toastr.error('لطفا کادر های قرمز را تکمیل کنید.');
                }
            });


        })
    </script>
@endsection
@section('css')
    .select2 {
        width: 100% !important;
    }

    @media (min-width: 1400px) {
        .container {
            max-width: 1350px !important;
        }
    }

    @media (min-width: 992px) {
        .mr-140 {
            margin-right: 140px !important;
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
@endsection
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">افزودن
                            مشترک
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <div class="container card" style="margin-top: 330px;background-color: gainsboro">

        <form id="submit" action="{{route('storeuser')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12 row justify-content-between px-4 ">
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">نام</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control" name="name" autocomplete="off" id="personalName">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">نام خانوادگی</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control" name="family" class="form-control" id="personalFamily">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">تاریخ تولد</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control birthday datePick" name="birthday" id="personalBirthday"
                                   placeholder="__/__/____" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">کد ملی</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control ncode justnumber" name="ncode" autocomplete="off"
                                   id="personalNcode">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">تلفن ثابت</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control phone justnumber" name="phone" class="form-control"
                                   id="personalPhone"
                                   placeholder="66912959">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">شماره کارت</span>

                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control cardnumber justnumber" name="cardnumber" autocomplete="off"
                                   id="personalCardnumber"
                                   placeholder="6393-4610-4567-9853">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">استان</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <select name="ostan" class="form-control select2" id="personalOstan">
                                <option value="">استان را انتخاب کنید.</option>
                                @if($ostans!="notfound")
                                    @foreach($ostans as $ostan)
                                        <option value="{{$ostan->id}}">{{$ostan->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">شهر</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <select name="city_id" class="form-control select2" id="personalCity">
                                <option value="">شهر را انتخاب کنید.</option>
                                {{--                        @if($cities!="notfound")--}}
                                {{--                            @foreach($cities as $city)--}}
                                {{--                                <option value="{{$city->id}}">{{$city->cityName}}</option>--}}
                                {{--                            @endforeach--}}
                                {{--                        @endif--}}
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">شماره موبایل</span>

                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control justnumber mobileInput" name="mobilecode" autocomplete="off"
                                   id="personalMobilecode" placeholder="09121234567">
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3 mt-5 row">
                        <div class="col-12 row">
                            <div class="col-6">
                                شماره تماس بیشتر
                            </div>
                            <span class="col-6" id="plusMobile" style="height: 33px;cursor: pointer">
                           <i
                               class="fa fa-plus fa-2x"></i></span>
                            </span>
                        </div>
                        <ol id="mobileList">

                        </ol>
                    </div>
                    <div class="col-lg-4 mb-5 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">جنسیت</span>
                        </div>
                        <div class="col-md-3 mt-2 row">
                            <div class="col-4">
                                <label for="personalGenderMale">مرد</label>
                            </div>
                            <div class="col-4">
                                <input id="personalGenderMale" type="radio"
                                       class="@error('gender') is-invalid @enderror"
                                       name="gender" required
                                       value="male" checked>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 row">
                            <div class="col-4">
                                <label for="personalGenderFemale">زن</label>
                            </div>
                            <div class="col-6">
                                <input id="personalGenderFemale" type="radio"
                                       class="@error('gender') is-invalid @enderror"
                                       name="gender" required
                                       value="female">
                            </div>
                        </div>
                        <div class="col-md-3 row text-lg-left text-center">
                        <span style="cursor:pointer;height: 40px" class="btn btn-info" data-toggle="modal"
                              data-target="#modalPhoto">
                            ثبت کارت شناسایی
                        </span>
                            <!-- PhotoModal -->
                            <div id="modalPhoto" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header row" style="text-align: right" dir="ltr">
                                            <button type="button" class="close m-1" data-dismiss="modal">&times;
                                            </button>
                                            <div class="col-12">
                                                <h3 class="w-100">اطلاعات کار شناسایی</h3>
                                            </div>
                                            <div class="col-12">
                                                <p class="alert-warning" style="text-align: right">.اگر پس از انتخاب و
                                                    آپلود تصویر تصمیم به حذف کارت شناسایی داشتید، گزینه نوع کارت شناسایی
                                                    را روی هیچکدام قرار بدهید </p>

                                            </div>

                                        </div>
                                        <div class="modal-body">
                                            @if($ncodetypes!='notfound')
                                                <div class="container-fluid">

                                                    @for($i=0;$i<count($ncodetypes);$i++)
                                                        <div class="row" style="border-bottom: 1px solid #aaaa">
                                                            <div class="col-6 my-2" style="text-align: right">
                                                                <label class="mt-2">نوع کارت شناسایی</label>
                                                                <select class="form-control ncodetype">

                                                                    <option value="no">هیچکدام</option>
                                                                    @foreach($ncodetypes as $ncodetype)
                                                                        <option
                                                                            value="{{$ncodetype->id}}">{{$ncodetype->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label for="attach-{{$i}}"
                                                                       class="btn btn-info mt-2 file-attach-label">انتخاب
                                                                    عکس</label>
                                                                <input name="attach[]" disabled
                                                                       class="d-none file-attach" id="attach-{{$i}}"
                                                                       type="file">
                                                            </div>
                                                            <div class="col-6 my-2 ncodePic" style="height: 150px">

                                                            </div>
                                                        </div>
                                                    @endfor
                                                    <input name="ncodetype" class="d-none totalncode">
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-5 mt-5 row">
                    </div>
                    <div class="col-12">
                        <h3>آدرس</h3>
                    </div>
                    <div class="col-12 col-md-4 mb-2 mt-5 row">
                        <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative" style="top: 24%">عنوان آدرس</span>

                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control" name="addrTitle" id="addrtitle">
                        </div>
                    </div>
                    <div class="col-12 mb-5 mt-2 row">
                        <div class="form-label mb-2 col-1 p-0 text-center position-relative h-100" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                            <span class="form-label mb-2 position-relative h-100" style="top: 24%">آدرس</span>

                        </div>
                        <div class="col-11 p-0 ">
                            <textarea class="form-control" name="addr" id="addr"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5 mt-5 row" style="margin-bottom: 100px!important;">
                    <div class="col-lg-6 mb-3 text-lg-right text-center">
                    </div>
                    <div class="col-lg-6 col-12 mb-3 text-lg-right text-center">
                        <button type="submit" class="w-25 btn btn-success pt-2 pb-2" id="personalsubmit">ثبت
                        </button>
                    </div>
                </div>

            </div>

        </form>

    </div>

@endsection
