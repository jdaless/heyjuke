var app = angular.module('player', ['ngMaterial']);

app.controller('Queue', function($scope, $http, $interval) {
	$queueRefreshed = false;
	$scope.progress = 0;
	function refreshQueue(){
		$http.get("api/player.php").then(function(response) {
	        $fullQueue = response.data;
			$scope.nowPlaying = $fullQueue[0];
			$scope.queue = $fullQueue[1];
			$scope.started = $fullQueue[2];
			$queueRefreshed = true;
	    });
	}
	refreshQueue();
	$interval(function() {
		$time = new Date().getTime();
		if($queueRefreshed){
			$scope.progress = ($time - ($scope.started*1000)) / ($scope.nowPlaying.length*10);
		}
		else{
			$scope.progress = 101;
		}
		if($scope.progress>100  && $scope.nowPlaying.title != null){
			refreshQueue();
		}
	}, 100, 0, true);
});

app.controller('AddMenu', function($scope, $mdSidenav){
	$scope.openSideNav = function (){
		console.log('A thing happened')
	    $mdSidenav('left').open();
	}

});
