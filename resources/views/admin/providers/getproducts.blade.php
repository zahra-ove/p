@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<meta name="msapplication-tap-highlight" content="no">
<style>


    .dataTables_wrapper {
        margin-top: 50px;
    }

    a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .delete-banner{
        margin: auto;
        background-color: rgba(0, 0, 0, 0.5);
        text-align: center;
        padding-top: 25%;
        position: absolute;
        top: 0;
        right: 20%;
    }
</style>
@section('js')
    <script>

        $(document).ready(function (e) {
            $('.picked').prop('checked', true);
            $('.urlVideo').change(function (e) {
                let video = $(this).siblings('.mt-2').children('.video');
                video.empty();
                console.log(video)
                let urlVal = $(this).val();
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

            $('.owl-item').each(function (index) {
                 $(this).attr('data-id',$(this).children('.item').attr('data-id'));
            });

            // owl carosel
            $('.item').click(function (e){
               let src = $(this).children('img').attr('src');
                let dataId=$(this).children('img').attr('data-id');
                $('.picked').prop('checked', false);
               $('.bigImg').attr('src',src);
                $('.bigImg').attr('data-id',dataId);
            });
            $('.item').mouseup(function (e) {
                $('.item').click(function (e) {
                    let src = $(this).children('img').attr('src');
                    let dataId=$(this).children('img').attr('data-id');
                    $('.picked').prop('checked', false);
                    $('.bigImg').attr('src',src);
                    $('.bigImg').attr('data-id',dataId);
                });
            });
            $('.del-pro').click(function (e) {
                    $('.owl-item').removeClass('active').removeClass('cloned');
                let dataId=$(this).parents('.delete-banner').siblings('img').attr('data-id');
                // $(`.item[data-id=${dataId}]`).parents('.owl-item').attr('data-id',dataId);
                $(`.item[data-id=${dataId}]`).remove();
                // $(`.owl-item`).each(function (index) {
                //     console.log($(this).children())
                //     if($(this).attr('data-id')==dataId){
                //         $(this).remove();
                //     }
                // });
                let otherImg = $('.item').first().children('img');
                let srcOther = otherImg.attr('src');
                let idOther = otherImg.attr('data-id');
                // $('.owl-item').remove();
                $(this).parents('.delete-banner').siblings('img').attr('src',srcOther);
                $(this).parents('.delete-banner').siblings('img').attr('data-id',idOther);
                let info= {
                    "_token": "{{ csrf_token() }}",
                }
               $.ajax({
                    url:"{{asset('admin/deletephoto')}}" + "/" + dataId,
                    type:"post",
                   data:info,
                   success: function (data) {
                       if (data == "ok") {

                           toastr.success('تصویر با موفقیت حذف شد.');
                       } else if (data == "notfound") {

                           toastr.success('بروز خطا');
                       }
                   }
               })
            });
            $('.hrefbtn').attr('href', "{{route('setboomproduct')}}");
            $('.insert-photo').change(function (e) {
                $('.modalShow').on('hidden.bs.modal', function () {
                    $('.felfel').remove();
                    allFiless = [];
                });

                let files = e.target.files;
                let thisId = $(this).attr('id');
                var file = files[0];
                allFiless.push(file);
                let reader = new FileReader();
                let $this = $(this);

                reader.onload = (function (theFile) {
                    console.log(theFile)
                    var imgSrc = theFile.target.result;
                    $this.siblings('.gallery').append("<div class='col-md-4 mt-2 border-top felfel' ><img class='single-show-img mt-2' style='width: 200px;height: 200px' src='" + imgSrc + "'> <div class='text-center'></div> </div>");
                    $('.felfel').each(function (index) {
                        $(this).attr('data-id', index);
                        $(this).children('.text-center').attr('data-id', index);
                        $(this).children('.text-center').children('.delete-img').attr('data-id', index);
                    });
                    // let total=$('.felfel').length - 1;

                    // $(`.lastbot`).click(function (e) {
                    //     // console.log(allFiless);
                    //     console.log('allFiless');
                    //     let dataIds = $(this).attr('data-id');
                    //     let parentId = $(this).parents(`.felfel[data-id="${dataIds}"]`).attr('data-id');

                        // allFiless.splice(parentId[], 1);
                        // $(this).parents('.felfel').remove();
                        // console.log(allFiless)
                    });
                // });

                // allFiless.splice(1, 1);
                // console.log(allFiless)
// Read in the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

            });

            $('.imgSubmit').click(function (e) {
                // $('.imgSubmit').click(function (e) {
                {{--let info={--}}
                {{--    "_token": "{{ csrf_token() }}",--}}
                {{--    "name":cityname,--}}
                {{--    "ostan_id":ostan--}}
                {{--}--}}
                let id = $(this).attr('data-id');
                var postData = new FormData();
                allFiless.forEach(function (item, index) {
                    postData.append(`attach-${index}`, item);
                });
                postData.append('id', id);
                // postData.append('attach', allFiless);

                // postData.append('ostan_id', ostan);


                $.ajax(
                    {
                        url: "{{route('insertProviderPhotos')}}",
                        headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                        async: true,
                        contentType: false,
                        processData: false,
                        data: postData,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                location.reload();
                                toastr.success('تصاویر برای خدمت با موفقیت ثبت شد.');
                            } else if (data == "notfound") {
                                location.reload();
                                toastr.success('بروز خطا');
                            }

                        },
                        error: function (data, error) {
                            console.log(data, error)
                        }
                    }
                );


            });
            //////video
            $('.videoSubmit').click(function (e) {

                let id = $(this).attr('data-id');
                let url = $(this).parents('.modal-footer').siblings('.modal-body').children('.col-12').children('input').val();

                let info={
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                    "url":url
                }
                console.log(id)
                $.ajax(
                    {
                        url: "{{route('insertvideo')}}",
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                location.reload();
                                toastr.success('فیلم برای خدمت با موفقیت ثبت شد.');
                            } else if (data == "notfound") {
                                location.reload();
                                toastr.success('بروز خطا');
                            }

                        },
                        error: function (data, error) {
                            console.log(data, error)
                        }
                    }
                );


            });
            ///delete video
            $('.delete-movie').click(function (e) {

                let id = $(this).attr('data-id');

                let info={
                    "_token": "{{ csrf_token() }}",
                    "id":id,
                }
                $.ajax(
                    {
                        url: "{{route('deletevideo')}}",
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                location.reload();
                                toastr.success('فیلم برای خدمت با موفقیت حذف شد.');
                            } else if (data == "notfound") {
                                location.reload();
                                toastr.success('بروز خطا');
                            }

                        },
                        error: function (data, error) {
                            console.log(data, error)
                        }
                    }
                );


            });

            ///////
            $('.delete-banner').hide();

            $('.home-slider').mouseover(function () {
                let width = $(this).find('img').css('width');
                let height = $(this).find('img').css('height');
                $(this).find('.delete-banner').css({'width': width,'height':height})
                $(this).find('.delete-banner').show();

            });

            $('.home-slider').mouseout(function () {
                let width = $(this).css('width');
                let height = $(this).css('height');
                $(this).siblings('.delete-banner').css({'width': width,'height':height})
                $(this).find('.delete-banner').hide();

            });
            $('.delete-btn').click(function (e) {
                let btnDel=$(this).attr('data-id');
                // let keycol=$(this).parents('td').siblings('.key-col');
                // $('td.key-col').each(function (index) {
                //     if (parseInt($(this).html())>parseInt(keycol)){
                //         $(this).text(parseInt($(this).html())-1)
                //     }
                // });

                $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}"
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/productuser/delete/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('خدمات دهنده با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });

            $('.picked').click(function (e) {
                let id = $('.bigImg').attr('data-id');
                let info = {
                    "_token": "{{ csrf_token() }}",
                    'id':id
                }
                $.ajax(
                    {
                        url: "{{route('photopick')}}",
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {

                                toastr.success('عکس صفحه نمایش تغییر نمود.');

                            } else if (data == "notfound") {

                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
        });

        let allFiless = [];


    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                @if($provider!="notfound")
                <div class="w-sm-100 mr-auto"><h4 class="mb-0"> محصولات {{$provider->business_title}}</h4></div>
                @endif
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
    <!-- category table-->
    <div class="container-fluid card border-top row m-auto">
        <div class="row col-12 m-3">
            <div class="col-12 row" style="border:1px solid #a3a3a3">
                <div class="col-12 col-lg-4 row">
                    <div class="col-3 my-3">نام کامل:</div><div class="col-3 my-3">{{$provider->name!=null?$provider->name:'-'}} {{$provider->family!=null?$provider->family:'-'}}</div><div class="col-6"></div>
                    <div class="col-3 my-3">شرکت:</div><div class="col-3 my-3">{{$provider->business_title!=null?$provider->business_title:'-'}}</div><div class="col-6"></div>
                    <div class="col-3 my-3">کدملی:</div><div class="col-3 my-3">{{$provider->ncode!=null?$provider->ncode:'-'}}</div><div class="col-6"></div>
                    <div class="col-3 my-3">شهر:</div><div class="col-3 my-3">{{$provider->city_id!=null?$provider->city->name:'-'}}</div><div class="col-6"></div>

                </div>
                <div class="col-12 col-lg-4 row">
                    <div class="col-3 my-3">شماره تماس:</div><div class="col-3 my-3">{{$provider->phone!=null?$provider->phone:'-'}}</div><div class="col-6"></div>
                    <div class="col-3 my-3">شماره موبایل:</div><div class="col-3 my-3">{{$provider->mobilecode!=null?$provider->mobilecode:'-'}}</div><div class="col-6"></div>
                    <div class="col-3 my-3">ایمیل:</div><div class="col-3 my-3">{{$provider->emial!=null?$provider->emial:'-'}}</div><div class="col-6"></div>
                    <div class="col-3 my-3">دسته بندی:</div><div class="col-3 my-3">{{$provider->category_id!=null?$provider->category->title:'-'}}</div><div class="col-6"></div>
                </div>
                <div class="col-12 col-lg-4 row">
                    <div class="col-3 my-3">آدرس:</div><div class="col-9 my-3">{{count($provider->address)>0?$provider->address[0]->addr:'-'}}</div>


                </div>
            </div>

        <div class="col-12">
            <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>نام محصول</th>
                    <th>زیر دسته</th>
                    <th>تعداد</th>
                    <th>قیمت</th>
                    <th>شهر</th>
                    <th class="text-center">تنظیمات</th>
                </tr>
                </thead>
                <tbody>

                @if($productusers!="notfound")
                    @foreach($productusers as $key=>$productuser)
                        <tr data-id="{{$productuser->id}}">
                            <td>{{++$key}}</td>
                            <td>{{$productuser ? $productuser->product->title:'-'}}</td>
                            <td>{{$productuser ? $productuser->product->category->title : '-'}}</td>
                            <td>{{$productuser->price!=null ? number_format(substr(($productuser->price),0)): '-'}}</td>
                            <td>{{$productuser->count!=null ? number_format(substr(($productuser->count),0))  : '-'}}</td>
                            <td>{{$productuser->city_id!=null ? $productuser->city->name : '-'}}</td>
                            <td class="text-center">
                                @if($productuser->product->category->category_id==3)
                                    <a href="{{route('freetime.create',$productuser->id)}}" class="btn text-white btn-info" title="زمان های آزاد" style="padding: 10px 12px"><i class="fas fa-clock"></i> </a>
                                @elseif($productuser->product->category->category_id==2)
                                    <a href="{{route('tour.create',$productuser->id)}}" class="btn text-white btn-info" title="زمان های آزاد" style="padding: 10px 12px"><i class="fas fa-clock"></i> </a>

                                @endif
                                <button class="btn text-white btn-secondary add-photo" style="padding: 10px 12px" data-toggle="modal"
                                        data-target="#insertPhoto-{{$key}}" title="افزودن تصویر"><i class="fas fa-image"></i>
                                </button>
                                <button class="btn text-white btn-secondary add-photo" style="padding: 10px 12px" data-toggle="modal"
                                        data-target="#video-{{$key}}" title="نمایش فیلم"><i class="fa fa-video"></i>
                                </button>
                                <button class="btn text-white btn-success" style="padding: 10px 12px" data-toggle="modal"
                                        data-target="#showPhotos-{{$key}}" title="تصاویر"><i class="fas fa-images"></i>
                                </button>
                                <a href="{{route('editprodcuts',$productuser->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش"><i class="fas fa-edit"></i>
                                </a>
                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$productuser->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
                                <!-- modal delete -->
                                <div class="modal fade" id="delete-modal-{{$key}}" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header d-block" style="text-align: right">
                                                <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                            </div>
                                            <div class="modal-body text-dark" >
                                                <div style="text-align: right">
                                                    <p>آیا می خواهید زیردسته {{$productuser->product->title}} حذف شود؟</p>
                                                </div>
                                                <div style="text-align: left">
                                                    <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$productuser->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>

                            <!--insert photo Modal -->
                            <div class="modal modalShow fade" id="insertPhoto-{{$key}}" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="py-5 mt-5 mb-lg-3 row w-100">
                                                <div class="col-12  align-self-center">
                                                    <div
                                                        class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">افزودن تصویر</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            {{--                                        <form method="post" action="{{route('insertProviderPhotos')}}">--}}
                                            {{--                                            @csrf--}}
                                            <input id="city-attach-{{$key}}" name="attach" type="file"
                                                   class="d-none insert-photo">
                                            {{--                                        <input  name="file" type="file" class=" insert-photo">--}}
                                            <label class="btn btn-info w-25" for="city-attach-{{$key}}">
                                                ثبت تصویر
                                            </label>
                                            <div class="gallery row" style="min-height: 300px">
                                            </div>
                                            {{--                                            <input type="submit">--}}

                                            {{--                                    </form>--}}
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success imgSubmit" data-id="{{$productuser->id}}"
                                                    style="width: 15%">ثبت
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--video Modal -->
                            <div class="modal modalShow fade" id="video-{{$key}}" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="py-5 mt-5 mb-lg-3 row w-100">
                                                <div class="col-12  align-self-center">
                                                    <div
                                                        class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">نمایش فیلم</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body text-dark text-center">
                                            @if(count($productuser->video)>0)


                                                <video class=" pb-4 mb-4 w-100" id="video" controls>
                                                    {{--                                                                            <source src="https://static0.arshehonline.com/servev2/JOHymr9Ix9Lk/pBL9vLzVLpA,/%DA%AF%D8%B4%D8%AA+%D8%A7%D8%B1%D8%B4%D8%A7%D8%AF3.mp4" type="video/mp4">--}}
                                                    <source src=" {{$productuser->video[0]->url}}" type="video/mp4">



                                                </video>
                                                <button class="btn btn-danger m-auto" data-toggle="modal" data-target="#delete-video-{{$key}}">حذف</button>
                                                <!-- modal delete video -->
                                                <div class="modal fade" id="delete-video-{{$key}}" style="top: 40%" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header d-block" style="text-align: right">
                                                                <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                                            </div>
                                                            <div class="modal-body text-dark" >
                                                                <div style="text-align: right">
                                                                    <p>آیا می خواهید فیلم حذف شود؟</p>
                                                                </div>
                                                                <div style="text-align: left">
                                                                    <button data-dismiss="modal" class="btn text-white btn-danger delete-movie" title="حذف" data-id="{{$productuser->video[0]->id}}">
                                                                        حذف
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-12 mb-5">
                                                    <label class="form-label mb-2" for="submit-ostan">آدرس ویدیو</label>
                                                    <input type="text" class="form-control urlVideo" name="urlVideo" autocomplete="off">
                                                    <div class="mt-2">
                                                        <video class="d-none pb-4 mb-4 video w-100" controls>
                                                            {{--                        <source src="https://static0.arshehonline.com/servev2/JOHymr9Ix9Lk/pBL9vLzVLpA,/%DA%AF%D8%B4%D8%AA+%D8%A7%D8%B1%D8%B4%D8%A7%D8%AF3.mp4" type="video/mp4">--}}
                                                            {{--                  --}}


                                                        </video>

                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            @if(count($productuser->video)==0)
                                                <button class="btn btn-success videoSubmit" data-id="{{$productuser->id}}"
                                                        style="width: 15%">ثبت
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--show photos Modal -->
                            <div class="modal allGallery fade" id="showPhotos-{{$key}}" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="mt-5 mb-lg-3 row w-100">
                                                <div class="col-12  align-self-center">
                                                    <div
                                                        class="sub-header mt-3 align-self-center d-sm-flex w-100 rounded">
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">تصاویر خدمت</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12 text-center position-relative home-slider mb-3" style="height: 450px;width: 450px">
                                                        @if(isset($productuser->photo[0]->path))
                                                            <img class="bigImg" style="width:450px!important;height: 450px!important;" src="{{asset($productuser->photopick)}}" data-id="{{$productuser->photo[0]->id}}">
                                                            <input class="position-absolute picked position-absolute" style="right: 24%; top: 6%;z-index: 90000" data-id="{{$productuser->photo[0]->id}}" name="show" type="radio">
                                                            <div class="delete-banner pb-3">
                                                                <button id="btn_gallery"
                                                                        class="btn btn-danger mr-2 text-white w-25 mt-2 del-pro"
                                                                        data-toggle="modal"
                                                                        data-target="#myModale-right"
                                                                        type="button">
                                                                    حذف
                                                                </button>
                                                            </div>
                                                        @else
                                                            <h2 class="alert-danger">عکسی برای این محصول ثبت نشده است.</h2>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            @if($productuser->photo!=null)
                                                <div class="owl-carousel owl-theme">
                                                    @foreach($productuser->photo as $photo)
                                                        <div class="item d-flex position-relative" data-bgimg="{{asset($photo->path)}}" data-id="{{$photo->id}}">

                                                            <img src="{{asset($photo->path)}}" data-id="{{$photo->id}}">
                                                            {{--                                                                    <div class='home-slider w-100 h-100 d-none'>--}}
                                                            {{--                                                                        <h6>برای مشاهده بیشتر بر روی دکمه زیر کلیک کنید.</h6>--}}
                                                            {{--                                                                        <a href='{{route('single-product',$slider->product_user_id)}}' class='btn btn-info'>مشاهده بیشتر</a>--}}
                                                            {{--                                                                    </div>--}}
                                                            {{--                                                            </img>--}}

                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </tr>
                    @endforeach

                @endif
                </tbody>

            </table>
        </div>
    </div>
@endsection
