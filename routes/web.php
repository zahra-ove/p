<?php

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\Store\HomeController::class,'index'])->name('home');
Route::get('getprobycat/{id}/{city}',[\App\Http\Controllers\Store\ProductController::class,'showProvidersByCategory'])->name('showproviders');
Route::get('testshode',function (){
    $parsian=new \App\Http\Controllers\Larabookir\Gateway\Parsian\Parsian();
    dd($parsian->set(100000));
})->name('getIPGs');


Route::get('getproductbycity/{id}/{catid}',[\App\Http\Controllers\Store\ProductController::class,'showProductByCityBoom'])->name('getproductbycity');
Route::get('paginprovider',[\App\Http\Controllers\Store\ProductController::class,'paginProvider'])->name('paginprovider');
Route::get('about',[\App\Http\Controllers\Store\ProductController::class,'about'])->name('about');
Route::get('contanct',[\App\Http\Controllers\Store\ProductController::class,'contact'])->name('contact');
Route::get('providerproducts/{id}',[\App\Http\Controllers\Store\ProductController::class,'getProviderProducts'])->name('providerproducts');
Route::get('providerproductspagin',[\App\Http\Controllers\Store\ProductController::class,'getProviderProductsPagin'])->name('providerproductspagin');
Route::get('singleproduct/{id}',[\App\Http\Controllers\Store\ProductController::class,'singleProduct'])->name('singleproduct');
Route::get('infoproduct/{id}',[\App\Http\Controllers\Store\ProductController::class,'productInfo'])->name('infoproduct');
Route::get('edituser/{id}',[\App\Http\Controllers\Store\RegisterController::class,'edit'])->name('edituser');
Route::get('favorite/{id}',[\App\Http\Controllers\Store\ProductController::class,'getFavoriteByUser'])->name('getfav');
Route::get('favoritePagin/{id}',[\App\Http\Controllers\Store\ProductController::class,'getFavoriteByUserPagin'])->name('getfavpagin');
Route::post('editaccount/{id}',[\App\Http\Controllers\Store\HomeController::class,'editAccount'])->name('editaccount');
Route::post('reservboomgardi',[\App\Http\Controllers\Store\BuyController::class,'reservBoomgardi'])->name('reservboomgardi');
Route::get('setpassengers/{id}',[\App\Http\Controllers\Store\BuyController::class,'setPassengers'])->name('setpassengers');
Route::post('editpassenger',[\App\Http\Controllers\Store\BuyController::class,'editPassenger'])->name('editpassenger');
Route::get('basket',[\App\Http\Controllers\Store\BuyController::class,'basket'])->name('basket');
Route::get('basketpage',[\App\Http\Controllers\Store\BuyController::class,'basketPage'])->name('basketpage');

Route::post('deletebasket',[\App\Http\Controllers\Store\BuyController::class,'deleteFromBasket'])->name('deletebasket');
Route::get('detailroom/{id}',[\App\Http\Controllers\Store\ProductController::class,'detailRoom'])->name('detailroom');
Route::get('detailtakht/{id}',[\App\Http\Controllers\Store\ProductController::class,'detailTakht'])->name('detailtakht');
Route::get('roomlist/{id}',[\App\Http\Controllers\Store\ProductController::class,'roomList'])->name('roomlist');
Route::get('getroomfloor/{id}',[\App\Http\Controllers\Store\ProductController::class,'getRoomByPansionByFloor'])->name('getroomfloor');
Route::get('gettakhtbyprice/{floor}',[\App\Http\Controllers\Store\ProductController::class,'getTakhtByRoomOrderPrice'])->name('gettakhtbyprice');
Route::get('gettakhtbypricelimitoffset/{floor}/{raft}/{bargasht}/{limit}/{offset}',[\App\Http\Controllers\Store\ProductController::class,'getTakhtByRoomOrderPriceLimitOffsset'])->name('gettakhtbypricelimitoffset');

Route::get('sw',function (){
    $cities=\App\Models\City::all();
    return view('store.products.infosingleproduct',compact('cities'));
});



