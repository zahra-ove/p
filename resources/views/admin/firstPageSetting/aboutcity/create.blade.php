@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){

            CKEDITOR.replace('editor', {
                language: "fa",

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
                        url: "{{asset('admin')}}/deleteabout/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('درباره شهر با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });

            $('#submit').submit(function (e) {


              if (CKEDITOR.instances.editor.getData()==""){
                  e.preventDefault();
                  toastr.error('متن خالی است.');
              }
                if ($('#title').val()==''){
                    e.preventDefault();
                    toastr.error('عنوان ندارد.');
                }
                if ($('#city_id').val()==''){
                    e.preventDefault();
                    toastr.error('شهر انتخاب نشده است.');
                }
            });
        });

    </script>
@endsection
<style>
    .select2-container{
        width: 100%!important;
    }
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت درباره شهر</h4></div>

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
    <form action="{{route('addaboutcity')}}" method="post" id="submit">
        @csrf
    <div class="container-fluid card">
        <div class="row">
            <div class="col-lg-8 row">
                <div class="col-lg-6 mb-5 mt-5">
                    <label class="form-label mb-2" for="catName">عنوان</label>
                    <input class="form-control" name="title" autocomplete="off" id="title">
                </div>
                <div class="col-lg-6 col-12 mb-5 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">شهر</label>
                    <select name="city_id" class="form-control select2" id="city_id">
                        <option value="">شهر را انتخاب کنید.</option>
                        @if($cities!="notfound")
                            @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->cityName}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-12 mb-5">
                    <label class="form-label mb-2" for="submit-ostan">توضیح</label>
                    <textarea id="editor" name="editor"></textarea>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="categorysubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
        <!-- category table-->
        <div class="container-fluid card border-top row m-auto">
            <h2 class="mb-3 pt-2">جدول درباره شهر ها</h2>
            <table class="align-right table table-hover table-dark table-striped mytable w-100">
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>عنوان</th>
                    <th>نام شهر</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @if($abouts!='notfound')
                    @foreach($abouts as $key=>$about)
                        <tr data-id="{{$about->id}}">
                            <td class="key-col">{{++$key}}</td>

                            <td>{{$about->title!=null ? $about->title:'-'}}</td>
                            <td>{{$about->city_id!=null ? $about->city->name:'-'}}</td>

                            <td class="text-center">
                                <button class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" data-id="{{$about->id}}" data-toggle="modal" data-target="#edit-modal-{{$key}}"><i class="fas fa-edit"></i> </button>
                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="{{$about->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
                                <!-- modal edit -->
                                <div class="modal fade" id="edit-modal-{{$key}}" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header d-block" style="text-align: right">
                                                <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                            </div>
                                            <div class="modal-body text-dark" >
                                                <!-- START: Breadcrumbs-->
                                                <div class="py-5 mt-5 mb-lg-3 row w-100">
                                                    <div class="col-12  align-self-center">
                                                        <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                            <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش دسته بندی</h4></div>
                                                            <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END: Breadcrumbs-->
                                                <!-- START: Form-->
                                                <form action="" method="post" enctype="multipart/form-data" id="edit-submit">
                                                    @csrf
                                                    @method('patch')
                                                    <div class="container-fluid card">
                                                        <div class="row parent-file">
                                                            <div class="col-lg-8 row" style="text-align: right">
                                                                <div class="col-lg-6 mb-5 mt-5">
                                                                    <label class="form-label mb-2" for="catName">عنوان</label>
                                                                    <input class="form-control w-100" value="{{$about->title}}" name="title" autocomplete="off" id="title">
                                                                </div>
                                                                <div class="col-lg-6 col-12 mb-5 mt-5">
                                                                    <label class="form-label mb-2" for="submit-ostan">شهر</label>
                                                                    <select name="city_id" class="form-control select2 w-100" id="city_id">
                                                                        <option value="">شهر را انتخاب کنید.</option>
                                                                        @if($cities!="notfound")
                                                                            @foreach($cities as $city)
                                                                                @if($about->city_id==$city->id)
                                                                                <option value="{{$city->id}}" selected>{{$city->cityName}}</option>
                                                                                @else
                                                                                    <option value="{{$city->id}}">{{$city->cityName}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 mb-5">
                                                                    <label class="form-label mb-2" for="submit-ostan">توضیح</label>
                                                                    <textarea class="w-100" id="editors" name="editors">
                                                                        {!! $about->text !!}
                                                                    </textarea>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                                                                <div class="col-12 text-center">
                                                                    <div class="col-12 mb-3 mt-3">
                                                                        <button type="submit" class="w-100 btn btn-success mt-3 pt-2 pb-2 submit-edit" id="ostansubmit" data-id="{{$about->id}}">ثبت</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 singleShow mt-5">
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
                                                    <p>آیا می خواهید {{$about->title}} حذف شود؟</p>
                                                </div>
                                                <div style="text-align: left">
                                                    <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$about->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>


                        </tr>
                    @endforeach
                @endif
                </tbody>

            </table>
        </div>

@endsection
