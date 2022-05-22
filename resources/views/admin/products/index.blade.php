@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
<style>
    .dataTables_wrapper{
        margin-top: 50px;
    }
    a.btn{
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .select2{
        width: 100%!important;
    }
</style>
@section('js')
    <script>
        $('.dataTables_filter').after('<div class="col-sm-12 col-md-6 mt-2 order-1"><a href="{{route('product.create')}}" class="btn btn-success mb-2" style="width:20%">افزودن</a></div>');
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
                    url: "{{asset('admin')}}/product/" + btnDel,
                    data: info,
                    type: "delete",
                    success: function (data) {
                        if (data == "ok") {
                            // location.reload();
                            toastr.success('محصول با موفقیت حذف شد.');

                        } else if (data == "notfound") {
                            // location.reload();
                            toastr.success('بروز خطا');
                        }

                    }
                }
            );
        });
    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">جدول محصولات</h4></div>

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
            <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>نام محصول</th>
                    <th>نام زیر دسته</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @if($products!='notfound')
                @foreach($products as $key=>$product)
                <tr data-id="{{$product->id}}">
                        {{--             @if($tik->ferestande=\Illuminate\Support\Facades\Auth::id() or $tik->girande=\Illuminate\Support\Facades\Auth::id())--}}
                        <td>{{++$key}}</td>

                        <td>{{$product ? $product->protitle:'-'}}</td>

                        <td>{{$product ? $product->cattitle : '-'}}</td>

                        <td>
                            <button class="btn text-white btn-warning" title="ویرایش" data-id="{{$product->id}}" data-toggle="modal" data-target="#edit-modal-{{$key}}"><i class="fas fa-edit"></i> </button>
                            <button  class="btn text-white btn-danger" title="حذف" data-id="{{$product->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}"><i class="fas fa-trash"></i> </button>
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
                                                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">ویرایش محصول</h4></div>
                                                        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END: Breadcrumbs-->
                                            <!-- START: Form-->
                                            <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('patch')
                                                <div class="container-fluid card">
                                                    <div class="row parent-file">
                                                        <div class="col-lg-8 row">
                                                            <div class="col-md-6 mb-5 mt-5" style="text-align: right;">
                                                                <label class="form-label mb-2" for="submit-ostanname">نام محصول</label>
                                                                <input class="form-control edit-name" name="title" value="{{$product->protitle}}" autocomplete="off" id="ostanName">
                                                            </div>
                                                            <div class="col-md-6 mb-5 mt-5" style="text-align: right;">
                                                                <label class="form-label mb-2 w-100" for="ostanIdInsert-{{$key}}">زیر دسته</label>
                                                                <select name="category_id"  class="form-control w-100 select2" id="ostanIdInsert-{{$key}}">
                                                                    <option value="">دسته بندی را انتخاب کنید.</option>
                                                                    @if($categories!="notfound")
                                                                        @foreach($categories as $category)
                                                                            @if($category->id==$product->category_id)
                                                                                <option value="{{$category->id}}" selected>{{$category->subtitle}}</option>
                                                                            @else
                                                                                <option value="{{$category->id}}">{{$category->subtitle}}</option>
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
                                                <p>آیا می خواهید زیردسته {{$product->protitle}} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$product->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

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
