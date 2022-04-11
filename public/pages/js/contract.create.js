$(document).ready(function () {
    $("#choose_category").modal("show");
    $("#add_blanket-rec").click(function () {
        add_blanket();
        return false;
    });
    $(".remove_blanket-rec").click(function () {
        remove_blanket(this);
        return false;
    });
    var clone_blanker_rec = $(".blanket-rec").clone().prop("outerHTML");

    var multipleCancelButton = new Choices("#choices-multiple-remove-button", {
        removeItemButton: true,
        maxItemCount: 5,
        searchResultLimit: 5,
        renderChoiceLimit: 5,
    });

    $(document).on("change", "#contract_type", function () {
        $("#type_val").val($("#contract_type").val());
        hide_content(
            $("#contract_type").val(),
            $("#contract_type option:selected").text()
        );
        $("#choose_category").modal("hide");
    });

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
                $("#custom_blanket_quantity").val("");
                break;
            case "2":
                $(".volume_blanket").hide();
                $(".volume_blanket input").removeAttr("required");
                $("#custom_blanket_title").text("Maximum Quantity");
                $("#custom_blanket").show();
                $("#custom_blanket_quantity").val("");
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

    function add_blanket() {
        $(".blanket_loop").append(clone_blanker_rec);
        $(".remove_blanket-rec").click(function () {
            remove_blanket(this);
            return false;
        });
        setRupiahWithdot("rupiahWithdot");
        setNumberPeriod("numberWithPeriod");
    }

    function remove_blanket(selected) {
        if ($(".blanket_loop .blanket-rec").length > 1) {
            $(selected).closest(".blanket-rec").remove();
        }
    }
    setNumberPeriod("numberWithPeriod");
    setRupiahWithdot("rupiahWithdot");
});
