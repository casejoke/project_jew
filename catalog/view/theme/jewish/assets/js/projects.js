var projects = {
  initFilter:function () {
    var options = {
		  valueNames: [ 'name' ]
		};

		var userList = new List('projects', options);
  }
};
$(document).ready(function() {
	projects.initFilter();
});
