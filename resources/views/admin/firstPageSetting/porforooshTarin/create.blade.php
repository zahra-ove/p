@extends("admin.master.home")
<meta name="csrf_token" content="{{csrf_token()}}">
@section("pagecss")


    <style>
        i {
            width: 20px;
        }
        .custom-select{
            background: none;
            padding-right: 8px;
            padding-left: 20px;
        }

        .select2-selection{
            height: 38px!important;
            border: 1px solid #ced4da!important;
        }

        select{
            font-size: 13px!important;
            height: 38px!important;
            background: white!important;
        }

        body {
            font-family: IRANSansWeb_Light;
        }

        .v1 {
            border-left: 6px solid #dc3545;
            height: 180%;
            position: absolute;
            left: 10%;
            margin-left: -3px;
            top: 0;
        }

        .modal {
            color: black;
        }

        .img {
            border-radius: 8px;
            padding: 5px;
            width: 200px;
            height: 200px;
        }


        .list1 tr:hover {
            background-color: #FEFEFE;
        }

        .polaroid {
            width: 100%;
            height: 100%;
            /*background-color: white;*/
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin-bottom: 25px;
        }

        .pagination {
            display: inline-block;

        }


        .pagination a {
            color: black;
            align: center;
            float: right;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
        }

        .page-btn.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ffffff;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        .uploaded.text-right {
            text-align: right !important;
        }


    </style>
