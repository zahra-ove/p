@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function () {
            let addpubcheck = [];
//////ckeditor
            CKEDITOR.replace('editor', {
                language: "fa",

            });
            $('#showItem').change(function (e) {
                if ($(this).is(':checked')) {
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            });

            $('#urlVideo').change(function (e) {
                let video = $('#video');
                let urlVal = $(this).val();
                video.empty();
                video.append(`<source src="${urlVal}" type="video/mp4">`)
                // video.onload = function() {
                // show video element
                video.removeClass('d-none');
                // }

                // video.onerror = function() {
                //     alert('error, couldn\'t load');
                //     // don't show video element
                // }
            });
            ///setProductsForm
            $('#product-attach').change(function (e) {
                let files = e.target.files;
                console.log(files)
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.single-show-img').remove();
                    $('#noneImg').remove();
                    var imgSrc = theFile.target.result;
                    $('.singleShow').append("<img class='single-show-img' style='width: 400px;height: 400px' src='" + imgSrc + "'> ")
                });

// Read in the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            });

            $('#add-pub').click(function (e) {


                $('#publicTitle').removeClass('d-none');
                $('#submit-pub').removeClass('d-none');

            });

            $("#submit").submit(function (e) {
                let userId = $('#userId').val();
                let productId = $('#productId').val();
                let counts = $('#countProduct').val();
                $('#countProduct').val( $('#countProduct').val().replaceAll(',', ""));
                let prices = $('#priceProduct').val();
                $('#priceProduct').val(  $('#priceProduct').val().replaceAll(',', ""));
                let city = $('#cityProduct').val();
                let description = CKEDITOR.instances.editor.getData();
                let url = $("#urlVideo").val();
                let show = 0;

                if ($('#showItem').is(':checked')) {
                    show = 1;
                } else {
                    show = 0;
                }

                if ($('#userId').val()==''){
                    toastr.error('خدمات دهنده ای انتخاب نشده است.');
                    e.preventDefault();
                }
                if ($('#productId').val()==''){
                    toastr.error('محصول انتخاب انتخاب است.');
                    e.preventDefault();
                }
                if ($('#cityProduct').val()==''){
                    toastr.error('شهر انتخاب نشده است.');
                    e.preventDefault();
                }
                if ($('#priceProduct').val()==''){
                    toastr.error('قیمت خالی است.');
                    e.preventDefault();
                }
                if ($('#countProduct').val()==''){
                    toastr.error('تعداد مشخص نیست.');
                    e.preventDefault();
                }
                if ($('#vehicle').val()==''){
                    toastr.error('وسیله نقلیه انتخاب نشده است.');
                    e.preventDefault();
                }
                if ($("#product-attach")[0]['files'].length==0){
                    toastr.error('عکسی برای خدمت موجود نیست');
                    e.preventDefault();
                }
                if ($('.priTitle').val()==''){
                    toastr.error('وسیله تات انتخاب نشده است.');
                    e.preventDefault();
                }





            {{--let info={--}}
                {{--    "_token": "{{ csrf_token() }}",--}}
                {{--    "name":cityname,--}}
                {{--    "ostan_id":ostan--}}
                {{--}--}}

                // var postData = new FormData();
                // postData.append('attach', files[0]);
                // postData.append('userId', userId);
                // postData.append('productId', productId);
                // postData.append('count', count);
                // postData.append('price', price);
                // postData.append('city_id', city);
                // postData.append('show', show);
                // postData.append('description', description);
                // postData.append('url', url);
                // postData.append('pubemkanat',addpubcheck);
                {{--$.ajax(--}}
                {{--    {--}}
                {{--        url: "{{route('setproducts')}}",--}}
                {{--        headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},--}}
                {{--        async: true,--}}
                {{--        contentType: false,--}}
                {{--        processData: false,--}}
                {{--        data: postData,--}}
                {{--        type: "post",--}}
                {{--        success: function (data) {--}}
                {{--            console.log(data)--}}
                {{--            if (data=="ok"){--}}
                {{--            location.href = "{{route('provider.index')}}";--}}
                {{--            toastr.success('محصول با موفقیت ثبت شد.');--}}
                {{--            }--}}
                {{--            else if (data=="notfound"){--}}
                {{--                --}}{{--location.href="{{asset('admin/s')}}";--}}
                {{--                toastr.success('بروز خطا');--}}
                {{--            }--}}

                {{--        }--}}
                {{--    }--}}
                {{--);--}}
            });

            $('#submit-pub').click(function (event) {
                let title =  $('#publicTitle').val();
                let info={
                    "_token": "{{ csrf_token() }}",
                    "title":title,
                }

                if($('#publicTitle').val()!=""){
                    $.ajax({
                        url: "{{route('insertpub')}}",
                        data: info,
                        type:'post',
                        success: function (data) {
                            if (data!='notfound'){
                                $('#allPub').empty();
                                data.forEach(function (item,index){
                                    $('#allPub').append(`     <div class="row col-12 row-${item.id}" data_id="${item.id}">
<div class="col-lg-8 row">

                                <div class="col-1 mb-5 mt-5" style="text-align: left">
                                    <input type="checkbox" class="custom-checkbox pubChekckbox" value="${item.id}" data-id="${item.id}" name="pubcheck[]"
                                   autocomplete="off">
                        </div>

                        <div class="col-10 mb-5 mt-2">
                            <label class="form-label mb-2" for="submit-ostan">${item.title}</label>
                            <input class="form-control descriptions" name="descriptions[]"
                                   autocomplete="off">
                        </div>
<div class="col-1 mt-4" style="text-align: left">
                                    <a href="#" class="btn btn-danger deletePub" data-id="${item.id}">حذف</a>
                                </div>
                        </div>
                            <div class="col-lg-4"></div>
</div>`);
                                });

                                $('.deletePub').click(function (event) {
                                    let id =  $(this).attr('data-id');
                                    let info={
                                        "_token": "{{ csrf_token() }}",
                                        "id":id,
                                    }

                                    $.ajax({
                                        url: "{{route('deletepub')}}",
                                        data: info,
                                        type:'post',
                                        success: function (data) {
                                            console.log($(`.row-${id}`).attr('data_id'))
                                            if (data!='notfound'){
                                                $(`.row-${id}`).remove();
                                                toastr.success('امکانات با موفقیت حذف شد.');
                                            }


                                        }
                                    })
                                });
                            }

                        }
                    })
                }
                else {
                    toastr.error('عموان باید پر شود.')
                }

            });
            $('.pubChekckbox').change(function (ev) {
                $dataId =$(this).attr('data-id');
                desci = $(this).parents('.col-1').siblings('.col-10').children('.descriptions').val();

                if ($(this).is(':checked')){
                    addpubcheck.push([$dataId,desci]);
                    console.log(addpubcheck)
                }
                else {
                    addpubcheck.forEach(function (item,index) {
                        if (item[0]==$dataId){
                            addpubcheck.splice(index,1);
                        }

                    });
                }
            });
            $('.deletePub').click(function (event) {
                let id =  $(this).attr('data-id');
                let info={
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                }

                $.ajax({
                    url: "{{route('deletepub')}}",
                    data: info,
                    type:'post',
                    success: function (data) {
                        console.log($(`.row-${id}`).attr('data_id'))
                        if (data!='notfound'){
                            $(`.row-${id}`).remove();
                            toastr.success('امکانات با موفقیت حذف شد.');
                        }


                    }
                })
            });
            $('#readyPri').click(function (e) {
                $('#dropPri').append(`<div class="row col-12 border-top">
<div class="col-12 mt-3">
<h4>
${ $('#dropPri').children().length+1}.
</h4>
<div>
                                             <div class="col-12 col-md-6 mb-5 mt-5" style="text-align: left">
                                        <input type="text" class="form-control priTitle"  name="privateTitle[]"
                                               autocomplete="off" placeholder="عنوان">
                                    </div>
                                    <div class="col-12 mb-5 mt-5">
                                        <textarea type="text" class="form-control pri-description"  name="privateDesc[]"></textarea>
                                    </div>
                                    </div>
                `)

            })
        })
    </script>
