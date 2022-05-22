@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {

            ////detach
            $('.removePhoto').click(function (e) {
                let id = $(this).attr('user-id');
                let photoId = $(this).attr('photo-id');
                let $this=$(this);
                $.ajax({
                    url:"{{asset('admin/detachphtouser')}}/" +id+ '/'+photoId,
                    success:function (data) {
                        if(data=='ok'){
                            toastr.success('تصویر حذف شد.');
                            $this.parents('.radif').first().remove();
                        }
                    }
                })
            });

            let birthday = "";
            let ncodetype = [];
            let ncodetypes = [];
            $('.ncodetype').each(function (index) {

                if ($(this).val() != 'no') {
                    $(this).siblings('').prop('disabled', false)
                    ncodetypes.push($(this).val());
                }
            });


            $('.file-attach').change(function (e) {


                if ($(this).siblings('.ncodetype').val() == 'no') {
                    $(this).val(null)
                    toastr.warning('شرمنده');
                    e.preventDefault();

                }
                if (ncodetype.includes($(this).siblings('.ncodetype').val()) == false && $(this).siblings('.ncodetype').val() != 'no') {
                    ncodetype.push($(this).siblings('.ncodetype').val());
                }


                let files = e.target.files;
                let $this = $(this);
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    var imgSrc = theFile.target.result;
                    $this.parents('.col-6').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ")
                });
                reader.readAsDataURL(this.files[0]);
            });
            $('.ncodetype').on('click', function () {
                // Store the current value on focus and on change
                previous = this.value;
            }).change(function (e) {
                $(this).parents('.col-6').siblings('.ncodePic').empty();
                if (previous != 'no') {
                    let previousIndex = ncodetype.indexOf(previous);
                    ncodetype.splice(previousIndex, 1);
                }


                if (ncodetypes.includes($(this).val())) {

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

            $("#edit-submit").submit(function (e) {
                @if($user!='notfound')
                let id = "{{$user->id}}";
                @endif
                $('.totalncode').val(ncodetype);
                if (ncodetype.length != $('.single-show-img').length) {
                    e.preventDefault();
                    toastr.error('کارت شناسایی ها درست ثبت نشده اند.');
                }
                let userName = $('#userName').val();
                let userFamily = $('#userFamily').val();
                let proveiderNcode = $('#proveiderNcode').val();
                let birth = $('#userBirthday').val();
                let userMobilecode = $('#userMobilecode').val();
                let userPhone = $('#userPhone').val();
                if ($("#userGenderMale").is(":checked")) {
                    var userGender = $('#userGenderMale').val();
                } else if ($("#userGenderFemale").is(":checked")) {
                    var userGender = $('#userGenderFemale').val();
                }
                let userEmail = $('#userEmail').val();

                let userCity = $('#userCity').val();
                let userCardnumber = $('#userCardnumber').val();
                let password = $('#submit-pass').val();

                if (birthday != $('#userBirthday').val()) {
                    dateSplittedBirth = birth.split("/"),
                        jDBirth = JalaliDate.jalaliToGregorian(dateSplittedBirth[0], dateSplittedBirth[1], dateSplittedBirth[2]);
                    birthday = jDBirth[0] + "-" + jDBirth[1] + "-" + jDBirth[2];
                    $('#userBirthday').val(birthday);
                }


                if (userName == "") {
                    e.preventDefault();
                    $('#userName').addClass('border-red');
                } else {
                    $('#userName').removeClass('border-red');
                }
                if (userFamily == "") {
                    e.preventDefault();
                    $('#userFamily').addClass('border-red');
                } else {

                    $('#userFamily').removeClass('border-red');
                }
                if (userCity == "") {
                    e.preventDefault();
                    $('.select2-selection').addClass('border-red');
                } else {
                    $('.select2-selection').removeClass('border-red');
                }
                if (proveiderNcode.length < 10) {
                    e.preventDefault();
                    $('#proveiderNcode').addClass('border-red');
                } else {

                    $('#proveiderNcode').removeClass('border-red');
                }
                if (userMobilecode.length < 11) {
                    e.preventDefault();
                    $('#userMobilecode').addClass('border-red');
                } else {
                    $('#userMobilecode').removeClass('border-red');
                }
                if (userPhone.length < 8) {
                    e.preventDefault();
                    $('#userPhone').addClass('border-red');
                } else {
                    $('#userPhone').removeClass('border-red');
                }
                if (userCardnumber.length < 16) {
                    e.preventDefault();
                    $('#userCardnumber').addClass('border-red');
                } else {
                    $('#userCardnumber').removeClass('border-red');
                }
                if (birth.length < 10) {
                    e.preventDefault();
                    $('#userBirthday').addClass('border-red');
                } else {
                    $('#userBirthday').removeClass('border-red');
                }
                if (userEmail.length == "") {
                    e.preventDefault();
                    $('#userEmail').addClass('border-red');
                } else if (userEmail.includes("@") == false) {
                    e.preventDefault();
                    $('#userEmail').addClass('border-red');
                } else {
                    $('#userEmail').removeClass('border-red');
                }

                if (password.length < 8) {
                    e.preventDefault();
                    $('#submit-pass').addClass('border-red');
                } else {
                    $('#submit-pass').removeClass('border-red');
                }
                if (userName != "" && userFamily != "" && userCity != "" && proveiderNcode.length == 10 && userMobilecode.length == 11
                    && userPhone.length == 8 && userCardnumber.length == 16 && userEmail.length != "" && userEmail.includes("@")
                    && password.length > 8) {
                    $('#userBirthday').val(birthday);
                }
                $('#userBirthday').val(birthday);


                if ($('.border-red').length != 0) {
                    toastr.error('لطفا کادر های قرمز را تکمیل کنید.');
                }
            });
        });
    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    @if($user->group()->where('group_id','2')->exists())
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header py-2 mt-3 px-3 align-self-center d-sm-flex w-100 rounded"
                 style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a>
                        </li>
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('personal.index')}}">لیست
                                پرسنل</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">ویرایش
                            اطلاعات پرسنل {{$user->name}} {{$user->family}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @elseif($user->group()->where('group_id','3')->exists())
        <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
            <div class="col-12  align-self-center">
                <div class="sub-header py-2 mt-3 px-3 align-self-center d-sm-flex w-100 rounded"
                     style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a>
                            </li>
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('indexcustom')}}">لیست
                                    مشترکین</a></li>
                            <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">ویرایش
                                اطلاعات پرسنل {{$user->name}} {{$user->family}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    @else
        <h2>ناشناس</h2>
    @endif
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('personal.update',$user->id)}}" enctype="multipart/form-data" id="edit-submit">
        @csrf
        @method("patch")
        <div class="container card" style="margin-top: 330px;background-color: gainsboro">
            <div class="row">
                <div class="col-lg-12 row m-auto  justify-content-between px-4 ">
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
                            <input class="form-control" value="{{$user->name}}" name="name" autocomplete="off"
                                   id="userName">
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
                            <input class="form-control" value="{{$user->family}}" name="family" class="form-control"
                                   id="userFamily">
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
                            <input class="form-control" name="birthday"
                                   value="{{str_replace('-','/',Verta($user->birthday)->formatDate())}}"
                                   id="userBirthday"
                                   placeholder="__/__/____" required>
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
                            <input class="form-control ncode justnumber" value="{{$user->ncode}}" name="ncode"
                                   autocomplete="off" id="proveiderNcode">
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
                            <input class="form-control phone justnumber" value="{{$user->phone}}" name="phone"
                                   class="form-control" id="userPhone"
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
                            <span class="form-label mb-2 position-relative" style="top: 24%">شماره موبایل</span>
                        </div>
                        <div class="col-9 p-0 ">
                            <input class="form-control justnumber mobileInput" value="{{$user->mobilecode}}"
                                   name="mobilecode" autocomplete="off"
                                   id="userMobilecode" placeholder="09121234567">
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
                            <span class="form-label mb-2 position-relative" style="top: 24%">تغییر رمز</span>
                        </div>
                        <div class="col-9 p-0 ">
                        <input class="form-control justnumber" value="{{$user->password}}" name="newPass"
                               autocomplete="off"
                               id="submit-pass" type="password" placeholder="حداقل 8 رقم باشد">
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
                        <input class="form-control cardnumber justnumber" value="{{$user->cardnumber}}"
                               placeholder="6393461045679853" name="cardnumber" autocomplete="off" id="userCardnumber"
                               placeholder="6393461045679853">
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
                        <select name="city_id" class="form-control select2" id="userCity">
                            <option value="">شهر را انتخاب کنید.</option>
                            @if($cities!="notfound")
                                @foreach($cities as $city)
                                    @if($city->id==$user->city_id)
                                        <option value="{{$city->id}}" selected>{{$city->cityName}}</option>
                                    @else
                                        <option value="{{$city->id}}">{{$city->cityName}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
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
                        <div class="col-9 p-0 row m-auto">
                        @if($user->gender=='male')
                            <div class="col-md-4">
                                <div class="col-4">
                                    <label for="userGenderMale">مرد</label>
                                </div>
                                <div class="col-6">
                                    <input id="userGenderMale" type="radio" name="gender" value="male" checked>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-4">
                                    <label for="userGenderFemale">زن</label>
                                </div>
                                <div class="col-6">
                                    <input id="userGenderFemale" type="radio" name="gender" required value="female">
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="col-4">
                                    <label for="userGenderMale">مرد</label>
                                </div>
                                <div class="col-6">
                                    <input id="userGenderMale" type="radio" name="gender" value="male">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-4">
                                    <label for="userGenderFemale">زن</label>
                                </div>
                                <div class="col-6">
                                    <input id="userGenderFemale" type="radio" name="gender" required value="female"
                                           checked>
                                </div>
                            </div>
                        @endif

                    </div>
                    </div>
                    <div class="col-12">
                        <h3>آدرس</h3>
                    </div>

                    <div class="col-12 col-md-6 mb-2 mt-5">
                        <label class="form-label col-12 col-md-6" for="signup-password-confirm">عنوان آدرس</label>
                        <input class="form-control" value="{{count($user->address)>0?$user->address[0]->title:''}}"
                               name="addrTitle" id="addrtitle">
                    </div>
                    <div class="col-12 mb-5 mt-2">
                        <label class="form-label col-12" for="signup-password-confirm">آدرس</label>
                        <textarea class="form-control" name="addr"
                                  id="addr">{{count($user->address)>0?$user->address[0]->addr:''}}</textarea>
                    </div>
                </div>
                <div class="col-12 mb-5 mt-5 row m-auto" style="margin-bottom: 100px">
                    <div class="col-12 col-lg-6 mb-3 text-center text-lg-left">
                             <span style="cursor:pointer;" class="btn btn-info w-25" data-toggle="modal"
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


                                        </div>

                                    </div>
                                    <div class="modal-body">
                                        @if($ncodetypes!='notfound')
                                            <div class="container-fluid">

                                                @for($i=0;$i<count($ncodetypes);$i++)
                                                    <div class="row radif" style="border-bottom: 1px solid #aaaa">
                                                        <div class="col-6 my-2" style="text-align: right">
                                                            <label class="mt-2">نوع کارت شناسایی</label>
                                                            <select class="form-control ncodetype">

                                                                <option value="no">هیچکدام</option>
                                                                @foreach($ncodetypes as $ncodetype)
                                                                    @if(isset($user->ncodetype[$i]))
                                                                        @if($user->ncodetype[$i]->id==$ncodetype->id)
                                                                            <option value="{{$ncodetype->id}}"
                                                                                    selected>{{$ncodetype->title}}</option>
                                                                        @else
                                                                            <option
                                                                                value="{{$ncodetype->id}}">{{$ncodetype->title}}</option>
                                                                        @endif
                                                                    @else
                                                                        <option
                                                                            value="{{$ncodetype->id}}">{{$ncodetype->title}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <label for="attach-{{$i}}"
                                                                   class="btn btn-info mt-2 file-attach-label">ثبت عکس</label>
                                                            <input name="attach[]" disabled
                                                                   class="d-none file-attach" id="attach-{{$i}}"
                                                                   type="file">
                                                            @if(isset($user->ncodetype[$i]))
                                                            <span user-id="{{$user->id}}" photo-id="{{$user->ncodetype[$i]->id}}" style="cursor: pointer" class="btn btn-danger mt-2 removePhoto">حذف</span>
                                                            @endif
                                                        </div>
                                                        <div class="col-6 my-2 ncodePic" style="height: 150px">
                                                            @if(isset($user->ncodetype[$i]))
                                                                <img class='single-show-imgs h-100'
                                                                     src='{{asset($user->ncodetype[$i]->pivot->path)}}'>
                                                            @endif
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
                        <div class="col-12 col-lg-6 mb-3 text-center text-lg-right">
                            <button type="submit" class="w-25 btn btn-success pt-2 pb-2" id="usersubmit">ثبت</button>
                        </div>




                </div>
            </div>
        </div>
    </form>
@endsection