@endsection
@section("js")
    <script>
        $('.select2').select2();
        $(document).ready(function () {
            console.log('hi')
            let tahatorPanjahSelectedProduct = [];
            let tahatorPanjahSelectUser = [];
// Get SubCatgory By Catgeory
            $('#inputGroupSelect07').on('change', function (e) {
                console.log('hi')
                let id = $(this).val();
                let url = "{{asset('getsubategory')}}/" + id;

                $.get(url, function (data) {

                    if (data === 'notFound') {
                        toastr.error('دسته بندي يافت نشد');
                        return false;
                    }
                    let rows = '<option value="" selected>انتخاب کنید</option>';
                    data.forEach(function (value, index) {

                        rows += '<option value="' + value.subId + '">' + value.subTtile + '</option>';
                    })
                    $('#city-select option').remove();
                    $('#city-select').append('<option value="" selected>انتخاب کنید</option>');
                    $('#tahator50-table option').remove();
                    $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                    $('#tahatoor50-table tr').remove();
                    $('#tahatoor50-table').append(`<tr>
                    <td>انتخاب</td>
                    <th>نام محصول</th>
                    </tr>`);

                    $('#inputGroupSelect08').html(rows);

                })
                    .fail(function (e) {
                        toastr.error('بروز خطا');
                        return false;
                    })
            })

            // GET city By category

            $('#inputGroupSelect08').on('change', function (e) {
                e.preventDefault();
                let id = $(this).val();
                if (id < 1) {
                    return false;
                }

                let url2 = "{{asset('getcitybycategory')}}/" + id;
                $.get(url2, function (data) {
                    if (data === 'notFound') {
                        toastr.error('خدمات دهنده يافت نشد');
                        $('#city-select option').remove();
                        $('#city-select').append('<option value="" selected>انتخاب کنید</option>');
                        $('#tahator50-table option').remove();
                        $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                        $('#tahatoor50-table tr').remove();
                        $('#tahatoor50-table').append(`<tr>
                        <td>انتخاب</td>
                        <th>نام محصول</th>
                        </tr>`);

                        // $('#providerImage').remove();
                        return false;
                    }

                    let providers = '<option>انتخاب کنيد</option>';
                    data.forEach(function (value, index) {
                        providers += '<option value="' + value.cityid + '">' + value.cityname + '</option>';
                    })

                    $('#city-select option').remove();
                    $('#city-select').append('<option value="" selected>انتخاب کنید</option>');
                    $('#tahator50-table option').remove();
                    $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                    $('#tahatoor50-table tr').remove();
                    $('#tahatoor50-table').append(`<tr>
                    <td>انتخاب</td>
                    <th>نام محصول</th>
                    </tr>`);


                    $('#city-select').html(providers);
                })
                    .fail(function (d) {
                        toastr.error('بروز خطا');
                        return false;
                    })
            })

            let catId;


            // Get Provider by id City
            // Get useId & category from provider

            $("#tahator50-table").on("change", function (e) {

                e.preventDefault();
                let id = $(this).val();
                catId = $('#inputGroupSelect08').val();
                let tagProvider = '<td>انتخاب</td><th>نام محصول</th>';
                let url2 = "{{asset('getProductsbyprovider/')}}/" + id;
                $.get(url2, function (data) {

                    let count = Math.floor(data / 5);
                    if (data % 5 !== 0)
                        count++;
                    let btns = '';
                    for (let i = 1; i <= count; i++) {
                        if (i === 1) {
                            btns += `<a  class="page-btn active" form="tahatorpanjah-form" page="${i}">${i}
                        </a>`;
                        } else {
                            btns += `<a  class="page-btn " form="tahatorpanjah-form" page="${i}">${i}
                        </a>`;
                        }


                    }

                    $("#pagination-container").html(btns);
                    $(".page-btn").off("click");
                    $(".page-btn").on("click", function (e) {
                        $('.active').removeClass("active");
                        $(this).addClass("active");
                        e.preventDefault();
                        // $("#providerImage").empty();
                        let url3 = "{{asset('getProductsbyprovider/')}}/" + id;
                        $.get(url3, function (data) {


                            if (data === 'notFound') {
                                toastr.error('خدمات دهنده يافت نشد');
                                $('#city-select option').remove();
                                $('#city-select').append('<option value="" selected>انتخاب کنید</option>');
                                $('#tahator50-table option').remove();
                                $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                                $('#tahatoor50-table tr').remove();
                                $('#tahatoor50-table').append(`<tr>
                        <td>انتخاب</td>
                        <th>نام محصول</th>
                        </tr>`);


                                return false;
                            }

                            let providers = '<tr style="background-color: #e9ecef">\n <td>انتخاب</td><th>نام محصول</th>\n</tr>';
                            let providerImages = [];
                            data.forEach(function (value, index) {
                                if (value.photo.length) {
                                    providerImages.push({
                                        photos: value.photo,
                                        productId: value.id
                                    });


                                }

                                providers += `
<tr>
<td><input type="checkbox" class="tahator-50-checkbox" data-id="${value.user.id}" value="${value.id}" name='check4'></td>
<td class="tahator50-product-title" user-id="${value.user.business_title}">${value.product.title}</td>
<td style="display: none" class="tahator50-product-image">${index}</td></tr>`;
                            })

                            $('#tahatoor50-table tr').remove();
                            $('#tahatoor50-table').html(tagProvider);
                            $('#tahatoor50-table').append(`<tr>
                    <td>انتخاب</td>
                    <th>نام محصول</th>
                    </tr>`);


                            $('#tahatoor50-table').html(providers);
                            tahatorPanjahSelectedProduct.forEach(function (item){
                                if (item != undefined) {
                                    $('input[value="'+item['productId']+'"]').attr('checked', 'checked');
                                }
                            });
                            let count = 0;
                            tahatorPanjahSelectedProduct
                            $('.tahator-50-checkbox').off('change');
                            $('.tahator-50-checkbox').on('change', function (e) {
                                if ($(this).is(':checked')) {
                                    $(this).removeClass('tahator-50-checkbox');
                                    // $('.tahator-50-checkbox').attr("disabled", "disabled");
                                    $('#btn_tp').css('display', 'block');
                                    $(this).addClass("tahator-50-checkbox");
                                    let UserId = $('#tahator50-table').val();
                                    let productId = $(this).val();
                                    let productName = $(this).parent().siblings('td.tahator50-product-title').html();
                                    let userName = $(this).parent().siblings('td.tahator50-product-title').attr('user-id');
                                    let index = $(this).parent().siblings('td.tahator50-product-image').html();

                                    if (tahatorPanjahSelectedProduct.includes(tahatorPanjahSelectedProduct[0]) == false) {
                                        tahatorPanjahSelectedProduct.push({
                                            productId: productId,
                                            imageId: "",
                                            productName: productName,
                                            userName:userName
                                        });
                                    } else {
                                        for (var i = 0; i < tahatorPanjahSelectedProduct.length; i++) {


                                            if (tahatorPanjahSelectedProduct[i]['productId'] == productId) {

                                                break
                                            } else {

                                                tahatorPanjahSelectedProduct.push({
                                                    productId: productId,
                                                    imageId: "",
                                                    productName: productName,
                                                    userName:userName
                                                });

                                                break
                                            }
                                        }
                                    }
                                    tahatorPanjahSelectUser.push(UserId);
                                    let numberIndex='';
                                    let images = '';
                                    let imagess = '';
                                    imagess += `<label for="file" class="btn btn-primary btn-file " style="margin-left: 30%">آپلود عکس</label>
<input type="file"  name="file[]" form="tahatorpanjah-form" id="file" style="display:none" multiple />`;                                    $('.uploaded').html(imagess);
                                    numberIndex = Number(index) + tahatorPanjahSelectedProduct.length;
                                    $('#file').off('change');
                                    $('#file').on('change', function (e) {
                                        let files = e.target.files; // FileList object

                                        // use the 1st file from the list
                                        let f = files[0];
                                        let reader = new FileReader();



                                        // Closure to capture the file information.
                                        reader.onload = (function (theFile) {
                                            var imgSrc = theFile.target.result;
                                            $('#providerImage').children('div:first').children('div.row').prepend(' <div class="col-xl-3 col-md-4 col-sm-6 panjahsad"><div class="d-flex justify-content-center align-items-center flex-column "><img class="img w-100" style="height: 196.469px" src="' + imgSrc + '"><input type="radio" name="image-'+productId+'" class="image-checkbox undone"><input type="button" class="delete-50 btn-danger" value="حذف"> </div></div>');
                                        });
                                        // Read in the image file as a data URL.
                                        reader.readAsDataURL(this.files[0]);
                                        //upload
                                        let puid2= $('#providerImage').children('div:first').attr('data-id');
                                        var postData = new FormData();
                                        postData.append('file', this.files[0]);
                                        postData.append('productId', puid2);
                                        postData.append('userId', UserId);
                                        var url = "{{asset('admin/phototahator')}}";
                                        $.ajax({
                                            headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                                            async: true,
                                            type: "post",
                                            contentType: false,
                                            url: url,
                                            data: postData,
                                            processData: false,
                                            success: function (data) {
                                                let puid= $('#providerImage').children('div:first').attr('data-id');
                                                $('.img:first').siblings('.delete-50').attr('data-id', data.id);
                                                $('.img:first').siblings('.undone').attr('value', data.id);
                                                $('.img:first').siblings('.undone').attr('productId', puid);
                                                $(".image-checkbox").on("click", function () {
                                                    if ($(`input[name=image-${puid2}]`).is(":checked")) {
                                                        $('select').prop("disabled", false);
                                                        $('.tahator-50-checkbox').prop("disabled", false);
                                                        $('button[type=submit]').prop("disabled", false);
                                                        $('.page-btn').removeClass("disable");
                                                    };
                                                    if ($(this).is(':checked')) {
                                                        $('select').prop("disabled", false);
                                                        $('.tahator-50-checkbox').prop("disabled", false);
                                                        $('button[type=submit]').prop("disabled", false);
                                                        let productId = $(this).attr("productId");
                                                        let image = $(this).val();
                                                        for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                                            if (tahatorPanjahSelectedProduct[i].productId === productId) {
                                                                tahatorPanjahSelectedProduct.splice(i, 1, {
                                                                    ...tahatorPanjahSelectedProduct[i],
                                                                    imageId: image
                                                                })
                                                                break;
                                                            }
                                                        }
                                                    }




                                                })
                                                $('#tahatorpanjah-form').on('submit', function (e) {
                                                    $('.selected-product-input').val(JSON.stringify(tahatorPanjahSelectedProduct));
                                                    $('.selected-user-input').val(tahatorPanjahSelectUser);
                                                    $('.selected-user-input1').val($('input[name="image"]:checked').val());
                                                });

                                                $('.delete-50').click(function () {
                                                    let id = $(this).attr('data-id');

                                                    let hazf = $(this).parents('.panjahsad');
                                                    let urldelete = "{{asset('admin/delete50')}}" + '/' + id;

                                                    $.ajax({
                                                        headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                                                        type: 'delete',
                                                        url: urldelete,
                                                        success: function () {
                                                            hazf.remove();
                                                        }
                                                    })

                                                })

                                            }
                                        });


                                    })

                                    if(providerImages[index]!=undefined){
                                        for (let i = 0; i < providerImages[index].photos.length; i++) {
                                            if (providerImages[index].photos[i].upload) {
                                                images += `<div class="col-xl-3 col-md-4 col-sm-6"><div class="d-flex justify-content-center align-items-center flex-column "><img class="img w-100" style="height: 196.469px" src="{{asset('/')}}/${providerImages[index].photos[i].path}" alt=""/><input type="radio' name="image-${productId}" value="${providerImages[index].photos[i].id}" productId="${providerImages[index].productId}" class="image-checkbox undone" /></div></div>`;
                                            }
                                            else
                                                images += `<div class="col-xl-3 col-md-4 col-sm-6"><div class="d-flex justify-content-center align-items-center flex-column "><img class="img w-100" style="height: 196.469px" src="{{asset('/')}}/${providerImages[index].photos[i].path}" alt=""/><input type="radio" name="image-${productId}" value="${providerImages[index].photos[i].id}" productId="${providerImages[index].productId}" class="image-checkbox undone" /></div></div>`;


                                        }
                                    }
                                    // if (!$(`input[name=image-${numberIndex}]`).is(":checked")){
                                    //
                                    // }

                                    let items = '';
                                    for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                        items += '<div class="col-md-3" data-productid=' + tahatorPanjahSelectedProduct[i].productId + '>'+ tahatorPanjahSelectedProduct[i].userName +': ' + tahatorPanjahSelectedProduct[i].productName + ' '+ '</div>';                                    }
                                    $('.selected-product-box').html(items);
                                    tahatorPanjahSelectedProduct.forEach(function (item){
                                        if (item != undefined) {
                                            $('input[value="'+item['imageId']+'"]').attr('checked', 'checked');
                                        }
                                    });
                                    // $("#providerImage").empty();
                                    $("#providerImage").prepend('<div class="container-fluid" data-id="'+productId+'"><h5>'+userName+':'+productName+'</h5> <div class="row"> '+images+'</div> </div>');

                                    $('select').attr('disabled',"disabled");
                                    $('.tahator-50-checkbox').not(':checked').attr('disabled',"disabled");
                                    $('button[type=submit]').attr('disabled',"disabled");
                                    $('.page-btn').prop("disabled", true);
                                    $('.page-btn').addClass("disable");
                                    $(".image-checkbox").off("click");
                                    $(".image-checkbox").off("change");
                                    $(".image-checkbox").on("change", function (e) {
                                        let productId = $(this).attr("productId");
                                        if ($(`input[name=image-${productId}]`).is(":checked")){
                                            $('select').prop("disabled",false);
                                            $('.tahator-50-checkbox').prop("disabled",false);
                                            $('button[type=submit]').prop("disabled",false);
                                            $('.page-btn').removeClass("disable");
                                        }
                                        if ($(this).is(':checked')) {
                                            console.log(productId);
                                            let image = $(this).val();
                                            for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                                if (tahatorPanjahSelectedProduct[i].productId === productId) {
                                                    tahatorPanjahSelectedProduct.splice(i, 1, {
                                                        ...tahatorPanjahSelectedProduct[i],
                                                        imageId: image
                                                    })
                                                    break;
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $('select').prop("disabled", false);
                                    $('.tahator-50-checkbox').prop("disabled", false);
                                    $('button[type=submit]').prop("disabled", false);
                                    $('.page-btn').removeClass("disable");
                                    let notcheck = $(this).val();
                                    $("#providerImage").children(`.container-fluid[data-id=${notcheck}]`).remove();
                                    $('.tahator-50-checkbox').removeAttr("disabled");
                                    for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                        if (tahatorPanjahSelectedProduct[i].productId === $(this).val()) {
                                            tahatorPanjahSelectedProduct.splice(i, 1);
                                            break;
                                        }
                                    }

                                    let items = '';
                                    for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                        items += '<div class="col-md-3" data-productid=' + tahatorPanjahSelectedProduct[i].productId + '>' + tahatorPanjahSelectedProduct[i].productName + ' ' + tahatorPanjahSelectedProduct[i].userName + '</div>';
                                    }
                                    $('.selected-product-box').html(items);
                                    tahatorPanjahSelectedProduct.forEach(function (item){
                                        if (item != undefined) {
                                            $('input[value="'+item['imageId']+'"]').attr('checked', 'checked');
                                        }
                                    });
                                }
                                ;

                                $(".image-checkbox").on("click", function () {
                                    if ($(this).is(":checked")) {
                                        $(this).removeClass("undone").addClass("done")
                                        count++;
                                    } else {
                                        $(this).removeClass("done").addClass("undone")
                                        count--
                                    }
                                    if (count == "1") {
                                        $(".image-checkbox").each(function () {
                                            if ($(".image-checkbox").hasClass("undone")) {
                                            }
                                        });
                                    } else {


                                    }
                                })

                            });
                            $('#tahatorpanjah-form').on('submit', function (e) {
                                $('.selected-product-input').val(JSON.stringify(tahatorPanjahSelectedProduct));
                                $('.selected-user-input').val(tahatorPanjahSelectUser);
                                $('.selected-user-input1').val($('input[name="image"]:checked').val());
                            });
                        })
                            .fail(function (d) {
                                toastr.error('بروز خطا');
                                return false;
                            })
                    });
                });
                let url =  "{{asset('getProductsbyprovider/')}}/" + id;;
                $.get(url, function (data) {


                    if (data === 'notFound') {
                        toastr.error('خدمات دهنده يافت نشد');
                        $('#city-select option').remove();
                        $('#city-select').append('<option value="" selected>انتخاب کنید</option>');
                        $('#tahator50-table option').remove();
                        $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                        $('#tahatoor50-table tr').remove();
                        $('#tahatoor50-table').append(`<tr>
                        <td>انتخاب</td>
                        <th>نام محصول</th>
                        </tr>`);



                        return false;
                    }

                    let providers = '<tr style="background-color: #e9ecef">\n <td>انتخاب</td><th>نام محصول</th>\n</tr>';
                    let providerImages = [];
                    data.forEach(function (value, index) {
                        if (value.photo.length) {
                            providerImages.push({
                                photos: value.photo,
                                productId: value.id
                            });


                        }



                        providers += `
<tr>
<td><input type="checkbox" class="tahator-50-checkbox" data-id="${value.user.id}" value="${value.id}" name='check4'></td>
<td class="tahator50-product-title" user-id="${value.user.business_title}">${value.product.title}</td>
<td style="display: none" class="tahator50-product-image">${index}</td></tr>`;
                    })


                    $('#tahatoor50-table tr').remove();
                    $('#tahatoor50-table').html(tagProvider);
                    $('#tahatoor50-table').append(`<tr>
                    <td>انتخاب</td>
                    <th>نام محصول</th>
                    </tr>`);
                    // $('#providerImage').empty();

                    $('#tahatoor50-table').html(providers);
                    tahatorPanjahSelectedProduct.forEach(function (item){
                        if (item != undefined) {
                            $('input[value="'+item['productId']+'"]').attr('checked', 'checked');
                        }
                    });
                    let count = 0;

                    $('.tahator-50-checkbox').off('change');
                    $('.tahator-50-checkbox').on('change', function (e) {
                        if ($(this).is(':checked')) {

                            $(this).removeClass('tahator-50-checkbox');
                            $('#btn_tp').css('display', 'block');
                            $(this).addClass("tahator-50-checkbox");
                            let UserId = $('#tahator50-table').val();
                            let productId = $(this).val();
                            let productName = $(this).parent().siblings('td.tahator50-product-title').html();
                            let userName = $(this).parent().siblings('td.tahator50-product-title').attr('user-id');
                            let index = $(this).parent().siblings('td.tahator50-product-image').html();

                            if (tahatorPanjahSelectedProduct.includes(tahatorPanjahSelectedProduct[0]) == false) {
                                tahatorPanjahSelectedProduct.push({
                                    productId: productId,
                                    imageId: "",
                                    productName: productName,
                                    userName:userName
                                });
                            } else {
                                for (var i = 0; i < tahatorPanjahSelectedProduct.length; i++) {


                                    if (tahatorPanjahSelectedProduct[i]['productId'] == productId) {

                                        break
                                    } else {

                                        tahatorPanjahSelectedProduct.push({
                                            productId: productId,
                                            imageId: "",
                                            productName: productName,
                                            userName:userName
                                        });

                                        break
                                    }
                                }
                            }

                            console.log(tahatorPanjahSelectedProduct)
                            tahatorPanjahSelectUser.push(UserId);

                            let images = '';
                            let imagess = '';
                            imagess += `<label for="file" class="btn btn-primary btn-file " style="margin-left: 30%">آپلود عکس</label>
<input type="file"  name="file[]" form="tahatorpanjah-form" id="file" style="display:none" multiple />`;
                            $('.uploaded').html(imagess);
                            var imgData = document.getElementById('file');
                            $('#file').off('change');
                            let dataPanjah = [];

                            $('#file').on('change', function (e) {
                                let files = e.target.files; // FileList object

                                // use the 1st file from the list
                                let f = files[0];
                                let reader = new FileReader();
                                // Closure to capture the file information.
                                reader.onload = (function (theFile) {
                                    var imgSrc = theFile.target.result;

                                    $('#providerImage').children('div:first').children('div.row').prepend(' <div class="col-xl-3 col-md-4 col-sm-6 panjahsad"><div class="d-flex justify-content-center align-items-center flex-column "><img class="img w-100" style="height: 196.469px" src="' + imgSrc + '"><input type="radio" name="image-'+productId+'" class="image-checkbox undone"><input type="button" class="delete-50 btn-danger" value="حذف"> </div></div>');
                                });
                                // Read in the image file as a data URL.
                                reader.readAsDataURL(this.files[0]);
                                //upload
                                let puid2= $('#providerImage').children('div:first').attr('data-id');
                                var postData = new FormData();
                                postData.append('file', this.files[0]);
                                postData.append('productId', puid2);
                                postData.append('userId', UserId);

                                var url = "{{asset('admin/phototahator')}}";
                                $.ajax({
                                    headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                                    async: true,
                                    type: "post",
                                    contentType: false,
                                    url: url,
                                    data: postData,
                                    processData: false,
                                    success: function (data) {
                                        let puid= $('#providerImage').children('div:first').attr('data-id');
                                        $('.img:first').siblings('.delete-50').attr('data-id', data.id);
                                        $('.img:first').siblings('.undone').attr('value', data.id);
                                        $('.img:first').siblings('.undone').attr('productId', puid);
                                        $(".image-checkbox").on("click", function () {
                                            if ($(this).is(':checked')) {
                                                if ($(`input[name=image-${puid2}]`).is(":checked")) {
                                                    $('select').prop("disabled", false);
                                                    $('.tahator-50-checkbox').prop("disabled", false);
                                                    $('button[type=submit]').prop("disabled", false);
                                                    $('.page-btn').removeClass("disable");
                                                };
                                                let productId = $(this).attr("productId");
                                                let image = $(this).val();
                                                for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                                    if (tahatorPanjahSelectedProduct[i].productId === productId) {
                                                        tahatorPanjahSelectedProduct.splice(i, 1, {
                                                            ...tahatorPanjahSelectedProduct[i],
                                                            imageId: image
                                                        })
                                                        break;
                                                    }
                                                }
                                            }
                                        })
                                        $('#tahatorpanjah-form').on('submit', function (e) {
                                            $('.selected-product-input').val(JSON.stringify(tahatorPanjahSelectedProduct));
                                            $('.selected-user-input').val(tahatorPanjahSelectUser);
                                            $('.selected-user-input1').val($('input[name="image"]:checked').val());
                                        });

                                        $('.delete-50').click(function () {
                                            let id = $(this).attr('data-id');

                                            let hazf = $(this).parents('.panjahsad');
                                            let urldelete = "{{asset('admin/delete50')}}" + '/' + id;

                                            $.ajax({
                                                headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                                                type: 'delete',
                                                url: urldelete,
                                                success: function () {
                                                    hazf.remove();
                                                }
                                            })

                                        })

                                    }
                                });


                            })

                            if(providerImages[index]!=undefined){
                                for (let i = 0; i < providerImages[index].photos.length; i++) {
                                    if (providerImages[index].photos[i].upload) {
                                        images += `<div class="col-xl-3 col-md-4 col-sm-6"><div class="d-flex justify-content-center align-items-center flex-column "><img class="img w-100" style="height: 196.469px" src="{{asset('/')}}/${providerImages[index].photos[i].path}" alt=""/><input type="radio" name="image-${productId}" value="${providerImages[index].photos[i].id}" productId="${providerImages[index].productId}" class="image-checkbox undone" /></div></div>`;
                                    }
                                    else
                                        images += `<div class="col-xl-3 col-md-4 col-sm-6"><div class="d-flex justify-content-center align-items-center flex-column "><img class="img w-100" style="height: 196.469px" src="{{asset('/')}}/${providerImages[index].photos[i].path}" alt=""/><input type="radio" name="image-${productId}" value="${providerImages[index].photos[i].id}" productId="${providerImages[index].productId}" class="image-checkbox undone" /></div></div>`;

                                }
                            }



                            let items = '';
                            for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                items += '<div class="col-md-3" data-productid=' + tahatorPanjahSelectedProduct[i].productId + '>'+ tahatorPanjahSelectedProduct[i].userName +': ' + tahatorPanjahSelectedProduct[i].productName + ' '+ '</div>';
                            }
                            $('.selected-product-box').html(items);
                            tahatorPanjahSelectedProduct.forEach(function (item){
                                if (item != undefined) {
                                    $('input[value="'+item['imageId']+'"]').attr('checked', 'checked');
                                }
                            });
                            $("#providerImage").prepend('<div class="container-fluid" data-id="'+productId+'"><h5>'+userName+':'+productName+'</h5> <div class="row"> '+images+'</div> </div>');


                            $('select').attr('disabled',"disabled");
                            $('.tahator-50-checkbox').not(':checked').attr('disabled',"disabled");
                            $('button[type=submit]').attr('disabled',"disabled");
                            $('.page-btn').addClass("disable");
                            $(this).prop("disabled",false);
                            $(".image-checkbox").off("click");
                            $(".image-checkbox").off("change");
                            $(".image-checkbox").on("change", function (e) {
                                let productId = $(this).attr("productId");
                                if ($(`input[name=image-${productId}]`).is(":checked")){
                                    $('select').prop("disabled",false);
                                    $('.tahator-50-checkbox').prop("disabled",false);
                                    $('button[type=submit]').prop("disabled",false);
                                    $('.page-btn').removeClass("disable");
                                }
                                if ($(this).is(':checked')) {
                                    console.log(productId);
                                    let image = $(this).val();
                                    for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                        if (tahatorPanjahSelectedProduct[i].productId === productId) {
                                            tahatorPanjahSelectedProduct.splice(i, 1, {
                                                ...tahatorPanjahSelectedProduct[i],
                                                imageId: image
                                            })
                                            break;
                                        }
                                    }

                                }

                            });
                        } else {
                            $('select').prop("disabled", false);
                            $('.tahator-50-checkbox').prop("disabled", false);
                            $('button[type=submit]').prop("disabled", false);
                            $('.page-btn').removeClass("disable");
                            $('select').prop("disabled",false);
                            $('.tahator-50-checkbox').prop("disabled",false);
                            $('button[type=submit]').prop("disabled",false);
                            let notcheck = $(this).val();
                            $("#providerImage").children(`.container-fluid[data-id=${notcheck}]`).remove();
                            for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                if (tahatorPanjahSelectedProduct[i].productId === $(this).val()) {
                                    tahatorPanjahSelectedProduct.splice(i, 1);
                                    break;
                                }
                            }

                            let items = '';
                            for (let i = 0; i < tahatorPanjahSelectedProduct.length; i++) {
                                items += '<div class="col-md-3" data-productid=' + tahatorPanjahSelectedProduct[i].productId + '>'+ tahatorPanjahSelectedProduct[i].userName +': ' + tahatorPanjahSelectedProduct[i].productName + ' '+ '</div>';
                            }
                            $('.selected-product-box').html(items);
                            tahatorPanjahSelectedProduct.forEach(function (item){
                                if (item != undefined) {
                                    $('input[value="'+item['imageId']+'"]').attr('checked', 'checked');
                                }
                            });
                        }
                        ;


                    });
                    $('#tahatorpanjah-form').on('submit', function (e) {
                        $('.selected-product-input').val(JSON.stringify(tahatorPanjahSelectedProduct));
                        $('.selected-user-input').val(tahatorPanjahSelectUser);
                        $('.selected-user-input1').val($('input[name="image"]:checked').val());
                    });
                })
                    .fail(function (d) {
                        toastr.error('بروز خطا');
                        return false;
                    })


            });


            $("#city-select").on("change", function (e) {
                e.preventDefault();
                let id = $(this).val();
                let catId = $('#inputGroupSelect08').val();
                let url = "{{asset('getproviderbycity')}}/" + id + '/' + catId;
                $.get(url, function (data) {
                    if (data === 'notFound') {
                        toastr.error('خدمات دهنده يافت نشد');
                        $('#tahator50-table option').remove();
                        $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                        $('#tahatoor50-table tr').remove();
                        $('#tahatoor50-table').append(`<tr>
                        <td>انتخاب</td>
                        <th>نام محصول</th>
                        </tr>`);
                        // $('#providerImage').empty();
                        return false;
                    }
                    let providers = '<option>انتخاب کنید</option>';
                    let products = '';
                    data.forEach(function (value, index) {
                        providers += '<option value="' + value.uId + '">' + value.business_title + '</option>'
                    })

                    $('#tahator50-table option').remove();
                    $('#tahator50-table').append('<option value="" selected>انتخاب کنید</option>');
                    $('#tahatoor50-table tr').remove();
                    $('#tahatoor50-table').append(`<tr>
                    <td>انتخاب</td>
                    <th>نام محصول</th>
                    </tr>`);
                    // $('#providerImage').empty();
                    $('#tahator50-table').html(providers);


                })
                    .fail(function (d) {
                        toastr.error('بروز خطا');
                        return false;
                    })


            });

        })

    </script>