//@todo: pnlu for testing, I've disabled auth middleware. remind me to return it.  ->done
Route::prefix('admin')->middleware(['auth'])->group(function (){
//Route::prefix('admin')->group(function (){

    Route::get('/dashboard',[\App\Http\Controllers\Admin\UserController::class,'showDashboard'])->name('admin');
    Route::resource('city',\App\Http\Controllers\Admin\CityController::class);
//    Route::post('insertostan',[\App\Http\Controllers\Admin\CityController::class,'insertOstan'])->name('ostan.store');   //@todo
    Route::get('getcitybyostan/{id}',[\App\Http\Controllers\Admin\CityController::class,'getCityByOstan'])->name('getcitybyostan');
    Route::resource('ostan',\App\Http\Controllers\Admin\OstanController::class);
//    Route::resource('user',\App\Http\Controllers\Admin\OstanController::class);
    Route::get('porforoosh/create',[\App\Http\Controllers\Admin\FirstpageController::class,'porforooshCreate'])->name('porforoosh.create');
    Route::get('economic/create',[\App\Http\Controllers\Admin\FirstpageController::class,'economicCreate'])->name('economic.create');
    Route::get('season/create',[\App\Http\Controllers\Admin\FirstpageController::class,'seasonCreate'])->name('season.create');
    Route::get('aboutcity/create',[\App\Http\Controllers\Admin\FirstpageController::class,'aboutcityCreate'])->name('aboutcity.create');
    Route::resource('group',\App\Http\Controllers\Admin\GroupController::class);
    Route::resource('permission',\App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('personal',\App\Http\Controllers\Admin\UserController::class);
    Route::get('setpermissiongroup/{id}',[\App\Http\Controllers\Admin\GroupController::class,'setPermission'])->name('setpermissiongroup');
    Route::post('setpermissionsgroup',[\App\Http\Controllers\Admin\GroupController::class,'setPermissions'])->name('setpermissionsgroup');
    Route::post('dettachpermission',[\App\Http\Controllers\Admin\GroupController::class,'dettachPermissioonGroup'])->name('dettachpermission');
    Route::get('setgroup/{id}',[\App\Http\Controllers\Admin\UserController::class,'setGroup'])->name('setgroup');
    Route::get('setpermission/{id}',[\App\Http\Controllers\Admin\UserController::class,'setPermission'])->name('setPermission');
    Route::post('setgroups',[\App\Http\Controllers\Admin\UserController::class,'setGroups'])->name('setgroups');
    Route::post('setpermissions',[\App\Http\Controllers\Admin\UserController::class,'setPermissions'])->name('setPermissions');
    Route::post('dettachgroup',[\App\Http\Controllers\Admin\UserController::class,'dettachGroupUser'])->name('dettachgroup');
    Route::post('dettachpermissionuser',[\App\Http\Controllers\Admin\UserController::class,'dettachPermissionUser'])->name('dettachpermissionuser');
    Route::post('addporforoosh',[\App\Http\Controllers\Admin\FirstpageController::class,'addPorforoosh'])->name('addporforoosh');
    Route::post('addeconomic',[\App\Http\Controllers\Admin\FirstpageController::class,'addEconomic'])->name('addeconomic');
    Route::post('addseason',[\App\Http\Controllers\Admin\FirstpageController::class,'addSeason'])->name('addseason');
    Route::post('addaboutcity',[\App\Http\Controllers\Admin\FirstpageController::class,'addAboutcity'])->name('addaboutcity');
    Route::delete('deleteabout/{id}',[\App\Http\Controllers\Admin\FirstpageController::class,'deleteAboutcity'])->name('deleteabout');




    Route::get('allcustomers',[\App\Http\Controllers\Admin\UserController::class,'getAllCustoms'])->name('allcustomers');
    Route::get('getallcustomerssss',[\App\Http\Controllers\Admin\UserController::class,'getAllCustomers'])->name('allcustomersssss');


    Route::get('payqest/{id}',[\App\Http\Controllers\Admin\UserController::class,'payQest'])->name('payqestuser');
    Route::get('allcustomerslimitoffset/{limit}/{offset}',[\App\Http\Controllers\Admin\UserController::class,'getAllCustomsLimitOffset'])->name('allcustomerslimitoffset');
    Route::get('getallcustomsbyncodelimitoffset/{column}/{data}/{limit}/{offset}',[\App\Http\Controllers\Admin\UserController::class,'getAllCustomsByNcodeLimitOffset'])->name('getAllCustomsByNcodeLimitOffset');
    Route::get('allcustomersgone',[\App\Http\Controllers\Admin\UserController::class,'getAllCustomsGone'])->name('allcustomersgone');
    Route::get('getcustomsbyncode/{column}/{data}',[\App\Http\Controllers\Admin\UserController::class,'getCustomsByNcode'])->name('getcustomsbyncode');
    Route::get('getcustomsbytakht/{takhId}',[\App\Http\Controllers\Admin\UserController::class,'getUserByTakht'])->name('getcustomsbytakht');
    Route::get('getcustomsbytakhtlimitoffset/{takhId}/{limit}/{offset}',[\App\Http\Controllers\Admin\UserController::class,'getUserByTakhtLimitOffset'])->name('getcustomsbytakhtlimitoffset');
    Route::post('setfav',[\App\Http\Controllers\Store\ProductController::class,'setFavarites'])->name('setfav');
    Route::get('searchphoto/create',[\App\Http\Controllers\Admin\FirstpageController::class,'SearchPhotoPage'])->name('searchget');
    Route::post('editsearchphoto',[\App\Http\Controllers\Admin\FirstpageController::class,'editSearchPhoto'])->name('editsearchget');
    Route::post('deletesearchphoto',[\App\Http\Controllers\Admin\FirstpageController::class,'deleteSearchPhoto'])->name('deletesearchphoto');
    Route::get('economic',[\App\Http\Controllers\Admin\FirstpageController::class,'getAllEconomic'])->name('economic.index');
    Route::get('porforoosh',[\App\Http\Controllers\Admin\FirstpageController::class,'getAllPorforoosh'])->name('porforoosh.index');
    Route::delete('deleteporforoosh/{id}',[\App\Http\Controllers\Admin\FirstpageController::class,'deletePor'])->name('deleteporforoosh');
    Route::post('editporforoosh/{id}',[\App\Http\Controllers\Admin\FirstpageController::class,'editPorforoosh'])->name('editporforoosh');
    Route::get('season',[\App\Http\Controllers\Admin\FirstpageController::class,'getAllSeason'])->name('season.index');
    Route::delete('deleteseason/{id}',[\App\Http\Controllers\Admin\FirstpageController::class,'deleteSeason'])->name('deleteseason');
    Route::post('editseason/{id}',[\App\Http\Controllers\Admin\FirstpageController::class,'editSeason'])->name('editseason');
    Route::get('myorders',[\App\Http\Controllers\Store\BuyController::class,'myOrders'])->name('myorders');
    Route::get('doneorders',[\App\Http\Controllers\Store\BuyController::class,'doneOrders'])->name('doneorders');
    Route::get('moalaghorders',[\App\Http\Controllers\Store\BuyController::class,'doneOrders'])->name('moalaghorders');
//    Route::get('cancelorders',[\App\Http\Controllers\Store\BuyController::class,'doneOrders'])->name('cancelorders');
    Route::resource('pansion',\App\Http\Controllers\Admin\PansionController::class);
    Route::get('getpansionajax',[\App\Http\Controllers\Admin\PansionController::class,'getAllPansionWithAjax'])->name('getpansionajax');
    Route::post('deletephoto/{id}',[\App\Http\Controllers\Admin\PansionController::class,'deletePhoto'])->name('deletephoto');
    Route::get('getpansionbyidajax/{id}',[\App\Http\Controllers\Admin\PansionController::class,'getPansionByIdAjax'])->name('getpansionbyidajax');
    Route::resource('takht',\App\Http\Controllers\Admin\TakhtController::class);
    Route::resource('room',\App\Http\Controllers\Admin\RoomController::class);
    Route::post('insertpubemkanat',[\App\Http\Controllers\Admin\RoomController::class,'insertPubemkanat'])->name('insertpubemkanat');
    Route::post('deletepubemkanat',[\App\Http\Controllers\Admin\RoomController::class,'deletePubemkanat'])->name('deletepubemkanat');
    Route::get('getroombypansion/{id}',[\App\Http\Controllers\Admin\RoomController::class,'getRoomByPansion'])->name('getroombypansion');
    Route::get('gettakhtbyroom/{id}',[\App\Http\Controllers\Admin\TakhtController::class,'getTakhtByRoom'])->name('gettakhtbyroom');
    Route::get('roomsofpansion/{id}',[\App\Http\Controllers\Admin\RoomController::class,'roomsOfPansion'])->name('roomsofpansion');
    Route::get('getroombyid/{id}',[\App\Http\Controllers\Admin\RoomController::class,'getRoomById'])->name('getroombyid');
    Route::get('getallrooms',[\App\Http\Controllers\Admin\RoomController::class,'getAllRooms'])->name('getallrooms');
    Route::get('takhtsofroom/{id}',[\App\Http\Controllers\Admin\TakhtController::class,'takhtsOfRoom'])->name('takhtsofroom');
    Route::get('fulltakht',[\App\Http\Controllers\Admin\TakhtController::class,'fullTakht'])->name('fulltakht');
//    Route::get('getemptytakhtpansion/{pansionId}/{raft}/{bargasht}/{reserveType}',[\App\Http\Controllers\Admin\TakhtController::class,'getEmptyTakhtByDateInPansion'])->name('getemptytakhtpansion');
    Route::post('getemptytakhtpansion/{pansionId}/{reserveType}',[\App\Http\Controllers\Admin\TakhtController::class,'getEmptyTakhtByDateInPansion'])->name('getemptytakhtpansion');
    Route::get('getemptytakhtroom/{pansionId}/{raft}/{bargasht}/{reserveType}',[\App\Http\Controllers\Admin\TakhtController::class,'getEmptyTakhtByDateInRoom'])->name('getemptytakhtroom');
    Route::get('getfulltakhtbypansion/{id}',[\App\Http\Controllers\Admin\TakhtController::class,'getFullTakhtsByPansion'])->name('getfulltakhtbypansion');
    Route::resource('order',\App\Http\Controllers\Admin\OrderController::class);
    Route::get('getorderbytakht/{id}',[\App\Http\Controllers\Admin\OrderController::class,'getOrderByTakht'])->name('getorderbytakht');
    Route::get('getorderbyuser/{id}',[\App\Http\Controllers\Admin\OrderController::class,'getOrderByUser'])->name('getorderbyuser');
//    Route::get('cancelreserve',[\App\Http\Controllers\Admin\OrderController::class,'cancelReserve'])->name('cancelreserve');
    Route::get('movereserve',[\App\Http\Controllers\Admin\OrderController::class,'moveReserve'])->name('movereserve');
    Route::get('ekhrajiha',[\App\Http\Controllers\Admin\OrderController::class,'indexekhraj'])->name('ekhrajiha');
    Route::get('khorujiha',[\App\Http\Controllers\Admin\OrderController::class,'indexkhoruj'])->name('khorujiha');
    Route::get('taghirvaziat',[\App\Http\Controllers\Admin\OrderController::class,'taghirVaziat'])->name('taghirvaziat');
    Route::get('testdl/{id}',[\App\Http\Controllers\Admin\OrderController::class,'destroy'])->name('testdl');
    Route::get('naqdtypes',[\App\Http\Controllers\Admin\OrderController::class,'getAllnaqdtypes'])->name('naqdtypes');
    Route::get('reservetypes',[\App\Http\Controllers\Admin\OrderController::class,'getAllreservetypes'])->name('reservetypes');
    Route::post('deletepassday/{id}',[\App\Http\Controllers\Admin\OrderController::class,'deletePassDay'])->name('deletepassday');
    Route::post('ekhraj/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ekhraaj'])->name('ekhraaj');
    Route::post('khoruj/{id}',[\App\Http\Controllers\Admin\OrderController::class,'khorooj'])->name('khorooj');
//    Route::get('pastcancel/{id}',[\App\Http\Controllers\Admin\OrderController::class,'cancelPast'])->name('pastcancel');
//    Route::get('ajaxpast/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ajaxPast'])->name('ajaxpast');     // was used for cancel reserve from admin panel
    Route::get('ajaxkhorooj/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ajaxKhorooj'])->name('ajaxkhorooj');
    Route::get('ajaxekhraaj/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ajaxekhraaj'])->name('ajaxekhraaj');
    Route::get('ajaxmove/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ajaxmove'])->name('ajaxmove');
    Route::get('ajaxvaziat/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ajaxVaziat'])->name('ajaxvaziat');
    Route::get('ekhraaji/{id}',[\App\Http\Controllers\Admin\OrderController::class,'ekhraaji'])->name('ekhraaji');
    Route::get('khorooji/{id}',[\App\Http\Controllers\Admin\OrderController::class,'khrooji'])->name('khorooji');
    Route::get('wheremove/{id}',[\App\Http\Controllers\Admin\OrderController::class,'wheremove'])->name('wheremove');
    Route::post('movetakht/{id}',[\App\Http\Controllers\Admin\OrderController::class,'moveTakht'])->name('movetakht');
    Route::get('vaziat/{id}',[\App\Http\Controllers\Admin\OrderController::class,'vaziat'])->name('vaziat');
    Route::get('reserveuser/{id}',[\App\Http\Controllers\Admin\OrderController::class,'getOrdersByUser'])->name('reserveuser');
    Route::get('recentreserve',[\App\Http\Controllers\Admin\OrderController::class,'getReserveOrderAuth'])->name('recentreserve');
