<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BattleNewsController;
use App\Http\Controllers\CrystalController;
use App\Http\Controllers\DublicatController;
use App\Http\Controllers\ElchilarController;
use App\Http\Controllers\ElchiTaskController;
use App\Http\Controllers\FirewallController;
use App\Http\Controllers\JamoalarController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MijozController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PillController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\LoginAuth;
use App\Http\Middleware\LoginAdmin;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PremyaTaskController;
use App\Http\Controllers\ProvizorController;
use App\Http\Controllers\RekController;
use App\Http\Controllers\RekrutController;
use App\Http\Controllers\ResidualController;
use App\Http\Controllers\ToolzController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TurnirController;
use App\Http\Controllers\MegaTurnirController;
use App\Http\Controllers\VideoController;
use App\Http\Livewire\McShipmentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
// Route::middleware(['web'])->group(function () {




    Route::post('region/elchi', [App\Http\Controllers\NovatioController::class,'region']);
    Route::post('region/chart', [App\Http\Controllers\NovatioController::class,'regionChart']);

    Route::post('grades', [App\Http\Controllers\NovatioController::class,'grades']);
    Route::post('dep/grades', [App\Http\Controllers\NovatioController::class,'depGrades']);

    Route::post('calendar', [App\Http\Controllers\NovatioController::class,'calendar']);
    Route::post('grade/ball', [App\Http\Controllers\NovatioController::class,'grade']);
    Route::post('grade/save', [App\Http\Controllers\NovatioController::class,'gradeSave']);
    Route::post('grade/tashqi', [App\Http\Controllers\NovatioController::class,'gradeTashqi']);
    Route::get('/sms',[App\Http\Controllers\HomeController::class, 'smsfly'])->name('smsfly');
    Route::post('edit/purchase', [App\Http\Controllers\NovatioController::class,'editPurchase']);

    Route::post('/user/cancel', [UserController::class,'userCancel']);
    Route::post('/user-success/{id}', [UserController::class,'userSuccess'])->name('user-success');

    Route::post('/user/shift-open', [ToolzController::class,'adminCheckOpenSmena'])->name("admin-check-open-smena");
    Route::post('/user/shift-close', [ToolzController::class,'adminCheckCloseSmena'])->name("admin-check-close-smena");
    Route::post('/user/king-sold', [ToolzController::class,'kingSoldAnsver'])->name('ks-ansver');



Auth::routes();

Route::get('login', function(){
    return view('auth.login');
})->name('sign-in');
// Route::get('admin', function(){
//     return view('admin.login');
// })->name('admin-login');
Route::post('/home', [LoginController::class, 'login'])->name('login');
// Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');

// Route::middleware([LoginAuth::class])->group(function () {

// });

Route::get('/admin-logout', [AdminController::class, 'logoutAdmin'])->name('admin-logout');
Route::get('/admin-login', [AdminController::class, 'adminLogin'])->name('admin-index');
Route::post('/admin-login', [LoginController::class, 'adminLogin'])->name('admin-login');

Route::middleware([LoginAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');

    Route::get('super-admin-list', [AdminController::class,'adminList'])->name('super-admin-list');
    Route::get('super-admin-list-edit/{id}', [AdminController::class,'adminListEdit'])->name('super-admin-list-edit');
    Route::post('super-admin-list-update/{id}', [AdminController::class,'adminListUpdate'])->name('super-admin-list-update');

    Route::get('super-secret-admin-list', [AdminController::class,'adminListSecret'])->name('super-secret-admin-list');
    Route::get('super-secret-admin-list-edit/{id}', [AdminController::class,'adminListEditSecret'])->name('super-secret-admin-list-edit');
    Route::post('super-secret-admin-list-update/{id}', [AdminController::class,'adminListUpdateSecret'])->name('super-secret-admin-list-update');
});

$user = DB::table('tg_user')->where('admin',false)->pluck('username');

