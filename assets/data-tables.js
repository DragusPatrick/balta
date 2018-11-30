jQuery.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, fnCallback, bStandingRedraw)
{
    if(jQuery.fn.dataTable.versionCheck)
    {
        var api = new jQuery.fn.dataTable.Api(oSettings);

        if(sNewSource)
        {
            api.ajax.url(sNewSource).load(fnCallback, !bStandingRedraw);
        }
        else
        {
            api.ajax.reload(fnCallback, !bStandingRedraw);
        }
        return;
    }

    if(sNewSource !== undefined && sNewSource !== null)
    {
        oSettings.sAjaxSource = sNewSource;
    }

    if (oSettings.oFeatures.bServerSide)
    {
        this.fnDraw();
        return;
    }

    this.oApi._fnProcessingDisplay(oSettings, true);
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];

    this.oApi._fnServerParams(oSettings, aData);

    oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function(json)
    {
        /* Clear the old information from the table */
        that.oApi._fnClearTable(oSettings);

        /* Got the data - add it to the table */
        var aData = (oSettings.sAjaxDataProp !== "") ? that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

        for (var i = 0 ; i < aData.length ; i++)
        {
            that.oApi._fnAddData(oSettings, aData[i]);
        }

        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

        that.fnDraw();

        if (bStandingRedraw === true)
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd(oSettings);
            that.fnDraw(false);
        }

        that.oApi._fnProcessingDisplay(oSettings, false);

        /* Callback user function - for event handlers etc */
        if(typeof fnCallback == 'function' && fnCallback !== null)
        {
            fnCallback(oSettings);
        }
    }, oSettings);
};

jQuery.fn.dataTableExt.oApi.fnFilterOnReturn = function (oSettings) {
    var _that = this;

    this.each(function (i) {
        $.fn.dataTableExt.iApiIndex = i;
        var $this = this;
        var anControl = $('input', _that.fnSettings().aanFeatures.f);
        anControl
            .unbind('keyup search input')
            .bind('keypress', function (e) {
                if (e.which == 13) {
                    $.fn.dataTableExt.iApiIndex = i;
                    _that.fnFilter(anControl.val());
                }
            });

        return this;
    });

    return this;
};