//    Route::get('getactivestatusorderbyuser/{id}',[\App\Http\Controllers\Admin\OrderController::class,'getActiveStatusOrderByUser'])->name('getactivestatusorderbyuser');  // was used for cancel reserve for admin panel
    Route::get('getstatusmalibyorder/{id}',[\App\Http\Controllers\Admin\OrderController::class,'getStatusmaliByOrder'])->name('getstatusmalibyorder');
    Route::get('customreserve/{id}',[\App\Http\Controllers\Admin\OrderController::class,'customReserve'])->name('customreserve');
    Route::post('customstore',[\App\Http\Controllers\Admin\OrderController::class,'customStore'])->name('customstore');
    Route::post('storecustomer',[\App\Http\Controllers\Admin\UserController::class,'storeCustomer'])->name('storecustomer');
    Route::post('storeuser',[\App\Http\Controllers\Admin\UserController::class,'storeUser'])->name('storeuser');
    Route::get('createcustomer',[\App\Http\Controllers\Admin\UserController::class,'createCustomer'])->name('createcustomer');
    Route::get('createnewuser',[\App\Http\Controllers\Admin\UserController::class,'createNewUser'])->name('createnewuser');
    Route::get('indexcustom',[\App\Http\Controllers\Admin\UserController::class,'indexCustoms'])->name('indexcustom');
    Route::get('gettransactionbyuser/{id}',[\App\Http\Controllers\Admin\TransactionController::class,'getTransactionByUser'])->name('gettransactionbyuser');
    Route::get('changepassblade/{id}',[\App\Http\Controllers\Admin\UserController::class,'bladeChangePassword'])->name('changepassblade');
    Route::post('changepass/{id}',[\App\Http\Controllers\Admin\UserController::class,'changePassword'])->name('changePassword');
    Route::post('roompickstore',[\App\Http\Controllers\Admin\FirstpageController::class,'storeRoomPick'])->name('roompickstore');
    Route::post('sliderstore',[\App\Http\Controllers\Admin\FirstpageController::class,'storeSlider'])->name('sliderstore');
    Route::post('aboutstore',[\App\Http\Controllers\Admin\FirstpageController::class,'storeAbout'])->name('aboutstore');
    Route::post('contactstore',[\App\Http\Controllers\Admin\FirstpageController::class,'storeContact'])->name('contactstore');
    Route::get('roompickcreate',[\App\Http\Controllers\Admin\FirstpageController::class,'createRoomPick'])->name('roompickcreate');
    Route::get('slidercreate',[\App\Http\Controllers\Admin\FirstpageController::class,'createSlider'])->name('slidercreate');
    Route::get('aboutcreate',[\App\Http\Controllers\Admin\FirstpageController::class,'createAbout'])->name('aboutcreate');
    Route::get('contactcreate',[\App\Http\Controllers\Admin\FirstpageController::class,'createContact'])->name('contactcreate');
    Route::resource('naqdtype',\App\Http\Controllers\Admin\NaqdtypeController::class);
    Route::get('getuserphotos/{id}',[\App\Http\Controllers\Admin\UserController::class,'usersPhoto'])->name('getuserphotos');
    Route::get('detachphtouser/{id}/{photoId}',[\App\Http\Controllers\Admin\UserController::class,'detachUserPhoto'])->name('detachphtouser');
    Route::get('contract/{id}',[\App\Http\Controllers\Admin\UserController::class,'contarctPersonal'])->name('contract');
    Route::get('getorderbysearchlimitoffset/{column}/{output}/{limit}/{offset}',[\App\Http\Controllers\Admin\OrderController::class,'getOderBySearchLimitOffset'])->name('getorderbysearchlimitoffset');
    Route::get('getorderbysearch/{column}/{output}',[\App\Http\Controllers\Admin\OrderController::class,'getOderBySearch'])->name('getorderbysearch');
    Route::get('getorderlimitoffset/{limit}/{offset}',[\App\Http\Controllers\Admin\OrderController::class,'getAllOrderLimitOffset'])->name('getOrderLimmitOffset');
    Route::get('getallordersbydate',[\App\Http\Controllers\Admin\OrderController::class,'getAllOrdersByDate'])->name('getAllordersByDate');
    Route::get('getallorders',[\App\Http\Controllers\Admin\OrderController::class,'getAllOrders'])->name('getAllorders');
    Route::get('getallordersreturn',[\App\Http\Controllers\Admin\OrderController::class,'getAllOrdersReturn'])->name('getallordersreturn');
    Route::get('getordersnotpay',[\App\Http\Controllers\Admin\OrderController::class,'getOrdersNotPay'])->name('getordersnotpay');
    Route::get('getallordersnotpay',[\App\Http\Controllers\Admin\OrderController::class,'getAllOrdersNotPay'])->name('getAllOrdersNotPay');
    Route::get('tamdiduser/{id}',[\App\Http\Controllers\Admin\OrderController::class,'tamdidOrder'])->name('tamdiduser');
    Route::get('tamdid/{id}',[\App\Http\Controllers\Admin\OrderController::class,'tamdid'])->name('tamdid');   //@todo
