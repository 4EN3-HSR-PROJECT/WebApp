function random_ads()
{
	var ads = new Array();
	ads[1] = "ads/subAd.jpg";
	ads[2] = "ads/timAd.jpg";
	ads[3] = "ads/beerStoreAd.jpg";
	var ry = Math.floor(Math.random() * ads.length) + 1;
	return ('<img src="' + ads[ry] + '" border=0>');
}