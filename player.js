angular.module('player', ['ngMaterial'])
.controller('Queue', function($scope, $http) {

	$http.get("api/player.php").then(function(response) {
        $fullQueue = response.data;
		console.log($fullQueue);
		$scope.nowPlaying = $fullQueue[0];
		$scope.queue = $fullQueue[1];
		console.log($scope.nowPlaying);
		console.log($scope.queue);
    });
});