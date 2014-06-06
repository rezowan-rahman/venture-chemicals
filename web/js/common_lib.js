/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function confirmDel() {
    return confirm("Are you sure you want to delete this");
}

jQuery(document).on("click", "button.target", function(e) {
    var obj = jQuery(this);
    var url = obj.data("path");

    if(obj.hasClass('confirm')) {
        if(!confirm("Are you sure you want to delete ?")) {
            return false;
        }
    }

    window.location = url;
});


