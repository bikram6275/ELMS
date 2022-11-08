@extends('backend.layouts.app')
@section('title')
    Enumerator
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
                        <h1>Enumerator</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Enumerator</a></li>
                            <li class="breadcrumb-item active">Enumerator</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('backend.message.flash')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary ">
                                    <div class="container-fluid text-center">
                                            <img src="{{url('/uploads/images/dummyUser.gif')}}" alt="User Image" style="width: 150px;height: 150px;">
                                    </div>
                                    <br>
                                    <div class="box-header with-border text-center">
                                        <h3 class="box-title"><strong>{{$emitter->name}}</strong></h3>
                                    </div>
                                   <div class="container mt-4">
                                       <div class="active">
                                           <div class="box-body box-profile">
                                               <div class="">
                                                   <table class="table table-bordered table-responsive table-striped">
                                                       <tr>
                                                           <td width=50%>Pradesh Name</td>
                                                           <td>
                                                               {{$emitter->pradesh->pradesh_name??null}}
                                                           </td>
                                                       </tr>
                                                       <tr>
                                                           <td>District</td>
                                                           <td>{{$emitter->district->english_name??null}}</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Municipality</td>
                                                           <td>{{$emitter->municipality->muni_name??null}}</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Ward</td>
                                                           <td>{{$emitter->ward_no??null}}</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Phone</td>
                                                           <td>{{$emitter->phone_no??null}}</td>
                                                       </tr>
                                                       <tr>
                                                           <td>Email</td>
                                                           <td>{{$emitter->email??null}}</td>
                                                       </tr>
                                                      
    
                                                   </table>
                                               </div>
    
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
