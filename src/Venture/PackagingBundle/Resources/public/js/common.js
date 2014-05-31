jQuery(document).ready(function(e) {
    jQuery("button.target").on("click", function(e) {
        var obj = jQuery(this);
        var location = obj.attr("location");
        var html = obj.html();
        if(html == "Delete") {
            if(confirm("Are you sure to delete this?")) {
                window.location = location;
                return true;
            }
            return false;
        }
        window.location = location;
        return true;
    });
});