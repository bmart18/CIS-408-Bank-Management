function toggle_main(){
    var x = document.getElementsByClassName(arguments[0]);
    //list of containers
    containers = ['transfer-container', 'profile-container', 'change-password-container', 'Manage-staff-container', 'transaction-history-container', 'add-staff-container','update-profile-container']
    for (i = 0; i<containers.length; i++){
        //current main content
        current_main = document.getElementsByClassName(containers[i])

        //retrieve display of current main
        current_main_display = get_Display(current_main[0])

        //switch to container that user wants
        if (current_main_display === "grid"){
            current_main[0].style.display = "none";
            x[0].style.display = "grid";
            break;
        }
    }
}

//get css display from element
function get_Display(container){
    var display = window.getComputedStyle(container, null).getPropertyValue("display");
    return display;
}
