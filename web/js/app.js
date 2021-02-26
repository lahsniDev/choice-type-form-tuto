$(function () {
    $.ajax({
        type: "GET",
        url: "http://localhost/ChoiceTypeTuto/web/app_dev.php/categories",
        success: function (categories) {
            $.each(categories, function (key, category) {
                $('#category').append($('<option></option>').attr('value', category['id']).text(category['name']))
            });
        }
    });
});