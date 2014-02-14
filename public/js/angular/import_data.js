angular.module('OpenConnect', ['facebook'], 
    function($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    })
    .config([
        'FacebookProvider',
        function(FacebookProvider) {
            var myAppId = '562961157074755';
            FacebookProvider.init(myAppId);    
        }
    ])
  
    .controller('MainController', [
        '$scope',
        '$timeout',
        '$http',
        'Facebook',
        function($scope, $timeout, $http, Facebook) {

            // Define user empty data :/
            $scope.user = {};

            // Defining user logged status
            $scope.logged = false;

            // And some fancy flags to display messages upon user status change
            $scope.byebye = false;
            $scope.salutation = false;

            $scope.isGeneratingKeyword = false ;
            $scope.isGeneratingKeywordRank = false ;

            /**
            * Watch for Facebook to be ready.
            * There's also the event that could be used
            */
            $scope.$watch(
            function() {
              return Facebook.isReady();
            },
            function(newVal) {
              if (newVal)
                $scope.facebookReady = true;
            }
            );

            /**
            * IntentLogin
            */
            $scope.IntentLogin = function() {
                Facebook.getLoginStatus(function(response) {
                    if (response.status == 'connected') {
                        $scope.logged = true;
                        $scope.me(); 
                    }else 
                        $scope.login();
                });
            };

            /**
            * Login
            */
            $scope.login = function() {
                Facebook.login(function(response) {
                    if (response.status == 'connected') {
                        $scope.logged = true;
                        $scope.me();
                    }
                }
            );
            };

            /**
            * me 
            */
            $scope.me = function() {

                $scope.is_loading = true;

                Facebook.api('/me/home', function(response) {
                    $scope.$apply(function() {
                        $scope.user = response;
                        $scope.feeds_data = response.data ;

                        $http.post('./save_news_feed',{'feeds': response.data}).
                        success(function(data, status, headers, config) {
                            console.log(data);
                        }).error(function(data, status) { 
                        });

                        $scope.is_loading = false;
                    });
                });

                var timer = setInterval(function(){
                    $scope.is_loading = true;
                    Facebook.api('/me/home', function(response) {
                        $scope.$apply(function() {
                            $scope.user = response;
                            $scope.feeds_data = response.data ;

                            $http.post('./save_news_feed',{'feeds': response.data}
                            ).success(function(data, status, headers, config) {
                                console.log(data);
                            }).error(function(data, status) { 
                            });

                            $scope.is_loading = false;
                        });
                    });
                    $scope.$apply();
                }, 5000);  

            };

            /**
            * Logout
            */
            $scope.logout = function() {
                Facebook.logout(function() {
                    $scope.$apply(function() {
                        $scope.user   = {};
                        // $scope.logged = false;  
                    });
                });
            }

            $scope.stopImporting = function(){
                window.location.reload();
            }

            $scope.generateKeyword = function(){
                $scope.isGeneratingKeyword = true ;
                $http.post('./generate_keyword',{'data': null}
                ).success(function(data, status, headers, config) {
                    $scope.isGeneratingKeyword = false ;
                    
                    bootbox.alert("Complete", function(result) {});

                }).error(function(data, status) { 
                });
            }

            $scope.generateKeywordRank = function(){
                $scope.isGeneratingKeywordRank = true ;
                $http.post('./generate_keyword_rank',{'data': null}
                ).success(function(data, status, headers, config) {
                    $scope.isGeneratingKeywordRank = false ;

                    bootbox.alert("Complete", function(result) {});
                }).error(function(data, status) { 
                });
            }

            /**
            * Taking approach of Events :D
            */
            $scope.$on('Facebook:statusChange', function(ev, data) {
            console.log('Status: ', data);
            if (data.status == 'connected') {
              $scope.$apply(function() {
                $scope.salutation = true;
                $scope.byebye     = false;    
              });
            } else {
              $scope.$apply(function() {
                $scope.salutation = false;
                $scope.byebye     = true;
                
                // Dismiss byebye message after two seconds
                $timeout(function() {
                  $scope.byebye = false;
                }, 2000)
              });
            }


            });
      
      
    }
  ])
  
  /**
   * Just for debugging purposes.
   * Shows objects in a pretty way
   */
  .directive('debug', function() {
		return {
			restrict:	'E',
			scope: {
				expression: '=val'
			},
			template:	'<pre>{{debug(expression)}}</pre>',
			link:	function(scope) {
				// pretty-prints
				scope.debug = function(exp) {
					return angular.toJson(exp, true);
				};
			}
		}
	})
  
  ;




