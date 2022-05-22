@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

<style>
    .dataTables_wrapper {
        margin-top: 50px;
    }

    a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .select2-container--default{
        width: 100%!important;
    }
    #wichSearch,#search-ncode{
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 36px;
    }

    .w-20{
        width: 20%!important;
    }
    .w-10{
        width: 10%!important;
    }
    @media (min-width: 1500px){
        .container {
            max-width: 1400px!important;
        }
    }

    @media (min-width: 992px){
        .mr-140{
            margin-right: 140px!important;
        }
    }
    @media (max-width: 576px){
        .mr-140{
            margin-right:60px!important;
        }
    }
    .breadcrumb{
        background-color: white!important;
    }
    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
        border-radius: 5px;
    }
</style>
@section('js')
    <script>

        $(document).ready(function (e){
            function separateNum(value, input) {
                /* seprate number input 3 number */
                var nStr = value + '';
                nStr = nStr.replace(/\,/g, "");
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                if (input !== undefined) {
                    input.value = x1 + x2;
                } else {
                    return x1 + x2;
                }
            }
            $('tbody').empty();
$('#DataTables_Table_0_info').hide();
$('#DataTables_Table_0_paginate').hide();
$('#DataTables_Table_0_length').hide();
            $('.dataTables_length').after(`
<div class="col-6 row">
<div class="col-lg-4">
<label>خوابگاه</label>
<select class="select2" id="pansion"> </select>
</div>
<div class="col-lg-4">
<label>اتاق</label>
<select class="select2" id="room"></select>
</div>
<div class="col-lg-4">
<label>تخت</label>
<select class="select2" id="takht"></select>
</div>
</div>
<div class="col-12 col-lg-3 mb-1" style="text-align: left">
<label for="serach-ncode h-100" style="margin-top: 35px;" >جستجو کدملی</label>
<select id="wichSearch">
<option value="ncode">کدملی</option>
<option value="family">نام و نام خانوادگی</option>
<option value="mobilecode">شماره موبایل</option>
</select> </div>
<div class="col-12 col-lg-3 mb-1 " style="text-align: left;margin-right: -50px;">
<input class="justnumber" style="margin-top: 26px;" placeholder="جستجو" id="search-ncode">
<button class="btn btn-secondary" id="clickSearch">جستجو</button>
</div>
`)
            $('.select2').select2({
            });
            $.ajax({
                url:"{{asset('admin/getpansionajax')}}",
                success: function (data) {
                    $('#pansion').empty();
                    $('#pansion').append(`\`<option value="">خوابگاه خود را انتخاب کنبد.</option>\``);
                    $('#room').empty();
                    $('#takht').empty();
                    if (data!='notfound') {
                        data.forEach(function (item, index) {
                            $('#pansion').append(`<option value="${item.id}">${item.name}</option>`)
                        });
                    }
                    else {
                        $('.notfound').remove();
                        $('#orderList').hide();
                        $('.pagination').hide();
                        $('#searchPart').hide();
                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                    }
                }
            });

            let countAllOrders = "";
//////limitoffset
            $.ajax({
                url:'{{asset('admin/getallcustomerssss')}}',
                async:false,
                success:function (data) {
                    countAllOrders=data;
                }
            });

            $.ajax({
                url: '{{asset('admin/allcustomerslimitoffset')}}/' + '10' + '/0',
                async:false,
                success: function (data) {

                    if (data != 'notfound') {
                        $('.pagination').empty();
                        let countpages=Math.ceil(countAllOrders.length/10);
                        for(let i=1;i<=countpages;i++) {
                            if (i == '1') {
                                $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                            }
                            else
                            {
                                $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                            }

                        }
                        $('.notfound').remove();
                        $('#orderList').show();
                        $('.pagination').show();
                        $('#searchPart').show();
                        data.forEach(function (item, index) {
                            $('#tbody-users').append(`<tr>
      <td>${index+1}</td>
                        <td class="w-10">${item.name!=null ? item.name:'-'} ${item.family!=null ? item.family:'-'}</td>
                        <td>${item.ncode!=null ? item.ncode:'-'}</td>
                        <td class="w-20">خوابگاه ${item.pansion.name} اتاق ${item.room.roomnumber} تخت${item.takht.takhtnumber}</td>
                        <td class="w-20">${item.bedehi!=null ? separateNum(Math.abs(item.bedehi.substr(0,item.bedehi.length-3))):'-'} تومان ${item.mali}</td>
                        <td class="w-50">
                            <a href="{{asset('admin/reserveuser')}}/${item.id}" title="تاریخچه" class="btn btn-success"><i class="fa fa-history"></i> </a>
                            <a href="{{asset('admin/khorooji')}}/${item.orderId}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{asset('admin/wheremove')}}/${item.orderId}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{asset('admin/vaziat')}}/${item.orderId}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{asset('admin/ekhraaji')}}/${item.orderId}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                             <a href="{{asset('admin/pastcancel')}}/${item.orderId}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                                   <a href="{{asset('admin/gettransactionbyuser')}}/${item.id}" title="تراکنش مالی" class="btn btn-info m-1"><i class="fa fa-money-bill"></i> </a>
                            <a href="{{asset('admin/getstatusmalibyorder')}}/${item.orderId}" title="وضعیت مالی" class="btn btn-secondary m-1"><i class="fa fa-calculator"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-${index+1}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
${item.addr}



                            </div>
                        </div>
<ul class="mt-3" id="mobileList"></ul>
                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                            <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}"><i class="fas fa-trash"></i> </button>
                            <!-- modal delete -->
                            <div class="modal fade" id="delete-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div style="text-align: right">
                                                <p>آیا می خواهید  ${item.family} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>

</tr>`);
                            item.mobiles.forEach(function (ite,inx) {
                                   $('#mobileList').append(`<li>${ite.number}</li>`)
                                  });
                        })
                    }else {
                        $('.notfound').remove();
                        $('#orderList').hide();
                        $('.pagination').hide();
                        $('#searchPart').hide();
                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                    }
                }
            });
            //endlimitoffset
            $('#pansion').change(function (ev) {

                let pansionId=$(this).val();
                $.ajax(
                    {
                        url:"{{asset('admin/getroombypansion')}}/" + pansionId,
                        success:function (data) {
                            $('#room').empty()
                            $('#room').append(`<option value="">اتاق را انتخاب کنید.</option>`);
                            data.forEach(function (item,index) {
                                $('#room').append(`<option value="${item.id}"> طبقه ${item.floor} اتاق ${item.roomnumber}  </option> `)
                            })

                        }
                    }
                )


            });
            $('#room').change(function (ev) {

                let roomId=$(this).val();
                $.ajax(
                    {
                        url:"{{asset('admin/gettakhtbyroom')}}/" + roomId,
                        success:function (data) {
                            $('#takht').empty()
                            $('#takht').append(`<option value="">تخت را انتخاب کنید.</option>`);
                            data.forEach(function (item,index) {
                                $('#takht').append(`<option price="${item.price}" value="${item.id}"> تخت شماره ${item.takhtnumber} </option> `)
                            })

                        }
                    }
                )
            });
            $('#takht').change(function (ev) {
                let id =$(this).val();
                $('#tbody-users').empty();

                let countTakht="";
                $.ajax({
                    url:"{{asset('admin/getcustomsbytakht')}}/" + id,
                    async:false,
                    success:function (data) {
                        if(data!='notfound') {

                            countTakht=data;

                        }
                        else {
                            $('.notfound').remove();
                            $('#orderList').hide();
                            $('.pagination').hide();
                            $('#searchPart').hide();
                            $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                        }
                    }
                });

                $.ajax({
                    url:"{{asset('admin/getcustomsbytakhtlimitoffset')}}/" + id +'/10/0',
                    async:false,
                    success:function (data) {
                        if(data!='notfound') {
                            $('.pagination').empty();

                            let countpages=Math.ceil(countTakht.length/10);
                            for(let i=1;i<=countpages;i++) {
                                if (i == '1') {
                                    $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                                }
                                else
                                {
                                    $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                                }

                            }
                            $('.pagination a').addClass('takhti');
                            $('.pagination a').removeClass('his');
                            data.forEach(function(item,index){
                                $('#tbody-users').append(`<tr>
      <td>${index+1}</td>
                        <td class="w-10">${item.name!=null ? item.name:'-'} ${item.family!=null ? item.family:'-'}</td>
                        <td>${item.ncode!=null ? item.ncode:'-'}</td>
                        <td class="w-20">خوابگاه ${item.pansion.name} اتاق ${item.room.roomnumber} تخت${item.takht.takhtnumber}</td>
                        <td class="w-20">${item.bedehi!=null ? separateNum(Math.abs(item.bedehi.substr(0,item.bedehi.length-3))):'-'} تومان ${item.mali}</td>
                        <td class="w-50">
                            <a href="{{asset('admin/reserveuser')}}/${item.id}" title="تاریخچه" class="btn btn-success"><i class="fa fa-history"></i> </a>
                            <a href="{{asset('admin/khorooji')}}/${item.orderId}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{asset('admin/wheremove')}}/${item.orderId}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{asset('admin/vaziat')}}/${item.orderId}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{asset('admin/ekhraaji')}}/${item.orderId}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                             <a href="{{asset('admin/pastcancel')}}/${item.orderId}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                                   <a href="{{asset('admin/gettransactionbyuser')}}/${item.id}" title="تراکنش مالی" class="btn btn-info m-1"><i class="fa fa-money-bill"></i> </a>
                            <a href="{{asset('admin/getstatusmalibyorder')}}/${item.orderId}" title="وضعیت مالی" class="btn btn-secondary m-1"><i class="fa fa-calculator"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-${index+1}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
${item.addr}
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                                <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}"><i class="fas fa-trash"></i> </button>
                            <!-- modal delete -->
                            <div class="modal fade" id="delete-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div style="text-align: right">
                                                <p>آیا می خواهید  ${item.family} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>

</tr>`);
                            })

                        }
                        else {
                            $('.notfound').remove();
                            $('#orderList').hide();
                            $('.pagination').hide();
                            $('#searchPart').hide();
                            $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                        }
                    }
                })

            });
            $('#clickSearch').click(function(e){

                if ($("#search-ncode").val().length!=0){
                    $("#tbody-users").empty();
                    let column = $("#wichSearch").val();
                    let data =  $("#search-ncode").val();
                    let countDateOrders = "";
                    $.ajax({
                        url:'{{asset('admin/getcustomsbyncode')}}/'+ column + '/' + data ,
                        async:false,
                        success:function (data) {
                            countDateOrders=data;
                        }
                    });
                    $.ajax({
                        url:"{{asset('admin/getallcustomsbyncodelimitoffset')}}/" + column + "/" + data + '/10/' + '0',
                        success: function(data){

                            if (data!='notfound') {
                                $('.pagination').empty();
                                let countpages=Math.ceil(countAllOrders.length/10);
                                for(let i=1;i<=countpages;i++) {
                                    if (i == '1') {
                                        $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                                    }
                                    else
                                    {
                                        $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                                    }

                                }
                                $('.notfound').remove();
                                $('#orderList').show();
                                $('.pagination').show();
                                $('#searchPart').show();
                                $('.pagination a').addClass('his');
                                $('.pagination a').removeClass('takhti');
                                data.forEach(function (item, index) {
                                    $('#tbody-users').append(`<tr>
      <td>${index+1}</td>
                        <td class="w-10">${item.name!=null ? item.name:'-'} ${item.family!=null ? item.family:'-'}</td>
                        <td>${item.ncode!=null ? item.ncode:'-'}</td>
                        <td class="w-20">خوابگاه ${item.pansion.name} اتاق ${item.room.roomnumber} تخت${item.takht.takhtnumber}</td>
                        <td class="w-20">${item.bedehi!=null ? separateNum(Math.abs(item.bedehi.substr(0,item.bedehi.length-3))):'-'} تومان ${item.mali}</td>
                        <td class="w-50">
                            <a href="{{asset('admin/reserveuser')}}/${item.id}" title="تاریخچه" class="btn btn-success"><i class="fa fa-history"></i> </a>
                            <a href="{{asset('admin/khorooji')}}/${item.orderId}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{asset('admin/wheremove')}}/${item.orderId}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{asset('admin/vaziat')}}/${item.orderId}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{asset('admin/ekhraaji')}}/${item.orderId}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                             <a href="{{asset('admin/pastcancel')}}/${item.orderId}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                                   <a href="{{asset('admin/gettransactionbyuser')}}/${item.id}" title="تراکنش مالی" class="btn btn-info m-1"><i class="fa fa-money-bill"></i> </a>
                            <a href="{{asset('admin/getstatusmalibyorder')}}/${item.orderId}" title="وضعیت مالی" class="btn btn-secondary m-1"><i class="fa fa-calculator"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-${index+1}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
${item.addr}
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                                    <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}"><i class="fas fa-trash"></i> </button>
                            <!-- modal delete -->
                            <div class="modal fade" id="delete-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div style="text-align: right">
                                                <p>آیا می خواهید  ${item.family} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>

</tr>`);
                                })
                            }
                            else {
                                $('.notfound').remove();
                                $('#orderList').hide();
                                $('.pagination').hide();
                                $('#searchPart').hide();
                                $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                            }
                        }
                    });
                }
                else {
                    toastr.warning('فرم جستجو خالی است.');
                }

            });

            $('.dataTables_filter').hide()
            $('.hrefbtn').hide();
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
                        url: "{{asset('admin')}}/provider/" + btnDel,
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
            $(document).on('click',".pagination a",function (ep) {
                let $this=$(this);

                if ($(this).hasClass('active') == false) {
                    if ($(this).hasClass('his') == false && $(this).hasClass('takhti') == false ){

                        $('#orderList tbody').empty();
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        $.ajax({
                            url: '{{asset('admin/getorderlimitoffset')}}/' + counts + '/' + preCounts,
                            async:false,
                            success: function (data) {
                                if (data != 'notfound') {
                                    $('.pagination').empty();
                                    let countpages=Math.ceil(countAllOrders.length/10);
                                    for(let i=1;i<=countpages;i++) {
                                        if (i == $this.text()) {
                                            $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                                        }
                                        else
                                        {
                                            $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                                        }

                                    }
                                    // $('a.active').removeClass('active');

                                    $('.notfound').remove();
                                    $('#orderList').show();
                                    $('.pagination').show();
                                    $('#searchPart').show();
                                    data.forEach(function (item, index) {
                                        $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
   <td>${item.fullname}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.vaziat}</td>
                    <td>${item.statusmalis}</td>
                   </tr> `)
                                    })
                                }
                                else {
                                    $('.notfound').remove();
                                    $('#orderList').hide();
                                    $('.pagination').hide();
                                    $('#searchPart').hide();
                                    $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                }
                            }


                        });
                    }
                    else if ($(this).hasClass('his')){

                        $('#orderList tbody').empty();
                        $('a.active').removeClass('active');
                        $(this).addClass('active');
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        let from = $('#from').attr('data-gdate').replaceAll('/', '-');
                        let to = $('#to').attr('data-gdate').replaceAll('/', '-');
                        let countDateOrders = "";
                        $.ajax({
                            url:'{{asset('admin/getallordersbydate')}}/'+ from + '/' + to ,
                            async:false,
                            success:function (data) {
                                countDateOrders=data;
                            }
                        });
                        $.ajax(
                            {
                                url: "{{asset('admin/getallordersbydate')}}/" + from + '/' + to + '/' + counts + '/' + preCounts,
                                success: function (data) {
                                    if (data != 'notfound') {
                                        $('.pagination').empty();
                                        let countpages=Math.ceil(countDateOrders.length/10);
                                        for(let i=1;i<=countpages;i++) {
                                            if (i == $this.text()) {
                                                $('.pagination').append(`<a page="${i}" href="#" class="active his">${i}</a>`);
                                            }
                                            else
                                            {
                                                $('.pagination').append(`  <a page="${i}" href="#" class="his">${i}</a>`);


                                            }

                                        }
                                        $('.notfound').remove();
                                        $('#orderList').show();
                                        $('.pagination').show();
                                        $('#searchPart').show();
                                        data.forEach(function (item, index) {
                                            $('#orderList tbody').append(`<tr>
                    <td>${index + 1}</td>
                    <td>${item.fullname}</td>
                    <td>خوابگاه ${item.pansionname} اتاق ${item.roomnumber} شماره تخت ${item.takht.takhtnumber} </td>
                    <td>${item.raftjalali}</td>
                    <td>${item.bargashtjalali}</td>
                    <td>${item.vaziat}</td>
                    <td>${item.statusmalis}</td>
                   </tr> `)
                                        })
                                    } else {
                                        $('.notfound').remove();
                                        $('#orderList').hide();
                                        $('.pagination').hide();
                                        $('#searchPart').hide();
                                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                    }
                                }
                            }
                        );
                    }
                    else if ($(this).hasClass('takhti')){
                        $('#orderList tbody').empty();
                        $('a.active').removeClass('active');
                        $(this).addClass('active');
                        let pageNunmber = parseInt($(this).text());
                        let prePageNunmber = parseInt($(this).text()) - 1;
                        let preCounts = prePageNunmber * 10;
                        let counts = pageNunmber * 10;
                        let countDateOrders = "";
                        $.ajax({
                            url:'{{asset('admin/getcustomsbytakht')}}/'+ $('#takht').val(),
                            async:false,
                            success:function (data) {
                                countDateOrders=data;
                            }
                        });
                        $.ajax(
                            {
                                url: "{{asset('admin/getcustomsbytakhtlimitoffset')}}/" + $('#takht').val() + '/' + counts + '/' + preCounts,
                                success: function (data) {
                                    if(data!='notfound') {
                                        $('.pagination').empty();

                                        let countpages=Math.ceil(countTakht.length/10);
                                        for(let i=1;i<=countpages;i++) {
                                            if (i == '1') {
                                                $('.pagination').append(`<a page="${i}" href="#" class="active">${i}</a>`);
                                            }
                                            else
                                            {
                                                $('.pagination').append(`  <a page="${i}" href="#">${i}</a>`);


                                            }

                                        }
                                        $('.pagination a').addClass('takhti');
                                        $('.pagination a').removeClass('his');
                                        data.forEach(function(item,index){
                                            $('#tbody-users').append(`<tr>
      <td>${index+1}</td>
                        <td class="w-10">${item.name!=null ? item.name:'-'} ${item.family!=null ? item.family:'-'}</td>
                        <td>${item.ncode!=null ? item.ncode:'-'}</td>
                        <td class="w-20">خوابگاه ${item.pansion.name} اتاق ${item.room.roomnumber} تخت${item.takht.takhtnumber}</td>
                        <td class="w-20">${item.bedehi!=null ? separateNum(Math.abs(item.bedehi.substr(0,item.bedehi.length-3))):'-'} تومان ${item.mali}</td>
                        <td class="w-50">
                            <a href="{{asset('admin/reserveuser')}}/${item.id}" title="تاریخچه" class="btn btn-success"><i class="fa fa-history"></i> </a>
                            <a href="{{asset('admin/khorooji')}}/${item.orderId}" title="خروج" class="btn btn-warning m-1"><i class="fa fa-sign-out"></i> </a>
                            <a href="{{asset('admin/wheremove')}}/${item.orderId}" title="جابجایی" class="btn btn-warning m-1"><i class="fa fa-arrow-right-arrow-left"></i> </a>
                            <a href="{{asset('admin/vaziat')}}/${item.orderId}" title="تغییر وضعیت" class="btn btn-warning m-1"><i class="fa fa-calendar-days"></i> </a>
                            <a href="{{asset('admin/ekhraaji')}}/${item.orderId}" title="اخراج" class="btn btn-warning m-1"><i class="fa fa-face-angry"></i> </a>
                             <a href="{{asset('admin/pastcancel')}}/${item.orderId}" title="کنسل" class="btn btn-warning m-1"><i class="fa fa-cancel"></i> </a>
                                   <a href="{{asset('admin/gettransactionbyuser')}}/${item.id}" title="تراکنش مالی" class="btn btn-info m-1"><i class="fa fa-money-bill"></i> </a>
                            <a href="{{asset('admin/getstatusmalibyorder')}}/${item.orderId}" title="وضعیت مالی" class="btn btn-secondary m-1"><i class="fa fa-calculator"></i> </a>
                            <button href="#" class="btn text-white btn-info" style="padding: 10px 12px" title="نمایش"  data-toggle="modal" data-target="#other-modal-${index+1}"><i class="fas fa-eye"></i> </button>
                            <!-- modal otherdetail -->
                            <div class="modal fade" id="other-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>آدرس</label>
                                                        <div>
${item.addr}
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>
</div>
{{--                            <a href="{{route('provider.edit',$user->id)}}" class="btn text-white btn-warning" style="padding: 10px 12px" title="ویرایش" target="_blank"><i class="fas fa-edit"></i> </a>--}}
                                            <button class="btn text-white btn-danger" style="padding: 10px 12px" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}"><i class="fas fa-trash"></i> </button>
                            <!-- modal delete -->
                            <div class="modal fade" id="delete-modal-${index+1}" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header d-block" style="text-align: right">
                                            <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark" >
                                            <div style="text-align: right">
                                                <p>آیا می خواهید  ${item.family} حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="${item.id}" data-toggle="modal" data-target="#delete-modal-${index+1}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </td>

</tr>`);
                                        })

                                    }
                                    else {
                                        $('.notfound').remove();
                                        $('#orderList').hide();
                                        $('.pagination').hide();
                                        $('#searchPart').hide();
                                        $('.container').append(`<p class='p-2 alert-danger notfound'> موردی وجود ندارد.</p>`);
                                    }
                                }
                            }
                        );
                    }
                }
            });
        })

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">جدول مشترکین</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 230px;background-color: gainsboro">
@if($pages!=0)
        <table class="align-right table table-hover table-dark table-striped mytable w-100 pt-2">
            <thead>
            <tr>

                <th>لیست</th>
                <th>نام</th>
                <th>کد ملی</th>
                <th>تخت</th>
                <th>بدهکاری</th>
                <th>تنظیمات</th>
            </tr>
            </thead>
            <tbody id="tbody-users">

            </tbody>

        </table>
            @if($pages!=0)
                <div class="col-12 m-auto">
                    <div class="pagination justify-content-center mb-2">

                        @for($i=1;$i<=$pages;$i++)
                            @if($i=='1')
                                <a page="{{$i}}" href="#" class="active">{{$i}}</a>
                            @else

                                <a page="{{$i}}" href="#">{{$i}}</a>

                            @endif
                        @endfor

                    </div>
                </div>
            @endif

@endif
    </div>
@endsection
