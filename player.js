angular.module('player', ['ngMaterial'])
.controller('Song', ['$scope', function($scope) {
	$scope.title = 'Title';
	$scope.artist = 'Artist';
	$scope.album = 'Album';
	$scope.imagePath = 'img/noart.png';
}]);