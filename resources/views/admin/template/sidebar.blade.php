<?php
use App\Models\Common;
use App\Models\User;

$adminId = decrypt(Session::get('AdminId'));

$user = User::where('UserId', $adminId)->first();

$common = new Common();
$dir    = "common";

$image             = $common->ResponseMediaLink('logo.png', $dir);
$ManuName          = $common->getManu();
$ResumeArray       = ['4', '26'];
$ResumeDetailArray = ['5', '6', '7', '8'];
$RegistrationArray = ['12', '13', '14', '15', '16', '17', '18'];
$SubAdminArray     = ['27', '28'];

?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" style="height: 50px;width: auto;" src="{{ $image }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">Search Jobs For You</span>

                        <span class="text-muted text-xs block">Admin
                            <b class="caret"></b>
                        </span>
                    </a>

                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a class="dropdown-item" href="{{ url('admin/profile') }}">Profile</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ url('admin/change-password') }}">Change Password</a>
                        </li>

                        <li class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="{{ url('admin/logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>

                <div class="logo-element">
                    RS
                </div>
            </li>
         @if (in_array("1", $ManuName))
            <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <i class="fa fa-th-large"></i>

                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
         @endif
         @if (in_array("2", $ManuName))
            <li class="{{ Request::segment(2) == 'plan' ? 'active' : '' }}">
                <a href="{{ url('admin/plan') }}">
                <i class="fa fa-pencil-square-o"></i>

                    <span class="nav-label" style="padding-left: 5px;">Plan</span>
                </a>
            </li>
            @endif
            @if (in_array("3", $ManuName))
            <li class="{{ Request::segment(2) == 'agreement' ? 'active' : '' }}">
                <a href="{{ url('admin/agreement') }}">
                    <i class="fa fa-gavel"></i>

                    <span class="nav-label">Agreement</span>
                </a>
            </li>
            @endif
            @if(count(array_intersect($ResumeArray, $ManuName)) > 0)
            <li class="{{ Request::segment(2) == 'resume' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-file"></i>

                    <span class="nav-label">Resume</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                @if (in_array("4", $ManuName))
                <li class="{{ (Request::segment(2) == 'resume' && Request::segment(3) == '') || (Request::segment(2) == 'resume' && Request::segment(3) == 'add-resume') ? 'active' : '' }}">
                <a href="{{ url('admin/resume') }}">
                    <i class="fa fa-file"></i>
                    <span class="nav-label">Resume List</span>
                </a>
                </li>
            @endif

                @if (in_array("26", $ManuName))
                    <li class="{{ Request::segment(3) == 'delete-resumes' ? 'active' : '' }}">
                        <a href="{{ url('admin/resume/delete-resumes') }}">
                            <i class="fa fa-file"></i>

                            <span class="nav-label">Multiple Delete</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if(count(array_intersect($ResumeDetailArray, $ManuName)) > 0)
            <li class="{{ Request::segment(2) == 'resumedetails' ? 'active' : '' }}{{ Request::segment(2) == 'resumedetailsubmit' ? 'active' : '' }}{{ Request::segment(2) == 'pass' ? 'active' : '' }}{{ Request::segment(2) == 'fail' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span class="fa arrow"></span>
                    <span class="nav-label">Resume Details</span>
                </a>
                <ul class="nav nav-second-level collapse">
                @if (in_array("6", $ManuName))
                    <li class="{{ Request::segment(2) == 'resumedetailsubmit' ? 'active' : '' }}">
                        <a href="{{ route('submit') }}">
                            <i class="fa fa-file"></i>
                            <span class="nav-label">Not Submitted</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("5", $ManuName))
                    <li class="{{ Request::segment(2) == 'resumedetails' ? 'active' : '' }}">
                        <a href="{{ route('notsubmit') }}">
                            <i class="fa fa-file"></i>
                            <span class="nav-label">Submitted</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("7", $ManuName))
                    <li class="{{ Request::segment(2) == 'pass' ? 'active' : '' }}">
                        <a href="{{url('admin/pass')}}">
                            <i class="fa fa-file"></i>
                            <span class="nav-label">Pass</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("8", $ManuName))
                    <li class="{{ Request::segment(2) == 'fail' ? 'active' : '' }}">
                        <a href="{{url('admin/fail')}}">
                            <i class="fa fa-file"></i>
                            <span class="nav-label">Fail</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (in_array("9", $ManuName))
            <li class="{{ Request::segment(2) == 'customer-helpline' ? 'active' : '' }}">
                <a href="{{ url('admin/customer-helpline') }}">
                    <i class="fa fa-question-circle"></i>

                    <span class="nav-label">Customer Helpline</span>
                </a>
            </li>
            @endif
            @if (in_array("10", $ManuName))
            <li class="{{ Request::segment(2) == 'franchisee' ? 'active' : '' }}">
                <a href="{{ url('admin/franchisee') }}">
                    <i class="fa fa-globe"></i>

                    <span class="nav-label">Franchisee</span>
                </a>
            </li>
            @endif
            @if (in_array("11", $ManuName))
            <li class="{{ Request::segment(2) == 'caller' ? 'active' : '' }}">
                <a href="{{ url('admin/caller') }}">
                    <i class="fa fa-phone"></i>

                    <span class="nav-label">Caller</span>
                </a>
            </li>
            @endif

            @if(count(array_intersect($RegistrationArray, $ManuName)) > 0)
            <li class="{{ Request::segment(2) == 'client' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Registration</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                @if (in_array("12", $ManuName))
                    <li class="{{ Request::segment(2) == 'client' && Request::segment(3) == '' ? 'active' : '' }}">
                        <a href="{{ url('admin/client') }}">
                            <i class="fa fa-user"></i>
                            <span class="nav-label">Registration List</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("13", $ManuName))
                    <li class="{{ Request::segment(3) == 'add-client' ? 'active' : '' }}">
                        <a href="{{ url('admin/client/add-client') }}">
                            <i class="fa fa-user"></i>

                            <span class="nav-label">Add Registration</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("14", $ManuName))
                    <li class="{{ Request::segment(3) == 'delete-clients' ? 'active' : '' }}">
                        <a href="{{ url('admin/client/delete-clients') }}">
                            <i class="fa fa-user"></i>

                            <span class="nav-label">Multiple Delete</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("15", $ManuName))
                    <li class="{{ Request::segment(3) == 'pending' ? 'active' : '' }}">
                        <a href="{{ url('admin/client/pending') }}">
                            <i class="fa fa-user"></i>

                            <span class="nav-label">Pending</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("16", $ManuName))
                    <li class="{{ Request::segment(3) == 'approve' ? 'active' : '' }}">
                        <a href="{{ url('admin/client/approve') }}">
                            <i class="fa fa-user"></i>

                            <span class="nav-label">Approve</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("17", $ManuName))
                    <li class="{{ Request::segment(3) == 'disapprove' ? 'active' : '' }}">
                        <a href="{{ url('admin/client/disapprove') }}">
                            <i class="fa fa-user"></i>

                            <span class="nav-label">Deactivate</span>
                        </a>
                    </li>
                    @endif
                    @if (in_array("18", $ManuName))
                    <li class="{{ Request::segment(3) == 'acive-users' ? 'active' : '' }}">
                        <a href="{{ url('admin/client/acive-users') }}">
                            <i class="fa fa-user"></i>

                            <span class="nav-label">Active Users</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if(count(array_intersect($SubAdminArray, $ManuName)) > 0)
            <li class="{{ Request::segment(2) == 'sub-admin' ? 'active' : '' || Request::segment(2) == 'add-sub-admin' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="fa arrow"></span>
                    <span class="nav-label">Sub Admin</span>
                </a>

                <ul class="nav nav-second-level collapse">
                    @if (in_array("27", $ManuName))
                    <li class="{{ Request::segment(2) == 'sub-admin' ? 'active' : '' }}">
                        <a href="{{ url('admin/sub-admin') }}">
                            <i class="fa fa-user"></i>
                            <span class="nav-label">Sub Admin List</span>
                        </a>
                    </li>
                    @endif

                    @if (in_array("28", $ManuName))
                    <li class="{{ Request::segment(2) == 'add-sub-admin' ? 'active' : '' }}">
                        <a href="{{ url('admin/add-sub-admin') }}">
                            <i class="fa fa-user"></i>
                            <span class="nav-label">Add Sub Admin</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (in_array("19", $ManuName))
            <li class="{{ Request::segment(2) == 'customer-care' ? 'active' : '' }}">
                <a href="{{ url('admin/customer-care') }}">
                    <i class="fa fa-mobile"></i>

                    <span class="nav-label">Customer Care</span>
                </a>
            </li>
            @endif
            @if (in_array("20", $ManuName))
            <li class="{{ Request::segment(2) == 'date-extension' ? 'active' : '' }}">
                <a href="{{ url('admin/date-extensions') }}">
                    <i class="fa fa-info"></i>

                    <span class="nav-label">Date Extension</span>
                </a>
            </li>
            @endif
            @if (in_array("21", $ManuName))
            <li class="{{ Request::segment(2) == 'nocs' ? 'active' : '' }}">
                <a href="{{ url('admin/noc') }}">
                    <i class="fa fa-info"></i>

                    <span class="nav-label">Noc</span>
                </a>
            </li>
            @endif
            @if (in_array("22", $ManuName))
            <li class="{{ Request::segment(2) == 'report' ? 'active' : '' }}">
                <a href="{{ url('admin/report') }}">
                    <i class="fa fa-info"></i>

                    <span class="nav-label">Report</span>
                </a>
            </li>
            @endif
            @if (in_array("23", $ManuName))
            <li class="{{ Request::segment(2) == 'warning-mail' ? 'active' : '' }}">
                <a href="{{ url('admin/warning-mail') }}">
                    <i class="fa fa-envelope"></i>

                    <span class="nav-label">Warning Mail</span>
                </a>
            </li>
            @endif
            @if (in_array("24", $ManuName))
            <li class="{{ Request::segment(2) == 'image' ? 'active' : '' }}">
                <a href="{{ url('admin/image') }}">
                    <i class="fa fa-picture-o"></i>

                    <span class="nav-label">Payment Image</span>
                </a>
            </li>
            @endif
            @if (in_array("25", $ManuName))
            <li class="{{ Request::segment(2) == 'client-log' ? 'active' : '' }}">
                <a href="{{ url('admin/client-log') }}">
                    <i class="fa fa-history"></i>

                    <span class="nav-label">Client Log</span>
                </a>
            </li>
            @endif
            @if (in_array("29", $ManuName))
            <li class="{{ Request::segment(2) == 'excel-download' ? 'active' : '' }}">
                <a href="{{ url('admin/excel-download') }}">
                    <i class="fa fa-file-excel-o"></i>

                    <span class="nav-label">Excel Download</span>
                </a>
            </li>
            @endif
            @if (in_array("30", $ManuName))
            <li class="{{ Request::segment(2) == 'invoice-generator' ? 'active' : '' }}">
                <a href="{{ url('admin/invoice-generator') }}">
                    <i class="fa fa-file-excel-o"></i>

                    <span class="nav-label">Invoice Generator</span>
                </a>
            </li>
            @endif
            @if (in_array("31", $ManuName))
            <li class="{{ Request::segment(2) == 'remark' ? 'active' : '' }}">
                <a href="{{ url('admin/remark') }}">
                    <i class="fa fa-file-excel-o"></i>

                    <span class="nav-label">Remark</span>
                </a>
            </li>
            @endif
            @if (in_array("32", $ManuName))
            <li class="{{ Request::segment(2) == 'payment-mail' ? 'active' : '' }}">
                <a href="{{ url('admin/payment-mail') }}">
                    <i class="fa fa-envelope"></i>
                    <span class="nav-label">Payment Mail</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</nav>
