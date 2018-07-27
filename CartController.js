/**
 * CartController
 *
 * @description :: Server-side logic for managing carts
 * @help        :: See http://sailsjs.org/#!/documentation/concepts/Controllers
 */
let remote = require('remote-file-size');
var MobileDetect = require('mobile-detect');
module.exports = {
  get: (req, res, next) => {
    if(!req.session.user) {
      return res.json({
        error: 'You must loggen in'
      });
    }
    if(req.isSocket || req.param('json')) {
		let userId = req.session.user.id;
		let tracks = [];
		let haveTracks = false;
		let md = new MobileDetect(req.headers['user-agent']);
		console.log(md);
		if(md.phone() == null && md.tablet() == null){
			console.log('On Desktop');
			Cart.find({user: userId}).exec((error, cartTracks) => {
				console.log('cart tracks');
				console.log(cartTracks);
				console.log(cartTracks.length);
				let i = 0;
				if(cartTracks.length > 0){
					cartTracks.forEach(cartTrack => {
						console.log('cart track');
						console.log(cartTrack);
						console.log(cartTrack.id);
						Track.findOne({id: cartTrack.track}).exec((error, track) => {
							console.log('track detail');
							console.log(track);
							tracks.push(track);
							i = i + 1;
							if(i == cartTracks.length){
								console.log('Tracks');
								console.log(tracks);
								if(tracks.length > 0){
									req.session.user.cart = tracks;
								}
								console.log(req.session.user.cart);
								res.json({
									cart: req.session.user.cart || [],
									haveTracks: haveTracks
								});
							}
						});
					});
					haveTracks = true;
				} else {
					res.json({
						cart: req.session.user.cart || [],
						haveTracks: haveTracks
					});
				}
			});
		}
		/*console.log('Tracks');
		console.log(tracks);
		if(tracks.length > 0){
			req.session.user.cart = tracks;
		}
		console.log(req.session.user.cart);
		res.json({
			cart: req.session.user.cart || [],
			haveTracks: haveTracks
		});*/
    }
    else {
		let userId = req.session.user.id;
		let tracks = [];
		let haveTracks = false;
		let md = new MobileDetect(req.headers['user-agent']);
		console.log(md);
		if(md.phone() == null && md.tablet() == null){
			console.log('On Desktop');
			Cart.find({user: userId}).exec((error, cartTracks) => {
				console.log('cart tracks');
				console.log(cartTracks);
				console.log(cartTracks.length);
				let i = 0;
				if(cartTracks.length > 0){
					cartTracks.forEach(cartTrack => {
						Track.findOne({id: cartTrack.track}).exec((error, track) => {
							tracks.push(track);
							i = i + 1;
							if(i == cartTracks.length){
								console.log('Tracks');
								console.log(tracks);
								if(tracks.length > 0){
									req.session.user.cart = tracks;
								}
								console.log(req.session.user.cart);
								res.view('cart', {
									cart: req.session.user.cart || [],
									haveTracks: haveTracks
								});
							}
						});
					});
					haveTracks = true;
				} else {
					res.view('cart', {
						cart: req.session.user.cart || [],
						haveTracks: haveTracks
					});
				}
			});
		}
		/*console.log('Tracks');
		console.log(tracks);
		if(tracks.length > 0){
			req.session.user.cart = tracks;
		}
		res.view('cart', {
			cart: req.session.user.cart || [],
			haveTracks: haveTracks
		});*/
    }
    
  },
	add: (req, res, next) => {
		let params = req.params.all();
		console.log('add-to-cart: ', params.id);
		let md = new MobileDetect(req.headers['user-agent']);
		console.log(md);
		if(md.phone() != null || md.tablet() != null){
			if(!params.id) {
			  if(req.isSocket || req.param('json')) {
				return res.json({
				  error: 'Invalid track id'
				});
			  }
			  else {
				return res.serverError('Invalid track id');
			  }
			}
			Track.findOne({ id: params.id }).exec((err, track) => {
				let userId = req.session.user ? req.session.user.id : null;
				Cart.create({ track: params.id ,user: userId }, (err, track) => {
				  if(err) {
					return res.serverError(err);
				  }
				  if(req.isSocket || req.param('json')) {
					return res.json({
					  error: 'This track was also added'
					});
				  }
				  else {
					return res.serverError('This track was also added');
				  }
				});
			});
		}
		if(!req.session.user.cart) req.session.user.cart = [];
		// if id dosn't include in request params
		if(!params.id) {
		  if(req.isSocket || req.param('json')) {
			return res.json({
			  error: 'Invalid track id'
			});
		  }
		  else {
			return res.serverError('Invalid track id');
		  }
		}
		// if this track also was added, send error message
		let isAdded = req.session.user.cart.filter(item => item.id === params.id*1)
		if(isAdded.length) {
		  if(req.isSocket || req.param('json')) {
			return res.json({
			  error: 'This track was also added'
			});
		  }
		  else {
			return res.serverError('This track was also added');
		  }
		}
		/*
		  Find track by id, add to session crate.
		  If this is default get request, you will go to crate page
		  If this is socket request, you will recieve cart content
		*/
		let checkSize = (track) => {
		  return new Promise((resolve, reject) => {
			console.log('Check track: ',track.name, ', size: ', track.size)
			if(track.size) {
			  resolve(track)
			}
			else {
			  remote(track.url, function(err, size) {
				console.log('Getted size : ', size);
				if(err) {
				  sails.error(err);
				  return resolve(0);
				}
				Track.update(params.id, { size: size }).exec((err, uptrack) => {
				  resolve(uptrack[0]);
				});
			  })
			}
		  })
		}
		Track.findOne({ id: params.id }).exec((err, track) => {
		  req.session.user.cart.push(track);
		  checkSize(track).then(data => {
			let sum = req.session.user.cart.reduce(function(acc, item) {
			  return acc + (item.size || 0);
			}, 0);
			let sumMB = parseFloat(((sum + data.size)/1000/1000).toFixed(3), 10);
			if(sumMB > sails.session.settings.cartSize) {

			  sails.log('Cart is full, summ: ', sumMB, ', max: ', sails.session.settings.cartSize);
			  let removedIndex = _.findIndex(req.session.user.cart, {id: data.id });
			  req.session.user.cart.splice(removedIndex, 1);
			  sails.log('Removed index: ', removedIndex);

			  sails.sockets.blast('cart-update.' + req.session.user.id, {type: 'update', cart: req.session.user.cart });
			  if(req.param('json') || req.isSocket) {
				return res.json({
				  error: sails.__('full_cart')
				});
			  }
			  else {
				return res.serverError(sails.__('full_cart'));
			  }
			}
			if(req.param('json') || req.isSocket) {
			  let tmpObj = {
				cart: req.session.user.cart
			  }
			  if(err) {
				tmpObj = {
				  error: err
				}
			  }
			  sails.sockets.blast('cart-update.' + req.session.user.id, {type: 'add', id: params.id, cart: req.session.user.cart });
			  return res.json(tmpObj);
			}
			else {
			  if(err) {
				return res.serverError({
				  error: 'We can\'t find this track'
				});
			  }
			  return res.redirect('/crate');
			}
		  })
		})
	},
	destroy: (req, res, next) => {
		let params = req.params.all();
		console.log('Remove id from cart: ', params.id);
		if(!params.id) {
		  return res[req.isSocket || req.param('json') ? 'json' : 'serverError']({
			error: 'Incorrect track id'
		  });
		}
		
		req.session.user.cart = (req.session.user.cart || []).filter(item => {
		  return item.id !== params.id*1
		});
		

		sails.sockets.blast('cart-update.' + req.session.user.id, {
		  type: 'remove', id: params.id, cart: req.session.user.cart
		});
		
		let md = new MobileDetect(req.headers['user-agent']);
		if(md.phone() != null || md.tablet() != null){
			Crate.destroy({user:req.session.user.id},{track: params.id});
		}
		
		if(req.isSocket || req.param('json')) {
		  return res.json({
			msg: 'Track removed!',
			cart: req.session.user.cart
		  });
		}
		return res.redirect('/crate');
	}
};

