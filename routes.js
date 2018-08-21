module.exports.routes = {
	'get /get-model/:name': 'Core.model',

	'get /config': 'CoreController.config',
	'get /config/:setting': 'CoreController.config',

	// static page
	'/': {
		view: 'homepage'
	},
	'get /day-trending': 'TrackController.dayTrending',
	'get /week-trending': 'TrackController.weekTrending',
	'get /month-trending': 'TrackController.monthTrending',
	'/static/:page': {
		fn: function(req, res, next) {
			let pageName = req.param('page');
			if(pageName) {
				if(req.xhr) {
					return res.render('static/' + pageName + '.ejs');
				}
				else {
					return res.redirect('/' + pageName);
				}
			}
			else {
				return res.send(404);
			}
		}
	},
	'/contact': { 
		view: 'static/contact',
		locals: {
			layout: 's-layout'
		  }
	},
	'/downloader': { 
		view: 'static/download',
		locals: {
			layout: 's-layout'
		  }
	},
	// Copyright Views
	'/copyright': { 
		view: 'static/copyright',
		locals: {
			layout: 's-layout'
			}
	},
    '/terms': { 
		view: 'static/terms',
		locals: {
			layout: 's-layout'
		  }
	},
	'/faq': { 
		view: 'static/faq',
		locals: {
			layout: 's-layout'
		  }
	},
	'/feedback': { 
		view: 'static/feedback',
		locals: {
			layout: 's-layout'
		  } 
		},
	'/crate': {
		view: 'crate',
		policy: 'isLoggedIn',
		locals: {
		  layout: 'c-layout'
		}
	},

	'/theme/toggle': {
		controller: 'ThemeController',
		action: 'toggle'
	},

	// admin panel
	'get /admin': {
		controller: 'AdminController',
		action: 'index',
		locals: {
			layout: 'a-layout'
		  }
	},

	// genrefilter view routes
	'post /admin/settings-save': {
		controller: 'AdminController',
		action: 'settingsSave',
		locals: {
			layout: 'a-layout'
		  }
	},

	// genrefilter view routes
	'get /admin/genrefilter': {
		controller: 'GenrefilterController',
		action: 'index'
	},
	'get /admin/genrefilter/new': {
		controller: 'GenrefilterController',
		action: 'new',
		locals: {
			layout: 'a-layout'
		}
	},
	'get /admin/genrefilter/edit/:id': {
		controller: 'GenrefilterController',
		action: 'edit'
	},

	// Filter endpoints
	'get /remixerfilter/json': {
		controller: 'TrackController',
		action: 'remixer',
		locals: {
			layout: 'a-layout'
		}
	},
	'get /oddestremixerfilter/json': {
		controller: 'TrackController',
		action: 'oddestremixer'
	},
	'get /genrefilter/json': {
		controller: 'GenrefilterController',
		action: 'json'
	},
	'post /admin/genrefilter/create': {
		controller: 'GenrefilterController',
		action: 'create'
	},
	'post /admin/genrefilter/update/:id': {
		controller: 'GenrefilterController',
		action: 'update'
	},
	'/admin/genrefilter/destroy/:id': {
		controller: 'GenrefilterController',
		action: 'destroy'
	},


	// track view routes
	'get /admin/track': {
		controller: 'TrackController',
		action: 'index',
		locals: {
			layout: 'a-layout'
		  }
	},
	'get /admin/track/new': {
		controller: 'TrackController',
		action: 'new',
		locals: {
			layout: 'a-layout'
		  }
	},
	'get /admin/track/edit/:id': {
		controller: 'TrackController',
		action: 'edit',
		locals: {
			layout: 'a-layout'
		}
	},
	'get /admin/track/:id': {
		controller: 'TrackController',
		action: 'show',
		locals: {
			layout: 'a-layout'
		}
	},
	// for local files upload
	'get /tmp-uploads/*': {
		controller: 'TrackController',
		action: 'trackfile'
	},
	'get /search-all-remixes': {
		controller: 'TrackController',
		action: 'searchAllRemixes'
	},

	'get /download-track/:id': {
		controller: 'FileController',
		action: 'downloadTrack'
	},
	'get /check-download-track/:id': {
		controller: 'FileController',
		action: 'checkDownloadCount',
		policy: 'isLoggedIn'
	},
	// for local files upload
	'get /get-archive': {
		controller: 'FileController',
		action: 'attachZip'
	},
	'get /marked-as-downloaded' : {
		controller: 'FileController',
		action: 'markedAsDownloaded'
	},
	'post /metadata': {
		controller: 'FileController',
		action: 'getMetaData'
	},


	'get /search/autocomplete': {
		controller: 'TrackController',
		action: 'search-autocomplete'
	},
	
	'get /search/remix-oddest': {
		controller: 'RemixOdestController',
		action: 'getAlltracks'
	},
	
	'get /search/admin-tracks': {
		controller: 'TrackController',
		action: 'adminTracks'
	},

	// Track endpoints
	'get /track/json': {
		controller: 'TrackController',
		action: 'json'
	},
	'post /admin/track/create': {
		controller: 'TrackController',
		action: 'create'
	},
	'post /admin/track/update/:id': {
		controller: 'TrackController',
		action: 'update'
	},
	'/admin/track/destroy/:id': {
		controller: 'TrackController',
		action: 'destroy'
	},
	'post /admin/file/upload': {
		controller: 'FileController',
		action: 'upload'
	},
	'post /admin/file/s3upload': {
		controller: 'FileController',
		action: 's3upload'
	},
	'post /admin/file/s3upload-multi': {
		controller: 'FileController',
		action: 's3uploadMulti'
	},

	// cart routes
	'/get-cart': {
		controller: 'CartController',
		action: 'get',
		policy: 'isLoggedIn'
	},
	'get /add-to-cart/:id': {
		controller: 'CartController',
		action: 'add',
		policy: 'isLoggedIn'
	},
	'get /update-stream-count/:id': {
		controller: 'TrackController',
		action: 'addStream',
		//policy: 'isLoggedIn'
	},
	'get /remove-from-cart/:id': {
		controller: 'CartController',
		action: 'destroy',
		policy: 'isLoggedIn'
	},

	// user view routes
	'get /user-info': {
		controller: 'UserController',
		action: 'info'
	},
	// Login Views
	'get /login': [
			{ policy: 'isNotLoggedIn' },
			{ view: 'admin/user/login',
				locals: {
					layout: 'l-layout'
				}
			}
		],

	// Endpoints
	'post /login': 'UserController.login',
	'/logout': 'UserController.logout',

	// Login Views
	'get /signup': { view: 'admin/user/signup' },
	
	'post /contact-form' : {
		controller: 'CoreController',
		action: 'sendEmail'
	},
	/*{ view: 'admin/user/login' },*/

	// Endpoints
	'post /copyright': {
		controller: 'CoreController',
		action: 'sendCopyright'
	},

	'post /feedback-form': {
		controller: 'CoreController',
		action: 'sendFeedback'
	},

	'get /cron': {
		controller: 'TrackController',
		action: 'runCron'
	},

	'get /update-search': {
		controller: 'TrackController',
		action: 'updateSearch'
	},

	'get /song/:name': {
		view: 'media',
		locals: {
			layout: 'media-layout'
		  }
	},

	'get /video/:name': {
		view: 'media',
		locals: {
			layout: 'media-layout'
		  }
	},

	'get /media/:name': {
		controller: 'TrackController',
		action: 'songDetails',
	},

	'get /artist/:name': {
		view: 'artist',
		locals: {
			layout: 'artist-layout'
		}
	},

	'get /filter-artist/:name': {
		controller: 'TrackController',
		action: 'artistDetails'
	},

	'get /policy': {
		view: 'static/policy',
		locals: {
			layout: 's-layout'
		  }
	},
	'get /userlogin': {
		controller: 'UserController',
		action: 'uLogin'
	},
	'get /vlogin': {
		controller: 'UserController',
		action: 'verifyLogin'
	},
	'get /dlogin': {
		controller: 'UserController',
		action: 'detailUser'
	},
	// DJ Remix Upload
	'get /upload': {
		policy: 'isLoggedIn',
		view: 'upload',
		locals: {
			layout: 'upload-layout'
		  }
	},
	'get /upload/remix': {
		policy: 'isLoggedIn',
		view: 'user-track',
		locals: {
			layout: 'upload-layout'
		  }
	},
	'get /upload/odest': {
		policy: 'isLoggedIn',
		view: 'odest-track',
		locals: {
			layout: 'upload-layout'
		  }
	},
	'post /add-remix': {
		controller: 'RemixOdestController',
		action: 'addDjRemix',
		locals: {
			layout: 'upload-layout'
		}
	},
	'post /add-odest': {
		controller: 'RemixOdestController',
		action: 'addOdest',
		locals: {
			layout: 'upload-layout'
		}
	},
	'get /uploads': {
		policy: 'isLoggedIn',
		view: 'uploads',
		locals: {
			layout: 's-layout'
		  }
	},
	'get /upload/test': {
		controller: 'RemixOdestController',
		action: 'getTest'
	},
	'post /remix-odest/track/update/:id': {
		controller: 'RemixOdestController',
		action: 'update'
	},
	'/remix-odest/track/destroy/:id': {
		controller: 'RemixOdestController',
		action: 'destroy'
	},
	'get /remix': {
		policy: 'isLoggedIn',
		view: 'remix-odest',
		locals: {
			layout: 'ro-layout'
		  }
	},
	'get /odest': {
		policy: 'isLoggedIn',
		view: 'remix-odest',
		locals: {
			layout: 'ro-layout'
		  }
	},
	'get /search/remix': {
		controller: 'RemixOdestController',
		action: 'getRemixes'
	},
	'get /search/odest': {
		controller: 'RemixOdestController',
		action: 'getOdest'
	},
	'get /update-ro-stream-count/:id': {
		controller: 'RemixOdestController',
		action: 'updateStream'
	},
	'get /update-ro-like-count/:id': {
		controller: 'RemixOdestController',
		action: 'updateLikes'
	},
	'get /update-ro-dislike-count/:id': {
		controller: 'RemixOdestController',
		action: 'updateDislikes'
	},
	'get /download-ro-track/:id': {
		controller: 'RemixOdestController',
		action: 'downloadTrack'
	},
};
