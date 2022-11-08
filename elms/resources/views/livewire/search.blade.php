<div class="card card-primary card-outline" style="overflow-x: scroll">
    <div class="card-header">
        <h3 class="card-title">
            Survey Status
        </h3>
        <div class="col-md-4 form-group">
            {!! Form::select('enumerator_id', [1,2], Request::get('enumerator_id'), ['class' => 'form-control select2', 'id' => 'enumerator_id', 'wire:model'=>'search','placeholder' => 'Select Enumerator']) !!}
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="row mt-4 mx-2">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>3>
                        <p>Total Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3></h3>
                        <p>Completed Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>}}</h3>
                        <p>In Progress Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>}}
                        </h3>
                        <p>Not Started Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 mx-2">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>}}</h3>
                        <p>Enumerator Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>}}</h3>
                        <p>Supervisor Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3> }}</h3>
                        <p>Coordiantor Survey</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3></h3>
                        <p>Feedback Provided</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a class="btn btn-sm btn-primary float-right" href="{{ route('survey_status.view') }}">
                View More</a>
        </div>
    </div>
</div>