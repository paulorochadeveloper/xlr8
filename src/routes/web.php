<?php

Route::get('/hotels', [\Rocha\Xlr8\Controllers\Search::class, 'getNearbyHotels'])->name('hotels');
