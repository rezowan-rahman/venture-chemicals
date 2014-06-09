var $collectionHolder;
var $collectionHolder2;
var $collectionHolder3;

var $addPropertyLink = jQuery("button#add-properties");
var $addShippingLink = jQuery("button#add-ingredients");
var $addPriceLink = jQuery("button#add-salesPointCosts");

jQuery(document).ready(function(e) {

    $collectionHolder = jQuery('div.add-properties');
    $collectionHolder2 = jQuery('div.add-ingredients');
    $collectionHolder3 = jQuery('div.add-salesPointCosts');


    $addPropertyLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, "property");
    });

    $addShippingLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder2, "ingredient");
    });

    $addPriceLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder3, "salesPointCost");
    });
});