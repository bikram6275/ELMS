@extends('backend.layouts.app')
@section('title')
    Map View
@endsection
@section('content')
@inject('pradesh_helper','App\Helpers\PradeshHelper')
@inject('district_helper','App\Helpers\DistrictHelper')
    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }
    </style>

    <style>
        #map {
            width: 100%;
            height: 50vh;
        }
        .leaflet-container {
            height: 50vh !important;
  background: rgb(175, 175, 175);
}
.leaflet-tooltip-own {
    position: absolute;
    padding: 4px;
    background:transparent;
    border: 0px solid transparent;
    color: #000;
    white-space: nowrap;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    pointer-events: none;
    box-shadow: 0 0px 0px rgba(0,0,0,0.4);
}
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                Filter
                            </div>
                            <div class="card-body">
                                {{-- {!! Form::open(['method'=>'post','url'=>'enumeratorassign','enctype'=>'multipart/form-data','file'=>true]) !!} --}}
                                {!! Form::open(['method' => 'get', route('organization.index'), 'enctype' => 'multipart/form-data', 'file' => true]) !!}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                            {{ Form::select('pradesh_id', $pradesh_helper->dropdown(), Request::get('pradesh_id'), ['class' => 'form-control select2','id' => 'pradesh_id','name' => 'pradesh_id','placeholder' => 'Select Pradesh']) }}
                                            {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                            {{ Form::select('district_id', $district_helper->dropdown(), Request::get('district_id'), ['class' => 'form-control select2','id' => 'district_id','name' => 'district_id','placeholder' => 'Select District']) }}
                                            {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info " id="assign_button"><i
                                                    class="fa fa-search"></i>Filter
                                            </button>
                                            <a href="{{ url('map/') }}" class="btn btn-warning "><i
                                                    class="fa fa-refresh"></i> Refresh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Map View</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard  </a></li>
                            <li> / MapView</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
       <section class="content">
        <div id='map'></div>
       </section>
    </div>
    @push('custom-scripts')
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
        <script type="text/javascript" src="{{ asset('js/map/province.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province1-district.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province2-district.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province3-district.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province4-district.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province5-district.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province6-district.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/map/province7-district.js') }}"></script>

        <script type="text/javascript">
            var provinceMap, provinceGeoJson, stateGeoJson;
            /**
             **  Initialize map
             **/
            provinceMap = L.map('map', {
                scrollWheelZoom: true,
                touchZoom: false,
                doubleClickZoom: true,
                zoomControl: true,
                dragging: true
            }).setView([28.3949, 84.1240], 8);


            /**
             **  GeoJSON data
             **/
            provinceGeoJson = L.geoJson(provinceData, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(provinceMap);

            var bound = provinceGeoJson.getBounds();
            provinceMap.fitBounds(bound);
            provinceGeoJson.eachLayer(function(layer) {
                    layer.bindTooltip(layer.feature.properties.Province_Name, {
                        permanent: true,
                        direction: "center",
                        opacity: 0.75,
                        className: 'leaflet-tooltip-own' 

                    }).openTooltip()
                });
            /**
             *  Functions for map
             **/
            function style(feature) {
                return {
                    weight: 2,
                    opacity: 1,
                    color: '#FFF',
                    dashArray: '1',
                    fillOpacity: 0.7,
                    fillColor: getProvinceColor(feature.properties.Province),
                };
            }

            function highlightFeature(e) {
                var layer = e.target;

                layer.setStyle({
                    weight: 2,
                    color: 'black',
                    dashArray: '',
                    fillOpacity: 0.7,
                    fillColor: '#fff'
                });

                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                    layer.bringToFront();
                }
            }

            function getProvinceColor(province) {
                switch (province) {
                    case 1:
                        return 'red';
                        break;
                    case 2:
                        return 'green';
                        break;
                    case 3:
                        return 'blue';
                        break;
                    case 4:
                        return 'lightblue';
                        break;
                    case 5:
                        return 'lightgreen';
                        break;
                    case 6:
                        return 'yellow';
                        break;
                    case 7:
                        return 'orange';
                        break;
                    default:
                        return 'skyblue';
                        break;
                }
            }

            function resetHighlight(e) {
                provinceGeoJson.resetStyle(e.target);
                // info.update();
            }

            function zoomToProvince(e) {
                var json,
                    province_number = e.target.feature.properties.Province;

                provinceMap.fitBounds(e.target.getBounds());
                console.log(stateGeoJson);

                if (stateGeoJson != undefined) {
                    stateGeoJson.clearLayers();
                }

                switch (province_number) {
                    case 1:
                        json = province_1;
                        break;
                    case 2:
                        json = province_2;
                        break;
                    case 3:
                        json = province_3;
                        break;
                    case 4:
                        json = province_4;
                        break;
                    case 5:
                        json = province_5;
                        break;
                    case 6:
                        json = province_6;
                        break;
                    case 7:
                        json = province_7;
                        break;
                    default:
                        json = '';
                        break;
                }
                // provinceMap.removeLayer(stateGeoJson);

                stateGeoJson = L.geoJson(json, {
                    style: style,
                    onEachFeature: onEachFeature
                }).addTo(provinceMap);

                // provinceMap.removeLayer(stateGeoJson);

                stateGeoJson.eachLayer(function(layer) {
                    layer.bindTooltip(layer.feature.properties.DISTRICT, {
                        permanent: true,
                        direction: "center"
                    }).openTooltip()
                });
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToProvince
                });
            }

            /**
             **  Markers example
             **/
            var sites = {!! json_encode($model->toArray()) !!};

            for (var i = 0; i < sites.length; i++) {
                var marker = L.marker([sites[i].latitude, sites[i].longitude]).addTo(provinceMap);
                marker.bindPopup(sites[i].organization.org_name);
            }
        </script>
    @endpush

< @endsection
