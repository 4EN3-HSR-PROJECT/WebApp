function updateAds()
{
	var ads = new Array();
	ads[1] = "ads/subAd.jpg";
	ads[2] = "ads/timAd.jpg";
	ads[3] = "ads/beerStoreAd.jpg";
	var rand = Math.floor(Math.random() * ads.length) + 1;
	$("#bus_ad").html('<img src="' + ads[ry] + '" border=0>');
	$("#bulletin_ad").html('<img src="' + ads[ry] + '" border=0>');
	$("#taxi_ad").html('<img src="' + ads[ry] + '" border=0>');
}