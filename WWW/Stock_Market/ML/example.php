<?php

require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Classification\KNearestNeighbors;
use Phpml\Regression\LeastSquares;


use Phpml\Classification\MLPClassifier;
use Phpml\NeuralNetwork\ActivationFunction\PReLU;
use Phpml\NeuralNetwork\ActivationFunction\Sigmoid;
use Phpml\NeuralNetwork\Layer;
use Phpml\NeuralNetwork\Node\Neuron;


$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2], [4, 2]];

$labels = ['1', '1', '0', '2', '2', '3', '1'];

$classifier = new KNearestNeighbors();
$classifier->train($samples, $labels);

echo $classifier->predict([3, 2]);
// return 'b'
echo "<br>";

$samples = [[60], [61], [62], [63], [65]];
$targets = [3.1, 3.6, 3.8, 4, 4.1];

$regression = new LeastSquares();
$regression->train($samples, $targets);

echo $regression->predict([64]);





$mlp = new MLPClassifier(4, [2], ['a', 'b', 'c']);

// 4 nodes in input layer, 2 nodes in first hidden layer and 3 possible labels.

$mlp = new MLPClassifier(4, [[2, new PReLU], [2, new Sigmoid]], ['a', 'b', 'c']);

$layer1 = new Layer(2, Neuron::class, new PReLU);
$layer2 = new Layer(2, Neuron::class, new Sigmoid);
$mlp = new MLPClassifier(4, [$layer1, $layer2], ['a', 'b', 'c']);

$mlp->train(
    $samples = [[1, 0, 0, 0], [0, 1, 1, 0], [1, 1, 1, 1], [0, 0, 0, 0]],
    $targets = ['a', 'a', 'b', 'c']
);

$mlp->partialTrain(
    $samples = [[1, 0, 0, 0], [0, 1, 1, 0]],
    $targets = ['a', 'a']
);
$mlp->partialTrain(
    $samples = [[1, 1, 1, 1], [0, 0, 0, 0]],
    $targets = ['b', 'c']
);

echo "<br>";


print_r(  $mlp->predict([[1, 1, 1, 1], [0, 0, 0, 0]]));
// return ['b', 'c'];