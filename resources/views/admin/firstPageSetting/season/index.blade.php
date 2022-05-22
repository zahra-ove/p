@extends("admin.master.home")
@section("pagecss")
    <style>
        i {
            width: 20px;
        }

        body {
            font-family: IRANSansWeb_Light;
        }

        .modal {
            color: black;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function (e) {
            $('.delete-btn').click(function (e) {
                let btnDel=$(this).attr('data-id');
                let orderDel=$(this).attr('orders');

                $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}"
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/deleteseason/" + btnDel,
                        data: info,
                        type: "delete",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('اسلاید با موفقیت حذف شد.');
                                $('input[name=ticketNum]').each(function (index) {
                                    let order= parseInt($(this).val());

                                    if (order>parseInt(orderDel))
                                    {
                                        $(this).val(order-1)
                                    }
                                })

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
            $('.edited').click(function (e) {
                let btnDel=$(this).attr('data-id');
                let orderDel=$(this).attr('orders');
                console.log($(this).parents('td').siblings('td').children('input[name=ticketNum]').val())

                let info = {
                    "_token": "{{ csrf_token() }}",
                    'orders': $(this).parents('td').siblings('td').children('input[name=ticketNum]').val()
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/editseason/" + btnDel,
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                location.reload();
                                toastr.success('اسلاید با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
            $('.search-box').keyup(function (e) {
                $('.delete-btn').click(function (e) {
                    let btnDel=$(this).attr('data-id');
                    let orderDel=$(this).attr('orders');

                    $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                    let info = {
                        "_token": "{{ csrf_token() }}"
                    }
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $.ajax(
                        {
                            url: "{{asset('admin')}}/deleteseason/" + btnDel,
                            data: info,
                            type: "delete",
                            success: function (data) {
                                if (data == "ok") {
                                    // location.reload();
                                    toastr.success('اسلاید با موفقیت حذف شد.');
                                    $('input[name=ticketNum]').each(function (index) {
                                        let order= parseInt($(this).val());

                                        if (order>parseInt(orderDel))
                                        {
                                            $(this).val(order-1)
                                        }
                                    })

                                } else if (data == "notfound") {
                                    // location.reload();
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                });
                $('.edited').click(function (e) {
                    let btnDel=$(this).attr('data-id');
                    let orderDel=$(this).attr('orders');
                    console.log($(this).parents('td').siblings('td').children('input[name=ticketNum]').val())

                    let info = {
                        "_token": "{{ csrf_token() }}",
                        'orders': $(this).parents('td').siblings('td').children('input[name=ticketNum]').val()
                    }
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $.ajax(
                        {
                            url: "{{asset('admin')}}/editseason/" + btnDel,
                            data: info,
                            type: "post",
                            success: function (data) {
                                if (data == "ok") {
                                    location.reload();
                                    toastr.success('اسلاید با موفقیت حذف شد.');

                                } else if (data == "notfound") {
                                    // location.reload();
                                    toastr.success('بروز خطا');
                                }

                            }
                        }
                    );
                });
            });
        })
    </script>
@endsection

@section("content")


    <div class="container-fluid">
        <div class="card-header mb-4 " style="margin-top: 100px">
{{--            <a class="btn btn-list  mb-4 bck"--}}
{{--               href="{{asset('admin/slider')}}" target="_blank" style="float: left">بازگشت به صفحه اصلی--}}
{{--            </a>--}}
            <h4 class="card-title">جدول پرفروش ترین ها</h4>
        </div>
        <table class="align-right table table-hover table-dark table-striped" id="myTable">
            @if($seasons=="notFound")
                <h5 class="alert-danger pr-2 pt-4 pb-4">.محصولی برای پرفروش ها ثبت نشده است</h5>
            @else
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>عنوان</th>
                    <th>دسته بندی</th>
                    <th>تامین کننده</th>
                    <th>شهر</th>
                    <th>فصل</th>
                    <th>ترتیب نمایش</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @if($seasons!='notfound')
                @foreach($seasons as $key=>$p)
                    <tr data-id="{{$p->id}}">


                        <td>{{++$key}}</td>

                        <td>{{$p->product_user_id ? $p->productuser->product->title:'-' }}</td>

                        <td>{{$p->product_user_id ? $p->productuser->product->category->title:'-' }}</td>

                        <td>{{$p->product_user_id ? $p->productuser->user->business_title:'-' }}</td>
                        <td>{{$p->city_id ? $p->city->name:'-' }} </td>
                        @if($p->seasons!=null)
                            @if($p->seasons=='z')
                        <td>زمستان </td>
                            @elseif($p->seasons=='t')
                        <td>تابستان</td>
                            @elseif($p->seasons=='p')
                        <td>پاییز</td>
                            @elseif($p->seasons=='b')
                        <td>بهار</td>
                                @endif
                        @else
                            <td>-</td>
                        @endif
                        <td class="col-2">

                                    <input type="number" min="1" name="ticketNum"  tahatorId="{{$p->id}}" value="{{$p->orders}}" class="w-25 number" autocomplete="off">

                        </td>
                        <td>
                            <i title="حذف" class="fa fa-trash btn btn-danger pt-2 pb-2" data-toggle="modal" data-target="#delete-modal-{{$key}}"></i>
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
                                                <p>آیا می خواهید حذف شود؟</p>
                                            </div>
                                            <div style="text-align: left">
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" orders="{{$p->orders}}" title="حذف" data-id="{{$p->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <i title="ویرایش" class="fa fa-edit btn btn-warning pt-2 pb-2 edited" data-id="{{$p->id}}"></i>
                        </td>



                    </tr>
                @endforeach
                @endif
                </tbody>
            @endif
        </table>
    </div>



@endsection
