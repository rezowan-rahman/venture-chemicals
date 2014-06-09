/**
 * Created by rezowan on 6/9/14.
 */

var $collectionHolder;

var $addShippingLink = jQuery("button#add-shipping");

jQuery(document).ready(function(e) {

    $collectionHolder = jQuery('div.add-shipping');


    $addShippingLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, "shipping");
    });
});