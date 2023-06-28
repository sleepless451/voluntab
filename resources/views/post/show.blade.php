@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="content">
            <div>
                <div>
                    <h2>{{$post->title}}</h2>
                </div>
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-6">
                            @if ($post->image_link)
                            <div class="d-flex justify-content-center p-3" style="border: 2px solid  rgb(0 0 0 / 17%);">
                                <img src="{{ asset('images/' . $post->image_link) }}" alt="{{ $post->image_link }}" class="mt-2 img-fluid">
                            </div>
                            @endif
                            @if ($post->is_map)
                            <div class="form-group">
                                <label><strong>Мапа з місцем проведення заходу / зустрічі</strong></label>
                                <div id="map" style="width: 100%;"></div>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label><strong>Тип оголошення:</strong></label>
                                <p>{{$post->post_type ? 'Пропозиція' : 'Потреба'}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Тип допомоги:</strong></label>
                                <p>{{$post->tagify}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Опис:</strong></label>
                                <p>{{$post->description}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Контактний номер телефону:</strong></label>
                                <p>{{$post->contact_info}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script>
        window.onload = function() {

            var centerLat = 50.619585;
            var centerLong = 26.248195;
            let marker;
            let map_lat = {{$post->map_lat}};
            let map_long = {{$post->map_long}};
            var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                osm = L.tileLayer(osmUrl, {
                    maxZoom: 18,
                    attribution: osmAttrib
                });

            // initialize the map on the "map" div with a given center and zoom
            var map = L.map('map').setView([map_lat, map_long], 15).addLayer(osm);
            marker = L.marker([map_lat, map_long]).addTo(map);
        }
    </script>
@endpush


