function vitiligoTracking() {
  if (navigator.doNotTrack) {
    // Browser has Do Not Track preference set, so don't track them because we're nice.
    console.log("Respecting your Do Not Track setting and not tracking your contribution.");
    return;
  }
  var trxnId = CRM.vars.VitiligoDonateTracking.trxnId;
  var totalAmount = CRM.vars.VitiligoDonateTracking.totalAmount;
  var formId = CRM.vars.VitiligoDonateTracking.formId;
  var contribType = CRM.vars.VitiligoDonateTracking.contribType;

  // Facebook Pixel event
  if ('fbq' in window) {
    fbq('track', 'Purchase', { value: totalAmount, currency: 'GBP', content_name: formId, content_type: contribType });
  }
  else {
    console.warn("Did not fire facebook tracking event as fbq() not available.");
  }

  // Google Analytics events
  if ('ga' in window) {
    // Fire an event for goal tracking
    ga('send', 'event', contribType, 'Purchase', formId, Math.floor(parseFloat(totalAmount)));
    // Fire an ecommerce event for financial tracking
    ga('require', 'ecommerce');
    ga('ecommerce:addTransaction', {
      'id': trxnId,           // Transaction ID. Required.
      'affiliation': formId,  // Affiliation or store name.
      'revenue': totalAmount, // Grand Total.
    });
    ga('ecommerce:send');
    // Expect to see a call to https://www.google-analytics.com/collect
  }
  else {
    console.warn("Did not fire google tracking event as ga() not available.");
  }
}
