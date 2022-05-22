@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        function removePV() {

            $('.pv-line').last().remove();
            $('.nexty').last().remove();
            $('.pv-line').last().append(`   <span class="col-1 text-center mt-3">
                                         <span class="btn mt-1 p-0 removePV" onclick="removePV()" data-id="" style="cursor: pointer"><i class="fa fa-minus fa-2x"></i> </span>
                                      </span>`);
        }

        function removePVWas() {

            $('.pv-line').last().remove();
            $('.nexty').last().remove();

        }

        $(document).ready(function () {
            let photosCount = $('.single-show-img').length;
            let addpubcheck = [];
            $.switcher('#showItem')
            $('#showItem').change(function (eevv) {
                if ($('#showItem').is(':checked')) {
                    $('#show').attr('value', '1');


                } else {
                    $('#show').attr('value', '0');
                }
            });
            $('.detachPhoto').click(function (ee) {
                let id = $(this).attr('data-id');
                photosCount = photosCount - 1;
                let $this = $(this);
                $.ajax(
                    {
                        url: "{{asset('admin/deletephoto')}}/" + id,
                        type: 'post',
                        data: {'_token': "{{csrf_token()}}"},
                        success: function (data) {
                            if (data != 'notfound') {
                                if ($this.parents('.existPhotos').children('.pick').children('.col-2').children('input').prop('checked')){
                                    $('input[name=pick]').last().prop('checked',true);
                                }
                                $this.parents('.existPhotos').first().remove();
                            }
                        }
                    }
                )
            });





            $('#add-pub').click(function (e) {


                $('#publicTitle').removeClass('d-none');
                $('#submit-pub').removeClass('d-none');

            });


            $('#submit-pub').click(function (event) {
                let title = $('#publicTitle').val();
                let info = {
                    "_token": "{{ csrf_token() }}",
                    "title": title,
                }

                if ($('#publicTitle').val() != "") {
                    $.ajax({
                        url: "{{route('insertpubemkanat')}}",
                        data: info,
                        type: 'post',
                        success: function (data) {
                            if (data != 'notfound') {
                                $('.table-emkanat tbody').empty();
                                data.forEach(function (item, index) {
                                    $('.table-emkanat tbody').append(`      <tr class="row-${item.id}" data_id="${item.id}">
                        <td style="border: 1px #aaaaaa solid">
                            <input type="checkbox" class="custom-checkbox pubChekckbox" value="${item.id}" data-id="${item.id}" name="pubcheck[]"
                                   autocomplete="off">
                        </td>
                        <td style="border: 1px #aaaaaa solid">
                            <label class="form-label mb-2" for="submit-ostan">${item.title}</label>
                        </td>
               <td style="border: 1px #aaaaaa solid">
                                    <span style="cursor: pointer" href="#" class="btn btn-danger deletePub" data-id="${item.id}">حذف</span>
                                </td>
                        </tr>`);
                                });

                                $('.deletePub').click(function (event) {
                                    let id = $(this).attr('data-id');
                                    let info = {
                                        "_token": "{{ csrf_token() }}",
                                        "id": id,
                                    }

                                    $.ajax({
                                        url: "{{route('deletepubemkanat')}}",
                                        data: info,
                                        type: 'post',
                                        success: function (data) {
                                            console.log($(`.row-${id}`).attr('data_id'))
                                            if (data != 'notfound') {
                                                $(`.row-${id}`).remove();
                                                toastr.success('امکانات با موفقیت حذف شد.');
                                            }


                                        }
                                    })
                                });
                            }

                        }
                    });
                    $('#publicTitle').val('');
                } else {
                    toastr.error('عموان باید پر شود.')
                }

            });
            $('.pubChekckbox').change(function (ev) {
                $dataId = $(this).attr('data-id');
                desci = $(this).parents('.col-1').siblings('.col-10').children('.descriptions').val();

                if ($(this).is(':checked')) {
                    addpubcheck.push([$dataId, desci]);
                    console.log(addpubcheck)
                } else {
                    addpubcheck.forEach(function (item, index) {
                        if (item[0] == $dataId) {
                            addpubcheck.splice(index, 1);
                        }

                    });
                }
            });
            $('.deletePub').click(function (event) {
                let id = $(this).attr('data-id');
                let info = {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                }

                $.ajax({
                    url: "{{route('deletepubemkanat')}}",
                    data: info,
                    type: 'post',
                    success: function (data) {
                        console.log($(`.row-${id}`).attr('data_id'))
                        if (data != 'notfound') {
                            $(`.row-${id}`).remove();
                            toastr.success('امکانات با موفقیت حذف شد.');
                        }


                    }
                })
            });
            $('#readyPri').click(function (e) {
                $('.removePV').parents('span').first().remove();
                $('#dropPri').append(`<div class="row col-6 border-top pv-line">
<div class="my-4 col-1 p-0">
<h4>
${$('#dropPri').children('.pv-line').length + 1}.
</h4>
       </div>
                                             <div class="col-10 my-3" style="text-align: left">
                                        <input type="text" class="form-control priTitle"  name="privateTitle[]"
                                               autocomplete="off" placeholder="عنوان">
                                    </div>
                                    </div>
<div class="col-6 nexty"></div>

                `);
                $('.pv-line').last().append(`   <span class="col-1 text-center mt-3">
                                         <span class="btn mt-1 p-0 removePV" onclick="removePV()" data-id="" style="cursor: pointer"><i class="fa fa-minus fa-2x"></i> </span>
                                      </span>`);
            });
            $('#plusPhoto').click(function () {

                let tedad = $('.file-attach').length;
                $('#album').append(` <div class="row  row-photo" style="border-bottom: 1px solid #aaaa">
                                                        <div class="col-md-5 my-2 row" style="text-align: right">
                                                        <div class="col-3">
                                                            <h3>${tedad + 1}.</h3>
                                                            </div>
<div class="col-9">
                                                            <label for="attach-${tedad + 1}" class="btn btn-info mt-2 file-attach-label w-50">انتخاب تصویر</label>

                                                            <input name="attach[]" class="d-none file-attach" id="attach-${tedad + 1}" type="file">
                                                        </div>
                                                        </div>
<div class="col-md-4 my-2 row pick" style="text-align: right;visibility: hidden">
                                                            <div class="col-lg-7 col-9">
                                                                عکس معرفی
                                                            </div>
                                                            <div class="col-2">
                                                                                                                                    <input name="pick" type="radio">
                                                                                                                            </div>
                                                        </div>
                                                        <div class="col-3 my-2 ncodePic" style="height: 150px">

                                                        </div>
                                                    </div>`);
                $('.file-attach').change(function (e) {

                    photosCount = photosCount + 1;
                    $(this).siblings('.deletePhoto').remove();
                    let files = e.target.files;
                    let $this = $(this);
                    let reader = new FileReader();
                    reader.onload = (function (theFile) {
                        var imgSrc = theFile.target.result;
                        $this.parents('.col-md-5').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ");
                    });
                    $this.after(`    <span style="cursor: pointer" class="btn btn-danger mt-2 w-50 deletePhoto">حذف</span>`)
                    $this.parents('.col-md-5').siblings('.pick').children(".col-2").children('input').attr('value',e.target.files[0].name);
                    $this.parents('.col-md-5').siblings('.pick').css('visibility','visible');
                    reader.readAsDataURL(this.files[0]);

                    $('.deletePhoto').click(function (esd) {
                        photosCount = photosCount - 1;
                        $(this).parents('.row-photo').first().remove();
                        if ($(this).parents('.row-photo').children('.pick').children('.col-2').children('input').prop('checked')) {

                            $('input[name=pick]').last().prop('checked', true);
                        }

                    });
                });
            });
            $('.file-attach').change(function (e) {
                photosCount = photosCount + 1;
                $(this).siblings('.deletePhoto').remove();
                let files = e.target.files;
                let $this = $(this);
                let reader = new FileReader();
                reader.onload = (function (theFile) {
                    var imgSrc = theFile.target.result;
                    $this.parents('.col-6').siblings('.ncodePic').html("<img class='single-show-img h-100' src='" + imgSrc + "'> ")
                });
                $this.after(`    <span style="cursor: pointer;margin-right: 10px;" class="btn btn-danger mt-2 w-25 deletePhoto">حذف</span>`)

                reader.readAsDataURL(this.files[0]);

                $('.deletePhoto').click(function (esd) {
                    photosCount = photosCount - 1;
                    $(this).parents('.row-photo').first().remove();
                    if ($(this).parents('.row-photo').children('.pick').children('.col-2').children('input').prop('checked')) {

                        $('input[name=pick]').last().prop('checked', true);
                    }

                });


            });
            $("#submit").submit(function (e) {

                let show = 0;
                if ($('#pansionId').val().length == 0) {
                    e.preventDefault();
                    $('#pansionId').addClass('border-red');
                    toastr.error('قسمت خوابگاه خالی است.');
                } else {
                    $('#pansionId').removeClass('border-red');
                }
                if ($('#floor').val().length == 0) {
                    e.preventDefault();
                    $('#floor').addClass('border-red');
                    toastr.error('قسمت طبقه خالی است.');
                } else {
                    $('#floor').removeClass('border-red');
                }
                if ($('#roomnumber').val().length == 0) {
                    e.preventDefault();
                    $('#roomnumber').addClass('border-red');
                    toastr.error('قسمت شماره اتاق خالی است.');
                } else {
                    $('#roomnumber').removeClass('border-red');
                }
                if ($('#counttakht').val().length == 0) {
                    e.preventDefault();
                    $('#counttakht').addClass('border-red');
                    toastr.error('قسمت تعداد تخت خالی است.');
                } else {
                    $('#counttakht').removeClass('border-red');
                }
                if (photosCount == 0) {
                    e.preventDefault();
                    toastr.error('حداقل یک تصویر باید بارگزاری شود.');
                }
                $('.priTitle').each(function (index){
                    if ($(this).val().length==0){
                        $(this).parents('.pv-line').next('.nexty').remove();
                        $(this).parents('.pv-line').first().remove();
                    }
                });
                $('.titrPv').each(function (index){
                    $(this).text(`${index+1}.`);
                });
            });
        });
    </script>
    <style>
        .table-emkanat td {
            text-align: center;
            padding: 5px 0px;
        }

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

        label.form-label {
            font-size: 20px;
        }

        .single-show-img {
            width: 225px;
        }
    </style>
