$(document).ready(function () {
    $('#region_id').on('change', function () {
        var regionId = this.value;
        $('#district_id').html('');
        $.ajax({
            url:'/users-region',
            data: {
                region_id: regionId,
            },
            type: 'GET',
            success: function (data) {
                console.log('region')
                // console.log(data)
                $('#district_id').html('<option value="">Select District</option>');
                $.each(data, function (key, value) {
                    $('#district_id').append('<option  value="'+value.id +'">'+value.name+'</option>');
                });
                // $('#kvartira').html('<option value="">Select Kvartira</option>');
            },
            error: function (xhr, status, error) {
                console.log(error);
                // console.log(data)
            },
        });
    });


    $('#UpdateRegionDistrict').on('click', function (event) {
        var regionValue = $('#region_id').val();
        var districtValue = $('#district_id').val();

        if (!regionValue) {
            alert('Iltimos, regionni tanlang.');
            event.preventDefault();
        } else if (!districtValue) {
            alert('Iltimos, districtni tanlang.');
            event.preventDefault();
        }
    });

    // Select2 Multiple
    $('#select2Multiple').select2({
        placeholder: "Select Pharm",
        allowClear: true
    });

    // Select2 Multiple
    $('#select2-multipleTeacher').select2({
        placeholder: "Select Teacher",
        allowClear: true
    });

    // Select2 Multiple
    $('#select2-multipleUser').select2({
        placeholder: "Select User",
        allowClear: true
    });

    // Select2 Multiple
    $('#select2-multipleMember').select2({
        placeholder: "Select Members",
        allowClear: true
    });

    $('.checkbox_ids').change(function () {
        var checkboxId = $(this).attr('id');
        var deleteButtonId = '#delete-button' + checkboxId;

  //      console.log('Checkbox ID:', checkboxId);
//        console.log('Delete Button ID:', deleteButtonId);

        if ($(this).is(':checked')) {
           // console.log('Checkboxfsd ID:', checkboxId);
            $(deleteButtonId).show();
        } else {
           // console.log('Delete Buttonfs ID:', deleteButtonId);
            $(deleteButtonId).hide();
        }
    });

});

