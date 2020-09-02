import { Employee } from "../js/models/employee.js";
$(window).ready(() => {
    $.ajax({
        type: "GET",
        url: "/PID_Assignment/employee/getSessionEmpID"
    }).then(function (e) {
        $("#empID").text(e);
        if (e.length <= 0) {
            window.location.href = "/PID_Assignment/views/pageBack/login.html";
        } else {
            $("#textLogin").text("登出");
        }
    });
});