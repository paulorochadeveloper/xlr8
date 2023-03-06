<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xlr8 Hotels</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <h1>Hotels</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 mx-auto">
                    <form action="{{ route('hotels') }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="lat">Latitude:</label>
                                <input type="number" step="any"  name="lat" class="form-control" value="{{ app('request')->input('lat') }}" required/>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="long">Longitude:</label>
                                <input type="number" step="any"  name="long" class="form-control" value="{{ app('request')->input('long') }}" required/>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="range">Range Ray(km):</label>
                                <input type="number" name="range" min="0"  class="form-control" value="{{ app('request')->input('range') }}" required/>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="long">Sort:</label>
                                <select name="sort" class="form-control" >
                                    <option value="distance" {{ app('request')->input('sort') == 'distance' ? 'selected' : '' }}> Proximity</option>
                                    <option value="price"  {{ app('request')->input('sort') == 'price' ? 'selected' : '' }}> Price low</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <button type="submit"  class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
    </div>
    <div class="row">
        <div class="col-lg-9 mx-auto mt-5">
            @if(isset($fails))
                {{ $fails }}
            @else
            <ul class="list-group shadow">
                @foreach ($hotelsList as $product)
                    <li class="row mb-1 p-2 " style="border-bottom:1px solid #eee">
                        <div class="col-3 p-3">
                            <img src="https://picsum.photos/300/200" alt="{{ $product['hotel'] }}" width="200">
                        </div>
                        <div class="col-9 p-3">
                            <div class="media-body order-1 order-lg-1">
                                <h5 class="mt-0 font-weight-bold mb-2">{{ $product['hotel'] }}</h5>
                                <p class="font-italic text-muted mb-0 small">{{ $product['distance'] }} {{ $product['unit'] }}</p>
                                <div class="d-flex align-items-center justify-content-between mt-1" >
                                    <h6 class="font-weight-bold my-2">{{ $product['price'] }}  {{ $product['currency'] }}</h6>
                                    <button type="button" class="btn btn-primary" data-toggle="modal">
                                        Booking Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
                @endif
        </div>
    </div>
</div>
</body>
</html>
