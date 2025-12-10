<?php
function calculate_linear_regression($data) {
    $n = count($data);
    if ($n < 2) {
        return null; 
    }

    $numeric_data = [];
    foreach ($data as $point) {
        $timestamp = strtotime($point->fecha);
        if ($timestamp !== false) {
             $numeric_data[] = ['x' => $timestamp, 'y' => (float)$point->precio];
        }
    }
    
    $n = count($numeric_data);
    if ($n < 2) {
        return null;
    }

    $sum_x = 0; $sum_y = 0; $sum_xy = 0; $sum_x2 = 0;

    foreach ($numeric_data as $point) {
        $sum_x += $point['x'];
        $sum_y += $point['y'];
        $sum_xy += $point['x'] * $point['y'];
        $sum_x2 += $point['x'] * $point['x'];
    }

    $denominator = ($n * $sum_x2 - $sum_x * $sum_x);
    if ($denominator == 0) {
        return null;
    }

    $slope = ($n * $sum_xy - $sum_x * $sum_y) / $denominator;
    $intercept = ($sum_y - $slope * $sum_x) / $n;

    $last_point = end($numeric_data);
    $future_x = $last_point['x'] + (7 * 24 * 60 * 60);
    $predicted_price = $slope * $future_x + $intercept;

    $future_date_str = date('d/m/Y', $future_x);

    return [
        'date' => $future_date_str,
        'price' => round($predicted_price, 2)
    ];
}
