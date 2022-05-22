@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){
            ///cityForm



                $("#productsubmit").click(function (e){
                    let productName=$('#productName').val();
                    let category=$('#categoryIdInsert').val();
                    {{--let info={--}}
                    {{--    "_token": "{{ csrf_token() }}",--}}
                    {{--    "name":cityname,--}}
                    {{--    "ostan_id":ostan--}}
                    {{--}--}}

                    var postData = new FormData();
                    // postData.append('attach', files[0]);
                    postData.append('title', productName);
                    postData.append('category_id', category);
                    $.ajax(
                        {
                            url:"{{route('product.store')}}",
                            headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                            async:true,
                            contentType: false,
                            processData: false,
                            data:postData,
                            type:"post",
                            success: function (data){
                                if (data=="ok"){
                                    location.href="{{route('product.index')}}";
                                    toastr.success('محصول با موفقیت ثبت شد.');
                                }
                                else if (data=="notfound"){

                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                });
// Read in the image file as a data URL.
                reader.readAsDataURL(this.files[0]);



        })
    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row w-100">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت محصول</h4></div>

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
                <label class="form-label mb-2" for="submit-cityname">نام محصول</label>
                <input class="form-control" name="name" autocomplete="off" id="productName">
            </div>
            <div class="col-lg-6 mb-5 mt-5">
                <label class="form-label mb-2" for="submit-ostan">زیردسته</label>
                <select name="ostan_id" class="form-control" id="categoryIdInsert">
                    <option value="">زیردسته را انتخاب کنید.</option>
                    @if($categories!="notfound")
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->subtitle}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            </div>
            <div class="col-lg-4 mb-5 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="productsubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                </div>
                <div class="col-12 singleShow mt-5">
                </div>

            </div>
        </div>
    </div>

@endsection
