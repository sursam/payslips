$('#payment-form').submit(function (e) {
    e.preventDefault();
    sendPaymentDataToAnet();
});
function sendPaymentDataToAnet() {
    // Set up authorisation to access the gateway.
    var authData = {};
        authData.clientKey = CLIENT_KEY;
        authData.apiLoginID = AUTHORIZE_LOGINID;

    var cardData = {};
        cardData.cardNumber = $('.card-number').val();
        cardData.month = $(".card-expiry-month").val();
        cardData.year = $(".card-expiry-year").val();
        cardData.cardCode = $('.card-cvc').val();

    // Now send the card data to the gateway for tokenisation.
    // The responseHandler function will handle the response.
    var secureData = {};
        secureData.authData = authData;
        secureData.cardData = cardData;
        Accept.dispatchData(secureData, responseHandler);
}

async function responseHandler(response) {
	
    if (response.messages.resultCode === "Error") {
        var i = 0;
        while (i < response.messages.message.length) {
            showToast('error','Card',response.messages.message[i].text);
            /* console.log(
                response.messages.message[i].code + ": " +
                response.messages.message[i].text
            ); */
            i = i + 1;
        }
    } else {
		var paymentData= await paymentFormUpdate(response.opaqueData);
		console.log(paymentData);
    }
}

function paymentFormUpdate(opaqueData) {
	document.getElementById("opaqueDataDescriptor").value = opaqueData.dataDescriptor;
    document.getElementById("opaqueDataValue").value = opaqueData.dataValue;
    document.getElementById("payment-form").submit();
	/* $("#opaqueDataDescriptor").val(opaqueData.dataDescriptor);
    $("#opaqueDataValue").val(opaqueData.dataValue);
	$("#payment-form").submit(); */
	// return false;

}