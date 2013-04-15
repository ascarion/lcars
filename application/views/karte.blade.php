@layout('template')

@section('content')
<div id="map"></div>
@endsection

@section('topnav')
@endsection

@section('styles')
{{ Asset::container('leaflet')->styles(); }}
@endsection

@section('scripts')
{{ Asset::container('leaflet')->scripts(); }}
@endsection