jQuery(document).ready(function()
{
    var ajax_dt = $('table[data-ajax-dt]'),
        ajax_pu = false;

    if(ajax_dt.length > 0)
    {
        ajax_dt.each(function(index, table_ob)
        {
            var dt = $(table_ob);

            dt.dataTable({
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": base_url + dt.data('ajax-dt'),
                    "type": "POST"
                },
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [-1]
                }],
                "order": [[ 0, "desc" ]],
                "oLanguage": {
                    "sLengthMenu": "Afiseaza _MENU_",
                    "sLoadingRecords": "Se incarca - asteptati...",
                    "sProcessing": "Are loc procesarea datelor - asteptati...",
                    "sSearch": "Cauta rezervare:",
                    "sZeroRecords": "Nu exista inregistrari pentru afisare",
                    "sInfoEmpty": "Nus inregistrari pentru afisare",
                    "sInfoFiltered": " - filtrare din _MAX_ inreg.",
                    "sInfo": "Sunt afisate _START_ - _END_ din _TOTAL_ inreg.",
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": ""
                    }
                },
                "iDisplayLength": 10,
                "aLengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>'
            })
                .fnFilterOnReturn();
        });

        ajax_dt.on('click', 'a.remove', function(event)
        {
            event.preventDefault();

            var btn = $(this);

            $.magnificPopup.open({
                items: {
                    src: base_url + $(this).attr('href')
                },
                type: 'ajax',
                mainClass: 'mfp-slideDown'
            });

            ajax_pu = $.magnificPopup.instance;
            
            // bootbox.dialog({
            //     message: '<p class="pt5 pb5">Va rugam sa confirmati stergerea articolului selectat.</p>' +
            //     '<p class="text-danger" style="font-weight: 600;">Atentie: Dupa confirmarea acestui mesaj, datele articolului ales vor fi sterse fara posibilitatea de a fi recuperate ulterior!</p>',
            //     title: 'Confirmare stergere',
            //     buttons: {
            //         success: {
            //             label: "Continua",
            //             className: "btn-success",
            //             callback: function()
            //             {
            //                 $.ajax({
            //                     url: base_url + btn.attr('href'),
            //                     dataType: 'json',
            //                     beforeSend: function()
            //                     {
            //                         btn.attr('disabled', true).find('.fa').removeClass('fa-times').addClass('fa-refresh fa-spin');
            //                     },
            //                     success: function(response)
            //                     {
            //                         if(response.type === 'success')
            //                         {
            //                             btn.closest('table[data-ajax-dt]').dataTable().fnReloadAjax();
            //                         }
            //                         else
            //                         {
            //                             btn.removeAttr('disabled').find('.fa').removeClass('fa-refresh fa-spin').addClass('fa-times');

            //                             bootbox.alert('<p class="text-danger pt5 pb5">' + response.message + '</p>');
            //                         }
            //                     },
            //                     error: function()
            //                     {
            //                         btn.removeAttr('disabled').find('.fa').removeClass('fa-refresh fa-spin').addClass('fa-times');

            //                         bootbox.alert('<p class="text-danger pt5 pb5">A intervenit o eroare la trimiterea datelor, reincarcati pagina si incercati iar!</p>');
            //                     }
            //                 });
            //             }
            //         },
            //         danger: {
            //             label: "Renunta",
            //             className: "btn-danger"
            //         }
            //     }
            // });

        });

        ajax_dt.on('click', 'a.change', function(event)
        {
            event.preventDefault();

            $.magnificPopup.open({
                items: {
                    src: base_url + $(this).attr('href')
                },
                type: 'ajax',
                mainClass: 'mfp-slideDown'
            });

            ajax_pu = $.magnificPopup.instance;
        });

        $('body').on('submit', 'form[data-form-dt]', function(event)
        {
            event.preventDefault();

            var form_ob  = $(this),
                alert_ob = form_ob.find('.alert'),
                btn_ob   = form_ob.find('button[type="submit"]'),
                dTable   = $('table#' + form_ob.data('form-dt'));

            form_ob.ajaxSubmit({
                url: base_url + form_ob.attr('action'),
                type: 'post',
                dataType: 'json',
                beforeSend: function()
                {
                    change_btn_state(btn_ob, 'loading');
                },
                success: function(response)
                {
                    show_alert(alert_ob, response.type, response.message);

                    change_btn_state(btn_ob, 'normal');

                    if(response.type === 'success')
                    {
                        form_ob.trigger('reset');

                        setTimeout(function()
                        {
                            hide_alert(alert_ob);
                        }, 3000);

                        if(dTable.length)
                        {
                            dTable.dataTable().fnReloadAjax();
                        }

                        if(ajax_pu !== false)
                        {
                            ajax_pu.close();
                        }
                    }
                },
                error: function()
                {
                    show_alert(alert_ob, 'danger', 'A intervenit o eroare la trimiterea datelor, reincarcati pagina si incercati iar!')

                    change_btn_state(btn_ob, 'normal');
                }
            })
        });
    }

    $('.panel-xs-hidden .panel-heading').on('click', function(event)
    {
        event.preventDefault();

        var hidden_part = $(this).closest('.panel-xs-hidden').find('.panel-hidden-part');

        if(hidden_part.hasClass('hidden-xs'))
        {
            hidden_part.removeClass('hidden-xs');
        }
        else
        {
            hidden_part.addClass('hidden-xs');
        }
    });
});

function change_btn_state(btn_ob, btn_state)
{
    switch(btn_state)
    {
        case 'loading' :
            btn_ob.width(btn_ob.width()).attr({'disabled' : true, 'data-label' : btn_ob.html()});
            btn_ob.html('<i class="fa fa-refresh fa-spin"></i>');
            break;

        case 'normal' :
            btn_ob.removeAttr('style disabled');
            btn_ob.html(btn_ob.data('label'));
            break;

        case 'disabled' :
            btn_ob.removeAttr('style');
            btn_ob.html(btn_ob.data('label'));
            break;
    }
}

function show_alert(alert_ob, alert_type, alert_msg)
{
    var alerts_icons = {
        danger  : 'fa-exclamation-triangle',
        success : 'fa-check-circle'
    };

    alert_ob.removeClass('alert-danger alert-success').addClass('alert-' + alert_type).html('<i class="fa ' + alerts_icons[alert_type] + ' mr5"></i>' + alert_msg);

    if(alert_ob.hasClass('hidden'))
    {
        alert_ob.removeClass('hidden');
    }
}

function hide_alert(alert_ob)
{
    if(!alert_ob.hasClass('hidden'))
    {
        alert_ob.addClass('hidden');
    }
}