@section("content")


    <div class="container-fluid">
        <div class="card-header mb-4 text-dark" style="margin-top: 100px">

            <a class="btn btn-list  mb-4 bck"
               href="{{route('porforoosh.index')}}" target="_blank" style="float: left">جدول پرفروش ترین ها
            </a>
            <h5 class="card-title" id="staticBackdropLabel">انتخاب پرفروش ترین ها</h5>
        </div>

        <table class="align-right table table-hover table-dark table-striped" id="tahator50">
            <form action="{{route('addporforoosh')}}" id="tahatorpanjah-form" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product[]" class="selected-product-input">
                <input type="hidden" name="userId[]" class="selected-user-input">
                <input type="hidden" name="image1" class="selected-user-input1">
                <div class="card-body">


                    <div class="row">
                        <div class="col-sm-12 mb-8">
                            <div class="row">
                                <div class="col-lg-4 col-mb-10 pr-md-0">
                                    <div class="v1"></div>
                                    <div class="input-group col-11 mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect07">دسته بندي</label>
                                        </div>
                                        <select class="custom-select select2" id="inputGroupSelect07">
                                            <option selected>انتخاب ...</option>
                                            @foreach($categories as $cat)
                                                <option
                                                    value="{{$cat->id}}" }}>{{$cat->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group col-11 mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect08">زير دسته</label>
                                        </div>
                                        <select class="custom-select select2" id="inputGroupSelect08">
                                            <option selected>انتخاب کنيد ...</option>

                                        </select>
                                    </div>
                                    <div class="input-group col-11 mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="city-select">انتخاب شهر</label>
                                        </div>
                                        <select class="custom-select select2" id="city-select">
                                            <option selected>انتخاب کنيد ...</option>

                                        </select>
                                    </div>
                                    <div class="input-group col-11 mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="tahator50-table">تامين کننده</label>
                                        </div>
                                        <select class="custom-select select2" id="tahator50-table">
                                            <option selected>انتخاب کنيد ...</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-lg-8 col-md-12 ">
                                    <h6>تصاویر محصولات </h6>
                                    <div class="alert alert-primary selected-product-alert col-11 mb-3 " role="alert">
                                        <div class="row" id="providerImage">

                                        </div>

                                    </div>


                                    <h6>محصولات انتخاب شده</h6>
                                    <div class="alert alert-primary selected-product-alert col-11 mb-3" role="alert">
                                        <div class="row selected-product-box">
                                        </div>
                                    </div>
                                    <div class="row no-gutters justify-content-end">

                                        <div class=" text-left ml-2 footer-form">
                                            <button id="btn_tp" type="submit" class="btn btn-success "
                                                    form="tahatorpanjah-form" style="display: none">ثبت
                                            </button>
                                        </div>

                                        <div class="uploaded text-right col-2 ">

                                        </div>

                                    </div>
                                    <table class="table table-hover table-striped col-lg-3 mb-3 mr-3 list1"
                                           id="tahatoor50-table">
                                        <thead>
                                        <tr>
                                            <td>انتخاب</td>
                                            <th>نام محصول</th>
                                        </tr>

                                        </thead>
                                    </table>
                                    <div class="just">
                                        <div id="pagination-container" class="pagination col-lg-3 mb-3 mr-3">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <tbody class="tahatorpanjahbody"
                           id="product-table">
                    </tbody>


                </div>
                <div class="card-footer">


                </div>


            </form>
            @csrf
        </table>
    </div>


@endsection
@endsection
