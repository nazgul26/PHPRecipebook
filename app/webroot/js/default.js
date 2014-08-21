function initApplication() {
    initAjaxHRef("container");
    initNavigationHRef("container");
    initDialogs();
    setupSearchBox();
    if ($(window).width() >= 1480) {
      ajaxGet("RecipeLinkBox/Index", "recipeLinkBoxContainer");
    } 
    
    window.onpopstate = function (event) {
        if (event.state && event.state.target) {
            ajaxGet(event.state.action, event.state.target);
        } else {
            // Get us Home and refresh
            location.reload();
        }
    };
}

function initAjax(target) {
    initAjaxHRef(target);
    initMoreActionsLink(target);
    initAjaxForms(target);
    initAjaxDeleteLinks(target);
}

function ajaxGet(location, target) {
    target = (target === undefined) ? "content" : target;
    //console.log("getting:" + location + " Target: " +target);
    $("#" + target).html("<div class='loadingImage'>Loading..<br/><div><img src='./img/ajax-loader.gif' alt='loading...'/></div></div>");

    $.get(location, function(data) {
        $("#" + target ).html(data);
        initAjax(target);
    }).fail(function(xhr, status, error) {
        //var err = eval("(" + xhr.responseText + ")");
        $("#" + target ).html(xhr.responseText);
    });
}

function ajaxPostForm($formItem) {
    var targetId = ($formItem.attr('targetId') == undefined) ? 'content' : $formItem.attr('targetId');
    
    $.ajax({
        async:true, 
        data: $formItem.serialize(), 
        dataType:"html", 
        success:function (data, textStatus) {
            $("#" + targetId).html(data);
            initAjax(targetId);
        }, 
        type:"POST", 
        url: $formItem.attr('action')
    }).fail(function(xhr, status, error) {
        //var err = eval("(" + xhr.responseText + ")");
        $("#" + targetId).html(xhr.responseText);
    });;
}

function ajaxNavigate(actionUrl, title, targetId) {
    if (history.pushState) {
        var stateObj = { target: targetId, action: actionUrl };
        history.pushState(stateObj, title, actionUrl);
        ajaxGet(actionUrl, targetId);
    } else {
        location.assign(actionUrl);
    }
    return false;
}

function initNavigationHRef(targetId) {
    var findQuery = (targetId === undefined) ? "#content .ajaxNavigationLink" : "#" + targetId + " .ajaxNavigationLink";
    $(findQuery).each(function(event) {
        var $targetItem = $(this);
        if (!$(this).is('a')) $targetItem = $(this).find("a");
        //console.log('Navigation ' + $targetItem.attr('href') + ", Title = " + $targetItem.text());
        $targetItem.click(function() {
            console.log("Navigation Push " + $(this).attr('href') + ", target: " + $(this).attr('targetId') + ", Title = " + $(this).text());
            var $targetItem = $("#" + $(this).attr('targetId'));
            if (!$targetItem.hasClass('ui-dialog-content')) {
                $("#content #moreActionLinks").qtip('destroy', true);
            }
            ajaxNavigate($(this).attr('href'), $(this).text(), $(this).attr('targetId'));
            return false;
        });
    });
}

function initAjaxHRef(targetId) {
    var findQuery = (targetId === undefined) ? "#content .ajaxLink" : "#" + targetId + " .ajaxLink";
    $(findQuery).each(function(event) {
        var $targetItem = $(this);
        if (!$(this).is('a')) $targetItem = $(this).find("a");
        //console.log('ajaxLink: ' + $targetItem.attr('href'));
        $targetItem.click(function() {
            //console.log("getting " + $(this).attr('href') + ", target: " + $(this).attr('targetId'));
            var $targetItem = $("#" + $(this).attr('targetId'));
            if ($targetItem.hasClass('ui-dialog-content')) {
                $targetItem.dialog('open');
            } else {
                $("#content #moreActionLinks").qtip('destroy', true);
            }
            
            ajaxGet($(this).attr('href'), $(this).attr('targetId'));
            return false;
        });
    });
}

function initAjaxForms(targetId) {
    var findQuery = (targetId === undefined) ? "#content form" : "#" + targetId + " form";
    $(findQuery).each(function(event) {
        $(this).bind("submit", function (event) {
            ajaxPostForm($(this));
            return false;
        });
    });
}

function initAjaxDeleteLinks(targetId) {
    var findQuery = (targetId === undefined) ? "#content .ajaxDeleteLink" : "#" + targetId + " .ajaxDeleteLink";
    $(findQuery).each(function() {
        $(this).click(function() {
            var confirmMessage = $(this).attr('deletemessage');
            if (confirm(confirmMessage)) {
                //console.log("getting " + $(this).attr('href') + ", target: " + $(this).attr('targetId'));
                ajaxGet($(this).attr('href'), $(this).attr('targetId'));
            }
            return false;
        });
    });
}

function initMoreActionsLink(targetId) {
    var findQuery = (targetId === undefined) ? "#content #moreActionLinks" : "#" + targetId + " #moreActionLinks";
    $(findQuery).qtip({
        content: $('#moreActionLinksContent'),
        position: {
            my: 'top center',  // Position my top left...
            at: 'bottom center', // at the bottom right of...
            target: $('#moreActionLinks') // my target
        },
        style: {
            classes: 'qtip-rounder qtip-shadow',
            widget: true, // Use the jQuery UI widget classes
            def: true // Remove the default styling (usually a good idea, see below)  
        },
        show: {
            event: 'click',
            effect: function(offset) {
                $(this).slideDown(400); // "this" refers to the tooltip
            }
        },
        hide: {
            event: 'click',
            effect: function(offset) {
                $(this).slideUp(400); // "this" refers to the tooltip
            }
        }
    }).click(function() { return false; });
}

function initDialogs() {
    var findQuery =".dialog";
    $(findQuery).each(function() {
        $(this).dialog({
		autoOpen: false,
		title: $(this).attr("title"),
		modal: true,
		width: $(this).attr("width"),
                height: $(this).attr("height"),
		buttons: { 
                    "Save": function() { 
                        $(this).find(':submit').click(); 
                    },
                    "Close": function() { $(this).dialog('close'); } 
                }
	});
    });
}

function setupSearchBox() {
    showCancel();
    $("#searchEverythingForm").submit(function() {
        e.preventDefault();
        return false;
    });
    
    $('.cancelBtn').click(function()
    {
        $(".cancelBtn").stop();
        $(".cancelBtn").fadeTo(500 , 0 );
        $('.searchTextBox').val('');
    });

    $('.searchTextBox').change(function()
    {
        showCancel();
    });
    $('.searchTextBox').keydown(function(e)
    {
        if(e.which == 13) {
            console.log('going to Search ' + window.applicationContext + " for " + $(this).val());
            console.log('Address:' + window.applicationContext + '/search/term=' + $(this).val());
            ajaxGet(window.applicationContext + '/search?term=' + $(this).val());
            return false;
        }
        showCancel();
    });
    
    $('.searchTextBox').keyup(function()
    {
        showCancel();
    });
}

function showCancel() {
    var textBxContent = $(".searchTextBox").val();
    if (textBxContent) {
        $(".cancelBtn").fadeTo(500, 1 );
    } else {
        $(".cancelBtn").fadeTo(500, 0 );
    }
}


