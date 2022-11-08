<div class="card col-md-12" style=" overflow-x: scroll;">
    <div class="card-body">
        <div class="table-responsive my-3">
            <table class="table table-striped table-bordered table-hover" style="width:100%;">
                <thead class="text-center">
                    <tr>
                        <th colspan="2" rowspan="2" style="vertical-align: middle">Nature of
                            Human
                            Resources</th>
                        <th colspan="3">Gender</th>
                        <th colspan="3">Nationality</th>
                        <th rowspan="2" style="vertical-align: middle">
                            Total
                        </th>
                    </tr>
                    <tr>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Sexual Minority</th>
                        <th>Nepali</th>
                        <th>Neighboring Countries</th>
                        <th>Foreigner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizations as $key => $organization)
                        @foreach ($organization as $k => $value)
                            <tr>
                                @if ($loop->first)
                                    <td class="text-capitalize" rowspan="{{ count($organization) }}"
                                        style="vertical-align: middle">
                                        {{ $humanresources[$key] }}
                                    </td>
                                @endif

                                <td class="text-capitalize">
                                    {{ $k }}
                                </td>

                                <td>{{ $value[0]->male_count }}</td>
                                <td>{{ $value[0]->female_count }}
                                </td>
                                <td>{{ $value[0]->minority_count }}
                                </td>
                                <td>{{ $value[0]->nepali_count }}
                                </td>
                                <td>{{ $value[0]->neighboring_count }}
                                </td>
                                <td>{{ $value[0]->foreigner_count }}
                                </td>
                                <td>{{ $value[0]->total }}</td>

                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="card col-md-12" style=" overflow-x: scroll;">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover " style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th rowspan="3" style="vertical-align: middle">Nature of
                            Human
                            Resources</th>
                        <th colspan="12">Gender</th>
                        <th colspan="12">Nationality</th>
        
                    </tr>
                    <tr>
                        <th colspan="4">Male</th>
                        <th colspan="4">Female</th>
                        <th colspan="4">Sexual Minority</th>
                        <th colspan="4">Nepali</th>
                        <th colspan="4">Neighboring Countries</th>
                        <th colspan="4">Foreigner</th>
                    </tr>
                    <tr>
                        <th>Max</th>
                        <th>Min</th>
                        <th>Mean</th>
                        <th>SD</th>
                        
                        <th>Max</th>
                        <th>Min</th>
                        <th>Mean</th>
                        <th>SD</th>
        
                        <th>Max</th>
                        <th>Min</th>
                        <th>Mean</th>
                        <th>SD</th>
        
                        <th>Max</th>
                        <th>Min</th>
                        <th>Mean</th>
                        <th>SD</th>
        
                        <th>Max</th>
                        <th>Min</th>
                        <th>Mean</th>
                        <th>SD</th>
        
                        <th>Max</th>
                        <th>Min</th>
                        <th>Mean</th>
                        <th>SD</th>
        
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach ($organizations as $key => $organization)
                        @foreach ($organization as $k => $value)
                            <tr>
        
        
                                <td class="text-capitalize">
                                    {{ $k }}
                                </td>
        
                                <td>{{ $value[0]->max_male_count }}</td>
                                <td>{{ $value[0]->min_male_count }}</td>
                                <td>{{ $value[0]->avg_male_count }}</td>
                                <td>{{ round($value[0]->std_male_count) }}</td>
        
        
                                <td>{{ $value[0]->max_female_count }}</td>
                                <td>{{ $value[0]->min_female_count }}</td>
                                <td>{{ $value[0]->avg_female_count }}</td>
                                <td>{{ round($value[0]->std_female_count) }}</td>
        
        
                                <td>{{ $value[0]->max_minority_count }}</td>
                                <td>{{ $value[0]->min_minority_count }}</td>
                                <td>{{ $value[0]->avg_minority_count }}</td>
                                <td>{{ round($value[0]->std_minority_count) }}</td>
        
        
                                <td>{{ $value[0]->max_nepali_count }}</td>
                                <td>{{ $value[0]->min_nepali_count }}</td>
                                <td>{{ $value[0]->avg_nepali_count }}</td>
                                <td>{{ round($value[0]->std_nepali_count) }}</td>
        
                                <td>{{ $value[0]->max_neighboring_count }}</td>
                                <td>{{ $value[0]->min_neighboring_count }}</td>
                                <td>{{ $value[0]->avg_neighboring_count }}</td>
                                <td>{{ round($value[0]->std_neighboring_count) }}</td>
        
        
                                <td>{{ $value[0]->max_foreigner_count }}</td>
                                <td>{{ $value[0]->min_foreigner_count }}</td>
                                <td>{{ $value[0]->avg_foreigner_count }}</td>
                                <td>{{ round($value[0]->std_foreigner_count,2) }}</td>
        
        
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card col-md-12" style="overflow-x: scroll; ">
    <div class="card-body">
        <div class="table-responsive my-3">
            <table class="table table-striped table-bordered table-hover" style="width:100%">
                <thead class="text-center">
                    <tr>
                        <th rowspan="3" style="vertical-align: middle">Nature of
                            Human
                            Resources</th>
                        <th colspan="9">Gender</th>
                        <th colspan="9">Nationality</th>
            
                    </tr>
                    <tr>
                        <th colspan="3">Male</th>
                        <th colspan="3">Female</th>
                        <th colspan="3">Sexual Minority</th>
                        <th colspan="3">Nepali</th>
                        <th colspan="3">Neighboring Countries</th>
                        <th colspan="3">Foreigner</th>
                    </tr>
                    <tr>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($quartile) }} --}}
                    @foreach ($quartile  as $key => $organization)
                            <tr>
                                <td class="text-capitalize">
                                    {{ $key }}
                                </td>
                                <td>{{ $organization['male_q1']}}</td>
                                <td>{{ $organization['male_q2']}}</td>
                                <td>{{ $organization['male_q3']}}</td>
            
                                <td>{{ $organization['female_q1']}}</td>
                                <td>{{ $organization['female_q2']}}</td>
                                <td>{{ $organization['female_q3']}}</td>
            
                                <td>{{ $organization['minority_q1']}}</td>
                                <td>{{ $organization['minority_q2']}}</td>
                                <td>{{ $organization['minority_q3']}}</td>
            
                                <td>{{ $organization['nepali_q1']}}</td>
                                <td>{{ $organization['nepali_q2']}}</td>
                                <td>{{ $organization['nepali_q3']}}</td>
            
            
                                <td>{{ $organization['foreign_q1']}}</td>
                                <td>{{ $organization['foreign_q2']}}</td>
                                <td>{{ $organization['foreign_q3']}}</td>
            
            
                                <td>{{ $organization['neighbouring_q1']}}</td>
                                <td>{{ $organization['neighbouring_q2']}}</td>
                                <td>{{ $organization['neighbouring_q3']}}</td>
                            </tr>
                     
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>