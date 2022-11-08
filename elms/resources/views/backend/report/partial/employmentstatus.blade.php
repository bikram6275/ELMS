<div class="col-md-12 card" style="overflow-x: scroll">
    <div class="card-body">
        <div class="table-responsive my-3">
            <table class="table table-striped ">
                <thead class="text-center">
                    <tr class="">
                        <th rowspan="2" style="vertical-align: middle">
                            Occupation</th>
                        <th>Currently working numbers</th>
                        <th>Currently Required Number</th>
                        <th>Estimated Required For next two Years
                        </th>
                        <th>Estimated Required For next five Years
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($organizations as $key => $organization)
                        <tr>
                            <td>{{ $occupation[$organization->occupation_id] }}
                            </td>
                            <td>{{ $organization->working_number }}
                            </td>
                            <td>{{ $organization->required_number }}
                            </td>
                            <td>{{ $organization->for_two_years }}
                            </td>
                            <td>
                                {{ $organization->for_five_years }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12 card" style="overflow-x: scroll">
    <div class="card-body">
        <div class="table-responsive my-3">
            <table class="table table-striped table-bordered">
                <thead class="text-center">
                    <tr class="">
                        <th rowspan="2" style="vertical-align: middle">
                            Occupation</th>
                        <th colspan="4">Currently working numbers</th>
                        <th colspan="4">Currently Required Number</th>
                        <th colspan="4">Estimated Required For next two Years
                        </th>
                        <th colspan="4">Estimated Required For next five Years
                        </th>
                    </tr>
                    <tr>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Avg</th>
                        <th>SD</th>

                        <th>Min</th>
                        <th>Max</th>
                        <th>Avg</th>
                        <th>SD</th>

                        <th>Min</th>
                        <th>Max</th>
                        <th>Avg</th>
                        <th>SD</th>

                        <th>Min</th>
                        <th>Max</th>
                        <th>Avg</th>
                        <th>SD</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($organizations as $key => $organization)
                        <tr>
                            <td>{{ $occupation[$organization->occupation_id] }}
                            </td>
                            <td>{{ $organization->min_working_number }}
                            </td>
                            <td>{{ $organization->max_working_number }}
                            </td>
                            <td>{{ round($organization->avg_working_number,2) }}
                            </td>
                            <td>{{ round($organization->std_working_number,2) }}
                            </td>

                            <td>{{ $organization->min_required_number }}
                            </td>
                            <td>{{ $organization->max_required_number }}
                            </td>
                            <td>{{ round($organization->avg_required_number,2) }}
                            </td>
                            <td>{{ round($organization->std_required_number,2) }}
                            </td>

                            <td>{{ $organization->min_for_two_years }}
                            </td>
                            <td>{{ $organization->max_for_two_years }}
                            </td>
                            <td>{{ round($organization->avg_for_two_years) }}
                            </td>
                            <td>{{ round($organization->std_for_two_years) }}
                            </td>

                            <td>{{ $organization->min_for_five_years }}
                            </td>
                            <td>{{ $organization->max_for_five_years }}
                            </td>
                            <td>{{ round($organization->avg_for_five_years) }}
                            </td>
                            <td>{{ round($organization->std_for_five_years) }}
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12 card" style="overflow-x: scroll">
    <div class="card-body">
        <div class="table-responsive my-3">
            <table class="table table-striped table-bordered">
                <thead class="text-center">
                    <tr class="">
                        <th rowspan="2" style="vertical-align: middle">
                            Occupation</th>
                        <th colspan="3">Currently working numbers</th>
                        <th colspan="3">Currently Required Number</th>
                        <th colspan="3">Estimated Required For next two Years
                        </th>
                        <th colspan="3">Estimated Required For next five Years
                        </th>
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
                    </tr>
                </thead>

                <tbody>
                   
                    @foreach ($organ as $key => $organization)
                        <tr>
                            <td>{{ $occupation[$key] }}</td>

                            <td>{{ $organization['working_q1'] }}</td>
                            <td>{{ $organization['working_q2'] }}</td>
                            <td>{{ $organization['working_q3'] }}</td>

                            <td>{{ $organization['required_q1'] }}</td>
                            <td>{{ $organization['required_q2'] }}</td>
                            <td>{{ $organization['required_q3'] }}</td>

                            <td>{{ $organization['for_two_years_q1'] }}</td>
                            <td>{{ $organization['for_two_years_q2'] }}</td>
                            <td>{{ $organization['for_two_years_q3'] }}</td>

                            <td>{{ $organization['for_five_years_q1'] }}</td>
                            <td>{{ $organization['for_five_years_q2'] }}</td>
                            <td>{{ $organization['for_five_years_q3'] }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>