foreach ($user as $u) {
    Route::get($u, [HomeController::class,'nvt']);
}
Route::middleware([LoginAuth::class])->group(function () {

    Route::get('/',[HomeController::class,'index'])->name('blackjack');
    Route::get('/capitan/{month}',[HomeController::class,'capitan'])->name('capitan');
    Route::get('/search',[HomeController::class,'filter']);
    Route::get('elchi/{id}/{time?}', [HomeController::class,'elchi'])->name('elchi');
    Route::post('elchi/premya', [HomeController::class, 'markPremya'])->name('premya.store');
    Route::get('elchi-list', [HomeController::class,'elchiList'])->name('elchi-list');
    Route::get('admin-list', [UserController::class,'adminList'])->name('admin-list');
    Route::get('rm-list', [UserController::class,'rmList'])->name('rm-list');
    Route::get('cap-list', [UserController::class,'capList'])->name('cap-list');
    Route::get('user-list', [UserController::class,'userList'])->name('user-list');


    Route::get('/status', [HomeController::class,'userOnlineStatus']);
    #position
    Route::resource('position', PositionController::class);
    Route::resource('bolim', BolimController::class);
    Route::resource('question', QuestionController::class);
    Route::get('question/{id?}/delete', [App\Http\Controllers\QuestionController::class,'destroy'])->name('question.delete');
    Route::get('position/{id?}/delete', [App\Http\Controllers\PositionController::class,'destroy'])->name('position.delete');
    // Route::get('user-list', [HomeController::class,'userList'])->name('user-list');
    Route::get('pro-list/{time}/{region?}/{pharm?}', [HomeController::class,'proList'])->name('pro-list');
    Route::get('pro-list-search', [HomeController::class,'proList'])->name('pro-list-search');
    Route::post('permission', [HomeController::class,'permission'])->name('permissions');
    Route::get('reg', [HomeController::class,'reg']);
    Route::get('grade', [HomeController::class,'grade'])->name('grade');
    Route::get('setting/{month}', [HomeController::class,'setting'])->name('setting');
    Route::post('setting-month', [HomeController::class,'settingMonth'])->name('setting_month');


    Route::post('add-new-pharm', [App\Http\Controllers\PharmacyController::class,'addPharm'])->name('add-new-pharm.store');

    Route::get('pharmacy-user/{time}', [App\Http\Controllers\PharmacyController::class,'pharmacyUser'])->name('pharmacy-user');

    Route::get('pharmacy-users/{time}', [App\Http\Controllers\PharmacyController::class,'pharmacyUsers'])->name('pharmacy-users');

    Route::get('pharmacy-list/{time}', [App\Http\Controllers\PharmacyController::class,'pharmacyList'])->name('pharmacy-list');
    Route::post('farm/chart', [App\Http\Controllers\PharmacyController::class,'chart']);

    Route::get('pharmacy-delete/{id}', [App\Http\Controllers\PharmacyController::class,'delete'])->name('pharmacy-delete');


    Route::get('image-grade', [App\Http\Controllers\HomeController::class,'imageGrade'])->name('image.grade');
    Route::post('imagegrade-save', [App\Http\Controllers\HomeController::class,'imageGradeSave'])->name('imagegrade.store');




    Route::resource('pill-question',PillQuestionController::class);
    Route::get('pill-question/{id?}/delete', [App\Http\Controllers\PillQuestionController::class,'destroy'])->name('pill-question.delete');

    Route::resource('condition-question',ConditionQuestionController::class);
    Route::get('condition-question/{id?}/delete', [App\Http\Controllers\ConditionQuestionController::class,'destroy'])->name('condition-question.delete');

    Route::resource('knowledge-question',KnowledgeQuestionController::class);
    Route::get('knowledge-question/{id?}/delete', [App\Http\Controllers\KnowledgeQuestionController::class,'destroy'])->name('knowledge-question.delete');

    Route::resource('bquestion',BilimQuestionController::class);
    Route::get('bquestion/{id?}/delete', [App\Http\Controllers\BilimQuestionController::class,'destroy'])->name('bquestion.delete');

    Route::resource('knowledge',KnowledgeController::class);
    Route::get('knowledge/{id?}/delete', [App\Http\Controllers\KnowledgeController::class,'destroy'])->name('knowledge.delete');

    Route::get('knowledge-grade', [App\Http\Controllers\HomeController::class,'knowGrade'])->name('know.grade');
    Route::get('elchi_know/{id?}', [App\Http\Controllers\ElchiController::class,'elchiKnow'])->name('elchi.know');
    Route::post('know-grade-store', [App\Http\Controllers\ElchiController::class,'knowGradeStore'])->name('know-grade.store');
    Route::get('all-grade', [App\Http\Controllers\GradeController::class,'allGrade'])->name('all.grade');
    Route::post('all-grade', [App\Http\Controllers\GradeController::class,'allGradeStore'])->name('all-grade.store');
    Route::post('all-grade-step1', [App\Http\Controllers\GradeController::class,'allGradeStoreStep1'])->name('all-grade-step1.store');
    Route::post('all-grade-step3', [App\Http\Controllers\GradeController::class,'allGradeStoreStep3'])->name('all-grade-step3.store');

    Route::get('journal-purchase', [App\Http\Controllers\JournalController::class,'purchase'])->name('purchase.journal');

    Route::get('pharmacy/{id?}/{time}', [App\Http\Controllers\PharmacyController::class,'pharmacy'])->name('pharmacy');
    Route::post('pharma-user/{id}', [App\Http\Controllers\PharmacyController::class,'pharmaUserStore'])->name('pharma-user.store');
    Route::post('user-pharma/{id}', [App\Http\Controllers\PharmacyController::class,'userPharmaStore'])->name('user-pharma.store');
    Route::post('user-add-pharma', [App\Http\Controllers\PharmacyController::class,'userPharma'])->name('user-add-pharma.store');
    Route::post('user-delete-pharma', [App\Http\Controllers\PharmacyController::class,'userPharmaDelete'])->name('user-delete-pharma.store');
    Route::post('user-rol', [App\Http\Controllers\PositionController::class,'userRol'])->name('user-rol.store');


    Route::resource('shablon',ShablonController::class);
    Route::get('prices/{id}', [App\Http\Controllers\ShablonController::class,'priceMed'])->name('price-med');
    Route::post('prices-store', [App\Http\Controllers\ShablonController::class,'priceMedStore'])->name('price-medic.store');
    Route::post('prices-store-update/{id}', [App\Http\Controllers\ShablonController::class,'priceMedUpdate'])->name('price-medic.update');
    Route::get('prices-store-edit/{id}', [App\Http\Controllers\ShablonController::class,'priceMedEdit'])->name('price-med.edit');
    Route::get('shablon-active/{id}', [App\Http\Controllers\ShablonController::class,'shablonActive'])->name('shablon-active');
    Route::get('shablon-pharmacy', [App\Http\Controllers\ShablonController::class,'shablonPharmacy'])->name('shablon.pharmacy');
    Route::post('shablon-pharmacy-store', [App\Http\Controllers\ShablonController::class,'shablonPharmacyStore'])->name('shablon.pharmacy.store');
    Route::post('shablon-pharmacy-update/{id}', [App\Http\Controllers\ShablonController::class,'shablonPharmacyUpdate'])->name('shablon.pharmacy.update');
    Route::get('shablon-pharmacy-edit/{id}', [App\Http\Controllers\ShablonController::class,'shablonPharmacyEdit'])->name('shablon.pharmacy.edit');


    Route::resource('warehouse',WarehouseController::class);
    Route::resource('product-category',ProductCategoryController::class);
    Route::resource('product',ProductController::class);
    Route::post('product-plus/{id}', [App\Http\Controllers\ProductController::class,'productPlus'])->name('product.plus');
    Route::post('product-minus/{id}', [App\Http\Controllers\ProductController::class,'productMinus'])->name('product.minus');
    Route::get('product-journal', [App\Http\Controllers\ProductController::class,'productJournal'])->name('product-journal.show');
    Route::get('product/{id?}/trash', [App\Http\Controllers\ProductController::class,'trash'])->name('product.trash');
    Route::get('product/{id?}/delete', [App\Http\Controllers\ProductController::class,'destroy'])->name('product.delete');
    Route::get('product/{id?}/restore', [App\Http\Controllers\ProductController::class,'restore'])->name('product.restore');

    Route::get('database', [App\Http\Controllers\BazaController::class,'database'])->name('database');


    Route::get('team/{time}',[App\Http\Controllers\TeamController::class,'index'])->name('team');

    Route::get('team-battle',[App\Http\Controllers\TeamController::class,'teamBattle'])->name('team-battle');

    Route::get('team-slider',[App\Http\Controllers\TeamController::class,'slider'])->name('team-slider');
    Route::post('team-slider-save',[App\Http\Controllers\TeamController::class,'sliderSave'])->name('team-slider-save');
    Route::post('team-slider-update/{id}',[App\Http\Controllers\TeamController::class,'sliderUpdate'])->name('team-slider-update');
    Route::get('team-slider-delete/{id}',[App\Http\Controllers\TeamController::class,'sliderDelete'])->name('team-slider-delete');

    Route::get('team-plan',[App\Http\Controllers\TeamController::class,'plan'])->name('team-plan');
    Route::post('team-plan-update/{id}',[App\Http\Controllers\TeamController::class,'planUpdate'])->name('team-plan-update');

    Route::get('team-battle-view/{id}',[App\Http\Controllers\TeamController::class,'teamBattleView'])->name('battle.view');
    Route::post('team-battle-store',[App\Http\Controllers\TeamController::class,'teamBattleStore'])->name('team-battle.store');
    Route::post('team-battle-date/{id}',[App\Http\Controllers\TeamController::class,'teamBattleDate'])->name('team-battle.date');

    Route::post('team',[App\Http\Controllers\TeamController::class,'store'])->name('team.store');
    #battle
    Route::get('elchi-battle',[App\Http\Controllers\UserController::class,'elchiBattle'])->name('elchi-battle');
    Route::get('elchi-his/{id}',[App\Http\Controllers\UserController::class,'elchiHis'])->name('get-his');
    Route::get('get-battle/{start}/{end?}',[App\Http\Controllers\UserController::class,'getBattle'])->name('get-battle');
    Route::get('elchi-battle-setting',[App\Http\Controllers\UserController::class,'elchiBattleSetting'])->name('elchi-battle-setting');
    Route::post('elchi-battle-setting-store',[App\Http\Controllers\UserController::class,'elchiBattleSettingStore'])->name('elchi-battle-setting.store');
    Route::get('elchi-battle-select',[App\Http\Controllers\UserController::class,'elchiBattleSelect'])->name('elchi-battle-select');
    Route::post('elchi-battle-select.store',[App\Http\Controllers\UserController::class,'elchiBattleSelectStore'])->name('elchi-battle-select.store');
    Route::get('elchi-battle-exercise',[App\Http\Controllers\UserController::class,'elchiBattleExercise'])->name('elchi-battle-exercise');
    Route::post('elchi-battle-exercise-store',[App\Http\Controllers\UserController::class,'elchiBattleExerciseStore'])->name('elchi-battle-exercise-store');
    Route::get('elchi-user-battle-exercise',[App\Http\Controllers\UserController::class,'elchiUserBattleExercise'])->name('elchi-user-battle-exercise');

    Route::post('elchi-user-battle-exercise-store',[App\Http\Controllers\UserController::class,'elchiUserBattleExerciseStore'])->name('elchi-user-battle-exercise-store');

    #endbattle

    Route::resource('member',MemberController::class);
    Route::post('member-minus', [App\Http\Controllers\MemberController::class,'minus'])->name('member.minus');
// trend
    Route::get('trend',[App\Http\Controllers\TrendController::class,'trend'])->name('trend');

    Route::post('region-statistic',[App\Http\Controllers\TrendController::class,'RegionStatistic'])->name('region.statistic');
    Route::get('trend-region/{range}',[App\Http\Controllers\TrendController::class,'region'])->name('trend.region');

    Route::post('month-statistic',[App\Http\Controllers\TrendController::class,'MonthStatistic'])->name('month.statistic');

    Route::get('day-statistic-name',[App\Http\Controllers\TrendController::class,'DayStatistic'])->name('day.statistic');
    Route::get('day-statistic-region',[App\Http\Controllers\TrendController::class,'DayStatistic2'])->name('day.statistic2');
    Route::get('day-statistic-name-region',[App\Http\Controllers\TrendController::class,'DayStatistic3'])->name('day.statistic3');

    Route::post('product-statistic',[App\Http\Controllers\TrendController::class,'ProductStatistic'])->name('product.statistic');
    Route::get('trend-product/{range}',[App\Http\Controllers\TrendController::class,'product'])->name('trend.product');

    Route::get('trend-user/{range}',[App\Http\Controllers\TrendController::class,'user'])->name('trend.user');
    Route::get('trend-pharmacy/{range}',[App\Http\Controllers\TrendController::class,'pharmacy'])->name('trend.pharmacy');
    // end trend
    #end-position
    #bro
    Route::get('plan/{id}', [PlanController::class,'create'])->name('plan');
    Route::post('plan/create/{id}', [PlanController::class,'store'])->name('plan.store');
    Route::post('plan/update/{id}', [PlanController::class,'updateAllPlans'])->name('plan.update-all-plans');
    Route::get('plan/{id}/edit', [PlanController::class,'edit'])->name('plan.edit');
    Route::get('plan/{id}/update-all', [PlanController::class,'updateAll'])->name('plan.update-all');
    Route::get('plan/show/{id}/{startday?}', [PlanController::class,'show'])->name('plan.show');
    Route::post('plan/{id}/update', [PlanController::class,'update'])->name('plan.update');
    Route::get('elchilar-kunlik/{month}', [ElchilarController::class,'kunlik'])->name('elchilar');
    Route::get('user-control', [UserController::class,'index'])->name('user-control');
    Route::get('user-register', [UserController::class,'userRegister'])->name('user-register');
    Route::get('users-without-pharmacy', [UserController::class,'userWithoutPharmacy'])->name('users-without-pharmacy');
    Route::post('user-bind-pharmacy', [UserController::class,'userBindPharmacy'])->name('user-bind-pharmacy.store');
    Route::get('users-all', [UserController::class,'allUsers'])->name('users-all');

//    new route

    Route::get('users-view/{id}', [UserController::class,'ViewUsers'])->name('users-view');
    Route::post('create_users_pharm',[UserController::class,'CreatePharm'])->name('create_users_pharm');
    Route::post('create_users_start_work',[UserController::class,'CreateStartWork'])->name('create_users_start_work');
    Route::put('update_users_start_work/{id}',[UserController::class,'UpdateStartWork'])->name('update_users_start_work');
    Route::delete('delete_users_pharm/{id}',[UserController::class,'DeletePharm'])->name('delete_users_pharm');
    Route::delete('users-order-delete/{id}',[UserController::class,'DeleteOrder'])->name('users-order-delete');
    Route::put('users-update/{id}', [UserController::class,'UpdateUsers'])->name('users-update');
    Route::put('users-order-update/{id}', [UserController::class,'UpdateOrder'])->name('users-order-update');
    Route::get('/users-region', [UserController::class,'changeRegion'])->name('users-region');

//    end route

    Route::get('users-crystall', [UserController::class,'usersCrystall'])->name('users-crystall');
    Route::post('change-crystall', [UserController::class,'changeCrystall'])->name('change-users-crystall');
    Route::post('assign-daily-work-time', [UserController::class, 'assignDailyWork'])->name('assign-daily-work-time');
    Route::post('user-control/add', [UserController::class,'addUser'])->name('user-add');
    Route::post('user-control/delete/{action}', [UserController::class,'controlWorker'])->name('user-delete');
    Route::post('user-rm', [UserController::class,'userRm'])->name('user-rm');
    Route::post('user-cap', [UserController::class,'userCap'])->name('user-cap');
    Route::post('user-exit', [UserController::class,'userExit'])->name('user-exit');
    Route::post('user-test', [UserController::class,'userTest'])->name('user-test');
    Route::post('user-new', [UserController::class,'userNew'])->name('user-new');
    Route::get('money/{region_id}/{month}', [UserController::class, 'userMoney'])->name('user-money');
    Route::get('blacklist', [UserController::class, 'blackList'])->name('blacklist.all');
    Route::post('blacklist-remove', [UserController::class, 'blackListRemove'])->name('blacklist.remove');

    Route::get('user-money/{id}/{month}', [UserController::class, 'userMoneyProfil'])->name('user-money-profil');

    Route::get('medicine/accept/{id}/create',[\App\Http\Controllers\AcceptProductController::class,'create'])->name('accept.med.create');
    Route::get('medicine/accept/{id}/show/{time?}',[\App\Http\Controllers\AcceptProductController::class,'show'])->name('accept.med.show');
    Route::get('medicine/accept',[\App\Http\Controllers\AcceptProductController::class,'index'])->name('accept.med');
    Route::get('medicine/accept/all/{time}',[\App\Http\Controllers\AcceptProductController::class,'index_all'])->name('accept.med.all');
    Route::post('medicine/accept/{id}/store',[\App\Http\Controllers\AcceptProductController::class,'store'])->name('accept.med.store');
    Route::get('medicine/accept/{pharmacy_id}/edit/{date}',[\App\Http\Controllers\AcceptProductController::class,'edit'])->name('accept.med.edit');
    Route::post('medicine/accept/{id}/update',[\App\Http\Controllers\AcceptProductController::class,'update'])->name('accept.med.update');
    Route::get('medicine/accept/{pharmacy_id}/delete/{date}',[\App\Http\Controllers\AcceptProductController::class,'delete'])->name('accept.med.delete');


    Route::get('medicine/stock/{id}/create',[\App\Http\Controllers\StockController::class,'create'])->name('stock.med.create');
    Route::get('medicine/stock/{id}/show/{time}',[\App\Http\Controllers\StockController::class,'show'])->name('stock.med.show');
    Route::get('medicine/stock',[\App\Http\Controllers\StockController::class,'index'])->name('stock.med');
    Route::get('medicine/stock/all/{time}',[\App\Http\Controllers\StockController::class,'index_all'])->name('stock.med.all');
    Route::post('medicine/stock/{id}/store',[\App\Http\Controllers\StockController::class,'store'])->name('stock.med.store');
    Route::get('medicine/stock/{pharmacy_id}/edit/{date}',[\App\Http\Controllers\StockController::class,'edit'])->name('stock.med.edit');
    Route::get('medicine/stock/{pharmacy_id}/delete/{date}',[\App\Http\Controllers\StockController::class,'delete'])->name('stock.med.delete');
    Route::post('medicine/stock/{id}/update',[\App\Http\Controllers\StockController::class,'update'])->name('stock.med.update');


    Route::get('pharm/users',[\App\Http\Controllers\PharmUsersController::class,'index'])->name('pharm.users');
    Route::get('pharm/users/all/show',[\App\Http\Controllers\PharmUsersController::class,'allshow'])->name('pharm.users.all');
    Route::get('pharm/users/all/show-by-pharmacy',[\App\Http\Controllers\PharmUsersController::class,'allshowbypharm'])->name('pharm.users.bypharm');
    Route::get('pharm/users/{id}/edit',[\App\Http\Controllers\PharmUsersController::class,'edit'])->name('pharm.users.edit');
    Route::get('pharm/users/{id}/edit-by-pharmacy',[\App\Http\Controllers\PharmUsersController::class,'editby'])->name('pharm.users.editby');
    Route::post('pharm/users/{id}/update',[\App\Http\Controllers\PharmUsersController::class,'updateByUser'])->name('pharm.users.update');
    Route::post('pharm/users/{id}/update-by',[\App\Http\Controllers\PharmUsersController::class,'updateByPharmacy'])->name('pharm.users.updateby');
    Route::get('pharm/users/{id}/show',[\App\Http\Controllers\PharmUsersController::class,'oneshow'])->name('pharm.users.one');
    Route::post('pharm/users/store',[\App\Http\Controllers\PharmUsersController::class,'store'])->name('pharm.users.store');


    Route::get('compare-stocks',[\App\Http\Controllers\CompareController::class,'index'])->name('compare');
    Route::get('compare-stocks/{id}/time/{time?}',[\App\Http\Controllers\CompareController::class,'show'])->name('compare.pharm');
    Route::post('task',[ElchiTaskController::class,'store'])->name('task.store');
    #end-bro

    #rm-dash
    Route::get('rm',[\App\Http\Controllers\RMController::class,'index'])->name('rm-dash');
    Route::get('rm-region/{region}/{time?}/{action?}',[\App\Http\Controllers\RMController::class,'region'])->name('rm-region');
    Route::get('rm-user/{region}/{time?}',[\App\Http\Controllers\RMController::class,'user'])->name('rm-user');
    Route::get('rm-pharmacy/{region}/{time?}',[\App\Http\Controllers\RMController::class,'pharmacy'])->name('rm-pharmacy');
    Route::get('rm-medicine/{region}/{time?}',[\App\Http\Controllers\RMController::class,'medicine'])->name('rm-medicine');

    #end-rm-dash

    Route::get('open-smena', [ToolzController::class,'openSmena'])->name('open-smena');
    Route::get('close-smena', [ToolzController::class,'closeSmena'])->name('close-smena');
    Route::get('king-sold', [ToolzController::class,'kingSold'])->name('king.sold');

    Route::get('king-sold/{user_id}/{region_id}/{date}', [ToolzController::class,'kingSoldSearch'])->name('king-sold');


    Route::get('king-sold-history', [ToolzController::class,'kingSoldHistory'])->name('king.history');
    Route::get('king-liga', [ToolzController::class,'kingSoldLiga'])->name('king-liga');
    Route::post('king-liga-store', [ToolzController::class,'kingSoldLigaStore'])->name('user-add-liga.king');
    Route::post('king-liga-delete', [ToolzController::class,'kingSoldLigaDelete'])->name('user-delete-liga.king');
    Route::get('king-ligas', [ToolzController::class, 'kingLigas'])->name('kingliga.index');
    Route::post('king-ligas-update', [ToolzController::class, 'kingLigasUpdate'])->name('kingliga.update');

    Route::get('add-teacher', [TeacherController::class,'index'])->name('add-teacher');
    Route::post('store-teacher', [TeacherController::class,'store'])->name('teacher.store');

    Route::get('add-shogird', [TeacherController::class,'shogird'])->name('add-shogird');

    Route::get('ustoz-game/{id}', [TeacherController::class,'ustozGame'])->name('ustoz-game');
    Route::get('ustoz-add/{id}', [TeacherController::class,'ustozAdd'])->name('ustoz-add');
    Route::get('stajer-add/{id}', [TeacherController::class,'stajerAdd'])->name('stajer-add');
    Route::get('ustoz-stajer-minus/{id}', [TeacherController::class,'ustozStajerMinus'])->name('ustoz-stajer-minus');

    Route::post('shogird-teacher', [TeacherController::class,'shogirdStore'])->name('shogird.store');
    Route::post('shogird-teacher-update', [TeacherController::class,'shogirdUpdateTime'])->name('shogird.date');

    Route::get('st-grade', [TeacherController::class,'grade'])->name('st-grade');
    Route::get('yetakchi', [TeacherController::class,'yetakchi'])->name('yetakchi');

//   Start Jamolar

    Route::get('jamoalar',[JamoalarController::class,'index'])->name('jamoalar');
    Route::post('create_jamoa',[JamoalarController::class,'CreateJamoa'])->name('create_jamoa');
    Route::delete('delete_jamoa/{id}',[JamoalarController::class,'DeleteJamoa'])->name('delete_jamoa');
    Route::post('select_date',[JamoalarController::class,'SelectDate'])->name('select_date');
    Route::post('create_plan',[JamoalarController::class,'CreatePlan'])->name('create_plan');
    Route::put('update_plan/{id}',[JamoalarController::class,'UpdatePlan'])->name('update_plan');
    Route::get('user_or_teacher/{id}',[JamoalarController::class,'IsTeacherOrUser'])->name('user_or_teacher');

//   End Jamolar
    Route::get('dublicat', [DublicatController::class,'index'])->name('dublicat.index');
    Route::post('dublicat-store', [DublicatController::class,'store'])->name('dublicat.store');

    Route::get('provizor', [ToolzController::class,'provizor'])->name('provizor');
    Route::post('provizor-add', [ToolzController::class,'provizorAdd'])->name('provizor-add');
    Route::post('provizor-lose', [ToolzController::class,'provizorLose'])->name('provizor-lose');

    // BATTLE NEWS
    Route::get('/allnews', [NewsController::class, 'index'])->name('openNews');
    Route::get('create-news', [NewsController::class, 'create'])->name('createNews');
    Route::get('edit-news/{id}', [NewsController::class, 'edit'])->name('editNews');
    Route::post('update-news/{id}', [NewsController::class, 'update'])->name('updateNews');
    Route::post('delete-news/{id}', [NewsController::class, 'delete'])->name('deleteNews');
    Route::post('store-news', [NewsController::class, 'store'])->name('storeNews');

    Route::post('/store-news-images', [NewsController::class, 'uploadImages'])->name('uploadImages');
    Route::get('/old-news-images', [NewsController::class, 'uploadedImages'])->name('uploadedImages');


    // INFO NEWS
    Route::get('/allinfos', [InfoController::class, 'index'])->name('openInfos');
    Route::get('create-infos', [InfoController::class, 'create'])->name('createInfos');
    Route::get('edit-infos/{id}', [InfoController::class, 'edit'])->name('editInfos');
    Route::post('update-infos/{id}', [InfoController::class, 'update'])->name('updateInfos');
    Route::post('delete-infos/{id}', [InfoController::class, 'delete'])->name('deleteInfos');
    Route::post('store-infos', [InfoController::class, 'store'])->name('storeInfos');
    // VIDEO NEWS
    Route::get('/allvideos', [VideoController::class, 'index'])->name('openVideos');
    Route::get('create-videos', [VideoController::class, 'create'])->name('createVideos');
    Route::get('edit-videos/{id}', [VideoController::class, 'edit'])->name('editVideos');
    Route::post('update-videos/{id}', [VideoController::class, 'update'])->name('updateVideos');
    Route::post('delete-videos/{id}', [VideoController::class, 'delete'])->name('deleteVideos');
    Route::post('store-videos', [VideoController::class, 'store'])->name('storeVideos');

    //ostatka2.0 - start
    Route::resource('residual', ResidualController::class);

    //ostatka2.0 - end

    //provizor - start
    Route::get('pro-order', [ProvizorController::class, 'index'])->name('pro-order');
    Route::get('change-status/{order_id}/{status}', [ProvizorController::class,'changeOrderStatus'])->name('orderpro.status');

    Route::get('order-product/{order_id}', [ProvizorController::class,'orderProduct'])->name('order.product');

    Route::post('order-update/{order_id}', [ProvizorController::class,'orderProductUpdate'])->name('order.update');

    Route::get('order-delete-pro/{order_id}', [ProvizorController::class,'orderProductDelete'])->name('ordersdelete');

    Route::get('provizor-hisobot', [ProvizorController::class, 'provizorHisobot'])->name('provizor-hisobot');



    Route::get('pro-money', [ProvizorController::class, 'money'])->name('pro-money');
    Route::post('pro-money', [ProvizorController::class, 'moneyStore'])->name('pro-money.store');

    Route::get('pro-battle', [ProvizorController::class, 'battle'])->name('pro-battle');
    Route::post('pro-battle', [ProvizorController::class, 'battleStore'])->name('pro-battle.store');


    Route::get('pro-crystal-history', [ProvizorController::class, 'crystalHistory'])->name('pro-crystal-history');
    Route::post('pro-crystal-history-save', [ProvizorController::class, 'crystalHistoryStore'])->name('pro-crystal-history-save');
    //provizor - end

    //TURNIR-BEGIN
    Route::get('turnir-team', [TurnirController::class, 'team'])->name('turnir-team');
    Route::get('turnir-group', [TurnirController::class, 'group'])->name('turnir-group');
    Route::post('turnir-member-store', [TurnirController::class, 'memberStore'])->name('turnir-member.store');
    Route::post('team-group-store', [TurnirController::class, 'teamGroupStore'])->name('team-group.store');
    Route::get('turnir-tour', [TurnirController::class, 'turnirTour'])->name('turnir-tour');
    Route::post('turnir-tour-store', [TurnirController::class, 'turnirTourStore'])->name('turnir-tour-store');
    Route::post('turnir-tour-update', [TurnirController::class, 'turnirTourUpdate'])->name('turnir-tour-update');

    Route::get('turnir-playoff', [TurnirController::class, 'turnirPlayoff'])->name('turnir-playoff');
    Route::post('turnir-playoff-store', [TurnirController::class, 'turnirPlayoffStore'])->name('turnir-playoff-store');

    Route::get('turnir-games', [TurnirController::class, 'turnirGames'])->name('turnir-games');
    Route::post('turnir-games-store', [TurnirController::class, 'turnirGamesStore'])->name('turnir-games-store');

    Route::get('group-state', [TurnirController::class, 'groupState'])->name('group-state');
    Route::post('group-state-store', [TurnirController::class, 'groupStateStore'])->name('group-state.store');
    //TURNIR-END

    //      LMS

    Route::get('lms-index',[\App\Http\Controllers\LMSController::class,'index'])->name('lms-index');
    Route::post('lms-user-check',[\App\Http\Controllers\LMSController::class,'UserCheck'])->name('lms-user-check');

//    End LMS
//    Topshiriq
    Route::get('topshiriq-index',[\App\Http\Controllers\TopshiriqController::class,'index'])->name('topshiriq-index');
    Route::post('topshiriq-create',[\App\Http\Controllers\TopshiriqController::class,'create'])->name('topshiriq-create');
    Route::put('topshiriq-update/{id}',[\App\Http\Controllers\TopshiriqController::class,'update'])->name('topshiriq-update');
//    Daraja
    Route::get('topshiriq-level',[\App\Http\Controllers\TopshiriqController::class,'level'])->name('topshiriq-level');
    Route::post('topshiriq-level-create',[\App\Http\Controllers\TopshiriqController::class,'LevelCreate'])->name('topshiriq-level-create');
    Route::put('topshiriq-level-update/{id}',[\App\Http\Controllers\TopshiriqController::class,'LevelUpdate'])->name('topshiriq-level-update');

//    End Topshiriq



    //MEGA-TURNIR-BEGIN
        Route::get('mega-turnir-teacher', [MegaTurnirController::class, 'teacher'])->name('mega-turnir-teacher');
        Route::post('mega-turnir-teacher-save', [MegaTurnirController::class, 'teacherSave'])->name('mega-turnir-teacher-save');
        Route::get('mega-turnir-team', [MegaTurnirController::class, 'team'])->name('mega-turnir-team');
        Route::post('mega-turnir-team-save', [MegaTurnirController::class, 'teamSave'])->name('mega-turnir-team-save');

        Route::get('mega-turnir-team-battle', [MegaTurnirController::class, 'teamBattle'])->name('mega-turnir-team-battle');
        Route::post('mega-turnir-team-battle-save', [MegaTurnirController::class, 'teamBattleSave'])->name('mega-turnir-team-battle-save');

        Route::get('mega-turnir-user-battle', [MegaTurnirController::class, 'userBattle'])->name('mega-turnir-user-battle');
        Route::post('mega-turnir-user-battle-save', [MegaTurnirController::class, 'userBattleSave'])->name('mega-turnir-user-battle-save');
    //MEGA-TURNIR-END

    //REKRUT-BEGIN
    Route::get('rekrut', [RekrutController::class, 'rekrut'])->name('rekrut');
    Route::get('rekrut-hisobot', [RekrutController::class, 'rekrutHisobot'])->name('rekrut-hisobot');
    Route::post('rekrut-check/{id}', [RekrutController::class, 'rekrutCheck'])->name('rekrut.check');
    Route::get('rekrut-add-user', [RekrutController::class, 'addUser'])->name('rekrut-add-user');
    Route::get('rekrut-change/{id}', [RekrutController::class, 'change'])->name('rekrut.change');
    Route::get('rekrut-delete/{id}', [RekrutController::class, 'delete'])->name('rekrut.delete');
    Route::post('rekrut-save-user', [RekrutController::class, 'saveUser'])->name('rekrut-save-user');

    Route::get('rekrut-change-xolat/{id}/{xolat}', [RekrutController::class, 'changeXolat'])->name('rekrut-change-xolat');
    Route::get('rekrut-change-potok/{id}/{potok}', [RekrutController::class, 'changePotok'])->name('rekrut-change-potok');

    Route::post('rekrut-ustoz-hisobot', [RekrutController::class, 'rekrutUstozHisobot'])->name('rekrut-ustoz-hisobot');
    Route::get('rekrut-edit/{id}', [RekrutController::class, 'rekrutEdit'])->name('rekrut-edit');
    Route::get('rekrut-sms/{id}', [RekrutController::class, 'rekrutSMS'])->name('rekrut-sms');
    Route::post('rekrut-update/{id}', [RekrutController::class, 'rekrutUpdate'])->name('rekrut-update');

    Route::get('ustoz50', [RekrutController::class, 'ustoz50'])->name('ustoz50');
    Route::get('ustoz70', [RekrutController::class, 'ustoz70'])->name('ustoz70');


    Route::resource('rekrut-group',RekrutGroupController::class);


    //REKRUT-END

    //ORDER-BEGIN
    Route::get('order', [OrderController::class, 'index'])->name('order.index');

    Route::get('order/{order_id}', [OrderController::class, 'orderPage'])->name('mc-ord-id');
    Route::get('order-delete/{order_id}', [OrderController::class, 'orderDelete']);

    // Route::get('order/{order_id}', [\App\Http\Livewire\McShipmentDetail::class, 'mount']);

    Route::get('all-orders', [OrderController::class, 'allOrders'])->name('orders');
    Route::get('warehouse', [OrderController::class, 'warehouse'])->name('warehouse');
    Route::get('shipment', [OrderController::class, 'shipment'])->name('shipment');
    Route::get('money-coming', [OrderController::class, 'money'])->name('money-coming');
    Route::get('report', [OrderController::class, 'report'])->name('report');
    Route::post('report-save', [OrderController::class, 'reportSave'])->name('report-save');
    Route::get('report-region', [OrderController::class, 'reportRegion'])->name('report-region');
    Route::get('mc-admin', [OrderController::class, 'mcAdmin']);
    Route::get('mc-admin-restore/{id}', [OrderController::class, 'mcOrderRestore'])->name('mc-admin-restore');

    Route::get('mc-admin-restore/{begin}/{end}', [OrderController::class, 'mcMoneymonth'])->name('mc-money-month');

    Route::post('mc-order-change-date/{id}', [OrderController::class, 'mcChangeOrderDate'])->name('mc-order-change-date');
    Route::post('mc-order-delivery-change-date/{id}/{array}', [OrderController::class, 'mcChangeOrderDeliveryDate'])->name('mc-order-delivery-change-date');

    Route::post('mc-payment-change-date/{id}', [OrderController::class, 'mcChangePaymentDate'])->name('mc-payment-change-date');
    Route::post('mc-payment-change-amount/{id}', [OrderController::class, 'mcChangePaymentAmount'])->name('mc-payment-change-amount');

    Route::get('mc-pharmacy-return-money', [OrderController::class, 'mcPharmacyReturn'])->name('mc-pharmacy-return-money');
    Route::post('mc-return-day-region/{id}', [OrderController::class, 'mcRegionReturnDay'])->name('mc-return-day-region');
    Route::post('mc-return-day-pharmacy', [OrderController::class, 'mcPharmacyReturnDay'])->name('mc-return-day-pharmacy');

    Route::get('mc-payment-last/{id}', [OrderController::class, 'mcChangePaymentLast'])->name('mc-payment-last');
    Route::get('mc-payment-delete/{id}', [OrderController::class, 'mcChangePaymentDelete'])->name('mc-payment-delete');
    Route::get('mc-return-delete/{id}', [OrderController::class, 'mcChangeReturnDelete'])->name('mc-return-delete');

    Route::post('mc-return/{id}', [OrderController::class, 'mcChangeReturn'])->name('mc-return');
    Route::post('mc-return-date/{id}', [OrderController::class, 'mcChangeReturnDate'])->name('mc-return-date');

    Route::post('mc-change-phar/{id}', [OrderController::class, 'mcChangeOrderPhrmacy'])->name('mc-change-phar');


    Route::get('mc-yanvar', [OrderController::class, 'mcYanvar'])->name('mc-yanvar');

    Route::get('mc-change-price', [OrderController::class, 'mcChangePrice'])->name('mc-change-price');
    Route::post('mc-update-price', [OrderController::class, 'mcUpdatePrice'])->name('mc-update-price');

    Route::get('mc-pharmacy', [OrderController::class, 'pharmacy'])->name('mc-pharmacy');
    Route::get('last-order', [OrderController::class, 'lastOrders'])->name('last.order');
    Route::post('last-order-save', [OrderController::class, 'lastOrdersSave'])->name('last.order.save');


    //ORDER-END

    //REK-BEGIN
    Route::get('rek', [RekController::class, 'index'])->name('rek.index');
    Route::get('rek-pharmacy/{id}', [RekController::class, 'pharmacy'])->name('rek.pharmacy');
    //REk-END


    //MIJOZ-BEGIN
    Route::get('mijoz-banner', [MijozController::class, 'banner'])->name('mijoz-banner');
    Route::post('mijoz-banner-save', [MijozController::class, 'bannerSave'])->name('mijoz-banner-save');
    Route::post('mijoz-banner-update/{banner_id}', [MijozController::class, 'bannerUpdate'])->name('mijoz-banner-update');
    //MIJOZ-END

    //MARKET-BEGIN
    Route::get('market-category', [MarketController::class, 'category'])->name('market-category');
    Route::post('market-category-save', [MarketController::class, 'categorySave'])->name('market-category-save');
    Route::post('market-category-update/{id}', [MarketController::class, 'categoryUpdate'])->name('market-category-update');
    Route::get('market-category-delete/{id}', [MarketController::class, 'categoryDelete'])->name('market-category-delete');

    Route::get('market-slider', [MarketController::class, 'slider'])->name('market-slider');
    Route::post('market-slider-save', [MarketController::class, 'sliderSave'])->name('market-slider-save');
    Route::post('market-slider-update/{id}', [MarketController::class, 'sliderUpdate'])->name('market-slider-update');
    Route::get('market-slider-delete/{id}', [MarketController::class, 'sliderDelete'])->name('market-slider-delete');

    Route::get('market-product', [MarketController::class, 'product'])->name('market-product');
    Route::post('market-product-save', [MarketController::class, 'productSave'])->name('market-product-save');
    Route::post('market-product-update/{id}', [MarketController::class, 'productUpdate'])->name('market-product-update');
    Route::get('market-product-delete/{id}', [MarketController::class, 'productDelete'])->name('market-product-delete');
    //MARKET-END

     //CRYSTALL-BEGIN
     Route::get('crystal-add', [CrystalController::class, 'addCrystal'])->name('crystal-add');
     Route::post('crystal-save', [CrystalController::class, 'saveCrystal'])->name('crystal-save');
     //CRYSTALL-END

     //FIREWALL-BEGIN
     Route::get('firewall', [FirewallController::class, 'index'])->name('firewall');
     Route::get('firewall-confirm/{id}/{status}', [FirewallController::class, 'firewallConfirm'])->name('firewall-confirm');
     //FIREWALL-END

     //NEW-PAROL-BEGIN
     Route::get('regenerate-password', [UserController::class, 'rePassword']);
     Route::get('regenerate-password-change-pass-phone', [UserController::class, 'rePasswordPhone'])->name('change-pass-phone');
     Route::get('regenerate-password-change-pass', [UserController::class, 'rePasswordPass'])->name('change-pass');
     //NEW-PAROL-BEGIN

});

// PREMYA
Route::get('premya-tasks', [PremyaTaskController::class, 'index'])->name('premya.index');
Route::get('premya-active/{premya_id}', [PremyaTaskController::class, 'active'])->name('premya.active');

// });
