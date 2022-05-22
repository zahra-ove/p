@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){
                    $('.hrefbtn').hide();
                $("#subcategorysubmit").click(function (e){
                    let subcategoryname=$('#namesubcat').val();
                    let category=$('#categoryIdInsert').val();
                    if (category == "") {
                        $('#categoryIdInsert').addClass('border-red');
                    }
                    else {
                        $('#categoryIdInsert').removeClass('border-red');
                    }

                    if (subcategoryname == "") {
                        $('#namesubcat').addClass('border-red');
                    }
                    else {
                        $('#namesubcat').removeClass('border-red');
                    }

                    if (category != "" && subcategoryname!='') {


                        let info={
                            "_token": "{{ csrf_token() }}",
                            "name":subcategoryname,
                            "category_id":category
                        }
                        $.ajax(
                            {
                                url:"{{route('subcategory.store')}}",
                                headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                                // async:true,
                                // contentType: false,
                                // processData: false,
                                data:info,
                                type:"post",
                                success: function (data){
                                    if (data=="ok"){
                                        location.reload();
                                        toastr.success('زیر دسته با موفقیت ثبت شد.');
                                    }
                                    else if (data=="notfound"){
                                        location.reload();
                                        toastr.success('بروز خطا');
                                    }

                                }
                            }
                        );
                    }

                    else {

                        toastr.error('تمامی قسمت ها باید پر شوند.')

                }
                });
                $("#categorysubmit").click(function (e){
                    let categoryname=$('#catName').val();
                    if (categoryname == "") {
                        toastr.error('فیلد دسته بندی حتما پر شود.')
                        $('#catName').addClass('border-red');
                    } else {
                        $('#catName').removeClass('border-red');
                        info={
                            "_token": "{{ csrf_token() }}",
                            "name":categoryname,
                        }
                        $.ajax(
                            {
                                url:"{{route('category.store')}}",
                                data:info,
                                type:"post",
                                success: function (data){
                                    if (data=="ok"){
                                        location.reload();
                                        toastr.success('دسته بندی با موفقیت ثبت شد.');
                                    }
                                    else if (data=="notfound"){

                                        toastr.success('بروز خطا');
                                    }

                                }
                            }
                        );
                    }
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
                        url: "{{asset('admin')}}/category/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('شهر با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });

            $('.search-box').keyup(function (e) {
                console.log('hi');
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
                            url: "{{asset('admin')}}/category/" + btnDel,
                            data: info,
                            type: "delete",
                            success: function (data) {
                                if (data == "ok") {
                                    // location.reload();
                                    toastr.success('شهر با موفقیت حذف شد.');

                                } else if (data == "notfound") {
                                    // location.reload();
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                });
            });
            });

    </script>
@endsection
<style>
    .select2{
        width: 100%!important;
    }
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت زیر دسته</h4></div>

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
    <div class="container-fluid card">
        <div class="row">
            <div class="col-lg-8 row">
                <div class="col-lg-6 mb-5 mt-5">
                    <label class="form-label mb-2" for="submit-cityname">نام زیردسته</label>
                    <input class="form-control" name="name" autocomplete="off" id="namesubcat">
                </div>
                <div class="col-lg-6 mb-5 mt-5">
                    <label class="form-label mb-2" for="submit-ostan">انتخاب دسته بندی</label>
                    <select name="category_id" class="form-control select2" id="categoryIdInsert">
                        <option value="">دسته بندی را انتخاب کنید.</option>
                        @if($categories!="notfound")
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="subcategorysubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                    <div class="col-12 mb-3">

                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-info w-50 pt-2 pb-2" data-toggle="modal" data-target="#myModal">ثبت دسته بندی</button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- START: Breadcrumbs-->
                                            <div class="py-5 mt-5 mb-lg-3 row container-fluid">
                                                <div class="col-12  align-self-center">
                                                    <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت دسته بندی</h4></div>

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
                                            <div class="container row">
                                                <div class="col-lg-6 mb-5 text-left">
                                                    <label class="form-label mb-2" for="submit-cityname">
                                                        نام دسته بندی</label>
                                                    <input class="form-control" id="catName" name="name" autocomplete="off">
                                                </div>
                                                <div class="col-lg-6 mb-5 pt-4">
                                                    <button class="w-50 btn btn-success pt-2 pb-2" id="categorysubmit">ثبت</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                </div>
                <div class="col-12 singleShow mt-5">
                </div>

            </div>
        </div>
    </div>
        <!-- category table-->
        <div class="container-fluid card border-top row m-auto">
            <h2 class="mb-3 pt-2">جدول دسته بندی</h2>
            <table class="align-right table table-hover table-dark table-striped mytable w-100">
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>نام زیر دسته</th>
                    <th>نام دسته بندی</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @if($subcategories!='notfound')
                 @foreach($subcategories as $key=>$subcategory)
                     <tr data-id="{{$subcategory->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>

                        <td>{{$subcategory->subtitle!=null ? $subcategory->subtitle:'-'}}</td>

                        <td>{{$subcategory->maintitle!=null ? $subcategory->maintitle : '-'}}</td>
                        <td class="text-center">
                            <button class="btn text-white btn-warning" title="ویرایش" data-id="{{$subcategory->id}}" data-toggle="modal" data-target="#edit-modal-{{$key}}"><i class="fas fa-edit"></i> </button>
                            <button class="btn text-white btn-danger" title="حذف" data-id="{{$subcategory->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                            <form action="{{route('category.update',$subcategory->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="container-fluid card">
                                                    <div class="row parent-file">
                                                        <div class="col-lg-8 row">
                                                            <div class="col-md-6 mb-5 mt-5" style="text-align: right;">
                                                                <label class="form-label mb-2" for="submit-ostanname">نام زیر دسته</label>
                                                                <input class="form-control edit-name" name="title" value="{{$subcategory->subtitle}}" autocomplete="off" id="ostanName">
                                                            </div>
                                                            <div class="col-md-6 mb-5 mt-5" style="text-align: right;">
                                                                <label class="form-label mb-2 w-100" for="ostanIdInsert-{{$key}}">دسته بندی</label>
                                                                <select name="category_id"  class="form-control w-100 select2" id="ostanIdInsert-{{$key}}">
                                                                    <option value="">دسته بندی را انتخاب کنید.</option>
                                                                    @if($categories!="notfound")
                                                                        @foreach($categories as $category)
                                                                            @if($category->id==$subcategory->category_id)
                                                                                <option value="{{$category->id}}" selected>{{$category->title}}</option>
                                                                            @else
                                                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 mb-5 mt-5 row pl-5">
                                                            <div class="col-12 text-center">
                                                                <div class="col-12 mb-3 mt-3">
                                                                    <button type="submit" class="w-100 btn btn-success mt-3 pt-2 pb-2 submit-edit" id="ostansubmit" data-id="{{$category->id}}">ثبت</button>
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
                                                <p>آیا می خواهید زیردسته {{$subcategory->maintitle}} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$subcategory->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
