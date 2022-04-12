$(document).ready(function () {
    $("#contract_type").val(type); 
    console.log();
    $("#type_val").val($("#contract_type").val());
    hide_content(
        type,
        $("#contract_type option:selected").text()
    );
    $("#choose_category").modal("hide");

    function hide_content(category_type, title) {
        switch (category_type) {
            case "4":
                $("#blanket input").removeAttr("required");
                return;
            case "3":
                $(".volume_blanket").hide();
                $(".volume_blanket input").removeAttr("required");
                $("#custom_blanket_title").text("Maximum Total Price");
                $("#custom_blanket").show();
                break;
            case "2":
                $(".volume_blanket").hide();
                $(".volume_blanket input").removeAttr("required");
                $("#custom_blanket_title").text("Maximum Quantity");
                $("#custom_blanket").show();
                break;
            case "1":
                $("#custom_blanket_quantity").val(0);
                $("#custom_blanket").hide();
                break;
        }

        $("#blanket").show();
        // Change title
        $("#blanket_title").text(title);
        clone_blanker_rec = $(".blanket-rec").clone().prop("outerHTML");
    }
    setNumberPeriod("numberWithPeriod");
    setRupiahWithdot("rupiahWithdot");
});
