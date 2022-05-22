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
                $(this).parents('tr[data-id="'+btnDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}"
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{asset('admin')}}/city/" + btnDel,
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
        })
    </script>
@endsection

@section("content")


    <div class="container-fluid">
        <div class="card-header mb-4 " style="margin-top: 100px">
{{--            <a class="btn btn-list  mb-4 bck"--}}
{{--               href="{{asset('admin/slider')}}" target="_blank" style="float: left">بازگشت به صفحه اصلی--}}
{{--            </a>--}}
            <h4 class="card-title">تنظیمات صفحه اول</h4>
        </div>
        <table class="align-right table table-hover table-dark table-striped" id="myTable">
            @if($economics=="notFound")
                <h5 class="alert-danger pr-2 pt-4 pb-4">.محصولی برای اقتصادی ها ثبت نشده است</h5>
            @else
                <thead>
                <tr>

                    <th>شماره لیست</th>
                    <th>عنوان</th>
                    <th>دسته بندی</th>
                    <th>تامین کننده</th>
                    <th>شهر</th>
                    <th>ترتیب نمایش</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @if($economics!='notfound')
                @foreach($economics as $key=>$p)
                    <tr>


                        <td>{{++$key}}</td>

                        <td>{{$p->product_user_id ? $p->productuser->product->title:'-' }}</td>

                        <td>{{$p->product_user_id ? $p->productuser->product->category->title:'-' }}</td>

                        <td>{{$p->product_user_id ? $p->productuser->user->business_title:'-' }}</td>
                        <td>{{$p->city_id ? $p->city->name:'-' }} </td>
                        <td class="col-2">
                            <div>
                                <form action="#" method="post" id="orderSub-{{$key}}">
                                    @method('patch')
                                    @csrf
                                    <input type="number" min="1" name="ticketNum"  tahatorId="{{$p->id}}" value="{{$p->orders}}" class="w-25 number" autocomplete="off">
                                </form>
                            </div>
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
                                                <button data-dismiss="modal" class="btn text-white btn-danger delete-btn" title="حذف" data-id="{{$p->id}}" data-toggle="modal" data-target="#delete-modal-{{$key}}">حذف </button>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <i title="ویرایش" class="fa fa-edit btn btn-warning pt-2 pb-2"></i>
                        </td>



                    </tr>
                @endforeach
                @endif
                </tbody>
            @endif
        </table>
    </div>



@endsection
