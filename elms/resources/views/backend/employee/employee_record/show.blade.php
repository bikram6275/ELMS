{{--{{dd($employee)}}--}}
@extends('backend.layouts.app')
@section('title')
    Employee
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('backend.message.flash')
                <div class="row">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Employee</h3>

                                <a href="{{url('/orgs/employeeRecord/create')}}" class="pull-right cardTopButton" id="add"
                                   data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                                                            style="font-size: 20px;"></i></a>
                                <a href="{{url('/orgs/employeeRecord')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">

                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>{{$employee->employee_name}}</strong></h3>

                                </div>
                                <div class="tab-content">
                                    <div class="active">
                                        <div class="box-body box-profile">

                                            <div class="post">
                                                <table class="table table-bordered table-responsive table-hover">
                                                    <tr>
                                                        <td>Employee Type</td>
                                                        <td>
                                                            {{$employee->employeeType->name??null}}
                                                        </td>
                                                        </tr>
                                                    <tr>
                                                        <td>Date of Birth</td>
                                                        <td>
                                                            {{$employee->date_of_birth??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td>
                                                            {{$employee->genders->name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Marital Status</td>
                                                        <td>
                                                            {{$employee->marital_status??null}}
                                                        </td>
                                                    </tr>
                                                    @if($employee->marital_status=='married')
                                                    <tr>
                                                        <td>Spouse Name</td>
                                                        <td>
                                                            {{$employee->spouse_name??null}}
                                                        </td>
                                                    </tr>
                                                        <tr>
                                                            <td>No of children</td>
                                                            <td>
                                                                {{$employee->no_of_children??null}}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>Permanent Pradesh Name</td>
                                                        <td>
                                                            {{$employee->pradeshPer->pradesh_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Permanent District</td>
                                                        <td>{{$employee->districtPer->english_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Permanent Municipality</td>
                                                        <td>{{$employee->municipalityPer->muni_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Permanent Ward</td>
                                                        <td>{{$employee->permanent_ward_no??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td> Contact Pradesh Name</td>
                                                        <td>
                                                            {{$employee->pradesh->pradesh_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact District</td>
                                                        <td>{{$employee->district->english_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact Municipality</td>
                                                        <td>{{$employee->municipality->muni_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact Ward</td>
                                                        <td>{{$employee->ward_no??null}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Father Name</td>
                                                        <td>{{$employee->father_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mother Name:</td>
                                                        <td>
                                                            {{$employee->mother_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grand Father</td>
                                                        <td>
                                                            {{$employee->grand_father_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>{{$employee->phone_no??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{$employee->email??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobile No.</td>
                                                        <td>{{$employee->mobile_no??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>First Entry Position</td>
                                                        <td>{{$employee->first_entry_position??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Level</td>
                                                        <td>{{$employee->level??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Promoted Level</td>
                                                        <td>{{$employee->promoted_level??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Present Position</td>
                                                        <td>{{$employee->present_position??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Immediate Promoted Date</td>
                                                        <td>{{$employee->immediate_promoted_date??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Working Hours/Days Per Week</td>
                                                        <td>{{$employee->working_hour_per_week??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Working Hours/Days Month</td>
                                                        <td>{{$employee->working_hour_per_days_in_month??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Promoted Level</td>
                                                        <td>{{$employee->promoted_level??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Education Type</td>
                                                        <td>{{$employee->edu->eduType[0]->name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Education Level</td>
                                                        <td>{{$employee->edu->eduLevel[0]->level??null}}</td>
                                                    </tr>
                                                </table>

                                                @if($orgRecs->count()!=0)
                                                    <h3 class="box-title"><strong>Records of Previous Organisation/s </strong></h3>
                                                <table  class="table table-striped table-bordered table-hover table-responsive">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                        <th>Organization Name</th>
                                                        <th>Last Position </th>
                                                        <th>Total Experience Year </th>

                                                        <th>Total experience Month</th>


                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 1;?>
                                                    @foreach($orgRecs as $key=>$orgRec)
                                                        <tr>

                                                            <th scope=row>{{$i}}</th>
                                                            <td>{{$orgRec->organization_name??null}}</td>
                                                            <td>{{$orgRec->last_position??null}}</td>
                                                            <td>{{$orgRec->total_experience_year??null}}</td>
                                                            <td>{{$orgRec->total_experience_month??null}}</td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                @endif

                                                @if($empAwards->count()!=0)
                                                    <h3 class="box-title"><strong>Awards</strong></h3>
                                                    <table  class="table table-striped table-bordered table-hover table-responsive">
                                                        <thead>
                                                        <tr>

                                                            <th>Number of Grade Earned</th>
                                                            <th>Number of Promotion Received </th>
                                                            <th>Appreciation Letter </th>

                                                            <th>Employee of Year</th>


                                                        </thead>
                                                        <tbody>

                                                        @foreach($empAwards as $key=>$empAward)
                                                            <tr>


                                                                <td>{{$empAward->grade_earned??null}}</td>
                                                                <td>{{$empAward->promotion_received??null}}</td>
                                                                @if($empAward->appreciation_letter=='1')
                                                                <td>Yes</td>
                                                                @else
                                                                    <td>No</td>
                                                                @endif
                                                                @if($empAward->employee_of_yr=='1')
                                                                    <td>Yes</td>
                                                                @else
                                                                    <td>No</td>
                                                                @endif
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif

                                                @if($empleaves->count()!=0)
                                                    <h3 class="box-title"><strong>Leaves</strong></h3>
                                                    <table  class="table table-striped table-bordered table-hover table-responsive">
                                                        <thead>
                                                        <tr>

                                                            <th>Year</th>
                                                            <th>Leave Type</th>
                                                            <th>Leave </th>
                                                            <th>Leave (Days Spent):</th>
                                                        </tr>

                                                        </thead>
                                                        <tbody>

                                                        @foreach($empleaves as $key=>$employee_leave)
                                                            <tr>
                                                                <td>{{$employee_leave->fiscal->fy_name}}</td>
                                                                <td>{{$employee_leave->leaveType->leave_type}}</td>
                                                                <td>{{$employee_leave->paid_leave}}</td>
                                                                <td>{{$employee_leave->paid_leave_used}}</td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                                @if($empPunishments->count()!=0)
                                                    <h3 class="box-title"><strong>Punishment</strong></h3>
                                                    <table  class="table table-striped table-bordered table-hover table-responsive">
                                                        <thead>
                                                        <tr>

                                                            <th>Number of Defense Letter Received</th>
                                                            <th>Grade deduction Records </th>
                                                            <th>De promoted Records </th>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($empPunishments as $key=>$empPunishment)
                                                            <tr>


                                                                <td>{{$empPunishment->defence_letter_received??null}}</td>

                                                                @if($empPunishment->de_promoted=='1')
                                                                    <td>Yes</td>
                                                                @else
                                                                    <td>No</td>
                                                                @endif
                                                                @if($empPunishment->grade_deducted=='1')
                                                                    <td>Yes</td>
                                                                @else
                                                                    <td>No</td>
                                                                @endif
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                                @if($empExperiences->count()!=0)
                                                    <h3 class="box-title"><strong>Experience</strong></h3>
                                                    <table  class="table table-striped table-bordered table-hover table-responsive">
                                                        <thead>
                                                        <tr>
                                                            <th colspan="2">In the Present Organisation</th>
                                                            <th colspan="2">In the same Occupation </th>
                                                            <th colspan="2">At Present Position </th>
                                                            <th colspan="2">In Other Organisation </th>
                                                            <th colspan="2">Total Experience</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($empExperiences as $key=>$empExperience)
                                                            <tr>


                                                                <td>{{$empExperience->present_org_year??null}}</td>
                                                                <td>{{$empExperience->present_org_month??null}}</td>
                                                                <td>{{$empExperience->same_occu_year??null}}</td>
                                                                <td>{{$empExperience->same_occu_month??null}}</td>
                                                                <td>{{$empExperience->present_pos_year??null}}</td>
                                                                <td>{{$empExperience->present_pos_month??null}}</td>
                                                                <td>{{$empExperience->other_org_year??null}}</td>
                                                                <td>{{$empExperience->other_org_month??null}}</td>
                                                                <td>{{$empExperience->total_exp_year??null}}</td>
                                                                <td>{{$empExperience->total_exp_month??null}}</td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                                @if($empTrainings->count()!=0)
                                                    <h3 class="box-title"><strong>Trainings</strong></h3>
                                                    <table  class="table table-striped table-bordered table-hover table-responsive">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">Training Type</th>
                                                            <th colspan="2">Pre-Service Training Duration </th>
                                                            <th colspan="2">In-service Training Duration  </th>
                                                            <th rowspan="2">Others</th>

                                                        </tr>
                                                        <tr>

                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($empTrainings as $key=>$empTraining)
                                                            <tr>


                                                                <td>{{$empTraining->training_type??null}}</td>
                                                                <td>{{$empTraining->pre_service_yr??null}}</td>
                                                                <td>{{$empTraining->pre_service_month??null}}</td>
                                                                <td>{{$empTraining->in_service_yr??null}}</td>
                                                                <td>{{$empTraining->in_service_month??null}}</td>
                                                                <td>{{$empTraining->others??null}}</td>
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                                @if($empResponsibilitys->count()!=0)
                                                    <h3 class="box-title"><strong>Responsibility</strong></h3>
                                                    <table  class="table table-striped table-bordered table-hover table-responsive">
                                                        <thead>
                                                        <tr>

                                                            <th>Responsibility Type</th>
                                                            <th>Level  </th>
                                                            <th>Field </th>
                                                            <th>Present Working Section/s </th>
                                                            <th>Name of Immediate Supervisor </th>
                                                            <th>Name of Ultimate Supervisor </th>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($empResponsibilitys as $key=>$empResponsibility)
                                                            <tr>
                                                                <td>{{$empResponsibility->employeeResponsibilities->name??null}}</td>
                                                                <td>{{$empResponsibility->level??null}}</td>
                                                                <td>{{$empResponsibility->field??null}}</td>
                                                                <td>{{$empResponsibility->present_working_sector??null}}</td>
                                                                <td>{{$empResponsibility->name_of_supervisor??null}}</td>
                                                                <td>{{$empResponsibility->name_of_ultimate_supervisor??null}}</td>

                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
