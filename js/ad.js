function updateAds()
{
	var ads = new Array();
	ads[0] = "ads/subAd.jpg";
	ads[1] = "ads/timAd.jpg";
	ads[2] = "ads/beerStoreAd.jpg";
	var rand = Math.floor(Math.random() * (ads.length));
	$("#bus_ad").html('<img src="' + ads[rand] + '" border=0 width="100%">');
	$("#bulletin_ad").html('<img src="' + ads[rand] + '" border=0 width="100%">');
	$("#taxi_ad").html('<img src="' + ads[rand] + '" border=0 width="100%">');
	setTimeout ('updateAds()', 30000);
}