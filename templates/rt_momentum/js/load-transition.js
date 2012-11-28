/**
 * @package		Gantry Template Framework - RocketTheme
 * @version		1.5 March 19, 2012
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license		http://www.rockettheme.com/legal/license.php RocketTheme Proprietary Use License
 */

((function(){

var animation = function(){
	var body = document.id('rt-transition');

	if (Browser.Engine.gecko19 || (Browser.Engine.trident && !Browser.Engine.trident7)){
		if (body){
			body.set('tween', {duration: 800, transition: 'quad:out'});
			body.setStyles({'visibility': 'hidden', 'opacity': 0});
			body.removeClass('rt-hidden').fade('in');
		}
		
		return;
	}
	
	if (body) body.removeClass('rt-hidden').addClass('rt-visible');
};

window.addEvent('load', animation);

})());