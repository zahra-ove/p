@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $('.time').clockTimePicker();
        $(document).ready(function () {

            let addpubcheck = [];
////ckeditor
            CKEDITOR.replace('fivedaysorderSetting', {
                language: "fa",

            });
            CKEDITOR.replace('threedaysqestSetting', {
                language: "fa",

            });
            CKEDITOR.replace('fivedayssoonSetting', {
                language: "fa",

            });
            CKEDITOR.instances.fivedaysorderSetting.setData(CKEDITOR.instances.fivedaysorderSetting.getData().replaceAll('$name',"{نام}").replaceAll('$pansion',"{خوابگاه}"));
            CKEDITOR.instances.threedaysqestSetting.setData(CKEDITOR.instances.threedaysqestSetting.getData().replaceAll('$name',"{نام}").replaceAll('$pansion',"{خوابگاه}"));
            CKEDITOR.instances.fivedayssoonSetting.setData(CKEDITOR.instances.fivedayssoonSetting.getData().replaceAll('$name',"{نام}").replaceAll('$pansion',"{خوابگاه}"));




            $('#forFiveDaysOrder').change(function () {

let ck = CKEDITOR.instances.fivedaysorderSetting.getData().replaceAll('<p>',"").replaceAll('</p>',"");

   CKEDITOR.instances.fivedaysorderSetting.setData(ck+$(this).val());
   console.log(CKEDITOR.instances.fivedaysorderSetting.getData());
   if ($(this).is(:chane))
});

            $('#forThreeDaysQest').change(function () {
                let ck = CKEDITOR.instances.threedaysqestSetting.getData().replaceAll('<p>',"").replaceAll('</p>',"");
                console.log(ck);
                console.log($(this).val());
                CKEDITOR.instances.threedaysqestSetting.setData(ck+$(this).val());
                console.log(CKEDITOR.instances.fivedaysorderSetting.getData());
            });


            $('#forFiveDaysSoon').change(function () {
                let ck = CKEDITOR.instances.fivedayssoonSetting.getData().replaceAll('<p>',"").replaceAll('</p>',"");
                console.log(ck);
                console.log($(this).val());
                CKEDITOR.instances.fivedayssoonSetting.setData(ck+$(this).val());
                console.log(CKEDITOR.instances.fivedaysorderSetting.getData());
            });



            $("form").submit(function (e) {


///////fivedaysorder
                let fivedaysorder = CKEDITOR.instances.fivedaysorderSetting.getData();
                var fivedaysorderAName = fivedaysorder.replace("نام", "name");
                let fivedaysorderFName = fivedaysorderAName.replaceAll('{', '$');
                let fivedaysorderGName = fivedaysorderFName.replaceAll('}', '');

                var fivedaysorderAPansion = fivedaysorderGName.replace("خوابگاه","pansion");
                let fivedaysorderFPansion = fivedaysorderAPansion.replaceAll('{', '$');
                let fivedaysorderGPansion = fivedaysorderFPansion.replaceAll('}', '');
                CKEDITOR.instances.fivedaysorderSetting.setData(fivedaysorderGPansion);
                CKEDITOR.instances.fivedaysorderSetting.setData(fivedaysorderGName);
// ///////threedaysqest
                let threedaysqest = CKEDITOR.instances.threedaysqestSetting.getData();
                var threedaysqestAName = threedaysqest.replace("نام", "name");
                let threedaysqestFName = threedaysqestAName.replaceAll('{', '$');
                let threedaysqestGName = threedaysqestFName.replaceAll('}', '');

                var threedaysqestAPansion = threedaysqestFName.replace("خوابگاه","pansion");
                let threedaysqestFPansion = threedaysqestAPansion.replaceAll('{', '$');
                let threedaysqestGPansion = threedaysqestFPansion.replaceAll('}', '');
                CKEDITOR.instances.threedaysqestSetting.setData(threedaysqestGPansion);
                CKEDITOR.instances.threedaysqestSetting.setData(threedaysqestGName);

                // ///////fivedayssoon
                let fivedayssoon = CKEDITOR.instances.fivedayssoonSetting.getData();
                var fivedayssoonAName = fivedayssoon.replace("نام", "name");
                let fivedayssoonFName = fivedayssoonAName.replaceAll('{', '$');
                let fivedayssoonGName = fivedayssoonFName.replaceAll('}', '');

                var fivedayssoonAPansion = fivedayssoonGName.replace("خوابگاه","pansion");
                let fivedayssoonFPansion = fivedayssoonAPansion.replaceAll('{', '$');
                let fivedayssoonGPansion = fivedayssoonFPansion.replaceAll('}', '');
                CKEDITOR.instances.fivedayssoonSetting.setData(fivedayssoonGPansion);
                CKEDITOR.instances.fivedayssoonSetting.setData(fivedayssoonGName);


            });

        });
    </script>