@endsection

@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0"> افزودن بوم گردی</h4></div>

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
    <form method="post" action="{{route('setproducts')}}" enctype="multipart/form-data" id="submit">
        @csrf
        <div class="container-fluid card">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 col-12 mb-5 mt-3">
                            <label class="form-label mb-2" for="submit-cityname">خدمات دهنده</label>
                            <select name="userId" class="form-control" id="userId">
                                <option value="">زیردسته را انتخاب کنید.</option>
                                @if($users!="notfound")
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->business_title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3">
                            <label class="form-label mb-2" for="submit-ostan">محصول</label>
                            <select name="productId" class="form-control" id="productId">
                                <option value="">زیردسته را انتخاب کنید.</option>
                                @if($products!="notfound")
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->protitle}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3">
                            <label class="form-label mb-2" for="submit-ostan">شهر</label>
                            <select name="city_id" class="form-control select2" id="cityProduct">
                                <option value="">شهر را انتخاب کنید.</option>
                                @if($cities!="notfound")
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->cityName}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-5 mt-3">
                            <label class="form-label mb-2" for="priceProduct">قیمت</label>
                            <input class="form-control seprator justnumber" name="price" id="priceProduct"
                                   autocomplete="off">
                        </div>
                        <div class="col-lg-4 mb-5 mt-3">
                            <label class="form-label mb-2" for="submit-ostan">تعداد</label>
                            <input class="form-control seprator justnumber" name="count" id="countProduct"
                                   autocomplete="off">
                        </div>
                        <div class="col-lg-4 mb-5 mt-3">
                            <label class="form-label mb-2" for="vehicle-ostan">وسیله نقلیه</label>
                            <select name="vehicle" class="form-control select2" id="vehicle">
                                <option value="">انتخاب وسیله</option>
                                @if($vehicles!='notfound')
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{$vehicle->id}}">{{$vehicle->vehicle}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-5">
                            <label class="form-label mb-2" for="submit-ostan">توضیح</label>
                            <textarea id="editor" name="editor"></textarea>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-2 mb-5 mt-3">
                            <label class="form-label mb-2" for="submit-ostan">نمایش</label>
                            <input type="checkbox" class="form-control seprator justnumber" name="show" id="showItem"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-5">
                            <label class="form-label mb-2" for="submit-ostan">آدرس ویدیو</label>
                            <input type="text" class="form-control" name="urlVideo" id="urlVideo" autocomplete="off">
                            <div class="mt-2">
                                <video class="d-none pb-4 mb-4" id="video" controls>
                                    {{--                        <source src="https://static0.arshehonline.com/servev2/JOHymr9Ix9Lk/pBL9vLzVLpA,/%DA%AF%D8%B4%D8%AA+%D8%A7%D8%B1%D8%B4%D8%A7%D8%AF3.mp4" type="video/mp4">--}}
                                    {{--                  --}}


                                </video>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6 col-md-2">
                            <h3>امکانات</h3>
                        </div>
                        <div class="col-6 col-md-10">
                            <div class="mt-3" style="border-top: 1px solid #aaa!important"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3 mt-5">  <h4 class="mt-4">امکانات عمومی</h4></div>
                        <div class="col-md-1 col-12 mb-5 mt-5">
                            <i href="#" class="btn btn-info" id="add-pub">
                                افزودن
                            </i>
                        </div>
                        <div class="col-12 col-md-6 mb-5 mt-5 ml-4" style="text-align: left">
                            <input type="text" class="form-control d-none"  name="title" id="publicTitle"
                                   autocomplete="off" placeholder="عنوان">
                        </div>
                        <div class="col-md-1 col-12 mb-5 mt-5">
                            <div class="btn btn-success d-none w-100" id="submit-pub">
                                ثبت
                            </div>
                        </div>
                        <div id="allPub" class="row">
                            @if($pubs!='notfound')
                                @foreach($pubs as $key=>$pub)
                                    <div  class="row col-12 row-{{$pub->id}}" data_id="{{$pub->id}}">
                                        <div class="col-lg-8 row">

                                            <div class="col-1 mb-5 mt-5" style="text-align: left">
                                                <input type="checkbox" class="custom-checkbox pubChekckbox" value="{{$pub->id}}" data-id="{{$pub->id}}" name="pubcheck[]"
                                                       autocomplete="off">
                                            </div>
                                            <div class="col-10">
                                                <label class="form-label mb-2" for="submit-ostan">{{$pub->title}}</label>
                                                <input class="form-control descriptions" name="descriptions[]"
                                                       autocomplete="off">
                                            </div>
                                            <div class="col-1 mt-4" style="text-align: left">
                                                <a href="#" class="btn btn-danger deletePub" data-id="{{$pub->id}}">حذف</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-12 mb-5 mt-5">
                            <h4 class="mt-4 mb-4 d-inline">امکانات خصوصی</h4>
                            <input type="checkbox" class="custom-checkbox ml-4"  data-id="" name="price"
                                   autocomplete="off" >
                        </div>
                        <div class=" col-12 mb-5 mt-5">
                            <div class="btn btn-info mb-3" id="readyPri">
                                افزودن
                            </div>
                            <div class="col-12 row" id="dropPri">

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 mt-5 row pl-5">
                    <div class="col-12 text-center">
                        <div class="col-12 mb-3">
                            <button type="submit" class="w-50 btn btn-success pt-2 pb-2" id="productsubmit">ثبت</button>
                        </div>
                        <div class="col-12 mb-3">
                            <a href="{{route('provider.create')}}" class="w-50 btn btn-secondary pt-2 pb-2">افزودن خدمات دهنده جدید</a>
                        </div>
                        <div class="col-12 mb-3">
                            <input id="product-attach" name="attach" type="file" class="d-none">
                            <label class="btn btn-info w-50" for="product-attach">
                                ثبت تصویر
                            </label>
                        </div>
                    </div>
                    <div class="col-12 singleShow mb-5 mt-5 h-100">
                        <div class='single-show-img position-relative' id="noneImg"
                             style="width: 400px;height: 400px;background: #bebebe" src='#'>
                            <h3 class="text-white position-absolute" style="left: 32%;bottom: 45%;">نمایش تصویر</h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
    </div>

@endsection