@endsection
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
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('pansion.index')}}">لیست
                                خوابگاه ها</a></li>
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a
                                href="{{route('roomsofpansion',$room->pansion_id)}}">لیست اتاق
                                های {{$room->pansion->name}}</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">ویرایش
                            اتاق {{$room->roomnumber}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- START: Form-->
    <form method="post" action="{{route('room.update',$room->id)}}" enctype="multipart/form-data" id="submit">
        @csrf
        @method('patch')
        <div class="container card" style="margin-top: 330px;background-color: gainsboro">
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="row justify-content-between px-4">
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">نام خوابگاه</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <select name="pansionId" class="form-control select2" id="pansionId">
                                    <option value=""></option>
                                    @if($pansions!="notfound")
                                        @foreach($pansions as $pansion)
                                            @if($pansion->id==$room->pansion_id)
                                                <option value="{{$pansion->id}}" selected>{{$pansion->name}}</option>
                                            @else
                                                <option value="{{$pansion->id}}">{{$pansion->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">طبقه</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" name="floor" type="number" value="{{$room->floor}}"
                                       id="floor">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">شماره اتاق</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" type="number" value="{{$room->roomnumber}}" id="roomnumber"
                                       name="roomnumber">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between px-4">
                        <div class="col-lg-4 mb-5 mt-3 row">
                            <div class="form-label mb-2 col-3 p-0 text-center position-relative" style="
    border: 1px solid;
    height: 38px;
    border: 1px solid #aaa!important;
    border-collapse: collapse;
    border-radius: 5px;
    background-color: beige;">
                                <span class="form-label mb-2 position-relative" style="top: 24%">تعداد تخت</span>
                            </div>
                            <div class="col-9 p-0 ">
                                <input class="form-control" value="{{$room->counttakht}}" name="counttakht"
                                       id="counttakht"
                                       autocomplete="off" type="number">
                            </div>
                        </div>

                        <div class="col-lg-4 col-12 mb-5 mt-3 row"></div>
                        <div class="col-12 mb-5 mt-3 w-25 row">
                            <label class="form-label mb-2 col-1" for="submit-ostan">نمایش</label>
                            @if($room->show=='0')
                                <input type="checkbox" class="form-control col-1" id="showItem"
                                       autocomplete="off">
                                <input name="show" class="d-none" id="show" value="0">
                            @elseif($room->show=='1')
                                <input type="checkbox" checked class="form-control col-1" name="show" id="showItem"
                                       autocomplete="off">
                                <input name="show" class="d-none" id="show" value="1">
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
                        <div class="col-12 mb-3 mt-5"><h4 class="mt-4">امکانات عمومی</h4></div>
                        <div class="col-md-1 col-12 mb-5">
                            <i href="#" class="btn btn-info" id="add-pub">
                                افزودن
                            </i>
                        </div>
                        <div class="col-12 col-md-6 mb-5 mt-5 ml-4" style="text-align: left">
                            <input type="text" class="form-control d-none" name="title" id="publicTitle"
                                   autocomplete="off" placeholder="عنوان">
                        </div>
                        <div class="col-md-1 col-12 mb-5 mt-5">
                            <div class="btn btn-success d-none w-100" id="submit-pub">
                                ثبت
                            </div>
                        </div>
                        <div id="allPub" class="row col-12 px-5">
                            @if($pubs!='notfound')
                                <table class="table-emkanat"
                                       style="width: 15%">
                                    @foreach($pubs as $key=>$pub)
                                        <tr class="row-{{$pub->id}}" data_id="{{$pub->id}}">
                                            <td>
                                                @if($room->pubemkanat->where('id',$pub->id)->first()!=null)
                                                    @if($room->pubemkanat->where('id',$pub->id)->first()->id==$pub->id)
                                                        <input type="checkbox" class="custom-checkbox pubChekckbox"
                                                               value="{{$pub->id}}" data-id="{{$pub->id}}"
                                                               name="pubcheck[]"
                                                               autocomplete="off" checked>

                                                    @endif
                                                @else
                                                    <input type="checkbox" class="custom-checkbox pubChekckbox"
                                                           value="{{$pub->id}}" data-id="{{$pub->id}}" name="pubcheck[]"
                                                           autocomplete="off">
                                                @endif
                                            </td>
                                            <td>
                                                <label class="form-label mb-2"
                                                       for="submit-ostan">{{$pub->title}}</label>
                                            </td>
                                            <td>
                                                <span style="cursor: pointer" href="#" class="btn btn-danger deletePub"
                                                      data-id="{{$pub->id}}">حذف</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-5 mt-5">
                            <h4 class="mt-4 mb-4 d-inline">امکانات اختصاصی</h4>
                        </div>
                        <div class=" col-12 mb-5">
                               <span style="cursor: pointer" class="mb-3 col-12" id="readyPri">
                            <i class="fa fa-plus fa-2x"></i>
                        </span>
                            <div class="col-12 row" id="dropPri">
                                @if($room->pvemkanat!=null)
                                    @foreach($room->pvemkanat as $key=>$pv)


                                        <div class="row col-6 border-top pv-line">
                                            <div class="my-4 col-1 p-0">
                                                <h4>
                                                    {{++$key}}.
                                                </h4>
                                            </div>
                                            <div class="col-10 my-3" style="text-align: left">
                                                <input type="text" class="form-control priTitle" value="{{$pv->title}}"
                                                       name="privateTitle[]"
                                                       autocomplete="off" placeholder="عنوان">
                                            </div>
                                            <span class="col-1 text-center mt-3">
                                         <span class="btn mt-1 p-0" onclick="removePVWas()" data-id=""
                                               style="cursor: pointer"><i class="fa fa-minus fa-2x"></i> </span>
                                      </span></div>
                                        <div class="col-6 nexty"></div>


                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 mt-5 row m-auto" style="height: 150px">


                    <div class="col-12 mb-3 text-center text-lg-left">

                        <span style="cursor:pointer; width: 157px!important;" class="btn btn-info w-25"
                              data-toggle="modal"
                              data-target="#modalPhoto">
                            ثبت تصویر
                        </span>
                        <!-- PhotoModal -->
                        <div id="modalPhoto" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header row" style="text-align: right" dir="ltr">
                                        <button type="button" class="close m-1" data-dismiss="modal">&times;</button>
                                        <div class="col-12">
                                            <h3 class="w-100">آپلود تصویر</h3>
                                        </div>


                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid" id="album">
                                            <div class="row mb-4" style="border-bottom: 1px solid #aaaaaa">
                                                <h4 class="d-inline px-4">بیشتر</h4>
                                                <span id="plusPhoto"><i class="fa fa-plus fa-2x"
                                                                        style="cursor: pointer"></i> </span>
                                            </div>
                                            @if($room->photo!=null)
                                                @foreach($room->photo as $key=>$p)
                                                    <div class="row existPhotos" style="border-bottom: 1px solid #aaaa">
                                                        <div class="col-md-5 my-2 row" style="text-align: right">
                                                            <div class="col-3">
                                                                <h3>{{++$key}}.</h3>
                                                            </div>
                                                            <div class="col-9">
                                                                <span data-id="{{$p->id}}"
                                                                      style="cursor: pointer"
                                                                      class="btn btn-danger mt-2 w-50 detachPhoto">حذف</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 my-2 row pick" style="text-align: right">
                                                            <div class="col-lg-7 col-9">
                                                                عکس معرفی
                                                            </div>
                                                            <div class="col-2">
                                                                @if($p->pick=='1')
                                                                    <input name="pick" type="radio" value="{{$p->id}}"
                                                                           checked>
                                                                @else
                                                                    <input name="pick" type="radio" value="{{$p->id}}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 my-2 ncodePic" style="height: 150px">
                                                            <img class='single-show-img h-100'
                                                                 src='{{asset($p->path)}}'>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center text-lg-right">
                        <input style="width: 157px!important;" type="submit" class="btn w-25 btn-success" value="ثبت">
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

@endsection
