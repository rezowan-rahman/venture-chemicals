var $collectionHolder;
var $collectionHolder2;

var $addPropertyLink = jQuery("button#add-properties");
var $addShippingLink = jQuery("button#add-ingredients");

jQuery(document).ready(function(e) {

    $collectionHolder = jQuery('div.add-properties');
    $collectionHolder2 = jQuery('div.add-ingredients');


    $addPropertyLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, "property");
    });

    $addShippingLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder2, "ingredient");
    });
});