<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ElchilarController;
use App\Http\Controllers\ElchiTaskController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PillController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\LoginAuth;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ToolzController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrendController;
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
    Route::post('/user/success', [UserController::class,'userSuccess']);

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

Route::post('/admin', [LoginController::class, 'loginAdmin'])->name('login-admin');
Route::middleware([LoginAdmin::class])->group(function () {

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
Route::get('pharmacy-list/{time}', [App\Http\Controllers\PharmacyController::class,'pharmacyList'])->name('pharmacy-list');
Route::post('farm/chart', [App\Http\Controllers\PharmacyController::class,'chart']);


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

Route::get('trend-region/{range}',[App\Http\Controllers\TrendController::class,'region'])->name('trend.region');
Route::get('trend-product/{range}',[App\Http\Controllers\TrendController::class,'product'])->name('trend.product');
Route::get('trend-user/{range}',[App\Http\Controllers\TrendController::class,'user'])->name('trend.user');
Route::get('trend-pharmacy/{range}',[App\Http\Controllers\TrendController::class,'pharmacy'])->name('trend.pharmacy');

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
Route::post('assign-daily-work-time', [UserController::class, 'assignDailyWork'])->name('assign-daily-work-time');
Route::post('user-control/add', [UserController::class,'addUser'])->name('user-add');
Route::post('user-control/delete/{action}', [UserController::class,'controlWorker'])->name('user-delete');
Route::post('user-rm', [UserController::class,'userRm'])->name('user-rm');
Route::post('user-cap', [UserController::class,'userCap'])->name('user-cap');
Route::post('user-exit', [UserController::class,'userExit'])->name('user-exit');
Route::post('user-test', [UserController::class,'userTest'])->name('user-test');
Route::post('user-new', [UserController::class,'userNew'])->name('user-new');
Route::get('user-money', [UserController::class, 'userMoney'])->name('user-money');

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
Route::post('pharm/users/{id}/update',[\App\Http\Controllers\PharmUsersController::class,'updateby'])->name('pharm.users.update');
Route::post('pharm/users/{id}/update-by',[\App\Http\Controllers\PharmUsersController::class,'updateby'])->name('pharm.users.updateby');
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


Route::get('king-sold-history/{date}', [ToolzController::class,'kingSoldHistory'])->name('king.history');
Route::get('king-liga', [ToolzController::class,'kingSoldLiga'])->name('king-liga');
Route::post('king-liga-store', [ToolzController::class,'kingSoldLigaStore'])->name('user-add-liga.king');
Route::post('king-liga-delete', [ToolzController::class,'kingSoldLigaDelete'])->name('user-delete-liga.king');

});

// });
