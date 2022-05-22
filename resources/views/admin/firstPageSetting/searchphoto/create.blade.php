@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){
            $('#attach').change(function (e) {
                let files = e.target.files;
                console.log(files)
                let file = files[0];
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    $('.single-show-img').remove();
                    var imgSrc = theFile.target.result;
                    $('.pick-photo').append("<img class='single-show-img w-100 border p-2' style='width: 400px;height: 200px' src='" + imgSrc + "'> ")
                });
                reader.readAsDataURL(this.files[0]);
            });

        });

    </script>
@endsection
<style>
    #permission-table,#permission-table th,#permission-table td{
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">تغییر تصویر جستجو</h4></div>

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
        <form method="post" action="{{route('editsearchget')}}" enctype="multipart/form-data">
            @csrf
        <div class="row">
            <div class="col-lg-8 row">
<div class="col-12 col-lg-6">
    <h3>تصویر فعلی</h3>
    @if($photo!='notfound' )
    @if($photo->path!=null)
    <img class="w-100 border p-2" src="{{asset($photo->path)}}">
        @else
            <div class="w-100"> در حال حاضر عکسی وجود ندارد</div>
    @endif
    @endif

</div>
                <div class="col-12 col-lg-6 pick-photo">
                    <h3>تصویر انتخاب شده</h3>
{{--                    <img class="w-100 border p-2" src="{{asset($photo->path)}}">--}}
                </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="groupsubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <input id="attach" name="attach" type="file" class="d-none">
                        <label class="btn btn-info w-50" for="attach">
                            ثبت تصویر
                        </label>
                    </div>
                    <div class="col-12 mb-3">
                        <a class="w-50 btn btn-warning pt-2 pb-2 text-white"  data-toggle="modal"
                                data-target="#delete-modal">حذف</a>

                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!-- modal delete -->
        <div class="modal fade" id="delete-modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header d-block" style="text-align: right">
                        <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                    </div>
                    <div class="modal-body text-dark" >
                        <div style="text-align: right">
                            <p>آیا می خواهید تصویر حذف شود؟</p>
                        </div>
                        <div style="text-align: left">
                            <form method="post" action="{{route('deletesearchphoto')}}">
                                @csrf
                            <button type="submit" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$photo!='notfound'?$photo->id:'#'}}" >حذف </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
@endsection