@endsection
<style>
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
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">تنظیم پیامک ها
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- END: Breadcrumbs-->
    <!-- START: Form-->


        <div class="container card mx-auto" style="margin-top: 330px;background-color: gainsboro">
            <div class="row mb-4 mx-auto">
{{--                <div class="col-7 row mt-2" style="font-size: 16px">--}}
{{--                    <div class="col-3 my-2">* ابتدای همه پیامک ها:</div>--}}
{{--                    <div class="col-9 my-2">جناب آقای/سرکار خانم نام و نام خانوادگی(به طور مثال: علی محمدی).</div>--}}
{{--                    <div class="col-3 my-2">* انتهای همه پیامک ها:</div>--}}
{{--                    <div class="col-9 my-2">از طرف خوابگاه (به طور مثال: سالیز).</div>--}}
{{--                </div>--}}
                <div class="col-12">
                    <div class="row justify-content-between px-4">

                        <form method="post" class="row w-100" style="border-bottom: #aaaaaa 1px solid" action="{{route('fivedaysordersetting')}}" enctype="multipart/form-data" id="submit-left">
                            @csrf
                        <div class="col-12 col-lg-10 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-2 p-0 text-center position-relative h-100" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">5 روز مانده به پایان رزرو</span>
                            </div>
                            <div class="col-5 p-0 ">
                                <textarea name="fivedaysorderSetting" class="w-100"
                                          style="min-height: 100px">{{$massage!='notfound'?$massage->fivedaysorder:''}}</textarea>
                            </div>
                            <div class="col-5 " >
                                <select class="form-control" id="forFiveDaysOrder" multiple>
                                    <option value="{نام}">نام</option>
                                    <option value="{خوابگاه}">خوابگاه</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-12 col-lg-2 mb-5 mt-4">
                                <button type="submit" class="btn btn-success btn-lg w-100">ثبت</button>
                            </div>
    </form>
                        <form method="post"  class="row w-100" style="border-bottom: #aaaaaa 1px solid" action="{{route('threedaysqestsetting')}}" enctype="multipart/form-data" id="submit-qest">
                            @csrf
                        <div class="col-12 col-lg-10 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-2 p-0 text-center position-relative h-100" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">3 روز مانده به موعد قسط</span>
                            </div>
                            <div class="col-5 p-0 ">
                                <textarea name="threedaysqestSetting" class="w-100"
                                          style="min-height: 100px">{{$massage!='notfound'?$massage->threedaysqest:''}}</textarea>
                            </div>
                            <div class="col-5" >
                                <select class="form-control" id="forThreeDaysQest" multiple>
                                    <option value="{نام}">نام</option>
                                    <option value="{خوابگاه}">خوابگاه</option>
                                </select>
                            </div>
                        </div>


                            <div class="col-12 col-lg-2 mb-5 mt-4">
                                <button type="submit" class="btn btn-success btn-lg w-100">ثبت</button>
                            </div>
    </form>
                        <form method="post"  class="row w-100" action="{{route('fivedayssoonsetting')}}" enctype="multipart/form-data" id="submit-soon">
                            @csrf
                        <div class="col-12 col-lg-10 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-2 p-0 text-center position-relative h-100" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">5 روز مانده به ورود</span>
                            </div>
                            <div class="col-5 p-0 ">
                                <textarea name="fivedayssoonSetting" class="w-100"
                                          style="min-height: 100px">{{$massage!='notfound'?$massage->fivedayssoon:''}}</textarea>
                            </div>
                            <div class="col-5 ">
                                <select class="form-control" id="forFiveDaysSoon" multiple>
                                    <option value="{نام}">نام</option>
                                    <option value="{خوابگاه}">خوابگاه</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-12 col-lg-2 mb-5 mt-4">
                                <button type="submit" class="btn btn-success btn-lg w-100">ثبت</button>
                            </div>

    </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