//    Route::get('fullfortamdid/{raft}/{bargasht}/{takht_id}',[\App\Http\Controllers\Admin\OrderController::class,'fullForTamdid'])->name('tamdid');   //@todo
    Route::get('paymentorder/{id}/{price}',[\App\Http\Controllers\Admin\OrderController::class,'paymentOrder'])->name('paymentorder');
    Route::get('getallordersbydate/{from}/{to}/{limit}/{offset}',[\App\Http\Controllers\Admin\OrderController::class,'getOrderByDates'])->name('getordersbydate');
    Route::get('getordersnotpaydatelimitoffset/{from}/{to}/{limit}/{offset}',[\App\Http\Controllers\Admin\OrderController::class,'getOrdersNotPayDateLimitOffset'])->name('getordersnotpaydatelimitoffset');
    Route::get('getallordersbydate/{from}/{to}',[\App\Http\Controllers\Admin\OrderController::class,'getAllOrderByDates'])->name('getallordersbydate');
    Route::get('getordersnotpaydate/{from}/{to}',[\App\Http\Controllers\Admin\OrderController::class,'getOrdersNotPayDate'])->name('getordersnotpaydate');
    Route::get('getordersnotpaylimitoffset/{limit}/{offset}',[\App\Http\Controllers\Admin\OrderController::class,'getOrdersNotPayLimitOffset'])->name('getOrdersNotPayLimitOffset');
