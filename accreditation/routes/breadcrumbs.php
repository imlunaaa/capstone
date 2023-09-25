<?php

use App\Models\Area;
use App\Models\Parameter;

// Instrument
Breadcrumbs::for('Instrument', function ($trail) {
    $trail->push('Instrument', route('instrument_list'));
});

// Instrument > [Areas]
Breadcrumbs::for('manage_areas', function ($trail, $id) {
    $trail->parent('Instrument');
    $trail->push('Areas', route('manage_areas', $id));
});

// Instrument > [Areas] > [Parameter]
Breadcrumbs::for('manage_parameter', function ($trail, $id) {
    $area = Area::select()->where('instrument_id', $id)->first();
    $trail->parent('manage_areas', $id);
    $trail->push('Parameter', route('manage_parameter', $id));
});

// Instrument > [Areas] > [Parameter] > [Indicator]
Breadcrumbs::for('view_indicator', function ($trail, $id) {
    $parameter = Parameter::select()->where('id', $id)->first();
    $trail->parent('manage_parameter', $parameter->area_id);
    $trail->push('Indicator', route('admin.view_indicator.index', $id));
});


