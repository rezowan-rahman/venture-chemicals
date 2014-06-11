var $collectionHolder;
var $collectionHolder2;

var $addPropertyLink = jQuery("button#add-properties");
var $addShippingLink = jQuery("button#add-shipping");

jQuery(document).ready(function(e) {

    $collectionHolder = jQuery('div.add-properties');
    $collectionHolder2 = jQuery('div.add-shipping');


    $addPropertyLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, "property");
    });

    $addShippingLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder2, "shipping");
    });
});