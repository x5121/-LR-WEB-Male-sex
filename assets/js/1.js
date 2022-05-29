function InstallModule() {
    $.ajax({
        type: "POST",
        url: location.href,
        data: $("#db_check").serialize() + "&action=install",
        success: function (response) {
            note({
                content: response.messenge,
                type: response.status,
                time: 5
            });

            if(response.success == true) {
                let url = window.location.protocol + '//' + window.location.hostname + '/malesex_stats';
                setTimeout(( e ) => {window.location.href = url;}, 2000);
            }
            return;

        },
        fail: function (response) {
            note({
                content: response.messenge,
                type: response.status,
                time: 5
            });

        }



    });
}