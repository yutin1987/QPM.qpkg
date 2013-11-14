app = angular.module("qpmApp", [])

app.controller "web", ($scope) ->
  $scope.username = null
  $scope.password = null
  $scope.remember = no

  $scope.toggle_remember = () ->
    $scope.remember = !$scope.remember

  $scope.login = () ->
    return unless $scope.username and $scope.password
    UserSvc.login $scope.username, $scope.password

# app.config ($routeProvider, $httpProvider) ->
#   $routeProvider
#   .when("/photo",
#     templateUrl: "views/photo.html"
#     controller: "PhotoCtrl"
#     resolve:
#       Tab: -> 'photo'
#   )
#   .when("/album",
#     templateUrl: "views/photo.html"
#     controller: "PhotoCtrl"
#     resolve:
#       Tab: -> 'album'
#   )
#   .when("/selected",
#     templateUrl: "views/photo.html"
#     controller: "PhotoCtrl"
#     resolve:
#       Tab: -> 'selected'
#   )
#   .when("/albumPhoto/:id",
#     templateUrl: "views/photo.html"
#     controller: "PhotoCtrl"
#     resolve:
#       Tab: -> 'albumPhoto'
#   )
#   .when("/template",
#     templateUrl: "views/template.html"
#     controller: "TemplateCtrl"
#   )
#   .otherwise redirectTo: "/photo"

#   delete $httpProvider.defaults.headers.common['X-Requested-With']


# $(function(){
#   $('.drop_wrap.images').on('drop',function(e){
#     e.stopPropagation();
#     e.preventDefault();

#     var files = e.dataTransfer.files;
#     var fr = new FileReader();
#     var target = e.delegateTarget;
#     file = files[0] ? files[0] : null;

#     if (file.type.match('image.*')) {
#         fr.onload = function(e) {
#           $(target).addClass('preview');
#           $('img', target).attr('src',e.target.result);
#         };
#         fr.readAsDataURL(file);               
#     }
#   });
#   $('.drop_wrap.files').on('drop',function(e){
#     e.stopPropagation();
#     e.preventDefault();

#     var files = e.dataTransfer.files;
#     var target = e.delegateTarget;
#     file = files[0] ? files[0] : null;

#     $(target).addClass('preview');
#     $('.filename', target).text(file.name+' ('+file.type+')');
#     $('.size', target).text(file.size+' bytes');
#   });
#   $('.drop_wrap').on('dragover',function(e){
#     e.stopPropagation();
#     e.preventDefault();
#   });

# });