//    Route::get('getaqsatbyorder/{id}',[\App\Http\Controllers\Admin\OrderController::class,'getAqsatByOrder'])->name('getaqsatnotpay');    //@todo
    Route::patch('payqest/{id}',[\App\Http\Controllers\Admin\OrderController::class,'payQest'])->name('payQest');
//    Route::get('getoreders2date/{id}/{raft}/{bargasht}/{reservetype}/{thisId}',[\App\Http\Controllers\Admin\OrderController::class,'getReserveforTakhtBetween2Dates'])->name('getaqsatnotpay');   //@todo
    Route::post('fivedaysordersetting',[\App\Http\Controllers\Admin\MassageController::class,'fivedaysorderSetting'])->name('fivedaysordersetting');
    Route::post('threedaysqestsetting',[\App\Http\Controllers\Admin\MassageController::class,'threedaysqestSetting'])->name('threedaysqestsetting');
    Route::post('fivedayssoonsetting',[\App\Http\Controllers\Admin\MassageController::class,'fivedayssoonSetting'])->name('fivedayssoonsetting');
    Route::get('massagesetting',[\App\Http\Controllers\Admin\MassageController::class,'massages'])->name('massages');
    Route::post('cash',[\App\Http\Controllers\Admin\WalletController::class,'cash'])->name('cash');
    Route::post('deposite',[\App\Http\Controllers\Admin\WalletController::class,'deposite'])->name('deposite');
    Route::get('wallet',[\App\Http\Controllers\Admin\WalletController::class,'wallet'])->name('wallet');


    //=================== zizi start routes
    Route::get('takhtByPansionReserveType/{pansionId}/{reserveType}/{raft}/{bargasht}',[\App\Http\Controllers\Admin\TakhtController::class,'getEmptyTakhtByPansionRoom'])->name('getEmptyTakhtByPansionRoom');

    //================ cancel reservation by pansion personal
    Route::get('getallactiveorder/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'getAllActiveOrderInfoForSpecificUser']);
    Route::get('getallqestlistfororder/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'getAqsatListForSpecificOrder']);
    Route::get('getalltransactionlistfororder/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'getTransactionListForSpecificOrder']);
    Route::post('cancelorder', [\App\Http\Controllers\Admin\OrderController::class, 'cancelorder']);


    // old routes for canceling a reserve/order
    Route::get('pastcancel/{id}',[\App\Http\Controllers\Admin\OrderController::class,'cancelPast'])->name('pastcancel');     //?
    Route::get('cancelreserve',[\App\Http\Controllers\Admin\OrderController::class,'showCancelReserveForm'])->name('cancelreserve');    // shows canceli view
//    Route::get('cancelorders',[\App\Http\Controllers\Store\BuyController::class,'doneOrders'])->name('cancelorders');

    //================= wallet
    Route::get('getwalletmojoodi/{id}',[\App\Http\Controllers\Admin\WalletController::class,'getWalletMojoodiForSpecifcUser']);    // get wallet mojoodi for a specific user
    Route::get('getwalletmojoodiandordertotalprice/{user_id}/{order_id}',[\App\Http\Controllers\Admin\OrderController::class,'getwalletmojoodiandordertotalprice']);
});


////////cron
//Route::get('orders5daysleft',[\App\Http\Controllers\Admin\OrderController::class,'getOrders5DaysLeft'])->name('orders5daysleft');
//Route::get('orders5dayssoon',[\App\Http\Controllers\Admin\OrderController::class,'getOrders5DaysSoon'])->name('orders5dayssoon');
//Route::get('qests3daysleft',[\App\Http\Controllers\Admin\OrderController::class,'getQest3DaysLeft'])->name('qests3daysleft');
//




//////getcitybyCategory
Route::get('/getcitybycategory/{id}',[\App\Http\Controllers\Admin\CityController::class,'getCityByCategory']);
Route::get('/test',[\App\Http\Controllers\testController::class,"kaveh"]);



//================= Authentication
Route::get('login', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', '\App\Http\Controllers\Auth\LoginController@login')->name('post.login');

Route::get('register', '\App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', '\App\Http\Controllers\Auth\RegisterController@register')->name('post.register');
Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

// Password Confirmation Routes...
Route::get('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@confirm');

// Email Verification Routes...
Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');


//================= get verification code
Route::get('/verify-mobile-form/{id}', 'App\Http\Controllers\Admin\UserController@showVerificationCodeForm');
Route::get('/get-verification-code/{id}', 'App\Http\Controllers\Admin\UserController@generateActivationCodeForSpecificUser');
Route::post('/check-verification-code', 'App\Http\Controllers\Admin\UserController@checkActivationCodeForSpecificUser')->name('check.verifycode');


//================= payment
Route::post('/pay', [App\Http\Controllers\Admin\PaymentController::class, 'pay'])->name('pay');
Route::get('/varify', [App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('pay.verify');


Route::get('getpayform', [App\Http\Controllers\Admin\PaymentController::class, 'getpayform']);


//===========for testing

//=========== tamdid e reserve
Route::get('tamdidreserve', [\App\Http\Controllers\Admin\OrderController::class,'tamdidform'])->name('tamdidform');
Route::post('tamdidreserve', [\App\Http\Controllers\Admin\OrderController::class,'tamdidreserve'])->name('tamdidreserve');



