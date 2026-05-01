    <?php

    use App\Http\Controllers\ActiveController;
    use App\Http\Controllers\AddMembershipPlanController;
    use App\Http\Controllers\AddPersonalTrainerPlan;
    use App\Http\Controllers\AdminDashboardController;
    use App\Http\Controllers\AttendanceController;
    use App\Http\Controllers\BranchController;
    use App\Http\Controllers\CancellationOrRefundPolicyController;
    use App\Http\Controllers\CheckInController;
    use App\Http\Controllers\CustomerDashboard;
    use App\Http\Controllers\CustomerLoginController;
    use App\Http\Controllers\CustomerProfileController;
    use App\Http\Controllers\CustomerWorkoutController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\DeletedMemberController;
    use App\Http\Controllers\DeleteMemberController;
    use App\Http\Controllers\ExerciseController;
    use App\Http\Controllers\ExerciseImageController;
    use App\Http\Controllers\ExpiredPlanController;
use App\Http\Controllers\ExportCsvController;
use App\Http\Controllers\FollowUpLeadController;
    use App\Http\Controllers\ForgotPassword;
    use App\Http\Controllers\ImportCsvAndExcelFileController;
    use App\Http\Controllers\LeadNotesController;
    use App\Http\Controllers\LeadStatusController;
    use App\Http\Controllers\LeadTransferController;
    use App\Http\Controllers\LeadUserController;
use App\Http\Controllers\LiabilityController;
use App\Http\Controllers\MemberInvoicePdfController;
    use App\Http\Controllers\MembershipPlanController;
    use App\Http\Controllers\MembershipPlanStatusController;
    use App\Http\Controllers\PendingRemainingBalanceController;
    use App\Http\Controllers\PersonalTrainerController;
use App\Http\Controllers\PersonalTrainerPdfController;
use App\Http\Controllers\PersonalTrainerTransactionController;
    use App\Http\Controllers\PrivacyAndPolicyController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\SettingController;
    use App\Http\Controllers\StaffController;
    use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TermAndConditionController;
    use App\Http\Controllers\TrainerController;
    use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionPdfController;
