<?php

use App\Helpers\ROC;

test('roc weighting method', function () {
    $weight = ROC::getWeight(1, 3);
    expect(round($weight, 4))->toBe(0.6111);

    $weight = ROC::getWeight(2, 3);
    expect(round($weight, 4))->toBe(0.2778);

    $weight = ROC::getWeight(3, 3);
    expect(round($weight, 4))->toBe(0.1111);
});
