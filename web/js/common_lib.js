/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function confirmDel() {
    return confirm("Are you sure you want to delete this");
}

function blank(a) { 
    if(a.value == a.defaultValue) a.value = ""; 
}
function unblank(a) { 
    if(a.value == "") a.value = a.defaultValue; 
}   


