@extends('layouts.app')

@section('content')
    <style>
        .tagify {
            width: 100%;
        }

        .form-group-tag {
            display: flex;
            flex-direction: column;
        }

        .map-show {
            display: none;
        }
    </style>

    <div class="container">
        <section class="content">
            <form method="POST" action="{{ route('update-post', $post->id) }}" aria-label="Edit Post" enctype="multipart/form-data">
                @csrf
                <div>
                    <div>
                        <h2 class="box-title">Сторінка редагування оголошення</h2>
                        @include('layouts.errors')
                    </div>
                    <hr/>
                    <div>
                        <div class="form-group">
                            <label>Заголовок</label>
                            <input type="text" class="form-control" name="title" placeholder="" value="{{old('title', $post->title)}}">
                        </div>
                        <div class="form-group">
                            <label>Тип оголошення</label>
                            <select name="post_type" class="form-select">
                                <option value="1" @if (old('post_type', $post->post_type) === 1) {{ 'selected' }} @endif>Пропозиція</option>
                                <option value="0" @if (old('post_type', $post->post_type) === 0) {{ 'selected' }} @endif>Потреба</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Тип допомоги</label>
                            <input name="tagify" id="tagify" value='{!! old('tagify', $post->tagify) !!}'>
                        </div>
                        <div class="form-group">
                            <label>Опис</label>
                            <input type="text" class="form-control" name="description" placeholder="" value="{{old('description', $post->description)}}">
                        </div>
                        <div class="form-group">
                            <label>Чи потрібна карта?</label>
                            <input type="checkbox" name="is_map" {{ !!$post->is_map ? 'checked' : '' }}>
                        </div>
                        <div class="form-group" id="map-div">
                            <label>Карта з місцем</label>
                            <div id="map"></div>
                        </div>
                        <div class="form-group">
                            <input id="map_long" type="hidden" class="form-control" name="map_long" placeholder="" value="{{old('map_long', $post->map_long)}}">
                        </div>
                        <div class="form-group">
                            <input id="map_lat" type="hidden" class="form-control" name="map_lat" placeholder="" value="{{old('map_lat', $post->map_lat)}}">
                        </div>
                        <div class="form-group">
                            <label>Контакти</label>
                            <input class="form-control" name="contact_info" placeholder="" value="{{old('contact_info', $post->contact_info)}}">
                        </div>
                        @if ($post->image_link)
                            <img src="{{ asset('images/' . $post->image_link) }}" alt="{{ $post->image_link }}" class="mt-2 img-fluid" style="max-width: 200px;">
                        @endif
                        <div class="form-group">
                            <label for="image_link">Нове фото</label>
                            <input type="file" name="image_link" class="form-control-file">
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-success pull-right">Зберегти оголошення</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@push('js')
    <script>
        var input = document.querySelector('#post_tags'),
            tagify = new Tagify(input, {
                id: 'post_tags'
            });

        function getDistance(p1, p2) {
            let R = 6378137;
            let dLat = rad(p2.lat - p1.lat);
            let dLong = rad(p2.lng - p1.lng);
            let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
                Math.sin(dLong / 2) * Math.sin(dLong / 2);
            let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            let d = R * c;
            return d;
        }

        function rad(x) {
            return x * Math.PI / 180;
        }

        window.onload = function() {
            if(!$('input[name=is_map]').is(":checked")){
                $('#map-div').addClass('map-show');
            }

            var centerLat = {{ $post->map_lat ?? '50.619585' }};
            var centerLong = {{ $post->map_long ?? '26.248195' }};
            let marker;
            let mapLongInput = document.getElementById('map_long');
            let mapLatInput = document.getElementById('map_lat');
            var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
                osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                osm = L.tileLayer(osmUrl, {
                    maxZoom: 18,
                    attribution: osmAttrib
                });

            // initialize the map on the "map" div with a given center and zoom
            var map = L.map('map').setView([centerLat, centerLong], 15).addLayer(osm);
            let circle = L.circle([centerLat, centerLong], {
                color: 'green',
                fillColor: 'yellow',
                fillOpacity: 0.08,
                radius: 15000
            }).addTo(map);
            marker = L.marker([centerLat, centerLong]).addTo(map);
            document.getElementById('map_lat').value = centerLat;
            document.getElementById('map_long').value = centerLong;
            map.on('click', function(e){
                let center = {
                    lat: centerLat,
                    lng: centerLong,
                }
                let point = {
                    lat: e.latlng.lat,
                    lng: e.latlng.lng,
                }

                if(getDistance(center, point) <= 15000) {
                    if (marker) {
                        marker.remove()
                    }
                    marker = L.marker(e.latlng).addTo(map);
                    document.getElementById('map_lat').value = point.lat;
                    document.getElementById('map_long').value = point.lng;
                }
            });
        }

        $('input[name=is_map]').on('change', function() {
            if (this.checked) {
                $('#map-div').removeClass('map-show');
            } else {
                $('#map-div').addClass('map-show');
            }
        });

    </script>
@endpush

