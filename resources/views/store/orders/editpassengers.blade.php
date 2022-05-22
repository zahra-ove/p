@extends('store.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">
@section('js')
    <script>
        $(document).ready(function (){




            $('.delete-btn').click(function (e) {
                let btnDel=$(this).attr('data-id');
                // let keycol=$(this).parents('td').siblings('.key-col');
                // $('td.key-col').each(function (index) {
                //     if (parseInt($(this).html())>parseInt(keycol)){
                //         $(this).text(parseInt($(this).html())-1)
                //     }
                // });


            });
            $('#submit').submit(function (ev) {
                if ($('input').val()==""){
                    ev.preventDefault();
                    toastr.error('تمامی کادر ها باید کامل پر شوند.');
                }
            });
        });

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    <div class="py-5 mt-5 mb-lg-3 row">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 px-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0">ثبت اطلاعات افراد</h4></div>

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

    <!-- passenger table-->
    <div class="container-fluid card border-top row m-auto">
        {{--            <h2 class="mb-3 pt-2">اطلاعات مسافران</h2>--}}
        <table class="align-right table table-hover table-info table-striped mytable w-100">
            <thead>
            <tr class="mt-3 mb-3">

                <th>شماره لیست</th>
                <th>نام </th>
                <th>نام خانوادگی</th>
                <th>سن</th>
                <th>کد ملی</th>
                <th>جنسیت</th>

            </tr>
            </thead>
            <tbody>
            <form method="post" action="{{route('editpassenger')}}" id="submit">
                @csrf
                @if($passengers!="notfound")

                    @foreach($passengers as $key=>$passenger)


                        <input class="d-none" name="id[]" value="{{$passenger->id}}" autocomplete="off">
                        <tr data-id="{{$passenger->id}}">
                            <td class="key-col">{{++$key}}</td>
                            <td>

                                <input name="name[]" id="name"  autocomplete="off">
                            </td>

                            <td>

                                <input name="family[]" id="family"  autocomplete="off">
                            </td>
                            <td>

                                <input type="number" name="age[]" id="age"  autocomplete="off">
                            </td>
                            <td>

                                <input name="ncode[]" class="justnumber" id="ncode"  autocomplete="off">
                            </td>

                            <td>

                                <select name="gender[]">
                                    <option value="male">آقا</option>
                                    <option value="female">خانم</option>
                                </select>
                            </td>
                        </tr>



                    @endforeach
                @endif
                <tr data-id="{{$passenger->id}}">
                    <td class="key-col">
                        <button class="btn btn-success" id="btn-submit" type="submit">ثبت</button>
                    </td>
                    <td>

                    </td>

                    <td>

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>

                    <td>

                    </td>
                </tr>
            </form>
            </tbody>

        </table>
    </div>
@endsection
