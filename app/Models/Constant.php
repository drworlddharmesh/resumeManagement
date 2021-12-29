<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model {

    const isApiLogEnable = false;
    const perPageCount   = 20;
    const resumeLimit    = 3;
    const email          = 'info@searchjobsforyou.com';
    const emailwarning   = 'legal@searchjobsforyou.com';
    const toEmail        = 'resume792020@gmail.com';

    const InvoiceGST = 18;

    const userType = [
        'Admin'    => 1,
        'Client'   => 2,
        'SubAdmin' => 3,
    ];
    const ManuStatus = [
        'Inactive' => 0,
        'Active'   => 1,
    ];
    const LoggerData = [
        '1' => 'login',
        '2' => 'resume',
        '3' => 'logout',
    ];

    const LoginStatus = [
        'logout' => 0,
        'login'  => 1,

    ];

    const resumeAllow = [
        'Notreview' => 0,
        'Disallow'  => 1,
        'Allow'     => 2,
    ];

    const resumeStatus = [
        'Fail'      => 0,
        'Pass'      => 1,
        'NotSubmit' => 2,
        'Submit'    => 3,
    ];

    const isRemoved = [
        'NotRemoved' => 0,
        'Removed'    => 1,
    ];
    const MoveSubmit = [
        'NotMove' => 1,
        'Move'    => 2,
    ];

    const UserResumeStatus = [
        'NotSubmit' => 1,
        'Submit'    => 2,
        'Pass'      => 3,
        'Fail'      => 4,
    ];

    const clientUrl = 'http://searchjobsforyou.com';

    // API messages
    const apiMessage = [
        'msgEmailAlreadyExist'          => 'This email is already registered.',
        'msgUserRegistered'             => 'User registered successfully.',
        'msgUserLoggedIn'               => 'User logged in successfully.',
        'msgErrorUploadingImage'        => 'Error while uploading an image.',
        'msgGetCoachList'               => 'Got coach list successfully.',
        'msgEmailDoesnotExist'          => 'Email does not exist.',
        'msgIncorrectEmailPassword'     => 'Incorrect email or password.',
        'msgForgotPassword'             => 'Forgot password mail sent successfully.',
        'msgResetPassword'              => 'Password changed successfully.',
        'msgHealthCondition'            => 'Got health condition list successfully.',
        'msgMedicalForm'                => 'Medical form submited successfully.',
        'msgFitnessTest'                => 'Fitness test submited successfully.',
        'msgGetProfile'                 => 'Got profile successfully.',
        'msgUpdateProfile'              => 'Profile updated successfully.',
        'msgChangePassword'             => 'Password changed successfully.',
        'msgWrongOldPassword'           => 'You entered wrong old password.',
        'msgLogout'                     => 'Logged out successfully.',
        'msgExercise'                   => 'Got exercise successfully.',
        'msgGetDailyWorkoutList'        => 'Got daily workout list successfully.',
        'msgAddExercise'                => 'Exercise inserted successfully.',
        'msgEditExercise'               => 'Exercise updated successfully.',
        'msgDeleteExercise'             => 'Exercise deleted successfully.',
        'msgGetTrainerList'             => 'Got trainer list successfully.',
        'msgAcceptTrainerRequest'       => 'Trainer request accepted successfully.',
        'msgDeclineTrainerRequest'      => 'Trainer request declined successfully.',
        'msgGetAssignWorkoutList'       => 'Got assign workout list successfully.',
        'msgAddAssignExercise'          => 'Assign exercise inserted successfully.',
        'msgAssignExerciseAlreadyExist' => 'Selected exercise already exist for this user.',
        'msgEditAssignExercise'         => 'Assign exercise updated successfully.',
        'msgDeleteAssignExercise'       => 'Assign exercise deleted successfully.',
        'msgGetMedicalFormDateList'     => 'Got medical form date list successfully.',
        'msgGetMedicalForm'             => 'Got medical form data successfully.',
        'msgGetFitnessTestDateList'     => 'Got fitness test date list successfully.',
        'msgGetFitnessTest'             => 'Got fitness test data successfully.',
        'msgGetFitnessTestList'         => 'Got fitness test list successfully.',
        'msgGetPost'                    => 'Got post data successfully.',
        'msgCreatePost'                 => 'Post created successfully.',
        'msgGetSelfPost'                => 'Got self post data successfully.',
        'msgDeletePost'                 => 'Post deleted successfully.',
        'msgDeleteMedicalForm'          => 'Medical form deleted successfully.',
        'msgDeleteFitnessTest'          => 'Fitness test deleted successfully.',
        'msgMedicalFormAlreadyExist'    => 'Medical form is already exist for selected date.',
        'msgFitnessTestAlreadyExist'    => 'Fitness test is already exist for selected date.',
        'msgGetBodyState'               => 'Got body state data successfully.',
        'msgBodyState'                  => 'Body state submited successfully.',
        'msgGetBodyStateDateList'       => 'Got body state date list successfully.',
        'msgBodyStateAlreadyExist'      => 'Body state is already exist for selected date.',
        'msgDeleteBodyState'            => 'Body state deleted successfully.',

    ];

    // Admin session messages
    const adminSessionMessage = [
        'msgIncorrectEmailPassword' => 'Incorrect email or password.',
        'msgUserDisallow'           => 'User disallow by admin.',
        'msgUserLogin'              => 'You can not logout from last device.',
        'msgInsertClient'           => 'Client inserted successfully.',
        'msgUpdateClient'           => 'Client updated successfully.',
        'msgInsertClientStatus'     => 'Status updated successfully.',
        'msgInsertClientAllow'      => 'Resume allow successfully.',
        'msgDeleteUser'             => 'Client deleted successfully.',
        'msgInsertPlan'             => 'Plan inserted successfully.',
        'msgUpdatePlan'             => 'Plan updated successfully.',
        'msgDeletePlan'             => 'Plan deleted successfully.',
        'msgInsertResume'           => 'Resume inserted successfully.',
        'msgUpdateResume'           => 'Resume updated successfully.',
        'msgDeleteResume'           => 'Resume deleted successfully.',
        'msgInsertAgreement'        => 'Agreement inserted successfully.',
        'msgUpdateAgreement'        => 'Agreement updated successfully.',
        'msgDeleteAgreement'        => 'Agreement deleted successfully.',
        'msgInsertFranchisee'       => 'Franchisee inserted successfully.',
        'msgUpdateFranchisee'       => 'Franchisee updated successfully.',
        'msgDeleteFranchisee'       => 'Franchisee deleted successfully.',
        'msgInsertCaller'           => 'Caller inserted successfully.',
        'msgUpdateCaller'           => 'Caller updated successfully.',
        'msgDeleteCaller'           => 'Caller deleted successfully.',
        'msgResetPassword'          => 'Password reset successfully.',
        'msgChangePassword'         => 'Password changed successfully.',
        'msgUpdateProfile'          => 'Profile updated successfully.',
        'msgInsertExercise'         => 'Exercise inserted successfully.',
        'msgUpdateExercise'         => 'Exercise updated successfully.',
        'msgDeleteExercise'         => 'Exercise deleted successfully.',
        'msgCheckFranchiseeName'    => 'Franchisee name already exist.',
        'msgUpdateResumeDetails'    => 'Resume details submitted successfully.',
        'msgResendMailClient'       => 'Resend mail successfully.',
        'msgResendSMSClient'        => 'Resend sms successfully.',
        'msgResendSignClient'       => 'Resend sign successfully.',
        'msgClientMutipleDeleted'   => 'Mutiple Client Deleted successfully.',
        'msgResumeMutipleDeleted'   => 'Mutiple Resume Deleted successfully.',
        'msgSignature'              => 'Signature inserted successfully.',
        'msgCustomerHelplineAnswer' => 'Answer given successfully.',
        'msgResumeQueryFieldSubmit' => 'Question submitted successfully.',
        'msgResumeQueryFieldLimit'  => 'Query limit finish.',
        'msgIncorrectPassword'      => 'Incorrect password.',
        'msgMailSend'               => 'Mail send successfully.',
        'msgDataNotFound'           => 'Data not found.',
        'msgDateExtension'          => 'Date Extension successfully.',
        'msgMoveToSubmit'           => 'Move to submit successfully.',
        'msgMoveToFail'             => 'Move to fail successfully.',
        'msgInsertCustomerCare'     => 'Customer Care inserted successfully.',
        'msgUpdateCustomerCare'     => 'Customer Care updated successfully.',
        'msgDeleteCustomerCare'     => 'Customer Care deleted successfully.',
        'msgMailNotSend'            => 'Email not send,',
        'msgInsertImage'            => 'Image inserted successfully.',
        'msgUpdateImage'            => 'Image updated successfully.',
        'msgDeleteImage'            => 'Image deleted successfully.',
        'msgInsertSubAdmin'         => 'Sub Admin inserted successfully.',
        'msgDeleteSubAdmin'         => 'Sub Admin deleted successfully.',
        'msgUpdateSubAdmin'         => 'Sub Admin updated successfully.',
        'msgInsertRemark'            => 'Remark inserted successfully.',
    ];

    const resumeField = [
        '1'  => 'First Name',
        '2'  => 'Middle Name',
        '3'  => 'Last Name',
        '4'  => 'Date Of Birth',
        '5'  => 'Gender',
        '6'  => 'Nationality',
        '7'  => 'Marital',
        '8'  => 'Passport',
        '9'  => 'Hobbies',
        '10' => 'Language Known',
        '11' => 'Address',
        '12' => 'Landmark',
        '13' => 'City',
        '14' => 'State',
        '15' => 'Pincode',
        '16' => 'Mobile',
        '17' => 'Email Id',
        '18' => 'SSC Result',
        '19' => 'SSC Passing Year',
        '20' => 'SSC Board University',
        '21' => 'HSC Result',
        '22' => 'HSC Board University',
        '23' => 'HSC Passing Year',
        '24' => 'Diploma Degree',
        '25' => 'Diploma Result',
        '26' => 'Diploma University',
        '27' => 'Diploma Year',
        '28' => 'Graduation Result',
        '29' => 'Graduation University',
        '30' => 'Graduation Year',
        '31' => 'Graduation Degree',
        '32' => 'Post Graduation Degree',
        '33' => 'Post Graduation Result',
        '34' => 'Post Graduation University',
        '35' => 'Post Graduation Year',
        '36' => 'Highest Level Education',
        '37' => 'Total Work Expesience Year',
        '38' => 'Total Work Expesience Month',
        '39' => 'Total Companies Worked',
        '40' => 'Last Current Employer',
    ];
}