use App\Http\Controllers\TransactionReportController;
use App\Http\Controllers\UnifiedSearchController;
use App\Http\Controllers\UpcomingRenewalController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\UserNoteController;
    use App\Http\Controllers\UserPaymentReminderController;
    use App\Http\Controllers\WorkoutCategoryController;
    use App\Http\Controllers\WorkoutPlanController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('/', [DashboardController::class, 'dashboard']);
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //**************************************************************/
    /*                      Admin Routes                           */
    /***************************************************************/

    Route::middleware(['auth', 'admin.check'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Route
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Payment Remainder routes
        Route::controller(UserPaymentReminderController::class)->group(function () {
            Route::post('{user}/payment/remainder/mail', 'byMail')->name('payment.remainder.by.mail');
            Route::post('{user}/payment/remainder/sms', 'bySms')->name('payment.remainder.by.sms');
        });

        // Forgot Password Routes
        Route::controller(ForgotPassword::class)->group(function () {
            Route::get('members/{user}/forgot_password', 'edit')->name('user.forgot.password');
            Route::patch('members/{user}/forgot_password', 'update')->name('user.forgot.password');
            Route::patch('members/{user}/forgot_password/link', 'sendNewPassword')->name('user.forgot.password.link');
        });

        // Members Routes
        Route::controller(UserController::class)->prefix('members')->name('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::get('/create/{user?}', 'create')->name('create');
            Route::get('/{user}/view', 'view')->name('view');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::get('/{user}/exit', 'exit')->name('exit');
            Route::post('/store', 'store')->name('store');
            Route::put('/{user}/update', 'update')->name('update');
            Route::delete('/{user}/delete', 'delete')->name('delete');
            Route::delete('/{membershipPlan}/delete-record', 'deleteRecord')->name('delete.record');
        });

        //Unified Search
        Route::get('/unified-search',[UnifiedSearchController::class,'search'])->name('unified.search');

        //Liability Routes
        Route::get('liability/index',[LiabilityController::class,'index'])->name('liability.index');

        //Attendance Routes
        Route::controller(AttendanceController::class)->prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/index', 'index')->name('index');
           
        });

        // Add Membership plan
        Route::controller(AddMembershipPlanController::class)->prefix('members/plan')->name('user.membership.plan.')->group(function () {
            Route::get('/{user}/create', 'create')->name('create');
            Route::post('/{user}/store', 'store')->name('store');
            Route::get('/{plan}/edit', 'edit')->name('edit');
            Route::post('/{plan}/update', 'update')->name('update');
            Route::delete('/{plan}/delete', 'delete')->name('delete');
        });

        // Download Invoice PDF
        Route::get('/member/{user}/invoice/pdf', MemberInvoicePdfController::class)->name('user.invoice.pdf');
        Route::get('/pt/{user}/invoice/pdf', PersonalTrainerPdfController::class)->name('pt.invoice.pdf');
        // Member note routes
        Route::controller(UserNoteController::class)->prefix('members')->name('members.notes.')->group(function () {
            Route::get('/{user}/notes', 'index')->name('index');
            Route::post('/{user}/notes/store', 'store')->name('store');
            Route::delete('/{note}/notes/delete', 'delete')->name('delete');
        });

        // Transaction Routes
        Route::controller(TransactionController::class)->prefix('members/transactions')->name('transaction.')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::post('/{user}/store', 'store')->name('store');
            Route::get('/{transaction}/edit', 'edit')->name('edit');
            Route::post('/{transaction}/update', 'update')->name('update');
            Route::delete('/{transaction}/delete', 'delete')->name('delete');
        });
        //Transaction Invoice
        Route::controller(TransactionPdfController::class)->prefix('members/transactions/invoice')->name('transaction.invoice.')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::get('/invoice/{user}', 'download')->name('download');
        });

        //Personal Trainer Transaction Route
        Route::controller(PersonalTrainerTransactionController::class)->prefix('personal_training/transactions')->name('pt.transactions.')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::post('/{user}/store', 'store')->name('store');
            Route::get('/{transaction}/edit', 'edit')->name('edit');
            Route::post('/{transaction}/update', 'update')->name('update');
            Route::delete('/{transaction}/delete', 'delete')->name('delete');
        });


        // Transaction Report Routes
        Route::controller(TransactionReportController::class)->prefix('transactions/report')->name('transaction.report.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        //Export CSV
        Route::get('/exportcsv',[ExportCsvController::class,'exportCsv'])->name('exportcsv');

        //Trainers Routes
        Route::controller(TrainerController::class)->prefix('trainers')->name('trainers.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/view/{user}', 'view')->name('view');
            Route::get('/edit/{user}', 'edit')->name('edit');
            Route::post('/update/{user}', 'update')->name('update');
            Route::delete('/delete/{user}', 'delete')->name('delete');
            //to show trainer from member index
            Route::get('/showTrainer','showTrainer')->name('showTrainer');
        });

        // Leads Routes
        Route::controller(LeadUserController::class)->prefix('leads')->name('lead.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::delete('/{user}/delete', 'delete')->name('delete');
            Route::post('/store', 'store')->name('store');
            Route::put('/{user}/update', 'update')->name('update');
            Route::get('/{user}/view', 'view')->name('view');
        });

        //Lead Transfer Controller Routes

        Route::controller(LeadTransferController::class)->prefix('lead/transfer')->name('lead.transfer.')->group(function () {
            Route::get('/{user}/{id}', 'transfer')->name('transfer');
        });

        Route::patch('lead/{user}/update', [LeadStatusController::class, 'update'])->name('lead.status.update');

        // Leads Notes Route
        Route::controller(LeadNotesController::class)->prefix('leads')->name('lead.notes.')->group(function () {
            Route::get('/{user}/notes', 'index')->name('index');
            Route::post('/{user}/notes/store', 'store')->name('store');
            Route::delete('/{note}/notes/delete', 'delete')->name('delete');
        });

        // Manage PT Routes
        Route::controller(PersonalTrainerController::class)->prefix('personal_training')->name('pt.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{data}/edit', 'edit')->name('edit');
            Route::delete('/{data}/delete', 'delete')->name('delete');
            Route::post('/store', 'store')->name('store');
            Route::put('/{data}/update', 'update')->name('update');
            Route::get('/{data}/view', 'view')->name('view');
        });

        // Additinal PT Plans route
        Route::controller(AddPersonalTrainerPlan::class)->name('pt.plan.')->prefix('personal_training/plan')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::post('/{user}/store', 'store')->name('store');
            Route::delete('/{data}/delete', 'delete')->name('delete');
        });

        // Staff Routes
        Route::controller(StaffController::class)->prefix('staffs')->name('staff.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}/update', 'update')->name('update');
            Route::get('/{user}/view', 'view')->name('view');
        });

        // Branches Routes
        Route::controller(BranchController::class)->prefix('branches')->name('branch.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{branch}/edit', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::put('/{branch}/update', 'update')->name('update');
            Route::delete('/{branch}/delete', 'delete')->name('delete');
        });

        // Membership Plan Routes
        Route::controller(MembershipPlanController::class)->prefix('plans')->name('membershipplan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{plan}/edit', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::put('/{plan}/update', 'update')->name('update');
            Route::delete('/{plan}/delete', 'delete')->name('delete');
            Route::patch('/{plan}/update', [MembershipPlanStatusController::class, 'update'])->name('status.update');
        });

        // Profile Route
        Route::middleware('auth')->controller(ProfileController::class)->group(function () {
            Route::get('/profile',  'edit')->name('profile.edit');
            Route::put('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });

        // Import csv file route
        Route::post('import/file', [ImportCsvAndExcelFileController::class, 'store'])->name('import.file');

        // Upcoming Renewal
        Route::controller(UpcomingRenewalController::class)->prefix('/upcoming-renewal')->name('upcoming.renewal.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{id}', 'create')->name('create');
            Route::post('/store/{plan?}', 'store')->name('store');
            Route::get('/update/{plan?}', 'update')->name('update');
        });

        // Expired Plan
        Route::controller(ExpiredPlanController::class)->prefix('/expired-plan')->name('expired.plan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{plan?}', 'create')->name('create');
            Route::post('/store/{plan?}', 'store')->name('store');
        });

        // Remaining balance is pending
        Route::controller(PendingRemainingBalanceController::class)->prefix('/remaining-balance')->name('remaining.balance.')->group(function () {
            Route::get('/', 'index')->name('index');
        });


        // Follow Up Lead
        Route::controller(FollowUpLeadController::class)->prefix('/follow-up-lead')->name('followup.lead.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/approach-status/{id}', 'check')->name('check');
        });

        // Workout Plans Route
        Route::controller(WorkoutPlanController::class)->prefix('/workout-plans')->name('workout.plans.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{plan}/view', 'view')->name('view');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{plan}/edit', 'edit')->name('edit');
            Route::put('/{plan}/update', 'update')->name('update');
            Route::delete('/{plan}/delete', 'delete')->name('delete');
        });

        // Workout category route
        Route::controller(WorkoutCategoryController::class)->prefix('/workout-categories')->name('workout.categories.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{category}/edit', 'edit')->name('edit');
            Route::put('/{category}/update', 'update')->name('update');
            Route::delete('/{category}/delete', 'delete')->name('delete');
        });

        //Workout exercise route
        Route::controller(ExerciseController::class)->prefix('/exercises')->name('exercises.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{exercise}/edit', 'edit')->name('edit');
            Route::put('/{exercise}/update', 'update')->name('update');
            Route::delete('/{exercise}/delete', 'delete')->name('delete');
        });

        Route::controller(ExerciseImageController::class)->prefix('/exercises/upload')->name('exercises.upload.')->group(function () {
            Route::get('/{exercise}/create', 'create')->name('create');
            Route::get('/{exercise}/index', 'index')->name('index');
            Route::post('/{exercise}/store', 'store')->name('store');
            Route::post('/{exercise}/delete', 'delete')->name('delete');
        });

        Route::controller(DeletedMemberController::class)->prefix('/deleted-members')->name('deleted.member.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/restore', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
        });

        Route::controller(TemplateController::class)->prefix('/SMS/Templates')->name('sms.')->group(function(){
            Route::get('sms/index','index')->name('index');
            Route::get('sms/add','add')->name('add');
            Route::post('sms/create','create')->name('create');
            Route::post('sms/store/{id}','store')->name('store');
            Route::get('sms/edit/{id}','edit')->name('edit');
            Route::delete('sms/delete/{id}','delete')->name('delete');
            Route::get('sms/send-sms/','send')->name('send');
            Route::get('sms/broadcast/','broadcast')->name('broadcast');

        });

    });


    //**************************************************************/
    /*                      Staff Routes                           */
    /***************************************************************/

    Route::middleware(['auth', 'staff.check'])->prefix('staff')->name('staff.')->group(function () {
        // Dashboard Route
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

        // Payment Remainder routes
        Route::controller(UserPaymentReminderController::class)->group(function () {
            Route::post('{user}/payment/remainder/mail', 'byMail')->name('payment.remainder.by.mail');
            Route::post('{user}/payment/remainder/sms', 'bySms')->name('payment.remainder.by.sms');
        });

        // Forgot Password Routes
        Route::controller(ForgotPassword::class)->group(function () {
            Route::get('members/{user}/forgot_password', 'edit')->name('user.forgot.password');
            Route::patch('members/{user}/forgot_password', 'update')->name('user.forgot.password');
            Route::patch('members/{user}/forgot_password/link', 'sendNewPassword')->name('user.forgot.password.link');
        });

        // Members
        Route::controller(UserController::class)->prefix('members')->name('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{user?}', 'create')->name('create');
            Route::get('/{user}/view', 'view')->name('view');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::get('/{user}/exit', 'exit')->name('exit');
            Route::post('/store', 'store')->name('store');
            Route::put('/{user}/update', 'update')->name('update');
            Route::delete('/{user}/delete', 'delete')->name('delete');
            Route::delete('/{membershipPlan}/delete-record', 'deleteRecord')->name('delete.record');
        });

        //Unified Search
        Route::get('/unified-search',[UnifiedSearchController::class,'search'])->name('unified.search');

         //Liability Routes
         Route::get('liability/index',[LiabilityController::class,'index'])->name('liability.index');

         //Attendance Routes
         Route::controller(AttendanceController::class)->prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/index', 'index')->name('index');
           
        });

        // Add Membership plan
        Route::controller(AddMembershipPlanController::class)->prefix('members/plan')->name('user.membership.plan.')->group(function () {
            Route::get('/{user}/create', 'create')->name('create');
            Route::post('/{user}/store', 'store')->name('store');
            Route::get('/{plan}/edit', 'edit')->name('edit');
            Route::post('/{plan}/update', 'update')->name('update');
            Route::delete('/{plan}/delete', 'delete')->name('delete');
        });

        // Download Invoice PDF
        Route::get('/member/{user}/invoice/pdf', MemberInvoicePdfController::class)->name('user.invoice.pdf');
        Route::get('/pt/{user}/invoice/pdf', PersonalTrainerPdfController::class)->name('pt.invoice.pdf');
        

        // Member note routes
        Route::controller(UserNoteController::class)->prefix('members')->name('members.notes.')->group(function () {
            Route::get('/{user}/notes', 'index')->name('index');
            Route::post('/{user}/notes/store', 'store')->name('store');
            Route::delete('/{note}/notes/delete', 'delete')->name('delete');
        });

        // Transaction Routes
        Route::controller(TransactionController::class)->prefix('members/transactions')->name('transaction.')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::post('/{user}/store', 'store')->name('store');
            Route::get('/{transaction}/edit', 'edit')->name('edit');
            Route::post('/{transaction}/update', 'update')->name('update');
            Route::delete('/{transaction}/delete', 'delete')->name('delete');
        });
        //Transaction Invoice
        Route::controller(TransactionPdfController::class)->prefix('members/transactions/invoice')->name('transaction.invoice.')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::get('/invoice/{user}', 'download')->name('download');
        });

        //Trainers Routes
        Route::controller(TrainerController::class)->prefix('trainers')->name('trainers.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/view/{user}', 'view')->name('view');
            Route::get('/edit/{user}', 'edit')->name('edit');
            Route::post('/update/{user}', 'update')->name('update');
            Route::delete('/delete/{user}', 'delete')->name('delete');
             //to show trainer from member index
             Route::get('/showTrainer','showTrainer')->name('showTrainer');
        });


        //Personal Trainer Transaction Route
        Route::controller(PersonalTrainerTransactionController::class)->prefix('personal_training/transactions')->name('pt.transactions.')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::post('/{user}/store', 'store')->name('store');
            Route::get('/{transaction}/edit', 'edit')->name('edit');
            Route::post('/{transaction}/update', 'update')->name('update');
            Route::delete('/{transaction}/delete', 'delete')->name('delete');
        });

        // Transaction Report Routes
        Route::controller(TransactionReportController::class)->prefix('transactions/report')->name('transaction.report.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        //Export CSV
        Route::get('/exportcsv',[ExportCsvController::class,'exportCsv'])->name('exportcsv');

        // Leads Routes
        Route::controller(LeadUserController::class)->prefix('leads')->name('lead.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::delete('/{user}/delete', 'delete')->name('delete');
            Route::post('/store', 'store')->name('store');
            Route::put('/{user}/update', 'update')->name('update');
            Route::get('/{user}/view', 'view')->name('view');
        });

        //Lead Transfer Controller Routes

        Route::controller(LeadTransferController::class)->prefix('lead/transfer')->name('lead.transfer.')->group(function () {
            Route::get('/', 'transfer')->name('transfer');
        });
        Route::patch('lead/{user}/update', [LeadStatusController::class, 'update'])->name('lead.status.update');

        // Leads Notes Route
        Route::controller(LeadNotesController::class)->prefix('leads')->name('lead.notes.')->group(function () {
            Route::get('/{user}/notes', 'index')->name('index');
            Route::post('/{user}/notes/store', 'store')->name('store');
            Route::delete('/{note}/notes/delete', 'delete')->name('delete');
        });

        // Manage PT Routes
        Route::controller(PersonalTrainerController::class)->prefix('personal_training')->name('pt.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{data}/edit', 'edit')->name('edit');
            Route::delete('/{data}/delete', 'delete')->name('delete');
            Route::post('/store', 'store')->name('store');
            Route::put('/{data}/update', 'update')->name('update');
            Route::get('/{data}/view', 'view')->name('view');
        });

        // Additinal PT Plans route
        Route::controller(AddPersonalTrainerPlan::class)->name('pt.plan.')->prefix('personal_training/plan')->group(function () {
            Route::get('/{user}', 'index')->name('index');
            Route::post('/{user}/store', 'store')->name('store');
            Route::delete('/{data}/delete', 'delete')->name('delete');
        });

        // Staff Routes
        Route::controller(StaffController::class)->prefix('staffs')->name('staff.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}/update', 'update')->name('update');
            Route::get('/{user}/view', 'view')->name('view');
        });

        // Branches Routes
        Route::controller(BranchController::class)->prefix('branches')->name('branch.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{branch}/edit', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::put('/{branch}/update', 'update')->name('update');
            Route::delete('/{branch}/delete', 'delete')->name('delete');
        });

        // Membership Plan Routes
        Route::controller(MembershipPlanController::class)->prefix('plans')->name('membershipplan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::patch('/{plan}/update', [LeadStatusController::class, 'update'])->name('status.update');
            // Route::get('/create', 'create')->name('create');
            // Route::get('/{plan}/edit', 'edit')->name('edit');
            // Route::post('/store', 'store')->name('store');
            // Route::put('/{plan}/update', 'update')->name('update');
            // Route::delete('/{plan}/delete', 'delete')->name('delete');
        });

        // Profile Route
        Route::middleware('auth')->controller(ProfileController::class)->group(function () {
            Route::get('/profile',  'edit')->name('profile.edit');
            Route::put('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });

        // Import csv file route
        Route::post('import/file', [ImportCsvAndExcelFileController::class, 'store'])->name('import.file');

        // Upcoming Renewal
        Route::controller(UpcomingRenewalController::class)->prefix('/upcoming-renewal')->name('upcoming.renewal.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{user?}', 'create')->name('create');
            Route::post('/store/{user?}', 'store')->name('store');
            Route::get('/update/{plan?}', 'update')->name('update');

        });


        // Expired Plan
        Route::controller(ExpiredPlanController::class)->prefix('/expired-plan')->name('expired.plan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create/{plan?}', 'create')->name('create');
            Route::post('/store/{plan?}', 'store')->name('store');
        });

        // Remaining balance is pending
        Route::controller(PendingRemainingBalanceController::class)->prefix('/remaining-balance')->name('remaining.balance.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        // Follow Up lead
        Route::controller(FollowUpLeadController::class)->prefix('/follow-up-lead')->name('followup.lead.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/approach-status/{id}', 'check')->name('check');
        });

        // Workout Plans Route
        Route::controller(WorkoutPlanController::class)->prefix('/workout-plans')->name('workout.plans.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{plan}/view', 'view')->name('view');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{plan}/edit', 'edit')->name('edit');
            Route::put('/{plan}/update', 'update')->name('update');
            Route::delete('/{plan}/delete', 'delete')->name('delete');
        });

        // Workout category route
        Route::controller(WorkoutCategoryController::class)->prefix('/workout-categories')->name('workout.categories.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{category}/edit', 'edit')->name('edit');
            Route::put('/{category}/update', 'update')->name('update');
            Route::delete('/{category}/delete', 'delete')->name('delete');
        });

        //Workout exercise route
        Route::controller(ExerciseController::class)->prefix('/exercises')->name('exercises.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{exercise}/edit', 'edit')->name('edit');
            Route::put('/{exercise}/update', 'update')->name('update');
            Route::delete('/{exercise}/delete', 'delete')->name('delete');
        });

        Route::controller(ExerciseImageController::class)->prefix('/exercises/upload')->name('exercises.upload.')->group(function () {
            Route::get('/{exercise}/create', 'create')->name('create');
            Route::get('/{exercise}/index', 'index')->name('index');
            Route::post('/{exercise}/store', 'store')->name('store');
            Route::post('/{exercise}/delete', 'delete')->name('delete');
        });

        Route::controller(DeletedMemberController::class)->prefix('/deleted-members')->name('deleted.member.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/restore', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
        });

        Route::controller(TemplateController::class)->prefix('/SMS/Templates')->name('sms.')->group(function(){
            Route::get('sms/index','index')->name('index');
            Route::get('sms/add','add')->name('add');
            Route::post('sms/create','create')->name('create');
            Route::post('sms/store/{id}','store')->name('store');
            Route::get('sms/edit/{id}','edit')->name('edit');
            Route::delete('sms/delete/{id}','delete')->name('delete');
            Route::get('sms/send-sms/','send')->name('send');
            Route::get('sms/broadcast/','broadcast')->name('broadcast');
        });

    });

    //**************************************************************/
    /*                      Customer Routes                        */
    /***************************************************************/

    Route::middleware(['auth', 'user.check'])->prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');

        // Profile Routes
        Route::controller(CustomerProfileController::class)->group(function () {
            Route::get('/profile', 'index')->name('profile.index');
            Route::get('/edit-profile', 'edit')->name('profile.edit');
            Route::put('/edit-update', 'update')->name('profile.update');
        });



        // Workout Route
        Route::controller(CustomerWorkoutController::class)->prefix('workouts')->name('workouts.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{plan}/view', 'view')->name('view');
        });
    });

    Route::get('/member/login', [CustomerLoginController::class, 'index'])->name('user.login');
    Route::post('/member/login', [CustomerLoginController::class, 'store'])->name('user.login');
    // Route::controller(RegistrationController::class)->group(function () {
    //     Route::get('/new-membership', 'create')->name('registration');
    //     Route::post('/new-membership/store', 'store')->name('registration.store');
    //     Route::post('/check/validation', 'checkValidation')->name('check.validation');
    // });

    // Frontend Routes
    Route::get('/privacy&policy', [PrivacyAndPolicyController::class, 'view'])->name('privacy.and.policy');
    Route::get('/cancellation&refund', [CancellationOrRefundPolicyController::class, 'view'])->name('cancellation.and.refund.policy');
    Route::get('/terms&conditions', [TermAndConditionController::class, 'view'])->name('terms.and.conditions');

    // Fallback Route
    Route::fallback(function () {
        return back();
    });

    //CheckIn Routes

    Route::controller(CheckInController::class)->prefix('check-in')->name('checkin.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'mark')->name('mark');
        Route::post('/store/{user}', 'store')->name('store');
    });


    require __DIR__ . '/auth.php';
