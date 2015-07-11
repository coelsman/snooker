function CountryCode () {
	this.code = {
		VN: 'Vietnam', 
		TH: 'Thailand',
		FR: 'France'
	};
}
CountryCode.prototype = {
	getCountryByCode: function (code) {
		return this.code[code];
	}
};