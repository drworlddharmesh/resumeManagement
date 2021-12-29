<?php

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

// Route::get('/', function () {
//     //return view('welcome');
//     return redirect('admin');
// });
Route::get('log-clean', function () {
    \Artisan::call('logs:clear');
    dd("Done");
});

Route::get('/', function () {
    return redirect('admin');
});

// Route::get('update-user-end-date', function () {
//     \App\Jobs\UpdateUserEndDate::dispatch();
//     dd('Users end date updated successfully.');
// });

// Route::get('update-user-resume-data', function () {
//     \App\Jobs\UpdateUserResumeData::dispatch();
//     dd('Users resume data updated successfully.');
// });

// Route::get('change-not-submit-status', function () {
//     \App\Models\User::where('IsRemoved', 0)->whereNull('UserEndDate')->update([
//         'ResumeSubmitStatus' => 1,
//     ]);

//     dd('Not submit status updated successfully.');
// });

// Route::get('update-agreement-no', function () {
//     $user = \App\Models\User::whereDate('created_at', '>=', '2020-09-30 17:32:00')
//         ->where('AgreementId', '<=', 15)
//         ->get();

//     $cnt = 0;
//     foreach ($user as $usr) {
//         $AgreementId = \App\Models\Agreement::where('AgreementNo', $usr->AgreementId)
//             ->where('IsRemoved', 0)
//             ->first();

//         \App\Models\User::where('UserId', $usr->UserId)
//             ->update([
//                 'AgreementId' => $AgreementId->AgreementId,
//             ]);

//         $cnt += 1;
//     }

//     dd('Updated successfully. : ' . $cnt);
// });

