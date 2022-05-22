@extends('admin.master.home')
<meta name="csrf_token" content="{{csrf_token()}}">

<style>
    @media print {

    }
    .dataTables_wrapper {
        margin-top: 50px;
    }

    a.btn {
        padding-top: 10px;
        padding-bottom: 10px;
    }
    @media (min-width: 1500px){
        .container {
            max-width: 1450px!important;
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
</style>
@section('js')
    <script>
        $(document).ready(function (e){
            $('.hrefbtn').attr('href',"{{route('personal.create')}}");
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
                        url: "{{asset('admin')}}/personal/" + btnDel,
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
            $('.dettach-btn').click(function (e) {
                let uDel=$(this).attr('data-id');
                let gDel=$(this).attr('data_id');
                // let keycol=$(this).parents('td').siblings('.key-col');
                // $('td.key-col').each(function (index) {
                //     if (parseInt($(this).html())>parseInt(keycol)){
                //         $(this).text(parseInt($(this).html())-1)
                //     }
                // });

                $(this).parents('tr[data-id="'+gDel+'-'+uDel+'"]').remove();
                let info = {
                    "_token": "{{ csrf_token() }}",
                    "uId": uDel,
                    "gId": gDel,
                }
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $.ajax(
                    {
                        url: "{{route('dettachgroup')}}",
                        data: info,
                        type: "post",
                        success: function (data) {
                            if (data == "ok") {
                                // location.reload();
                                toastr.success('سمت با موفقیت حذف شد.');

                            } else if (data == "notfound") {
                                // location.reload();
                                toastr.success('بروز خطا');
                            }

                        }
                    }
                );
            });
        })

    </script>
@endsection
@section('content')
    <!-- START: Breadcrumbs-->
    @if($user->group()->where('group_id','2')->exists())
    <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                        <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('personal.index')}}">لیست پرسنل</a></li>
                        <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">کارت شناسایی های {{$user->name.' '.$user->family}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @elseif($user->group()->where('group_id','3')->exists())
        <div class="container-fluid position-fixed" style="top: 105px;z-index: 1000">
            <div class="col-12  align-self-center">
                <div class="sub-header mt-3 py-2 px-3 align-self-center d-sm-flex w-100 rounded" style="border-radius: 20px!important;background: #d0e7ff;box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 15px;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0" style="font-size: 15px">
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('admin')}}">داشبورد</a></li>
                            <li class="breadcrumb-item" style="background: #d0e7ff"><a href="{{route('indexcustom')}}">لیست مشترکین</a></li>
                            <li class="breadcrumb-item active" style="background: #d0e7ff" aria-current="page">کارت شناسایی های {{$user->name.' '.$user->family}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    @endif
    <!-- END: Breadcrumbs-->
    <!-- category table-->
    <div class="container card px-5" style="margin-top: 330px;background-color: gainsboro">
        <div class="row justify-content-center">
      @if(count($user->ncodetype)!=0)
          @foreach($user->ncodetype as $key=>$photo)
              <div class="col-lg-3 col-12 py-4">
                  <a href="{{asset($photo->pivot->path)}}" target="_blank">
                      <div class="titleNcode bg-dark position-absolute" style="width: 1000px"> </div>
                  <img src="{{asset($photo->pivot->path)}}" style="
                  border: 1px solid rgba(0,0,0,0.47);
    width: 200px;
    height: 100%;
    border-radius: 6px;
    cursor: pointer;"
{{--" data-toggle="modal" data-target="#myModal-{{$key}}"--}}
                  >
                  </a>
              </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal-{{$key}}" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body text-center">
                        <img style="width: 100%" src="{{asset($photo->pivot->path)}}">
                        <button class="mt-2 btn btn-secondary w-25" onclick="window.print()">پرینت</button>
                    </div>

                </div>

            </div>
        </div>
            @endforeach
        @endif
    </div>
    </div>
@endsection
