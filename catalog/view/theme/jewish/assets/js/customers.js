var customers = {
  initFilter:function () {
    var options = {
		  valueNames: [ 'name' ]
		};

		var userList = new List('users', options);
  }
};
$(document).ready(function() {
	customers.initFilter();
});
