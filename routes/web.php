<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ElchilarController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PillController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\LoginAuth;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;

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
    Route::post('calendar', [App\Http\Controllers\NovatioController::class,'calendar']);
    Route::post('grade/ball', [App\Http\Controllers\NovatioController::class,'grade']);
    Route::post('grade/save', [App\Http\Controllers\NovatioController::class,'gradeSave']);
    Route::post('grade/tashqi', [App\Http\Controllers\NovatioController::class,'gradeTashqi']);
    Route::post('/sms',[App\Http\Controllers\HomeController::class, 'smsfly']);
    Route::post('edit/purchase', [App\Http\Controllers\NovatioController::class,'editPurchase']);


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
    Route::get('/search',[HomeController::class,'filter']);
Route::get('elchi/{id}/{time?}', [HomeController::class,'elchi'])->name('elchi');
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
Route::get('pro-list/{time}', [HomeController::class,'proList'])->name('pro-list');
Route::post('permission', [HomeController::class,'permission'])->name('permissions');
Route::get('reg', [HomeController::class,'reg']);
Route::get('grade', [HomeController::class,'grade'])->name('grade');
Route::get('setting/{month}', [HomeController::class,'setting'])->name('setting');

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
Route::get('shablon-active/{id}', [App\Http\Controllers\ShablonController::class,'shablonActive'])->name('shablon-active');


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
Route::get('teamwars',[App\Http\Controllers\TeamWarsController::class,'index'])->name('team.wars');
Route::post('teamwars/store',[App\Http\Controllers\TeamWarsController::class,'store'])->name('team.wars.store');
Route::post('team',[TeamController::class,'store'])->name('team.store');
Route::resource('member',MemberController::class);
Route::post('member-minus', [App\Http\Controllers\MemberController::class,'minus'])->name('member.minus');

#end-position
#bro
Route::get('plan/{id}', [PlanController::class,'create'])->name('plan');
Route::post('plan/create/{id}', [PlanController::class,'store'])->name('plan.store');
Route::get('plan/{id}/edit', [PlanController::class,'edit'])->name('plan.edit');
Route::get('plan/show/{id}/{startday?}', [PlanController::class,'show'])->name('plan.show');
Route::post('plan/{id}/update', [PlanController::class,'update'])->name('plan.update');
Route::get('elchilar-kunlik/{month}', [ElchilarController::class,'kunlik'])->name('elchilar');
Route::get('user-control', [UserController::class,'index'])->name('user-control');
Route::post('user-control/add', [UserController::class,'addUser'])->name('user-add');
Route::post('user-control/delete/{action}', [UserController::class,'controlWorker'])->name('user-delete');
Route::post('user-rm', [UserController::class,'userRm'])->name('user-rm');
Route::post('user-cap', [UserController::class,'userCap'])->name('user-cap');

#end-bro

});

// });
