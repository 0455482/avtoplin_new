app.directive('notnumber', function() {
  return {
    restrict : 'A',
    replace: true,
    require: 'ng-model',
    scope: {},
    link: function(scope, element, attrs, ngModel) {
        element.bind('blur', function (e) {
            //console.log(attrs.placeholder);
            if (!ngModel || !element.val()) return;
            
            if ($.isNumeric(element.val())) {
                element.attr('placeholder', 'haha');
            } else {
                element.val('');
                element.attr('placeholder', 'Vnesite ceno z številke');
                angular.element(element).addClass('validation_error');
            }
        });
    }
  };
});