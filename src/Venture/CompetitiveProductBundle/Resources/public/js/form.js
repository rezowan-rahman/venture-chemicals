var $collectionHolder;
var $addNotesLink = jQuery("button#add-properties");


jQuery(document).ready(function(e) {

    $collectionHolder = jQuery('div.add-properties');


    $addNotesLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($collectionHolder, "property");
    });
});