// Admin
Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        if (Session::has('AdminId')) {
            return redirect('admin/dashboard');
        } else {
            return view('admin.admin.login');
        }
    });
    Route::get('report', 'Admin\ReportController@Report');
    // Admin
    Route::post('login', 'Admin\AdminController@Login');
    Route::post('supar-admin-login', 'Admin\AdminController@SuparAdminLogin');
    Route::get('dashboard', 'Admin\AdminController@Dashboard');
    Route::get('DashboardDataTable', 'Admin\AdminController@DashboardDataTable')->name('DashboardDataTable');
    Route::get('forgot-password', 'Admin\AdminController@ForgotPassword');
    Route::post('check-admin-email', 'Admin\AdminController@CheckAdminEmail');
    Route::post('otp', 'Admin\AdminController@OTP');
    Route::post('reset-password', 'Admin\AdminController@ResetPassword');
    Route::post('submit-reset-password', 'Admin\AdminController@SubmitResetPassword');
    // Route::view('/profiles', 'admin.admin.password');
    Route::post('profile/password', 'Admin\NocController@password2');
    Route::post('profile/reset-password', 'Admin\AdminController@AdminResetPassword');
    Route::get('profile', 'Admin\AdminController@Profile');
    Route::get('change-password', 'Admin\AdminController@ChangePassword');

    Route::post('check-old-password', 'Admin\AdminController@CheckOldPassword');
    Route::post('update-password', 'Admin\AdminController@UpdatePassword');
    Route::post('profile/update-profile', 'Admin\AdminController@UpdateProfile');

    //Client
    Route::get('client', 'Admin\ClientController@Client');
    Route::get('AddUserDataTable', 'Admin\ClientController@AddUserDataTable')->name('AddUserDataTable');
    Route::post('client/delete-client', 'Admin\ClientController@DeleteClient');
    Route::get('client/delete-clients', 'Admin\ClientController@DeleteClients');
    Route::get('client/add-client', 'Admin\ClientController@AddClient');
    Route::get('client/edit-client/{UserId}', 'Admin\ClientController@EditClient');
    Route::post('client/check-dublication-email', 'Admin\ClientController@checkdublicationemail');
    Route::post('client/insert-client', 'Admin\ClientController@InsertClient');
    Route::post('client/update-client', 'Admin\ClientController@UpdateClient');
    Route::get('client/resend-mail/{UserId}', 'Admin\ClientController@Resendmail');
    Route::get('client/resend-sms/{UserId}', 'Admin\ClientController@Resendsms');
    Route::get('client/remove-sign/{UserId}', 'Admin\ClientController@RemoveSign');
    Route::get('client/resumeallow-client/{UserId}/{Status}', 'Admin\ClientController@resumeAllowStatus');
    Route::post('/client/fetch', 'Admin\ClientController@dependentfetch')->name('ClientController.dependentfetch');
    Route::get('client/pending', 'Admin\ClientController@pending');
    Route::get('UserPendingDataTable', 'Admin\ClientController@UserPendingDataTable')->name('UserPendingDataTable');
    Route::any('client/approve', 'Admin\ClientController@approve');
    Route::any('UserApproveDataTable', 'Admin\ClientController@UserApproveDataTable')->name('UserApproveDataTable');
    Route::get('client/disapprove', 'Admin\ClientController@disapprove');
    Route::get('UserDisapproveDataTable', 'Admin\ClientController@UserDisapproveDataTable')->name('UserDisapproveDataTable');
    Route::post('client/delete-client/clients_delete', 'Admin\ClientController@clients_delete');
    Route::get('client/acive-users', 'Admin\ActiveUserController@ActiveUser');
    //DataTables
    Route::get('client/acive-users-datatable', 'Admin\ActiveUserController@ActiveUserDataTable')->name('ActiveUserDataTable');

    // Plan
    Route::get('plan', 'Admin\PlanController@Plan');
    Route::get('PlanDataTable', 'Admin\PlanController@PlanDataTable')->name('PlanDataTable');
    Route::post('plan/delete-plan', 'Admin\PlanController@DeletePlan');
    Route::get('plan/add-plan', 'Admin\PlanController@AddPlan');
    Route::post('plan/insert-plan', 'Admin\PlanController@InsertPlan');
    Route::get('plan/edit-plan/{PlanId}', 'Admin\PlanController@EditPlan');
    Route::post('plan/update-plan', 'Admin\PlanController@UpdatePlan');

    //Resume
    Route::get('resume', 'Admin\ResumeController@Resume');
    Route::get('ResumeDataTable', 'Admin\ResumeController@ResumeDataTable')->name('ResumeDataTable');
    Route::post('resume/delete-resume', 'Admin\ResumeController@DeleteResume');
    Route::get('resume/add-resume', 'Admin\ResumeController@AddResume');
    Route::post('resume/insert-resume', 'Admin\ResumeController@InsertResume');
    Route::get('resume/edit-resume/{PlanId}', 'Admin\ResumeController@EditResume');
    Route::post('resume/update-resume', 'Admin\ResumeController@UpdateResume');
    Route::get('resume/delete-resumes', 'Admin\ResumeController@DeleteResumes');
    Route::post('resume/delete-resumes/resumes_delete', 'Admin\ResumeController@resumes_delete');
    // ResumeDetails
    Route::any('resumedetails', 'Admin\ResumeDetailsController@users')->name('notsubmit');
    Route::any('UserReviewDataTable', 'Admin\ResumeDetailsController@usersDataTable')->name('UserReviewDataTable');
    Route::any('resumedetailsubmit', 'Admin\ResumeDetailsController@userssubmit')->name('submit');
    Route::any('UserReviewDataTableSubmit', 'Admin\ResumeDetailsController@usersDataTableSubmit')->name('UserReviewDataTableSubmit');
    Route::get('resumedetails/{UserId}', 'Admin\ResumeDetailsController@Resume');
    Route::any('ResumeSubmitDataTable', 'Admin\ResumeDetailsController@ResumeSubmitDataTable')->name('ResumeSubmitDataTable');
    Route::get('resumedetails/resume-details/{UserId}/{ResumeId}', 'Admin\ResumeDetailsController@ResumeDetails');
    Route::get('resumedetails/fail-all-resume/{UserId}', 'Admin\ResumeDetailsController@FailAllResume');
    Route::any('pass', 'Admin\ResumeDetailsController@pass');
    Route::any('PassDataTable', 'Admin\ResumeDetailsController@PassDataTable')->name('PassDataTable');

    Route::any('fail', 'Admin\ResumeDetailsController@fail');
    Route::any('fail/FailDataTable', 'Admin\ResumeDetailsController@FailDataTable')->name('FailDataTable');
    Route::post('resumedetails/review-resume-details', 'Admin\ResumeDetailsController@ReviewResumeDetails');

    Route::get('resumedetailsubmit/{UserId}', 'Admin\ResumeDetailsController@Resume1');
    Route::get('resumedetailsubmit/move/{UserId}', 'Admin\ResumeDetailsController@MoveToSubmit');
    Route::get('resumedetailsubmit/resume-details/{UserId}/{ResumeId}', 'Admin\ResumeDetailsController@ResumeDetails');
    Route::post('resumedetailsubmit/review-resume-details', 'Admin\ResumeDetailsController@ReviewResumeDetails');

    //Agreement
    Route::get('agreement', 'Admin\AgreementController@Agreement');
    Route::get('AgreementDataTable', 'Admin\AgreementController@AgreementDataTable')->name('AgreementDataTable');
    Route::post('agreement/delete-agreement', 'Admin\AgreementController@DeleteAgreement');
    Route::get('agreement/add-agreement', 'Admin\AgreementController@AddAgreement');
    Route::post('agreement/insert-agreement', 'Admin\AgreementController@InsertAgreement');
    Route::get('agreement/edit-agreement/{AgreementId}', 'Admin\AgreementController@EditAgreement');
    Route::post('agreement/update-agreement', 'Admin\AgreementController@UpdateAgreement');
    Route::post('agreement/check-agreement-name', 'Admin\AgreementController@CheckAgreementName');
    Route::post('agreement/check-edit-agreement-name', 'Admin\AgreementController@CheckEditAgreementName');

    //Franchisee
    Route::get('franchisee', 'Admin\FranchiseeController@Franchisee');
    Route::get('FranchiseerDataTable', 'Admin\FranchiseeController@FranchiseerDataTable')->name('FranchiseerDataTable');
    Route::post('franchisee/delete-franchisee', 'Admin\FranchiseeController@DeleteFranchisee');
    Route::get('franchisee/add-franchisee', 'Admin\FranchiseeController@AddFranchisee');
    Route::post('franchisee/insert-franchisee', 'Admin\FranchiseeController@InsertFranchisee');
    Route::get('franchisee/edit-franchisee/{FranchiseeId}', 'Admin\FranchiseeController@EditFranchisee');
    Route::post('franchisee/update-franchisee', 'Admin\FranchiseeController@UpdateFranchisee');
    Route::post('franchisee/check-franchisee-name', 'Admin\FranchiseeController@CheckFranchiseeName');
    Route::post('franchisee/check-edit-franchisee-name', 'Admin\FranchiseeController@CheckEditFranchiseeName');

    //Caller
    Route::get('caller', 'Admin\CallerController@Caller');
    Route::get('CallerDataTable', 'Admin\CallerController@CallerDataTable')->name('CallerDataTable');
    Route::post('caller/delete-caller', 'Admin\CallerController@DeleteCaller');
    Route::get('caller/add-caller', 'Admin\CallerController@AddCaller');
    Route::post('caller/insert-caller', 'Admin\CallerController@InsertCaller');
    Route::get('caller/edit-caller/{CallerId}', 'Admin\CallerController@EditCaller');
    Route::post('caller/update-caller', 'Admin\CallerController@UpdateCaller');
    Route::post('caller/check-caller-name', 'Admin\CallerController@CheckCallerName');
    Route::post('caller/check-edit-caller-name', 'Admin\CallerController@CheckEditCallerName');
    // Noc
    Route::view('/noc', 'admin.noc.password');
    Route::post('noc/password', 'Admin\NocController@password');
    Route::get('/nocs', 'Admin\NocController@noc');
    Route::post('nocs/paymentmail', 'Admin\NocController@paymentmail');

    //Image
    Route::get('image', 'Admin\ImageController@Image');
    Route::get('ImageDataTable', 'Admin\ImageController@ImageDataTable')->name('ImageDataTable');
    Route::post('image/delete-image', 'Admin\ImageController@DeleteImage');
    Route::get('image/add-image', 'Admin\ImageController@AddImage');
    Route::post('image/insert-image', 'Admin\ImageController@InsertImage');
    Route::get('image/edit-image/{ImageId}', 'Admin\ImageController@EditImage');
    Route::post('image/update-image', 'Admin\ImageController@UpdateImage');

    // Exercise
    // Route::get('exercise', 'Admin\ExerciseController@Exercise');
    // Route::get('exercise/add-exercise', 'Admin\ExerciseController@AddExercise');
    // Route::post('exercise/check-exist-add-exercise', 'Admin\ExerciseController@CheckExistAddExercise');
    // Route::post('exercise/insert-exercise', 'Admin\ExerciseController@InsertExercise');
    // Route::get('exercise/edit-exercise/{ExerciseId}', 'Admin\ExerciseController@EditExercise');
    // Route::post('exercise/check-exist-edit-exercise', 'Admin\ExerciseController@CheckExistEditExercise');
    // Route::post('exercise/update-exercise', 'Admin\ExerciseController@UpdateExercise');
    // Route::post('exercise/delete-exercise', 'Admin\ExerciseController@DeleteExercise');

    // Customer Helpline
    Route::get('customer-helpline', 'Admin\CustomerHelplineController@CustomerHelpline');
    Route::get('CustomerHelplineDataTable', 'Admin\CustomerHelplineController@CustomerHelplineDataTable')->name('CustomerHelplineDataTable');
    Route::get('customer-helpline/view-customer-helpline/{CustomerHelplineId}', 'Admin\CustomerHelplineController@ViewCustomerHelpline');
    Route::post('customer-helpline/update-customer-helpline', 'Admin\CustomerHelplineController@UpdateCustomerHelpline');
    Route::view('/date-extensions', 'admin.dateextension.password');
    Route::post('date-extension/password', 'Admin\NocController@password1');
    Route::get('date-extension', 'Admin\DateExtensionController@date_extension');
    Route::post('check-UserRegistrationId', 'Admin\DateExtensionController@check_UserRegistrationId');
    Route::post('date-extension/update', 'Admin\DateExtensionController@update');
    // Warning Mail
    Route::get('warning-mail', 'Admin\WarningMailController@WarningMail');
    Route::post('warning-mail/send', 'Admin\WarningMailController@WarningMailSend');

    //CustomerCare
    Route::get('customer-care', 'Admin\CustomerCareController@CustomerCare');
    Route::get('CustomerCareDataTable', 'Admin\CustomerCareController@CustomerCareDataTable')->name('CustomerCareDataTable');
    Route::post('customer-care/delete-customer-care', 'Admin\CustomerCareController@DeleteCustomerCare');
    Route::get('customer-care/add-customer-care', 'Admin\CustomerCareController@AddCustomerCare');
    Route::post('customer-care/insert-customer-care', 'Admin\CustomerCareController@InsertCustomerCare');
    Route::get('customer-care/edit-customer-care/{CustomerCareId}', 'Admin\CustomerCareController@EditCustomerCare');
    Route::post('customer-care/update-customer-care', 'Admin\CustomerCareController@UpdateCustomerCare');

    Route::get('client-log', 'Admin\ClientLogController@ClientLog');
    Route::get('client-log-DataTable', 'Admin\ClientLogController@ClientLogDataTable')->name('ClientLogDataTable');
    Route::get('client-log/details/{Id}', 'Admin\ClientLogController@Details');
    Route::get('client-log-DataTable-Details', 'Admin\ClientLogController@DetailsDataTable')->name('DetailsDataTable');

    // Sub Admin
    Route::get('sub-admin', 'Admin\ClientController@SubAdmin');
    Route::get('AddSubAdminDataTable', 'Admin\ClientController@AddSubAdminDataTable')->name('AddSubAdminDataTable');
    Route::get('add-sub-admin', 'Admin\ClientController@AddSubAdmin');
    Route::post('insert-sub-admin', 'Admin\ClientController@InsertSubAdmin');
    Route::post('delete-sub-admin', 'Admin\ClientController@DeleteSubAdmin');
    Route::get('sub-admin/resend-mail/{UserId}', 'Admin\ClientController@SubAdminResendmail');
    Route::get('sub-admin/resend-sms/{UserId}', 'Admin\ClientController@SubAdminResendsms');
    Route::get('sub-admin/edit-sub-admin/{UserId}', 'Admin\ClientController@EditSubAdmin');
    Route::post('update-sub-admin', 'Admin\ClientController@UpdateSubAdmin');
//Excel
    Route::get('excel-download', 'Admin\ExcelController@Excel');
    Route::post('excel-download/download', 'Admin\ExcelController@Download');
    Route::get('invoice-generator', 'Admin\InvoiceController@InvoiceGenerator');
    Route::post('invoice-generator/download', 'Admin\InvoiceController@Download');
//Remark
    Route::get('remark', 'Admin\RemarkController@Remark');
    Route::get('RemarkDataTable', 'Admin\RemarkController@RemarkDataTable')->name('RemarkDataTable');
    Route::post('remark/add-remark', 'Admin\RemarkController@InsertRemark');

      // Payment Mail
      Route::get('payment-mail', 'Admin\PaymentMailController@PaymentMail');
      Route::post('payment-mail/send', 'Admin\PaymentMailController@PaymentMailSend');
    // Logout
    Route::get('logout', function () {
        Session::flush();

        return redirect('admin');
    });
});
