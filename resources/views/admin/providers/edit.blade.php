@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {

            $('#product-attach').change(function (e) {
                let files = e.target.files;
                console.log(files)
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.singleShow').empty();

                    var imgSrc = theFile.target.result;
                    $('.singleShow').append("<img class='single-show-img' style='width: 400px;height: 400px' src='" + imgSrc + "'> ")
                });

                reader.readAsDataURL(this.files[0]);
            });
            $("#edit-submit").submit(function (e) {
                @if($provider!='notfound')
                let id = "{{$provider->id}}";
                @endif
                let providerName = $('#providerName').val();
                let providerFamily = $('#providerFamily').val();
                let proveiderNcode = $('#proveiderNcode').val();
                let birth = $('#providerBirthday').val();
                let business_title = $('#business_title').val();
                let providerMobilecode = $('#providerMobilecode').val();
                let providerPhone = $('#providerPhone').val();
                if ($("#providerGenderMale").is(":checked")) {
                    var providerGender = $('#providerGenderMale').val();
                } else if ($("#providerGenderFemale").is(":checked")) {
                    var providerGender = $('#providerGenderFemale').val();
                }
                let providerEmail = $('#providerEmail').val();
                let contract_enddate = $('#provider_contract_enddate').val();
                let contract_startdate = $('#provider_contract_startdate').val();
                let providerCity = $('#providerCity').val();
                let providerCardnumber = $('#providerCardnumber').val();
                let password = $('#submit-pass').val();
                dateSplittedBirth = birth.split("/"),
                    jDBirth = JalaliDate.jalaliToGregorian(dateSplittedBirth[0], dateSplittedBirth[1], dateSplittedBirth[2]);
                birthday = jDBirth[0] + "-" + jDBirth[1] + "-" + jDBirth[2];
                dateSplittedEnddate = contract_enddate.split("/"),
                    jDEnddate = JalaliDate.jalaliToGregorian(dateSplittedEnddate[0], dateSplittedEnddate[1], dateSplittedEnddate[2]);

                provider_contract_enddate = jDEnddate[0] + "-" + jDEnddate[1] + "-" + jDEnddate[2];

                dateSplittedStartdate = contract_startdate.split("/"),
                    jDStartdate = JalaliDate.jalaliToGregorian(dateSplittedStartdate[0], dateSplittedStartdate[1], dateSplittedStartdate[2]);

                provider_contract_startdate = jDStartdate[0] + "-" + jDStartdate[1] + "-" + jDStartdate[2];
                $('#providerBirthday').val(birthday);

                let info = {
                    "_token": "{{ csrf_token() }}",
                    "name": providerName,
                    "family": providerFamily,
                    "ncode": proveiderNcode,
                    "birthday": birthday,
                    "business_title": business_title,
                    "mobilecode": providerMobilecode,
                    "phone": providerPhone,
                    "city_id": providerCity,
                    "gender": providerGender,
                    "email": providerEmail,
                    "contract_startdate": provider_contract_enddate,
                    "contract_enddate": provider_contract_startdate,
                    "cardnumber": providerCardnumber,
                    "password": password,
                }
                var postData = new FormData();
                // postData.append('attach', files[0]);
                postData.append('name', providerName);
                postData.append('family', providerFamily);
                postData.append('ncode', proveiderNcode);
                postData.append('birthday', birthday);
                postData.append('business_title', business_title);
                postData.append('mobilecode', providerMobilecode);
                postData.append('phone', providerPhone);
                postData.append('city_id', providerCity);
                postData.append('gender', providerGender);
                postData.append('email', providerEmail);
                postData.append('contract_startdate', provider_contract_enddate);
                postData.append('contract_enddate', provider_contract_startdate);
                postData.append('cardnumber', providerCardnumber);
                postData.append('password', password);
                postData.append('_method', 'PATCH');
                if (providerName == "") {

                    $('#providerName').addClass('border-red');
                }
                else {
                    $('#providerName').removeClass('border-red');
                }
                if (providerFamily == "") {

                    $('#providerFamily').addClass('border-red');
                }
                else {
                    $('#providerFamily').removeClass('border-red');
                }
                if (business_title == "") {

                    $('#business_title').addClass('border-red');
                }
                else {
                    $('#business_title').removeClass('border-red');
                }
                if (providerCity == "") {

                    $('.select2-selection').addClass('border-red');
                }
                else {
                    $('.select2-selection').removeClass('border-red');
                }
                if (proveiderNcode.length < 10) {

                    $('#proveiderNcode').addClass('border-red');
                }
                else {
                    $('#proveiderNcode').removeClass('border-red');
                }
                if (providerMobilecode.length < 11) {

                    $('#providerMobilecode').addClass('border-red');
                }
                else {
                    $('#providerMobilecode').removeClass('border-red');
                }
                if (providerPhone.length < 8) {

                    $('#providerPhone').addClass('border-red');
                }
                else {
                    $('#providerPhone').removeClass('border-red');
                }
                if (providerCardnumber.length < 16) {

                    $('#providerCardnumber').addClass('border-red');
                }
                else {
                    $('#providerCardnumber').removeClass('border-red');
                }
                if (birth.length < 10) {

                    $('#providerBirthday').addClass('border-red');
                }
                else {
                    $('#providerBirthday').removeClass('border-red');
                }
                if (providerEmail.length == "") {
                    $('#providerEmail').addClass('border-red');
                } else if (providerEmail.includes("@") == false) {
                    $('#providerEmail').addClass('border-red');
                }
                else {
                    $('#providerEmail').removeClass('border-red');
                }

                if (contract_startdate.length == "") {
                    $('#provider_contract_startdate').addClass('border-red');
                }
                else {
                    $('#provider_contract_startdate').removeClass('border-red');
                }
                if (contract_enddate.length == "") {
                    $('#provider_contract_enddate').addClass('border-red');
                } else if (provider_contract_enddate.split() < provider_contract_startdate.split()) {
                    $('#provider_contract_enddate').addClass('border-red');
                    $('#provider_contract_enddate').val("");
                }
                else {
                    $('#provider_contract_enddate').removeClass('border-red');
                }
                if (password.length<8){
                    $('#submit-pass').addClass('border-red');
                }
                else {
                    $('#submit-pass').removeClass('border-red');
                }
                if (providerName != "" && providerFamily != "" && business_title != "" && providerCity != "" && proveiderNcode.length == 10 && providerMobilecode.length == 11
                    && providerPhone.length == 8 && providerCardnumber.length == 16 && providerEmail.length != "" && providerEmail.includes("@")
                    && contract_startdate.length != "" && contract_enddate.length != "" && provider_contract_enddate.split() > provider_contract_startdate.split() && password.length>8) {
                    $('#provider_contract_enddate').val(provider_contract_enddate);
                    $('#provider_contract_startdate').val(provider_contract_startdate);
                } else {
                    e.preventDefault()



                    toastr.error('کادر های قرمز را اصلاح نمایید.');
                }
            });
        });
    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش خدمات دهنده</h4></div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    {{--                    <li class="breadcrumb-item">خانه</li>--}}
                    {{--                    <li class="breadcrumb-item">فرم</li>--}}
                    {{--                    <li class="breadcrumb-item">عناصر</li>--}}
                    {{--                    <li class="breadcrumb-item active"><a href="#">کادرهای انتخاب</a></li>--}}
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('provider.update',$provider->id)}}" enctype="multipart/form-data" id="edit-submit">
        @csrf
        @method("patch")
    <div class="container-fluid card">
        <div class="row">
            <div class="col-lg-8 row">
                <div class="col-lg-4 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">نام</label>
                    <input class="form-control" value="{{$provider->name}}" name="name" autocomplete="off" id="providerName">
                </div>
                <div class="col-lg-4 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">نام خانوادگی</label>
                    <input class="form-control" value="{{$provider->family}}" name="family" class="form-control" id="providerFamily">
                </div>
                <div class="col-lg-4 mb-3 mt-5">
                    <label class="form-label" for="signup-email">تاریخ تولد</label>
                    <input class="form-control" name="birthday" value="{{str_replace('-','/',Verta($provider->birthday)->formatDate())}}" id="providerBirthday"
                           placeholder="__/__/____" required>
                </div>
                <div class="col-lg-12 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">نام شرکت</label>
                    <input class="form-control" value="{{$provider->business_title}}" name="business_title" class="form-control" id="business_title">
                </div>
                <div class="col-lg-4 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">کد ملی</label>
                    <input class="form-control justnumber" value="{{$provider->ncode}}" name="ncode" autocomplete="off" id="proveiderNcode">
                </div>
                <div class="col-lg-4 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">تلفن ثابت</label>
                    <input class="form-control justnumber" value="{{$provider->phone}}" name="phone" class="form-control" id="providerPhone"
                           placeholder="66912959">
                </div>
                <div class="col-lg-4 mb-3 mt-5">
                    <label class="form-label mb-2" for="providerMobilecode">شماره موبایل</label>
                    <input class="form-control justnumber mobileInput" value="{{$provider->mobilecode}}" name="mobilecode" autocomplete="off"
                           id="providerMobilecode" placeholder="09121234567">
                </div>
                <div class="col-lg-6 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-pass">تغییر رمز</label>
                    <input class="form-control justnumber" value="{{$provider->password}}" name="newPass" autocomplete="off"
                           id="submit-pass" type="password" placeholder="حداقل 8 رقم باشد">
                </div>
                <div class="col-lg-6 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">شماره کارت</label>
                    <input class="form-control justnumber" value="{{$provider->cardnumber}}" name="cardnumber" autocomplete="off" id="providerCardnumber"
                           placeholder="6393461045679853">
                </div>
                <div class="col-lg-6 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">شهر</label>
                    <select name="city_id" class="form-control select2" id="providerCity">
                        <option value="">زیردسته را انتخاب کنید.</option>
                        @if($cities!="notfound")
                            @foreach($cities as $city)
                                @if($city->id==$provider->city_id)
                                <option value="{{$city->id}}" selected>{{$city->cityName}}</option>
                                @else
                                    <option value="{{$city->id}}">{{$city->cityName}}</option>
                                    @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-6 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">ایمیل</label>
                    <input class="form-control" value="{{$provider->email}}" name="email" autocomplete="off" id="providerEmail">
                </div>
                <div class="col-lg-6 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">تاریخ شروع قرارداد</label>
                    <input class="form-control datePicker" value="{{str_replace('-','/',Verta($provider->provider_contract_startdate)->formatDate())}}" name="provider_contract_startdate" class="form-control"
                           id="provider_contract_startdate">
                </div>
                <div class="col-lg-6 mb-3 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">تاریخ پایان قرارداد</label>
                    <input class="form-control datePicker" value="{{str_replace('-','/',Verta($provider->provider_contract_enddate)->formatDate())}}" name="provider_contract_enddate" autocomplete="off"
                           id="provider_contract_enddate">
                </div>
                <div class="col-lg-4 mb-5 mt-5 row">
                    <label class="form-label col-12" for="signup-password-confirm">جنسیت</label>
                    @if($provider->gender=='male')
                    <div class="col-md-6">
                        <div class="col-4">
                            <label for="providerGenderMale">مرد</label>
                        </div>
                        <div class="col-6">
                            <input id="providerGenderMale" type="radio" name="gender" value="male" checked>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-4">
                            <label for="providerGenderFemale">زن</label>
                        </div>
                        <div class="col-6">
                            <input id="providerGenderFemale" type="radio" name="gender" required value="female">
                        </div>
                    </div>
                    @else
                        <div class="col-md-6">
                            <div class="col-4">
                                <label for="providerGenderMale">مرد</label>
                            </div>
                            <div class="col-6">
                                <input id="providerGenderMale" type="radio" name="gender" value="male">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-4">
                                <label for="providerGenderFemale">زن</label>
                            </div>
                            <div class="col-6">
                                <input id="providerGenderFemale" type="radio" name="gender" required value="female" checked>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-12">
                    <h3>آدرس</h3>
                </div>

                <div class="col-12 col-md-6 mb-2 mt-5">
                    <label class="form-label col-12 col-md-6" for="signup-password-confirm">عنوان آدرس</label>
                    <input class="form-control" value="{{count($provider->address)>0?$provider->address[0]->title:''}}" name="addrTitle" id="addrtitle">
                </div>
                <div class="col-12 mb-5 mt-2">
                    <label class="form-label col-12" for="signup-password-confirm">آدرس</label>
                    <textarea class="form-control h-25" name="addr" id="addr">{{count($provider->address)>0?$provider->address[0]->addr:''}}</textarea>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="providersubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                                        <div class="col-12 mb-3">
                                            <input id="product-attach" name="attach" type="file" class="d-none">
                                            <label class="btn btn-info w-50" for="product-attach">
                                                ثبت تصویر
                                            </label>
                                        </div>
                </div>
                <div class="col-12 singleShow mt-5">
                    @if(count($provider->photo)>0)
                        <img src="{{asset($provider->photo[0]->path)}}" style="width: 400px;height: 400px">
                    @else
                        <div style="width: 400px;height: 400px" class="bg-secondary"></div>
                @endif
                </div>

            </div>
        </div>
    </div>
    </form>
@endsection
