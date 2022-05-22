@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){
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
                                    </div>
                                    </div>
                `)

            })
//////ckeditor
            CKEDITOR.replace('editor',{
                language:"fa",

            });
            ///cityForm

            $('#showItem').change(function (e){
                if ($(this).is(':checked')){
                    $(this).val('1');
                }
                else {
                    $(this).val('0');
                }
            });

            $("#edit-submit").submit(function (e){
            
                if ( $('#countProduct').val()!="") {
                    $('#countProduct').val($('#countProduct').val().replaceAll(',', ""));
                }
                if ( $('#priceProduct').val()!="") {
                    $('#priceProduct').val($('#priceProduct').val().replaceAll(',', ""));
                }
                if ( $('#discount_price').val()!="") {
                    $('#discount_price').val($('#discount_price').val().replaceAll(',', ""));
                }

                let show= 0;
                if ($('#showItem').is(':checked')){
                    show=1;
                }
                else {
                    show=0;
                }

                // if ($('.pubChekckbox').is(':checked')){
                //     $('.pubChekckbox').val('1')
                // }
                // else {
                //     $('.pubChekckbox').val('0')
                // }

            });

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
    <form method="post" action="{{route('updateproduct',$product_user->id)}}" enctype="multipart/form-data" id="edit-submit">
        @csrf
        @method("patch")
    <div class="container-fluid card">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-4 col-12 mb-5 mt-3">
                        <label class="form-label mb-2" for="submit-ostan">شهر</label>
                        <select name="city_id" class="form-control select2" id="cityProduct">
                            <option value="">شهر را انتخاب کنید.</option>
                            @if($cities!="notfound")
                                @foreach($cities as $city)
                                    @if($city->id==$product_user->city_id)
                                    <option value="{{$city->id}}" selected>{{$city->cityName}}</option>
                                    @else
                                    <option value="{{$city->id}}">{{$city->cityName}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 mb-5 mt-3">
                        <label class="form-label mb-2" for="submit-ostan">قیمت</label>
                        @if(isset($product_user->price))
                        <input class="form-control seprator justnumber" value="{{number_format(substr(($product_user->price),0))}}" name="price" id="priceProduct" autocomplete="off">
                        @else
                            <input class="form-control seprator justnumber" value="" name="price" id="countProduct" autocomplete="off">

                        @endif
                    </div>
                    <div class="col-lg-4 mb-5 mt-3">
                        <label class="form-label mb-2" for="submit-ostan">تعداد</label>
                        @if(isset($product_user->count))
                        <input class="form-control seprator justnumber" value="{{number_format(substr(($product_user->count),0))}}" name="count" id="countProduct" autocomplete="off">
                        @else
                            <input class="form-control seprator justnumber" value="" name="count" id="countProduct" autocomplete="off">

                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-5 mt-3">
                        <label class="form-label mb-2" for="discount_price">مبلغ تخفیف</label>
                        @if(isset($product_user->discount_price))
                        <input class="form-control seprator justnumber" value="{{number_format(substr(($product_user->discount_price),0))}}" name="discount_price" id="discount_price" autocomplete="off">
                        @else
                            <input class="form-control seprator justnumber" value="" name="discount_price" id="discount_price" autocomplete="off">

                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-5">
                        <label class="form-label mb-2" for="submit-ostan">توضیح</label>
                        <textarea id="editor" name="editor">
                            {{$product_user->description}}
                        </textarea>
                    </div>

                </div>
                <div class="row">
                    <div class="col-2 mb-5 mt-3">
                        <label class="form-label mb-2" for="submit-ostan">نمایش</label>
                        @if($product_user->show=='0')
                        <input type="checkbox" value="0" class="form-control seprator justnumber" name="show" id="showItem" autocomplete="off">
                        @else
                            <input type="checkbox" value="1" class="form-control seprator justnumber" name="show" id="showItem" autocomplete="off" checked>
                        @endif
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
                        @if($pubemkanat!='notfound')
                            @foreach($pubemkanat as $key=>$pub)

                                <div  class="row col-12 row-{{$pub->id}}" data_id="{{$pub->id}}">
                                    <div class="col-lg-8 row">



                                        <div class="col-1 mb-5 mt-5" style="text-align: left">
                                            @if($product_user->pubemkanat->where('id',$pub->id)->first()!=null)
                                            @if($product_user->pubemkanat->where('id',$pub->id)->first()->id==$pub->id)
                                            <input type="checkbox" class="custom-checkbox pubChekckbox" value="{{$pub->id}}" data-id="{{$pub->id}}" name="pubcheck[]"
                                                   autocomplete="off" checked>

                                            @endif
                                            @else
                                                <input type="checkbox" class="custom-checkbox pubChekckbox" value="{{$pub->id}}" data-id="{{$pub->id}}" name="pubcheck[]"
                                                       autocomplete="off">
                                            @endif
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
                        <input type="checkbox" class="custom-checkbox ml-4"  data-id="" name="prv"
                               autocomplete="off" >
                    </div>
                    <div class=" col-12 mb-5 mt-5">
                        <div class="btn btn-info mb-3" id="readyPri">
                            افزودن
                        </div>
                        <div class="col-12 row" id="dropPri">
@foreach($product_user->pvemkanat as $key=>$pv)
                                <div class="row col-12 border-top">
                                    <div class="col-12 mt-3">
                                        <h4>
                                          {{++$key}}.
                                        </h4>
                                        <div>
                                            <div class="col-12 col-md-6 mb-5 mt-5" style="text-align: left">
                                                <input type="text" value="{{$pv->title}}" class="form-control priTitle"  name="privateTitle[]"
                                                       autocomplete="off" placeholder="عنوان">
                                            </div>
                                            <div class="col-12 mb-5 mt-5">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                </div>
            </div>
            </div>
            </div>

            <div class="col-lg-4 mt-5 row pl-5">
                <div class="col-12 text-center">
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-success pt-2 pb-2" id="productsubmit">ثبت</button>
                    </div>
                    <div class="col-12 mb-3">
                        <button class="w-50 btn btn-danger pt-2 pb-2">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>

@endsection
