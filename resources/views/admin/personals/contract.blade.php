@extends('admin.master.home')

@section('js')
    <script>
        $(document).ready(function () {


            CKEDITOR.replace('contract', {
                language: "fa",


            });
            $('#content').text(CKEDITOR.instances.contract.getData());
            CKEDITOR.instances.contract.on('change', function(e) {
                $('#content').text(CKEDITOR.instances.contract.getData());
            });
            $(".datePick").persianDatepicker({
                    alwaysShow: true, closeOnBlur: true,

            });
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

                $('#mobileList').append(`   <li class="row " style="border-bottom: 1px solid #aaaaaa">
                                        <div class="col-12 mt-3 mb-3 row" >
                                            <span class="col-3" style="font-size: 18px;text-align: left">${index + 1}.</span>
                                           <span class="col-9 p-0"> <input name="mobiles[]" class="form-control justnumber mobileInput"></span>
                                        </div>

                                    </li>`);
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

            $('.mobileInput').change(function (e) {
                $('#mobileList').append(`<li class="p-1">${$(this).val()}</li>`)
            });
            $("#submit").submit(function (e) {
                $('.cardnumber').val($('.cardnumber').val().replaceAll('-',""));
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
                if (birth.length < 10) {
                    e.preventDefault();
                    $('#personalBirthday').addClass('border-red');
                } else {
                    $('#personalBirthday').removeClass('border-red');
                }
                if (personalEmail.length == "") {
                    e.preventDefault();
                    $('#personalEmail').addClass('border-red');
                } else if (personalEmail.includes("@") == false) {
                    e.preventDefault();
                    $('#personalEmail').addClass('border-red');
                } else {
                    $('#personalEmail').removeClass('border-red');
                }

                $('#personalBirthday').val(birthday);

                console.log(ncodetype)
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
    @media print {
        .w-100 {
            display: none;
        }
        #nav-wrapper{
            display: none;
        }

        .position-fixed{
            display: none;
        }

            .card{
                display: block; width: 100%; height: 100%;
                margin-top: 0px!important;
                padding: 0px!important;
                /* change the margins as you want them to be. */
            }

            #cke_contract{
                display: none;
            }
        #content{
            display: block!important; ;
        }
    }
    /*html,body{*/
    /*    height:297mm;*/
    /*    width:210mm;*/
    /*}*/
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">لیست پرسنل</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">قرداد کاری {{$user->name.' '.$user->family}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <div class="container card" style="margin-top: 330px">
        <div class="mx-auto pt-2">
            <img width="150" src="{{asset('img')}}/logokarpng.png">
            <h3 style="font-family: BTitr;text-align: center">قرارداد کار</h3>
        </div>

<div class="content-contract p-5">
    <textarea name="contract" class="w-100" id="contract">
            آقا/خانم/شرکت {{$user->name.' '.$user->family}} فرزند ....... شماره شناسنامه(ش.ش) ............ شماره ثبت ........... به نشانی .......... کد پستی ......... .

    2-1 کارگر/کارمند

    آقا / خانم .......... فرزند ......... متولد .......... شماره شناسنامه(ش.ش) ........... شماره ملّی {{$user->ncode}} میزان تحصیلات ............. نوع و میزان مهارت .............. به نشانی .................. کد پستی ............. .
    </textarea>

<p id="content" style="display: none"></p>
        <div class="w-100 text-center mt-2" style="margin-bottom: 100px">
            <button class="btn btn-secondary w-25" id="print" onclick="print()">
                پرینت
            </button>
        </div>

    </div>

@endsection
