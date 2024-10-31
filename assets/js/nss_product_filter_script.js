/*
Created By Nss Theme
*/
jQuery(document).ready(function ($) {
    "use strict";
    //three step
    var $select1 = $("#nss_select1"),
        $select2 = $("#nss_select2"),
        $select3 = $("#nss_select3");
    //select1
    $select1.on("change", function () {
        var parentVal = $(this).val();
        var nssCatItem = $("#nss_cat_item").val();
        getParentData(parentVal, nssCatItem);
    }).trigger("change");

    function getParentData(parentVal_id, cat_name) {
        jQuery.ajax({
            url: nssProduct_ajax.ajaxurl,
            type: "GET",
            dataType: "html",
            beforeSend: function () { showLoading_select() },
            data: {
                action: "nssProduct_ele_filter_addon",
                parentVal: parentVal_id,
                nssCatItem: cat_name
            },
        })
        .done(function (res) {
            $select2.html(res);
        });
    }
    function showLoading_select(){
        $("#nss_select2").html('<div id="loadings">....</div>');
    }
    //select 2
    $select2.on("change", function () {
        var childVal = $(this).val();
        var nss_cat_sub_item = $("#nss_cat_sub_item").val();
        getChildData(childVal, nss_cat_sub_item);
    }).trigger("change");

    function getChildData(childVal_id, nss_cat_sub_item_id) {
        jQuery.ajax({
            url: nssProduct_ajax.ajaxurl,
            type: "GET",
            dataType: "html",
            beforeSend: function () { showLoading_select3() },
            data: {
                action: "nssProduct_ele_filter_addon",
                childVal: childVal_id,
                nss_cat_sub_item: nss_cat_sub_item_id
            },
        })
        .done(function (res) {
            $select3.html(res);
        });
    }
    function showLoading_select3() {
        $("#nss_select3").html('<div id="loadings">....</div>');
    }
    //load_ajaxData
    if ($("#search_form_ajax").length > 0) {
        $("#search_form_ajax").on("submit", function (e) {
            e.preventDefault();
            var firstInVal = $select1.val();
            var secInVal = $select2.val();
            var thirdInVal = $select3.val();
            var ppsVal = $("#nss_pps_id").val();
            var three_nonce_field = $("#three_nonce_field").val();

            jQuery.ajax({
                url: nssProduct_ajax.ajaxurl,
                type: "GET",
                dataType: "html",
                beforeSend: function () { showLoading() },
                data: {
                    action: "nssProduct_ele_filter_addon",
                    "selectFirstItem": firstInVal,
                    "selectSecondItem": secInVal,
                    "selectThirdItem": thirdInVal,
                    "numberOfPage": ppsVal,
                    "nonceThreeStep": three_nonce_field                   
                },
            })
            .done(function (res) {
                setTimeout(function () {
                    $("#load_ajaxData").html(res);
                }, 500);
            });
        });
    }
    function showLoading() {
        $("#load_ajaxData").html('<div id="loading">loading..</div>');
    }
    //one step 
    var $nss_one_step_select1 = $("#nss_one_step_select1");
    $nss_one_step_select1.on("change", function () {
        var oneSParentVal = $(this).val();
        getOneStepParentData(oneSParentVal);
    }).trigger("change");

    function getOneStepParentData(OneParentVal_id) {
        jQuery.ajax({
            url: nssProduct_ajax.ajaxurl,
            type: "GET",
            dataType: "html",
            data: {
                action: "nssProduct_ele_onestep_filter_addon",
                oneSParentVal: OneParentVal_id
            },
        })
        .done(function (res) {
            //$select2.html(res);
            //console.log(OneParentVal_id);
        });
    }
    //load_ajaxData
    if ($("#search_onestep_form_ajax").length > 0) {
        $("#search_onestep_form_ajax").on("submit", function (e) {
            e.preventDefault();
            var firstInVal = $nss_one_step_select1.val();
            var oPPs = $("#onePps").val();
            var oneNonce = $("#oneNonce").val();
            jQuery.ajax({
                url: nssProduct_ajax.ajaxurl,
                type: "GET",
                dataType: "html",
                beforeSend: function () { showLoading() },
                data: {
                    action: "nssProduct_ele_onestep_filter_addon",
                    "selectedValue": firstInVal,
                    "postPerPageId": oPPs,
                    "nonceOne": oneNonce
                },
            })
            .done(function (res) {
                setTimeout(function () {
                    $("#load_ajaxData").html(res);
                }, 500);
            });
        });
    }
    //two step
    var $nssTwoStepSelt = $("#nss_two_step_select1");
    $nssTwoStepSelt.on("change", function () {
        var twoSParentVal = $(this).val();
        var twoOptionVal = $("#nss_two_cat_name").val();
        getTwoStepParentData(twoSParentVal, twoOptionVal);
    }).trigger("change");

    function getTwoStepParentData(twoParentVal_id,twoOpName_id) 
    {
        jQuery.ajax({
            url: nssProduct_ajax.ajaxurl,
            type: "GET",
            dataType: "html",
            beforeSend: function () { TshowLoading_select() },
            data: {
                action: "nssProduct_ele_twostep_filter_addon",
                twoSParentVal: twoParentVal_id,
                twoOptionVal : twoOpName_id
            },
        })
        .done(function (res) 
        {
            $("#nss_two_step_select2").html(res);
            //console.log(res);
        });
    }
    function TshowLoading_select() {
        $("#nss_two_step_select2").html('<div id="loadings">....</div>');
    }
    //load_ajaxData
    if ($("#search_two_step_form_ajax").length > 0) {
        $("#search_two_step_form_ajax").on('submit', function (e) {
            e.preventDefault();
            var twoStepInVal = $nssTwoStepSelt.val();
            var TwoSInVal = $("#nss_two_step_select2").val();
            var pps = $("#nss_two_pps_id").val();
            var twoNonceStep = $("#two_nonce_field").val();
            jQuery.ajax({
                url: nssProduct_ajax.ajaxurl,
                type: "GET",
                dataType: "html",
                beforeSend: function () { showLoading() },
                data: {
                    action: "nssProduct_ele_twostep_filter_addon",
                    "selectFirstItem": twoStepInVal,
                    "selectSecondItem": TwoSInVal,
                    "pageValue": pps,
                    "nonceStepTwo": twoNonceStep
                },
            })
            .done(function (res) {
                setTimeout(function () {
                    $("#load_ajaxData").html(res);
                }, 500);
            });
        });
    }    
    //specfic id
    //form data
    if ($("#search_specfic_form_ajax").length > 0) 
    {
        $("#search_specfic_form_ajax").on('submit', function (e) 
        {
            e.preventDefault();
            var specfSInVals = $("#nss_specfic_select1").val();
            var pps = $("#postPerPage").val();
            var specfic_nonce_step = $("#specfic_nonce_step").val();
            jQuery.ajax({
                url: nssProduct_ajax.ajaxurl,
                type: "GET",
                dataType: "html",
                beforeSend: function () { showLoading() },
                data: {
                    action: "nssProduct_ele_specfic_filter_addon",
                    "selectFirstVal": specfSInVals,
                    "numberOfItem" : pps,
                    "specficNonceVal" : specfic_nonce_step
                },
            })
            .done(function (res) {
                setTimeout(function () {
                    $("#load_ajaxData").html(res);
                }, 500);
            });
        });
    }

});