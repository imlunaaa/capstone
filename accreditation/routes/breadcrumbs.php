<?php

use App\Models\Area;

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


// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});